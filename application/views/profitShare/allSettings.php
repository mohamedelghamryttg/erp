<!--begin::Entry-->
<div class="d-flex flex-column-fluid py-5">
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
                <span class="fas fa-times-circle"></span>
                <span><strong>
                        <?= $this->session->flashdata('error') ?>
                    </strong></span>
            </div>
        <?php } ?>
        <!--  start search form card -->    
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header flex-wrap py-6">
                <div class="card-title">
                    <h3 class="card-label">Company Target</h3>
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <form class="ml-5" action="<?php echo base_url() ?>profitShare/settings" method="get">
                            <div class="input-group input-group-sm input-group-solid" style="">
                                <input type="text" class="form-control" name="year" value="<?= $year ?? '' ?>"
                                       id="kt_subheader_search_form" placeholder="Search By Year...">
                                <div class="input-group-append">
                                    <button class="btn btn-success" name="search" type="submit"><i
                                            class="flaticon2-search-1 icon-sm"></i>Search</button>
                                    <a href="<?= base_url() ?>profitShare/settings" class="btn btn-danger"><i
                                            class="la la-trash"></i>Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-toolbar">
                    <?php if ($permission->add == 1) { ?>
                        <a class="btn btn-dark btn-sm font-weight-bolder" href="<?= base_url() ?>profitShare/addProfitShareSettings" >
                            <i class="fa fa-pen-alt"></i>add New
                        </a>

                    <?php } ?>

                </div>
            </div>
        </div>
        <!-- end search form -->

    <!--begin::Card-->
     <div class="card card-custom gutter-b example example-compact">     
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-head-custom">

                <thead>
                    <tr>
                        
                        <th>Title</th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($targets as $row) { ?>
                        <tr>                          
                            <!--<td><span class="label label-square label-default font-weight-bold">Company Target In <?= $row->year ?></span></td>-->
                            <td class="font-weight-bold">Company Target In <?= $row->year ?></td>
                            
                            <td>
                                <a title="View Report" href="<?= base_url() . 'profitShare/targetReport?t=' . base64_encode($row->id); ?>"  class="btn btn-sm btn-default mr-2 btn-hover-primary text-danger font-weight-bold">
                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"></path>
                                                                <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"></path>
                                                        </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                        </span> View Report
                                </a>
                                <?php if ($permission->edit == 1) { ?>
                                    <a title="Edit" href="<?= base_url() . 'profitShare/editProfitShareSettings?t=' . base64_encode($row->id); ?>" class="btn btn-sm btn-default mr-2  btn-hover-primary text-danger font-weight-bold">
                                        <span class="svg-icon svg-icon-primary svg-icon-md"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Design\Edit.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1" />
                                                </g>
                                            </svg><!--end::Svg Icon--></span>
                                            Edit Target
                                    </a>
                                <?php }?>
                                <?php if ($this->role == 21 || $this->role == 31) { ?>
                                    <a title="Team Leaders Kpis" href="<?= base_url() . 'profitShare/addTeamLeadersKpis?t=' . base64_encode($row->id); ?>" class="btn btn-sm btn-default mr-2  btn-hover-primary text-danger font-weight-bold">
                                        <i class="fab fa-buffer text-danger"></i>
                                            Team Leaders Kpis
                                    </a>
                                <?php }?>
                              
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <!--end: Datatable-->

        </div>
    </div>
</div>
</div>
<!--end::Card-->
<style>
    .label {
        width: auto;
        padding: 10px;
        font-size: 1rem!important;
    }
   
</style>