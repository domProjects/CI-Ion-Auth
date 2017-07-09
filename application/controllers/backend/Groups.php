<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends Backend
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
			$this->data['groups'] = $this->ion_auth->groups()->result();
			// IN TEST
			//$this->data['color'] = $this->db->select('id_groups, color')->get('dp_auth_groups_color');
			//$this->data['color'] = $this->db->get('dp_auth_groups_color');

			$this->data['count_groups']   = $this->db->count_all($this->config->item('tables', 'ion_auth')['groups']);
			$this->data['subtitle']       = $this->lang->line('security_groups');
			$this->data['page_content']   = 'backend/groups/index';

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
			$this->form_validation->set_rules('group_name', 'lang:group_name', 'required|alpha_dash');

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

				$this->data['message']      = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				$this->data['subtitle']     = $this->lang->line('create_group_title');
				$this->data['page_content'] = 'backend/groups/add';

				$this->render();
			}
		}
	}


	public function edit($id)
	{
		if ( ! $this->ion_auth->logged_in() || ( ! $this->ion_auth->is_admin() && ! ($this->ion_auth->group()->row()->id == $id)))
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->form_validation->set_rules('group_name', 'lang:group_name', 'required|alpha_dash');

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

			$this->data['message']      = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['subtitle']     = 'Group edit';
			$this->data['page_content'] = 'backend/groups/edit';

			$this->render();
		}
	}


	public function import()
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->data['message']      = NULL;
			$this->data['subtitle']     = 'Import';
			$this->data['page_content'] = 'backend/groups/import';

			$this->render();
		}
	}


	public function import_process()
	{
		if ( ! $this->ion_auth->logged_in() && ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			$this->load->library('import_csv');

			$config['upload_path']   = './uploads/';
			$config['allowed_types'] = 'csv|txt';
			$config['max_size']      = '1000';
 
			$this->load->library('upload', $config);
 
 			if ($this->upload->do_upload('file'))
 			{
				$file_data = $this->upload->data();

				$file_path           = './uploads/'.$file_data['file_name'];
				$column_headers      = array('name', 'description');
				$detect_line_endings = TRUE;
				$initial_line        = 0;
				$delimiter           = ';';
 
				if ($this->import_csv->get_array($file_path))
				{
					$csv_array = $this->import_csv->get_array($file_path, $column_headers, $detect_line_endings, $initial_line, $delimiter);

					foreach ($csv_array as $row)
					{
						$insert_data = array(
							'name'        => $row['name'],
							'description' => $row['description']
						);

						$this->backend_tools_model->insert_csv('dp_auth_groups', $insert_data);
					}

					unlink($file_path);

					$this->session->set_flashdata('item', array('message' => 'Csv Data Imported Succesfully', 'class' => 'success'));

					redirect('backend/groups', 'refresh');
				}
				else
				{
					$this->data['message'] = "Error occured";
				}
 			}
			else
			{
				$this->data['message'] = $this->upload->display_errors();
			}

			$this->data['subtitle']     = 'Import';
			$this->data['page_content'] = 'backend/groups/import';

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

			$query    = 'SELECT name, description FROM dp_auth_groups';
			$category = 'security_groups';

			$this->backend_tools_model->export_csv($query, $category);
		}
	}
}