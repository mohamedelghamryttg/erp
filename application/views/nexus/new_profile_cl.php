<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="'.base_url().'assets/images/favicon.png">
                        <title>Columbuslang | Site Manager</title>
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
                    <p>Dear <?=$vendor->name?>,</p>
                       <p>We hope this finds you well and in good health. </p>
                       <p>Columbus Lang would like to announce the launch of our new system and the related processes; our new portal is now called “Nexus”. </p>
                       <p>The following steps will introduce the process and how to get our work done through “Nexus”; please see the below steps:</p>
                       <p><b>Step 1 :</b> You need to create a new profile on Nexus.</p>
                       <p><b>Step 2 :</b> You need to create your initial username and password. Your password can be changed later on.</p>
                       <p><b>Step 3 :</b> The profile includes all your data: Job Acquisition, Job Acceptance, Purchase Orders, and the Created Invoices.</p>
                       <p><b>N.B:</b>  Any offline work is not allowed. We only take into consideration the work completed online through Nexus following the process explained above.</p>
                       <p></p>
                       <p><b>Please find below your login credentials for your Nexus account:</b></p>
                       <p><b>Link:</b> <a href="<?=$nexusLink?>"><?=$nexusLink?></a></p>
                       <p><b>Email:</b> <?=$vendor->email?></p>
                       <p><b>Password:</b> <?=base64_decode($vendor->password)?></p>
                       <p></p>
                       <p><b>Please make sure to change your password after signing in.</b></p>
                       <p></p>                      
                       <p>For more information on using the system, kindly  <a href="<?=$nexusLink?>/home/instructions">Click Here</a></p>
                       <p>For any questions, feedbacks or comments, we are always glad to assist you. Please contact us at <a href="mailto:help@aixnexus.com">help@aixnexus.com</a></p>
                       <p>We sincerely appreciate your time and efforts.</p>
                     
                    </body>
                    </html>