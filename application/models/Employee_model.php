<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class employee_Model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }

    //<==Playing Users (Role 3) Start==>

    function all_user_count($block = 0) {
        $this->db->select('a.`id`,`a.name`,`a.address`,a.`mobile`,a.`email`,a.`created_at`,a.`dob`,a.`image`');
        $this->db->from('employee a');
       
        return $this->db->get()->num_rows();
    }

    function all_user($limit, $start, $col, $dir, $block = 0) {
        $this->db->select('a.`id`,`a.name`,`a.address`,a.`mobile`,a.`email`,a.`created_at`,a.`dob`,a.`image`');
        $this->db->from('employee a');
        
        $this->db->limit($limit, $start);
        
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function user_search($limit, $start, $search, $col, $dir, $block = 0) {
        $this->db->select('a.`id`,`a.name`,`a.address`,a.`mobile`,a.`email`,a.`created_at`,a.`dob`,a.`image`');
        $this->db->from('employee a');
        
       
        $this->db->group_start();
        
        $this->db->or_like('a.name', $search);
        $this->db->or_like('a.address', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function user_search_count($search, $block = 0) {
        $this->db->select('a.`id`,`a.name`,`a.address`,a.`mobile`,a.`email`,a.`created_at`,a.`dob`,a.`image`');
        $this->db->from('employee a');
        

        $this->db->group_start();
        
        $this->db->or_like('a.name', $search);
        $this->db->or_like('a.address', $search);
        $this->db->or_like('a.mobile', $search);
        $this->db->or_like('a.email', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }


   
    function get_user_detail($user_id = '0') {
        $this->db->select('a.*');
        $this->db->from('employee a');
        $this->db->where('a.id', $user_id);
        return $this->db->get()->row();
    }

}

?>