<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['subtitle'] = 'Accueil';
		$this->data['page_content'] = 'home';

		$this->render();
	}
}
