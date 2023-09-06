<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CustomerEvaluation extends CI_Controller{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form', 'html');
        $this->load->library('Excelfile', 'form_validation');
        
    }

    public function index()
    {
        $brand = 1;
        $data['project_id'] = $_GET['project'];
        $data['customer_id'] = $_GET['customer'];
        $data['job_id'] = $_GET['job'];
        $data['evaluation'] = $this->db->get_where('pm_setup', array('brand'=>$brand))->row();  
        
        $project_id =  base64_decode($_GET['project']);               
        $customer_id =  base64_decode($_GET['customer']);  
        $job_id =  base64_decode($_GET['job']);  
        $data['customerEv'] = $this->db->get_where('customer_evaluation', array('project_id'=>$project_id,'customer_id'=>$customer_id,'job_id'=>$job_id))->num_rows();           
        $this->load->view('customerEvaluation/evaluation', $data);
           

    }
    public function saveCustomerEvaluation()
    {
            $brand = 1;
            $data['project_id'] =  base64_decode($_POST['project_id']);               
            $data['customer_id'] =  base64_decode($_POST['customer_id']);          
            $data['job_id'] =  base64_decode($_POST['job_id']);          
            $data['note'] = $_POST['note'];  
            $data['ev_select'] = $_POST['ev_select'];           
            $data['ev_type'] = ($_POST['ev_select']<5)?2:1;
            $evaluation = $this->db->get_where('pm_setup', array('brand'=>$brand))->row();  
            for($i=1; $i<=6; $i++){  
                $c_ev_name = "c_ev_name".$i; 
                $c_ev_per = "c_ev_per".$x;
                if($evaluation->$c_ev_name !=null){
                    $data["c_ev_text$i"] = $evaluation->$c_ev_name;  
                    $data["c_ev_per$i"] = $evaluation->$c_ev_per;                 
                    $data["c_ev_val$i"] = $_POST["c_ev_val$i"]??0;  
                }               
            }  
            $data['created_at'] = date("Y-m-d H:i:s");  
            if($this->db->insert('customer_evaluation',$data)){                   
                $true = "Data Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $error = "Failed To Add Data ...";
                $this->session->set_flashdata('error', $error);
               redirect($_SERVER['HTTP_REFERER']);
            }
           
    }
}