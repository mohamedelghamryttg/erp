<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .removed{       
        opacity: 0;       
       -webkit-transition: opacity 1s ease-in-out;
        -moz-transition: opacity 1s ease-in-out;
        -ms-transition: opacity 1s ease-in-out;
        -o-transition: opacity 1s ease-in-out;
    }
</style>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <?php if ($this->session->flashdata('true')) { ?>
            <div class="alert alert-success" role="alert">
                <span class="fa fa-check-circle"></span>
                <span><strong><?= $this->session->flashdata('true') ?></strong></span>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="fa fa-warning"></span>
                <span><strong><?= $this->session->flashdata('error') ?></strong></span>
            </div>
        <?php } ?>
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>

            </div>
            <!--begin::Form-->
            <form class="form"action="<?php echo base_url() ?>admin/doEditUserData" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <h3 class="font-size-lg text-dark font-weight-bold mb-6 ml-5">1. User Info :</h3>
                    <input type="text" name="id" value="<?= $id ?>" hidden="">                  
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Username</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" data-maxlength="300" value="<?= $row->user_name ?>" name="user_name" id="user_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Email</label>
                        <div class="col-lg-6">
                            <input type="email"  placeholder="E-mail" class=" form-control" value="<?= $row->email ?>" name="email" id="email" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Password</label>
                        <div class="col-lg-6">
                            <input type="password" id="inputPassword" placeholder="Password" class=" form-control" 
                                   value="<?= base64_decode($row->password) ?>" name="password"  required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Employee Name</label>
                        <div class="col-lg-6">
                            <select name="employees" class="form-control m-b" id="employees">
                                <option disabled="disabled" selected="selected">-- Select Employee Name --</option>
                                <?= $this->admin_model->selectEmployees($row->employees_id) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Phone</label>
                        <div class="col-lg-6">
                            <input type="number" id="mobile" class=" form-control" value="<?= $row->phone ?>" name="phone" data-maxlength="15">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Status</label>
                        <div class="col-lg-6">
                            <select name="status" class="form-control m-b" id="status">
                                <option disabled="disabled" selected="selected">-- Select Status --</option>                                                                   
                                <option value="1" <?= $row->status == 1 ? "selected" : "" ?>>Active</option>
                                <option value="0" <?= $row->status == 0 ? "selected" : "" ?>>deactive</option>                                                                   
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="col-lg-3 control-label font-weight-bold account_label" >2. User Accounts :   
                            <a onClick='AddAccount()' id='Add_brand_account' class='btn btn-sm btn-clean' data-toggle="tooltip" data-placement="top" title="Add New Account"><i class="fa fa-plus-circle" ></i></a>
                        </label>            
                    </div>
                    
                    <?php if ($accounts) {
                        foreach ($accounts as $k => $account) {
                            ?>
                            <div class="card border border-default p-5 accountCard mb-2" id="account_<?=$account->id?>" style="border-style: dashed!important">
                                <div class="form-group row">
                                    <label class="col-lg-3 control-label font-weight-bold " >Acount #<span class="account_count"><?= ++$k ?></span>
                                    </label> 
                                    <input name="accountId[]"  class="form-control" type="hidden" required value="<?=$account->id?>"/>

                                    <div class="col-lg-9 text-right">
                                        <!--<a class='btn btn-sm btn-clean btn-icon p-0 delete_account_permanently' data-toggle="tooltip" data-placement="top" data-id="<?=$account->id?>" title="Delete Account Permanently"><i class="far fa-times-circle" ></i></a>-->
                                        <a class="btn btn-clean btn-sm p-0 collapseBtn" data-toggle="collapse" href="#multiCollapseExample_11" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-arrow-circle-down" ></i></a>
                                    </div>
                                </div>
                                <div class="collapse multi-collapse show" id="multiCollapseExample_11">
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-2 col-form-label text-right">First Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input name="accountFirstName[]" id="first_name" class="form-control" data-maxlength="300" required value="<?=$account->first_name?>"/>

                                        </div>                   
                                        <label class="col-lg-2 col-form-label text-right">Last Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input name="accountLastName[]" id="last_name" class="form-control" data-maxlength="300" required value="<?=$account->last_name?>"/>

                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">
                                        <label class="col-lg-2 col-form-label text-right">Username <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input name="accountUserName[]" id="user_name" class="form-control" data-maxlength="300" required value="<?=$account->user_name?>"/>

                                        </div>                   
                                        <label class="col-lg-2 col-form-label text-right">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <input name="accountEmail[]" id="email"  class="form-control" required value="<?=$account->email?>"/>

                                        </div>
                                    </div>
                                    <div class="form-group row mb-2">                                        
                                        <label class="col-lg-2 col-form-label text-right">Role <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <select name="accountRole[]" class="form-control m-b" id="role_<?= $k ?>" required="">
                                                <option disabled="disabled" selected="selected">-- Select Role --</option>
        <?= $this->admin_model->selectRole($account->role) ?>
                                            </select>
                                        </div>                    
                                        <label class="col-lg-2 col-form-label text-right">Brand <span class="text-danger">*</span></label>
                                        <div class="col-lg-4">
                                            <select name="accountBrand[]" class="form-control m-b" id="brand_<?= $k ?>" required="">
                                                <option disabled="disabled" selected="selected">-- Select Brand --</option>
        <?= $this->admin_model->selectBrand($account->brand) ?>
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="form-group row mb-2">   
                                        <label class="col-lg-2 col-form-label text-right">Abbreviations</label>
                                        <div class="col-lg-4">
                                            <input name="accountAbbreviations[]" id="abbreviations" class="form-control" data-maxlength="3" value="<?=$account->abbreviations?>">
                                        </div> 
                                       
                                        <label class="col-lg-2 col-form-label text-right">Status</label>
                                        <div class="col-lg-4">
                                            <select name="accountStatus[]" class="form-control m-b" id="status_<?= $k ?>">
                                                <option disabled="disabled" selected="selected">-- Select Status --</option>                                                                   
                                                <option value="1" <?= $account->status == 1 ? "selected" : "" ?>>Active</option>
                                                <option value="0" <?= $account->status == 0 ? "selected" : "" ?>>Deactive</option>                                                                   
                                            </select>
                                        </div>
                    
                                    </div>      
                                </div>
                            </div>
    <?php }
} ?>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/users" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
    <div id="accounts" style='display:none' >                        
        <div class="card border border-default p-5 accountCard mb-2" style="border-style: dashed!important">
            <div class="form-group row">
                <label class="col-lg-3 control-label font-weight-bold " >Acount #<span class="account_count">1</span>
                </label>   
                <div class="col-lg-9 text-right">
                    <a class='btn btn-sm btn-clean btn-icon p-0 delete_account' data-toggle="tooltip" data-placement="top" title="Delete Account"><i class="fa fa-trash" ></i></a>
                    <a class="btn btn-clean btn-sm p-0 collapseBtn" data-toggle="collapse" href="#multiCollapseExample_11" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-arrow-circle-down" ></i></a>
                </div>
            </div>
            <div class="collapse multi-collapse show" id="multiCollapseExample_11">
                <div class="form-group row mb-2">
                    <label class="col-lg-2 col-form-label text-right">First Name <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountFirstName[]" id="first_name" class="form-control" data-maxlength="300" required/>

                    </div>                   
                    <label class="col-lg-2 col-form-label text-right">Last Name <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountLastName[]" id="last_name" class="form-control" data-maxlength="300" required/>

                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-lg-2 col-form-label text-right">Username <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountUserName[]" id="user_name" class="form-control" data-maxlength="300" required/>

                    </div>                   
                    <label class="col-lg-2 col-form-label text-right">Email <span class="text-danger">*</span></label>
                    <div class="col-lg-4">
                        <input name="accountEmail[]" id="email"  class="form-control" required/>

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
                 <input name="accountStatus[]" class="form-control" type='hidden' value='1'>
            </div>
        </div>
    </div>
</div>
<script>

    function AddAccount() {
        // get number of accounts 
        // if more than 4 show alert
//        var numItems = $('.form .account_count').length;
//        if (numItems > 3) {
//            alert('User Max Number Of Accounts Is 4 ....');
//        } else {
            $(".card-body .accountCard .multi-collapse").removeClass('show');
            $(".card-body .accountCard .collapseBtn").find('i').addClass('fa-arrow-circle-up').removeClass('fa-arrow-circle-down');
            $(".card-body").append($("#accounts").html());
            accountCount();
            $('html, body').animate({scrollTop: $(".card-body .accountCard .multi-collapse.show").offset().top});
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
            $('select').select2({dropdownCssClass: "selectheight"});
            $('.select2-container').css('width', '100%');
        });
        $("body").tooltip({selector: '[data-toggle=tooltip]'});
    }

    $(document).on("click", ".collapseBtn", function () {
        $(this).find('i').toggleClass('fa-arrow-circle-down fa-arrow-circle-up');
    });    
 
//    $(document).on("click", ".delete_account_permanently", function () {
//        $(this).tooltip('hide');
//        var user_id = $(this).attr('data-id');
//        if (!confirm('Delete This Account permanently From DB, Are you sure....?'))
//            return false;
//        $.ajaxSetup({
//            beforeSend: function(){
//                $('#loading').show();
//            },
//        });
//         $.ajax({
//            async: false,
//            type: "POST",
//            url: base_url + "admin/deleteUserAccount",
//            data: {user_id: user_id},
//            dataType: "json",
//            success: function (data) {  
//                
//                if (data.status == "success") { 
//                    $('.account_label').addClass('spinner spinner-darker-danger spinner-right');
//                    $('#account_'+user_id).addClass('removed');
//                    setTimeout(() => {
//                        $('#account_'+user_id).remove();
//                        $('.account_label').removeClass('spinner spinner-darker-danger spinner-right');
//                        accountCount();
//                    }, 1500);  
//                   
//                }
//             else {
//                    data_return=false;
//                    alert(data.msg);
//                }
//                $('#loading').hide();
//            }
//        });
//    });
</script>