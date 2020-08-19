<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->active = 'account';
        $this->load->model('User_model');
        date_default_timezone_set('Asia/Bangkok'); 
        $this->date = date('Y-m-d H:i:s');
    }
    
    function randomString() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $stg = array();
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $stg[] = $alphabet[$n];
        }
        return implode($stg); 
    }
	  
	public function index(){
        $this->subactive = 'profile';
        $data['userdata'] = $this->User_model->get_profile();
		$this->load->view('account', $data);
    }

    public function changepassword(){
        $this->subactive = 'changepass';
		$this->load->view('change_password');
    }

    public function update_profile(){
        $username = $this->input->post('username');
		$data = array(
            'date_modified' => $this->date,
            'username' => $username,
            'fullname' => $this->input->post('fullname'),
            'tel' => $this->input->post('tel'),
        );

        $res = $this->User_model->update_profile($data);
        if($res == 1){
            $_SESSION['username'] = $username;
        }
		echo $res;
	}
    
    public function upload_profile_image() {
        $data = array();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|png';
        $config['file_name'] = 'img-'.time().$this->randomString();
        $config['max_size'] = 5000;
        $config['max_width'] = 2400;
        $config['max_height'] = 2400;
        
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $data['error'] = $this->upload->display_errors();
        } else {
            $upload_data = $this->upload->data(); 
            $profile_data = array(
                'date_modified' => $this->date,
                'img_name' => $upload_data['file_name']
            );
            if($this->User_model->update_profile($profile_data) != 0){
                $data['done'] = $this->upload->data();
            }else{
                $data['error'] = 'Can not update file name to database';
            }
        }
        echo json_encode($data);
    }
}
