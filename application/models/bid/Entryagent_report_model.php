<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Entryagent_report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Common_model');
    }

    function trans_count() { 
        $this->db->select('a.paidfor,a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`credit`,a.`debit`,a.pay_type,a.`name`,a.`create_date`,a.`status`,b.first_name,c.sites_name');
        $this->db->from('data_entries a');
        $this->db->join('front_users b','a.agent_id=b.id','left');
        $this->db->join('sites c','a.site_id=c.sp_id','left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.create_date) >=", date('Y-m-d',strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.create_date) <=", date('Y-m-d',strtotime($_POST['dateto'])));
        }

        $this->db->where("a.agent_id",$this->session->userdata("user_id"));
        
        if ($_POST['site_id'] != '') {
            $this->db->where("a.site_id", $_POST['site_id']);
        }
        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_trans($limit, $start, $col, $dir) {
        $this->db->select('a.paidfor,a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`credit`,a.`debit`,a.pay_type,a.`name`,a.`create_date`,a.`status`,b.first_name,c.sites_name');
        $this->db->from('data_entries a');
        $this->db->join('front_users b','a.agent_id=b.id','left');
        $this->db->join('sites c','a.site_id=c.sp_id','left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.create_date) >=", date('Y-m-d',strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.create_date) <=", date('Y-m-d',strtotime($_POST['dateto'])));
        }

        $this->db->where("a.agent_id",$this->session->userdata("user_id"));

        if ($_POST['site_id'] != '') {
            $this->db->where("a.site_id", $_POST['site_id']);
        }

        if ($limit != '' && $start != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('a.id');
        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
      // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    function trans_search($limit, $start, $search, $dir) {
        $this->db->select('a.paidfor,a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`credit`,a.`debit`,a.pay_type,a.`name`,a.`create_date`,a.`status`,b.first_name,c.sites_name');
        $this->db->from('data_entries a');
        $this->db->join('front_users b','a.agent_id=b.id','left');
        $this->db->join('sites c','a.site_id=c.sp_id','left');
        if ($_POST['datefrom'] != '') {
            $this->db->where("date(a.create_date) >=", date('Y-m-d',strtotime($_POST['datefrom'])));
        }
        if ($_POST['dateto'] != '') {
            $this->db->where("date(a.create_date) <=", date('Y-m-d',strtotime($_POST['dateto'])));
        }

        $this->db->where("a.agent_id",$this->session->userdata("user_id"));

        if ($_POST['site_id'] != '') {
          $this->db->where("a.site_id", $_POST['site_id']);
      }
      $this->db->group_start();
      if (!empty($search)) {
        $this->db->like('a.id', $search);
        $this->db->or_like('b.first_name', $search);
        $this->db->or_like('b.mobile', $search);
    }
    $this->db->group_end();
    if ($limit != '' && $start != '') {
        $this->db->limit($limit, $start);
    }
    $this->db->group_by('a.id');
    $this->db->order_by('id', 'DESC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return null;
    }
}

function trans_search_count($search) {
    $this->db->select('a.paidfor,a.`id`,`a.agent_id`,`a.site_id`,a.data_type,a.`mobile`,a.`credit`,a.`debit`,a.pay_type,a.`name`,a.`create_date`,a.`status`,b.first_name,c.sites_name');
    $this->db->from('data_entries a');
    $this->db->join('front_users b','a.agent_id=b.id','left');
    $this->db->join('sites c','a.site_id=c.sp_id','left');
    if ($_POST['datefrom'] != '') {
        $this->db->where("date(a.create_date) >=", date('Y-m-d',strtotime($_POST['datefrom'])));
    }
    if ($_POST['dateto'] != '') {
        $this->db->where("date(a.create_date) <=", date('Y-m-d',strtotime($_POST['dateto'])));
    }

    $this->db->where("a.agent_id",$this->session->userdata("user_id"));
    
    if ($_POST['site_id'] != '') {
     $this->db->where("a.site_id", $_POST['site_id']);
 }
 $this->db->group_start();
 if (!empty($search)) {
    $this->db->like('a.id', $search);
    $this->db->or_like('b.first_name', $search);
    $this->db->or_like('b.mobile', $search);
}
$this->db->group_end();
$this->db->group_by('a.id');
$this->db->order_by('a.id', 'DESC');
$query = $this->db->get();

if ($query->num_rows() > 0) {
    return $query->num_rows();
} else {
    return null;
}
}



}
