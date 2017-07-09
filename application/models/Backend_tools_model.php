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


	public function export_csv($query, $category = 'export', $delimiter = ';', $enclosure = '', $newline = "\r\n")
	{
		if ( ! empty($query))
		{
			$this->load->helper(array('download', 'inflector', 'text'));

			$category = convert_accented_characters($category);
			$category = underscore($category);
			$filename = $category . '-' . date('Ymd_His') . '.csv';
			$query    = $this->db->query($query);
			$backup   = $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);

			force_download($filename, $backup);
		}
	}




	//
	// Maintenance
	//

	public function server_version()
	{
		//$get_software = explode('/', $_SERVER['SERVER_SOFTWARE']);
		$get_software = explode('/', apache_get_version());
		$result       = explode(' ', $get_software[1]);
		$name         = $get_software[0];
		$version      = $result[0];

		return $version;
	}


	public function disk_totalspace($dir = DIRECTORY_SEPARATOR)
	{
		return disk_total_space($dir);
    }


	public function disk_freespace($dir = DIRECTORY_SEPARATOR)
	{
		return disk_free_space($dir);
	}


	public function disk_usespace($dir = DIRECTORY_SEPARATOR)
	{
		return $this->disk_totalspace($dir) - $this->disk_freespace($dir);
	}


	public function disk_freepercent($dir = DIRECTORY_SEPARATOR, $precision = 0, $display_unit = TRUE)
	{
		if ($display_unit === FALSE)
		{
			$unit = NULL;
		}
		else
		{
			$unit = '%';
		}

		return round(($this->disk_freespace($dir) * 100) / $this->disk_totalspace($dir), $precision) . $unit;
    }


	public function disk_usepercent($dir = DIRECTORY_SEPARATOR, $precision = 0, $display_unit = TRUE)
	{
		if ($display_unit === FALSE)
		{
			$unit = NULL;
		}
		else
		{
			$unit = '%';
		}

		return round(($this->disk_usespace($dir) * 100) / $this->disk_totalspace($dir), $precision) . $unit;
	}


	public function memory_peak_usage($real = FALSE)
	{
		if ($real)
		{
			return memory_get_peak_usage(TRUE);
		}
		else
		{
			return memory_get_peak_usage(FALSE);
		}
	}


	public function memory_usage()
	{
		return memory_get_usage();
	}


	public function memory_free($real = FALSE)
	{
		return $this->memory_peak_usage($real) - $this->memory_usage();
	}


	public function memory_usepercent($real = TRUE, $precision = 0, $display_unit = TRUE)
	{
		if ($display_unit === FALSE)
		{
			$unit = NULL;
		}
		else
		{
			$unit = '%';
		}

		return round(($this->memory_usage() * 100) / $this->memory_peak_usage($real), $precision) . $unit;
	}







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
