<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Accounting_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function AllCpo($brand, $filter)
    {
        $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `po` AS p WHERE p.verified = 0 AND " . $filter . " HAVING brand = '$brand' ORDER BY p.created_at DESC ");
        return $data;
    }

    public function AllCpoPages($brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `po` AS p WHERE p.verified = 0  HAVING brand = '$brand' ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllInvoices($brand, $filter)
    {
        $data = $this->db->query(" SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM `invoices` AS v WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        return $data;
    }

    public function AllInvoicesPages($brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM `invoices` AS v HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function getVirifiedPoByCustomer($id, $lead)
    {
        $row = $this->db->query(" SELECT * FROM `po` WHERE `lead` = '$lead' AND `verified` = '1' AND `invoiced` <> 1 ")->result();

        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($row as $row) {
            $job_data = $this->projects_model->totalRevenuePO($row->id);
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="projects[]" id="projects" onclick="getInvoiceTotal();" class="pos" value="' . $row->id . '" ' . $checked . ' title="' . $job_data['total'] . '"></td>
                            <td>' . $row->number . '</td>
                            <td>' . $this->admin_model->getCurrency($job_data['currency']) . '</td>
                            <td>' . $job_data['total'] . '</td>
                        </tr>';
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getPaymentData($customer = 0, $issue_date = "")
    {
        $payment = $this->db->get_where('customer', array('id' => $customer))->row()->payment;
        $dueDate = date("Y-m-d", strtotime($issue_date . " +" . $payment . " days"));

        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Payment Days</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <tr class="">
                        	<input type="text" id="payment" name="payment" value="' . $payment . '" hidden="">
                            <td>' . $payment . '</td>
                            <td>' . $dueDate . '</td>
                        </tr>
                    </tbody>
                </table>';
        echo $data;
    }

    public function getSelectedPOs($po_ids = 0)
    {
        $data = $this->db->query(" SELECT GROUP_CONCAT(number SEPARATOR ',') AS poNumber FROM po WHERE id IN (" . $po_ids . ") ")->row()->poNumber;
        return $data;
    }

    public function getInvoiceCurrency($po_ids)
    {
        $price_list = $this->db->query(" SELECT * FROM job WHERE po IN (" . $po_ids . ") ")->row()->price_list;
        $data = $this->db->get_where('job_price_list', array('id' => $price_list))->row()->currency;
        return $data;
    }

    public function getInvoiceTotal($po_ids)
    {
        $id = explode(",", $po_ids);
        $all = 0;
        for ($i = 0; $i < count($id); $i++) {
            $total = $this->projects_model->totalRevenuePO($id[$i]);
            $all = $all + $total['total'];
        }
        return $all;
    }

    public function getInvoiceStatus($status, $issue_date, $payment)
    {
        if ($status == 0) {
            $dueDate = date("Y-m-d", strtotime($issue_date . " +" . $payment . " days"));
            if ($dueDate > date("Y-m-d")) {
                echo "Due";
            } else {
                echo "Overdue";
            }
        } elseif ($status == 1) {
            echo "Paid";
        } else {
            echo "";
        }
    }

    public function AllPayments($brand, $filter)
    {
        $data = $this->db->query(" SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM `payment` AS v WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        return $data;
    }

    public function AllPaymentsPages($brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM `payment` AS v HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function getClientInvoices($id, $lead)
    {
        $row = $this->db->get_where('invoices', array('status' => 0, 'lead' => $lead))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Invoice Number</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                            <th>Issue Date</th>
                            <th>Difference</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>';
        $x = 1;
        foreach ($row as $row) {
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="invoices[]" onclick="getPymentTotal();" class="invoices" id="' . $x . '" value="' . $row->id . '" ' . $checked . ' title="' . $this->accounting_model->getInvoiceTotal($row->project_ids) . '"></td>
                            <td>' . $row->id . '</td>
                            <td>' . $this->accounting_model->getSelectedPOs($row->project_ids) . '</td>
			                <td>' . $this->admin_model->getCurrency($this->accounting_model->getInvoiceCurrency($row->project_ids)) . '</td>
			                <td>' . $this->accounting_model->getInvoiceTotal($row->project_ids) . '</td>
			                <td>' . $row->issue_date . '</td>
			                <td><input type="text" name="diff_' . $x . '" id="diff_' . $x . '" onblur="getPymentTotal();" onkeypress="return rateCode(event)" value="0"></td>
			                <td></td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getClientInvoicedPOs($id, $customer, $payment_date, $currencyTo)
    {
        $paymentDateArray = explode("/", $payment_date);
        $year = $paymentDateArray[2];
        $month = $paymentDateArray[0];
        $row = $this->db->get_where('po', array('customer' => $customer, 'verified' => 1, 'invoiced' => 1, 'paid' => 0))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Invoice Number</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                            <th>Total Revenue (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        $totalPosRevenue = 0;
        $totalPosRevenueMain = 0;
        foreach ($row as $row) {
            $InvoiceNumber = self::getInvoiceNumberByPoAndCustomer($row->id, $customer);
            $poData = $this->projects_model->totalRevenuePO($row->id);
            $totalPosRevenue = $totalPosRevenue + $poData['total'];
            if ($poData['currency'] === $currencyTo) {
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * 1);
                $poMainCurrency = $poData['total'] * 1;
            } else {
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $poData['currency'], 'currency_to' => $currencyTo))->row();
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * $mainCurrencyData->rate);
                $poMainCurrency = $poData['total'] * $mainCurrencyData->rate;
            }
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="po[]" class="checkPoPayment" onclick="getPymentTotal()" value="' . $row->id . '" ' . $checked . ' title="' . $poMainCurrency . '"></td>
                            <td>' . $InvoiceNumber . '</td>
                            <td>' . $row->number . '</td>
                            <td>' . $this->admin_model->getCurrency($poData['currency']) . '</td>
                            <td>' . $poData['total'] . '</td>
                            <td>' . $poMainCurrency . '</td>
                        </tr>';
        }
        $data .= '<tr>
                    <td colspan="4">Total Payments</td>
                    <td>' . $totalPosRevenue . '</td>
                    <td>' . $totalPosRevenueMain . '</td>';
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getAdvancedPayments($id, $customer, $currencyTo, $payment_date)
    {
        $payment = $this->db->get_where('advanced_payment', array('customer' => $customer, 'used' => 0))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Advanced Payment Value</th>
                            <th>Currency</th>
                            <th>Total Value In (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($payment as $payment) {
            if ($payment->currency == $currencyTo) {
                $paymentValueCurrency = $payment->value * 1;
            } else {
                $paymentDateArray = explode("/", $payment_date);
                $year = $paymentDateArray[2];
                $month = $paymentDateArray[0];
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $payment->currency, 'currency_to' => $currencyTo))->row();
                $paymentValueCurrency = $payment->value * $mainCurrencyData->rate;
            }
            if ($id == $payment->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="payment[]" class="payment" onclick="getPymentTotal()" value="' . $payment->id . '" ' . $checked . ' title="' . $paymentValueCurrency . '"></td>
                            <td>' . $payment->value . '</td>
                            <td>' . $this->admin_model->getCurrency($payment->currency) . '</td>
                            <td>' . $paymentValueCurrency . '</td>
                        </tr>';
        }

        echo $data;
    }

    public function getCreditNotePayment($id, $customer, $currencyTo, $payment_date)
    {
        $payment = $this->db->get_where('credit_note', array('customer' => $customer, 'status' => 3, 'paid' => 0))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Credit Note Value</th>
                            <th>Currency</th>
                            <th>Total Value In (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($payment as $payment) {
            if ($payment->currency == $currencyTo) {
                $paymentValueCurrency = $payment->amount * 1;
            } else {
                $paymentDateArray = explode("/", $payment_date);
                $year = $paymentDateArray[2];
                $month = $paymentDateArray[0];
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $payment->currency, 'currency_to' => $currencyTo))->row();
                $paymentValueCurrency = $payment->amount * $mainCurrencyData->rate;
            }
            if ($id == $payment->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="credit_note[]" class="creditNote" onclick="getPymentTotal();getTotalCreditNote()" value="' . $payment->id . '" ' . $checked . ' title="' . $paymentValueCurrency . '"></td>
                            <td>' . $payment->amount . '</td>
                            <td>' . $this->admin_model->getCurrency($payment->currency) . '</td>
                            <td>' . $paymentValueCurrency . '</td>
                        </tr>';
        }

        echo $data;
    }

    public function getInvoiceNumberByPoAndCustomer($po, $customer)
    {
        $invoiceData = $this->db->query(" SELECT * FROM `invoices` WHERE (PO_ids LIKE '%$po,%' OR po_ids LIKE '%,$po%' OR po_ids = '$po') AND customer = '$customer' ")->result();
        $invoiceNumber = "";
        foreach ($invoiceData as $invoiceData) {
            $poIdsArray = explode(",", $invoiceData->po_ids);
            if (in_array($po, $poIdsArray)) {
                $invoiceNumber = $invoiceData->id;
            } else {
            }
        }
        return $invoiceNumber;
    }

    public function selectPaymentDeductions($select = "")
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
            $selected3 = '';
        }

        $outpt = '<option value="1" ' . $selected1 . '>No Dudections</option>
                  <option value="2" ' . $selected2 . '>Fee</option>
                  <option value="3" ' . $selected3 . '>Early Payment</option>';
        return $outpt;
    }

    public function getPaymentDeductions($select = "")
    {
        if ($select == 1) {
            echo "No Dudections";
        } elseif ($select == 2) {
            echo "Fee";
        } elseif ($select == 3) {
            echo "Early Payment";
        } else {
            echo "";
        }
    }

    public function selectPaymentMethod($id = 0, $brand = 0)
    {
        $payment = $this->db->get_where('payment_method', array('brand' => $brand))->result();
        $data = "";
        foreach ($payment as $payment) {
            if ($payment->id == $id) {
                $data .= "<option value='" . $payment->id . "' selected='selected'>" . $payment->name . "</option>";
            } else {
                $data .= "<option value='" . $payment->id . "'>" . $payment->name . "</option>";
            }
        }
        return $data;
    }

    public function getPaymentMethod($id)
    {
        $result = $this->db->get_where('payment_method', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectHasError($id = 0)
    {
        $has_error = $this->db->get('has_error')->result();
        $data = "";
        $arr_id = explode(",", $id);
        foreach ($has_error as $has_error) {
            if (in_array($has_error->id, $arr_id)) {
                $data .= "<option value='" . $has_error->id . "' selected='selected'>" . $has_error->name . "</option>";
            } else {
                $data .= "<option value='" . $has_error->id . "'>" . $has_error->name . "</option>";
            }
        }
        return $data;
    }

    public function getError($id)
    {
        $result = $this->db->get_where('has_error', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function getPOStatus($status)
    {
        if ($status == 1) {
            echo "Verified";
        } else if ($status == 2) {
            echo "Has Error";
        } else {
            echo "";
        }
    }

    public function getPONumber($id)
    {
        $result = $this->db->get_where('po', array('id' => $id))->row();
        if (isset($result->number)) {
            return $result->number;
        } else {
            return '';
        }
    }

    public function getPONumberID($number)
    {
        $result = $this->db->get_where('po', array('number' => $number, 'verified' => 1))->row();
        if (isset($result->id)) {
            return $result->id;
        } else {
            return '';
        }
    }

    public function AllVPO($permission, $brand, $filter)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            LEFT OUTER JOIN po ON po.id = job.po
            WHERE " . $filter . " AND t.status = '1' AND job.status = '1' AND (t.verified IS NULL OR t.verified = '0' OR t.verified = '2') AND po.verified = '1' HAVING brand = '$brand' ORDER BY t.id DESC ");
        return $data;
    }

    public function AllVPOPages($permission, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            LEFT OUTER JOIN po ON po.id = job.po
            WHERE t.status = '1' AND job.status = '1' AND (t.verified IS NULL OR t.verified = '0' OR t.verified = '2') AND po.verified = '1' HAVING brand = '$brand' ORDER BY t.id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllVPOVerified($permission, $brand, $filter)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            WHERE " . $filter . " AND t.status = '1' AND (t.verified = 1) HAVING brand = '$brand' ORDER BY t.id DESC ");
        return $data;
    }

    public function AllVPOVerifiedPages($permission, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            WHERE t.status = '1' AND job.status = '1' AND (t.verified = 1) HAVING brand = '$brand' ORDER BY t.id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function AllVendorPayment($permission, $brand, $filter)
    {
        $data = $this->db->query(" SELECT p.*,(SELECT brand FROM `users` WHERE users.id = p.created_by) AS brand,j.code,j.rate,j.count,j.unit,j.vendor,c.name as currency  FROM vendor_payment AS p LEFT OUTER JOIN job_task AS j ON j.id = p.task  inner join currency c on j.currency = c.id WHERE " . $filter . " HAVING brand = '$brand' ORDER BY id DESC ");
        return $data;
    }

    public function AllVendorPaymentPages($permission, $brand, $limit, $offset)
    {
        $sql = "SELECT p.*,(SELECT brand FROM `users` WHERE users.id = p.created_by) AS brand,j.code,j.rate,j.count,j.unit,j.vendor,c.name as currency  FROM vendor_payment AS p LEFT OUTER JOIN job_task AS j ON j.id = p.task inner join currency c on j.currency = c.id HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ";
        $data = $this->db->query($sql);
        return $data;
    }

    public function getVendorVerifiedTasks($vendor)
    {
        $row = $this->db->query(" SELECT t.*,(SELECT COUNT(*) FROM `vendor_payment` WHERE vendor_payment.task = t.id) AS total,job.status
									FROM job_task AS t
                                    LEFT OUTER JOIN job ON job.id = t.job_id
									WHERE t.status = 1 AND job.status = '1' AND t.verified = 1 AND t.vendor = '$vendor' HAVING total = 0 ")->result();

        $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                        <thead>
                            <tr>
                            	 <th></th>
                                 <th>Task Code</th>
                                 <th>Volume</th>
                                 <th>Unit</th>
                                 <th>Rate</th>
                                 <th>Total Payment</th>
                                 <th>Currency</th>
                            </tr>
                        </thead>                            
                        <tbody>';
        foreach ($row as $row) {
            $data .= '<tr class="">
                            	<td><input type="checkbox" class="checkPoPayment" name="task[]" id="task" value="' . $row->id . '"></td>
                                <td>' . $row->code . '</td>
                                <td>' . $row->count . '</td>
                                <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                                <td>' . $row->rate . '</td>
                                <td>' . $row->rate * $row->count . '</td>
                                <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                            </tr>';
        }
        $data .= '</tbody></table>';
        return $data;
    }

    public function getVendorVerifiedTasksById($row)
    {
        $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                        <thead>
                            <tr>
                                 <th></th>
                                 <th>Task Code</th>
                                 <th>Volume</th>
                                 <th>Unit</th>
                                 <th>Rate</th>
                                 <th>Total Payment</th>
                                 <th>Currency</th>
                            </tr>
                        </thead>                            
                        <tbody>';
        $x = 1;
        if ($x == 1) {
            $radio = "required";
        } else {
            $radio = "";
        }
        $data .= '<tr class="">
                                <td><input type="radio" name="task" id="task" value="' . $row->id . '" ' . $radio . ' checked=""></td>
                                <td>' . $row->code . '</td>
                                <td>' . $row->count . '</td>
                                <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                                <td>' . $row->rate . '</td>
                                <td>' . $row->rate * $row->count . '</td>
                                <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                            </tr>';
        $data .= '</tbody></table>';
        return $data;
    }

    public function selectVendorPaymentStatus($select = "")
    {
        if ($select == 1) {
            $selected2 = 'selected';
        } elseif ($select == 2) {
            $selected3 = 'selected';
        } else {
            $selected2 = '';
            $selected3 = '';
        }

        $outpt = '<option value="1" ' . $selected2 . '>Paid</option>
                  <option value="2" ' . $selected3 . '>Re-opened</option>
                  ';
        return $outpt;
    }

    public function AllRunningVPO($permission, $brand, $filter)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status AS jobStatus FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            LEFT OUTER JOIN po ON po.id = job.po
            WHERE " . $filter . " AND po.verified <> '1' || po.verified IS NULL HAVING brand = '$brand' ORDER BY t.id DESC ");
        return $data;
    }

    public function AllRunningVPOPages($permission, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status AS jobStatus FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            LEFT OUTER JOIN po ON po.id = job.po
            WHERE po.verified <> '1' || po.verified IS NULL HAVING brand = '$brand' ORDER BY t.id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function vpoStatus($permission, $brand, $filter)
    {
        $data = $this->db->query(" SELECT t.*,p.payment_method,p.status AS payment_status,p.payment_date AS payment_date,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand FROM `job_task` AS t
            LEFT OUTER JOIN vendor_payment AS p ON p.task = t.id
            WHERE " . $filter . " HAVING brand = '$brand' ORDER BY t.id DESC ");
        return $data;
    }

    public function vpoStatusPages($permission, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT t.*,p.payment_method,p.status AS payment_status,p.payment_date AS payment_date,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand FROM `job_task` AS t
            LEFT OUTER JOIN vendor_payment AS p ON p.task = t.id
            HAVING brand = '$brand' ORDER BY t.id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function cpoStatus($brand, $filter)
    {
        $sql = " SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `po` AS p WHERE " . $filter . " HAVING brand = '$brand' ORDER BY p.created_by DESC ";
        $data = $this->db->query($sql);
        return $data;
    }

    public function cpoStatusPages($brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `po` AS p  HAVING brand = '$brand' ORDER BY p.created_by DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function sendPoRejectionMail($poId)
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,

        );
        $po = $this->db->get_where('po', array('id' => $poId))->row();
        $subject = "PO Rejection Email : # " . $po->number;

        $userData = $this->admin_model->getUserData($po->created_by);
        //$MailTo = $userData->email;
        // send for all pm created jobs by this po number
        $MailTo = $this->db->query(" SELECT GROUP_CONCAT(email SEPARATOR ', ') AS emails FROM users WHERE id IN (SELECT created_by FROM job WHERE po=$poId)")->row()->emails;

        $mailFrom = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        if ($this->brand == 1) {
            $this->email->from($mailFrom);
            $this->email->cc($mailFrom);
            $this->email->set_header('Reply-To', $mailFrom);
        } elseif ($this->brand == 2) {
            $this->email->from($mailFrom);
            $this->email->cc($mailFrom);
            $this->email->set_header('Reply-To', $mailFrom);
        } elseif ($this->brand == 3) {
            $this->email->from($mailFrom);
            $this->email->cc($mailFrom);
            $this->email->set_header('Reply-To', $mailFrom);
        } elseif ($this->brand == 11) {
            $this->email->from($mailFrom);
            $this->email->cc($mailFrom);
            $this->email->set_header('Reply-To', $mailFrom);
        }

        $msg = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Job Code</th>
                            <th>Job Name</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $job = $this->db->get_where('job', array('po' => $po->id))->result();
        foreach ($job as $job) {
            $msg .= '<tr><td>' . $po->number . '</td>';
            $msg .= '<td>' . $job->code . '</td>';
            $msg .= '<td>' . $job->name . '</td>';
        }
        $msg .= '</tbody></table>';



        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    <style>
                    @media print {
                    table {font-size: smaller; }
                    thead {display: table-header-group; }
                    table { page-break-inside:auto; width:75%; }
                    tr { page-break-inside:avoid; page-break-after:auto; }
                    }
                    table {
                    border: 1px solid black;
                    font-size:18px;
                    }
                    table td {
                    border: 1px solid black;
                    }
                    table th {
                    border: 1px solid black;
                    }
                    .clr{
                    background-color: #EEEEEE;
                    text-align: center;
                    }
                    .clr1 {
                    background-color: #FFFFCC;
                    text-align: center;
                    }
                    </style>
                    </head>

                    <body>
                    <p>Hello ,</p>
                    <p>Your PO has been rejected</p>
                       ' . $msg . '
                       <p> Thanks</p>
                    </body>
                    </html>';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        // replace my mail by pm manger it is just for testing
        $this->email->to($MailTo);
        $this->email->subject($subject);

        $this->email->message($message);
        $this->email->set_mailtype('html');
        $this->email->send();
        //  echo $this->email->print_debugger();
    }

    public function costOfSales($permission, $user, $brand, $filter)
    {
        $sql = "SELECT j.*,p.number,i.id AS invoiceId,i.issue_date,i.lead,i.customer,(SELECT brand FROM `users` WHERE users.id = i.created_by) AS brand  FROM job AS j
        LEFT OUTER JOIN po AS p ON p.id = j.po
        LEFT OUTER JOIN invoices AS i ON FIND_IN_SET(p.id, i.po_ids) > 0
        WHERE " . $filter . " HAVING brand = '$brand' order by issue_date desc ";
        var_dump($sql);
        $data = $this->db->query("SELECT j.*,p.number,i.id AS invoiceId,i.issue_date,i.lead,i.customer,(SELECT brand FROM `users` WHERE users.id = i.created_by) AS brand  FROM job AS j
									LEFT OUTER JOIN po AS p ON p.id = j.po
									LEFT OUTER JOIN invoices AS i ON FIND_IN_SET(p.id, i.po_ids) > 0
            						WHERE " . $filter . " HAVING brand = '$brand' order by issue_date desc ");
        return $data;
    }

    public function costOfSalesPages($permission, $user, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT j.*,p.number,i.id AS invoiceId,i.issue_date,i.lead,i.customer,(SELECT brand FROM `users` WHERE users.id = i.created_by) AS brand  FROM job AS j
									LEFT OUTER JOIN po AS p ON p.id = j.po
									LEFT OUTER JOIN invoices AS i ON FIND_IN_SET(p.id, i.po_ids) > 0
            HAVING brand = '$brand' ORDER BY issue_date DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function transfareTotalToCurrencyRate($currencyFrom, $currencyTo, $date, $total)
    {
        if ($currencyFrom == $currencyTo) {
            return $total;
        } else {
            $dateArray = explode("-", $date);
            $year = $dateArray[0];
            $month = $dateArray[1];
            $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $currencyFrom, 'currency_to' => $currencyTo))->row();
            return floatval($total) * floatval($mainCurrencyData->rate ?? '');
        }
    }

    public function totalCostByJobCurrency($currencyTo, $job)
    {
        //$tasks = $this->db->get_where('job_task', array('job_id' => $job, 'status' => 1))->result();
        $tasks = $this->db->query("select * from job_task where (job_id = '" . $job . "') and ( status = 0 or status = 1 or status = 4  or status = 5 )");
        //$tasks = $this->db->get_where('job_task', array('job_id' => $job))->result();
        $totalTasks = 0;
        foreach ($tasks->result() as $task) {
            if ($task->currency == $currencyTo) {
                $totalTasks = $totalTasks + ($task->rate * $task->count);
            } else {

                $dateArray = explode("-", $task->delivery_date);
                //$dateArray = explode("-", $task->closed_date);
                $year = $dateArray[0];
                $month = $dateArray[1];
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $task->currency, 'currency_to' => $currencyTo))->row();
                $totalTasks = $totalTasks + ($mainCurrencyData->rate * ($task->rate * $task->count));
            }
        }

        return $totalTasks;
    }
    public function getJobtaskStatus($job)
    {
        return $status = $this->db->get_where('job_task', array('job_id' => $job))->row()->status;
    }
    //start currency rate
    public function CurrencyRateTable()
    {
        $currency = $this->db->get('currency')->result();
        $data = "";
        foreach ($currency as $currency) {
            $data .= "<tr><td>$currency->name</td>
                    <td> 
                    <input type='text' class='form-control' name='" . $currency->name . "' onkeypress='return rateCode(event)' data-maxlength='300'  required=''>
                    <input type='text' class='form-control' name='" . $currency->id . "' data-maxlength='300'value='" . $currency->id . "' hidden required=''>
                    </td>
                  </tr>";
        }
        echo $data;
    }
    public function addCurrencyRate($post)
    {
        $currency = $this->db->get('currency')->result();
        foreach ($currency as $currency) {
            $data['currency_to'] = $post['currency'];
            $data['month'] = $post['month'];
            $data['year'] = $post['year'];
            $data['currency'] = $post[$currency->id];
            $data['rate'] = $post[$currency->name];
            $this->db->insert('currenies_rate', $data);
        }
    }

    public function AllCurrenyRate($filter)
    {

        $data = $this->db->query(" SELECT * FROM `currenies_rate` WHERE " . $filter . " ORDER BY id DESC ");
        return $data;
    }

    public function AllCurrenyRatePages($limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `currenies_rate` ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function selectMonth($id = "")
    {
        $months = $this->db->get('months')->result();
        $data = '';
        foreach ($months as $months) {
            if ($months->id == $id) {
                $data .= "<option value='" . $months->value . "' selected='selected'>" . $months->name . "</option>";
            } else {
                $data .= "<option value='" . $months->value . "'>" . $months->name . "</option>";
            }
        }
        return $data;
    }

    public function getMonth($months)
    {
        $result = $this->db->get_where('months', array('value' => $months))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }
    public function selectYear($name = "")
    {
        $years = $this->db->order_by('name', 'ASC')->get('years')->result();
        $data = '';
        foreach ($years as $years) {
            if ($years->name == $name) {
                $data .= "<option value='" . $years->name . "' selected='selected'>" . $years->name . "</option>";
            } else {
                $data .= "<option value='" . $years->name . "'>" . $years->name . "</option>";
            }
        }
        return $data;
    }
    //end currency rate

    public function AllCreditNotes($brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT p.*,(SELECT brand FROM customer WHERE customer.id = p.customer) AS brand FROM `po` AS p WHERE p.verified = 0  HAVING brand = '$brand' ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function selectAccountantEmployeeId($id = "", $brand = "")
    {
        $accountant = $this->db->query(" SELECT * FROM users WHERE (role = '14' OR role = '18' OR role = '19' OR role = '15') AND brand = '$this->brand' AND status = '1' ")->result();
        foreach ($accountant as $accountant) {
            if ($accountant->id == $id) {
                $data .= "<option value='" . $accountant->employees_id . "' selected='selected'>" . $accountant->user_name . "</option>";
            } else {
                $data .= "<option value='" . $accountant->employees_id . "'>" . $accountant->user_name . "</option>";
            }
        }
        return $data;
    }


    public function selectCreditNoteType($select = 0)
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } elseif ($select == 3) {
            $selected3 = 'selected';
        } elseif ($select == 4) {
            $selected4 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
            $selected3 = '';
            $selected3 = '';
        }

        $outpt = '<option value="1" ' . $selected1 . '>Quality / Feedbcak Issue</option>
                  <option value="2" ' . $selected2 . '>Volume Discount</option>
                  <option value="3" ' . $selected3 . '>Early Payment Discount</option>
                  <option value="4" ' . $selected4 . '>Customer credit Amount</option>';
        return $outpt;
    }

    public function getCreditNoteType($select = "")
    {
        if ($select == 1) {
            echo "Quality / Feedbcak Issue";
        } elseif ($select == 2) {
            echo "Volume Discount";
        } elseif ($select == 3) {
            echo "Early Payment Discount";
        } elseif ($select == 4) {
            echo "Customer credit Amount";
        } else {
            echo "";
        }
    }

    public function getClientInvoicedPOsSingleChoose($id, $customer, $payment_date, $currencyTo)
    {
        $paymentDateArray = explode("/", $payment_date);
        $year = $paymentDateArray[2];
        $month = $paymentDateArray[0];
        $row = $this->db->get_where('po', array('customer' => $customer, 'verified' => 1, 'invoiced' => 1))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                            <th>Total Revenue (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        $totalPosRevenue = 0;
        $totalPosRevenueMain = 0;
        foreach ($row as $row) {
            $poData = $this->projects_model->totalRevenuePO($row->id);
            $totalPosRevenue = $totalPosRevenue + $poData['total'];
            if ($poData['currency'] === $currencyTo) {
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * 1);
                $poMainCurrency = $poData['total'] * 1;
            } else {
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $poData['currency'], 'currency_to' => $currencyTo))->row();
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * $mainCurrencyData->rate);
                $poMainCurrency = $poData['total'] * $mainCurrencyData->rate;
            }
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="radio" name="po" class="pos" onclick="getPoCreditNoteAmount()" value="' . $row->id . '" ' . $checked . ' title="' . $poMainCurrency . '" required=""></td>
                            <td>' . $row->number . '</td>
                            <td>' . $this->admin_model->getCurrency($poData['currency']) . '</td>
                            <td>' . $poData['total'] . '</td>
                            <td>' . $poMainCurrency . '</td>
                        </tr>';
        }
        $data .= '<tr>
                    <td colspan="3">Total Payments</td>
                    <td>' . $totalPosRevenue . '</td>
                    <td>' . $totalPosRevenueMain . '</td>';
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getClientInvoicedPOsMultipleChoose($id, $customer, $payment_date, $currencyTo)
    {
        $paymentDateArray = explode("/", $payment_date);
        $year = $paymentDateArray[2];
        $month = $paymentDateArray[0];
        $row = $this->db->get_where('po', array('customer' => $customer, 'verified' => 1, 'invoiced' => 1))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Invoice Number</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                            <th>Total Revenue (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        $totalPosRevenue = 0;
        $totalPosRevenueMain = 0;
        foreach ($row as $row) {
            $poData = $this->projects_model->totalRevenuePO($row->id);
            $totalPosRevenue = $totalPosRevenue + $poData['total'];
            if ($poData['currency'] === $currencyTo) {
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * 1);
                $poMainCurrency = $poData['total'] * 1;
            } else {
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $poData['currency'], 'currency_to' => $currencyTo))->row();
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * $mainCurrencyData->rate);
                $poMainCurrency = $poData['total'] * $mainCurrencyData->rate;
            }
            $InvoiceNumber = self::getInvoiceNumberByPoAndCustomer($row->id, $customer);
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="pos[]" onclick="getInvoiceTotal();" id="pos" onclick="" class="pos" value="' . $row->id . '" ' . $checked . ' title="' . $poMainCurrency . '"></td>
                            <td>' . $InvoiceNumber . '</td>
                            <td>' . $row->number . '</td>
                            <td>' . $this->admin_model->getCurrency($poData['currency']) . '</td>
                            <td>' . $poData['total'] . '</td>
                            <td>' . $poMainCurrency . '</td>
                        </tr>';
        }
        $data .= '<tr>
                    <td colspan="4">Total Payments</td>
                    <td>' . $totalPosRevenue . '</td>
                    <td>' . $totalPosRevenueMain . '</td>';
        $data .= '</tbody></table>';
        echo $data;
    }

    public function creditNote($brand, $filter)
    {
        $data = $this->db->query(" SELECT c.*,p.number,p.created_by AS pm,(SELECT brand FROM customer WHERE customer.id = c.customer) AS brand
        FROM credit_note AS c LEFT OUTER JOIN po AS p ON p.id = c.po 
        WHERE " . $filter . " HAVING brand = '$brand' order by id desc ");
        return $data;
    }

    public function creditNotePages($brand, $limit, $offset)
    {
        $data = $this->db->query("  SELECT c.*,p.number,p.created_by AS pm,(SELECT brand FROM customer WHERE customer.id = c.customer) AS brand
        							FROM credit_note AS c LEFT OUTER JOIN po AS p ON p.id = c.po
            						HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    public function getCreditNoteStatus($select = "")
    {
        if ($select == 0) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #5e5e5d">Waiting Approval</span>';
        } else if ($select == 1) {
            $outpt = '<span class="badge badge-primary p-2" style="background-color: #0e4b9a">Approved</span>';
        } else if ($select == 2) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #fb0404">Rejected</span>';
        } else if ($select == 3) {
            $outpt = '<span class="badge badge-danger p-2" style="background-color: #07b817">Closed</span>';
        } else {
            $outpt = "";
        }
        return $outpt;
    }

    public function sendPoCreditNoteMail($poId, $description)
    {
        $po = $this->db->get_where('po', array('id' => $poId))->row();
        $subject = "PO Credit Note : # " . $po->number;

        $userData = $this->admin_model->getUserData($po->created_by);
        //$MailTo = "mohamed.elshehaby@thetranslationgate.com";
        $MailTo = $userData->email;

        $mailFrom = $this->db->get_where('users', array('id' => $this->user))->row()->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        if ($this->brand == 1) {
            $headers .= "Cc: " . $mailFrom . "\r\n";
            $headers .= "Cc: mohamed.mahfouz@thetranslationgate.com" . "\r\n";
            $headers .= 'From: ' . $mailFrom . "\r\n" . 'Reply-To: ' . $mailFrom . "\r\n";
        } elseif ($this->brand == 2) {
            $headers .= "Cc: " . $mailFrom . "\r\n";
            $headers .= "Cc: shehab.ahmed@dtpzone.com" . "\r\n";
            $headers .= 'From: ' . $mailFrom . "\r\n" . 'Reply-To: ' . $mailFrom . "\r\n";
        } elseif ($this->brand == 3) {
            $headers .= "Cc: " . $mailFrom . "\r\n";
            $headers .= "Cc: 'suhan.yilmaz@europelocalize.com" . "\r\n";
            $headers .= 'From: ' . $mailFrom . "\r\n" . 'Reply-To: ' . $mailFrom . "\r\n";
        }

        if (strlen(trim($description)) > 1) {
            $msg = '<p>Description : ' . $description . '</p>';
        }

        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    <style>
                    @media print {
                    table {font-size: smaller; }
                    thead {display: table-header-group; }
                    table { page-break-inside:auto; width:75%; }
                    tr { page-break-inside:avoid; page-break-after:auto; }
                    }
                    table {
                    border: 1px solid black;
                    font-size:18px;
                    }
                    table td {
                    border: 1px solid black;
                    }
                    table th {
                    border: 1px solid black;
                    }
                    .clr{
                    background-color: #EEEEEE;
                    text-align: center;
                    }
                    .clr1 {
                    background-color: #FFFFCC;
                    text-align: center;
                    }
                    </style>
                    </head>

                    <body>
                    <p>Dear ' . $userData->user_name . ' ,</p>
                    <p>A new credit note added to your PO: ' . $po->number . '</p>
                    ' . $msg . '
                    <p><a href="' . base_url() . 'projects/creditNote" target="_blank">Open Credit Note Page!</a></p>
                    <p>Thanks</p>
                    </body>
                    </html>';
        mail($MailTo, $subject, $message, $headers);
    }

    public function sendApproveCreditNoteMail($id, $type, $reason)
    {
        $subject = "Credit Note : # " . $id;

        $userData = $this->admin_model->getUserData($this->user);
        $MailFrom = $userData->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        if ($this->brand == 1) {
            $MailTo .= "dina.fawzy@thetranslationgate.com";
            $headers .= 'From: ' . $MailFrom . ' ' . "\r\n" . 'Reply-To: ' . $MailFrom . '' . "\r\n";
        } elseif ($this->brand == 2) {
            $MailTo .= "lara.ezzat@dtpzone.com";
            $headers .= 'From: ' . $MailFrom . ' ' . "\r\n" . 'Reply-To: ' . $MailFrom . '' . "\r\n";
        } elseif ($this->brand == 3) {
            $MailTo .= "aylin.ziyad@europelocalize.com";
            $headers .= 'From: ' . $MailFrom . ' ' . "\r\n" . 'Reply-To: ' . $MailFrom . '' . "\r\n";
        } elseif ($this->brand == 11) {
            $MailTo .= "lilly.Eric@columbuslang.com";
            $headers .= 'From: ' . $MailFrom . ' ' . "\r\n" . 'Reply-To: ' . $MailFrom . '' . "\r\n";
        }

        if (strlen(trim($reason)) > 1) {
            $msg = '<p>Description : ' . $reason . '</p>';
        }

        $message = '<!DOCTYPE ><html dir=ltr>
                    <head>
                    <style>
                    @media print {
                    table {font-size: smaller; }
                    thead {display: table-header-group; }
                    table { page-break-inside:auto; width:75%; }
                    tr { page-break-inside:avoid; page-break-after:auto; }
                    }
                    table {
                    border: 1px solid black;
                    font-size:18px;
                    }
                    table td {
                    border: 1px solid black;
                    }
                    table th {
                    border: 1px solid black;
                    }
                    .clr{
                    background-color: #EEEEEE;
                    text-align: center;
                    }
                    .clr1 {
                    background-color: #FFFFCC;
                    text-align: center;
                    }
                    </style>
                    </head>

                    <body>
                    <p>Dear,</p>
                    <p>This credit note has been : ' . self::getCreditNoteStatus($type) . '</p>
                    ' . $msg . '
                    <p><a href="' . base_url() . 'accounting/creditNote" target="_blank">Open Credit Note Page!</a></p>
                    <p>Thanks</p>
                    </body>
                    </html>';
        mail($MailTo, $subject, $message, $headers);
    }

    public function dtpRevenueReport($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,j.price_list,j.name,j.volume,j.type,j.closed_date,p.number,p.invoiced,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM dtp_request AS l 
            LEFT OUTER JOIN job AS j on l.job_id = j.id LEFT OUTER JOIN po AS p on j.po = p.id WHERE j.id <> 0 AND j.status = '1' AND p.invoiced = '1' AND " . $filter . " HAVING brand = '$this->brand' order by j.id desc ");
        }
        return $data;
    }

    public function translationRevenueReport($permission, $user, $brand, $filter)
    {
        $data = $this->db->query("SELECT l.*,j.price_list,j.name,j.volume,j.type,j.closed_date,p.number,p.invoiced,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM translation_request AS l 
            LEFT OUTER JOIN job AS j on l.job_id = j.id LEFT OUTER JOIN po AS p on j.po = p.id WHERE j.id <> 0 AND j.status = '1' AND p.invoiced = '1' AND l.status='3' AND " . $filter . " HAVING brand = '$this->brand' order by j.id desc ");
        return $data;
    }

    public function vpoBalancePaid($permission, $brand, $filter)
    {
        $data = $this->db->query("SELECT t.*,p.task,p.payment_date,p.status AS payment_status,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand FROM job_task AS t 
    	LEFT OUTER JOIN vendor_payment AS p ON p.task = t.id
    	LEFT OUTER JOIN job ON job.id = t.job_id WHERE " . $filter . " HAVING brand = '$this->brand' ");
        return $data;
    }

    public function vpoBalanceNew($permission, $brand, $filter)
    {
        $data = $this->db->query("SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
									LEFT OUTER JOIN job ON job.id = t.job_id
									LEFT OUTER JOIN po ON po.id = job.po
									WHERE t.status = '1' AND job.status = '1' AND (t.verified IS NULL OR t.verified = '0' OR t.verified = '2') AND po.verified = '1' HAVING brand = '$this->brand' ");
        return $data;
    }

    public function vpoBalanceVerified($permission, $brand, $filter)
    {
        $data = $this->db->query("SELECT t.*,p.task,p.payment_date,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand FROM job_task AS t 
									LEFT OUTER JOIN vendor_payment AS p ON p.task = t.id
									LEFT OUTER JOIN job ON job.id = t.job_id
									WHERE t.verified = '1' AND p.payment_date IS NULL HAVING brand = '$this->brand' ");
        return $data;
    }

    public function vpoStatus_added($filter)
    {
        $filter['t.added_vpo ='] = 1;
        // added in vpo
        $query = $this->db->select('t.*,p.payment_method,p.status AS payment_status,p.payment_date AS payment_date,v.brand,
                                  u.user_name,v.name as vendor_name,tp.name as task_type_name,un.name as unit_name,
                                  c.name as currency_name,j.price_list,pm.name as payment_method_name,
                                  j.po,slang.name as source_lang,tlang.name as target_lang,po.verified as po_verified,po.verified_at as po_verified_at')->from('job_task As t')
            ->join('vendor_payment as p', 'p.task = t.id')->join('payment_method As pm', 'pm.id=p.payment_method')->join('users AS u', 't.created_by = u.id', 'left')->join('vendor As v', 't.vendor=v.id', 'left')
            ->join('task_type tp', 't.task_type=tp.id', 'left')->join('unit As un', 't.unit=un.id', 'left')->join('currency As c', 't.currency=c.id', 'left')
            ->join('job As j', 't.job_id=j.id', 'left')->join('job_price_list AS jo', 'j.price_list=jo.id', 'left')->join('languages As slang', 'jo.source=slang.id', 'left')
            ->join('languages As tlang', 'jo.target=tlang.id', 'left')->join('po', 'j.po=po.id', 'left')->where($filter);



        return $query->get();
    }
    public function vpoStatus_not_added($filter)
    {
        $filter['t.added_vpo ='] = 0;
        // not added in vpo
        $query = $this->db->select('t.*,v.brand,
                                    u.user_name,v.name as vendor_name,tp.name as task_type_name,un.name as unit_name,
                                    c.name as currency_name,j.price_list,
                                    j.po,slang.name as source_lang,tlang.name as target_lang,po.verified as po_verified,po.verified_at as po_verified_at')->from('job_task As t')
            ->join('users AS u', 't.created_by = u.id', 'left')->join('vendor As v', 't.vendor=v.id', 'left')
            ->join('task_type tp', 't.task_type=tp.id', 'left')->join('unit As un', 't.unit=un.id', 'left')->join('currency As c', 't.currency=c.id', 'left')
            ->join('job As j', 't.job_id=j.id', 'left')->join('job_price_list AS jo', 'j.price_list=jo.id', 'left')->join('languages As slang', 'jo.source=slang.id', 'left')
            ->join('languages As tlang', 'jo.target=tlang.id', 'left')->join('po', 'j.po=po.id', 'left')->where($filter);
        return $query->get();
    }

    // start journal
    // Author Hagar & Refaat
    public function AllJournalCount($filter)
    {
        return $this->db->select('journal.*,t.id AS tID,t.journal_id,t.amount,t.amount,t.debit_credit,t.bank,
        t.create_at as trans_created_at,currency.name as currency_name,bj.name as brand_name,sub.subcategory_name,cat.category_name,sec.section_name,
        u.user_name,p.name as payment_method_name')->from('journal')
            ->join('journal_transaction AS t', 'journal.id = t.journal_id')
            ->join('currency', 'journal.currency = currency.id')->join('brand AS bj', 'journal.brand = bj.id')
            ->join('accounting_subcategory AS sub', 't.sup_category = sub.id')->join('accounting_category AS cat', 'sub.category_id = cat.id')
            ->join('accounting_section AS sec', 'cat.section_id = sec.id')->join('users AS u', 'journal.created_by = u.id')
            ->join('payment_method as p', 't.bank=p.id', 'left')->where($filter)->count_all_results();
    }

    public function AllJournalPages($filter, $limit, $offset)
    {
        $query = $this->db->select('journal.*,t.id AS tID,t.journal_id,t.amount,t.amount,t.debit_credit,t.bank,
                                  t.created_at as trans_created_at,currency.name as currency_name,bj.name as brand_name,sub.subcategory_name,cat.category_name,sec.section_name,
                                  u.user_name,p.name as payment_method_name')->from('journal')
            ->join('journal_transaction AS t', 'journal.id = t.journal_id')
            ->join('currency', 'journal.currency = currency.id')->join('brand AS bj', 'journal.brand = bj.id')
            ->join('accounting_subcategory AS sub', 't.sup_category = sub.id')->join('accounting_category AS cat', 'sub.category_id = cat.id')
            ->join('accounting_section AS sec', 'cat.section_id = sec.id')->join('users AS u', 'journal.created_by = u.id')
            ->join('payment_method as p', 't.bank=p.id', 'left')->where($filter);
        if ($limit != 0) {
            return $query->order_by('journal.id', 'DESC')->limit($limit, $offset)->get();
        } else {
            return $query->order_by('journal.id', 'DESC')->get();
        }
    }

    ///view and edit depeit or credit
    public function selectDepitOrCredit($select = "")
    {
        if ($select == 1) {
            $selected1 = 'selected';
        } elseif ($select == 2) {
            $selected2 = 'selected';
        } else {
            $selected1 = '';
            $selected2 = '';
        }

        $outpt = '<option value="2" ' . $selected2 . '>Credit</option>
                  <option value="1" ' . $selected1 . '>Debit</option>';
        return $outpt;
    }

    public function getFollowUpDepitOrCredit($select = "")
    {
        if ($select == 1) {
            $outpt = 'Debit';
        } elseif ($select == 2) {
            $outpt = 'Credit';
        } else {
            $outpt = "";
        }
        return $outpt;
    }


    //section 
    //section for select 
    public function selectSection($id = "")
    {
        $section = $this->db->get('accounting_section')->result();
        $data = "";
        foreach ($section as $section) {
            if ($section->id == $id) {
                $data .= "<option value='" . $section->id . "' selected='selected'>" . $section->section_name . "</option>";
            } else {
                $data .= "<option value='" . $section->id . "'>" . $section->section_name . "</option>";
            }
        }
        return $data;
    }
    public function selectCategory($id = "", $section = "")
    {
        $categories = $this->db->get_where('accounting_category', array('section_id' => $section))->result();
        $data = "";
        foreach ($categories as $categories) {
            if ($categories->id == $id) {
                $data .= "<option value='" . $categories->id . "' selected='selected'>" . $categories->category_name . "</option>";
            } else {
                $data .= "<option value='" . $categories->id . "'>" . $categories->category_name . "</option>";
            }
        }
        return $data;
    }
    public function selectSupCategory($id = "", $category = "")
    {
        $supCategories = $this->db->get_where('accounting_subcategory', array('category_id' => $category))->result();
        $data = "";
        foreach ($supCategories as $supCategories) {
            if ($supCategories->id == $id) {
                $data .= "<option value='" . $supCategories->id . "' selected='selected'>" . $supCategories->subcategory_name . "</option>";
            } else {
                $data .= "<option value='" . $supCategories->id . "'>" . $supCategories->subcategory_name . "</option>";
            }
        }
        return $data;
    }
    public function addPaymentToJournal($postData, $user, $brand, $payment_id)
    {
        //add payment to journal
        $dataJournal['entry_description'] = $this->customer_model->getCustomer($postData['customer']);
        $dataJournal['description'] = $this->customer_model->getCustomer($postData['customer']);
        $dataJournal['currency'] = $postData['currency'];
        $time = strtotime($postData['payment_date']);
        $newformat = date('Y-m-d', $time);
        $dataJournal['date'] = $newformat;
        $dataJournal['created_by'] = $user;
        $dataJournal['created_at'] = date("Y-m-d H:i:s");
        $dataJournal['brand'] = $brand;
        $dataJournal['reference'] = "payment";
        $dataJournal['reference_id'] = $payment_id;
        if ($this->db->insert('journal', $dataJournal)) {
            $insert_id = $this->db->insert_id();
            $dataTransactionDepit['journal_id'] = $insert_id;
            $dataTransactionDepit['amount'] = $postData['net_amount'];
            $dataTransactionDepit['debit_credit'] = '1';
            $dataTransactionDepit['bank'] = $postData['payment_method'];
            //$sup_category_id = $this->db->query("SELECT id FROM accounting_subcategory WHERE subcategory_name = 'Banks'")->row()->id;
            $dataTransactionDepit['sup_category'] = 15;
            $dataTransactionDepit['created_by'] = $user;
            $dataTransactionDepit['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('journal_transaction', $dataTransactionDepit)) {
                $dataTransactionCredit['journal_id'] = $insert_id;
                $dataTransactionCredit['amount'] = $postData['net_amount'];
                $dataTransactionCredit['debit_credit'] = '2';
                $dataTransactionCredit['bank'] = $postData['payment_method'];
                //$sup_category_id = $this->db->query("SELECT id FROM accounting_subcategory WHERE subcategory_name = 'Accounts Recievables'")->row()->id;
                $dataTransactionCredit['sup_category'] = 5;
                $dataTransactionCredit['created_by'] = $user;
                $dataTransactionCredit['created_at'] = date("Y-m-d H:i:s");

                $this->db->insert('journal_transaction', $dataTransactionCredit);
            }
        }
    }
    public function addInvoiceToJournal($postData, $user, $brand, $invoice_id)
    {
        //add the invoice to journal
        $dataJournal['entry_description'] = $this->customer_model->getCustomer($postData['customer']);
        $dataJournal['description'] = $this->customer_model->getCustomer($postData['customer']);
        //$dataJournal['currency'] = $postData['currency'];
        $time = strtotime($postData['issue_date']);
        $newformat = date('Y-m-d', $time);
        $dataJournal['date'] = $newformat;
        $dataJournal['created_by'] = $user;
        $dataJournal['created_at'] = date("Y-m-d H:i:s");
        $dataJournal['brand'] = $brand;
        $dataJournal['reference'] = "invoices";
        $dataJournal['reference_id'] = $invoice_id;

        if ($this->db->insert('journal', $dataJournal)) {
            $insert_id = $this->db->insert_id();
            $dataTransactionDepit['journal_id'] = $insert_id;
            $dataTransactionDepit['amount'] = $postData['total_revenue'];
            $dataTransactionDepit['debit_credit'] = '1';
            $dataTransactionDepit['bank'] = $postData['payment_method'];
            $dataTransactionDepit['sup_category'] = 8;
            $dataTransactionDepit['created_by'] = $user;
            $dataTransactionDepit['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('journal_transaction', $dataTransactionDepit)) {
                $dataTransactionCredit['journal_id'] = $insert_id;
                $dataTransactionCredit['amount'] = $postData['total_revenue'];
                $dataTransactionCredit['debit_credit'] = '2';
                $dataTransactionCredit['bank'] = $postData['payment_method'];
                $dataTransactionCredit['sup_category'] = 1;
                $dataTransactionCredit['created_by'] = $user;
                $dataTransactionCredit['created_at'] = date("Y-m-d H:i:s");

                $this->db->insert('journal_transaction', $dataTransactionCredit);
            }
        }
    }
    public function addCreditNoteToJournal($postData, $user, $brand, $credit_note_id)
    {
        //add the credit note to journal
        $dataJournal['entry_description'] = $this->customer_model->getCustomer($postData['customer']);
        $dataJournal['description'] = $this->customer_model->getCustomer($postData['customer']);
        $dataJournal['currency'] = $postData['currency'];
        $time = strtotime($postData['issue_date']);
        $newformat = date('Y-m-d', $time);
        $dataJournal['date'] = $newformat;
        $dataJournal['created_by'] = $user;
        $dataJournal['created_at'] = date("Y-m-d H:i:s");
        $dataJournal['brand'] = $brand;
        $dataJournal['reference'] = "credit_note";
        $dataJournal['reference_id'] = $credit_note_id;

        if ($this->db->insert('journal', $dataJournal)) {
            $insert_id = $this->db->insert_id();
            $dataTransactionDepit['journal_id'] = $insert_id;
            $dataTransactionDepit['amount'] = $postData['amount'];
            $dataTransactionDepit['debit_credit'] = '1';
            $dataTransactionDepit['sup_category'] = 1;
            $dataTransactionDepit['created_by'] = $user;
            $dataTransactionDepit['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('journal_transaction', $dataTransactionDepit)) {
                $dataTransactionCredit['journal_id'] = $insert_id;
                $dataTransactionCredit['amount'] = $postData['amount'];
                $dataTransactionCredit['debit_credit'] = '2';
                $dataTransactionCredit['sup_category'] = 8;
                $dataTransactionCredit['created_by'] = $user;
                $dataTransactionCredit['created_at'] = date("Y-m-d H:i:s");

                $this->db->insert('journal_transaction', $dataTransactionCredit);
            }
        }
    }
    public function addVPOInvoiceToJournal($postData, $user, $brand, $vpo_invoice_id)
    {
        //add the credit note to journal
        $dataJournal['entry_description'] = $this->vendor_model->getVendorName($postData['vendor']);
        $dataJournal['description'] = $this->vendor_model->getVendorName($postData['vendor']);
        $dataJournal['currency'] = $postData['currency'];
        $time = strtotime($postData['invoice_date']);
        $newformat = date('Y-m-d', $time);
        $dataJournal['date'] = $newformat;
        $dataJournal['created_by'] = $user;
        $dataJournal['created_at'] = date("Y-m-d H:i:s");
        $dataJournal['brand'] = $brand;
        $dataJournal['reference'] = "job_task";
        $dataJournal['reference_id'] = $vpo_invoice_id;

        if ($this->db->insert('journal', $dataJournal)) {
            $insert_id = $this->db->insert_id();
            $dataTransactionDepit['journal_id'] = $insert_id;
            $dataTransactionDepit['amount'] = $postData['amount'];
            $dataTransactionDepit['debit_credit'] = '1';
            $dataTransactionDepit['sup_category'] = 3;
            $dataTransactionDepit['created_by'] = $user;
            $dataTransactionDepit['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('journal_transaction', $dataTransactionDepit)) {
                $dataTransactionCredit['journal_id'] = $insert_id;
                $dataTransactionCredit['amount'] = $postData['amount'];
                $dataTransactionCredit['debit_credit'] = '2';
                $dataTransactionCredit['sup_category'] = 9;
                $dataTransactionCredit['created_by'] = $user;
                $dataTransactionCredit['created_at'] = date("Y-m-d H:i:s");

                $this->db->insert('journal_transaction', $dataTransactionCredit);
            }
        }
    }
    public function get_next_id()
    {
        return $this->db->query(" SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'journal'
        AND table_schema = DATABASE( )")->row()->AUTO_INCREMENT;
    }

    public function selectAccountingTeam($id = "", $brand = "")
    {
        $users = $this->db->query("SELECT id,user_name FROM `users` WHERE `role` in('1','14','15','18','19') AND brand = '$brand' AND status = '1' ")->result();
        $data = "";
        foreach ($users as $user) {
            if ($user->id == $id) {
                $data .= "<option value='" . $user->id . "' selected='selected'>" . $user->user_name . "</option>";
            } else {
                $data .= "<option value='" . $user->id . "'>" . $user->user_name . "</option>";
            }
        }
        return $data;
    }
    //////end journal 

    public function costOfSalesTest($filter)
    {
        // $data = $this->db->query("SELECT j.*,p.number,i.id AS invoiceId,i.issue_date,i.lead,i.customer,(SELECT brand FROM `users` WHERE users.id = i.created_by) AS brand  FROM job AS j
        // 							LEFT OUTER JOIN po AS p ON p.id = j.po
        // 							LEFT OUTER JOIN invoices AS i ON FIND_IN_SET(p.id, i.po_ids) > 0
        //     						WHERE ".$filter." HAVING brand = '$brand' order by issue_date desc ");

        $query = $this->db->select('j.*,p.number,i.id as invoiceId,i.issue_date,i.lead,customer.name as customer_name,users.brand,tlang.name as target_lang,
                                 slang.name as source_lang,s.name as service_name,jo.rate as price_list_rate,jo.currency as price_list_currency,
                                 currency.name as currency_name,users.user_name,users.brand')->from('job As j')
            ->join('po as p', 'p.id = j.po', 'left')->join('invoices As i', 'FIND_IN_SET(p.id, i.po_ids) > 0', 'left')->join('customer', 'i.customer=customer.id', 'left')
            ->join('job_price_list AS jo', 'j.price_list=jo.id', 'left')->join('languages As slang', 'jo.source=slang.id', 'left')
            ->join('languages As tlang', 'jo.target=tlang.id', 'left')->join('services As s', 'jo.service=s.id', 'left')
            ->join('currency', 'jo.currency=currency.id', 'left')->join('users', 'j.created_by=users.id', 'left')->where($filter);
        return $query->order_by('issue_date', 'DESC')->get();
    }
    public function costOfSalesPagesTest($filter, $limit, $offset)
    {

        $query = $this->db->select('j.*,p.number,i.id as invoiceId,i.issue_date,i.lead,customer.name as customer_name,users.brand,tlang.name as target_lang,
                                 slang.name as source_lang,s.name as service_name,jo.rate as price_list_rate,jo.currency as price_list_currency,
                                 currency.name as currency_name,users.user_name,users.brand')->from('job As j')
            ->join('po as p', 'p.id = j.po', 'left')->join('invoices As i', 'FIND_IN_SET(p.id, i.po_ids) > 0', 'left')->join('customer', 'i.customer=customer.id', 'left')
            ->join('job_price_list AS jo', 'j.price_list=jo.id', 'left')->join('languages As slang', 'jo.source=slang.id', 'left')
            ->join('languages As tlang', 'jo.target=tlang.id', 'left')->join('services As s', 'jo.service=s.id', 'left')
            ->join('currency', 'jo.currency=currency.id', 'left')->join('users', 'j.created_by=users.id', 'left')->where($filter);
        return $query->order_by('issue_date', 'DESC')->limit($limit, $offset)->get();
    }
    public function costofSalesCreditNotes($filter)
    {
        // $this->db->query("SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM credit_note AS v WHERE (type = '1' OR type = '4') AND status = '3' AND ".$arr4." HAVING brand = '$this->brand' ")->result();
        $query = $this->db->select('v.*,customer.brand as brand,customer.name as customer_name,currency.name as currency_name,po.number as po_number')->from('credit_note as v')
            ->join('customer', 'v.customer=customer.id', 'left')->join('currency', 'v.currency=currency.id', 'left')->join('po', 'v.po=po.id', 'left')->where($filter);
        return $query->get()->result();
    }

    /////// new update /////////
    public function getClientInvoicedPOsSingleChooseByNumber($id, $customer, $payment_date, $currencyTo, $number)
    {
        $paymentDateArray = explode("/", $payment_date);
        $year = $paymentDateArray[2];
        $month = $paymentDateArray[0];
        $row = $this->db->get_where('po', array('customer' => $customer, 'verified' => 1, 'invoiced' => 1, 'number' => $number))->result();
        $data = '<table id="ClientInvoicedPOs" class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                            <th>Total Revenue (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        $totalPosRevenue = 0;
        $totalPosRevenueMain = 0;
        foreach ($row as $row) {
            $poData = $this->projects_model->totalRevenuePO($row->id);
            $totalPosRevenue = $totalPosRevenue + $poData['total'];
            if ($poData['currency'] === $currencyTo) {
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * 1);
                $poMainCurrency = $poData['total'] * 1;
            } else {
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $poData['currency'], 'currency_to' => $currencyTo))->row();
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * $mainCurrencyData->rate);
                $poMainCurrency = $poData['total'] * $mainCurrencyData->rate;
            }
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="radio" name="po" class="pos" onclick="getPoCreditNoteAmount()" value="' . $row->id . '" ' . $checked . ' title="' . $poMainCurrency . '" required=""></td>
                            <td><span class="list_numbers">' . $row->number . '</span></td>
                            <td>' . $this->admin_model->getCurrency($poData['currency']) . '</td>
                            <td>' . $poData['total'] . '</td>
                            <td>' . $poMainCurrency . '</td>
                        </tr>';
        }
        $data .= '<tr>
                    <td colspan="3">Total Payments</td>
                    <td>' . $totalPosRevenue . '</td>
                    <td>' . $totalPosRevenueMain . '</td>';
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getClientInvoicedPOsMultipleChooseByNumber($id, $customer, $payment_date, $currencyTo, $number, $list = "")
    {
        $paymentDateArray = explode("/", $payment_date);
        $year = $paymentDateArray[2];
        $month = $paymentDateArray[0];

        if (empty($list))
            $row = $this->db->get_where('po', array('customer' => $customer, 'verified' => 1, 'invoiced' => 1, 'number' => $number))->result();
        else {
            $list .= $number;
            $row = $this->db->query("select * from po where customer = $customer AND verified = 1 AND invoiced =1 AND number IN ($list)")->result();
        }

        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Invoice Number</th>
                            <th>PO Number</th>
                            <th>Currency</th>
                            <th>Total Revenue</th>
                            <th>Total Revenue (' . $this->admin_model->getCurrency($currencyTo) . ')</th>
                        </tr>
                    </thead>
                    <tbody>';
        $totalPosRevenue = 0;
        $totalPosRevenueMain = 0;
        foreach ($row as $row) {
            $poData = $this->projects_model->totalRevenuePO($row->id);
            $totalPosRevenue = $totalPosRevenue + $poData['total'];
            if ($poData['currency'] === $currencyTo) {
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * 1);
                $poMainCurrency = $poData['total'] * 1;
            } else {
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $poData['currency'], 'currency_to' => $currencyTo))->row();
                $totalPosRevenueMain = $totalPosRevenueMain + ($poData['total'] * $mainCurrencyData->rate);
                $poMainCurrency = $poData['total'] * $mainCurrencyData->rate;
            }
            $InvoiceNumber = self::getInvoiceNumberByPoAndCustomer($row->id, $customer);
            if ($id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="checkbox" name="pos[]" onclick="getInvoiceTotal();" id="pos" onclick="" class="pos" value="' . $row->id . '" ' . $checked . ' title="' . $poMainCurrency . '"></td>
                            <td>' . $InvoiceNumber . '</td>
                            <td>' . $row->number . '</td>
                            <td>' . $this->admin_model->getCurrency($poData['currency']) . '</td>
                            <td>' . $poData['total'] . '</td>
                            <td>' . $poMainCurrency . '</td>
                        </tr>';
        }
        $data .= '<tr>
                    <td colspan="4">Total Payments</td>
                    <td>' . $totalPosRevenue . '</td>
                    <td>' . $totalPosRevenueMain . '</td>';
        $data .= '</tbody></table>';
        echo $data;
    }

    public function AllVPOVPortal($permission, $brand, $filter)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            LEFT OUTER JOIN po ON po.id = job.po
            WHERE " . $filter . " AND t.status = '1' AND t.verified = '3' AND t.job_portal=1 HAVING brand = '$brand' ORDER BY t.id DESC ");
        //  WHERE ".$filter." AND t.status = '1' AND job.status = '1' AND t.verified = '3' AND t.job_portal=1 AND po.verified = '1' HAVING brand = '$brand' ORDER BY t.id DESC ");  
        return $data;
    }

    public function AllVPOVPortalPages($permission, $brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT t.*,job.price_list,(SELECT brand FROM `vendor` WHERE vendor.id = vendor) AS brand,job.status FROM job_task AS t
            LEFT OUTER JOIN job ON job.id = t.job_id
            LEFT OUTER JOIN po ON po.id = job.po
            WHERE t.status = '1'  AND  t.verified = '3' AND t.job_portal=1  HAVING brand = '$brand' ORDER BY t.id DESC LIMIT $limit OFFSET $offset ");
        // WHERE t.status = '1' AND job.status = '1' AND  t.verified = '3' AND t.job_portal=1 AND po.verified = '1' HAVING brand = '$brand' ORDER BY t.id DESC LIMIT $limit OFFSET $offset ");  
        return $data;
    }

    public function AllOverDueInvoices($brand, $filter)
    {
        // get if po not paid
        // get from payments where po_ids not inside
        // SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand ,(SELECT name FROM customer WHERE customer.id = v.customer) AS Company_name FROM `invoices` AS v WHERE v.status = 0 AND DATE_ADD(v.created_at, INTERVAL v.payment DAY) <= DATE(NOW()) AND v.po_ids NOt IN (SELECT GROUP_CONCAT(po_ids SEPARATOR ',') as p_ids FROM payment ) HAVING brand = 1 ORDER BY id desc ,customer DESC

        $data = $this->db->query(" SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand ,(SELECT name FROM customer WHERE customer.id = v.customer) AS Company_name FROM `invoices` AS v WHERE v.status = 0 AND DATE_ADD(v.created_at, INTERVAL v.payment DAY) <= DATE(NOW()) AND v.po_ids NOT IN (SELECT GROUP_CONCAT(po_ids SEPARATOR ',') FROM payment ) AND " . $filter . " HAVING brand = '$brand' ORDER BY id  DESC,customer DESC");
        return $data;
    }

    public function AllOverDueInvoicesPages($brand, $limit, $offset)
    {
        $data = $this->db->query(" SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand ,(SELECT name FROM customer WHERE customer.id = v.customer) AS Company_name FROM `invoices` AS v WHERE v.status = 0 AND DATE_ADD(v.created_at, INTERVAL v.payment DAY) <= DATE(NOW()) AND v.po_ids NOT IN (SELECT GROUP_CONCAT(po_ids SEPARATOR ',') as p_ids FROM payment ) HAVING brand = '$brand' ORDER BY id DESC , customer DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }
    public function getSelectedPOsLines($po_ids = 0)
    {
        $data = $this->db->query(" SELECT GROUP_CONCAT(number SEPARATOR '<br/>') AS poNumber FROM po WHERE id IN (" . $po_ids . ") ")->row()->poNumber;
        return $data;
    }

    public function getCustomerStatus($customer)
    {
        $data = $this->db->query("SELECT YEAR(created_at) AS year FROM po WHERE customer = $customer ORDER BY id ASC limit 1")->row()->year;
        return $data;
    }

    public function getPoInvoiceStatus($po, $issue_date, $payment)
    {
        $sql = " SELECT id FROM payment WHERE ( po_ids like '%,$po,%' OR  po_ids like '$po,%' OR  po_ids like '%,$po' OR  po_ids like '$po')";

        $payment_data = $this->db->query($sql);
        // var_dump(count($payment_data));
        if ($payment_data) {
            if ($payment_data->num_rows() == 0) {
                $dueDate = date("Y-m-d", strtotime($issue_date . " +" . $payment . " days"));
                if ($dueDate > date("Y-m-d")) {
                    echo "Due";
                } else {
                    echo "Overdue";
                }
            } elseif ($payment_data->num_rows() == 1) {
                echo "Paid";
            } else {
                echo "";
            }
        } else {
            echo "";
        }
    }

    public function allRunningCpo($brand, $filter)
    {
        $sql = "SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,l.product_line,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
LEFT OUTER JOIN project AS p on j.project_id = p.id
LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list
LEFT OUTER JOIN po AS po on po.id = j.po
WHERE project_id <> 0 AND " . $filter . " HAVING brand = '$brand' order by id desc ";

        $data = $this->db->query($sql);

        return $data;
    }

    public function allRunningCpoPages($brand, $limit, $offset)
    {

        $data = $this->db->query(" SELECT j.*,p.customer,p.lead,l.service,l.source,l.target,l.rate,l.currency,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM job AS j 
            LEFT OUTER JOIN project AS p on j.project_id = p.id
            LEFT OUTER JOIN job_price_list AS l on l.id = j.price_list           
            WHERE project_id <> 0
            HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");

        return $data;
    }

    //payment meyhods
    public function allPaymentMethod($brand, $filter)
    {

        $data = $this->db->query(" SELECT * FROM payment_method 
        WHERE " . $filter . " HAVING brand = '$brand' order by id desc ");

        return $data;
    }

    public function allPaymentMethodPages($brand, $limit, $offset)
    {

        $data = $this->db->query(" SELECT * FROM payment_method 
            HAVING brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset ");

        return $data;
    }

    public function selectBank($id = "")
    {
        $bank = $this->db->get('bank')->result();
        $data = "";
        foreach ($bank as $bank) {
            if ($bank->id == $id) {
                $data .= "<option value='" . $bank->id . "' selected='selected'>" . $bank->name . "</option>";
            } else {
                $data .= "<option value='" . $bank->id . "'>" . $bank->name . "</option>";
            }
        }
        return $data;
    }

    public function getBank($bank)
    {
        $result = $this->db->get_where('bank', array('id' => $bank))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function getCreditNoteInvoice($po_number)
    {
        $invoice = '';
        $po = $this->db->query("SELECT id FROM `po` WHERE `number` LIKE '$po_number'")->row();
        if (!empty($po)) {
            $po_id = $po->id;
            $data = $this->db->query(" SELECT id FROM invoices WHERE po_ids like '$po_id ,%' or po_ids like '%,$po_id,%' or po_ids like '%,$po_id' or po_ids = '$po_id'")->row();
            if (!empty($data))
                $invoice = $data->id;
        }
        return $invoice;
    }
}
