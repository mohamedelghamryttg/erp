<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Commission_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 

    public function AllRules($permission, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM `commission_setting` WHERE " . $filter . "  Order By `year` ASC,`month` DESC");
        } 
        return $data;
    }

    

  
   
}
