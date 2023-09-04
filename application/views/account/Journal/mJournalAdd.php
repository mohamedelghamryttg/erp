<div class="card card-custom">
    <div class="card-header">
        <div class="row">
            <h3 class="card-title">
                Form Repeater Example
            </h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="form">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">Full Name:</label>
                <div class="col-lg-4">
                    <input type="email" class="form-control" placeholder="Enter full name" />
                    <span class="form-text text-muted">Please enter your full name</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">Email address:</label>
                <div class="col-lg-4">
                    <input type="email" class="form-control" placeholder="Enter email" />
                    <span class="form-text text-muted">We'll never share your email with anyone else</span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label text-right">Contact</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i
                                    class="la la-chain"></i></span></div>
                        <input type="text" class="form-control" placeholder="Phone number" />
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label class="col-lg-2 col-form-label text-right">Communication:</label>
                <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12 d-flex align-items-center">
                    <div class="checkbox-inline">
                        <label class="checkbox">
                            <input type="checkbox" /> Email
                            <span></span>
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" /> SMS
                            <span></span>
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" /> Phone
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="separator separator-dashed my-8"></div>

            <div id="kt_repeater_1">
                <div class="form-group row" id="kt_repeater_1">
                    <label class="col-lg-2 col-form-label text-right">Contacts:</label>
                    <div data-repeater-list="" class="col-lg-10">
                        <div data-repeater-item class="form-group row align-items-center">
                            <div class="col-md-3">
                                <label>Name:</label>
                                <input type="email" class="form-control" placeholder="Enter full name" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-3">
                                <label>Number:</label>
                                <input type="email" class="form-control" placeholder="Enter contact number" />
                                <div class="d-md-none mb-2"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="radio-inline">
                                    <label class="checkbox checkbox-success">
                                        <input type="checkbox" /> Primary
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a href="javascript:;" data-repeater-delete=""
                                    class="btn btn-sm font-weight-bolder btn-light-danger">
                                    <i class="la la-trash-o"></i>Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-form-label text-right"></label>
                    <div class="col-lg-4">
                        <a href="javascript:;" data-repeater-create=""
                            class="btn btn-sm font-weight-bolder btn-light-primary">
                            <i class="la la-plus"></i>Add
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-2">
                    <button type="reset" class="btn font-weight-bold btn-success mr-2">Submit</button>
                    <button type="reset" class="btn font-weight-bold btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>


<script>
    // Class definition
    var KTFormRepeater = function () {

        // Private functions
        var demo1 = function () {
            $('#kt_repeater_1').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        }

        return {
            // public functions
            init: function () {
                demo1();
            }
        };
    }();

    jQuery(document).ready(function () {
        KTFormRepeater.init();
    });
</script>