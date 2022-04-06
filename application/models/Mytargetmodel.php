<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mytargetmodel extends CI_Model {

    public function __construct() {

        $this->load->database();
    }

    //<==Playing Users (Role 3) Start==>

    function all_entries_count($block = 0) {
    $this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.target_id,a.settled,b.`mobile`,SUM(d.`credit`-d.`debit`)tot,d.pay_type,d.`create_date`,d.`status`,b.first_name,c.sites_name,e.target,e.commision,e.start_date,e.end_date');
    $this->db->from('agent_sites a');
    $this->db->join('front_users b','a.agent_id=b.id','left');
    $this->db->join('sites c','a.site_id=c.sp_id','left');
    $this->db->join('data_entries d','a.agent_id=d.agent_id','left');
    $this->db->join('agent_target e','e.id=a.target_id','left');
    $this->db->where('a.status','Active');
    $this->db->where('a.agent_id',$this->session->userdata("user_id"));
    $this->db->group_by(array("a.target_id","a.agent_id"));
     return $this->db->get()->num_rows();
 }

 function all_entries($limit, $start, $col, $dir, $block = 0) {
$this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.target_id,a.settled,b.`mobile`,SUM(d.`credit`-d.`debit`)tot,d.pay_type,d.`create_date`,d.`status`,b.first_name,c.sites_name,e.target,e.commision,e.start_date,e.end_date');
    $this->db->from('agent_sites a');
    $this->db->join('front_users b','a.agent_id=b.id','left');
    $this->db->join('sites c','a.site_id=c.sp_id','left');
     $this->db->join('data_entries d','a.agent_id=d.agent_id','left');
     $this->db->join('agent_target e','e.id=a.target_id','left');
    $this->db->where('a.status','Active');
       $this->db->where('a.agent_id',$this->session->userdata("user_id"));
    $this->db->limit($limit, $start);
     $this->db->group_by(array("a.target_id","a.agent_id"));
    $this->db->order_by("a." . $col, $dir);
    return $this->db->get()->result();
}

function entries_search($limit, $start, $search, $col, $dir, $block = 0) {
$this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.target_id,a.settled,b.`mobile`,SUM(d.`credit`-d.`debit`)tot,d.pay_type,d.`create_date`,d.`status`,b.first_name,c.sites_name,e.target,e.commision,e.start_date,e.end_date');
    $this->db->from('agent_sites a');
    $this->db->join('front_users b','a.agent_id=b.id','left');
    $this->db->join('sites c','a.site_id=c.sp_id','left');
    $this->db->join('data_entries d','d.site_id=a.site_id','left');
    $this->db->join('agent_target e','e.id=a.target_id','left');
    $this->db->where('a.status','Active');
       $this->db->where('a.agent_id',$this->session->userdata("user_id"));
    
    $this->db->group_start();
    
    $this->db->or_like('b.first_name', $search);
    $this->db->or_like('d.name', $search);
    $this->db->or_like('b.mobile', $search);
    $this->db->or_like('d.credit', $search);
    $this->db->or_like('d.status', $search);
    $this->db->group_end();
    $this->db->group_by(array("a.target_id","a.agent_id"));
    $this->db->limit($limit, $start);
    $this->db->order_by("a." . $col, $dir);
    return $this->db->get()->result();
}

function user_search_count($search, $block = 0) {
$this->db->select('a.`id`,`a.agent_id`,`a.site_id`,a.target_id,a.settled,b.`mobile`,SUM(d.`credit`-d.`debit`)tot,d.pay_type,d.`create_date`,d.`status`,b.first_name,c.sites_name,e.target,e.commision,e.start_date,e.end_date');
    $this->db->from('data_entries a');
    $this->db->join('front_users b','a.agent_id=b.id','left');
    $this->db->join('sites c','a.site_id=c.sp_id','left');
    $this->db->join('agent_sites d','d.site_id=a.site_id','left');
    $this->db->join('agent_target e','e.id=a.target_id','left');
    $this->db->where('a.status','Active');
       $this->db->where('a.agent_id',$this->session->userdata("user_id"));
    
    $this->db->group_start();
    
    $this->db->or_like('b.first_name', $search);
    $this->db->or_like('a.name', $search);
    $this->db->or_like('b.mobile', $search);
    $this->db->or_like('a.credit', $search);
    $this->db->or_like('a.status', $search);
    $this->db->group_end();
    $this->db->group_by(array("a.target_id","a.agent_id"));
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