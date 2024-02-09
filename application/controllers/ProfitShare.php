<?php

defined('BASEPATH') or exit('No direct script access allowed');
/** 
 *
 * Author:  Sarah Thabit
 *
 */
class ProfitShare extends CI_Controller
{

    var $role, $user, $brand;

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
        $this->load->model('profitShare_model');
    }

    

    public function index()
    {
                             
         //  sam & pm   -- brand contr. ???
         //  stand alone pm title ??
         // wait employees brands & region & salary & teamleaders Coefficient??
         // employees with 0 status but date between 7 - 12 
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..           
           
            if (isset($_GET['search'])) {
                $data['year'] = $year = $_REQUEST['year'];
                $data['half'] = $half = $_REQUEST['half'];
                 if($half == '1'){
                    $startMonth = "01";
                    $endMonth = "06";        
                    $endDate = "$year-06-30";
                }elseif ($half == '2') {
                    $startMonth = "07";
                    $endMonth = "12";        
                    $endDate = "$year-12-31";
                }     
                $data['department'] = $department = $_REQUEST['department'];
                $profit_type = $this->profitShare_model->getDepartmentProfitType($department);
                $data['equation'] = $profit_type['equation'];
                $data['type'] = $type = $profit_type['type'];
                // start
                $employees =  $this->db->query("SELECT id,hiring_date,name FROM employees WHERE status = 0 AND department = $department ")->result(); 
                foreach($employees as $row){                 
                    
                    $profitShareData = $this->profitShare_model->getEmployeeProfitShareAmount($row->id,$year,$half,$type);
                   
                    $records[$row->id]['name'] = $row->name;
                    $records[$row->id]['hiring_date'] = $row->hiring_date;
                    $records[$row->id]['brands_num'] = $profitShareData['brands_num'];                  
                    $records[$row->id]['brands_Coefficient'] = $profitShareData['brandCoefficient']??0 ;
                    $records[$row->id]['hiring_months'] = $profitShareData['hiringData']['numOfMonths'];
                    $records[$row->id]['hiring_per'] = $profitShareData['hiringData']['perOfHiring'];
                    $records[$row->id]['avg_score'] = $profitShareData['employeePerformanceData']['score'];
                    $records[$row->id]['num_score_months'] = $profitShareData['employeePerformanceData']['num_score_months'];
                    $records[$row->id]['empPerformance'] = $profitShareData['employeePerformanceData']['empPerformance'];
                    $records[$row->id]['profit_amount'] = $profitShareData['total'];
                    $records[$row->id]['bonus_amount'] = $this->profitShare_model->getEmployeeBonusAmount($row->id,$year,$half);

                }
                $data['brands'] = $this->db->get_where('brand',array('id !='=>4))->result();
                $data['regions'] = $this->db->order_by("id", "desc")->get_where('regions',array('id !='=>4))->result();
           
                if(count($employees)>0)
                    $data['records'] = $records;
            }
           
        // pages
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/index.php');
            $this->load->view('includes_new/footer.php');
               
        } else {
            echo "You have no permission to access this page";
        }
        
    }
    
    

    // Config
        // Target
    public function settings()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..      
            if (isset($_GET['search'])) {
                if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];                
                    if (!empty($year)) {
                        $data['year']=$year;
                         $data['targets'] = $this->db->get_where('company_target',array('year'=>$year))->result();
                    }
                    else{
                        $data['targets'] = $this->db->get('company_target')->result();
                    }
                }
            }else{
                $data['targets'] = $this->db->get('company_target')->result();
            }
            
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/allSettings.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
     public function addProfitShareSettings()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..           
            $data['edit'] = 0;
            $data['card_title'] = "<i class='fa fa-pen-alt mr-2 text-danger'></i> Add New Target";
            $data['brands'] = $this->db->get_where('brand',array('id !='=>4))->result();
            $data['regions'] = $this->db->order_by("id", "desc")->get_where('regions',array('id !='=>4))->result();
          
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/targetForm.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
     public function editProfitShareSettings()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..            
            $data['edit'] = 1;
            $data['card_title'] = "<i class='flaticon2-pen mr-2 text-danger'></i> Edit Target";
            $data['id']  = $_GET['t'];
            $id = base64_decode($_GET['t']);
            $data['brands'] = $this->db->get_where('brand',array('id !='=>4))->result();
            $data['regions'] = $this->db->order_by("id", "desc")->get_where('regions',array('id !='=>4))->result();
            $data['row'] = $this->db->get_where('company_target', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/targetForm.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function saveProfitShareSettings()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($permission->add == 1) {
            // check if alredy exists 
            $check = $this->db->get_where('company_target', array('year' => $_POST['year']))->num_rows();
            if ($check == 0) { 
                $sqlArray = array();
                $data['year'] = $_POST['year'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('company_target', $data)) {                    
                    $target_id = $this->db->insert_id();
                    $brands = $this->db->get_where('brand',array('id !='=>4))->result();
                    $regions = $this->db->get_where('regions',array('id !='=>4))->result();
                    foreach ($brands as $x) {
                        foreach ($regions as $y) {
                            $input_name = $x->id."_".$y->id;
                            $data2["target_id"] = $target_id;
                            $data2["brand_id"] = $x->id;
                            $data2["region_id"] = $y->id;
                            $data2["target"] = $_POST["target_$input_name"] ?? null; 
                            array_push($sqlArray, $data2);
                        }  
                    }   
                    $this->db->insert_batch('company_target_details', $sqlArray);
                    $true = "Data Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProfitShare/Settings");
                } else {
                    $error = "Failed To Add Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Target Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }    
    public function updateProfitShareSettings()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($permission->edit == 1) {
            // check if alredy exists 
            $id = base64_decode($_POST['id']);
            $target_id = $_POST['id'];
            $check = $this->db->get_where('company_target', array('id !=' => $id,'year' => $_POST['year']))->num_rows();
            if ($check == 0) {
                $data['year'] = $_POST['year'];
                $data['updated_by'] = $this->user;
                $data['updated_at'] = date("Y-m-d H:i:s");
                if ($this->db->update('company_target', $data, array('id' => $id))) {
                    $brands = $this->db->get_where('brand',array('id !='=>4))->result();
                    $regions = $this->db->get_where('regions',array('id !='=>4))->result();
                    foreach ($brands as $x) {   
                        foreach ($regions as $y) {
                            $input_name = $x->id."_".$y->id;
                            $data2["target"] = $_POST["target_$input_name"] ?? null; 
                            $this->db->update('company_target_details', $data2, array('target_id' => $id,'brand_id'=>$x->id,'region_id'=>$y->id));
                        } 
                    } 
                    $true = "Data Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "ProfitShare/targetReport?t=$target_id");
                } else {
                    $error = "Failed To Update Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Target Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    
    //  Achieved 
    public function targetReport()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..       
           
            $data['brands'] = $this->db->get_where('brand',array('id !='=>4))->result();
            $data['regions'] = $this->db->order_by("id", "desc")->get_where('regions',array('id !='=>4))->result();
           
            $data['id']  = $_GET['t'];
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('company_target', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/targetReport.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }    
    public function editProfitAchieved()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..            
            $data['edit'] = 1;
            $data['card_title'] = "<i class='flaticon2-pen mr-2 text-danger'></i> Edit Achieved Per Region / Per Brand";
            $data['id']  = $_GET['t'];
            $id = base64_decode($_GET['t']);
            $data['brands'] = $this->db->get_where('brand',array('id !='=>4))->result();
            $data['regions'] = $this->db->order_by("id", "desc")->get_where('regions',array('id !='=>4))->result();
            $data['row'] = $this->db->get_where('company_target', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/editAchieved.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }    
    public function updateProfitAchieved()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($permission->edit == 1) {
            // check if alredy exists 
            $id = base64_decode($_POST['id']);
            $target_id = $_POST['id'];
            $check = $this->db->get_where('company_target', array('id !=' => $id,'year' => $_POST['year']))->num_rows();
            if ($check == 0) {                
                $data['updated_by'] = $this->user;
                $data['updated_at'] = date("Y-m-d H:i:s");
                if ($this->db->update('company_target', $data, array('id' => $id))) {
                    $brands = $this->db->get_where('brand',array('id !='=>4))->result();
                    $regions = $this->db->get_where('regions',array('id !='=>4))->result();                    
                    foreach ($brands as $x) {   
                        foreach ($regions as $y) {
                            $input_name = $x->id."_".$y->id;
                            $data2["acheived_1"] = $_POST["acheived_$input_name"][1]; 
                            $data2["acheived_2"] = $_POST["acheived_$input_name"][2]; 
                            $this->db->update('company_target_details', $data2, array('target_id' => $id,'brand_id'=>$x->id,'region_id'=>$y->id));
                        } 
                    }                     
                    $true = "Data Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "profitShare/targetReport?t=$target_id");
                } else {
                    $error = "Failed To Update Data ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Target Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }   
    
    public function addTeamLeadersKpis()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..              
            $data['id']  = $_GET['t'];
            $id = base64_decode($_GET['t']);
            $data['employees'] = $this->profitShare_model->getSuperTeamLeaders();            
            $data['performanceMatrixArray'] = $this->profitShare_model->performanceMatrixArray();            
            $data['row'] = $this->db->get_where('company_target', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/addTeamLeadersKpis.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }    
    public function updateTeamLeadersKpis()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($permission->edit == 1) {            
            $id = base64_decode($_POST['target_id']);
            $target_id = $_POST['target_id'];
            $target = $this->db->get_where('company_target', array('id' => $id))->row();
            $data['year'] = $target->year;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            foreach ($_POST['emp_id'] as $emp_id){
                $data['emp_id'] = $emp_id;
                for($i =1 ;$i<=2;$i++){
                    $score_half = "score$i"."_$emp_id";                    
                    $data['half'] = $i;
                    if(isset($_POST["$score_half"])){
                        $data['score'] = $_POST[$score_half];
                        $check = $this->db->get_where('kpi_teamleaders',array('emp_id'=>$emp_id,'year'=>$data['year'],'half'=>$i))->row();
                        if(!empty($check)){
                            $this->db->update('kpi_teamleaders', $data, array('id' => $check->id));
                        }else{
                            $this->db->insert('kpi_teamleaders', $data);
                        }
                    }
                }
                             
            }
                             
            $true = "Data Updated Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "ProfitShare/Settings");
                
            
        } else {
            echo "You have no permission to access this page";
        }
    }
    
    public function viewRecord()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..     
            $data['year'] = $year = base64_decode($_GET['y']);
            $data['half'] = $half = base64_decode($_GET['h']);
            if($half == '1'){
                $startMonth = "01";
                $endMonth = "06";        
                $endDate = "$year-06-30";
            }elseif ($half == '2') {
                $startMonth = "07";
                $endMonth = "12";        
                $endDate = "$year-12-31";
            }  
                
            $data['emp_id'] = $emp_id = base64_decode($_GET['t']);
            
            $data['brands'] = $this->db->get_where('brand',array('id !='=>4))->result();
            $data['regions'] = $this->db->order_by("id", "desc")->get_where('regions',array('id !='=>4))->result();
           
            $row =  $this->db->query("SELECT id,hiring_date,name,department,emp_brands FROM employees WHERE status = 0 AND id = $emp_id ")->row();     
            $data['emp_brands'] =  $row->emp_brands;
            $data['department'] = $department = $row->department;
            $profit_type = $this->profitShare_model->getDepartmentProfitType($department);
            $data['equation'] = $profit_type['equation'];
            $data['type'] = $type = $profit_type['type'];
                
            $profitShareData = $this->profitShare_model->getEmployeeProfitShareAmount($emp_id,$year,$half,$type);                   
            $record['name'] = $row->name;
            $record['hiring_date'] = $row->hiring_date;
            $record['brands_num'] = $profitShareData['brands_num'];                  
            $record['brands_Coefficient'] = $profitShareData['brandCoefficient'] ;
            $record['hiring_months'] = $profitShareData['hiringData']['numOfMonths'];
            $record['hiring_per'] = $profitShareData['hiringData']['perOfHiring'];
            $record['avg_score'] = $profitShareData['employeePerformanceData']['score'];
            $record['num_score_months'] = $profitShareData['employeePerformanceData']['num_score_months'];
            $record['empPerformance'] = $profitShareData['employeePerformanceData']['empPerformance'];
            $record['salary'] = $profitShareData['salary'];
            $record['profit_amount'] = $profitShareData['total'];
            $data['bonus_amount'] = $this->profitShare_model->getEmployeeBonusAmount($emp_id,$year,$half);

            $data['record'] = $record;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('profitShare/viewRecord.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    } 
    
    
    public function addEmpBonus(){
     // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 244);
        if ($permission->add == 1) {            
            $data['year'] = $year = base64_decode($_POST['year']);
            $data['half'] = $half = base64_decode($_POST['half']);
            $data['emp_id'] = $emp_id = base64_decode($_POST['emp_id']); 
            $data['amount'] = $_POST['amount']; 
            //check
            $check = $this->db->get_where('profitshare_bonus', array('year' => $year,'half'=>$half,'emp_id'=>$emp_id))->num_rows();
            if(!empty($check)){
                $data['updated_by'] = $this->user;
                $data['updated_at'] = date("Y-m-d H:i:s");
                if($this->db->update('profitshare_bonus', $data, array('year' => $year,'half'=>$half,'emp_id'=>$emp_id))){
                     $true = "Data Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                }
            }else{
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('profitshare_bonus', $data)) {
                    $true = "Data Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);                    
                } 
            }
            redirect($_SERVER['HTTP_REFERER']);
           
        } else {
            echo "You have no permission to access this page";
        }
    }
}
