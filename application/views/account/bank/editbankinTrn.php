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

        <form class="form" id="form" enctype="multipart/form-data">
            <?php if (isset($_SERVER['HTTP_REFERER'])) : ?>
                <input type="text" name="referer" value="<?= $_SERVER['HTTP_REFERER'] ?>" hidden>
            <?php else : ?>
                <input type="text" name="referer" value="<?= base_url() ?>account" hidden>
            <?php endif; ?>

            <input type='hidden' id="chk_audit" value="<?= ($bankin->audit_chk ?? '0') . ($audit_permission->edit ?? '0')  ?>">

            <div class="card text-center">
                <div class="row">
                    <div class="col-lg-3 text-right">
                        <?php if ($bankin->audit_chk == '1') : ?>
                            <div class="devrotate">
                                <i class="fas fa-stamp fa-5x rotate"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-header">
                            <h3>Receipt Edit Bank In</h3>
                            <input type="hidden" name="serial" id="serial" value="<?= $bankin->ccode ?>">
                            <h3 style="color: darkred;"><u>Serial :<?= $bankin->ccode ?></u></h3>
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
            <!--begin::Form-->
            <input type="hidden" name="id" id="id" value="<?= base64_encode($bankin->id) ?>">

            <div class="card-body py-0 shadow-lg p-3 mb-5 bg-white rounded">
                <input type="hidden" name="brand" id="brand" value="<?= $brand ?>">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Bank</label>
                    <div class="col-lg-6">
                        <select name='bank_id' class='form-control m-b' id="bank_id" required value="<?= $bankin->bank_id ?>">
                            <option value="" selected='' disabled>-- Select bank --</option>
                            <?= $this->AccountModel->selectPaymentCombo('payment_method', $bankin->bank_id, $brand, '2'); ?>
                        </select>
                    </div>
                    <input type="hidden" name="bank_acc" id="bank_acc" value="<?= $cash_acc ?>">
                    <input type="hidden" name="bank_acc_id" id="bank_acc_id" value="<?= $cash_acc_id ?>">
                    <input type="hidden" name="bank_acc_name" id="bank_acc_name" value="<?= $cash_acc_name ?>">
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Date</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control datetimepicker-input" id="cdate" name="cdate" data-toggle="datetimepicker" data-target="#Datetimepicker" autocomplete="off" value="<?= date("Y-m-d", strtotime($bankin->date)) ?>">
                    </div>

                    <label class="col-lg-2 col-form-label text-right">Document Number</label>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="doc_no" id="doc_no" value="<?= $bankin->doc_no ?>">
                    </div>
                    <div class="col-lg-2">
                        <button type="button" id="auto_num" class="btn btn-success mr-2"> Auto Number</button>
                    </div>
                </div>

                <div class="form-group row" hidden>
                    <label class="col-lg-3 col-form-label text-right">Transaction Type </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_typ" id="trn_typ" required value="<?= $bankin->trn_typ ?>">
                            <option disabled="disabled" value="">-- Select Transaction Type --</option>
                            <option selected='selected' value="Other" selected="selected">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <input type="hidden" name="rev_name" id="rev_name" value="<?= $rev_name ?>">
                    <label class="col-lg-3 col-form-label text-right">Revenue</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="trn_id" id="trn_id" required value="<?= $bankin->trn_id ?>">
                            <option disabled="disabled" selected="selected" value="">-- Select Revenue Account --
                            </option>
                            <?= $this->AccountModel->Allrevenue($brand, $bankin->trn_id, $acc_setup->bank_acc_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Amount</label>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="amount" id="amount" value="<?= $bankin->amount ?>" required step="any" placeholder="0.00" pattern="^\d*(\.\d{0,2})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)'>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Cheque Number</label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="check_no" id="check_no" value="<?= $bankin->cheque_no ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Collection date</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control datetimepicker-input" id="cdate1" name="cdate1" data-toggle="datetimepicker" data-target="#Datetimepicker" autocomplete="off" value="<?= date("Y-m-d", strtotime($bankin->cheque_date ?? '')) ?>" required>

                        <!-- <input type="text" class="date_sheet form-control" name="cdate1" id="cdate1" value="<?= date("Y-m-d", strtotime($bankin->cheque_date ?? '')) ?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" required> -->
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Currency</label>
                    <input type="hidden" id="currency_hid" name="currency_hid" value="<?= $bankin->currency_id ?>">
                    <div class="col-lg-6">
                        <select class="form-control" name="currency_id" id="currency_id" disabled required value="<?= $bankin->currency_id ?>">
                            <option disabled="disabled" selected="selected" value="">-- Select Currency --</option>
                            <?= $this->admin_model->selectCurrency($bankin->currency_id) ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Rate</label>
                    <input type="hidden" id="rate_h" name="rate_h" value="<?= $bankin->rate ?>">
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="rate" id="rate" value="<?= $bankin->rate ?>" required step="any" placeholder="0.00000" pattern="^\d*(\.\d{0,5})?$" onkeypress='return (event.charCode == 46 || event.charCode >= 48 && event.charCode <= 57)' disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">File Attach</label>
                    <div class="col-lg-6">
                        <input type="text" id="fileToDelete" name="fileToDelete" value="<?= $bankin->doc_file ?>" hidden>

                        <input type="file" class="form-control" name="doc_file" id="doc_file" accept=".zip,.rar,.7zip">
                        <input readonly class="fileuploadspan form-control" id="fileuploadspan" name="fileuploadspan" value="<?= $bankin->name_file ?? '' ?>">
                    </div>
                </div>
                <div class="form-group row my-0" id="file_sel">
                    <?php if ($bankin->doc_file && $bankin->doc_file != '') { ?>
                        <div class="col-lg-6 text-right">
                            <a class="btn btn-sm btn-success my-3" id="linkToView" href="<?= base_url() . './assets/uploads/account/bankin/' . $bankin->doc_file ?>">View Attach</a>
                            <button type="button" id="linkToDelete" class="btn btn-sm btn-primary">Delete Attach</button>
                        </div>
                    <?php } ?>

                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">File Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" name="desc_file" id="desc_file" rows="1" cols="40"><?= $bankin->desc_file ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right">Document Description</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" id="rem" name="rem" rows="4" cols="40" required><?= $bankin->rem ?></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer" style="text-align: center;width: 73%;left: 15%;position: relative;">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <?php if (($bankin->audit_chk != '1')) : ?>
                            <button id="submit" class="btn btn-success mr-2">Submit</button>
                        <?php endif; ?>
                        <a type="button" class="btn btn-secondary" id="close" href="<?php echo base_url() ?>account/bankintrnlist" class="btn btn-default">Cancel</a>
                        <?php if ($audit_permission->edit ?? '' == 1) : ?>
                            <a href="#myModal" data-toggle="modal" class="btn btn-primary">Audit Document</a>
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
                            <input type="text" name="aud_id" id="aud_id" value="<?= base64_encode($bankin->id) ?>" hidden>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Audited </label>
                                <div class="col-lg-2">
                                    <select class="form-control" name="audit_chk" id="audit_chk" value="<?= $bankin->audit_chk ?>">
                                        <option value="0" <?= ($bankin->audit_chk == '0') ? "selected" : '' ?>>-- No --</option>
                                        <option value="1" <?= ($bankin->audit_chk == '1') ? "selected" : '' ?>>-- Yes --</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label text-right">Audit Comments</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" id="audit_comment" name="audit_comment" rows="4" cols="40"><?= $bankin->audit_comment ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <?php if (($audit_permission->edit ?? '' == 1)) : ?>
                                        <button id="submit1" class="btn btn-success mr-2">Submit</button>
                                    <?php endif; ?>
                                    <a type="button" class="btn btn-secondary" id="close1" href="#myModal" data-toggle="modal">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

<script>
    $(document).ready(function() {
        create_entry();
        check_audit_form();

        function check_audit_form() {
            let chk_audit = $('#chk_audit').val();

            if (chk_audit[0] == '1') {

                $("#form").find('input').prop('readonly', true)
                $("#form").find('textarea').prop('readonly', true)
                $("#form").find('select').prop('disabled', true)
                $("#cdate").prop("disabled", true);
                $("#doc_file").prop('disabled', true)
                document.getElementById("auto_num").style.visibility = 'hidden';

                document.getElementById("linkToView").style.visibility = 'hidden';
                document.getElementById("linkToDelete").style.visibility = 'hidden'
                if (chk_audit[1] == '0') {
                    $("#form1").find('textarea').prop('readonly', true)
                    $("#form1").find('select').prop('disabled', true)
                } else {
                    $("#form1").find('textarea').prop('readonly', false)
                    $("#form1").find('select').prop('disabled', false)

                }
            }
        }
        $("#submit1").on('click', function(e) {
            e.preventDefault();
            var audit_chk = $('#audit_chk').val()
            var aud_id = $('#aud_id').val()
            var audit_comment = $('#audit_comment').val()

            $.ajax({
                url: "<?= base_url() . "account/doEditBankinTrn_audit" ?>",
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
                        alert("Failed To Adit Bank In Entry ...");
                    else
                        $('#myModal').modal('hide');

                }
            });
        });

        $('#doc_file').change(function(e) {
            var fileName = e.target.files[0].name;
            if (fileName != '') {
                $('#fileuploadspan').val(fileName);
                // document.getElementById('file_sel').style.display = 'none';
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
            // if (confirm('Are you sure you want to delete Profile File Uploaded ?')) {

            var file_toDelete = $('#fileToDelete').val()
            var id = $('#id').val()

            if (file_toDelete && file_toDelete != '') {
                swal.fire({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to delete Attached File ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(function(result) {
                    if (result.value) {
                        $.ajax({
                            method: 'POST',
                            url: "<?= base_url() . "account/fileToDelete" ?>",
                            data: {
                                'id': id,
                                'file_toDelete': file_toDelete,
                                'type': 'bankin'
                            },
                            success: function(result) {
                                if (result == 'success') {
                                    alert("Success Deleted File ");
                                    $('#fileuploadspan').val('');
                                    document.getElementById('file_sel').style.display = "none";
                                    location.href = "<?= base_url() . "account/editBankinTrn/" ?>" + id;
                                } else {
                                    alert("File Failed to Deleted ");
                                }
                            },
                            error: function() {
                                alert("File Failed to Deleted ");
                            }
                        });


                    }
                })
            }

        });

        $("#form").submit(function(e) {
            // $("input:file[id*=doc_file]").attr("value", "abc.jpg");
            e.preventDefault();
            $.ajax({
                url: "<?= base_url() . "account/doEditBankinTrn" ?>",
                type: "POST",
                // data: $("#form").serialize(),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    if ($('#amount').val() === 0 || $('#rate_h').val() === 0) {
                        alert('You must fill out all required fields in order to submit a change');
                        return false;
                    }

                },
                success: function(data) {
                    data = (data);

                    if (data.records != 0)
                        alert("Failed To Edit Bank In Entry ...");
                    else
                        window.location = "<?= base_url("account/bankintrnlist") ?>";
                }
            });
        });

        $("#bank_id").on('change', function() {
            var bank_id = $("#bank_id").val();
            var date = $("#cdate").val();
            if (bank_id != '') {
                $.ajax({
                    url: "<?= base_url() . "account/bank_trn_currency" ?>",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'bank_id': bank_id,
                        'date': date
                    },
                    success: function(data) {
                        if (data != '') {
                            $('select[name="currency_id"]').html(data.options);
                            $("#currency_hid").val(data.currency_id);
                            $('select[name="currency_id"]').prop("readonly", true);
                            $("#rate").val(parseFloat(data.rate).toFixed(5));
                            $("#rate_h").val(parseFloat(data.rate).toFixed(5));
                            $('#bank_acc').val(data.bank_acc_acode)
                            $('#bank_acc_id').val(data.bank_acc_id)
                            $("#bank_acc_name").val(data.bank_acc_name);
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
                            $('#bank_acc').val('')
                            $('#bank_acc_id').val('')
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
                $('#bank_acc').val('')
                $('#bank_acc_id').val('')
            }
        });

        $("#cdate1").datetimepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            defaultDate: new Date()
        });

        $("#cdate").datetimepicker({
            format: 'YYYY-MM-DD',
            autoclose: true,
            defaultDate: new Date()
        });

        $("#cdate").on('change.datetimepicker', function() {
            var bank_id = $("#bank_id").val();
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
                        'bank_id': bank_id,
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
                $('select[name="currency_id"]').prop("disabled", false);
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
            var bank_id = $("#bank_id").val();
            var trn_id = $("#trn_id").val();
            var amont = $("#amount").val();
            if ((bank_id != '' && bank_id != null) && (amont != 0 || amont != '')) {
                $("#row1").html(`
                "<td data-field="debit" class="datatable-cell px-0"  style="width: 112px;"><span
                   >` + $("#amount").val() + `</span></td>
                <td data-field="credit"  class="datatable-cell px-0"  style="width: 112px;"><span
                    > </span></td>
                <td data-field="account" " class="datatable-cell px-0"  style="width: 150px;"><span
                   >` + $("#bank_acc_name").val() + ` </span></td>
                <td data-field="trn"  class="datatable-cell px-0"  style="width: 150px;"><span
                    >` + $("#bank_id option:selected").text() + `</span></td>
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
            var bank_id = $("#bank_id").val();
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
                        'bank_id': bank_id,
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
                    'transaction': 'Bank In',
                },
                success: function(data) {
                    //var data = JSON.parse(data);
                    // console.log(data);
                    document.getElementById("doc_no").value = data;
                }
            });
        }
    })
</script>