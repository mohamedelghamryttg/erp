<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth
*
* Author:  Ahmed Refaat
*
*/

class ExternalVendor_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


 
    public function AllExternalVendorCount($filter)
    {
        return $this->db->select('count(*) as count')->from('vendor_request as vr')
        ->join('vendor_sheet_request AS vsr', 'vsr.vendor = vr.id')->where($filter)->get()->row();
    }
 
    public function AllExternalVendorsPages($filter,$limit,$offset)
    {
        $query=$this->db->select('vr.*,vsr.id AS sheetid,slang.name as source_lang,tlang.name as target_lang,vsr.dialect,s.name as service_name,
                                  t.name as task_type_name,vsr.rate,vsr.special_rate,u.name as unit_name,currency.name as currency_name,
                                  countries.name as country_name')->from('vendor_request as vr')
                        ->join('vendor_sheet_request AS vsr', 'vsr.vendor = vr.id')->join('currency', 'vsr.currency = currency.id')
                        ->join('languages AS slang', 'vsr.source_lang = slang.id')->join('languages AS tlang', 'vsr.target_lang = tlang.id')
                        ->join('services AS s', 'vsr.service = s.id')->join('task_type AS t', 'vsr.task_type = t.id')->join('unit AS u', 'vsr.unit = u.id')
                        ->join('countries','vr.country=countries.id')->where($filter);
        if($limit!=0){
            return $query->order_by('vr.id', 'DESC')->limit($limit,$offset)->get();
        }
        else{
            return $query->order_by('vr.id', 'DESC')->get();
        }
    }
    public function getExternalVendor($sheet_id)
    {
        return $this->db->select('vr.*,vsr.id AS sheetid,vsr.source_lang,vsr.target_lang,vsr.dialect,vsr.service,vsr.task_type,vsr.rate,vsr.special_rate,vsr.currency,vsr.status,vsr.unit')->from('vendor_request as vr')
                        ->join('vendor_sheet_request AS vsr', 'vsr.vendor = vr.id')->where("vsr.id",$sheet_id)->get()->row();
        
    }
    public function getVendor($external_vendor)
    {
        return $this->db->select('id')->from('vendor')->where("external_id",$external_vendor)->get()->row();
        
    }







}
?>