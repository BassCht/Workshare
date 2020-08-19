<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->library('session');
		$this->load->model('Work_model');
		date_default_timezone_set('Asia/Bangkok'); 
        $this->date = date('Y-m-d H:i:s');
	}
	  
	public function index(){
        $this->active = 'addwork';
		$this->load->view('add_work');
	}

	public function add_work(){
		$detail = $this->input->post('detail');
		$res = $this->Work_model->add_work($detail);
		echo $res;
	}

	public function update(){
		$this->active = 'updatework';
		$data['work_list'] = $this->Work_model->get_user_work();
		$this->load->view('update_work', $data);
	}

	public function update_work_status(){
		$data = array(
            'date_modified' => $this->date,
            'status' => $this->input->post('status')
        );
		$res = $this->Work_model->update_work_status($this->input->post('work_id'), $data);
		echo $res;
	}

	public function clear_work(){
		$res = $this->Work_model->clear_work();
		echo $res;
	}
}
