<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Heads Up Data
            </header>
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
            <div class="panel-body">
                <div class="adv-table editable-table " style="overflow:scroll;">
                    <div class="clearfix">
                        <div class="btn-group">
                            <span class=" btn-primary" style="">
                                Project Data
                            </span>
                        </div>

                    </div>

                    <div class="space15"></div>

                    <table class="table table-striped table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th>Project Code</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Product Line</th>
                                <th>Created By</th>
                                <th>Created At</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="">
                                <td><a
                                        href="<?= base_url() ?>projectManagment/projectJobs?t=<?= base64_encode($project_data->project_id ?? '') ?>"><?= $this->projects_model->getProjectCode($project_data->project_id ?? '') ?></a></td>
                                <td>
                                    <?php echo $project_data->project_name ?>
                                </td>
                                <td>
                                    <?php echo $this->customer_model->getCustomer($project_data->customer); ?>
                                </td>
                                <td>
                                    <?php echo $this->customer_model->getProductLine($project_data->product_line); ?>
                                </td>
                                <td>
                                    <?php echo $this->admin_model->getAdmin($project_data->created_by); ?>
                                </td>
                                <td>
                                    <?php echo $project_data->created_at; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-body">
                <header class="panel-heading">
                    Project Jobs
                </header>
                <div class="adv-table editable-table mt-2" style="overflow-y: scroll;">
                    <div class="clearfix">
                        <div class="btn-group">


                            <?php if ($permission->add == 1 && $project_data->status == 0) { ?>
                                <a href="<?= base_url() ?>projectPlanning/addJob?t=<?= base64_encode($project) ?>"
                                    class="btn btn-primary ">Add New Job</a>
                                </br></br></br>
                            <?php } ?>

                        </div>

                    </div>
                    <div class="space15"></div>

                    <table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                        <thead>
                            <tr>
                                <!--<th>Job Code</th>-->
                                <th>Job Name</th>
                                <th>Product Line</th>
                                <th>Service</th>
                                <th>Source</th>
                                <th>Target</th>
                                <th>Volume</th>
                                <th>Rate</th>
                                <th>Total Revenue</th>
                                <th>Currency</th>
                                <th>Start Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Edit </th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($job->result() as $row) {
                                $priceList = $this->projects_model->getJobPriceListData($row->price_list);
                                $total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
                                ?>
                                <tr>
                                    <!--<td><?php echo $row->code; ?></td>-->
                                    <td><a
                                            href="<?= base_url() ?>projectPlanning/jobTasks?t=<?= base64_encode($row->id) ?>"><?= $row->name ?></a>
                                        <?php
                                        if ($row->job_type == "1") {
                                            echo "<p class='text-center mt-2'><span class='label label-danger'>Free Job</span></p>";
                                            if (strlen($row->attached_email) > 1 && $row->job_type == "1") {
                                                echo '<p class="text-center"><a href="<?=base_url()?>assets/uploads/jobFile/<?=$row->attached_email?>" target="_blank">Email Attachment</a></p>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $this->customer_model->getProductLine($priceList->product_line); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->admin_model->getServices($priceList->service); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->admin_model->getLanguage($priceList->source); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->admin_model->getLanguage($priceList->target); ?>
                                    </td>
                                    <?php if ($row->type == 1) { ?>
                                        <td>
                                            <?php echo $row->volume; ?>
                                        </td>
                                    <?php } elseif ($row->type == 2) { ?>
                                        <td>
                                            <?php echo $total_revenue / $priceList->rate; ?>
                                        </td>
                                    <?php } ?>
                                    <td>
                                        <?php echo $priceList->rate; ?>
                                    </td>
                                    <td>
                                        <?= $total_revenue ?>
                                    </td>
                                    <td>
                                        <?php echo $this->admin_model->getCurrency($priceList->currency); ?>
                                    </td>
                                    <td>
                                        <?php echo $row->start_date; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->delivery_date; ?>
                                    </td>
                                    <td>
                                        <?php echo $this->projects_model->getJobStatus($row->status); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->admin_model->getAdmin($row->created_by); ?>
                                    </td>
                                    <td>
                                        <?php echo $row->created_at; ?>
                                    </td>
                                    <td>
                                        <?php if ($permission->edit == 1 && ($row->status == 6 || $row->status == 7)) { ?>
                                            <a href="<?php echo base_url() ?>projectPlanning/editJob?t=<?php echo
                                                   base64_encode($row->id);
                                               ?>&p=<?= base64_encode($row->plan_id) ?>" class="">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($permission->delete == 1 && ($row->status == 6 || $row->status == 7)) { ?>
                                            <a href="<?php echo base_url() ?>projectPlanning/deleteJob?t=<?php echo
                                                   base64_encode($row->id);
                                               ?>&p=<?= base64_encode($row->plan_id) ?>" title="delete" class=""
                                                onclick="return confirm('Are you sure you want to delete this Project ?');">
                                                <i class="fa fa-times text-danger text"></i> Delete
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>