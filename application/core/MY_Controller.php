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
			$this->data['user_info'] = $this->user_info_model->get_info($this->ion_auth->user()->row()->id);
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
			// Load langage
			$this->lang->load(array('backend'));

			// Load helper
			//$this->load->helper(array('activelink'));
			
			// Theme
			$this->data['theme'] = ( ! empty($this->config->item('dp_theme_backend'))) ? $this->config->item('dp_theme_backend') : 'default';
			$this->data['theme_url'] = base_url($this->config->item('dp_theme_backend_url'));

			// Title
			$this->data['title'] = $this->lang->line('administration');
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
