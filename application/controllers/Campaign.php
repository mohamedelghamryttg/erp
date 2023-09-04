<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller {
    var $role,$user,$brand;

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Excelfile');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->brand = $this->session->userdata('brand');
        $this->user = $this->session->userdata('id');
    }

	public function sendCampaignEmail(){
    	//if($this->role == 1){
        
        // $config = Array(
        //'protocol' => 'smtp',
        //'smtp_host' => 'mail.thetranslationgate.com',
        //'smtp_port' => 465,
        //'smtp_user' => 'falaqsystem@thetranslationgate.com',
        //'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
        //'charset'=>'utf-8',
         //'validate'=>TRUE,
        //'wordwrap'=> TRUE,

        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
        'smtp_port' => 25,
        'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
        //'smtp_user' => 'root',
        'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
        'charset'=>'utf-8',
         'validate'=>TRUE,
        'wordwrap'=> TRUE,
	);
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $fileName= base_url().'assets/uploads/campaign/end_year.jpg';
      $this->email->attach($fileName);
      $cid = $this->email->attachment_cid($fileName);
        
        
        $customers = $this->db->get_where('customer_email',array('region'=>2,'sent'=>1))->result();
        foreach($customers as $row){
        	$mailTo = $row->email;
        	$subject = "Happy Holidays From The Translation Gate, LLC";
      		
        	
      $this->email->from($row->pm_email);
      $this->email->bcc('mohamed.elshehaby@thetranslationgate.com');
      
        // replace my mail by pm manger it is just for testing
      $this->email->to($mailTo);
    
      $this->email->subject($subject);
      	
        $msg = '<!DOCTYPE html>
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
                    }
                    </style>
                    <!--Core js-->
                </head>
                <body>
                	<p>Dear '.$row->name.',</p>
                    <p>As the end of the year is approaching with the lovely holidays season, The Translation Gate’s team is wishing you a happy and safe holiday with your families and beloved ones.</p>
                    <p>We’d be happy to take care of any project you have during the Christmas time from <a href="https://thetranslationgate.com/locations/">our new offices</a> with full capacity.<p>
                    <p>Find out more about our <a href="https://thetranslationgate.com/languages/">Languages that we support</a> and book your new project now.</p>
                    <p>
                    <a href="https://thetranslationgate.com/"><img src="cid:'. $cid .'" alt="photo1" /></a>
                	</p>
                    <p>From Your Team at The Translation Gate, LLC</p>
                    <p>Thanks,</p>
                </body>
                </html>';
            echo $msg;
      		$this->email->message($msg);
      		$this->email->set_header('Reply-To', $row->pm_email);
      		$this->email->set_mailtype('html');
      		$this->email->send();	
        }
        
        //}else{
        	//echo "You have no permission to access this page";
        //}
    }

	public function sendCampaignEmailTest(){
    
    $config = Array(
	'protocol' => 'smtp',
	'smtp_host' => 'mail.thetranslationgate.com',
	'smtp_port' => 465,
	'smtp_user' => 'falaqsystem@thetranslationgate.com',
	'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
	'charset'=>'utf-8',
	'validate'=>TRUE,
	'wordwrap'=> TRUE,
	);
	$this->load->library('email', $config);
	$this->email->set_newline("\r\n");
	
	$bee= base_url().'assets/uploads/campaign/bee.png';
    $this->email->attach($bee);
    $data['bee'] = $this->email->attachment_cid($bee);
    
    $logo= base_url().'assets/uploads/campaign/logo.png';
    $this->email->attach($logo);
    $data['logo'] = $this->email->attachment_cid($logo);
    
    $ss= base_url().'assets/uploads/campaign/ss.png';
    $this->email->attach($ss);
    $data['ss'] = $this->email->attachment_cid($ss);
    
    $feedback= base_url().'assets/uploads/campaign/feedback.jpeg';
    $this->email->attach($feedback);
    $data['feedback'] = $this->email->attachment_cid($feedback);
    
    
	$this->email->from("falaqsystem@thetranslationgate.com");
	$this->email->to("mohamed.elshehaby@thetranslationgate.com");
	// $this->email->cc("mohamed.elshehaby@thetranslationgate.com");
	$this->email->subject("test");  
	$message = $this->load->view('campaign/sendEmailTest.php',$data,TRUE);
    echo $message;
	$this->email->message($message);
	$this->email->set_header('Reply-To', "mohamed.elshehaby@thetranslationgate.com");
	$this->email->set_mailtype('html');
	$this->email->send();
    
    }
	
	public function sendCampaignEmailPhoto(){
    
    $config = Array(
	'protocol' => 'smtp',
	'smtp_host' => 'mail.thetranslationgate.com',
	'smtp_port' => 465,
	'smtp_user' => 'falaqsystem@thetranslationgate.com',
	'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
	'charset'=>'utf-8',
	'validate'=>TRUE,
	'wordwrap'=> TRUE,
	);
	$this->load->library('email', $config);
	$this->email->set_newline("\r\n");
	
	$cid= base_url().'assets/uploads/campaign/end_year.jpg';
    $this->email->attach($cid);
    $img = $this->email->attachment_cid($cid);
    
    
	$this->email->from("falaqsystem@thetranslationgate.com");
	$this->email->to("mohamed.elshehaby@thetranslationgate.com");
	// $this->email->cc("mohamed.elshehaby@thetranslationgate.com");
	$this->email->subject("Happy International Translation Day from The Translation Gate; Enjoy our limited-time offer now!");  
	$message = '<!DOCTYPE html>
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
                    }
                    </style>
                    <!--Core js-->
                </head>
                <body>
                	<p>Dear XXXX,</p>
                	<p><b>Happy International Translation Day from The Translation Gate; Enjoy our Limited- time offer now!</b></p>
                    <p>
                    <a href="https://thetranslationgate.com/international-translation-day-2021/"><img src="cid:'. $img .'" alt="photo1" /></a>
                	</p>
                </body>
                </html>';
    echo $message;
	$this->email->message($message);
	$this->email->set_header('Reply-To', "mohamed.elshehaby@thetranslationgate.com");
	$this->email->set_mailtype('html');
	$this->email->send();
    
    }
	
}
