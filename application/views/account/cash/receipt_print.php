<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Express Wash Customer Invoice</title>
    <style>
        @media print {
            @page {
                margin: 0;
                size: A4;
                /* sheet-size: 300px 250mm; */
            }

            /* html {
                direction: rtl;
            } */

            html,
            body {
                margin: 0;
                padding: 0;

            }

            #printContainer {
                /* width: 250px; */
                /* margin: auto; */
                /* text-align: justify; */
                margin-top: 150px;

            }

            header {
                display: none !important;
            }


            .text-center {
                text-align: center;
            }
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-weight: bold;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        #printContainer {
            /* width: 250px; */
            /* margin: auto; */
            /* text-align: justify; */

            font-family: "Times New Roman", Times, serif;
            font-size: 18pt !important;
            font-weight: bold;
        }

        h5 {
            font-size: 18px;
        }

        h3 {
            font-size: 20px;
        }

        h2 {
            font-size: 24px;
        }

        .devrotate {
            position: absolute;
            right: 0;
            top: 25px;
            width: 100px;
            height: 100px;
            background-color: transparent;
        }

        .rotate {
            background-color: transparent;
            transform: rotate(45deg);
            color: darkblue;
        }
    </style>
</head>

<body onload="window.print();">
    <div id='printContainer'>
        <!-- <div id="printdiv"> -->
        <!-- <div id="PrintModal" class="printMe"> -->
        <div class="container-fluid text-center " style="overflow:hidden;height: auto;width:100%">
            <div class="bg-white  ">
                <div class="row ">
                    <div class="col-1 text-left"></div>
                    <div class="col-5 text-left">
                        <?php if ($this->brand == 1) { ?>
                            <img alt="Logo" src="<?php echo base_url(); ?>assets/images/logo_ar.png" class="logo-default max-h-40px mx-5" />
                        <?php } elseif ($this->brand == 2) { ?>
                            <img alt="Logo" src="<?php echo base_url(); ?>assets/images/localizera_logo.png" class="logo-default max-h-20px" />
                        <?php } elseif ($this->brand == 3) { ?>
                            <img alt="Logo" src="<?php echo base_url(); ?>assets/images/europe.png" class="logo-default max-h-50px" />
                        <?php } elseif ($this->brand == 11) { ?>
                            <img alt="Logo" src="<?= base_url(); ?>assets/images/columbus_logo.jpg" class="logo-default max-h-70px" />
                        <?php } ?>
                    </div>
                    <div class="col-5 text-right">
                        <h2 style="margin: auto;padding : 20px"><?= $this->admin_model->getBrand($this->brand) ?> </h2>
                    </div>
                    <div class="col-1 text-left"></div>
                </div>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="text-center">
                            <h3>Treasury Receipt Cash In</h3>
                            <h3 style="color: darkred;"><u>Serial :<?= $cashin->ccode ?></u></h3>
                            <h3><u>Document Number :<span style="color: darkred;"><?= $cashin->doc_no ?></span></u></h3>
                        </div>
                    </div>
                    <div class="col-3 text-right">
                        <?php if ($cashin->audit_chk == '1') : ?>
                            <div class="devrotate">
                                <i class="fas fa-stamp fa-3x rotate"></i>
                                <hr style="border-top: 1px solid black;">
                            </div>

                        <?php endif; ?>
                    </div>

                </div>
                <!-- </div> -->
                <!--begin::Form-->

                <br>
                <div class="row">
                    <div class="col-3 text-right">
                        <h5>Cash :</h5>
                    </div>
                    <div class="col-3 text-left">
                        <h5>
                            <input type="text" value="<?= $this->db->get_where('payment_method', array('brand' => $brand, 'type' => '1', 'id' => $cashin->cash_id))->row()->name ?>" style="border: none;">
                        </h5>
                    </div>
                    <div class="col-3 text-right">
                        <h5>Document Date :</h5>
                    </div>
                    <div class="col-1  text-left">
                        <h5>
                            <input type="text" id="cdate" name="cdate" value="<?= date("Y-m-d", strtotime($cashin->date)) ?>" style="border: none;">
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 text-right">
                        <h5>Document Number :</h5>
                    </div>
                    <div class="col-2  text-left">
                        <h5>
                            <input type="text" name="doc_no" id="doc_no" value="<?= $cashin->doc_no ?>" style="border: none;">
                        </h5>
                    </div>

                </div>

                <div class="row">
                    <div class="col-3 text-right">
                        <h5>Revenue :</h5>
                    </div>
                    <div class="col-6 text-left">
                        <h5>
                            <input type="text" value="<?= $this->db->get_where('account_chart', array('id' => $cashin->trn_id))->row()->name ?? '' ?>" style="border: none;">
                        </h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3 text-right">
                        <h5>Amount :</h5>
                    </div>
                    <div class="col-3  text-left">
                        <h5>
                            <input type="text" name="amount" id="amount" value="<?= $cashin->amount . '  ' .  $this->admin_model->getCurrency($cashin->currency_id) ?>" style="border: none;">
                        </h5>
                    </div>
                    <div class="col-3 text-right">
                        <h5>Rate :</h5>
                    </div>
                    <div class="col-1  text-left">
                        <h5>
                            <input type="text" name="rate" id="rate" value="<?= $cashin->rate ?>" style="border: none;">
                        </h5>
                    </div>

                </div>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-9  text-left">
                        <h5>
                            <input type="text" name="Wamount" id="Wamount" value="<?php $val = $this->load->library('Numbertowords');
                                                                                    echo $this->numbertowords->convert_number($cashin->amount); ?>" style="border: none;">
                        </h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3 text-right">
                        <h5>Document Description</h5>
                    </div>
                    <div class="col-6 text-left">
                        <textarea id="rem" name="rem" rows="4" cols="40" style="border: none;font-size: 15pt !important;"><?= $cashin->rem ?></textarea>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3">
                        <h5>
                            Created By
                        </h5>
                    </div>
                    <div class="col-3">
                        <h5>
                            Audit By
                        </h5>
                    </div>

                    <div class="col-3"></div>

                </div>

                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3">
                        <h5><?= $this->db->get_where('users', array('id' => $cashin->created_by))->row()->user_name ?? '' ?> </h5>
                    </div>
                    <div class="col-3">
                        <h5><?= $this->db->get_where('users', array('id' => $cashin->audit_by))->row()->user_name ?? '' ?> </h5>
                    </div>
                    <div class="col-3"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3">
                    </div>
                    <div class="col-3">
                    </div>

                    <div class="col-3">
                        <sapn style="font-size: 10pt !important;">
                            <?= date("d-m-Y h:i:sa") ?>
                            </span>
                    </div>

                </div>
                <hr>
            </div>
        </div>
        <!-- </div> -->
        <!-- </div> -->
    </div>

</body>

</html>