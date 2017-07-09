<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends Backend
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('number');

		$this->load->dbutil();
	}


	public function index()
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
			$this->data['db_platform']    = $this->db->platform();
			$this->data['db_version']     = $this->db->version();

			$this->data['apache_version'] = $this->backend_tools_model->server_version();

			$this->data['php_version']    = phpversion();
			$this->data['zend_version']   = zend_version();
			$this->data['disk_freespace'] = byte_format($this->backend_tools_model->disk_freespace());
			$this->data['memory_free']    = byte_format($this->backend_tools_model->memory_free());

			$this->data['control_table'] = $this->backend_tools_model->control_table();

			$this->data['subtitle']     = $this->lang->line('maintenance');
			$this->data['page_content'] = 'backend/maintenance/index';

			$this->render();
		}
	}


	public function backup()
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
			$this->load->helper('download');

			$filename = 'backup_' . date('Ymd_His') . '.zip';

			$prefs = array(
				'tables'             => array(),
				'ignore'             => array(),
				'format'             => 'zip',
				'filename'           => $filename,
				'add_drop'           => TRUE,
				'add_insert'         => TRUE,
				'newline'            => "\r\n",
				'foreign_key_checks' => TRUE
			);

			$backup = $this->dbutil->backup($prefs);

			force_download($filename, $backup);
		}
	}


	public function backup_table()
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
			$query    = 'SELECT * FROM dp_auth_groups';
			$category = 'security_groups';

			$this->backend_tools_model->export_csv($query, $category);
		}
	}


}
