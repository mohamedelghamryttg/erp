var base_url = $('#base').val();
//var base_url = "https://falaq.thetranslationgate.com/";

function getCountries() {
    var region = $("#region").val();
    // alert(region);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/getCountries", { region: region }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#country").html(data);
    });
}

function CustomerData() {
    $("#LeadData").html("");
    var customer = $("#customer").val();
    //alert(customer);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/leadData", { customer: customer }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#LeadData").html(data);
    });
    $("#contact_method").val(0);
    $("#rolled_in").val(0);
    $("#feedback").val(0);
    $("#status").val(0);
    $("#paymnet").val("");
    //Opportunity ..
    $("#project_status").val(0);
}
function getContacts() {
    var lead = $('input[type=radio][name=lead]:checked').val();
    //alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/customerContact", { lead: lead }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#customerContact").html(data);
    });
}

function getLeadStatus() {
    var lead_status = $("#lead_status").val();
    if (lead_status == 2) {
        $("#rolled_status").hide();
        $("#payment_method").hide();
        $('#payment').prop('required', false);
        $('#rolled_in').prop('required', false);
        $('#pm').prop('required', false);
    } else if (lead_status == 1) {
        $("#rolled_status").show();
        $("#payment_method").show();
        $('#payment').prop('required', true);
        $('#rolled_in').prop('required', true);
        $('#pm').prop('required', true);
    }
}
function getPayment() {
    var rolled_in = $("#rolled_in").val();
    if (rolled_in == 1) {
        $("#payment_method").show();
        $('#payment').prop('required', true);
        $('#pm').prop('required', true);
    } else {
        $("#payment_method").hide();
        $('#payment').prop('required', false);
        $('#pm').prop('required', false);
    }
}

function fuzzy() {
    var cols = $("#cols").val();
    // alert(cols);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/fuzzyTable", { cols: cols }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#fuzzyTable").html(data);
    });
}
function calculateFuzzy(i) {
    var rate = $("#rate").val();
    var value = $("#value_" + i).val();
    var result = parseFloat(rate * value);
    var Min = parseFloat(rate * 250);
    // alert(rate);
    $("#result_" + i).html(result);
    $("#min").html(Min);
}
function calculateMin() {
    var rate = $("#rate").val();
    var cols = $("#cols").val();
    var Min = parseFloat(rate * 250);
    $("#min").html(Min);
    for (var i = 1; i <= cols; i++) {
        var value = $("#value_" + i).val();
        var result = parseFloat(rate * value);
        $("#result_" + i).html(result);
    }
}
function rateCode(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if (charCode == 46) {
        return true;
    } else if (charCode >= 48 && charCode <= 57) {
        return true;
    } else if (charCode == 8 || charCode == 9) {
        return true;
    }
    else {
        return false;
    }
    // alert(charCode);

}
function numbersOnly(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if (charCode > 31 && (charCode < 46 || charCode == 47 || charCode > 57)) {
        return false;
    }

    return true;
}

function getPriceList() {
    var lead = $("#lead").val();
    var product_line = $("#product_line").val();
    // alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/showPriceList", { lead: lead, product_line: product_line }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#PriceList").html(data);
    });
}

function getPriceListByService() {
    $("#PriceList").html("");
    var lead = $("#lead").val();
    var service = $("#service").val();
    var product_line = $("#product_line").val();
    // alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/showPriceListByService", { lead: lead, product_line: product_line, service: service }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#PriceList").html(data);
    });
}

function getPriceListByServiceAndIteration(i) {
    $("#PriceList").html("");
    var lead = $('input[type=radio][name=lead]:checked').val();
    var service = $("#service_" + i).val();
    var product_line = $("#product_line").val();
    // alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/showPriceListByServiceIteration/" + i, { lead: lead, product_line: product_line, service: service }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#PriceList_" + i).html(data);
    });
}

function getCheckedPriceListIdRate() {
    var priceId = $('input[type=radio][name=price_list]:checked').val();
    $("#total_revenue").val(0);
    $("#fuzzy").html("");
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/getPriceListFuzzy", { priceId: priceId }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#fuzzy").html(data);
    });
}

function getCheckedPriceListIdRateByIteration(i) {
    var priceId = $('input[type=radio][name=price_list_' + i + ']:checked').val();
    $("#total_revenue").val(0);
    $("#fuzzy").html("");
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/getPriceListFuzzyByIteration/" + i, { priceId: priceId }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#fuzzy_" + i).html(data);
    });
}

function fuzzyCalculation(x) {
    var id = $('input[type=radio][name=price_list]:checked').attr('id');
    var rate = $("#rate_" + id).val();
    var num = $("#unit_number_" + x).val();
    var value = $("#value_" + x).val();

    var total = parseFloat(rate * num * value);

    $("#total_price_" + x).val(total);

}

function fuzzyCalculationByIteration(x, i) {
    var id = $('input[type=radio][name=price_list_' + i + ']:checked').attr('id');
    var rate = $("#rate_" + id + "_" + i).val();
    var num = $("#unit_number_" + x + "_" + i).val();
    var value = $("#value_" + x + "_" + i).val();

    var total = parseFloat(rate * num * value);
    $("#total_price_" + x + "_" + i).val(total);

}

function projectFuzzy() {
    var total_rows = $("#total_rows").val();
    // alert(total_rows);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/projectFuzzy", { total_rows: total_rows }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#fuzzy").html(data);
    });
}

function projectFuzzyByIteration(i) {
    var total_rows = $("#total_rows_" + i).val();
    // alert(total_rows);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/projectFuzzyByIteration/" + i, { total_rows: total_rows }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#fuzzy_" + i).html(data);
    });
}


function totalRevenue(num) {
    var total = 0;
    for (var i = 1; i <= num; i++) {
        var totalRow = $("#total_price_" + i).val();
        total = parseFloat(total) + parseFloat(totalRow);
    }
    $("#total_revenue").val(total);
}

function totalRevenueByIteration(num, x) {
    var total = 0;
    for (var i = 1; i <= num; i++) {
        var totalRow = $("#total_price_" + i + "_" + x).val();
        total = parseFloat(total) + parseFloat(totalRow);
    }
    $("#total_revenue_" + x).val(total);
}

function totalRevenueVolume() {
    var id = $('input[type=radio][name=price_list]:checked').attr('id');
    var rate = $("#rate_" + id).val();
    var volume = $("#volume").val();
    var total = parseFloat(rate * volume);
    $("#total_revenue").val(total);
}

function totalRevenueVolumeByIteration(i) {
    var id = $('input[type=radio][name=price_list_' + i + ']:checked').attr('id');
    var rate = $("#rate_" + id + "_" + i).val();
    var volume = $("#volume_" + i).val();
    var total = parseFloat(rate * volume);
    $("#total_revenue_" + i).val(total);
}

function getCustomerData() {
    var customer = $("#customer").val();
    // alert(customer);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/leadDataPm", { customer: customer }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#LeadData").html(data);
    });
    // getPriceList();
    // getProductLineByLead();
}

function getProductLineByLead() {
    var lead = $('input[type=radio][name=lead]:checked').val();
    // alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/getProductLineByCustomer", { lead: lead }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#product_line").html(data);
    });
}

function getCustomerDataAccounting() {
    var customer = $("#customer").val();
    // alert(customer);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/leadDataAccounting", { customer: customer }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#LeadData").html(data);
    });
}

function getCustomerDataPayment() {
    var customer = $("#customer").val();
    // alert(customer);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/leadDataPayment", { customer: customer }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#LeadData").html(data);
    });
}


function getTaskType() {
    var service = $("#service").val();
    // alert(service);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/getTaskType", { service: service }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#task_type").html(data);
    });
}


function getTaskTypeByNumber(x) {
    var service = $("#service_" + x).val();
    // alert(service);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/getTaskType", { service: service }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#task_type_" + x).html(data);
    });
}

function getDepartment() {
    var division = $("#division").val();
    // alert(service);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/getDepartment", { division: division }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#department").html(data);
    });
}

function getTitle() {
    var department = $("#department").val();
    var division = $("#division").val();
    // alert(department);
    // alert(division);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/getTitle", { department: department, division: division }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#title").html(data);
    });
}

function getTitleData() {
    var title = $("#title").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/getTitleData", { title: title }, function (data) {
        //alert(data);
        $('#loading').hide();
        document.getElementById("titleData").innerHTML = data;
    });
}

function getDirectManagerByTitle() {
    var title = $("#title").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/getDirectManagerByTitle", { title: title }, function (data) {
        //alert(data);
        $('#loading').hide();
        document.getElementById("manager").innerHTML = data;
    });
}

function ticketReqType() {
    var reqType = $("#request_type").val();
    if (reqType == 1 || reqType == 5 || reqType == 4) {
        $("#resouceNumber").show();
        $('#number_of_resource').prop('required', true);
    } else {
        $("#resouceNumber").hide();
        $('#number_of_resource').prop('required', false);
    }
}

function checkResouceNumber() {
    var reqType = $("#request_type").val();
    var number = $("#number_of_resource").val();
    var rate = $("#rate").val();
    var count = $("#count").val();
    if (reqType == 1 || reqType == 5 || reqType == 4) {
        if (number < 1) {
            alert("You must add 1 resource at least ..");
            return false;
        }
    }
    if (rate <= 0) {
        if (reqType != 2) {
            alert("Rate should be more than 0 ");
            return false;
        } else if (reqType == 2 && rate < 0) {
            alert("Rate should be equal or more than 0");
            return false;
        }
    } if (count <= 0) {
        alert("Count should be more than 0 ");
        return false;
    }
}

function searchOptions() {
    var select = $("#vendor");
    var options = [];
    var textbox = $("#vendor_name");
    $("#vendorList").find('option').each(function () {
        // alert($(this).val()+" - "+$(this).text());
        options.push({
            value: $(this).val(),
            text: $(this).text()
        });
    });
    $(select).data('options', options);

    $(textbox).bind('change keyup', function () {
        var options = $(select).empty().data('options');
        var search = $.trim($(this).val());
        var regex = new RegExp(search, "gi");

        $.each(options, function (i) {
            var option = options[i];
            if (option.text.match(regex) !== null) {
                $(select).append(
                    $('<option>').text(option.text).val(option.value)
                );
            }
        });
    });
}

function checkTicketStatus() {
    var request_type = $("#request_type").val();
    var status = $("#status").val();
    var resources = $("#number_of_resource").val();
    if (status == 4 && request_type == 1) {
        alert("Closed ..");
        for (var i = 1; i <= resources; i++) {
            $('#ticket_response_type_' + i).prop('required', true);
        }
    } else {
        // $("#vendorSheet").hide();
    }
}
function checkCommentReject() {
    // var reason = $("#reject_reason").val();
    $('#reject_reason').prop('required', true);
    return true;
}
function checkCommentSave() {
    // var reason = $("#reject_reason").val();
    $('#reject_reason').prop('required', false);
    return true;
}

function checkPriceListForm() {
    var price_list = $("input[name='price_list']").val();
    //alert(price_list);
    if (price_list === undefined) {
        alert(" Please make sure to select from price list ... ");
        return false;
    } else {
        return true;
    }
}

function getVendorData(source, target) {
    $("#vendorData").html("");
    var vendor = $("#vendor").val();
    var task_type = $("#task_type").val();
    // alert(vendor);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/getVendorData", { vendor: vendor, task_type: task_type, source: source, target: target }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#vendorData").html(data);
    });
    $("#count").val("");
    $("#total_cost").val(0);
}

function getVendorDataLEFreelancer() {
    var vendor = $("#vendor").val();
    // alert(vendor);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/getVendorDataLEFreelancer", { vendor: vendor }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#vendorData").html(data);
    });
    $("#count").val("");
    $("#total_cost").val(0);
}

function getVendorByTask(service, source, target) {
    var task_type = $("#task_type").val();
    var flag = $("#flag").val() ? $("#flag").val() : 0;

    $.ajax({
        type: "POST",
        url: base_url + "vendor/getVendorByTask/" + flag,
        data: { service: service, task_type: task_type, source: source, target: target },
        cache: false,
        beforeSend: function () {
            $('#loading').show();
        },
        success: function (data) {
            $('#loading').hide();
            $("#vendor").html(data);
        },
        error: function (request, status, error) {
            $('#loading').hide();
            $("#vendor").html("");
        }
    });

    // $.ajaxSetup({
    //     beforeSend: function () {
    //         $('#loading').show();
    //     },
    // });
    // $.post(base_url + "vendor/getVendorByTask/" + flag, { service: service, task_type: task_type, source: source, target: target }, function (data) {
    //     $('#loading').hide();
    //     // alert(data);
    //     $("#vendor").html(data);
    // });
    // $("#vendorData").html("");
}


function calculateVendorCost(i) {
    var check = $("input[type=radio][name=select]:checked").val();
    var count = $("#count").val();
    var rate = $("#rate_" + i).val();
    if (check == i) {
        var total_cost = parseFloat(rate * count);
        $("#total_cost").val(total_cost);
    }
}

function calculateVendorCostEdit() {
    var count = $("#count").val();
    var rate = $("#rate").val();
    var total_cost = parseFloat(rate * count);
    $("#total_cost").val(total_cost);
}

function calculateVendorCostChecked() {
    var vendor = $("#vendor").val();
    if (vendor == "all") {
        var rate = $("#sendToAllVendors input[name='rate']").val();
    } else {
        var check = $("input[type=radio][name=select]:checked").val();
        var rate = $("#rate_" + check).val();
    }

    // alert(check);
    var count = $("#count").val();
    var total_cost = parseFloat(rate * count);
    $("#total_cost").val(total_cost);
}

function checkAll() {
    $(".checkPo").attr('checked', true);
}

function unCheckAll() {
    $(".checkPo").attr('checked', false);
}

function checkPoVerifyForm() {
    checked = $("input[type=checkbox]:checked").length;

    if (!checked) {
        alert("You must check at least one PO to verify.");
        return false;
    }
}

function checkJobVerifyForm() {
    checked = $("input[type=checkbox]:checked").length;

    if (!checked) {
        alert("You must check at least one Job to close.");
        return false;
    }
}

function checkPO() {
    var po = $("#po").val();
    var id = $("#id").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "projects/checkProjectPo", { po: po, id: id }, function (data) {
        $('#loading').hide();
        if (data == 0) {
            alert("PO Already Exist In Another Project ..");
            return false;
        } else if (data == 1) {
            return true;
        }
    });
}

function getVirifiedPoByCustomer() {
    $("#VerifiedPOs").html("");
    var lead = $('input[type=radio][name=lead]:checked').val();
    //  alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getVirifiedPoByCustomer", { lead: lead }, function (data) {
        $('#loading').hide();
        $("#VerifiedPOs").html(data);
    });
}

function getPaymentData() {
    var customer = $("#customer").val();
    var issue_date = $("#issue_date").val();
    // alert(customer);
    $("#paymentData").html("");
    if (customer) {
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "accounting/getPaymentData", { customer: customer, issue_date: issue_date }, function (data) {
            $('#loading').hide();
            // alert(data);
            $("#paymentData").html(data);
        });
    }
}

function clearPaymentData() {
    $("#paymentData").html("");
    $("#issue_date").val("");
}

function getInvoiceTotal() {
    var total = 0;
    $("input:checkbox[class=pos]:checked").each(function () {
        total = parseFloat(total) + parseFloat($(this).attr('title'));
    });
    $("#total_revenue").val(total);
}

function getClientInvoices() {
    var lead = $('input[type=radio][name=lead]:checked').val();
    $("#invoices").html("");
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getClientInvoices", { lead: lead }, function (data) {
        $('#loading').hide();
        $("#invoices").html(data);
    });
}

function getClientInvoicedPOs() {
    var customer = $("#customer").val();
    var payment_date = $("#payment_date").val();
    var currency = $("#currency").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getClientInvoicedPOs", { customer: customer, payment_date: payment_date, currency: currency }, function (data) {
        $('#loading').hide();
        $("#invoicedPOs").html(data);
    });
}

function getAdvancedPayments() {
    var customer = $("#customer").val();
    var currency = $("#currency").val();
    var payment_date = $("#payment_date").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getAdvancedPayments", { customer: customer, currency: currency, payment_date: payment_date }, function (data) {
        $('#loading').hide();
        $("#advancedPayments").html(data);
    });
}

function getCreditNotePayment() {
    var customer = $("#customer").val();
    var currency = $("#currency").val();
    var payment_date = $("#payment_date").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getCreditNotePayment", { customer: customer, currency: currency, payment_date: payment_date }, function (data) {
        $('#loading').hide();
        $("#creditNote").html(data);
    });
}

function getTotalCreditNote() {
    var total = 0;
    $("input:checkbox[class=creditNote]:checked").each(function () {
        var poTotal = $(this).attr('title');;
        total = parseFloat(poTotal) + total;
    });
    // alert(total);
    $("#total_credit_note").val(total);
}

function checkPoPayment() {
    $(".checkPoPayment").attr('checked', true);
}

function uncheckPoPayment() {
    $(".checkPoPayment").attr('checked', false);
}

function checkDeductionPaymentValue() {
    var deductions = $("#deductions").val();
    // alert(deductions);
    if (deductions > 0) {
        $("#deduction_reason").val(2);
    } else {
        $("#deduction_reason").val(1);
    }
}

function getPymentTotal() {
    var total = 0;
    var deductions = $("#deductions").val();
    var advanced_payment = $("#advanced_payment").val();
    var paymentOldAdvanced = 0;
    var creditNoteOld = 0;
    $("input:checkbox[class=checkPoPayment]:checked").each(function () {
        var poTotal = $(this).attr('title');;
        total = parseFloat(poTotal) + total;
    });
    $("input:checkbox[class=payment]:checked").each(function () {
        var payment = $(this).attr('title');;
        paymentOldAdvanced = parseFloat(payment) + paymentOldAdvanced;
    });
    $("input:checkbox[class=creditNote]:checked").each(function () {
        var creditNote = $(this).attr('title');;
        creditNoteOld = parseFloat(creditNote) + creditNoteOld;
    });
    // alert(total);
    var result = parseFloat(total) + parseFloat(advanced_payment) - parseFloat(deductions) - parseFloat(paymentOldAdvanced) - parseFloat(creditNoteOld);
    $("#net_amount").val(result);
}

function checkAddInvoice() {
    var projects = $("input:checkbox[id=projects]:checked").val();
    if (projects === undefined) {
        alert(" Please make sure to select from PO's list ... ");
        return false;
    } else {
        return true;
    }
}

function checkAddPayment() {
    var projects = $("input:checkbox[class=checkPoPayment]:checked").val();
    if (projects === undefined) {
        alert(" Please make sure to select from PO list ... ");
        return false;
    } else {
        return true;
    }
}

function checkDate(x) {
    var selectedDate = $("#" + x).val();

    dateTimeParts = selectedDate.split(' '),
        timeParts = dateTimeParts[1].split(':'),
        dateParts = dateTimeParts[0].split('-'),
        date = new Date(dateParts[0], parseInt(dateParts[1], 10) - 1, dateParts[2], timeParts[0], timeParts[1]);
    selected = date.getTime();
    console.log(selected);

    var n = Date.now();
    console.log(n);

    if (n > selected) {
        alert("Error, The selected date must be start from now ..");
        $("#" + x).val("");
        if ($("#" + x).hasClass('date_sheet_day')) {
            $("#" + x).trigger("click");
        }
    } else {
    }
}

function getVendorInfo() {
    $("#vendorData").html("");
    var vendor = $("#vendor").val();
    //alert(vendor);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/getVendorInfo", { vendor: vendor }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#vendorData").html(data);
    });
}

function getVendorVerifiedTasks() {
    $("#tasks").html("");
    var vendor = $("#vendor").val();
    //alert(vendor);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getVendorVerifiedTasks", { vendor: vendor }, function (data) {
        $('#loading').hide();
        //alert(data);
        $("#tasks").html(data);
    });
}

function addTaskForm() {
    var vendor = $("#vendor").val();
    if (vendor == "all") {
        if ($('#vendorData input[type=checkbox]:checked').length > 0) {
            return true;
        } else {
            alert(" Please select al least one vendor ... ");
            return false;
        }
    } else {
        var select = $("input[name='select']").val();
        if (select != 1) {
            alert(" Please check vendor data ... ");
            return false;
        } else {
            return true;
        }
    }

}

function showAndHide(div, button) {
    //alert("here");
    //alert(div);
    //alert(button);
    var check = $("#" + div).is(":visible");
    if (check == false) {
        $("#" + div).show();
        $("#" + button).html("<i class='fa fa-chevron-up'></i>");
    } else {
        $("#" + div).hide();
        $("#" + button).html("<i class='fa fa-chevron-down'></i>");
    }
}
function showAndHide2(div, button) {
    //alert("here");
    //alert(div);
    //alert(button);
    var check = $("#" + div).is(":visible");
    if (check == false) {
        $("#" + div).show();
        $("#" + button).html("<i class='far fa-arrow-alt-circle-up'></i>");
    } else {
        $("#" + div).hide();
        $("#" + button).html("<i class='far fa-arrow-alt-circle-down'></i>");
    }
}

function clearJobs() {
    $("#new_job_div").html("");
    $("#new_job").val(1);
}

function deleteSamCustomer(t, rowId) {
    // alert(t);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/deleteSamCustomer", { t: t, rowId: rowId }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#SamTable_" + rowId).html(data);
    });
}

function assignSamCustomer(rowId) {
    var lead = $("#lead_" + rowId + "").val();
    var customer = $("#customer_" + rowId + "").val();
    var sam = $("#sam_" + rowId + "").val();
    if (!sam) {
        alert('please Select Sam ');
        return false;
    }
    // alert(lead);
    // alert(customer);
    // alert(sam);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/assignSamCustomer", { lead: lead, customer: customer, sam: sam }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#SamTable_" + rowId).html(data);
    });
}

function selectDialect() {
    var language = $("#target").val();
    // alert(language);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/getDialect", { language: language }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#dialect").html(data);
    });
}

function getDTPRate() {
    var target_direction = $("#target_direction").val();
    var source_application = $("#source_application").val();
    var translation_in = $("#translation_in").val();
    // alert(translation_in);
    // alert(source_application);
    // alert(target_direction);
    if (target_direction != null && source_application != null && translation_in != null) {
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "dtp/getDTPRate", { target_direction: target_direction, source_application: source_application, translation_in: translation_in }, function (data) {
            $('#loading').hide();
            // alert(data);
            $("#rate").val(data);
        });
    }
}

function translationAction() {
    var status = $("#status").val();
    // alert(status);
    if (status == 0 || status == 5) {
        $("#comment").html(`<label class="col-sm-3 control-label">Reason</label>
                                    <div class="col-sm-6">
                                        <textarea name="reason" id="reason" class="form-control" value="" rows="6"></textarea>
                                    </div>`);
        tinymce.init({ selector: 'textarea' });
    } else {
        $("#comment").html(``);
    }
}

function getAssignedPM() {
    var lead = $('input[type=radio][name=lead]:checked').val();
    // alert(lead);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/getAssignedPM", { lead: lead }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#pm").html(data);
    });
}

function disableAddButton() {
    // document.getElementsByClassName("disableAdd")[0].disabled = true;
    document.getElementsByClassName("disableAdd")[0].style.visibility = 'hidden';
    return true;
}

function getInHouseTeam() {
    var team = $("#team").val();
    //alert(team);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "report/getInHouseTeam", { team: team }, function (data) {
        $('#loading').hide();
        //alert(data);
        $("#inHouseTeam").html(data);
    });
}

function vendoremail() {
    var email = $("#vendorEmail").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/validateEmail", { email: email.trim() }, function (data) {
        if (data == 1) {
            alert("Email is already Exist, Please enter another email ..");
            $("#vendorEmail").val("");
        }
        $('#loading').hide();
    });
}
function vendoremailedit() {
    var email = $("#vendorEmailEdit").val();
    var id = atob($("#id").val());
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/validateEmailEdit", { email: email.trim(), id: id }, function (data) {
        if (data == 1) {
            alert("Email is already Exist, Please try another email ..");
            $("#vendorEmailEdit").val("");
        } else if (data != 1) {
        }
        $('#loading').hide();
    });
}

function vendorTicketEmail(id) {
    var email = $("#email_" + id).val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/validateEmail", { email: email }, function (data) {
        if (data == 1) {
            alert("Email is already Exist, Please enter another email ..");
            $("#email_" + id).val("");
        }
        $('#loading').hide();
    });
}

function checkBoxes(className) {
    $("." + className).attr('checked', true);
}

function uncheckBoxes(className) {
    $("." + className).attr('checked', false);
}

// Marketing and leads activity comments ///

function openDiv(id) {
    // alert(id);
    $(".divComments").hide();
    $("#comments_" + id).show();
}

function hideDiv(id) {
    $("#comments_" + id).hide();
}

function addComment(x) {
    var activity = $("#activity_" + x).val();
    var lead = $("#lead").val();
    var comment = tinyMCE.get('chat_' + x).getContent();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/addLeadComment", { lead: lead, activity: activity, comment: comment }, function (data) {
        alert(data);
        $('#loading').hide();
        window.location.href = base_url + "customer/editLead?t=" + btoa(lead);
    });

}

function addCommentSales() {
    var activity = $("#activity").val();
    var lead = $("#lead").val();
    var comment = tinyMCE.get('chat').getContent();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/addSalesComment", { lead: lead, activity: activity, comment: comment }, function (data) {
        alert(data);
        $('#loading').hide();
        window.location.href = base_url + "sales/editSalesActivity?t=" + btoa(activity);
    });
}

//start vacation

function calculateAvailableVacationDays(ifEdit) {
    var type_of_vacation = $("#type_of_vacation").val();
    var relative_degree = $("#relative_degree").val();
    var emp_id = $("#emp_id").val();
    // for rest leave
    if (type_of_vacation == 8) {
        $("#available_days_div").hide();
    } else {
        $("#available_days_div").show();
    }
    if (type_of_vacation == 3) {

        $("#sick_leave_file").show();
    } else {
        $("#sick_leave_file").hide();
    }
    if (relative_degree == null) {
        relative_degree = 0;
        $("#relative_degree").val("0");
    } else {
        relative_degree = $("#relative_degree").val();
    }
    if (type_of_vacation == 4 || type_of_vacation == 5 || type_of_vacation == 6 || type_of_vacation == 7) {
        $("#requested_days_div").hide();
        $("#end_date").removeAttr("required").attr('readonly', true);
        if (type_of_vacation == 6) {
            $("#relative_degree_div").show();
        } else {
            $("#relative_degree_div").hide();
        }
    } else {
        $("#requested_days_div").show();
        $("#relative_degree_div").hide();
    }

    // for half day case
    if (type_of_vacation == 1 || type_of_vacation == 2) {
        $("#day_type_div").show();
        if (ifEdit == 1) {
            var requested = $("#requested_days").val();
            if (requested == 0.5) {
                $("#end_date").hide();
                $("#show_end_date").show().val('');
            }
        }
    }
    else {
        $("#day_type_div").hide();
    }

    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/calculateAvailableVacationDays", { type_of_vacation: type_of_vacation, relative_degree: relative_degree, emp_id: emp_id }, function (data) {
        if (data <= 0 && type_of_vacation != 6) {
            alert("Sorry.You have no vacation balance ..");
            if (type_of_vacation == 6) {
                $("#available_days").val("0");
            } else {
                //alert("Sorry.You have no vacation balance ..");
                $("#available_days").val("0");
            }
        } else {
            if (ifEdit == 1) {
                $("#available_days").val(data);
            } else {
                $("#available_days").val(data);
                $("#start_date").val(" ");
                $("#end_date").val(" ");
                $("#requested_days").val('');
                $("#show_end_date").val("");
            }
        }
        $('#loading').hide();
    });
}
function checkVacationCredite() {
    var start_date = $("#start_date").val();
    var emp_id = $("#emp_id").val();
    if ($("#day_type").val() == 1) {
        $("#end_date").val(start_date);
    }
    var end_date = $("#end_date").val();
    var type_of_vacation = $("#type_of_vacation").val();
    var available_days = $("#available_days").val();
    var day_type = $("#day_type").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/checkVacationCredite", { start_date: start_date, end_date: end_date, type_of_vacation: type_of_vacation, day_type: day_type, emp_id: emp_id }, function (data) {
        var json = JSON.parse(data);
        if (json.available_days < 0 || json.requested_days > available_days) {
            alert("Sorry,Your balance is not enough ..");
            $("#requested_days").val("0");
        } else {
            //check for casusal leave requested days must be day or two only
            if (type_of_vacation == 2 & json.requested_days > 2) {
                alert("Casusal Request shouled be only one or two days ");
                $("#requested_days").val("0");
                $("#start_date").val("");
                $("#end_date").val("");
            } else {
                $("#availableDays").val(json.available_days);
                $("#requested_days").val(json.requested_days);
                showEndDate();
            }

            calculateHalfDayVacation();
        }
        $('#loading').hide();
    });
}
function calculateHalfDayVacation() {
    var start_date = $("#start_date").val();
    if ($("#day_type").val() == 1) {
        $("#end_date").hide().val(start_date);
        $("#show_end_date").show().val('');
    } else {
        $("#end_date").show();
        $("#show_end_date").hide().val('');
    }

}
function onAddVacationRequest() {
    if ($("#type_of_vacation").val() == 1 || $("#type_of_vacation").val() == 2 || $("#type_of_vacation").val() == 3 || $("#type_of_vacation").val() == 8) {
        if ($("#requested_days").val() == 0) {
            alert("Requested Days can not be equal 0");
            return false;
        }
    }
}
function calculateVacationDate() {
    var start_date = $("#start_date").val();
    start_date_time = new Date(start_date);
    start_date_time_gettime = start_date_time.getTime();
    var end_date = $("#end_date").val();
    end_date_time = new Date(end_date);
    end_date_time_gettime = end_date_time.getTime();
    var today = new Date();
    var todayDate = today.getTime();
    var type_of_vacation = $("#type_of_vacation").val();
    if (end_date_time_gettime < start_date_time_gettime) {
        alert("choose correct date");
        $("#start_date").val("");
        $("#end_date").val("");
        $("#requested_days").val("");
    }

    var emp_id = $("#emp_id").val();
    //console.log(emp_id);
    if (isNaN(emp_id)) {
        if (type_of_vacation != 2 && type_of_vacation != 3 && todayDate > start_date_time_gettime) {
            if (type_of_vacation != 6 && type_of_vacation != 8) {
                alert("you can not choose old date");
                $("#start_date").val("");
                $("#end_date").val("");
                $("#requested_days").val("");
            }
        }
    }

}
function showEndDate() {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var type_of_vacation = $("#type_of_vacation").val();
    var relative_degree = $("#relative_degree").val();
    if (type_of_vacation == 4 || type_of_vacation == 5 || type_of_vacation == 6 || type_of_vacation == 7) {
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "hr/showEndDate", { start_date: start_date, end_date: end_date, type_of_vacation: type_of_vacation, relative_degree: relative_degree }, function (data) {
            //$("#end_date").removeAttr("required").removeClass("datepicker").attr('readonly', true).val(data);
            $("#end_date").hide();
            $("#show_end_date").show().val(data);
            $('#loading').hide();
        });
    }

}

function onApproveGetAvailableDays() {
    // alert("test");
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var emp_id = $("#emp_id_").val();
    var type_of_vacation = $("#type_of_vacation_").val();
    var day_type = $("#day_type").val();
    var return_data = "";
    if ($("#status").val() == 1 && type_of_vacation != 6) {
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "hr/onApproveGetAvailableDays", { start_date: start_date, end_date: end_date, emp_id: emp_id, type_of_vacation: type_of_vacation, day_type: day_type }, function (data) {
            var json = JSON.parse(data);
            // alert(json.available_days);
            // alert(json.requested_days);
            //if(json.available_days <= 0 || json.requested_days > available_days){
            if (json.available_days < 0 || json.requested_days > available_days) {
                alert("Sorry,This user has not enough balance please reject the request ..");
                //alert(json.available_days);
                return_data = 0;
                $("#return_available_days").val("0");
            } else {
                return_data = 1;
                $("#return_available_days").val("1");
            }
            $('#loading').hide();
        });
    } else {
        $("#return_available_days").val("1");
    }

}
function onApprove() {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var emp_id = $("#emp_id_").val();
    var type_of_vacation = $("#type_of_vacation_").val();
    var return_data = "";
    if ($("#status").val() == 1) {
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "hr/onApprove", { start_date: start_date, end_date: end_date, emp_id: emp_id }, function (data) {
            if (data >= 1) {
                alert("This request contain days on another approved request. So please, reject this request");
                return_data = 0;
                $("#return").val("0");
            } else {
                return_data = 1;
                $("#return").val("1");
            }
            $('#loading').hide();
        });
    } else {
        $("#return").val("1");
    }

}

function responseVactionRequest() {
    //  if($("#return").val() == 0){
    //    return false;
    // }

    if ($("#return").val() == 0 || $("#return_available_days").val() == 0) {
        return false;
    }
}
function onBlur() {
    checkVacationCredite();
    calculateVacationDate();
}

// End ////

// Attendance //

// End // 

function employeeStatus() {
    var empStatus = $("#status").val();
    if (empStatus == 1) {
        $("#employeeResignation").show();
        $("#resignation_reason").show();
        $("#resignation_comment").show();
        $('#resignation_date').prop('required', true);
    } else {
        $("#employeeResignation").hide();
        $("#resignation_reason").hide();
        $("#resignation_comment").hide();
        $('#resignation_date').prop('required', false);
    }
}

//////////// social insurance 
function getGenderAndDateOfBirth() {
    var employee_id = $("#employee").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/getGenderAndDateOfBirth", { employee_id: employee_id }, function (data) {
        var json = JSON.parse(data);
        if (json.gender == 1) {
            $("#gender").val("Male");
        } else if (json.gender == 2) {
            $("#gender").val("Female");
        }
        $("#dateOfBirth").val(json.birth_date);
        $('#loading').hide();
    });
}

// Medical Insurance ..
function removeFamilyMemberTable(rowId) {
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/removeFamilyMemberTable", { id: rowId }, function (data) {
        // alert(data);
        $('#loading').hide();
        if (data == 1) {
            $("#memberTable_" + rowId).remove();
        } else {
            alert("Falied to remove, please try again !");
        }
    });
}

//lost opportunity 6/2/2020 
function getLostOpportunityPM() {
    var customer_id = $('#customer').val();
    var lead = $('input[type=radio][name=lead]:checked').val();
    //alert(customer_id);

    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/getLostOpportunityPM", { customer_id: customer_id, lead: lead }, function (data) {
        $('#loading').hide();
        //alert(data);
        $("#pm").html(data);
    });
}
function CalculateTotalRevenueForLostOpportunities() {
    var rate = $("#rate").val();
    var volume = $("#volume").val();
    //alert(rate); 
    //alert(volume);

    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "sales/CalculateTotalRevenueForLostOpportunities", { rate: rate, volume: volume }, function (data) {
        $('#loading').hide();
        //alert(data);
        $("#total_revenue").val(data);
    });
}

function getClientInvoicedPOsSingleChoose() {
    var customer = $("#customer").val();
    var payment_date = $("#payment_date").val();
    var currency = $("#currency").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getClientInvoicedPOsSingleChoose", { customer: customer, payment_date: payment_date, currency: currency }, function (data) {
        $('#loading').hide();
        $("#invoicedPOs").html(data);
    });
}

function getPoCreditNoteAmount() {
    var result = $("input:radio[class=pos]:checked").attr('title');
    //alert(result);
    $("#po_amount").val(result);
}

function getClientInvoicedPOsMultipleChoose() {
    var customer = $("#customer").val();
    var payment_date = $("#payment_date").val();
    var currency = $("#currency").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getClientInvoicedPOsMultipleChoose", { customer: customer, payment_date: payment_date, currency: currency }, function (data) {
        $('#loading').hide();
        $("#invoicedPOs").html(data);
    });
}

function getCommissionEmail() {
    var commission = $("#commission").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "projects/getCommissionEmail", { commission: commission }, function (data) {
        $('#loading').hide();
        $("#email").html(data);
    });
}

function getCommissionRate() {
    var commission = $("#commission").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "projects/getCommissionRate", { commission: commission }, function (data) {
        $('#loading').hide();
        $("#rate").val(data);
    });
}
//holidays plan 
function validateHolidayDate(x) {
    if(x !=0)
    var holiday_date = $("#holiday_date_" + x).val();
    else
    var holiday_date = $("#holiday_date").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/validateHolidayDate", { holiday_date: holiday_date }, function (data) {
        $('#loading').hide();
        if (data > 0) {
            $("#holiday_date_" + x).val("");
            $("#holiday_date").val("");
            alert(" This day already a holiday .Please choose another day ");
        }
    });
}
//pm conversion request
function pmConversionRequest() {
    var attachment_type = $("#attachment_type").val();
    if (attachment_type == 1) {

        $("#file_attachment").show();
        $("#link").hide();
        $("#link_").removeAttr("required");
    } else if (attachment_type == 2) {
        $("#link").show();
        $("#file_attachment").hide();
        $("#file_attachment_").removeAttr("required");
    }
}

//Missing attendance 
function missingAttendanceApprovalForManager(rowId) {
    var manager_approval = $("#manager_approval_" + rowId + "").val();
    var id = $("#id_" + rowId + "").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/missingAttendanceApprovalForManager", { id: id, manager_approval: manager_approval }, function (data) {

        $("#approval").load(window.location.href + " #approval");
        $(".card-label-count").load(window.location.href + " .card-label-count");
        $(".nav-text-count").load(window.location.href + " .nav-text-count");
        $('#loading').hide();
        //location.reload();
    });
}

function missingAttendanceApprovalForHR(rowId) {
    var hr_approval = $("#hr_approval_" + rowId + "").val();
    var id = $("#id_" + rowId + "").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/missingAttendanceApprovalForHR", { id: id, hr_approval: hr_approval }, function (data) {
        $("#approval").load(window.location.href + " #approval");
        $('#loading').hide();
        // location.reload();

    });
}

/////// 

//vendor ticket issue 

function addIssueToVendorTicket(rowId) {
    var issue = $("#issue_" + rowId + "").val();
    var ticket_id = $("#ticket_" + rowId + "").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "vendor/addIssueToVendorTicket", { issue: issue, ticket_id: ticket_id }, function (data) {
        $('#loading').hide();
        // alert(data);
    });
}

///  

///vendor color comment 
function colorComment() {
    // alert("her");
    var color = $("#color").val();
    if (color == 1 || color == 2) {
        $("#color_comment").show();
    } else {
        $("#color_comment").hide();
    }
}
//calculate total deduction for social insurance
function calculateTotalDeduction() {
    var basic = $('#basic').val();
    var variable = $('#variable').val();
    //  var total_deductions = ( Number(basic) +  Number(variable))*0.40;
    var total_deductions = (Number(basic) + Number(variable)) * 0.27;
    $("#total_deductions").val(total_deductions);
}
/////vacation plan for pm
function onAddVacationPlan(ifEdit) {
    var date_from = $("#date_from").val();
    var date_to = $("#date_to").val();
    var quarter = quarter_of_the_year(new Date(date_from));
    var edit = 0;
    if (ifEdit == 1) {
        var id = atob($("#id").val());
        edit = 1;
    } else {
        var id = 0;
    }
    if (date_from.length > 0 && date_to.length > 0) {
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "hr/calculateRequestedDaysForPmVacationPlane", { date_from: date_from, date_to: date_to, quarter: quarter, edit: edit, id: id }, function (data) {
            $('#loading').hide();
            //alert(data);
            var json = JSON.parse(data);
            var total = json.totalOldRequests + json.requested_days;
            if (total > 5) {
                alert('you can not tack more than 5 days at quarter');
                $("#date_from").val('');
                $("#date_to").val('');

            }
            //alert(data);

        });
    }
    // return false;


}
function quarter_of_the_year(date) {
    var month = date.getMonth() + 1;
    return (Math.ceil(month / 3));
}
function checkStartAndEndOfQuarter(date) {
    var date_from = new Date($("#date_from").val()).getTime();
    var date_to = new Date($("#date_to").val()).getTime();
    //request data
    var date = new Date(date);
    var quarter = quarter_of_the_year(date);
    //current quarter
    var now = new Date()
    var nowquarter = quarter_of_the_year(now);
    var endDate = new Date(now.getFullYear(), nowquarter * 3, 0);
    now_time_gettime = now.getTime();
    date_time_gettime = date.getTime();

    if (date > endDate || quarter != nowquarter) {

        alert('choose day within current quarter ');
        $("#date_from").val('');
        $("#date_to").val('');
        return false;
    }
    if (date_time_gettime < now_time_gettime) {
        alert('choose another day ');
        $("#date_from").val('');
        $("#date_to").val('');
        return false;
    }
    if (date_from > date_to) {
        alert('choose correct date');
        $("#date_from").val('');
        $("#date_to").val('');
        return false;
    }


}

function checkForPmsVacationPlansAtSameRegion(ifEdit) {
    var date_from = $("#date_from").val();
    var date_to = $("#date_to").val();
    var group_id = $("#group_id").val();
    var edit = 0;
    if (ifEdit == 1) {
        var id = atob($("#id").val());
        edit = 1;
    } else {
        var id = 0;
    }
    if (date_from.length > 0 && date_to.length > 0) {

        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });

        $.post(base_url + "hr/checkForPmsVacationPlansAtSameRegion", { date_from: date_from, date_to: date_to, group_id: group_id, edit: edit, id: id }, function (data) {
            $('#loading').hide();
            if (data >= 1) {
                alert('there is another request reserved this day ,please choose another');
                $("#date_from").val('');
                $("#date_to").val('');

            }
            //alert(data);

        });
    }
    // return false;
}

//// 

//favourite vendor 
// function addToFavouriteVendor(t) {
//                   var id = t ;
//                   var fav = "fav";
//                   var test = fav.concat(id) ;
//                   var favourite = document.getElementById(test).value ;
//                   alert(id);
//                   alert(favourite);
//                   // alert(test);
//                 $.ajaxSetup({
//                     beforeSend: function(){
//                       $('#loading').show();
//                     },
//                 });
//                 $.post(base_url+"vendor/addToFavouriteVendor", {id:id,favourite:favourite} , function(data){
//                 $('#loading').hide();
//                  alert('data');
//                 //$("#fuzzy").html(data);
//                 });
//                 }
//

//start journal
//get section 
function getCategories(id) {
    var section = $("#section_name_" + id).val();
    //alert(section);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getCategories", { section: section }, function (data) {
        $('#loading').hide();
        //alert(data);
        $("#category_name_" + id).html(data);
        $("#sup_category_" + id).html("");
    });
}
//get category 
function getSupCategories(id) {
    var category = $("#category_name_" + id).val();
    // alert(category);
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getSupCategories", { category: category }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#sup_category_" + id).html(data);
    });

}

function calculateBalance() {
    var newbalance;
    var rows = $("#new_pair").val();
    $("#balance").val(0);
    for (var i = 1; i < rows; i++) {

        var amount = $("#amount_" + i).val();
        if (amount != undefined) {
            var debit_credit = $("#debit_credit_" + i).val();
            var balance = $("#balance").val();
            if (debit_credit == 1) {
                //Debit..
                newbalance = parseFloat(balance) + parseFloat(amount);
                $("#balance").val(newbalance);
                // alert(newbalance);
            } else if (debit_credit == 2) {
                newbalance = parseFloat(balance) - parseFloat(amount);
                $("#balance").val(newbalance);
                // alert(newbalance);
            } else {
                //alert('enter amount');
            }
        }
    }
}
function journalFormValidation() {
    var balance = $("#balance").val();
    if (balance == 0) {
        return true;
    } else {
        alert('balance must be equal 0');
        return false;
    }
}
function deletePairInAddMode(elem) {
    if ($('.pair').length > 1) {
        $(elem).closest('.pair').remove();
        calculateBalance();
    }
    else {
        alert("at least there one Transaction");
    }
}
function deletePairInEditMode(elem) {
    if ($('.pair').length > 1) {
        if ($(elem).closest('.pair').children('.tid').val() != undefined) {
            var deletedTransactions = $("#deletedTransactions").val();
            deletedTransactions = deletedTransactions + "," + $(elem).closest('.pair').children('.tid').val();
            $("#deletedTransactions").val(deletedTransactions);
        }
        $(elem).closest('.pair').remove();
        calculateBalance();
    }
    else {
        alert("at least there one Transaction");
    }

}
//end journal

/////////new update///////
function getClientInvoicedPOsSingleChooseByNumber() {

    var customer = $("#customer").val();
    var payment_date = $("#payment_date").val();
    var currency = $("#currency").val();
    var number = $("#po_number").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getClientInvoicedPOsSingleChooseByNumber", { customer: customer, payment_date: payment_date, currency: currency, number: number }, function (data) {
        $('#loading').hide();
        $("#invoicedPOs").html(data);


    });
}
function getClientInvoicedPOsMultipleChooseByNumber() {

    var customer = $("#customer").val();
    var payment_date = $("#payment_date").val();
    var currency = $("#currency").val();
    var number = $("#po_number").val();
    var list = $("#number_list").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "accounting/getClientInvoicedPOsMultipleChooseByNumber", { customer: customer, payment_date: payment_date, currency: currency, number: number, list: list }, function (data) {
        $('#loading').hide();
        $("#invoicedPOs").html(data);
        $("#number_list").val($("#number_list").val() + $("#po_number").val() + ",");
    });
}

function getAllVendorData(service, source, target) {
    $("#vendorData").html("");
    var task_type = $("#task_type").val();
    var vendor = $("#vendor").val();

    if (vendor == "all") {
        $("#sendToAllVendors").show();
        $("#sendToAllVendors input[name='unit']").attr('required', 'required');
        $("#sendToAllVendors input[name='rate']").attr('required', 'required');
        $.ajaxSetup({
            beforeSend: function () {
                $('#loading').show();
            },
        });
        $.post(base_url + "vendor/getAllVendorsByTask", { service: service, task_type: task_type, source: source, target: target }, function (data) {
            $('#loading').hide();
            // alert(data);
            $("#vendorData").html(data);
        });
    }
    else {
        $("#sendToAllVendors").hide();
        $("#sendToAllVendors input[name='unit']").removeAttr('required');
        $("#sendToAllVendors input[name='rate']").removeAttr('required');
        $.ajax({
            type: 'POST',
            url: base_url + "vendor/getVendorData",
            data: { vendor: vendor, task_type: task_type, source: source, target: target },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                $('#loading').hide();
                $("#vendorData").html(data);
            },
            error: function (xhr, textStatus, error) {
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
                $('#loading').hide();
            }
        });

        // $.ajaxSetup({
        //     beforeSend: function () {
        //         $('#loading').show();
        //     },
        // });
        // $.post(base_url + "vendor/getVendorData", { vendor: vendor, task_type: task_type, source: source, target: target }, function (data) {
        //     $('#loading').hide();
        //     alert(data);
        //     $("#vendorData").html(data);
        // },
        //     fail(function (xhr, textStatus, errorThrown) {
        //         // alert(xhr.responseText);
        //     })
        // )
    }
    $("#count").val("");
    $("#total_cost").val(0);
}

function checkAllBox() {
    if ($("#checkAll").attr('checked') == "checked")
        $('input:checkbox').not(this).attr('checked', 'checked');
    else
        $('input:checkbox').not(this).removeAttr('checked');
    $('.checkConfirmation').not(this).prop('checked', $('#checkAll').prop('checked'));
}

function assignSamCustomerGlobal() {
    var rowId = $("#lead_id").val();
    var lead = $("#lead_id").val();
    var customer = $("#customer_id").val();
    var sam = $("#sam_id").val();
    if (!sam) {
        alert('please Select Sam ');
        return false;
    }
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "customer/assignSamCustomer", { lead: lead, customer: customer, sam: sam }, function (data) {
        $('#loading').hide();
        // alert(data);
        $("#SamTable_" + rowId).html(data);
    });
}

function checkTaskConfirmForm() {
    checked = $("input[type=checkbox]:checked").length;

    if (!checked) {
        alert("You must check at least one Task to Confirm.");
        return false;
    } else {
        var tasks = '';
        $("input[type=checkbox]:checked").not("#checkAll").each(function () {
            tasks += $(this).attr('data_code') + "\n";
        });
        if (!confirm("Are You Sure.. You want to confirm these tasks ?\n\n" + tasks))
            return false;
    }

}

function getJobTypeInputs() {
    var job_type = $('#job_type').val();
    if (job_type == 1) {
        $("#attachedEmail").show();
        $("#attached_email").attr('required', 'required');

    } else {
        $("#attachedEmail").hide();
        $("#attached_email").removeAttr('required');
    }

}

function switchBrand(brand, email) {

    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.ajax({
        async: false,
        type: "POST",
        url: base_url + "admin/switchBrand",
        data: { brand: brand, email: email },
        dataType: "json",
        success: function (data) {

            if (data.status == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Account Changed Successfully",
                    text: "Redirect in 3 seconds.",
                    timer: 2000,
                    onOpen: function () {
                        Swal.showLoading();
                    }
                }).then(function (result) {
                    if (result.dismiss === "timer") {
                        window.location = base_url + 'admin';
                    }
                });

            } else {
                Swal.fire("Error", data.msg, "error").then(function () {
                    window.location = base_url + 'login';
                });
            }
            $('#loading').hide();
        }
    });
}

function locationApprovalForManager(rowId) {
    var manager_approval = $("#location_manager_approval_" + rowId + "").val();
    var id = $("#locationID_" + rowId + "").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/locationApprovalForManager", { id: id, manager_approval: manager_approval }, function (data) {

        $("#locationApproval").load(window.location.href + " #locationApproval");
        $('#loading').hide();
        //location.reload();
    });
}

function locationApprovalForHR(rowId) {
    var hr_approval = $("#hr_approval_" + rowId + "").val();
    var id = $("#locationID_" + rowId + "").val();
    $.ajaxSetup({
        beforeSend: function () {
            $('#loading').show();
        },
    });
    $.post(base_url + "hr/locationApprovalForHR", { id: id, hr_approval: hr_approval }, function (data) {
        $("#locationApproval").load(window.location.href + " #locationApproval");
        $('#loading').hide();
        // location.reload();

    });
}

