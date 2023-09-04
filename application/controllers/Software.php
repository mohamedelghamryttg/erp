<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Software extends CI_Controller {
    var $role,$user,$brand;

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
      	$this->brand = $this->session->userdata('brand');
        $this->emp_id = $this->session->userdata('emp_id');
    } 
    public function ttgSoftware(){
        $check = $this->admin_model->checkPermission($this->role,168);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,168);
            //body ..
            $data['request'] = $this->db->query(" SELECT * FROM pm_conversion_request WHERE status = '1' ");
            
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('software/ttgSoftware.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
     }

     public function softwareViewRequest(){
        $check = $this->admin_model->checkPermission($this->role,168);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,168);
            //body ..
             $data['id'] =base64_decode($_GET['t']);
              $data['row'] = $this->db->query(" SELECT * FROM pm_conversion_request WHERE id = '$id' ");
            // //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('software/viewRequest.php');
            $this->load->view('includes/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }
       }
        public function changeConversionRequestStatus(){
        $check = $this->admin_model->checkPermission($this->role,168);
            if($check){
               $id = base64_decode($_POST['id']);
               $data['status'] = $_POST['status'];
               $data['reason'] = $_POST['comment'];
               $data['status_at'] = date("Y-m-d H:i:s");
               $data['status_by'] = $this->user;
            
               if ($_FILES['file']['size'] != 0){
                       $config['file']['upload_path']          = './assets/uploads/pmConversionRequestDocument/';
                        $config['file']['encrypt_name']         = TRUE;
                        $config['file']['allowed_types']  = 'zip|rar';
                        $config['file']['max_size']             = 1000000;
                        $this->load->library('upload', $config['file'], 'file_upload');
                        if( ! $this->file_upload->do_upload('file')){
                            $error= $this->file_upload->display_errors();   
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url()."software/ttgSoftware");             
                        }else{
                            $data_file = $this->file_upload->data();
                            $data['closed_file'] = $data_file['file_name'];
                        }
                    }else{
                        // $error = "You should upload attachment";
                        // $this->session->set_flashdata('error', $error);
                        // redirect(base_url()."software/ttgSoftware");
                    }

             $this->admin_model->addToLoggerUpdate('pm_conversion_request',168,'id',$id,0,0,$this->user);
                if($this->db->update('pm_conversion_request',$data,array('id'=>$id))){
                	$this->projects_model->sendUpdateMail($data,$id);
                    $true = "Status Changed Successfully ...";
                    $this->session->set_flashdata('true', $true);
                        redirect(base_url()."software/ttgSoftware");
                 }else{
                    $error = "Failed To Change Status ...";
                    $this->session->set_flashdata('error', $error);
                        redirect(base_url()."software/ttgSoftware");        
                }
            }else{
                echo "You have no permission to access this page";
            }
      }

    }?>