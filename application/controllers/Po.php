<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po extends CI_Controller {
    var $role,$user,$brand;

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }
    
    public function download(){
        if(isset($_GET['t'])){
            $id = base64_decode($_GET['t']);
			
            $data['row'] = $this->projects_model->getTaskData($id);
            if(isset($data['row']->job_id)){
                $data['job'] = $this->projects_model->getJobData($data['row']->job_id);
                $data['jobPrice'] = $this->projects_model->getJobPriceListData($data['job']->price_list);
                $project = $this->projects_model->getProjectData($data['job']->project_id);
                $brand = $this->db->get_where('customer',array('id'=>$project->customer))->row()->brand;
                if($brand == 1){
                    $this->load->view('projects/vpoPage.php',$data);
                }else if($brand == 3){
                    $this->load->view('projects/vpoPageEurope.php',$data);
                }else if($brand == 2){
                    $this->load->view('projects/vpoPageDTP.php',$data);
                }
            }else{
                echo "Sorry, Page Not Found";
            }
        }else{
            echo "Sorry, Page Not Found";
        }
    }
}
?>