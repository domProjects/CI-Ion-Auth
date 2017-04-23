<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends Backend
{
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->data['groups'] = $this->ion_auth->groups()->result();

			$this->data['count_groups'] = $this->db->count_all($this->config->item('tables', 'ion_auth')['groups']);

			$this->data['subtitle'] = $this->lang->line('security_groups');
			$this->data['page_content'] = 'backend/groups/index';

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
			$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

			if ($this->form_validation->run() == TRUE)
			{
				$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));

				if ($new_group_id)
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());

					redirect('backend/groups', 'refresh');
				}
			}
			else
			{
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

				$this->data['group_name'] = array(
					'type'  => 'text',
					'name'  => 'group_name',
					'id'    => 'group_name',
					'value' => $this->form_validation->set_value('group_name'),
					'class' => 'form-control'
				);
				$this->data['description'] = array(
					'type'  => 'text',
					'name'  => 'description',
					'id'    => 'description',
					'value' => $this->form_validation->set_value('description'),
					'class' => 'form-control'
				);

				$this->data['subtitle'] = $this->lang->line('create_group_title');
				$this->data['page_content'] = 'backend/groups/add';

				$this->render();
			}
		}
	}


	public function edit($id = NULL)
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->form_validation->set_rules('group_name', 'lang:edit_group_validation_name_label', 'required|alpha_dash');

			$group = $this->ion_auth->group($id)->row();

			if (isset($_POST) && ! empty($_POST))
			{
				if ($this->form_validation->run() == TRUE)
				{
					$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

					if ($group_update)
					{
						$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
					}

					redirect('backend/groups', 'refresh');
				}
			}

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			//$this->data['group']   = $group;

			$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
		
			$this->data['group_name'] = array(
				'type'    => 'text',
				'name'    => 'group_name',
				'id'      => 'group_name',
				'value'   => $this->form_validation->set_value('group_name', $group->name),
				'class'   => 'form-control',
				$readonly => $readonly
			);
			$this->data['group_description'] = array(
				'type'  => 'text',
				'name'  => 'group_description',
				'id'    => 'group_description',
				'value' => $this->form_validation->set_value('group_description', $group->description),
				'class' => 'form-control'
			);

			$this->data['subtitle'] = 'Group edit';
			$this->data['page_content'] = 'backend/groups/edit';

			$this->render();
		}
	}
}