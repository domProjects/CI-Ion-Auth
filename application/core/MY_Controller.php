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
	}
}


class Backend extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
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
