<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExternalVendor extends CI_Controller {
    var $role,$user;

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
      	$this->brand = $this->session->userdata('brand');
    }
    public function register($brand=0){
        $map_data=[
            ["id"=>1,"title"=>"TTG","logo"=>"ttg.png"],
            ["id"=>2,"title"=>"DTP","logo"=>"dtp_zone.jpg"],
            ["id"=>3,"title"=>"Europe","logo"=>"europe.png"],
            ["id"=>11,"title"=>"Columbus","logo"=>"columbus.jpg"]
        ];
        if(empty($map_data[$brand-1])){
            echo "This brand doesn't exists";
             die;
        }
        $data['title']=$map_data[$brand-1]["title"];
        $data['logo']=$map_data[$brand-1]["logo"];
        $data['brand']=$map_data[$brand-1]["id"];;
        $this->load->view('partials/header.php',$data);
        $this->load->view('external_vendor/register.php');
        $this->load->view('partials/footer.php');

    }
    public function doAddVendor(){
        // echo    "New Resource ...";
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['contact'] = $_POST['contact'];
        $data['country'] = $_POST['country'];
        $data['mother_tongue'] = $_POST['mother_tongue'];
        $data['profile'] = $_POST['profile'];
        $data['subject'] = implode(",", $_POST['subject']);
        $data['tools'] = implode(",", $_POST['tools']);
        if ($_FILES['cv']['size'] != 0)
        {
            $config['cv']['upload_path']          = './assets/uploads/vendors/';
            // $config['cv']['upload_path']          = '/var/www/html/assets/uploads/vendors/';
            $config['cv']['encrypt_name']         = TRUE;
            $config['cv']['allowed_types']  = 'zip|rar';
            $config['cv']['max_size']             = 10000;
            $config['cv']['max_width']            = 1024;
            $config['cv']['max_height']           = 768;
            $this->load->library('upload', $config['cv'], 'file_upload');
            if ( ! $this->file_upload->do_upload('cv'))
            {
                $error= $this->file_upload->display_errors();   
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);             
            }
            else
            {
                $data_file = $this->file_upload->data();
                $data['cv'] = $data_file['file_name'];
            }
        }
        ///
        if ($_FILES['certificate']['size'] != 0)
        {
            $config['certificate']['upload_path']          = './assets/uploads/certificate/';
            $config['certificate']['encrypt_name']         = TRUE;
            $config['certificate']['allowed_types']  = 'zip|rar';
            $config['certificate']['max_size']             = 10000;
            $config['certificate']['max_width']            = 1024;
            $config['certificate']['max_height']           = 768;
            $this->load->library('upload', $config['certificate'], 'file_upload');
            if ( ! $this->file_upload->do_upload('certificate'))
            {
                $error= $this->file_upload->display_errors();   
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);             
            }
            else
            {
                $data_file = $this->file_upload->data();
                $data['certificate'] = $data_file['file_name'];
            }
        }
        ////
        $data['brand'] = $_POST['brand'];
        $data['created_at'] = date("Y-m-d H:i:s");

        if($this->db->insert('vendor_request',$data)){
            $dataSheet['vendor'] = $this->db->insert_id();
            for ($i=0; $i < count($_POST['language-pair']); $i++) {
                $dataSheet['source_lang'] = $_POST['language-pair'][$i]['source_lang'];
                $dataSheet['target_lang'] = $_POST['language-pair'][$i]['target_lang'];
                $dataSheet['dialect'] = $_POST['language-pair'][$i]['dialect'];
                $dataSheet['service'] = $_POST['language-pair'][$i]['service'];
                $dataSheet['task_type'] = $_POST['language-pair'][$i]['task_type'];
                $dataSheet['unit'] = $_POST['language-pair'][$i]['unit'];
                $dataSheet['rate'] = $_POST['language-pair'][$i]['rate'];
                $dataSheet['special_rate'] = $_POST['language-pair'][$i]['special_rate'];
                $dataSheet['currency'] = $_POST['language-pair'][$i]['currency'];
                $dataSheet['created_at'] = date("Y-m-d H:i:s");
                if($this->db->insert('vendor_sheet_request',$dataSheet)){
                    
                }else{
                    $error = "Failed To Add Your Request...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);             
                }
            }
            $true = "Your Request Add Successfully...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);             
        }else{
            $error = "Failed To Add Your Request...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);  
        }       
        
    }
    public function getTaskType(){
        $service = $_POST['service'];
        $data = "<option disabled='disabled' value='' selected=''>-- Select Task Type --</option>";
        $data .= $this->admin_model->selectTaskType(0,$service);
        echo $data;
    }
    public function index(){
        $check = $this->admin_model->checkPermission($this->role,180);

        if($check){
             // header ..
             $data['group'] = $this->admin_model->getGroupByRole($this->role);
             $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,180);
             //body ..
             $data['user'] = $this->user;
             $data['brand'] = $this->brand;
             $filter['vr.brand =']=$this->brand;
             $filter['vsr.status =']=1;
             if(isset($_POST['search'])){
                if(!empty($_POST['date_from'])){
                     $filter['vr.created_at >=']=date("Y-m-d", strtotime($_REQUEST['date_from']));
                }
                if(!empty($_POST['date_to'])){
                    $filter['vr.created_at <=']=date("Y-m-d", strtotime($_REQUEST['date_to']));
                }
                if(!empty($_POST['request_id'])){
                    $filter['vr.id =']=$_POST['request_id'];
                }
                if(!empty($_POST['name'])){
                    $filter['vr.name LIKE '] = "%".$_POST['name']."%";
                }    
                if(!empty($_POST['email'])){
                    $filter['vr.email LIKE '] = "%".$_POST['email']."%";
                }   
                if(!empty($_POST['contact'])){
                    $filter['vr.contact LIKE '] = "%".$_POST['contact']."%";
                }  
                if(!empty($_POST['source_lang'])){
                    $filter['vsr.source_lang = '] = $_POST['source_lang'];
                }   
                if(!empty($_POST['target_lang'])){
                    $filter['vsr.target_lang = '] = $_POST['target_lang'];
                }
                if(!empty($_POST['status']) && $_POST['status']==3){
                    $filter['vsr.status =']=0;
                }      
             }
            
            $limit = 10;
            $offset = $this->uri->segment(3);
            if($this->uri->segment(3) != NULL)
            {
            $offset = $this->uri->segment(3);
            }else{
            $offset = 0;
            }
            $count = $this->vendor_model->AllExternalVendorCount($filter)->count;

            $config['base_url']= base_url('externalVendor');
            $config['uri_segment'] = 3;
            $config['display_pages']= TRUE;
            $config['per_page']  = $limit;
            $config['total_rows'] = $count;
            $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
            $config['cur_tag_close'] = "</li>";
            $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
            $config['next_tagl_close'] = "</span></li>";
            $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
            $config['prev_tagl_close'] = "</span></li>";
            $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
            $config['last_tagl_close'] = "</li>";
            $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
            $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
            $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
            $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
            $config['num_links'] = 5;
            $config['show_count'] = TRUE;
            $this->pagination->initialize($config); 
            $data['vendors'] = $this->vendor_model->AllExternalVendorsPages($filter,$limit,$offset);

            $data['filter']=$filter;
 
             // //Pages ..
             $this->load->view('includes_new/header.php',$data);
             $this->load->view('external_vendor/index.php');
             $this->load->view('includes_new/footer.php');
        }else{
            echo "You have no permission to access this page";
        }
    }
    public function action(){
      $RequestAction=$_POST['RequestAction'];
      foreach($_POST['approve_reject'] as $sheetid) {
          $sheet=$this->vendor_model->getExternalVendor($sheetid);
          if($RequestAction==1){
          $vendor=$this->vendor_model->getVendor($sheet->id);
          if(empty($vendor)){
                //add vendor request
                $vendordata['name']=$sheet->name;
                $vendordata['email']=$sheet->email;
                $vendordata['contact']=$sheet->contact;
                $vendordata['mother_tongue']=$sheet->mother_tongue;
                $vendordata['country']=$sheet->country;
                $vendordata['profile']=$sheet->profile;
                $vendordata['subject']=$sheet->subject;
                $vendordata['tools']=$sheet->tools;
                $vendordata['quality']="";
                $vendordata['communication']="";
                $vendordata['commitment']="";
                $vendordata['sheet_fields']="";
                $vendordata['sheet_tools']="";
                $vendordata['cv']=$sheet->cv;
                $vendordata['certificate']=$sheet->certificate;
                $vendordata['brand']=$sheet->brand;
                $vendordata['type']=1;
                $vendordata['status']=1;
                $vendordata['external_id']=$sheet->id;
                $vendordata['created_by']=$this->user;
                $vendordata['created_at'] = date("Y-m-d H:i:s");
               
                if($this->db->insert('vendor',$vendordata)){
                  $vendor_id=$this->db->insert_id();
                }else{
                    $error = "Failed To Accept Vendor Request...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url()."externalVendor");
                }
              
          }else{
              $vendor_id=$vendor->id;
          }
          // add sheet request
          $sheetdata['vendor']=$vendor_id;
          $sheetdata['dialect']=$sheet->dialect;
          $sheetdata['service']=$sheet->service;
          $sheetdata['task_type']=$sheet->task_type;
          $sheetdata['rate']=$sheet->rate;
          $sheetdata['special_rate']=$sheet->special_rate;
          $sheetdata['unit']=$sheet->unit;
          $sheetdata['currency']=$sheet->currency;
          $sheetdata['source_lang']=$sheet->source_lang;
          $sheetdata['target_lang']=$sheet->target_lang;
          $sheetdata['copied']=0;
          $sheetdata['created_by']=$this->user;
          $sheetdata['created_at'] = date("Y-m-d H:i:s");
          if(!$this->db->insert('vendor_sheet',$sheetdata)){
          $error = "Failed To Copied Vendor Sheet Request...";
          $this->session->set_flashdata('error', $error);
          redirect(base_url()."externalVendor");
          }
          $this->db->update('vendor_sheet_request',array('status'=>2),array('id'=>$sheetid));
          
          }else{
           //reject
           $this->db->update('vendor_sheet_request',array('status'=>0),array('id'=>$sheetid));
           $true = "Vendor Request Rejected Successfully ...";
           $this->session->set_flashdata('true', $true);
           redirect(base_url()."externalVendor");
          }
       }
       $true = "Vendor Request Accepted Successfully ...";
       $this->session->set_flashdata('true', $true);
       redirect(base_url()."externalVendor");
    }
}