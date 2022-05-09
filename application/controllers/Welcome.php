<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('function');
	}
	public function index()
	{
		$data = [
			'header'=>'before_login/header',
			'footer'=>'before_login/footer',
			'page_name' => 'home/home_page',
			'style' => [''],
			'js' => [''],
		];
		$this->load->view('home/index', $data);
	}
}
