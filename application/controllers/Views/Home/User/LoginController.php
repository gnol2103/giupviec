<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
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
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/login',
			'style' => ['/css/user/user.css'],
			'js' => [''],
		];
		$this->load->view('home/index', $data);
	}

	public function login_employee(){
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/login_employee',
			'style' => ['/css/user/user.css','/css/user/login_employee.css'],
			'js' => [''],
		];
		$this->load->view('home/index', $data);
	}

	public function login_company(){
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/login_company',
			'style' => ['/css/user/user.css','/css/user/login_company.css'],
			'js' => [''],
		];
		$this->load->view('home/index', $data);
	}
}
