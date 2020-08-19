<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->active = 'home';
		$this->load->model('Work_model');
	}
	  
	public function index(){
		$data['work_list'] = $this->Work_model->get_work();
		$this->load->view('home', $data);
	}
}
