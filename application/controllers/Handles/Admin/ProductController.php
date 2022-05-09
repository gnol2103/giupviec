<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Product_model');
		$this->load->model('Admin/Manufacturer_model');
		$this->load->model('Admin/Category_model');
		if (!$this->session->userdata('username')) {
			redirect('/admin/login');
		}
	}


	public function index()
	{
		$select = 'name,id';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$list_category = $this->Product_model->select_data($select, 'category', $join, $condition, $order_by, $start, $perpage);
		$list_manufacturer = $this->Product_model->select_data($select, 'manufacturer', $join, $condition, $order_by, $start, $perpage);
		$lists = $this->Product_model->get_list();
		$data = [
			'page_name' => 'admin/product',
			'style' => '',
			'js' => '',
			'lists' => $lists,
			'list_category' => $list_category,
			'list_manufacturer' => $list_manufacturer
		];
		$this->load->view('admin/index', $data);
	}

	public function view_add()
	{
		$list_category = $this->Category_model->get_list_display();
		$list_manufacturer = $this->Manufacturer_model->get_list_display();
		$this->form_validation->set_rules('name', 'Tên sản phẩm', 'required|callback_name_check', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('price', 'Giá', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('quantity', 'Số lượng', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('manufacturer', 'Hãng sản xuất', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('category', 'Loại sản phẩm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('code_product', 'Mã sản phẩm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('user_size', 'Số lượng người dùng', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('model', 'Model', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('screen', 'Màn hình', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('memory', 'Bộ nhớ', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('connector', 'Cổng kết nối', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('capacity', 'Công suất', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('verification_time', 'Thời gian xác minh', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('battery', 'Pin', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('parameter', 'Thông số', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('review_product', 'Đánh giá sản phẩm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('origin', 'Xuất xứ', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('warranty', 'Thời gian bảo hành', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('feature', 'Tính năng', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('ava_image', 'Ảnh sản phẩm', 'callback_image_check');
		$this->form_validation->set_rules('des_image', 'Ảnh mô tả', 'callback_des_image_check');
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'list_category' => $list_category,
				'list_manufacturer' => $list_manufacturer,
				'page_name' => 'admin/add_product',
				'style' => '',
				'js' => '/scripts/admin/add_product.js',
				'lists' => ''
			];
			$this->load->view('admin/index', $data);
		} else {
			$this->action_add();
		}
	}

	public function name_check()
	{
		if (!$this->Product_model->validate($this->input->post('name'))) {
			$this->form_validation->set_message('name_check', '{field} đã tồn tại!');
			return false;
		} else {
			return true;
		}
	}

	public function image_check()
	{
		if (empty($_FILES['ava_image']['name'])) {
			$this->form_validation->set_message('image_check', '{field} không được để trống!');
			return false;
		} else {
			if ($this->is_image($_FILES['ava_image']["type"])) {
				return true;
			} else {
				$this->form_validation->set_message('image_check', '{field} không đúng định dạng!');
				return false;
			}
		}
	}

	public function is_image($file_type)
	{
		$image_type = ["image/gif", "image/png", "image/jpg"];
			if (!in_array($file_type, $image_type)) {
				$this->form_validation->set_message('image_check', '{field} không đúng định dạng!');
				return false;
			}else{
		return true;
			}
	}

	public function des_image_check()
	{
		if (empty($_FILES['des_image']['name'][0])) {
			$this->form_validation->set_message('des_image_check', '{field} không được để trống!');
			return false;
		} else {
			foreach($_FILES["des_image"]['type'] as $des_image_type){
			if (!$this->is_image($des_image_type)) {
				$this->form_validation->set_message('des_image_check', '{field} không đúng định dạng!');
				return false;
			}
		}
		return true;
		}
	}

	public function action_add()
	{
		$des_name = "";
		foreach ($_FILES["des_image"]['name'] as $name) {
			if ($des_name == '') {
				$des_name = $name;
			} else {
				$des_name = $des_name . ',' . $name;
			}
		}
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$alias = create_slug($this->input->post('name'));
		$data_product = [
			'name' => $this->input->post('name'),
			'alias' => $alias,
			'image' => $_FILES["ava_image"]['name'],
			'price' => $this->input->post('price'),
			'discount' => $this->input->post('discount'),
			'quantity' => $this->input->post('quantity'),
			'manufacturer_id' => $this->input->post('manufacturer'),
			'category' => $this->input->post('category'),
			'code_product' => $this->input->post('code_product'),
			'des_image' => $des_name,
			'parameter' => $this->input->post('parameter'),
			'review_product' => $this->input->post('review_product'),
			'user_size' => $this->input->post('user_size'),
			'model' => $this->input->post('model'),
			'screen' => $this->input->post('screen'),
			'memory' => $this->input->post('memory'),
			'connector' => $this->input->post('connector'),
			'capacity' => $this->input->post('capacity'),
			'verification_time' => $this->input->post('verification_time'),
			'battery' => $this->input->post('battery'),
			'feature' => $this->input->post('feature'),
			'origin' => $this->input->post('origin'),
			'warranty' => $this->input->post('warranty'),
			'gift' => $this->input->post('gift'),
			'create_date' => date("Y-m-d H:i:s"),
			'update_date' => date("Y-m-d H:i:s"),
			'status' => 1,
		];

		$last_id = $this->Product_model->insert($data_product);
		$path = "upload/products/product_" . $last_id;
		$full_path = $path . '/' . basename($_FILES["ava_image"]["name"]);
		mkdir($path, 0777);
		move_uploaded_file($_FILES['ava_image']['tmp_name'], $full_path);
		foreach ($_FILES["des_image"]["name"] as $v) {
			$des_full_path[] = $path . '/' . basename($v);
			// move_uploaded_file($_FILES["des_image"]['tmp_name'], $full_path);
		}
		for ($i = 0; $i < count($des_full_path); $i++) {
			move_uploaded_file($_FILES["des_image"]['tmp_name'][$i], $des_full_path[$i]);
		}
		$this->session->set_flashdata('insert_status', 'Thêm thành công', 300);
		$data = [
			'page_name' => 'admin/add_product',
			'style' => '',
			'js' => '',
			'lists' => ''
		];
		$this->load->view('admin/index', $data);
	}

	public function edit()
	{
		$product = $this->Product_model->get_one($this->input->get('id'));
		$select = 'name,id';
		$condition = '';
		$order_by = '';
		$join = [];
		$start = '';
		$perpage = '';
		$list_category = $this->Category_model->get_list_display();
		$list_manufacturer = $this->Manufacturer_model->get_list_display();
		$this->form_validation->set_rules('name', 'Tên sản phẩm', 'required|callback_edit_name_check', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('price', 'Giá', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('quantity', 'Số lượng', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('manufacturer', 'Hãng sản xuất', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('category', 'Loại sản phẩm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('code_product', 'Mã sản phẩm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('user_size', 'Số lượng người dùng', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('model', 'Model', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('screen', 'Màn hình', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('memory', 'Bộ nhớ', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('connector', 'Cổng kết nối', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('capacity', 'Công suất', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('verification_time', 'Thời gian xác minh', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('battery', 'Pin', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('parameter', 'Thông số', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('review_product', 'Đánh giá sản phẩm', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('feature', 'Tính năng', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('origin', 'Xuất xứ', 'required', array('required' => '%s không được để trống'));
		$this->form_validation->set_rules('warranty', 'Thời gian bảo hành', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'list_category' => $list_category,
				'list_manufacturer' => $list_manufacturer,
				'product' => $product,
				'page_name' => 'admin/update_product',
				'style' => '',
				'js' => '/scripts/admin/add_product.js',
				'lists' => ''
			];
			$this->load->view('admin/index', $data);
		} else {
			$this->action_edit();
		}
	}

	public function edit_name_check()
	{
		$product = $this->Product_model->get_one($this->input->get('id'));
		if ($this->input->post('name') != $product->name) {
			if (!$this->Product_model->validate($this->input->post('name'))) {
				$this->form_validation->set_message('edit_name_check', '{field} đẫ tồn tại!');
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function action_edit()
	{
		$des_name = "";
		foreach ($_FILES["des_image"]['name'] as $name) {
			if ($des_name == '') {
				$des_name = $name;
			} else {
				$des_name = $des_name . ',' . $name;
			}
		}
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$data_product = [
			'name' => $this->input->post('name'),
			'price' => $this->input->post('price'),
			'discount' => $this->input->post('discount'),
			'quantity' => $this->input->post('quantity'),
			'manufacturer_id' => $this->input->post('manufacturer'),
			'category' => $this->input->post('category'),
			'code_product' => $this->input->post('code_product'),
			'parameter' => $this->input->post('parameter'),
			'review_product' => $this->input->post('review_product'),
			'user_size' => $this->input->post('user_size'),
			'model' => $this->input->post('model'),
			'screen' => $this->input->post('screen'),
			'memory' => $this->input->post('memory'),
			'connector' => $this->input->post('connector'),
			'capacity' => $this->input->post('capacity'),
			'verification_time' => $this->input->post('verification_time'),
			'battery' => $this->input->post('battery'),
			'feature' => $this->input->post('feature'),
			'origin' => $this->input->post('origin'),
			'warranty' => $this->input->post('warranty'),
			'gift' => $this->input->post('gift'),
			'update_date' => date("Y-m-d h:i:s"),
			'status' => 1,
		];

		$id = $this->input->get('id');
		$path = "upload/products/product_" . $id;
		if (!empty($_FILES['ava_image']['name'])) {
			$this->delete_img;
			$data_product['image'] = $_FILES["ava_image"]['name'];
			$full_path = $path . '/' . basename($_FILES["ava_image"]["name"]);
			move_uploaded_file($_FILES['ava_image']['tmp_name'], $full_path);
		}

		if (!empty($_FILES['des_image']['name'][0])) {
			$this->delete_des_img($id);
			$data_product['des_image'] = $des_name;
			foreach ($_FILES["des_image"]["name"] as $v) {
				$des_full_path[] = $path . '/' . basename($v);
			}
			for ($i = 0; $i < count($des_full_path); $i++) {
				move_uploaded_file($_FILES["des_image"]['tmp_name'][$i], $des_full_path[$i]);
			}
		}
		$this->Product_model->update($id, $data_product);

		$this->session->set_flashdata('status', 'Cập nhật thành công', 300);
		redirect('/admin/product');
	}
	public function delete_des_img($id)
	{
		$product = $this->Product_model->get_one($id);
		$des_path = preg_split("/[,]+/", $product->des_image);
		foreach ($des_path as $path) {
			$des_full_path = "upload/products/product_" . $id . "/" . $path;
			unlink($des_full_path);
		}
	}

	public function delete_img($id)
	{
		$product = $this->Product_model->get_one($id);
		$full_path = "upload/products/product_" . $id . "/" . $product->image;
		unlink($full_path);
	}
}
