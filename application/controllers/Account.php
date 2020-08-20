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
    
    public function detail(){
        $data = array();
        if(isset($_GET['id'])){
            $user_id = $_GET['id'];
            $data['userdata'] = $this->User_model->get_profile_by_id($user_id);
        }
        $this->load->view('account_by_id', $data);
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
    
    public function update_password(){
        $checkOldPass = $this->User_model->check_old_pass($this->input->post('old_pass'));
        if($checkOldPass != 0){
            $data = array(
                'date_modified' => $this->date,
                'password' => $this->input->post('new_pass'),
            );
            $res = $this->User_model->update_profile($data);
            echo $res;
        }else{
            echo 2;
        }
    }

    public function upload_crop_image() {
        $image = $_POST['image'];
        list($type, $image) = explode(';',$image);
        list(, $image) = explode(',',$image);

        $image = base64_decode($image);
        $image_name = 'img-'.time().$this->randomString().'.png';
        if (file_put_contents('uploads/'.$image_name, $image) ) {
            $profile_data = array(
                'date_modified' => $this->date,
                'img_name' => $image_name
            );
            if($this->User_model->update_profile($profile_data) != 0){
                echo 'done';
            }else{
                echo 'error';
            }
        }else{
            echo 'error';
        }
    }

    public function get_prfile_img() {
        $data = $this->User_model->get_prfile_img();
        echo json_encode($data);
    }
}
