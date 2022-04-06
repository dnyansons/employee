<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {

        $this->load->database();
        $this->load->model('Common_model');
    }

    function live_matches_active() {
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,time_status,`home_id`,`away_id`');
        $this->db->from('market');
        $this->db->where('m_status','Active');
        $this->db->where('time_status','1');
        $this->db->order_by("match_time",'asc');
        return $this->db->get()->result();
    }

    function live_matches() {
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,time_status,`home_id`,`away_id`');
        $this->db->from('market');
        $this->db->where('m_status','Active');
        $this->db->limit(3,0);
        $this->db->order_by("match_time",'asc');
        return $this->db->get()->result();
    }


    function live_matches2() {
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,time_status,`home_id`,`away_id`');
        $this->db->from('market');
        $this->db->where('m_status','Active');
        $this->db->limit(3,3);
        $this->db->order_by("match_time",'asc');
        return $this->db->get()->result();
    }

    function live_matches3() {
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,time_status,`home_id`,`away_id`');
        $this->db->from('market');
        $this->db->where('m_status','Active');
        $this->db->limit(3,4);
        $this->db->order_by("match_time",'asc');
        return $this->db->get()->result();
    }

    function upcoming_matches(){
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,`home_id`,`away_id`');
        $this->db->from('market');
        $this->db->where('m_status','New');
        $this->db->where('match_date >=',date('Y-m-d'));
        //$this->db->limit(10,4);
        $this->db->order_by("match_time",'asc');
        return $this->db->get()->result();
    }

    function pre_prediction(){
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,`home_id`,`away_id`');
        $this->db->from('market');
        //$this->db->where('m_status','End');
        $this->db->where('show_front',1); 
        $this->db->where('date(match_date)<=',date('Y-m-d'));
        $this->db->limit(4);
        $this->db->order_by("match_time",'desc');
        return $this->db->get()->result();
    }

    function all_pre_prediction($limit,$start){
        $this->db->select('`m_id`,`match_id`,`match_time`,`league_name`,`home_name`,`home_image`,`away_name`,`away_image`,`m_status`,`home_score`,`away_score`,`home_id`,`away_id`');
        $this->db->from('market');
        //$this->db->where('m_status','End');
        $this->db->where('show_front',1);
        $this->db->where('date(match_date)<=',date('Y-m-d'));
        // $this->db->limit(4);
        $this->db->limit($limit, $start);
        $this->db->order_by("match_time",'desc');
        return $this->db->get()->result();
    }

    public function get_count_prediction() {
        return $this->db->count_all('market');
    }

    function get_logo($id=0){
        $this->db->select('image');
        $this->db->from('team_squad');
        $this->db->where('team_id',$id);
        $dat=$this->db->get()->row();
        
        // echo base_url().'assets/media/team/'.$filename;exit;
        if(isset($dat->image)){
            $filename=$dat->image;
            $img=base_url().'assets/media/team/'.$filename;
             return $img;
      
    }else{
        return 0;
    }
} 

function news(){
    $this->db->select('`blog_id`,`blog_title`,`blog_desc`,`short_desc`,`hash_tag`,`image`,`created_at`');
    $this->db->from('blog');
    $this->db->where('blog_status','Active');

    $this->db->limit(2);
    $this->db->order_by("blog_id",'desc');
    return $this->db->get()->result();
}

function news_detail($id){
    $this->db->select('`blog_id`,`blog_title`,`blog_desc`,`short_desc`,`hash_tag`,`image`,`created_at`');
    $this->db->from('blog');
    $this->db->where('blog_status','Active');
    $this->db->where('blog_id',$id);
    return $this->db->get()->row();
}

function other_news($id){
    $this->db->select('`blog_id`,`blog_title`,`blog_desc`,`short_desc`,`hash_tag`,`image`,`created_at`');
    $this->db->from('blog');
    $this->db->where('blog_status','Active');
    $this->db->where_not_in('blog_id',$id);
    $this->db->limit(5);
    $this->db->order_by("created_at",'desc');
    return $this->db->get()->result();
}

function alert_update(){
    $this->db->select('`id`, `title`, `description`, `status`');
    $this->db->from('news');
    $this->db->where('status','Active');
    return $this->db->get()->row();

}

function seo_data(){
    $this->db->select('`id`,`seo_type`,`title`, `keyword`, `description`');
    $this->db->from('seo');
    $this->db->where('id','1');
    return $this->db->get()->row();
}

function enquiry($mobile=0){
    $mobile=$this->session->userdata("mobile");

    $this->db->select('`id`,`name`,`email`,`mobile`,`description`,`subject`,`status`,`reply`,created_at');
    $this->db->from('enquiry');
    $this->db->where('mobile',$mobile);
    $this->db->order_by('id','desc');
    return $this->db->get()->result();

}

}
