<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="'.base_url().'assets/images/favicon.png">
                        <title> Europe Localize | Site Manager</title>
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
                       <p>We hope this finds you safe and sound. </p>
                       <p>We would like to announce our upcoming system processes, as we are going to use a new portal called “Nexus” </p>
                       <p>In order to get our work process done through “Nexus” please follow the below steps</p>
                       <p>1<sup>st</sup> step : You need to create a new profile on Nexus</p>
                       <p>2<sup>nd</sup> : You will create your Initial username and password. Afterwards, you can definitely change your password.</p>
                       <p>3<sup>rd</sup> :  Profile contains all your data (job acquisition and acceptance, POS, created invoices)</p>
                       <p><b>Note :</b>  Any offline work is not taken into consideration. We only consider online work through the system, following the process explained up above.</p>
                       <p></p>
                       <p>Your Nexus account information is as follows:</p>
                       <p>Link: <a href="<?=$nexusLink?>"><?=$nexusLink?></a></p>
                       <p>Email: <?=$vendor->email?></p>
                       <p>Password: <?=base64_decode($vendor->password)?></p>
                       <p></p>
                       <p><b>After logging in, please change your password.</b></p>
                       <p></p>                      
                       <p>For more information on using the system, kindly check: <a href="<?=$nexusLink?>/home/instructions">Click Here</a></p>
                       <p>For any questions, feedbacks, or comments, we are always happy to hear from you. Please contact us at <a href="mailto:help@aixnexus.com">help@aixnexus.com</a></p>
                       <p>Thanks for your hard work on this. Please accept our deepest gratitude.</p>
                     
                    </body>
                    </html>