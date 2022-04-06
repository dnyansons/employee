<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();


        $models = array('Common_model','Employee_model');  
        $this->load->model($models);
        $this->load->library('Common_data');
    }

    public function index() {
            $this->load->view('common/header');

            $this->load->view('employee/list');
            $this->load->view('common/footer');
    }


    public function ajax_list() {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'address',
            3 => 'mobile',
            4 => 'email',
            5 =>'dob',
            6 => 'image',
            7 => 'created_at',
        );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $col = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        //$dir ="desc";

        $totalData = $this->Employee_model->all_user_count(0);

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $users = $this->Employee_model->all_user($limit, $start, $col, $dir, 0);
            // echo $this->db->last_query();
        } else {
            $search = $this->input->post('search')['value'];

            $users = $this->Employee_model->user_search($limit, $start, $search, $col, $dir, 0);
            // echo $this->db->last_query();
            $totalFiltered = $this->Employee_model->user_search_count($search, 0);
        }

        $data = array();
        if (!empty($users)) {
            $i = 0;
            foreach ($users as $dat) {



                $nestedData['id'] = 'ID-' . $dat->id;
                $nestedData['name'] = $dat->name;
                 $nestedData['address'] = $dat->address;
                $nestedData['mobile'] = $dat->mobile;
                $nestedData['email'] = $dat->email;
                $nestedData['dob'] = $dat->dob;
                $nestedData['image'] ='<img style="width:80px;" src="'.$dat->image.'">';
                $nestedData['created_at'] = date("d M y h:i", strtotime($dat->created_at));
                $nestedData['action'] = '&nbsp;&nbsp;<a class="btn btn-info btn-sm" title="Edit agent" href="' . base_url() . 'employee/edit/' . $dat->id . '"><i class="fas fa-pencil-alt"></i></a> &nbsp;<a onclick="return confirm(&apos;Are You Sure ?&apos;)" href="'.base_url().'employee/delete/'.$dat->id.'" class="btn btn-warning btn-sm" title="Delete Agent"><i class="fas fa-trash-alt" style="color:#fff;"></i></a>';
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'query' => $this->db->last_query()
        );

        echo json_encode($json_data);
    }




    public function add() {


        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employee.email]');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() == false) {
            $err_msg = validation_errors();
            $this->session->set_flashdata('error', $err_msg);

            $this->load->view('common/header');
            $this->load->view('employee/add');
            $this->load->view('common/footer');
        } else {

            $insert['name'] = $this->input->post('name');
            $insert['mobile'] = $this->input->post('mobile');
            $insert['email'] = $this->input->post('email');
            $insert['dob'] =date('Y-m-d',strtotime($this->input->post('dob')));

            $config['upload_path'] = './assets/media/employee/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 200000; 

            $this->load->library('upload', $config);

            if(!empty($_FILES['image']['name'])){
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());

                    $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='far fa-window-close'></i></a>
                    <strong>Error!</strong> Upload Valid Image.
                    </div>";
                    $this->session->set_flashdata("message", $message);
                    redirect("employee");


                } 

            }
            if($this->upload->data('file_name')){
                $path=base_url().'assets/media/employee/'.$this->upload->data('file_name');
                $insert['image']=$path;
            }else{
                $insert['image']='';
            }

            //check for Date
             $currDate=date('Y-m-d',strtotime("+ 1 day"));
             $existDate=date('Y-m-d',strtotime($this->input->post('dob')));
            if ($existDate > $currDate){
                $message = "<div class='alert alert-danger alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='far fa-window-close'></i></a>
                <strong>Error!</strong> , DOB Future date cannot be select
                </div>";
                $this->session->set_flashdata("message", $message);
                 redirect("employee");
            }


            $insert['address'] = $this->input->post('address');
            $up = $this->db->insert('employee', $insert);
            if ($up) {
                $message = "<div class='alert alert-success alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                <strong>Success!</strong> Employee Created successfully.
                </div>";
                $this->session->set_flashdata("message", $message);
            } else {
                $message = "<div class='alert alert-info alert-dismissible'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='far fa-window-close'></i></a>
                <strong>Success!</strong> No Changes on Record.
                </div>";
                $this->session->set_flashdata("message", $message);
            }
            redirect("employee");
        }

    }


    public function edit($id = 0) {

        if ($id != 0) {

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            if ($this->form_validation->run() == false) {
                $err_msg = validation_errors();
                $this->session->set_flashdata('error', $err_msg);
                $data['users'] = $this->Employee_model->get_user_detail($id);
                $data['employee_id'] =$id;
                $this->load->view('common/header', $data);
                $this->load->view('employee/edit', $data);
                $this->load->view('common/footer');
            } else {

                $updata['name'] = $this->input->post('name');
                $updata['address'] = $this->input->post('address');     
                $updata['mobile'] = $this->input->post('mobile');
                $updata['email'] = $this->input->post('email');
                $updata['dob'] =date('Y-m-d',strtotime($this->input->post('dob')));


               $config['upload_path'] = './assets/media/app_banner/';
               $config['allowed_types'] = 'gif|jpg|png';
               $config['max_size'] = 200000;

               $this->load->library('upload', $config);
                if(!empty($_FILES['image']['name'])){
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());

                    $message = "<div class='alert alert-danger alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='far fa-window-close'></i></a>
                    <strong>Error!</strong> Upload Valid Image.
                    </div>";
                    $this->session->set_flashdata("message", $message);
                    redirect("employee");


                } 
                $path=base_url().'assets/media/employee/'.$this->upload->data('file_name');
                $updata['image']=$path;
            }
            


                $up = $this->Common_model->update('employee', $updata, array('id' =>$this->input->post('id')));
                if ($up) {
                    $message = "<div class='alert alert-success alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
                    <strong>Success!</strong> Update successfully.
                    </div>";
                    $this->session->set_flashdata("message", $message);
                } else {
                    $message = "<div class='alert alert-info alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'><i class='far fa-window-close'></i></a>
                    <strong>Success!</strong> No Changes on Record.
                    </div>";
                    $this->session->set_flashdata("message", $message);
                }
                redirect("employee");
            }
        } else {
            redirect("employee");
        }
    }



    function delete($id) {

        
     // $this->session->set_flashdata("message", $message);

     $this->Common_model->delete('employee', array('id' => $id));
     $message = "<div class='alert alert-success alert-dismissible'>
     <a href='#' class='close' data-dismiss='alert' aria-label='close'></a>
     <strong>Success!</strong>Employee Delete Successfully.
     </div>";
     $this->session->set_flashdata("message", $message);

     redirect("employee");
 }

}
