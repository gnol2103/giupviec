<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VerifyController extends CI_Controller
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
			'page_name' => 'home/user/verify',
			'style' => ['/css/user/user.css','/css/user/verify_account.css'],
			'js' => [''],
		];
		$this->load->view('home/index', $data);
	}
}
