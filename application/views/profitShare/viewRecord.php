<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
    .custom {
        font-weight: 700;
        color: #B5B5C3 !important;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
    }

    .card-header .fa.custom {
        transition: .3s transform ease-in-out;
    }

    .card-header .collapsed .fa.custom {
        transform: rotate(90deg);
    }
</style>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
            <!-- start search form card -->
            <div class="card card-custom gutter-b example example-compact" id='ticket_info'>
                <div class="card-header">
                    <h3 class="card-title text-danger"> View Ticket #<?= $ticket->id ?></h3>
                </div>
                <div class="card-body">
                    <table class="table table-head-custom table-hover" width="100%" id="kt_datatable2">
                        <thead>
                            <tr>
                                <th colspan="2">Ticket Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <p class="text-success font-weight-bolder">Ticket From</p>
                                </td>
                                <td width="60%"><?= $this->automation_model->getEmpName($ticket->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Department</p>
                                </td>
                                <td><?= $this->automation_model->getEmpDep($ticket->emp_id); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Date</p>
                                </td>
                                <td><?= $ticket->created_at ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="text-success font-weight-bolder">Ticket Type</p>
                                </td>
                                <td>
                                    <?= $ticket->ticket_type ?>
                                </td>
                            </tr>
                            

                        </tbody>
                    </table>
                </div>
               
            </div>


        </div>
    </div>
</div>