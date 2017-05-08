<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends Backend
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('download');

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
			$filename = 'backup_' . date('Ymd_His') . '.sql';

			$prefs = array(
				'tables'             => array(),
				'ignore'             => array(),
				'format'             => 'txt',
				'filename'           => $filename,
				'add_drop'           => TRUE,
				'add_insert'         => TRUE,
				'newline'            => "\n",
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
			$filename = 'backup_table-' . date('Ymd_His') . '.sql';

$query = $this->db->query("SELECT * FROM dp_auth_groups");

$delimiter = ",";
$newline = "\r\n";
$enclosure = '"';

$backup = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);


			force_download($filename, $backup);
		}
	}


}
