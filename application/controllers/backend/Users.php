<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Backend
{
	public function __construct()
	{
		parent::__construct();

		$this->form_validation->set_error_delimiters($this->config->item('error_prefix'), $this->config->item('error_suffix'));
	}


	public function index()
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->data['users'] = $this->ion_auth->users()->result();

			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->data['count_users']  = $this->db->count_all($this->config->item('tables', 'ion_auth')['users']);
			$this->data['subtitle']     = $this->lang->line('users');
			$this->data['page_content'] = 'backend/users/index';

			$this->render();
		}
	}


	public function add()
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$table_ion_auth  = $this->config->item('tables', 'ion_auth');
			$identity_column = $this->config->item('identity', 'ion_auth');

			$this->data['identity_column'] = $identity_column;

			$this->form_validation->set_rules('first_name', 'lang:first_name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'lang:last_name', 'trim|required');

			if ($identity_column !== 'email')
			{
				$this->form_validation->set_rules('identity', 'lang:create_user_validation_identity_label', 'required|is_unique[' . $table_ion_auth['users'] . '.' . $identity_column.']');
				$this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
			}
			else
			{
				$this->form_validation->set_rules('email', 'lang:email', 'required|valid_email|is_unique[' . $table_ion_auth['users'] . '.email]');
			}

			$this->form_validation->set_rules('phone', 'lang:phone', 'trim');
			$this->form_validation->set_rules('company', 'lang:company', 'trim');
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'lang:password_confirm', 'required');

			if ($this->form_validation->run() === TRUE)
			{
				$email    = strtolower($this->input->post('email'));
				$identity = ($identity_column == 'email') ? $email : strtolower($this->input->post('identity'));
				$password = $this->input->post('password');

				$additional_data = array(
					'first_name' => ucwords($this->input->post('first_name'), '-'),
					'last_name'  => mb_strtoupper($this->input->post('last_name'), 'UTF-8'),
					'company'    => mb_strtoupper($this->input->post('company'), 'UTF-8'),
					'phone'      => $this->input->post('phone')
				);
			}

			if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data))
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());

				redirect('backend/users', 'refresh');
			}
			else
			{
				$this->data['first_name'] = array(
					'type'  => 'text',
					'name'  => 'first_name',
					'id'    => 'first_name',
					'value' => $this->form_validation->set_value('first_name'),
					'class' => 'form-control'
				);
				$this->data['last_name'] = array(
					'type'  => 'text',
					'name'  => 'last_name',
					'id'    => 'last_name',
					'value' => $this->form_validation->set_value('last_name'),
					'class' => 'form-control'
				);
				$this->data['identity'] = array(
					'type'  => 'text',
					'name'  => 'identity',
					'id'    => 'identity',
					'value' => $this->form_validation->set_value('identity'),
					'class' => 'form-control'
				);
				$this->data['email'] = array(
					'type'  => 'email',
					'name'  => 'email',
					'id'    => 'email',
					'value' => $this->form_validation->set_value('email'),
					'class' => 'form-control'
				);
				$this->data['company'] = array(
					'type'  => 'text',
					'name'  => 'company',
					'id'    => 'company',
					'value' => $this->form_validation->set_value('company'),
					'class' => 'form-control'
				);
				$this->data['phone'] = array(
					'type'  => 'tel',
					'name'  => 'phone',
					'id'    => 'phone',
					'value' => $this->form_validation->set_value('phone'),
					'class' => 'form-control'
				);
				$this->data['password'] = array(
					'type'  => 'password',
					'name'  => 'password',
					'id'    => 'password',
					'value' => $this->form_validation->set_value('password'),
					'class' => 'form-control'
				);
				$this->data['password_confirm'] = array(
					'type'  => 'password',
					'name'  => 'password_confirm',
					'id'    => 'password_confirm',
					'value' => $this->form_validation->set_value('password_confirm'),
					'class' => 'form-control'
				);

				$this->data['message']      = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				$this->data['subtitle']     = $this->lang->line('create_user_heading');
				$this->data['page_content'] = 'backend/users/add';

				$this->render();
			}
		}
	}


	public function activate($id = NULL, $code = FALSE)
	{
		$id = (int) $id;

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('backend/users', 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/forgot_password', 'refresh');
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int) $id;

		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();

			$user = $this->ion_auth->user($id)->row();

			$this->data['lang_deactivate_user_confirm'] = $this->lang->line('deactivate_user_confirm');
			$this->data['id']           = $user->id;
			$this->data['username']     = $user->username;
			$this->data['subtitle']     = 'Deactivate user';
			$this->data['page_content'] = 'backend/users/deactivate';

			$this->render();
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('backend/users', 'refresh');
		}
	}


	public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() || ( ! $this->ion_auth->is_admin() && ! ($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$user          = $this->ion_auth->user($id)->row();
			$groups        = $this->ion_auth->groups()->result_array();
			$currentGroups = $this->ion_auth->get_users_groups($id)->result();

			// validate form input
			$this->form_validation->set_rules('first_name', 'lang:edit_user_validation_fname_label', 'trim|required');
			$this->form_validation->set_rules('last_name', 'lang:dit_user_validation_lname_label', 'trim|required');
			$this->form_validation->set_rules('email', 'lang:email', 'required|valid_email');
			$this->form_validation->set_rules('phone', 'lang:edit_user_validation_phone_label');
			$this->form_validation->set_rules('company', 'lang:edit_user_validation_company_label', 'trim');

			if (isset($_POST) && ! empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$this->form_validation->set_rules('password', 'lang:edit_user_validation_password_label', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
					$this->form_validation->set_rules('password_confirm', 'lang:edit_user_validation_password_confirm_label', 'required');
				}

				if ($this->form_validation->run() === TRUE)
				{
					$data = array(
						'first_name' => ucwords($this->input->post('first_name'), '-'),
						'last_name'  => mb_strtoupper($this->input->post('last_name'), 'UTF-8'),
						'company'    => mb_strtoupper($this->input->post('company'), 'UTF-8'),
						'email'      => $this->input->post('email'),
						'phone'      => $this->input->post('phone')
					);

					// update the password if it was posted
					if ($this->input->post('password'))
					{
						$data['password'] = $this->input->post('password');
					}

					// Only allow updating groups if user is admin
					if ($this->ion_auth->is_admin())
					{
						//Update the groups user belongs to
						$groupData = $this->input->post('groups');

						if (isset($groupData) && !empty($groupData))
						{
							$this->ion_auth->remove_from_group('', $id);

							foreach ($groupData as $grp)
							{
								$this->ion_auth->add_to_group($grp, $id);
							}
						}
					}

					// check to see if we are updating the user
					if ($this->ion_auth->update($user->id, $data))
					{
						// redirect them back to the admin page if admin, or to the base url if non admin
						$this->session->set_flashdata('message', $this->ion_auth->messages());

						if ($this->ion_auth->is_admin())
						{
							redirect('backend/users', 'refresh');
						}
						else
						{
							redirect('/', 'refresh');
						}
					}
					else
					{
						// redirect them back to the admin page if admin, or to the base url if non admin
						$this->session->set_flashdata('message', $this->ion_auth->errors());

						if ($this->ion_auth->is_admin())
						{
							redirect('backend/users', 'refresh');
						}
						else
						{
							redirect('/', 'refresh');
						}
					}
				}
			}

			$this->data['first_name'] = array(
				'type'  => 'text',
				'name'  => 'first_name',
				'id'    => 'first_name',
				'value' => $this->form_validation->set_value('first_name', $user->first_name),
				'class' => 'form-control'
			);
			$this->data['last_name'] = array(
				'type'  => 'text',
				'name'  => 'last_name',
				'id'    => 'last_name',
				'value' => $this->form_validation->set_value('last_name', $user->last_name),
				'class' => 'form-control'
			);
			$this->data['company'] = array(
				'type'  => 'text',
				'name'  => 'company',
				'id'    => 'company',
				'value' => $this->form_validation->set_value('company', $user->company),
				'class' => 'form-control'
			);
			$this->data['email'] = array(
				'type'  => 'email',
				'name'  => 'email',
				'id'    => 'email',
				'value' => $this->form_validation->set_value('email', $user->email),
				'class' => 'form-control'
				);
			$this->data['phone'] = array(
				'type'  => 'tel',
				'name'  => 'phone',
				'id'    => 'phone',
				'value' => $this->form_validation->set_value('phone', $user->phone),
				'class' => 'form-control'
			);
			$this->data['password'] = array(
				'type'  => 'password',
				'name'  => 'password',
				'id'    => 'password',
				'class' => 'form-control form-control-warning'
			);
			$this->data['password_confirm'] = array(
				'type'  => 'password',
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'class' => 'form-control form-control-warning'
			);

			$this->data['csrf']          = $this->_get_csrf_nonce();
			$this->data['user_id']       = $user->id;
			$this->data['groups']        = $groups;
			$this->data['currentGroups'] = $currentGroups;
			$this->data['message']       = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['subtitle']      = $this->lang->line('edit_user_heading');
			$this->data['page_content']  = 'backend/users/edit';

			$this->render();
		}
	}


	public function export()
	{
		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login/backend', 'refresh');
		}
		elseif ( ! $this->ion_auth->is_admin())
		{
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			$this->load->dbutil();

			$query    = 'SELECT username, email, first_name, last_name, company, phone FROM dp_auth_users';
			$category = 'users';

			$this->backend_tools_model->export_csv($query, $category);
		}
	}


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');

		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);

		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}


	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));

		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
