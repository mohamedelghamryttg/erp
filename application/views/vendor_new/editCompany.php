<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom example example-compact">
            <div class="card-header">
                <h3 class="card-title">Edit Company</h3>

            </div>
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url() ?>vendor/doEditCompany" method="post"
                enctype="multipart/form-data">
                <div class="card-body">

                    <input type="text" name="id" value="<?= base64_encode($companies->id) ?>" hidden="">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Company Name</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" value="<?= $companies->name ?>" name="name" id="name"
                                required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Email</label>
                        <div class="col-lg-6">
                            <input type="text" class=" form-control" name="email" data-maxlength="300" id="email"
                                value="<?= $companies->email ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Region</label>
                        <div class="col-lg-6">
                            <select name="region" class="form-control m-b" id="region" onchange="getCountries()"
                                required />
                            <option value="" disabled="disabled" selected="selected">-- Select Region --</option>
                            <?= $this->admin_model->selectRegion($companies->region) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Country</label>
                        <div class="col-lg-6">
                            <select name="country" class="form-control m-b" id="country" required />
                            <option value="" disabled="disabled" selected="selected">-- Select Country --</option>
                            <?= $this->admin_model->selectCountries($companies->country, $companies->region) ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-right">Comment</label>
                        <div class="col-lg-6">
                            <textarea name="comment" class="form-control" rows="6"><?= $companies->comment ?></textarea>
                        </div>
                    </div>


                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <a class="btn btn-secondary" href="<?php echo base_url() ?>vendor/companies"
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