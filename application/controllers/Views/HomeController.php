<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url','function'));
		$this->load->library(['form_validation', 'session']);
		$this->load->database();
	}


    public function lists()
    {
        $product = $this->Product_model->get_top_new();
		$category=$this->Category_model->get_list();
		$manufacturer=$this->Manufacturer_model->get_list();
		for($i=0;$i<count($product);$i++){
			$star=$this->Rate_model->get_star_avg($product[$i]['id']);
			$product[$i]['rate_star']=$star->rate_star;
		}
		
		$data = [
			'page_name' => 'home/list_product',
			'style' => ['css/search.css'],
            'js' => ['scripts/script.js','scripts/list_product.js'],
			'product' => $product,
			'category'=>$category,
			'manufacturer'=>$manufacturer,
			'count'=>count($product)
		];
		// var_dump($product);
		$this->load->view('home/index', $data);
    }

	public function search(){
		$key=$this->input->get('search_key');
		$manufacturer=$this->Manufacturer_model->search_limit($key);
		$category=$this->Category_model->search_limit($key);
		$product=$this->Product_model->search_limit($key);
		$output=[
			'manufacturer'=>$manufacturer,
			'product'=>$product,
			'category'=>$category,
		];
		echo json_encode($output);
	}

	public function search_product(){
		$search_key=$this->input->get('search_key');
		$product = $this->Product_model->search($search_key);
		$category=$this->Category_model->get_list();
		$manufacturer=$this->Manufacturer_model->get_list();
		for($i=0;$i<count($product);$i++){
			$star=$this->Rate_model->get_star_avg($product[$i]['id']);
			$product[$i]['rate_star']=$star->rate_star;
		}
		$data = [
			'page_name' => 'home/last-search',
			'style' => ['css/search.css'],
            'js' => ['scripts/script.js','scripts/list_product.js'],
			'product' => $product,
			'category'=>$category,
			'manufacturer'=>$manufacturer,
			'count'=>count($product),
			'title'=>'"'.$search_key.'"'
		];
		$this->load->view('home/index', $data);
	}

	public function filter(){
		$sort_option=$this->input->post('sort_option');
		$manu=$this->input->post('manu');
		$cate=$this->input->post('cate');
		$price=$this->input->post('price');
		$min_price=$this->input->post('min_price');
		$max_price=$this->input->post('max_price');
		$usersize=$this->input->post('usersize');
		$list=$this->input->post('list');
		$output=$this->Product_model->filter($manu,$cate,$price,$usersize,$sort_option,$list,$min_price,$max_price);
		for($i=0;$i<count($output);$i++){
			$star=$this->Rate_model->get_star_avg($output[$i]['id']);
			if($star->rate_star){
			$output[$i]['rate_star']=$star->rate_star;
			}
			else{
				$output[$i]['rate_star']=0;
			}
		}
		die(json_encode($output));
	} 
}
