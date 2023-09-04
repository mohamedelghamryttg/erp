<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendPO extends CI_Controller {
    var $role,$user,$brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){
        
        $mailTo = "ahmedvolks@gmail.com";
        // $mailTo = "mohamedtwins57@gmail.com";
        $subject = "Vendor VPO Test";
        
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'mail.thetranslationgate.com',
        'smtp_port' => 465,
        'smtp_user' => 'falaqsystem@thetranslationgate.com',
        'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
        'charset'=>'utf-8',
         'validate'=>TRUE,
        'wordwrap'=> TRUE,
        // 'dkim_domain' => 'thetranslationgate.com',
        // 'dkim_selector' => 'mail',

      );

      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
        
     $this->email->from("ahmed.reda@thetranslationgate.com");
      $this->email->cc("ahmed.reda@thetranslationgate.com");
    
    // $this->email->from("mohamed.elshehaby@thetranslationgate.com");
    //   $this->email->cc("mohamed.elshehaby@thetranslationgate.com");
      
      // replace my mail by pm manger it is just for testing
      $this->email->to($mailTo);
      $this->email->subject($subject);

            $msg="Test";
            //echo $msg;
            $this->email->message($msg);
              $this->email->set_header('Reply-To', $pmMail);
              $this->email->set_mailtype('html');
              $this->email->send();
    }
/*
    public function SendGmail(){
        
        $mailTo = "ahmedvolks@gmail.com";
        $subject = "Vendor VPO Test";
        
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'mohamedtwins57@gmail.com',
        'smtp_pass' => '@Twins2014',
        'charset'=>'utf-8',
         'validate'=>TRUE,
        'wordwrap'=> TRUE,
      );
    print_r($config);
    
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
        
      $this->email->from("ahmed.reda@thetranslationgate.com");
      $this->email->cc("ahmed.reda@thetranslationgate.com");
    
      
      // replace my mail by pm manger it is just for testing
      $this->email->to($mailTo);
      $this->email->subject($subject);

            $msg="Test";
            //echo $msg;
            $this->email->message($msg);
              $this->email->set_header('Reply-To', $pmMail);
              $this->email->set_mailtype('html');
              $this->email->send();
    }*/


}
?>