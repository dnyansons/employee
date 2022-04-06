<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entries_Model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }

    //<==Playing Users (Role 3) Start==>

    function all_entries_count($block = 0) {
       $this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`credit`,a.`debit`,a.pay_type,a.`name`,a.`create_date`,a.`status`,b.first_name,c.sites_name');
       $this->db->from('bid_data_entries a');
       $this->db->join('bid_front_users b','a.agent_id=b.id','left');
       $this->db->join('bid_sites c','a.site_id=c.sp_id','left');
       return $this->db->get()->num_rows();
   }

   function all_entries($limit, $start, $col, $dir, $block = 0) {
    $this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`name`,a.`credit`,a.`debit`,a.pay_type,a.`create_date`,a.`status`,b.first_name,c.sites_name');
       $this->db->from('bid_data_entries a');
       $this->db->join('bid_front_users b','a.agent_id=b.id','left');
       $this->db->join('bid_sites c','a.site_id=c.sp_id','left');
    $this->db->limit($limit, $start);
    
    $this->db->order_by("a." . $col, $dir);
    return $this->db->get()->result();
}

function entries_search($limit, $start, $search, $col, $dir, $block = 0) {
    $this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`name`,a.`credit`,a.`debit`,a.pay_type,a.`create_date`,a.`status`,b.first_name,c.sites_name');
       $this->db->from('bid_data_entries a');
       $this->db->join('bid_front_users b','a.agent_id=b.id','left');
       $this->db->join('bid_sites c','a.site_id=c.sp_id','left');
    
    $this->db->group_start();
    
    $this->db->or_like('b.first_name', $search);
    $this->db->or_like('a.name', $search);
    $this->db->or_like('a.mobile', $search);
    $this->db->or_like('a.credit', $search);
    $this->db->or_like('a.status', $search);
    $this->db->group_end();
    $this->db->limit($limit, $start);
    $this->db->order_by("a." . $col, $dir);
    return $this->db->get()->result();
}

function user_search_count($search, $block = 0) {
    $this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`name`,a.`credit`,a.`debit`,a.pay_type,a.`create_date`,a.`status`,b.first_name,c.sites_name');
       $this->db->from('bid_data_entries a');
       $this->db->join('bid_front_users b','a.agent_id=b.id','left');
       $this->db->join('bid_sites c','a.site_id=c.sp_id','left');
    
    $this->db->group_start();
    
    $this->db->or_like('b.first_name', $search);
    $this->db->or_like('a.name', $search);
    $this->db->or_like('a.mobile', $search);
    $this->db->or_like('a.credit', $search);
    $this->db->or_like('a.status', $search);
    $this->db->group_end();
    return $this->db->get()->num_rows();
}



function get_state($id) {
    $this->db->select('id,name');
    $this->db->from('states');
    $this->db->where('country_id', $id);
    return $this->db->get()->result();
}


function get_user_detail($user_id = '0') {
    $this->db->select('a.*,c.name as country_name,d.name as state_name');
    $this->db->from('front_users a');
    
    $this->db->join('countries c', 'a.country=c.id','left');
    $this->db->join('states d', 'a.state=d.id','left');
    $this->db->where('a.id', $user_id);
    return $this->db->get()->row();
}
function get_agent_user_detail($user_id = '0',$agent_id=0) {
    $this->db->select('a.*,c.name as country_name,d.name as state_name');
    $this->db->from('front_users a');
    $this->db->join('role b', 'a.role=b.role_id');
    $this->db->join('countries c', 'a.country=c.id');
    $this->db->join('states d', 'a.state=d.id');
    $this->db->where('a.user_id', $user_id);
    $this->db->where('a.created_by', $agent_id);
    return $this->db->get()->row();
}





}

?>