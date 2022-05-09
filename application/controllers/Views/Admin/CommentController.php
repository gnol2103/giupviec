<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CommentController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
		$this->load->model('Admin/Comment_model');
		$this->load->model('Admin/Rep_cmt_model');
		if (!$this->session->userdata('username')) {
			redirect('/admin/login');
		}
	}


	public function index()
	{
		$lists = $this->Comment_model->get_list();
		$data = [
			'page_name' => 'admin/comment',
			'style' => '',
			'js' => '',
			'lists' => $lists
		];
		// var_dump($lists);
		$this->load->view('admin/index', $data);
	}

	public function rep_list()
	{
		$cmt_id = $this->input->get('cmt_id');
		$lists = $this->Rep_cmt_model->get_one($cmt_id);
		$data = [
			'page_name' => 'admin/rep_cmt',
			'style' => '',
			'js' => '',
			'lists' => $lists,
			'id_cmt' => $cmt_id
		];
		// var_dump($lists);
		$this->load->view('admin/index', $data);
	}

	public function add_rep()
	{
		$cmt_id = $this->input->get('cmt_id');
		$this->form_validation->set_rules('content', 'Nội dung', 'required', array('required' => '%s không được để trống'));
		if ($this->form_validation->run() == FALSE) {
			$data_page = [
				'page_name' => 'admin/comment_add_rep',
				'style' => '',
				'js' => '/scripts/admin/rep.js',
				'lists' => '',
				'cmt_id' => $cmt_id
			];
			$this->load->view('admin/index', $data_page);
		} else {

			$this->action_add_rep($cmt_id);
		}
	}

	public function action_add_rep($cmt_id)
	{
		if (isset($_FILES['image'])) {
			$file_name = $_FILES['image']['name'];
		} else $file_name = '';
		date_default_timezone_set("Asia/Ho_Chi_Minh");
		$data = [
			'id_cmt' => $cmt_id,
			'name' => 'Timviec365.com',
			'content' => $this->input->post('content'),
			'image' => $file_name,
			'status' => 1,
			'is_admin' => 1,
			'create_time' => date("Y-m-d H:i:s"),
		];
		$last_id = $this->Rep_cmt_model->insert($data);
		if (isset($_FILES['image'])) {
			$path = "upload/cmt/rep_cmt_" . $last_id;
			$full_path = $path . '/' . basename($_FILES["image"]["name"]);
			mkdir($path, 0777);
			move_uploaded_file($_FILES['image']['tmp_name'], $full_path);
		}
		$this->session->set_flashdata('message', 'Thêm thành công.');
		header('location:' . $_SERVER['HTTP_REFERER']);
	}

	public function delete()
	{
		$id = $this->input->get('cmt_id');
		// $cmt=$this->Comment_model->get_one($id);
		$img_path = "upload/cmt/cmt_" . $id;
		$this->remove_dir($img_path);
		$rep_list = $this->Rep_cmt_model->get_one($id);
		foreach ($rep_list as $list) {
			$img_path = "upload/cmt/rep_cmt_" . $list['id'];
			$this->remove_dir($img_path);
			$this->Rep_cmt_model->delete($list['id']);
		}
		$this->Comment_model->delete($id);
		echo ($id);
	}

	public function delete_rep()
	{
		$id = $this->input->get('rep_cmt_id');
		$img_path = "upload/cmt/rep_cmt_" . $id;
		$this->remove_dir($img_path);
		$this->Rep_cmt_model->delete($id);
		echo ($id);
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
