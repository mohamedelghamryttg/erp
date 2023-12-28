<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <style>
            .devrotate {
                position: absolute;
                /* left: 50px; */
                right: 0;
                top: 25px;
                width: 100px;
                height: 100px;
                background-color: transparent;
            }

            .rotate {
                background-color: transparent;
                outline: 2px dashed;
                transform: rotate(45deg);
                color: darkblue;
                /* width: 40%; */
            }
        </style>


        <form class="form" id="form" method="post" enctype="multipart/form-data">
            <input type='hidden' id="chk_audit" value="<?= ($cashin->audit_chk ?? '0') . ($audit_permission->edit ?? '0')  ?>">

            <?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php else : ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php endif; ?>

            <div class="card text-center">
                <div class="row">
                    <div class="col-lg-3 text-right">
                        <?php if ($cashin->audit_chk == '1') : ?>
                            <div class="devrotate">
                                <i class="fas fa-stamp fa-5x rotate"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-header">
                            <h3>Treasury Receipt Edit Cash In</h3>
                            <input type="hidden" name="serial" id="serial" value="<?= $cashin->ccode ?>">
                            <h3 style="color: darkred;"><u>Serial :<?= $cashin->ccode ?></u></h3>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
            <!--begin::Form-->
            <input type="hidden" name="id" value="<?= base64_encode($cashin->id) ?>">

            <div class="card-body py-0 shadow-lg p-3 mb-5 bg-white rounded">
                <input type="hidden" name="brand" id="brand" value="<?= $brand ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Cash</label>
                    <div class="col-lg-6">
                        <select name='cash_id' class='form-control m-b' id="cash_id" required value="<?= $cashin->cash_id ?>">
                            <option value="" selected='' disabled>-- Select Cash --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', $cashin->cash_id, $brand, '1'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="cash_acc" id="cash_acc" value="<?= $cash_acc ?>">
                    <input type="hidden" name="cash_acc_id" id="cash_acc_id" value="<?= $cash_acc_id ?>">
                    <input type="hidden" name="cash_acc_name" id="cash_acc_name" value="<?= $cash_acc_name ?>">
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Date</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control datetimepicker-input" id="cdate" name="cdate" data-toggle="datetimepicker" data-target="#Datetimepicker" autocomplete="off" value="<?= date("Y-m-d", strtotime($cashin->date)) ?>">
                    </div>

                    <label class="col-lg-2 col-form-label text-right">Document Number</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="doc_no" id="doc_no" value="<?= $cashin->doc_no ?>" required>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="auto_num" class="btn btn-success mr-2"> Auto Number</button>
                    </div>
                </div>
                <div class="form-group row" hidden>
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required value="<?= $cashin->trn_typ ?>">
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="Other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <input type="hidden" name="rev_name" id="rev_name" value="<?= $rev_name ?>">
                    <label class="col-lg-3 col-form-label text-right">Revenue</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_id" id="trn_id" required value="<?= $cashin->trn_id ?>">
                            <option disabled="disabled" selected="selected" value="">-- Select Revenue Account --
                            </option>
                            <?= $this->AccountModel->Allrevenue($brand, $cashin->trn_id, $acc_setup->cash_acc_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="amount" id="amount" value="<?= $cashin->amount ?>" required step="any" placeholder="0.00" pattern="^\d*(\.\d{0,2})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Currency</label>
                    <input type="hidden" id="currency_hid" name="currency_hid" value="<?= $cashin->currency_id ?>">
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency_id" disabled required value="<?= $cashin->currency_id ?>">
                            <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency($cashin->currency_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Rate</label>
                    <input type="hidden" id="rate_h" name="rate_h" value="<?= $cashin->rate ?>">
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="rate" id="rate" value="<?= $cashin->rate ?>" required step="any" placeholder="0.00000" pattern="^\d*(\.\d{0,5})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>
                <style>
                    input[type=file] {
                        display: none
                    }
                </style>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">File Attach</label>
                    <div class="col-lg-6" style="display: flex;">
                        <button type="button" class="choosefile btn btn-secondary mr-2">Browse...</button>
                        <input type="text" id="fileToDelete" name="fileToDelete" value="<?= $cashin->doc_file ?>" hidden>

                        <input type="file" class="form-control" name="doc_file" id="doc_file" accept=".zip,.rar,.7zip">
                        <input readonly class="fileuploadspan form-control" id="fileuploadspan" name="fileuploadspan" value="<?= ($cashin->name_file && $cashin->name_file != '') ?  $cashin->name_file : 'No file selected' ?>">
                    </div>
                </div>
                <div class="form-group row my-0" id="file_sel">
                    <?php if ($cashin->doc_file && $cashin->doc_file != '') { ?>
                        <div class="col-lg-6 text-right">
                            <a class="btn btn-sm btn-success my-3" id="linkToView" href="<?= base_url() . './assets/uploads/account/cashin/' . $cashin->doc_file ?>">View Attach</a>
                            <button type="button" id="linkToDelete" class="btn btn-sm btn-primary">Delete Attach</button>
                        </div>
                    <?php } ?>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">File Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" name="desc_file" id="desc_file" rows="1" cols="40"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" id="rem" name="rem" rows="4" cols="40" required><?= $cashin->rem ?></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <?php if (($cashin->audit_chk != '1')) : ?>
                            <button id="submit" class="btn btn-success mr-2">Submit</button>
                        <?php endif; ?>
                        <a type="button" class="btn btn-secondary" id="close" href="<?php echo base_url() ?>account/cashintrnlist" class="btn btn-default">Cancel</a>
                        <?php if ($audit_permission->edit ?? '' == 1) : ?>
                            <a href="#myModal" data-toggle="modal" class="btn btn-success">Audit Document</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>

        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade ">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title">Audit Section</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form1" id="form" method="post" enctype="multipart/form-data">
                            <input type="text" name="aud_id" id="aud_id" value="<?= base64_encode($cashin->id) ?>" hidden>

                            <!-- <div class="card text-center">
                                    <div class="card-header">
                                        <h3>Audit Section</h3>
                                          </div>
                                </div> -->

                            <!-- <div class="card-body py-0 shadow-lg p-3 mb-5 bg-white rounded"> -->
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Audited </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="audit_chk" id="audit_chk" value="<?= $cashin->audit_chk ?>">
                                        <option value="0" <?= ($cashin->audit_chk == '0') ? "selected" : '' ?>>-- No --</option>
                                        <option value="1" <?= ($cashin->audit_chk == '1') ? "selected" : '' ?>>-- Yes --</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Audit Comments</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" id="audit_comment" name="audit_comment" rows="4" cols="40"><?= $cashin->audit_comment ?></textarea>
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;"> -->
                            <div class="row">

                                <div class="col-lg-12 text-center">
                                    <?php if (($audit_permission->edit ?? '' == 1)) : ?>
                                        <button id="submit1" class="btn btn-success mr-2">Submit</button>
                                    <?php endif; ?>
                                    <a type="button" class="btn btn-secondary" id="close1" href="#myModal" data-toggle="modal" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                            <!-- </div> -->

                        </form>
                    </div>
                </div>
            </div>
        </div>';

        <br />
        <div class="datatable datatable-default datatable-bordered datatable-loaded">
            <table class="datatable-bordered datatable-head-custom datatable-table" id="kt_datatable" style="display: block;border-top: 1px solid #3F4254;">
                <thead class="datatable-head">
                    <tr class="datatable-row" style="left: 0px;">
                        <th data-field="debit" class="datatable-cell px-0"><span style="width: 112px;">Debit</span></th>
                        <th data-field="credit" class="datatable-cell px-0"><span style="width: 112px;">Credit</span></th>
                        <th data-field="acount" class="datatable-cell  px-0"><span style="width: 150px;">Account</span></th>
                        <th data-field="revenue" class="datatable-cell  px-0"><span style="width: 150px;">Transaction</span></th>
                        <th data-field="currency" class="datatable-cell  px-0"><span style="width: 112px;">Currency</span></th>
                        <th data-field="rate" class="datatable-cell  px-0"><span style="width: 112px;">Rate</span></th>
                        <th data-field="evamount" data-autohide-disabled="false" class="datatable-cell  px-0">
                            <span style="width: 112px;">Ev. Amount</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="datatable-body entry_table">
                    <tr data-row="0" class="datatable-row" id="row1" style="left: 0px;">
                    </tr>
                    <tr data-row="0" class="datatable-row" id="row2" style="left: 0px;">
                    </tr>
                </tbody>
            </table>
        </div>
        <!--end::Form-->
    </div>
    <!--end::Card-->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        create_entry();
        check_audit_form();

        function check_audit_form() {
            let chk_audit = $('#chk_audit').val();
            if (chk_audit[0] = '1') {
                $("#form").find('input').prop('readonly', true)
                $("#form").find('textarea').prop('readonly', true)
                $("#form").find('select').prop('disabled', true)
                $("#cdate").prop("disabled", true);
                $(".choosefile").prop("disabled", true);
                $("#auto_num").prop("disabled", true);
                if (chk_audit[1] = '0') {
                    $("#form1").find('textarea').prop('readonly', true)
                    $("#form1").find('select').prop('disabled', true)
                } else {
                    $("#form1").find('textarea').prop('readonly', false)
                    $("#form1").find('select').prop('disabled', false)

                }
            }
        }
        $("#submit1").on('click', function(e) {
            // $("input:file[id*=doc_file]").attr("value", "abc.jpg");
            e.preventDefault();
            var audit_chk = $('#audit_chk').val()
            var aud_id = $('#aud_id').val()
            var audit_comment = $('#audit_comment').val()

            $.ajax({
                url: "<?= base_url() . "account/doEditCashinTrn_audit" ?>",
                type: "POST",
                data: {
                    'audit_chk': audit_chk,
                    'aud_id': aud_id,
                    'audit_comment': audit_comment
                },
                // data: new FormData(this),
                dataType: "json",

                success: function(data) {
                    data = (data);
                    if (data.records != 0)
                        alert("Failed To Adit Cash In Entry ...");
                    else
                        $('#myModal').modal('hide');

                }
            });
        });
        $('.choosefile').click(function() {
            $('#doc_file').click();
        });
        $('#doc_file').change(function(e) {
            var fileName = e.target.files[0].name;
            if (fileName != '') {
                $('#fileuploadspan').val(fileName);
                document.getElementById('file_sel').style.display = 'none';
            }
        });

        $("#amount").blur(function() {
            if (this.value === 'NaN') {
                this.value = 0;
            }
            this.value = parseFloat(this.value).toFixed(2);
        });
        $("#rate").blur(function() {
            if ($('#rate_h').val() === 0) {
                $('#rate_h').val() = this.value;
            }
            this.value = parseFloat(this.value).toFixed(5);
            if ($(this).val() == 0) {
                $("#rate").prop("readonly", false);
            } else {
                $("#rate").prop("readonly", true);
            }
        });
        $('#linkToDelete').on('click', function() {
            if (confirm('Are you sure you want to delete Profile File Uploaded ?')) {
                $('#fileuploadspan').val('');
                document.getElementById('file_sel').style.display = "none";
            }
        });
        $("#form").submit(function(e) {
            // $("input:file[id*=doc_file]").attr("value", "abc.jpg");
            e.preventDefault();
            $.ajax({
                url: "<?= base_url() . "account/doEditCashinTrn" ?>",
                type: "POST",
                // data: $("#form").serialize(),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    // $empty = $('#form').find("input").filter(function() {
                    //     return this.value === "";
                    // });
                    // $empty1 = $('#form').find("select").filter(function() {
                    //     return this.value === "";
                    // });
                    // $empty2 = $('#form').find("textarea").filter(function() {
                    //     return this.value === "";
                    // });
                    if ($('#amount').val() === 0 || $('#rate_h').val() === 0) {
                        alert('You must fill out all required fields in order to submit a change');
                        return false;
                    }
                    // if ($empty.length + $empty1.length + $empty2.length) {
                    //     alert('You must fill out all required fields to submit a change');
                    //     return false;
                    // } else {
                    //     return true;
                    // }
                },
                success: function(data) {
                    data = (data);

                    if (data.records != 0)
                        alert("Failed To Edit Cash In Entry ...");
                    else
                        window.location = "<?= base_url("account/cashintrnlist") ?>";
                }
            });
        });

        $("#cash_id").on('change', function() {
            var cash_id = $("#cash_id").val();
            var date = $("#cdate").val();
            if (cash_id != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'cash_id': cash_id,
                        'date': date
                    },
                    success: function(data) {
                        if (data != '') {
                            $('select[name="currency_id"]').html(data.options);
                            $("#currency_hid").val(data.currency_id);
                            $('select[name="currency_id"]').prop("readonly", true);
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            $('#cash_acc').val(data.cash_acc_acode)
                            $('#cash_acc_id').val(data.cash_acc_id)
                            $("#cash_acc_name").val(data.cash_acc_name);
                            if (data.rate === 0) {
                                $("#rate").prop("readonly", false);
                            } else {
                                $("#rate").prop("readonly", true);
                            }
                            create_entry();
                        } else {
                            $('select[name="currency_id"]').prop("readonly", false);
                            $("#rate").val('0');
                            $("#rate_h").val('0');
                            $("#currency_hid").val('');
                            $("#rate").prop("readonly", false);
                            $('#cash_acc').val('')
                            $('#cash_acc_id').val('')
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("readonly", false);
                $("#rate").val('0');
                $("#rate_h").val('0');
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
                $('#cash_acc').val('')
                $('#cash_acc_id').val('')
            }
        });

        $("#cdate").datetimepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            defaultDate: new Date()
        });

        $("#cdate").on('change.datetimepicker', function() {
            var cash_id = $("#cash_id").val();
            var date = $('#cdate').val();
            var currency_hid = $("#currency_hid").val();
            if (currency_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency_rate" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'currency_hid': currency_hid,
                        'cash_id': cash_id,
                        'date': date
                    },
                    success: function(data) {
                        if (data != '') {
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            if (data.rate === 0) {
                                $("#rate").prop("readonly", false);
                            } else {
                                $("#rate").prop("readonly", true);
                            }
                            create_entry();
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            $("#rate").prop("readonly", false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("readonly", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
            }
        });

        $("#trn_id").on('change', function() {
            create_entry();
        });
        $("#amount").on('focusout', function() {
            this.value = parseFloat(this.value).toFixed(2);
            create_entry();
        })

        function create_entry() {
            $entry_text1 = "";
            var cash_id = $("#cash_id").val();
            var trn_id = $("#trn_id").val();
            var amont = $("#amount").val();
            if ((cash_id != '' && cash_id != null) && (amont != 0 || amont != '')) {
                $("#row1").html(`
                "<td data-field="debit" class="datatable-cell px-0"  style="width: 112px;"><span
                   >` + $("#amount").val() + `</span></td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                    > </span></td>
                <td data-field="account" " class="datatable-cell px-0"  style="width: 150px;"><span
                   >` + $("#cash_acc_name").val() + ` </span></td>
                <td data-field="trn"  class="datatable-cell px-0"  style="width: 150px;"><span
                    >` + $("#cash_id option:selected").text() + `</span></td>
                <td data-field="currency"  class="datatable-cell px-0"  style="width: 112px;"><span
                   >` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell px-0"  style="width: 112px;"><span
                    >` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell px-0"  style="width: 112px;">
                    <span >
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + $("#amount").val() * $("#rate").val() + `</span> </span>
               </td>`);
            }

            if ((trn_id != '' && trn_id != null) && (amont != 0 && amont != '')) {
                $("#row2").html(`
                "<td data-field="debit" class="datatable-cell px-0" style="width: 112px;"><span
                    ></span></td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                   > ` + $("#amount").val() + `</span></td>
                <td data-field="account" " class="datatable-cell px-0"  style="width: 150px;"><span
                    >` + $("#trn_id option:selected").text() + ` </span></td>
                <td data-field="trn"  class="datatable-cell px-0" style="width: 150px;"><span
                    ></span></td>
                <td data-field="currency"  class="datatable-cell px-0" style="width: 112px;"><span
                    >` + $("#currency_id option:selected").text() + `</span></td>
                <td data-field="rate"  class="datatable-cell px-0" style="width: 112px;"><span
                    >` + $("#rate").val() + `</span></td>
                <td data-field="evamount" class="datatable-cell px-0" style="width: 112px;">
                    <span >
                    <span class="label label-success label-dot mr-2"></span>
                    <span class="font-weight-bold text-success">` + $("#amount").val() * $("#rate").val() + `</span> </span>
               </td>`);
            }
        }
        $(document).keypress(function(e) {
            if (e.keyCode === 13) {
                $(document.activeElement).next().focus();
            }
        });
        $("#rate").on('change', function() {
            $("#rate_h").val($(this).val());
            create_entry();
        })

        $("#currency_id").on('change', function() {
            $("#currency_hid").val($("#currency_id").val());
            var cash_id = $("#cash_id").val();
            var date = $('#cdate').val();
            var currency_hid = $("#currency_hid").val();
            if (currency_hid != '') {
                $.ajax({
                    url: "<?= base_url() . "account/get_trn_currency_rate" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'currency_hid': currency_hid,
                        'cash_id': cash_id,
                        'date': date
                    },
                    success: function(data) {
                        if (data != '') {
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            if (data.rate === 0) {
                                $("#rate").prop("readonly", false);
                            } else {
                                $("#rate").prop("readonly", true);
                            }
                            create_entry();
                        } else {
                            $("#rate").val(parseFloat(0).toFixed(5));
                            $("#rate_h").val(parseFloat(0).toFixed(5));
                            $("#rate").prop("readonly", false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            } else {
                $('select[name="currency_id"]').prop("readonly", false);
                $("#rate").val(parseFloat(0).toFixed(5));
                $("#rate_h").val(parseFloat(0).toFixed(5));
                $("#currency_hid").val('');
                $("#rate").prop("readonly", false);
            }
        });
        //     $("#linkToDelete").on('click', function() {
        //         var file_toDelete = $('#fileToDelete').val()
        //         if (file_toDelete && file_toDelete != '') {
        //             if (confirm('Are you sure you want to delete Profile File Uploaded ?')) {
        //                 $.ajax({
        //                     method: 'POST',
        //                     url: "<?= base_url() . "customer/fileToDelete" ?>",
        //                     data: {
        //                         'id': id,
        //                         'file_toDelete': file_toDelete
        //                     },
        //                     success: function(result) {
        //                         if (result === "success") {
        //                             alert("Success Deleted File ");
        //                             location.href = "<?php echo base_url() ?>customer/editCustomerPortal?t=" + id;
        //                         } else {
        //                             alert("File Failed to Deleted ");
        //                         }
        //                     },
        //                     error: function() {
        //                         alert("File Failed to Deleted ");
        //                     }
        //                 });
        //             }
        //         }
        //     });
    })
    $('#auto_num').click(function() {
        var date_trns = $('#cdate').val();
        var dt = new Date(date_trns);
        var dtm = dt.getMonth() + 1;
        if (dtm == 0) {
            dtm = 12
        }
        var ntm = parseInt(document.getElementById("doc_no").value.substr(0, 2));
        if (dtm != ntm) {
            $.ajax({
                url: "<?= base_url("account/auto_num_Transaction") ?>",
                type: "POST",
                data: {
                    'cdate': date_trns,
                    'transaction': 'Cash In'
                },
                success: function(data) {
                    //var data = JSON.parse(data);
                    // console.log(data);
                    document.getElementById("doc_no").value = data;
                }
            });
        }


    });
</script>