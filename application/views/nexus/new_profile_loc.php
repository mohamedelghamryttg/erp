<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="'.base_url().'assets/images/favicon.png">
                        <title>Localizera | Site Manager</title>
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
                    <p>Hello <?=$vendor->name?>,</p>
                       <p>We hope this email finds you well and safe. </p>
                       <p>We would like to announce the launch of Localizera’s new system “Nexus” and the respected processes. </p>
                       <p>We will pave the way for you and share the required steps to complete our work on “Nexus; kindly attend to the following steps: </p>
                       <p><b>•	First Step:</b> You must create a new profile on Nexus.</p>
                       <p><b>•	Second Step:</b> You must create the initial username and password. You can update or change your password in the future.</p>
                       <p><b>•	Third Step:</b> The profile contains your data like Job Acquisition, Job Acceptance, Purchase Orders, and the Created Invoices.</p>
                       <p><b>Note: </b> <br/>It is not permitted to perform any offline work. We take into account only the work completed online via Nexus following the process raised above.</p>
                       <p></p>
                       <p><b>You may find below your login details for your Nexus account:</b></p>
                       <p><b>Link:</b> <a href="<?=$nexusLink?>"><?=$nexusLink?></a></p>
                       <p><b>Email:</b> <?=$vendor->email?></p>
                       <p><b>Password:</b> <?=base64_decode($vendor->password)?></p>
                       <p></p>
                       <p><b>Kindly update your password after signing in.</b></p>
                       <p></p>                      
                       <p>For more information on how to navigate Nexus, please check out this link <a href="<?=$nexusLink?>/home/instructions">Click Here</a></p>
                       <p>For any questions, feedbacks or comments, we are always available to assist you, and you may contact us at <a href="mailto:help@aixnexus.com">help@aixnexus.com</a></p>
                       <p>Thank you so much for your time and attention. Much appreciated.</p>
                     
                    </body>
                    </html>