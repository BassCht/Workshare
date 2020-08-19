<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        date_default_timezone_set('Asia/Bangkok'); 
        $this->date = date('Y-m-d H:i:s');
    }

    function get_work() {
        $this->db->select('w.date_created, w.work_detail, w.status, u.username')
        ->from('work w')
        ->join('users u', 'w.user_id = u.user_id')
        ->order_by('w.date_created', 'DESC');
        $query = $this->db->get();

        if ($query->result()) {
            return $query->result();
        }
    }

    function add_work($detail) {
        $data = array(
            'date_created' => $this->date,
            'date_modified' => $this->date,
            'user_id' => $this->session->userdata('user_id'),
            'work_detail' => $detail,
            'status' => 1
        );

        if ($this->db->insert('work', $data)) {
            return 1;
        } else {
            return 0;
        }
    }   

    function get_user_work() {
        $this->db->select('w.work_id, w.date_created, w.work_detail, w.status, u.username')
        ->from('work w')
        ->join('users u', 'w.user_id = u.user_id')
        ->where('w.user_id', $this->session->userdata('user_id'))
        ->order_by('w.date_created', 'DESC');
        $query = $this->db->get();

        if ($query->result()) {
            return $query->result();
        }
    }

    function update_work_status($work_id, $data) {
        if ($this->db->where('work_id', $work_id)->update('work', $data)) {
            return 1;
        } else {
            return 0;
        }
    }   

    public function clear_work(){
        $user_id = $this->session->userdata('user_id');
        if ($this->db->where('user_id', $user_id)->where("DATEDIFF(NOW(), date_created) >= 2")->delete('work')) {
            return 1;
        } else {
            return 0;
        }
    }
    
}