<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit Group
            </header>

            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " action="<?php echo base_url() ?>admin/doEditGroup"
                        method="post" enctype="multipart/form-data">
                        <input type="text" name="id" value="<?= base64_encode($groupss->id) ?>" hidden="">
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="group name">Group</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value="<?= $groupss->name ?>" name="name"
                                    required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="icon">Icon</label>

                            <div class="col-lg-6">
                                <textarea name="icon" id="icon" rows="4" cols="40"><?= $groupss->icon ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Save</button> <a
                                    href="<?php echo base_url() ?>groups" class="btn btn-default"
                                    type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>