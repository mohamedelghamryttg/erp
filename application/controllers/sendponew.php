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
        'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
        'smtp_port' => 25,
        'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
        'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
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

    public function sendTTGTest($value='')
    {
        $pmMail = "mohamed.elshehaby@thetranslationgate.com";
        $subject = "Test New Ticket : #666666";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: ".$pmMail. "\r\n";
        $headers .= 'From: '.$pmMail."\r\n".'Reply-To: '.$pmMail."\r\n";
        $mailTo = " menna.ashour@thetranslationgate.com ";

        echo $message = '<!DOCTYPE html>
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
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear VM Team,</p>
                       <p> Please Check This New Ticket #6666666 </p>
                       <p>Created By :ddddddd</p>
                       <p> Thanks</p>
                    </body>
                    </html>';
        mail($mailTo,$subject,$message,$headers);
    }


}
?>
