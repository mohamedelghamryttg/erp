<script src="//cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Add Office</h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>admin/doAddOffices" onsubmit="return disableAddButton();"
                method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Office</label>
                        <div class="col-lg-6">
                            <input name="name" id="name" class="form-control" />

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-right" for="description">Description</label>

                    <div class="col-lg-6">
                        <textarea id="editor" class='ckeditor' name="office_desc"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>admin/offices"
                                class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
</div>
<script>
    // ClassicEditor
    //     .create(document.querySelector('#editor'))
    //     .catch(error => {
    //         console.error(error);
    //     });
</script>