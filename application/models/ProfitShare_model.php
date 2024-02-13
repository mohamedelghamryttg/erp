<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *
 * Author:  Sarah Thabit
 *
 */

class ProfitShare_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();        
    }

    // brands
    public function getEmpRegion($emp_id)
    {
        $data =  0;
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();       
        if(!empty($result)){ 
            $data = $result->region_id; 
        }        
        return $data;
    }  
    
    public function getNumOfBrandsServed ($emp_id)
    {
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();       
        if(!empty($result)){            
            if(str_contains($result->emp_brands, ',')){
                $brands = explode(',', $result->emp_brands); 
                $data = count($brands)-1;  
            }
            else{
                $data =  0;
            } 
        }        
        return $data;
    }  
    public function getIdsOfBrandsServed ($emp_id)
    {
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();       
        if(!empty($result)){            
            if(str_contains($result->emp_brands, ',')){
                $emp_brands = rtrim($result->emp_brands,', ');
                $brands = explode(',',$emp_brands);                
                $data = $brands;                               
            }
            else{
                $data =  0;
            } 
        }        
        return $data;
    }  
    
      // IF 
    public function checkIfPmStandAlone ($emp_id)
    {
        $data = false;
        $rows = $this->db->get_where('employees', array('manager' => $emp_id,'status'=>0,'department'=>12))->num_rows();
        if ($rows > 0) {
                $data = True;
        }
        return $data;
    } 
    
    public function getBrandsCoefficient ($emp_id,$value,$type)
    {
        $data = 0;
        $isTeamLeader = $this->profitShare_model->checkIfEmpIsSuperTeamLeader($emp_id);
        // if $type = 1 (support) / 2 = pm stand alone
        if($type == 1){
            if($isTeamLeader){
                $data = 1.6;
            }else{
                if($value == 1)
                        $data = 1.0;
                elseif($value == 2)
                        $data = 1.2;
                if($value == 3)
                        $data = 1.3;
                if($value == 4)
                        $data = 1.4;
            }
        }
        elseif($type == 2){
            $seniorPm = $this->profitShare_model->checkIfPmStandAlone($emp_id);
            if($isTeamLeader || $seniorPm ){
                if($value == 1)
                    $data = 1.3;
                elseif($value == 2)
                        $data = 1.5;
                if($value == 3)
                        $data = 1.7;
                if($value == 4)
                        $data = 2;
            }else{
                if($value == 1)
                        $data = 1.0;
                elseif($value == 2)
                        $data = 1.2;
                if($value == 3)
                        $data = 1.3;
                if($value == 4)
                        $data = 1.4;
            }
            
        }
        return $data;
    } 
    
    // hiring_date
    public function getPerOfHiringDate ($emp_id,$startDate,$endDate)
    {
        $result = $this->db->get_where('employees', array('id' => $emp_id))->row();       
        if(!empty($result)){ 
            if($result->status == 0){
                $hiring_date = $result->hiring_date;

                // get months
                $date1 = $hiring_date;
                $date2 = $endDate;
                $d1=new DateTime($date2); 
                $d2=new DateTime($date1);                                  
                $Months = $d2->diff($d1);
                if($date1 > $date2)
                    $data['numOfMonths'] = $NumOfMonths = 0;
                else
                    $data['numOfMonths'] = $NumOfMonths = (($Months->y) * 12) + ($Months->m)+ round((($Months->d)/30),1);
                //$data['numOfMonths'] = $Months->d;
                $NumOfMonthsAfterProb = $NumOfMonths - 3 ;
                if($NumOfMonthsAfterProb < 0)
                    $data['perOfHiring'] = 0;
                elseif($NumOfMonthsAfterProb > 6)
                    $data['perOfHiring'] = 1;
                else{
                    $data['perOfHiring'] = round(($NumOfMonthsAfterProb / 6),2) ;
                }
            }else{
                $resignation_date = $result->resignation_date; 
             
                // num of months
                $d11 = new DateTime($hiring_date); 
                $d12 = new DateTime($resignation_date);                                  
                $Months1 = $d12->diff($d11); 
                $NumOfMonths1 = (($Months1->y) * 12) + ($Months1->m)+ round((($Months1->d)/30),1);              
                if($NumOfMonths1 > 3){
                 // get months
                $date1 = $startDate;
                $date2 = $resignation_date;
                $d1=new DateTime($date2); 
                $d2=new DateTime($date1);                                  
                $Months = $d2->diff($d1);
                if($date1 > $date2)
                    $data['numOfMonths'] = $NumOfMonths = 0;
                else
                    $data['numOfMonths'] = $NumOfMonths = (($Months->y) * 12) + ($Months->m)+ round((($Months->d)/30),1);
               
                if($NumOfMonths > 6)
                    $data['perOfHiring'] = 1;
                else
                    $data['perOfHiring'] = round(($NumOfMonths / 6),2) ;
                }else{
                    $data['numOfMonths'] = $NumOfMonths = 0;
                    $data['perOfHiring'] = 0 ;
                }
                
            }
            
            return $data;
        }        
        
    }   
   
    public function getEmpSalaryByYear ($emp_id,$year)
    {
        $result = 0 ;
        if ($this->db->table_exists("emp_finance_$year") ){
            $row = $this->db->get_where("emp_finance_$year", array('emp_id' => $emp_id))->row();       
            if(!empty($row)){ 
                $result = $row->salary;            
            }            
        }
        return $result;               
        
    }
   
    // Employee Performance 
    public function getEmployeePerformanceMatrix ($emp_id,$startMonth,$endMonth,$year)
    {
        $yearID = $this->db->get_where('years', array('name' => $year))->row()->id;
        $score_data = $this->db->query("SELECT sum(score)/count(distinct(month)) as score_sum ,count(distinct(month)) as num_score_months FROM `kpi_score` Left Join `kpi_score_data` on `kpi_score_data`.kpi_score_id=`kpi_score`.id where month >= $startMonth AND month <= $endMonth AND year = $yearID AND emp_id = $emp_id")->row();
        if($score_data->score_sum){
            $data['score'] = $score = round($score_data->score_sum,2);
            $data['num_score_months'] = $score_data->num_score_months;
        }
        else{
            $data['num_score_months'] = $data['score'] = $score = 0; 
        }
        
        $data['empPerformance'] = self::perOfPerformanceMatrix($score);    
        
        return $data;
              
        
    }
    
    public function perOfPerformanceMatrix($score)
    {
        $result = 0;
        if ($score >= 0 && $score <= 50) {
            $result = 0;           
        } elseif ($score > 50 && $score <= 65) {
           $result = 0.5;   
        } elseif ($score > 65 && $score <= 80) {
           $result = 0.75;   
        } elseif ($score > 80 && $score <= 95) {
           $result = 1;   
        } elseif ($score > 95) {
            $result = 1.5;   
        }       
        return $result;

    }
    
    // Company Performance 
    public function brandPerformanceMatrix($score)
    {
        $result = 0;
        if ($score >= 0 && $score < 50) {
            $result = 0;
        } elseif ($score >= 50 && $score < 65) {
            $result = 40;
        } elseif ($score >= 65 && $score < 75) {
            $result = 60;
        } elseif ($score >= 75 && $score < 80) {
            $result = 75;
        } elseif ($score >= 80 && $score < 90) {
            $result = 90;
        } elseif ($score >= 90 && $score < 100) {
            $result = 100;
        } elseif ($score >= 100 && $score < 150) {
            $result = 125;
        } elseif ($score >= 150) {
            $result = 150;
        }
        return $result;
    }

    // company Target
    public function getBrandRegionTarget($year,$brand_id,$region_id)
    {
        $result = 0;
        $target = $this->db->get_where('company_target', array('year' => $year))->row();
        if(!empty($target)){
            $row = $this->db->get_where('company_target_details', array('target_id' => $target->id,'brand_id'=>$brand_id,'region_id'=>$region_id))->row();
            $result = $row->target;
        }
        return $result;
    }
    public function getBrandTargetContribution($year,$brand_id)
    {
        $result = 0;
        $target = $this->db->get_where('company_target', array('year' => $year))->row();
        if(!empty($target)){
            $brand_target = $this->db->query("SELECT sum(target) as brand_target FROM `company_target_details` WHERE target_id = $target->id AND brand_id = $brand_id")->row()->brand_target;
            $company_target = $this->db->query("SELECT sum(target) as company_target FROM `company_target_details` WHERE target_id = $target->id ")->row()->company_target;
            if($company_target != 0)
                $result = round(($brand_target/$company_target)*100);
        }
        return $result;
    }
    // Achieved 
    public function getBrandRegionAchieved($year,$brand_id,$region_id,$half)
    {
        $result = 0;
        $target = $this->db->get_where('company_target', array('year' => $year))->row();
        if(!empty($target)){
            $row = $this->db->get_where('company_target_details', array('target_id' => $target->id,'brand_id'=>$brand_id,'region_id'=>$region_id))->row();
            $name = "acheived_".$half;
            $result = $row->$name;
        }
        return $result;
    }
    // Achieved %
    public function getBrandRegionAchievedPer($year,$brand_id,$region_id,$half)
    {
        $result = 0;
        $target = $this->db->get_where('company_target', array('year' => $year))->row();
        if(!empty($target)){
            $row = $this->db->get_where('company_target_details', array('target_id' => $target->id,'brand_id'=>$brand_id,'region_id'=>$region_id))->row();
            if(!empty($row)){
                $name = "acheived_".$half;           
                $target = ($row->target)/2;
                $achieved = $row->$name;
                if($target != 0)
                    $result = round(($achieved/$target)*100);;
            }
        }
        return $result;
    }  
    
    public function getBrandAchievedPer($year,$brand_id,$half)
    {
        $result = 0;
        $target = $this->db->get_where('company_target', array('year' => $year))->row();
        if(!empty($target)){
            $brand_target = $this->db->query("SELECT sum(target) as brand_target FROM `company_target_details` WHERE target_id = $target->id AND brand_id = $brand_id")->row()->brand_target;
            $brand_acheived = $this->db->query("SELECT sum(acheived_$half) as brand_acheived FROM `company_target_details` WHERE target_id = $target->id AND brand_id = $brand_id")->row()->brand_acheived;
            if($brand_target != 0){
                $target = $brand_target/2;
                $result = round(($brand_acheived/$target)*100);
            }            
            
        }
        return $result;
    }
    
     // Achieved matrix
    public function getBrandRegionAchievedMatrix($year,$brand_id,$region_id,$half)
    {       
        $score = self::getBrandRegionAchievedPer($year,$brand_id,$region_id,$half);
        $result = self::brandPerformanceMatrix($score); 
        return $result;
    }
    
    public function getBrandAchievedMatrix($year,$brand_id,$half)
    {
        $score = self::getBrandAchievedPer($year,$brand_id,$half);
        $result = self::brandPerformanceMatrix($score); 
        return $result;
    }
    
    // calculate employee net profit
    public function getDepartmentProfitType($department){
        // if support or production
        if($department == 5 || $department == 6 || $department == 7 || $department == 8 || $department == 9
                || $department == 10 || $department == 13 || $department == 14 ||$department == 24){
            $data['type'] = 1;
            $data['equation']  = "(( Salary * Due vs. Hir * Emp Performance *  Brand Contribution * Brand Performance )+"
                    . "(Salary * Due vs. Hir * Emp Performance *  Brand Contribution * Brand Performance )+ "
                    . "(Salary * Due vs. Hir * Emp Performance *  Brand Contribution * Brand Performance  )+ "
                    . "(Salary * Due vs. Hir * Emp Performance *  Brand Contribution * Brand Performance  )) * Coefficient";
        }// pm & sam
        elseif($department == 11 || $department == 12 || $department == 16 || $department == 19){
            $data['type'] = 2;
            $data['equation']  = "(( Salary * Due vs. Hir * Emp Performance *  Brand Contribution * Brand Region Performance )* Coefficient";
        }else{
            $data['type'] = 0;
            $data['equation']  =""; 
        }
        return $data;
    }
    
    public function getEmployeeProfitShareAmount($emp_id,$year,$half,$profit_type){
        $total = 0;
        if($half == '1'){
            $startMonth = "01";
            $endMonth = "06";        
            $endDate = "$year-06-30";
            $startDate = "$year-01-01";
        }elseif ($half == '2') {
            $startMonth = "07";
            $endMonth = "12"; 
            $startDate = "$year-07-01";
            $endDate = "$year-12-31";
            
        }    
        
        // check if team leader
        $teamlaeder = self::checkIfEmpIsSuperTeamLeader($emp_id);
         // EmployeePerformanceMatrix  
        if($teamlaeder){
           $data['employeePerformanceData'] = $employeePerformanceData = self::getTeamLeaderperformance($emp_id,$half,$year);
           $employeePerformance = $employeePerformanceData['empPerformance'];
        }else{          
          $data['employeePerformanceData'] = $employeePerformanceData = self::getEmployeePerformanceMatrix ($emp_id,$startMonth,$endMonth,$year);
           $employeePerformance = $employeePerformanceData['empPerformance'];
        }        
        // salary
        $data['salary'] = $salary = self::getEmpSalaryByYear($emp_id,$year);
        // hiring date
        $data['hiringData'] = $hiringData = self::getPerOfHiringDate($emp_id,$startDate,$endDate);
        $hiring_data = $hiringData['perOfHiring'];
         // get num. of brands
        $data['brands_num'] = $brands_num = self::getNumOfBrandsServed($emp_id);
        $brands = self::getIdsOfBrandsServed($emp_id); 
            
        if($profit_type == 1){                   
            foreach ($brands as $val){            
                $brandContribution = self::getBrandTargetContribution($year,$val)/100;
                $brandPerformance = self::getBrandAchievedMatrix($year,$val,$half)/100;             
                $total += ($salary * $hiring_data * $employeePerformance  * $brandPerformance * $brandContribution); 
            }                  
            $team = $profit_type;
            $data['brandCoefficient'] = $brandCoefficient = $this->profitShare_model->getBrandsCoefficient($emp_id,$brands_num,$team);
            $total = $total * $brandCoefficient;
        }
        elseif($profit_type == 2){            
            $emp_region = self::getEmpRegion($emp_id);
            foreach ($brands as $val){ 
                $brandRegionPerformance = self::getBrandRegionAchievedMatrix($year,$val,$emp_region,$half);
                $total += ($salary * $hiring_data * $employeePerformance  * $brandRegionPerformance );    
            }
            $team = $profit_type;
            $data['brandCoefficient'] = $brandCoefficient = $this->profitShare_model->getBrandsCoefficient($emp_id,$brands_num,$team);
            $total = $total * $brandCoefficient;
        }
        $data['total'] = $total;
        return $data;
        
    }
    
        
    public function checkIfEmpIsSuperTeamLeader($emp_id)
    {  
        $employee = $this->db->get_where('employees', array('id' => $emp_id))->row();
        $manager_id = $employee->manager;
        if($manager_id == 13 || $manager_id ==14){
            return TRUE;
        } else {
            return FALSE;
        }
        
    }
    
    public function getSuperTeamLeaders()
    {  
        $employees = $this->db->query("SELECT id FROM `employees` WHERE status = 0 AND (manager = 13 ||  manager = 14 )")->result();
        return $employees;
    }    
    
     public function performanceMatrixArray()
    {
        $array =  ["Week Performance","Below Average Performance","Average Performance","Solid Performance","Exceeding Performance"];
       return $array ;
    }
    
     public function getTeamLeaderperformance($emp_id,$half,$year)
    {
        $array =  ["Week Performance","Below Average Performance","Average Performance","Solid Performance","Exceeding Performance"];
        $row = $this->db->get_where('kpi_teamleaders',array('emp_id'=>$emp_id,'year'=>$year,'half'=>$half))->row();
        if(!empty($row)){
            $score = $data['score_val'] = $row->score;
            $data['score'] = $array[$row->score];
            $data['num_score_months'] = 6;
            if ($score == 0) {
                $data['empPerformance']  = 0;           
            } elseif ($score == 1) {
               $data['empPerformance']  = 0.5;   
            } elseif ($score == 2) {
               $data['empPerformance']  = 0.75;   
            } elseif ($score == 3) {
               $data['empPerformance']  = 1;   
            } elseif ($score == 4) {
                $data['empPerformance']  = 1.5;   
            }  
        }else{
           $data['num_score_months'] = $data['empPerformance'] = $data['score'] =  $data['score_val'] = null ;
        }
        return $data ;
    }
    
    public function getEmployeeBonusAmount($emp_id,$year,$half){
        $result = 0;
        $row = $this->db->get_where('profitshare_bonus', array('year' => $year,'half'=>$half,'emp_id'=>$emp_id))->row();
        if(!empty($row)){
            $result = $row->amount;                    
        }
        return $result;
        
    }
    
}
