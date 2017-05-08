<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	protected $data = array();

	public function __construct()
	{
		parent::__construct();

		// Meta charset
		$this->data['charset'] = ( ! empty($this->config->item('charset'))) ? $this->config->item('charset') : 'UTF-8';

		// Ion Auth
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		// If logged request info user
		if ($this->ion_auth->logged_in())
		{
			$this->data['user_info']     = $this->user_info_model->get_info($this->ion_auth->user()->row()->id);
			$this->data['user_fullname'] = $this->data['user_info']['fullname'];
		}

		// Protection
		$this->output->set_header('X-Content-Type-Options: nosniff');
		$this->output->set_header('X-Frame-Options: DENY');
		$this->output->set_header('X-XSS-Protection: 1; mode=block');
	}
}


class Authenticate extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Theme
		$this->data['theme'] = ( ! empty($this->config->item('dp_theme_auth'))) ? $this->config->item('dp_theme_auth') : 'default';
		$this->data['theme_url'] = base_url($this->config->item('dp_theme_auth_url'));

		// Title
		$this->data['title'] = ( ! empty($this->config->item('dp_title'))) ? $this->config->item('dp_title') : 'CI-Ion Auth';
	}

	public function render()
	{
		// Gestion title and subtitle
		if ( ! isset($this->data['subtitle']))
		{
			$this->data['separate'] = NULL;
			$this->data['subtitle'] = NULL;
		}
		else
		{
			$this->data['separate'] = ' | ';
		}

		$this->data['pagetitle'] = $this->data['title'] . $this->data['separate'] . $this->data['subtitle'];

		// Include content
		$this->data['content'] = $this->parser->parse($this->data['page_content'], $this->data, TRUE);

		// Render template
		$this->data['data'] = &$this->data;
		$this->parser->parse('auth/_theme/template', $this->data);
	}
}


class Backend extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			// Load model
			$this->load->model(array('backend_tools_model'));

			// Load langage
			$this->lang->load(array('backend'));

			// Theme
			$this->data['theme']     = ( ! empty($this->config->item('dp_theme_backend'))) ? $this->config->item('dp_theme_backend') : 'default';
			$this->data['theme_url'] = base_url($this->config->item('dp_theme_backend_url'));

			// Title
			$this->data['title'] = $this->lang->line('administration');

			// Common language
			$this->data['lang_dashboard']          = $this->lang->line('dashboard');
			$this->data['lang_security_groups']    = $this->lang->line('security_groups');
			$this->data['lang_users']              = $this->lang->line('users');
			$this->data['lang_maintenance']        = $this->lang->line('maintenance');
			$this->data['lang_list']               = $this->lang->line('list');
			$this->data['lang_actions']            = $this->lang->line('actions');
			$this->data['lang_help']               = $this->lang->line('help');
			$this->data['lang_edit']               = $this->lang->line('edit');
			$this->data['lang_export_list']        = $this->lang->line('export_list');
			$this->data['lang_import_list']        = $this->lang->line('import_list');
			$this->data['lang_add_user']           = $this->lang->line('add_user');
			$this->data['lang_email']              = $this->lang->line('email');
			$this->data['lang_group']              = $this->lang->line('group');
			$this->data['lang_group_name']         = $this->lang->line('group_name');
			$this->data['lang_status']             = $this->lang->line('status');
			$this->data['lang_active']             = $this->lang->line('active');
			$this->data['lang_inactive']           = $this->lang->line('inactive');
			$this->data['lang_see']                = $this->lang->line('see');
			$this->data['lang_file']               = $this->lang->line('file');
			$this->data['lang_first_name']         = $this->lang->line('first_name');
			$this->data['lang_last_name']          = $this->lang->line('last_name');
			$this->data['lang_company_name']       = $this->lang->line('company_name');
			$this->data['lang_phone']              = $this->lang->line('phone');
			$this->data['lang_password']           = $this->lang->line('password');
			$this->data['lang_password_confirm']   = $this->lang->line('password_confirm');
			$this->data['lang_password_if_change'] = $this->lang->line('password_if_change');
			$this->data['lang_cancel']             = $this->lang->line('cancel');
			$this->data['lang_create']             = $this->lang->line('create');
			$this->data['lang_save']               = $this->lang->line('save');
			$this->data['lang_add_group']          = $this->lang->line('add_group');
			$this->data['lang_name']               = $this->lang->line('name');
			$this->data['lang_color']              = $this->lang->line('color');
			$this->data['lang_description']        = $this->lang->line('description');
			$this->data['lang_delete']             = $this->lang->line('delete');
			$this->data['lang_import']             = $this->lang->line('import');
			$this->data['lang_yes']                = $this->lang->line('yes');
			$this->data['lang_no']                 = $this->lang->line('no');
		}
	}

	public function render()
	{
		// Gestion title and subtitle
		if ( ! isset($this->data['subtitle']))
		{
			$this->data['separate'] = NULL;
			$this->data['subtitle'] = NULL;
		}
		else
		{
			$this->data['separate'] = ' | ';
		}

		$this->data['pagetitle'] = $this->data['title'] . $this->data['separate'] . $this->data['subtitle'];

		// Error management
		$this->data['result_flashdata'] = $this->backend_tools_model->display_flashdata('item');

		// Include nav header
		$this->data['nav_header'] = $this->parser->parse('backend/_theme/nav_header', $this->data, TRUE);

		// Include navside
		$this->data['nav_side'] = $this->parser->parse('backend/_theme/nav_side', $this->data, TRUE);

		// Include content
		$this->data['content'] = $this->parser->parse($this->data['page_content'], $this->data, TRUE);

		// Render template
		$this->data['data'] = $this->data;
		$this->parser->parse('backend/_theme/template', $this->data);
	}
}


class Frontend extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Theme
		$this->data['theme'] = ( ! empty($this->config->item('dp_theme_frontend'))) ? $this->config->item('dp_theme_frontend') : 'default';
		$this->data['theme_url'] = base_url($this->config->item('dp_theme_frontend_url'));

		// Title
		$this->data['title'] = ( ! empty($this->config->item('dp_title'))) ? $this->config->item('dp_title') : 'CI-Ion Auth';
	}

	public function render()
	{
		// Gestion TITLE
		if ( ! isset($this->data['subtitle']))
		{
			$this->data['separate'] = NULL;
			$this->data['subtitle'] = NULL;
		}
		else
		{
			$this->data['separate'] = ' | ';
		}

		$this->data['pagetitle'] = $this->data['title'] . $this->data['separate'] . $this->data['subtitle'];

		// Include CONTENT
		$this->data['content'] = $this->parser->parse($this->data['page_content'], $this->data, TRUE);

		// Render Template
		$this->data['data'] = &$this->data;
		$this->parser->parse('frontend/_theme/template', $this->data);
	}
}
