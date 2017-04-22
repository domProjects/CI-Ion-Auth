<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Authenticate
{
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		redirect('auth/login', 'refresh');
	}


	public function login()
	{
		$this->data['subtitle'] = $this->lang->line('login_heading');

		if ( ! $this->ion_auth->logged_in())
		{
			$this->form_validation->set_rules('identity', 'lang:login_identity_label', 'required');
			$this->form_validation->set_rules('password', 'lang:login_password_label', 'required');
			$this->form_validation->set_rules('remember', 'lang:login_remember_label', 'integer');

			if ($this->form_validation->run() == TRUE)
			{
				$remember = (bool) $this->input->post('remember');

				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('auth/choice', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/login', 'refresh');
				}
			}
			else
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['identity'] = array(
					'type'  => 'text',
					'name'  => 'identity',
					'id'    => 'identity',
					'value' => $this->form_validation->set_value('identity')
				);
				$this->data['password'] = array(
					'type' => 'password',
					'name' => 'password',
					'id'   => 'password'
				);
				$this->data['remember'] = array(
					'type'    => 'checkbox',
					'name'    => 'remember',
					'id'      => 'remember',
					'value'   => '1',
					'class'   => 'checkbox',
					'checked' => $this->form_validation->set_checkbox('remember', '1')
				);

				$this->data['page_content'] = 'auth/login';
				$this->render();
			}
		}
		else
		{
			redirect('auth/choice', 'refresh');
		}
	}


	public function logout()
	{
		$logout = $this->ion_auth->logout();

		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('/', 'refresh');
	}


	public function choice()
	{
		if ( ! $this->ion_auth->logged_in())
		{
			redirect('/', 'refresh');
		}
		elseif ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$this->data['subtitle'] = $this->lang->line('login_heading');

			$this->data['page_content'] = 'auth/choice';
			$this->render();
		}
		else
		{
			redirect('/', 'refresh');
		}
	}


	public function forgot_password()
	{
		$this->data['subtitle'] = $this->lang->line('forgot_password_heading');

		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', 'lang:forgot_password_identity_label', 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', 'lang:forgot_password_validation_email_label', 'required|valid_email');
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');

			$this->data['identity'] = array(
				'name' => 'identity',
				'id'   => 'identity'
			);

			if ($this->config->item('identity', 'ion_auth') != 'email' )
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['page_content'] = 'auth/forgot_password';
			$this->render();
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{
				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/forgot_password', 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('auth/login', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/forgot_password', 'refresh');
			}
		}
	}
}
