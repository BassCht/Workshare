<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    function check_login($username, $password) {
        $this->db->select('*')->from('users')->where('username', $username)->where('password', $password);
        $query = $this->db->get();

        if ($query->result()) {
            return $query->result();
        }
    }   
    
    function get_profile() {
        $this->db->select('*')->from('users')->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();

        if ($query->result()) {
            return $query->result();
        }
    } 

    function update_profile($data) {
        if ($this->db->where('user_id', $this->session->userdata('user_id'))->update('users', $data)) {
            return 1;
        } else {
            return 0;
        }
    }  
}