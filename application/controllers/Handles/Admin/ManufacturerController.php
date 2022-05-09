<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ManufacturerController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Manufacturer_model');
		if(!$this->session->userdata('username')){
			redirect('/admin/login');
		}
	}


	public function index()
	{
 
		$lists = $this->Manufacturer_model->get_list();
		$data = [
			'page_name' => 'admin/manufacturer',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		$this->load->view('admin/index', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('manufacturer_name', 'manufacturer Name', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('image', 'Ảnh thương hiệu', 'callback_image_check');
		if ($this->form_validation->run() == FALSE) {
			$data_page = [
				'page_name' => 'admin/add_manufacturer',
				'style' => '',
				'js' => '',
				'lists' => ''
			];
			$this->load->view('admin/index', $data_page);
		} else {
			if (!$this->Manufacturer_model->validate($this->input->post('manufacturer_name'))) {
				$this->session->set_flashdata('insert_status', 'Hãng sản xuất đã tồn tại', 300);
				$data_page = [
					'page_name' => 'admin/add_manufacturer',
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
		$alias=create_slug($this->input->post('manufacturer_name'));
		$data = [
			'name' => $this->input->post('manufacturer_name'),
			'status' => $this->input->post('status'),
			'image' => $_FILES["image"]['name'],
			'alias'=>$alias
		];
		$this->Manufacturer_model->insert($data);
		$path = "upload/manufacturer";
		$full_path = $path . '/' . basename($_FILES["image"]["name"]);
		move_uploaded_file($_FILES['image']['tmp_name'], $full_path);
		$this->session->set_flashdata('insert_status', 'Thêm thành công!', 300);
		$data_page = [
			'page_name' => 'admin/add_manufacturer',
			'style' => '',
			'js' => '',
			'lists' => ''
		];
		$this->load->view('admin/index', $data_page);
	}

	public function image_check()
	{
		if (empty($_FILES['image']['name'])) {
			$this->form_validation->set_message('image_check', '{field} không được để trống!');
			return false;
		} else {
			return true;
		}
	}

	public function edit()
	{
		$this->form_validation->set_rules('manufacturer_name', 'manufacturer Name', 'required|callback_edit_name_check', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$object = $this->Manufacturer_model->get_one($this->input->get('id'));
			$data = [
				'page_name' => 'admin/update_manufacturer',
				'style' => '',
				'js' => '',
				'object' => $object
			];
			$this->load->view('admin/index', $data);
		}
		else{
			$this->action_edit();
		}
	}

	public function action_edit(){
		$data = [
			'name' => $this->input->post('manufacturer_name'),
			'status' => $this->input->post('status')
		];
		if (!empty($_FILES['image']['name'])) {
			$path = "upload/manufacturer";
			$id=$this->input->get('id');
			$manufacturer = $this->Manufacturer_model->get_one($id);
			$full_path = $path . '/' . $manufacturer->image;
			unlink($full_path);

			$data['image'] = $_FILES["image"]['name'];
			$full_path = $path . '/' . basename($_FILES["image"]["name"]);
			move_uploaded_file($_FILES['image']['tmp_name'], $full_path);
		}
		$this->Manufacturer_model->update($this->input->get('id'),$data);
		redirect('/admin/manufacturer');
	}

	public function edit_name_check()
	{
		$manufacturer = $this->Manufacturer_model->get_one($this->input->get('id'));
		if ($this->input->post('name') != $manufacturer->name) {
			if (!$this->Manufacturer_model->validate($this->input->post('name'))) {
				$this->form_validation->set_message('edit_name_check', '{field} đẫ tồn tại!');
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
}
