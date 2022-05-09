<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RateController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Rate_model');
		$this->load->model('Admin/Rep_rate_model');
		if (!$this->session->userdata('username')) {
			redirect('/admin/login');
		}
	}


	public function index()
	{
		$lists = $this->Rate_model->get_list();
		$data = [
			'page_name' => 'admin/rate',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		// var_dump($lists);
		$this->load->view('admin/index', $data);
	}

	public function rep_list()
	{
		$rate_id = $this->input->get('rate_id');
		$lists = $this->Rep_rate_model->get_one($rate_id);
		$data = [
			'page_name' => 'admin/rep_rate',
			'style' => '',
			'js' => '',
			'lists' => $lists,
			'id_rate' => $rate_id
		];
		// var_dump($lists);
		$this->load->view('admin/index', $data);
	}

	public function add_rep()
	{
		$rate_id = $this->input->get('rate_id');
		$this->form_validation->set_rules('content', 'Nội dung', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$data_page = [
				'page_name' => 'admin/rate_add_rep',
				'style' => '',
				'js' => '/scripts/admin/rep.js',
				'lists' => '',
				'rate_id' => $rate_id
			];
			$this->load->view('admin/index', $data_page);
		} else {

			$this->action_add_rep($rate_id);
		}
	}

	public function action_add_rep($rate_id)
	{
		if (isset($_FILES['image'])) {
			$file_name = $_FILES['image']['name'];
		} else $file_name = '';
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$data = [
			'id_rate' => $rate_id,
			'name' => 'Timviec365.com',
			'content' => $this->input->post('content'),
			'image' => $file_name,
			'status' => 1,
			'is_admin' => 1,
			'create_time' => date("Y-m-d H:i:s"),
		];
		$last_id = $this->Rep_rate_model->insert($data);
		if (isset($_FILES['image'])) {
			$path = "upload/rate/rep_rate_" . $last_id;
			$full_path = $path . '/' . basename($_FILES["image"]["name"]);
			mkdir($path, 0777);
			move_uploaded_file($_FILES['image']['tmp_name'], $full_path);
		}
		$this->session->set_flashdata('message', 'Thêm thành công.');
		header('location:' . $_SERVER['HTTP_REFERER']);
	}

	public function delete()
	{
		$id = $this->input->get('rate_id');
		$img_path = "upload/rate/rate_" . $id;
		$this->remove_dir($img_path);
		$rep_list = $this->Rep_rate_model->get_one($id);
		foreach ($rep_list as $list) {
			$img_path = "upload/rate/rep_rate_" . $list['id'];
			$this->remove_dir($img_path);
			$this->Rep_rate_model->delete($list['id']);
		}
		$this->Rate_model->delete($id);
		echo ($id);
	}

	public function delete_rep()
	{
		$id = $this->input->get('rep_rate_id');
		$img_path = "upload/rate/rep_rate_" . $id;
		$this->remove_dir($img_path);
		$this->Rep_rate_model->delete($id);
		echo $id;
	}

	function remove_dir($dir = null)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir") remove_dir($dir . "/" . $object);
					else unlink($dir . "/" . $object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}
}
