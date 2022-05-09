<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrderController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Order_model');
		if(!$this->session->userdata('username')){
			redirect('/admin/login');
		}
	}


	public function index()
	{
		$lists = $this->Order_model->get_list();
		$data = [
			'page_name' => 'admin/order',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		$this->load->view('admin/index', $data);
	}

	public function order_detail()
	{
		$id=$this->input->get('id');
		$lists = $this->Order_model->get_order_detail($id);
		$data = [
			'page_name' => 'admin/order_detail',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		$this->load->view('admin/index', $data);
	}

	public function action_status(){
		$id=$this->input->post('id');
		$order=$this->Order_model->get_one($id);
		if($order->status==0){
			$data=[
				'status'=>1
			];
		}
		else{
			$data=[
				'status'=>0
			];
		}
		$this->Order_model->update($id,$data);
	}
}
