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
		$this->db->insert($table, $data);
	}
}
