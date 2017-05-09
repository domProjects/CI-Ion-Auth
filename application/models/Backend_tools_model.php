<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend_tools_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function display_flashdata($item = NULL)
	{
		$str = NULL;

		if ($this->session->flashdata($item)) {
			$value = $this->session->flashdata($item);

			$str .= '<div class="alert alert-' . $value['class'] . ' alert-dismissible fade show" role="alert">';
			$str .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
			$str .= $value['message'];
			$str .= '</div>';
		}
		else
		{
			$str .= NULL;
		}

		return $str;
	}


	public function insert_csv($table, $data)
	{
		if ( ! empty($table) OR ! empty($data))
		{
			$this->db->insert($table, $data);
		}
	}


	public function export_csv($query, $category = 'export', $delimiter = ',', $newline = "\r\n", $enclosure = '"')
	{
		if ( ! empty($query))
		{
			$this->load->helper(array('text', 'inflector'));

			$category  = convert_accented_characters($category);
			$category  = underscore($category);
			$filename  = $category . '-' . date('Ymd_His') . '.csv';
			$query     = $this->db->query($query);
			$backup    = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

			force_download($filename, $backup);
		}
	}




	//
	// Maintenance
	//

	public function control_table()
	{
		$str = NULL;
		$list_tables = $this->db->list_tables();

		if ($list_tables)
		{
			foreach ($list_tables as $tables)
			{
				$str .= '<tr>';
				$str .= '<td>' . $tables . '</td>';

				foreach ($this->check_table($tables) as $check)
				{
					$check_result = ($check['Msg_type'] == 'error') ? 'repair' : $check['Msg_text'];

					$str .= '<td>' . $check['Msg_type'] . '</td>';
					$str .= '<td>' . $check_result . '</td>';
				}

				foreach ($this->analyze_table($tables) as $analyze)
				{
					//$check_result = ($check['Msg_type'] == 'error') ? 'repair' : $check['Msg_text'];

					$str .= '<td>' . $analyze['Msg_type'] . '</td>';
					$str .= '<td>' . $analyze['Msg_text'] . '</td>';
				}

				$str .= '</tr>';
			}

			return $str;
		}
	}


	public function analyze_table($table)
	{
		if ( ! empty($table))
		{
			$data  = array();
			$query = $this->db->query('ANALYZE TABLE ' . $table);

			if ($query)
			{
				$data = $query->result_array();
			}

			return $data;
		}
	}


	public function check_table($table)
	{
		if ( ! empty($table))
		{
			$data  = array();
			$query = $this->db->query('CHECK TABLE ' . $table);

			if ($query)
			{
				$data = $query->result_array();
			}

			return $data;
		}
	}


}
