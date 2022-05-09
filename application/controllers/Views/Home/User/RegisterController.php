<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegisterController extends CI_Controller
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
			'page_name' => 'home/user/register',
			'style' => ['/css/user/user.css'],
			'js' => [''],
		];
		$this->load->view('home/index', $data);
	}

	public function register_employee(){
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/register_employee',
			'style' => ['/css/select2.min.css','/css/user/user.css','/css/user/register_employee.css'],
			'js' => ['/scripts/select2.min.js','/scripts/home/user/register_employee.js'],
		];
		$this->load->view('home/index', $data);
	}

	public function register_employee_success(){
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/register_employee_success',
			'style' => ['/css/select2.min.css','/css/user/user.css','/css/user/register_success.css'],
			'js' => [],
		];
		$this->load->view('home/index', $data);
	}

	public function register_company(){
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/register_company',
			'style' => ['/css/select2.min.css','/css/user/user.css','/css/user/register_company.css'],
			'js' => ['/scripts/select2.min.js','/scripts/home/user/register_company.js'],
		];
		$this->load->view('home/index', $data);
	}
	public function register_company_success(){
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/register_company_success',
			'style' => ['/css/select2.min.css','/css/user/user.css','/css/user/register_success.css'],
			'js' => [],
		];
		$this->load->view('home/index', $data);
	}
}
