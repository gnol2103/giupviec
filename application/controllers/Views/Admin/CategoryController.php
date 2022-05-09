<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Category_model');
		if(!$this->session->userdata('username')){
			redirect('/admin/login');
		}
	}


	public function index()
	{
		$data = [
			'page_name' => 'admin/category',
		];
		$lists = $this->Category_model->get_list();
		$data = [
			'page_name' => 'admin/category',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		$this->load->view('admin/index', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('category_name', 'Category Name', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$data_page = [
				'page_name' => 'admin/add_category',
				'style' => '',
				'js' => '',
				'lists' => ''
			];
			$this->load->view('admin/index', $data_page);
		} else {
			if (!$this->Category_model->validate($this->input->post('category_name'))) {
				$this->session->set_flashdata('insert_status', 'Danh mục đã tồn tại!', 300);
				$data_page = [
					'page_name' => 'admin/add_category',
					'style' => '',
					'js' => '',
					'lists' => ''
				];
				$this->load->view('admin/index', $data_page);
			} else {
				$this->action_add();
			}
		}
	}

	public function action_add(){
		$alias=create_slug($this->input->post('category_name'));
		$data = [
			'name' => $this->input->post('category_name'),
			'alias'=> $alias,
			'status' => $this->input->post('status')
		];
		echo $alias;
		$this->Category_model->insert($data);
		$this->session->set_flashdata('insert_status', 'Thêm thành công', 300);
		$data_page = [
			'page_name' => 'admin/add_category',
			'style' => '',
			'js' => '',
			'lists' => ''
		];
		$this->load->view('admin/index', $data_page);
	}

	public function edit()
	{
		$this->form_validation->set_rules('category_name', 'Category Name', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$object = $this->Category_model->get_one($this->input->get('id'));
			$data = [
				'page_name' => 'admin/update_category',
				'style' => '',
				'js' => '',
				'object' => $object
			];
			$this->load->view('admin/index', $data);
		}
		else{
			$object = $this->Category_model->get_one($this->input->get('id'));
			if (!$this->Category_model->validate($this->input->post('category_name')) && $object->name!=$this->input->post('category_name')) {
				$this->session->set_flashdata('insert_status', 'Danh mục đã tồn tại!', 300);
				$data = [
					'page_name' => 'admin/update_category',
					'style' => '',
					'js' => '',
					'object' => $object
				];
				$this->load->view('admin/index', $data);
			} else {
				$this->action_edit();
			}
		}
	}

	public function action_edit(){
		$data = [
			'name' => $this->input->post('category_name'),
			'status' => $this->input->post('status')
		];
		$this->Category_model->update($this->input->get('id'),$data);
		redirect('/admin/category');
	}
}
