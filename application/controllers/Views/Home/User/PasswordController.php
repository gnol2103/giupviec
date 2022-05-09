<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PasswordController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('function');
	}
	public function forgot_password()
	{
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/forgot_password',
			'style' => ['/css/user/user.css','/css/user/forgot_password.css'],
			'js' => ['/scripts/home/user/forgot_password.js'],
		];
		$this->load->view('home/index', $data);
	}
	public function forgot_password_send()
	{
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/forgot_password_send',
			'style' => ['/css/user/user.css','/css/user/forgot_password_send.css'],
			'js' => ['/scripts/home/user/forgot_password.js'],
		];
		$this->load->view('home/index', $data);
	}
	public function reset_password()
	{
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/reset_password',
			'style' => ['/css/user/user.css','/css/user/reset_password.css'],
			'js' => ['/scripts/home/user/reset_password.js'],
		];
		$this->load->view('home/index', $data);
	}

	public function reset_password_success()
	{
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/reset_password_success',
			'style' => ['/css/user/user.css','/css/user/reset_password_success.css'],
			'js' => [],
		];
		$this->load->view('home/index', $data);
	}
	public function error()
	{
		$data = [
			'header'=>'header',
			'footer'=>'footer',
			'page_name' => 'home/user/error',
			'style' => ['/css/user/user.css','/css/user/error.css'],
			'js' => [],
		];
		$this->load->view('home/index', $data);
	}
}
