<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entry_users_Model extends CI_Model {

    public function __construct() {

        $this->load->database();
    }

    //<==Playing Users (Role 3) Start==>

    function all_user_count($block = 0) {
        $this->db->select('a.`id`,`a.user_id`,`a.name`,`a.status`,created_at');
        $this->db->from('bid_entry_users a');
        return $this->db->get()->num_rows();
    }

    function all_user($limit, $start, $col, $dir, $block = 0) {
          $this->db->select('a.`id`,`a.user_id`,`a.name`,`a.status`,created_at');
        $this->db->from('bid_entry_users a');
        
        $this->db->limit($limit, $start);
        
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function user_search($limit, $start, $search, $col, $dir, $block = 0) {
        $this->db->select('a.`id`,`a.user_id`,`a.name`,`a.status`,created_at');
        $this->db->from('bid_entry_users a');
        
       
        $this->db->group_start();
        
        $this->db->or_like('a.user_id', $search);
        $this->db->or_like('a.name', $search);
        $this->db->or_like('a.status', $search);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by("a." . $col, $dir);
        return $this->db->get()->result();
    }

    function user_search_count($search, $block = 0) {
         $this->db->select('a.`id`,`a.user_id`,`a.name`,`a.status`,created_at');
        $this->db->from('bid_entry_users a');
        

        $this->db->group_start();
        
        $this->db->or_like('a.user_id', $search);
        $this->db->or_like('a.name', $search);
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
        $this->db->select('a.*');
        $this->db->from('bid_entry_users a');
       
        // $this->db->join('countries c', 'a.country=c.id','left');
        // $this->db->join('states d', 'a.state=d.id','left');
        $this->db->where('a.id', $user_id);
        return $this->db->get()->row();
    }
    function get_agent_user_detail($user_id = '0',$agent_id=0) {
        $this->db->select('a.*,c.name as country_name,d.name as state_name');
        $this->db->from('bid_entry_users a');
        $this->db->join('role b', 'a.role=b.role_id');
        $this->db->join('countries c', 'a.country=c.id');
        $this->db->join('states d', 'a.state=d.id');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.created_by', $agent_id);
        return $this->db->get()->row();
    }

    
   
    

}

?>