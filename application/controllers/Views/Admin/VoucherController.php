<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Voucher_model');
		if(!$this->session->userdata('username')){
			redirect('/admin/login');
		}
	}


	public function index()
	{
		$lists = $this->Voucher_model->get_list();
		$data = [
			'page_name' => 'admin/voucher',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		$this->load->view('admin/index', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('code', 'Mã giảm giá', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('discount', 'Giá trị giảm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('start', 'Thời gian bắt đầu', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('end', 'Thời gian kết thúc', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$data_page = [
				'page_name' => 'admin/add_voucher',
				'style' => '',
				'js' => '',
				'lists' => ''
			];
			$this->load->view('admin/index', $data_page);
		} else {
			if (!$this->Voucher_model->validate($this->input->post('code'))) {
				$this->session->set_flashdata('insert_status', 'Mã giảm giá đã tồn tại!', 300);
				$data_page = [
					'page_name' => 'admin/add_voucher',
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
		$data = [
			'code' => $this->input->post('code'),
			'discount' => $this->input->post('discount'),
			'max_discount' => $this->input->post('max_discount'),
			'start' => $this->input->post('start'),
			'end' => $this->input->post('end'),
			'type' => $this->input->post('type'),
			'status' => $this->input->post('status')
		];
		$this->Voucher_model->insert($data);
		$this->session->set_flashdata('insert_status', 'Thêm thành công', 300);
		$data_page = [
			'page_name' => 'admin/add_voucher',
			'style' => '',
			'js' => '',
			'lists' => ''
		];
		$this->load->view('admin/index', $data_page);
	}

	public function edit()
	{
		$this->form_validation->set_rules('code', 'Mã giảm giá', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('discount', 'Giá trị giảm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('start', 'Ngày bắt đầu', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('end', 'Ngày kết thúc', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$object = $this->Voucher_model->get_one($this->input->get('id'));
			$data = [
				'page_name' => 'admin/update_voucher',
				'style' => '',
				'js' => '',
				'object' => $object
			];
			$this->load->view('admin/index', $data);
		}
		else{
			$object = $this->Voucher_model->get_one($this->input->get('id'));
			if (!$this->Voucher_model->validate($this->input->post('code')) && $object->code!==$this->input->post('code')) {
				$this->session->set_flashdata('insert_status', 'Mã giảm giá đã tồn tại!', 300);
			$data = [
				'page_name' => 'admin/update_voucher',
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
			'code' => $this->input->post('code'),
			'discount' => $this->input->post('discount'),
			'max_discount' => $this->input->post('max_discount'),
			'start' => $this->input->post('start'),
			'end' => $this->input->post('end'),
			'type' => $this->input->post('type'),
			'status' => $this->input->post('status')
		];
		$this->Voucher_model->update($this->input->get('id'),$data);
		redirect('/admin/voucher');
	}
}
