<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->active = 'login';
		$this->load->library('session');
		$this->load->model('User_model');
	}
	  
	public function index(){
		$this->load->view('login');
	}

	public function check_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user = $this->User_model->check_login($username, $password);
		if($user != null){
			foreach($user as $val){
				$_SESSION['user_id'] = $val->user_id;
				$_SESSION['username'] = $val->username;
			}
			echo $_SESSION['user_id'];
		}else{
			echo 0;
		}
	}

	public function logout(){
		session_destroy();
		redirect(base_url());
	}
}
