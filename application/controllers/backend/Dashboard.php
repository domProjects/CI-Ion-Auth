<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend
{
	public function __construct()
	{
		parent::__construct();
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
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['subtitle'] = $this->lang->line('dashboard');
			$this->data['page_content'] = 'backend/dashboard';

			$this->render();
		}
	}
}
