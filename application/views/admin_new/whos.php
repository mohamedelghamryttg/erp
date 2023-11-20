<style>
    .text-wrap {
        white-space: normal !important;

    }

    table.dataTable.nowrap th,
    table.dataTable.nowrap td {
        white-space: normal !important;
    }

    .hidden {
        display: none;
    }
</style>
<div class="content d-flex flex-column flex-column-fluid py-0" id="kt_content">
    <div class="d-flex flex-column">
        <div class="container-fluid">

            <div class="card card-custom gutter-b example example-compact  my-0">
                <div class="card-header">
                    <h3 class="card-title">Company Directory</h3>
                </div>

                <div class="card-body py-0">
                    <form class="form" method="post" enctype="multipart/form-data" id="form">
                        <div class="form-group row my-2">

                            <label class="col-lg-2 col-form-label text-lg-right">Name:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="search_name" id="search_name" value="<?= $search_name ?? '' ?>">
                            </div>
                            <label class="col-lg-2 col-form-label text-lg-right">Email:</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="search_email" id="search_email" value="<?= $search_email ?? '' ?>">
                            </div>
                        </div>
                        <div class="form-group row my-2">
                            <label class="col-lg-2 col-form-label text-lg-right">Departments</label>
                            <div class="col-lg-4">
                                <select name="directmanager" class="form-control m-b" id="directmanager">
                                    <option selected="" value=""> -- Select Department --</option>
                                    <?= $this->admin_model->getDepartment() ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer py-2">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button class="btn btn-success mr-2" name="search" id="search" type="button" value="search"><i class="la la-search"></i>Search</button>
                                    <button class="btn btn-warning mr-2" name="submitReset" type="submit" value="submitReset"><i class="la la-trash"></i>Clear Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr class="solid my-0" style="background-color: #123455;">
                </div>
            </div>
            <!-- <div name="block_data" style="display:none;"> -->
            <div class="row">
                <div class="col-lg-12" id="tot">
                    <table id="user_data" class="table table-bordered">
                        <!-- table-striped nowrap     -->
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
            <div class="modal fade" id="DescModal" role="dialog">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h3 class='col-12 modal-title text-center' style="color: darkred;font-size: x-large;font-weight: bold;letter-spacing: 5px;">User Information </h3>
                        </div>
                        <div class="modal-body">
                            <div id="no_data"></div>
                            <div class="card-body py-0 px-0 " id="holediv">

                                <hr class="solid my-0" style="background-color: #123455;">
                                <div class="form-group row my-0">

                                    <div class="col-lg-8 my-8">
                                        <div class="form-group row my-0">
                                            <label class="col-lg-4 col-form-label text-lg-right px-0">Employee Name :</label>
                                            <div class="col-lg-8">
                                                <input type="text" readonly class="form-control-plaintext" name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row my-0">
                                            <label class="col-lg-4 col-form-label text-lg-right px-0">Email :</label>
                                            <div class="col-lg-8">
                                                <!-- <span name="email"></span> -->
                                                <input type="text" readonly class="form-control-plaintext" name="email" id="email">
                                            </div>
                                        </div>
                                        <div class="form-group row my-0">
                                            <label class="col-lg-4 col-form-label text-lg-right px-0">Phone :</label>
                                            <div class="col-lg-8">
                                                <input type="text" readonly class="form-control-plaintext" name="phone">
                                            </div>
                                        </div>
                                        <div class="form-group row my-0">
                                            <label class="col-lg-4 col-form-label text-lg-right px-0">Function :</label>
                                            <div class="col-lg-8">
                                                <input type="text" readonly class="form-control-plaintext" name="function">
                                            </div>
                                        </div>

                                        <div class="form-group row my-0">
                                            <label class="col-lg-4 col-form-label text-lg-right px-0">Position :</label>
                                            <div class="col-lg-8">
                                                <input type="text" readonly class="form-control-plaintext" name="position">
                                            </div>
                                        </div>
                                        <div class="form-group row my-0">
                                            <label class="col-lg-4 col-form-label text-lg-right px-0">Direct Manager :</label>
                                            <div class="col-lg-8">
                                                <input type="text" readonly class="form-control-plaintext" name="dmanager">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4  px-0 py-0 " id="employee_image">
                                        <img src="#" class="rounded mx-auto d-block img-thumbnail mx-0" alt="..." style="max-width:250px;">
                                    </div>
                                </div>
                                <hr class="solid my-0" style="background-color: #123455;">
                                <div id="brands"></div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {
        $.fn.DataTable.ext.pager.numbers_length = 15;
        $.fn.DataTable.ext.pager.full_numbers_no_ellipses = function(e, r) {
            var a = [],
                n = $.fn.DataTable.ext.pager.numbers_length,
                t = Math.floor(n / 2),
                l = function(e, r) {
                    var a;
                    void 0 === r ? (r = 0, a = e) : (a = r, r = e);
                    for (var n = [], t = r; t < a; t++) n.push(t);
                    return n
                }

            ;
            return (a = r <= n ? l(0, r) : e <= t ? l(0, n) : e >= r - 1 - t ? l(r - n, r) : l(e - t, e + t + 1)).DT_el = "span", ["first", "previous", a, "next", "last"]
        };

        var bTable;

        $('#search').on('click', function() {
            var directmanager = $('#directmanager').val();
            var search_name = $('#search_name').val();
            var search_email = $('#search_email').val();
            $("#user_data").dataTable().fnDestroy()
            //reinitialise datatable
            bTable = $("#user_data").dataTable({
                processing: false,
                retrieve: true,
                paging: true,
                searching: false,
                responsive: true,
                info: false,
                pageLength: 10,
                fixedHeader: true,
                scrollY: 500,
                scrollX: true,
                deferRender: true,
                scrollCollapse: true,
                select: {
                    info: true,
                    style: 'single',
                    selector: 'td:nth-child(1),td:nth-child(2)'
                },
                ajax: {
                    url: "<?php echo base_url() . 'admin/whos_data'; ?>",
                    type: "POST",
                    dataType: 'json',
                    async: true,
                    data: {
                        'search_name': search_name,
                        'search_email': search_email,
                        'searchmanager': directmanager
                    },
                    dataSrc: 'userss'
                },
                language: {
                    "emptyTable": "No data found."
                },
                columns: [{
                        'data': 'id',
                        'visible': false
                    }, {
                        'data': null,
                        render: data => data.first_name + ' ' + data.last_name + ' (' + data.user_name + ')'
                    },
                    {
                        'data': 'email'
                    }
                ],
                order: [

                ],
                columnDefs: [{
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap holes'>" + data + "</div>";
                    },
                    targets: 1
                }, {
                    render: function(data, type, full, meta) {
                        return "<div class='text-wrap holes'>" + data + "</div>";
                    },
                    targets: 2
                }, {
                    target: 1,
                    visible: false
                }]
            });
        });

        $('#user_data').on('click', 'tr', function(e) {
            e.preventDefault();
            var currentRow = $(this).closest("tr");
            var data = $('#user_data').DataTable().row(currentRow).data();
            var user_id = data['id'];
            var brands = '';
            // alert(user_id)
            if (user_id != '') {
                $.ajax({
                    url: "<?= base_url() . "admin/whos_data_det" ?>",
                    type: "POST",
                    async: true,
                    dataType: 'json',
                    data: {
                        'user_id': user_id
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        // alert(data)
                        if (data != '') {
                            // $('#tot').slideToggle(1000);
                            // $("#holediv").removeClass("hidden");
                            // $('#det').fadeToggle(1000);

                            $("input[name='name']").val((data.employee[0].emp_name) ?? '');
                            $("input[name='email']").val((data.user_mas[0].email) ?? '');
                            $("input[name='phone']").val((data.employee[0].phone + " - " + data.employee[0].emergency) ?? '');
                            $("input[name='function']").val((data.employee[0].department) ?? '');
                            $("input[name='position']").val((data.employee[0].title) ?? '');
                            $("input[name='dmanager']").val((data.employee[0].manager) ?? '');
                            try {
                                if (data.employee[0].employee_image && data.employee[0].employee_image != '') {
                                    $("#employee_image").html('<img src="<?= base_url() ?>assets/uploads/employeesImages/' + data.employee[0].employee_image + '" class="rounded mx-auto d-block img-thumbnail mx-0" alt="..." style="max-width:250px;">');
                                } else {
                                    $("#employee_image").html('');
                                }
                            } catch (err) {}

                            if (data.user_det) {
                                var brands = '';
                                $('#DescModal').modal("show");
                                for (var i = 0; i < data.user_det.length; i++) {
                                    // brands += ' <div class="container-fluid">'
                                    // brands += '<div class="form-group row my-0">';
                                    // brands += '<label class="col-lg-1 col-form-label text-lg-right px-0">Brand :</label>';
                                    // brands += '<div class="col-lg-2">';
                                    // brands += '<input type="search" readonly class="form-control-plaintext text-wrap" name="brand" value="' + data.user_det[i].brand + '">';
                                    // brands += '</div>';
                                    // brands += '<label class="col-lg-1 col-form-label text-lg-right px-0">Name :</label>';
                                    // brands += '<div class="col-lg-3">';
                                    // brands += '<input type="text" readonly class="form-control-plaintext" name="user_name" value="' + data.user_det[i].first_name + ' ' + data.user_det[i].last_name + '">';
                                    // brands += '</div>';
                                    // brands += '<label class="col-lg-1 col-form-label text-lg-right px-0">Email :</label>';
                                    // brands += '<div class="col-lg-2">';
                                    // brands += '<input type="search" readonly class="form-control-plaintext" name="user_name" value="' + data.user_det[i].email + '">';
                                    // brands += '</div>';
                                    // brands += '</div> ';
                                    // brands += '<hr class="solid my-0" style="background-color: #123455;">';
                                    // brands += '</div> ';
                                    brands += ' <div class="container-fluid">'
                                    brands += '<table class="table table-striped table-responsive ">';
                                    brands += '<div class="row">';
                                    brands += '<div class="col-lg-1 col-form-label text-lg-right px-0"><b>Brand :</b></div>';
                                    brands += '<div class="col-lg-2 col-form-label">';
                                    brands += data.user_det[i].brand;
                                    brands += '</div>';
                                    brands += '<div class="col-lg-1 col-form-label text-lg-right px-0"><b>Name :</b></div>';
                                    brands += '<div class="col-lg-3 col-form-label">';
                                    brands += data.user_det[i].first_name + ' ' + data.user_det[i].last_name;
                                    brands += '</div>';
                                    brands += '<div class="col-lg-1 col-form-label text-lg-right px-0"><b>Email :</b></div>';
                                    brands += '<div class="col-lg-2 col-form-label">';
                                    brands += data.user_det[i].email;
                                    brands += '</div>';
                                    brands += '</div> ';
                                    brands += '</table> ';
                                    // brands += '<hr class="solid my-0" style="background-color: #123455;">';
                                    brands += '</div> ';
                                }
                                // $('#no_data').addClass("hidden");

                                // $('#tot').addClass("hidden");
                                // $('#det').removeClass("col-lg-5");
                                // $('#det').addClass("col-lg-1");

                                // $('#det').removeClass("col-lg-*");
                                // $('#det').addClass("col-lg-11");

                                $('#brands').html(brands);
                            } else {
                                $('#no_data').html();
                                $("#holediv").addClass("hidden");
                                brands += '<div class="card-header">';
                                brands += '<div class="card-title">';
                                brands += "<h3>Company Directory</h3>";
                                brands += '</div>';
                                brands += '</div>';
                                brands += '<div class="card-header text-center">';
                                brands += '<div class="card-title">';
                                brands += '<h5 style="color: darkred;">No User Data for This Condation</h5>';
                                brands += '</div>';
                                brands += '</div>';
                                // brands += '</div>';
                                $('#no_data').html();

                            }
                        } else {
                            $('#no_data').html();
                            // $("#holediv").addClass("hidden");
                            brands += '<div class="card-header">';
                            brands += '<div class="card-title">';
                            brands += "<h3>Company Directory</h3>";
                            brands += '</div>';
                            brands += '</div>';
                            brands += '<div class="card-header text-center">';
                            brands += '<div class="card-title">';
                            brands += '<h5 style="color: darkred;">No User Data for This Condation</h5>';
                            brands += '</div>';
                            brands += '</div>';
                            // brands += '</div>';
                            $('#no_data').html(brands);
                        }
                        $('#loading').hide();
                    },
                    error: function(jqXHR, exception) {
                        $('#loading').hide();
                        // $("#holediv").removeClass("hidden");
                        $("#holediv").addClass("hidden");
                        $('#no_data').html();
                        brands = '<div class="card-header">';
                        brands += '<div class="card-title">';
                        brands += "<h3>Company Directory</h3>";
                        brands += '</div>';
                        brands += '</div>';
                        brands += '<div class="card-header text-center">';
                        brands += '<div class="card-title">';
                        brands += '<h5 style="color: darkred;">No User Data for This Condation</h5>';
                        brands += '</div>';
                        brands += '</div>';
                        // brands += '</div>';
                        $('#no_data').html(brands);
                    }
                })

            }
        });
    });
</script>