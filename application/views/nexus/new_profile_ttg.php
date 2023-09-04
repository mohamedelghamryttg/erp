<!DOCTYPE html>
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
                    <p>Hello <?=$vendor->name?>,</p>
                       <p>Hope you’re doing well. </p>
                       <p>1<sup>st</sup> : We’d like to update you with our system process from now on :- </p>
                       <p>2<sup>nd</sup>: We will create a new profile for you on <b>Nexus</b></p>
                       <p>3<sup>rd</sup>: Initial username and password, and you can update your password later on</p>
                       <p>4<sup>th</sup>: Your profile will include all of your data (to receive and accept jobs, Pos, create the invoice)</p>
                       <p>5<sup>th</sup>: We will NOT consider any offline work, ONLY through the system as per the explained process above</p>
                       <p></p>
                       <p></p>
                       <p>Below is your account information on Nexus:-</p>
                       <p>Link: <a href="<?=$nexusLink?>"><?=$nexusLink?></a></p>
                       <p>Email: <?=$vendor->email?></p>
                       <p>Password: <?=base64_decode($vendor->password)?></p>
                       <p><b>KINDLY UPDATE YOUR PASSWORD ONCE YOU LOGGED IN!</b></p>
                       <p></p>
                       <p></p>
                       <p>For more instructions about Nexus: <a href="<?=$nexusLink?>/home/instructions">Click Here</a></p>
                       <p>If you have any questions or feedback ,We&#39;re always keen to hear from you and help you out via <a href="mailto:help@aixnexus.com">help@aixnexus.com</a></p>
                       <p>Thank you</p>
                     
                    </body>
                    </html>