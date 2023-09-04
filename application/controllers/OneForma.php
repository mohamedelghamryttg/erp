<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OneForma extends CI_Controller {
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

    public function oneFormaAccounts(){
    $check = $this->admin_model->checkPermission($this->role,179);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,179);
            //body ..
            $data['user'] = $this->user;
           if(isset($_GET['search'])){
                $arr2 = array();
                if(isset($_REQUEST['email'])){
                    $email = $_REQUEST['email'];
                    if(!empty($email)){ array_push($arr2,0); }
                }else{
                    $email = "";
                }
                if(isset($_REQUEST['username'])){
                    $username = $_REQUEST['username'];
                    if(!empty($username)){ array_push($arr2,1); }
                }else{
                    $username = "";
                }
                if(isset($_REQUEST['language'])){
                    $language = $_REQUEST['language'];
                    if(!empty($language)){ array_push($arr2,2); }
                }else{
                    $language = "";
                }
               
               
                $cond1 = "email LIKE '%$email%'"; 
                $cond2 = "username LIKE '%$username%'"; 
                $cond3 = "language LIKE '%$language%'";            
                
               
                $arr1 = array($cond1,$cond2,$cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
            // print_r($arr4);     
                if($arr_1_cnt > 0){
                    $data['accounts'] = $this->OneForma_model->AllOneFormaAccounts($arr4);
               }else{
                    $data['accounts'] = $this->OneForma_model->AllOneFormaAccountsPages(9,0);
                }
                $data['total_rows'] = $data['accounts']->num_rows();
        }else{
            $limit = 9;
            $offset = $this->uri->segment(3);
            if($this->uri->segment(3) != NULL)
            {
                $offset = $this->uri->segment(3);
            }else{
                $offset = 0;
            }
              $count = $this->OneForma_model->AllOneFormaAccounts(1)->num_rows();
              $config['base_url']= base_url('oneForma/oneFormaAccounts');
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
             $data['accounts'] = $this->OneForma_model->AllOneFormaAccountsPages($limit,$offset);
             $data['total_rows'] = $count;
             }
            //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('oneForma/oneFormaAccounts.php');
            $this->load->view('includes_new/footer.php');
        }else{
            echo "You have no permission to access this page";
        } 
     } 
    
// public function oneFormaAccounts(){
//         // Check Permission ..
//         $check = $this->admin_model->checkPermission($this->role,179);
//         if($check){
//             //header ..
//             $data['group'] = $this->admin_model->getGroupByRole($this->role);
//             $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,179);
//             //body ..
//             $data['accounts'] = $this->db->query(" SELECT * FROM `one_forma_accounts` ORDER BY id DESC ");
//             //Pages ..

//             $this->load->view('includes_new/header.php',$data);
//             $this->load->view('oneForma/oneFormaAccounts.php');
//             $this->load->view('includes_new/footer.php');
//         }else{
//             echo "You have no permission to access this page";
//         } 
//     }
   

    public function addOneFormaAccounts(){
          // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,179);
        if($data['permission']->add == 1){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
             
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('oneForma/addOneFormaAccounts.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        } 
    }
    public function doAddOneFormaAccounts(){
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role,179);
        if($permission->add == 1){
            $initial = $_POST['initial'];
            $data['password'] = $_POST['password'];
            $data['country'] = $_POST['country'];
            $data['language'] = $_POST['language'];
            $start = $_POST['num_from'];
            $end = $_POST['num_to'];
            $data['redirect_to'] = implode(";", $_POST['redirect_to']);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s"); 
            $sqlArray = array();
            $emailArray = array();
           for($i = $start ; $i <= $end ; $i++){
             $numberToWord = $this->OneForma_model->convert_number($i);
             $data['first_name'] = $initial.'_'.$numberToWord;
             $data['last_name'] = $initial.'_'.$numberToWord ;
             $data['username'] = $initial.'_'.$numberToWord ;
             $data['email'] = $initial.'_'.$numberToWord.'@thetranslationgate.com' ; 
            
             array_push($sqlArray, $data); 
             array_push($emailArray, $data['email']);
           }
           //print_r($emailArray);
           //  $this->OneForma_model->sendOneFormaAccountsMail($emailArray,$data['redirect_to']);
           // exit();
            if($this->db->insert_batch('one_forma_accounts',$sqlArray)){
               $this->OneForma_model->sendOneFormaAccountsMail($emailArray,$data['redirect_to']);
                $true = "Records Added Successfully ..."; 
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."oneForma/oneFormaAccounts");
            }else{
                $error = "Failed To Add  ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."oneForma/oneFormaAccounts");
            }
        }else{
            echo "You have no permission to access this page";
        }  
    }

     public function editOneFormaAccounts(){
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,179);
        if($data['permission']->add == 1){
             $data['group'] = $this->admin_model->getGroupByRole($this->role);
             $data['id'] =base64_decode($_GET['i']);
             $data['row'] = $this->db->get_where('one_forma_accounts',array('id'=>$data['id']))->row();
            $this->load->view('includes_new/header.php',$data);
            $this->load->view('oneForma/editOneFormaAccounts.php');
            $this->load->view('includes_new/footer.php'); 
        }else{
            echo "You have no permission to access this page";
        }  
    }
    public function doEditOneFormaAccounts(){
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,179);
        if($check){
              $id = base64_decode($_POST['id']);
              $data['first_name'] = $_POST['first_name'];
              $data['last_name'] = $_POST['last_name'];
              $data['username'] = $_POST['username'];
              $data['email'] = $_POST['email'];
              $data['password'] = $_POST['password'];
              $data['country'] = $_POST['country'];
              $data['language'] = $_POST['language'];
              $data['redirect_to'] = implode(";", $_POST['redirect_to']);
              $data['created_by'] = $this->user;
              $data['created_at'] = date("Y-m-d H:i:s"); 
              $referer = $_POST['referer'];
             $this->admin_model->addToLoggerUpdate('one_forma_accounts',179,'id',$id,0,0,$this->user);
             if($this->db->update('one_forma_accounts',$data,array('id'=>$id))){
                    $true = "Record updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                     if(!empty($referer)){
                        redirect($referer);
                    }else{
                        redirect(base_url()."oneForma/oneFormaAccounts");   
                       }
               }else{
                $error = "Failed To update record ...";
                $this->session->set_flashdata('error', $error);
                 if(!empty($referer)){
                        redirect($referer);
                 }else{
                        redirect(base_url()."oneForma/oneFormaAccounts");   
                 }
            }
        }else{
            echo "You have no permission to access this page";
        }  
    } 
    public function deleteOneFormaAccounts($id){
         // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role,179);
        if($check){
            $id = base64_decode($_GET['i']);
            $this->admin_model->addToLoggerDelete('one_forma_accounts',179,'id',$id,0,0,$this->user);
            if($this->db->delete('one_forma_accounts',array('id' =>$id))){
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url()."oneForma/oneFormaAccounts");
            }else{
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url()."oneForma/oneFormaAccounts");
            }
        }else{
            echo "You have no permission to access this page";
        }
    } 


    public function exportOneFormaAccounts(){
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=OneFormaAccounts.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
       $check = $this->admin_model->checkPermission($this->role,179);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,179);
            //body ..
            $data['user'] = $this->user;
                $arr2 = array();
                if(isset($_REQUEST['email'])){
                    $email = $_REQUEST['email'];
                    if(!empty($email)){ array_push($arr2,0); }
                }else{
                    $email = "";
                }
                if(isset($_REQUEST['username'])){
                    $username = $_REQUEST['username'];
                    if(!empty($username)){ array_push($arr2,1); }
                }else{
                    $username = "";
                }
                if(isset($_REQUEST['language'])){
                    $language = $_REQUEST['language'];
                    if(!empty($language)){ array_push($arr2,2); }
                }else{
                    $language = "";
                }
               
               
                $cond1 = "email LIKE '%$email%'"; 
                $cond2 = "username LIKE '%$username%'"; 
                $cond3 = "language LIKE '%$language%'";            
                
               
                $arr1 = array($cond1,$cond2,$cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for($i=0; $i<$arr_1_cnt; $i++ ){
                array_push($arr3,$arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ",$arr3);
                if($arr_1_cnt > 0){
                    $data['accounts'] = $this->OneForma_model->AllOneFormaAccounts($arr4);
                 }else{
                    $data['accounts'] = $this->OneForma_model->AllOneFormaAccountsPages(9,0);
                }
       
            $this->load->view('oneForma/exportOneFormaAccounts.php',$data);
        }else{
            echo "You have no permission to access this page";
        } 
    }
    
  //

}?> 