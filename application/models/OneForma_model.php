<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth
*
* Author:  MOHAMED EL-SHEHABY
*
*/

class OneForma_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	} 
 

  function convert_number($number) {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }

        $Gn = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */

        $res = "";

        if ($Gn) {
            $res .= $this->convert_number($Gn) .  "Million";
        }

        if ($kn) {
            $res .= (empty($res) ? "" : " ") .$this->convert_number($kn) . "Thousand";
        }

        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .$this->convert_number($Hn) . "Hundred";
        }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= "and";
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;
    }

     public function AllOneFormaAccounts($filter){

        $data = $this->db->query(" SELECT * FROM `one_forma_accounts` WHERE ".$filter."  ORDER BY id ASC , id DESC ");
        return $data;
    }

    public function AllOneFormaAccountsPages($limit,$offset){
        $data = $this->db->query("SELECT * FROM `one_forma_accounts` ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function sendOneFormaAccountsMail($data,$pmIds){
        $pmsEmails_array = array();
        $pms_array =  explode(';', $pmIds);
            foreach ($pms_array as $item) {
                $pmMail = $this->db->get_where('users',array('id'=>$item))->row()->email;
                array_push($pmsEmails_array, $pmMail);
            } 
            $emailConfig = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.thetranslationgate.com',
            'smtp_port' => 465,
            'smtp_user' => 'falaqsystem@thetranslationgate.com',
            'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
            'charset'=>'utf-8',
            'validate'=>TRUE,
            'wordwrap'=> TRUE,
            ); 
              $this->load->library('email', $emailConfig);
              $this->email->set_newline("\r\n");
              $this->email->from("hagar.elbadry@thetranslationgate.com");
              $this->email->to("hagar.elbadry@thetranslationgate.com");
              $this->email->cc("mohamed.elshehaby@thetranslationgate.com");
              $this->email->subject("One Forma Accounts");
            //$this->email->bcc('mohamed.elshehaby@thetranslationgate.com');
       //  $mailTo= "hagar.elbadry@thetranslationgate.com";
       //  //$headers = "MIME-Version: 1.0" . "\r\n";
       // // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
       //  //$headers .= 'From: '.$mailTo."\r\n";
       //  //$headers .= "Cc: mohamed.elshehaby@thetranslationgate.com";
       //  $subject = "One Forma Accounts";
        $message .= '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="'.base_url().'assets/images/favicon.png">
                        <title>Falaq| Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        table{
                            border:1px solid black;
                        }
                        th{
                          border: 1px solid;
                        }
                        td {
                          border: 1px solid;
                        }
                        </style>
                        <!--Core js-->
                    </head>
               
                    <body> 
                    <p> Good day , <br> Please send this Aliases to The Attached PMs emails . <br>';
                    for($x = 0 ; $x <= count($pmsEmails_array) ; $x++ ){ 

                         $message .= '<p>'. $pmsEmails_array[$x].' </p>';
                        
                       }
                      
                    $message .= 'Thank you, <br> Dev Team </p> <br>

                     <table>
                     <thead> <tr><th> Emails </th></tr></thead>
                     <tbody>
                    ' ;
                     for($i = 0 ; $i <= count($data) ; $i++ ){ 

                         $message .= '<tr> <td> '. $data[$i].' </td></tr>';
                       }
                    $message .= '</tbody></table></html>';
                      
            // mail($mailTo,$subject,$message,$headers);
           
           
            $this->email->set_mailtype('html');
            $this->email->message($message);
            $this->email->send();          
            
    }
    public function selectOneFormaVendor($id=""){
        $vendors = $this->db->query("SELECT * FROM one_forma_accounts")->result();
        $data = "";
        foreach ($vendors as $vendor) {
            if ($vendor->id == $id) {
                $data .= "<option value='" . $vendor->id . "' selected='selected'>" . $vendor->email . "</option>";
            } else {
                $data .= "<option value='" . $vendor->id . "'>" . $vendor->email . "</option>";
            }
        }
        return $data;
    }
     public function getOneFormaVendorsEmails(){
            $result =$this->db->query("SELECT * FROM one_forma_accounts")->result();
            $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <th>Choose</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>';
           // $x = 1;
            foreach ($result as $row) {
               // if($x == 1){$radio = "required";}else{$radio = "";}
                        $data.=  '<tr class=""> 
                                <td><input type="checkbox" name="vendor_id" value="'.$row->id.'"></td>
                                <td>'.$row->email.'</td>
                            </tr>';
                   // $x++;
            }
            $data .= '</tbody></table>';
            echo $data;
      }
}