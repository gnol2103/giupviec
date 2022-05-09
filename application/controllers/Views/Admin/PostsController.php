<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PostsController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Posts_model');
		if(!$this->session->userdata('username')){
			redirect('/admin/login');
		}
	}


	public function index()
	{
 
		$lists = $this->Posts_model->get_list();
		$data = [
			'page_name' => 'admin/posts',
			'style' => '',
			'js' => '/scripts/admin/posts.js',
			'lists' => $lists
		];
		$this->load->view('admin/index', $data);
	}


	public function add(){
		$data = [
			'content' => $this->input->post('content'),
			'title_suggest' => $this->input->post('title_suggest'),
			'content_suggest' => $this->input->post('content_suggest'),
		];
		$this->Posts_model->insert($data);
		$this->session->set_flashdata('insert_status', 'Thêm thành công!', 300);
		redirect('/admin/posts');
	}


	public function edit(){
		$data = [
			'content' => $this->input->post('content'),
			'title_suggest' => $this->input->post('title_suggest'),
			'content_suggest' => $this->input->post('content_suggest'),
		];
		$this->Posts_model->update($this->input->get('id'),$data);
		$this->session->set_flashdata('insert_status', 'Cập nhật thành công!', 300);
		redirect('/admin/posts');
	}
}
