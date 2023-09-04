<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add Vacation Request
            </header>

            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal " id="form"
                        action="<?php echo base_url() ?>hr/doAddVacationRequest" method="post"
                        onsubmit="return onAddVacationRequest();" name="addVacatin" enctype="multipart/form-data">
                        <div class='form-group'>
                            <label class='col-lg-3 control-label' for='inputPassword'>Type Of Vacation</label>
                            <div class='col-lg-6'>
                                <select name='type_of_vacation' class='form-control m-b' id="type_of_vacation"
                                    onchange="calculateAvailableVacationDays(0);" value="" required="">
                                    <option value="" disabled='' selected=''>-- Select --</option>
                                    <?= $this->hr_model->selectAllVacationTypies() ?>
                                </select>
                            </div>
                        </div>
                        <div class='form-group' id="relative_degree_div" style="display: none;">
                            <label class='col-lg-3 control-label' for='inputPassword'>Relative Degree</label>
                            <div class='col-lg-6'>
                                <select name='relative_degree' class='form-control m-b' id="relative_degree"
                                    onchange="calculateAvailableVacationDays();">
                                    <option value="" selected=''>-- Select --</option>
                                    <option value="1">First</option>
                                    <option value="2">Second</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="available_days_div">
                            <label class="col-lg-3 control-label">Available Days</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value=" " name="available_days"
                                    id="available_days" data-maxlength="300" placeholder="Available days" readonly>
                                <input type="text" class="form-control" value=" " name="availableDays"
                                    id="availableDays" data-maxlength="300" placeholder="Available days" hidden="">
                            </div>
                        </div>
                        <div class="form-group" id="requested_days_div" style="display: block;">
                            <label class="col-lg-3 control-label">Requested Days</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control" value=" " name="requested_days"
                                    id="requested_days" data-maxlength="300" placeholder="Requested days" readonly>
                            </div>
                        </div>
                        <div class='form-group' id="day_type_div" style="display: none;">
                            <label class='col-lg-3 control-label'>Vacation Day Type</label>
                            <div class='col-lg-6'>
                                <select name='day_type' class='form-control m-b' id="day_type"
                                    onchange="checkVacationCredite();">
                                    <option value="0" selected=''>Full Day</option>
                                    <option value="1">½ Day</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Start</label>

                            <div class="col-lg-6">
                                <input type="text" class=" form-control datepicker" name="start_date" autocomplete="off"
                                    onblur="onBlur();" id="start_date" data-maxlength="300" placeholder="Start Date"
                                    required="">
                            </div>
                        </div>
                        <div class="form-group" id="end_date_div" style="display: block;">
                            <label class="col-lg-3 control-label">End</label>
                            <div class="col-lg-6">
                                <input type="text" class=" form-control datepicker" name="end_date" autocomplete="off"
                                    onblur="onBlur()" id="end_date" data-maxlength="300" placeholder="End Date"
                                    required="">
                                <input style="display: none;" type="text" class=" form-control" value=" "
                                    name="show_end_date" id="show_end_date" data-maxlength="300" placeholder="End Date"
                                    readonly>

                            </div>
                        </div>
                        <div class="form-group" id="sick_leave_file" style="display: none;">
                            <label class="col-lg-3 control-label">Sick Leave Document</label>

                            <div class="col-lg-6">

                                <input type="file" id="file" name="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" name="save" type="submit">Save</button>
                                <a href="<?php echo base_url() ?>hr/vacation" class="btn btn-danger"
                                    type="button">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    });     
</script>