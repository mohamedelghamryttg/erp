<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="d-flex flex-column-fluid mt-2">
    <!--begin::Container-->
    <div class="container">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('true') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add New User</h3>
            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>admin/doAddUserData"
                onsubmit="return disableAddButton();" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <h3 class="font-size-lg text-dark font-weight-bold mb-6 ml-5">1. User Info :</h3>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Username <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input name="user_name" id="user_name" class="form-control" data-maxlength="300" required />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Email <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input name="email" id="email" class="form-control" required />

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Password <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-6">
                            <input type="password" name="password" id="password" class="form-control" required />

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Employee Name </label>
                        <div class="col-lg-6">
                            <select name="employees" class="form-control" id="employees" required>
                                <option disabled="disabled" selected="selected" value="">-- Select Employee Name --
                                </option>
                                <?= $this->admin_model->selectEmployees() ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">phone</label>
                        <div class="col-lg-6">
                            <input type="number" name="phone" id="phone" data-maxlength="15" class="form-control" />

                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label class="col-lg-3 control-label font-weight-bold ">2. User Accounts :
                            <a onClick='AddAccount()' id='Add_brand_account' class='btn btn-sm btn-clean'
                                data-toggle="tooltip" data-placement="top" title="Add New Account"><i
                                    class="fa fa-plus-circle"></i></a>
                        </label>
                    </div>


                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/masterUsers"
                                class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
    <div id="accounts" style='display:none'>
        <div class="card border border-default p-5 accountCard mb-2" style="border-style: dashed!important">
            <div class="form-group row">
                <label class="col-lg-3 control-label font-weight-bold ">Acount #<span class="account_count">1</span>
                </label>
                <div class="col-lg-9 text-right">
                    <a class='btn btn-sm btn-clean btn-icon p-0 delete_account' data-toggle="tooltip"
                        data-placement="top" title="Delete Account"><i class="fa fa-trash"></i></a>
                    <a class="btn btn-clean btn-sm p-0 collapseBtn" data-toggle="collapse"
                        href="#multiCollapseExample_11" role="button" aria-expanded="false"
                        aria-controls="multiCollapseExample1"><i class="fa fa-arrow-circle-down"></i></a>
                </div>
            </div>
            <div class="collapse multi-collapse show" id="multiCollapseExample_11">
                <div class="form-group row mb-2">
                    <label class="col-lg-2 col-form-label text-right">First Name <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountFirstName[]" id="first_name" class="form-control" data-maxlength="300"
                            required />

                    </div>
                    <label class="col-lg-2 col-form-label text-right">Last Name <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountLastName[]" id="last_name" class="form-control" data-maxlength="300"
                            required />

                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-lg-2 col-form-label text-right">Username <span
                            class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountUserName[]" id="user_name" class="form-control" data-maxlength="300"
                            required />

                    </div>
                    <label class="col-lg-2 col-form-label text-right">Email <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountEmail[]" id="email" class="form-control" required />

                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-lg-2 col-form-label text-right">Role <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <select name="accountRole[]" class="form-control-sm m-b" id="role" required="">
                            <option disabled="disabled" selected="selected">-- Select Role --</option>
                            <?= $this->admin_model->selectRole() ?>
                        </select>
                    </div>
                    <label class="col-lg-2 col-form-label text-right">Brand <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <select name="accountBrand[]" class="form-control m-b" id="brand" required="">
                            <option disabled="disabled" selected="selected">-- Select Brand --</option>
                            <?= $this->admin_model->selectBrand() ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-lg-2 col-form-label text-right">Abbreviations</label>
                    <div class="col-lg-4">
                        <input name="accountAbbreviations[]" id="abbreviations" class="form-control" data-maxlength="3">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function AddAccount() {
        // get number of accounts 
        // if more than 4 show alert
        //        var numItems = $('.form .account_count').length;
        //        if(numItems > 3){
        //            alert('User Max Number Of Accounts Is 4 ....')
        //        }else{        
        $(".card-body .accountCard .multi-collapse").removeClass('show');
        $(".card-body .accountCard .collapseBtn").find('i').addClass('fa-arrow-circle-up').removeClass('fa-arrow-circle-down');
        $(".card-body").append($("#accounts").html());
        accountCount();
        $('html, body').animate({ scrollTop: $(".card-body .accountCard .multi-collapse.show").offset().top });
        //        }
    }

    $(document).on("click", ".delete_account", function () {
        $(this).tooltip('hide');
        if (!confirm('Delete Account , Are you sure?'))
            return false;
        $(this).closest('.accountCard').remove();
        accountCount();
    });


    function accountCount() {
        $('.card-body .accountCard').each(function (index, item) {
            var k = ++index;
            $(item).find('.account_count').html(k);
            $(item).find('.collapseBtn').attr('href', '#multiCollapseExample_' + k);
            $(item).find('.multi-collapse').attr('id', 'multiCollapseExample_' + k);
            $(item).find('.multi-collapse select').each(function (i, it) {
                var old_name = $(it).attr('id').split('_', 1)[0];
                $(it).attr('id', old_name + '_' + k);
            });
            $('.select2-container').remove();
            $('select').select2({ dropdownCssClass: "selectheight" });
            $('.select2-container').css('width', '100%');
        });
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    }

    $(document).on("click", ".collapseBtn", function () {
        $(this).find('i').toggleClass('fa-arrow-circle-down fa-arrow-circle-up');
    });
</script>