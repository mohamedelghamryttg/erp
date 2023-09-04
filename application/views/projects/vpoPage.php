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

<body onload="javascript:window.print();">
<div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="btn-group">
                            <span class=" btn-primary" style="">
                            </span>
                        </div>
                        
                    </div>
                    
                    <div class="space15"></div>
                    
                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                        <tbody>
                            <tr>
                                 <td style="font-size:bold;"><img src="<?=base_url()?>assets/images/logo_ar.png" alt="" style="width:50%;"></td>
                                 <td><p>3A Almashtal st, Taksim Elshishiny Corniche El-Nil,</p><p>Maadi, Cairo 11511 - EGYPT </p> Tel: +202 2528 1190 </p><p> Fax: +202 2528 3816 info@thetranslationgate.com </p> <p>www.thetranslationgate.com<p></td>
                            </tr>
                            <tr>
                                 <td colspan=2 style="background-color: #ffff06;color:#ff0606;text-align:left;font-size:18px;">
                                    <p>Dear our valued Vendor, please take into consideration the below conditions:</p>
                                    <p>• Payments will be processed within 45 to 60 days from date of receiving your invoice by 
                                    accountspayable@thetranslationgate.com.</p>
                                    <p>• Once you submit your work to our PM, please send your invoice along with the PO number received
                                    from our PM via email to accountspayable@thetranslationgate.com.</p>
                                    <p>• The company is not responsible for any payment delay due to sending the invoice to the incorrect 
                                    contact/person, The invoice must be sent to: accountspayable@thetranslationgate.com.</p>
                                    <p>• If any delay from your side to send your invoice once you finished the work, so it is not the company's 
                                    responsibility, and the normal duration paymnet will be applied "45 to 60 days from date of receiving your late invoice".</p> 
                                    <p>• PLEASE DO NOT SEND your invoice to the Project/Vendor Manager. Invoices MUST ONLY be sent to accountspayable@thetranslationgate.com, if you wish you can keep the PM cced. </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                        <tbody>
                           <tr>
                            <td colspan=2 style="background-color: #622422;color: white;">PO</td>
                            <td colspan=2 style="background-color:#fc6;color: black;"><?=$row->code?></td>
                           </tr>
                           <tr>
                            <td style="background-color: #622422;color: white;">Project Manager</td>
                            <td style="background-color:#fc6;color: black;"><?=$this->admin_model->getAdmin($row->created_by)?></td>
                            <td style="background-color: #622422;color: white;">PO Date</td>
                            <td style="background-color:#fc6;color: black;"><?=$row->delivery_date?></td>
                           </tr>
                           <tr>
                            <td style="background-color: #622422;color: white;">Service</td>
                            <td style="background-color:#fc6;color: black;"><?=$this->admin_model->getServices($jobPrice->service)?></td>
                            <td style="background-color: #622422;color: white;">Vendor Name</td>
                            <td style="background-color:#fc6;color: black;"><?=$this->vendor_model->getVendorName($row->vendor)?></td>
                           </tr>
                           <tr>
                           <td style="background-color: #622422;color: white;">Source</td>
                            <td style="background-color:#fc6;color: black;"><?=$this->admin_model->getLanguage($jobPrice->source)?></td>
                            <td style="background-color: #622422;color: white;">Vendor Email</td>
                            <td style="background-color:#fc6;color: black;"><?=$this->vendor_model->getVendorData($row->vendor)->email?></td>
                           </tr>
                           <tr>
                           <td style="background-color: #622422;color: white;">Target</td>
                            <td style="background-color:#fc6;color: black;"><?=$this->admin_model->getLanguage($jobPrice->target)?></td>
                            <td style="background-color: #622422;color: white;">Contact Person</td>
                            <td style="background-color:#fc6;color: black;"></td>
                           </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                        <tbody>
                           <tr>
                            <td style="background-color: #622422;color: white;">Task Name</td>
                            <td style="background-color: #622422;color: white;">Volume</td>
                            <td style="background-color: #622422;color: white;">Unit</td>
                            <td style="background-color: #622422;color: white;">Rate</td>
                            <td style="background-color: #622422;color: white;">Price</td>
                           </tr>
                           <tr>
                            <td style="background-color: #fc6;color: black;"><?=$row->code?></td>
                            <td style="background-color: #fc6;color: black;"><?=$row->count?></td>
                            <td style="background-color:#fc6;color: black;"><?=$this->admin_model->getUnit($row->unit)?></td>
                            <td style="background-color: #fc6;color: black;"><?=$row->rate?></td>
                            <td style="background-color: #fc6;color: black;"><?=$row->count*$row->rate?></td>
                           </tr>
                           <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color: #fc6;color: black;">Total</td>
                            <td style="background-color: #fc6;color: black;"><?=$row->count*$row->rate?></td>
                           </tr>
                           <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="background-color:#fc6;color: black;"><?=$this->admin_model->getCurrency($row->currency)?></td>
                           </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;font-size:18px;">
                        <tbody>
                            <tr>
                                 <td colspan=2 style="background-color: #ffff06;color:black;text-align:left;">
                                 <p style="color:red;font-weight: bold;text-decoration: underline;">Terms & Conditions:</p> 
                                <p>• Vendors must Include "The Translation Gate" PO Number in their invoices. </p>
                                <p>• Payment transfer fees will be divided 50-50 between the company and the vendor.</p>
                                <p>• Your invoice should include the payment methods with full and correct details, and "The Translation Gate" is not responsible for 
                                any payment delays caused by incorrect details that the Vendor submits on the payment invoices.  
                                <p>• We use Money Bookers or PayPal  for the amounts less than 300 USD, Western union for the amounts from 300 to 700 USD or 
                                Bank transfers for the amounts more than 700 USD.</p>
                                <p>• Any change or editing in the PO content should be made only through the direct PM, otherwise the PO will be cancelled. 
                                <p>• Failure to comply with job instructions will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                <p>• Deadline extensions can ONLY be requested 12 hours before the job's deadline and will be reviewed if applicable, and failure to meet the deadlines requested in this PO will be penalized by sufficient deductions and could lead to cancel the whole PO.</p>
                                <p>• If the service quality is below the accepted standards, deductions or job cancellation might be applied.</p>
                                <p>• This PO will be considered "cancelled", if our PM did not receive an email confirmation of accepting the job, and indicating fully 
                                understanding of the jobs instructions, and accepting the delivery deadline.</p>
                                <p>• Payments expire after 1 year from task delivery dates.</p>
                                 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
          </div>
</body>
</html>