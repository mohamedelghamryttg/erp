<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounting extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Excelfile');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
    }

    public function PoList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 74);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 74);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['po'])) {
                    $po = $_REQUEST['po'];
                    if (!empty($po)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $po = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 2);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                //print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "number LIKE '%$po%'";
                $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['cpo'] = $this->accounting_model->AllCpo($this->brand, $arr4);
                } else {
                    $data['cpo'] = $this->accounting_model->AllCpoPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllCpo($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/poList');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['cpo'] = $this->accounting_model->AllCpoPages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/poList.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportPOList()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=POList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 74);
        $arr2 = array();
        if (isset($_REQUEST['customer'])) {
            $customer = $_REQUEST['customer'];
            if (!empty($customer)) {
                array_push($arr2, 0);
            }
        } else {
            $customer = "";
        }
        if (isset($_REQUEST['po'])) {
            $po = $_REQUEST['po'];
            if (!empty($po)) {
                array_push($arr2, 1);
            }
        } else {
            $po = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 2);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        //print_r($arr2);
        $cond1 = "customer = '$customer'";
        $cond2 = "number LIKE '%$po%'";
        $cond3 = "created_at BETWEEN '$date_from' AND '$date_to' ";
        $arr1 = array($cond1, $cond2, $cond3);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['cpo'] = $this->accounting_model->AllCpo($this->brand, $arr4);
        } else {
            $data['cpo'] = $this->accounting_model->AllCpo($this->brand, 1);
        }

        $this->load->view('accounting/exportPOList.php', $data);
    }

    public function updateInvoices()
    {
        $invoices = $this->db->get('invoices')->result();
        $pos = "";
        foreach ($invoices as $invoice) {
            $projectIds = explode(",", $invoice->project_ids);
            for ($i = 0; $i < count($projectIds); $i++) {
                $poNumber = $this->db->get_where('job', array('project_id' => $projectIds[$i]))->row()->po;
                $this->db->update('po', array('invoiced' => 1), array('id' => $poNumber));
                if ($i == 0) {
                    $pos = $poNumber;
                } else {
                    $pos .= "," . $poNumber;
                }
            }
            $this->db->update('invoices', array('po_ids' => $pos), array('id' => $invoice->id));
            echo $pos;
            echo "</br>----------------------------</br>";
        }
    }

    public function verifyMultiPos()
    {
        if (isset($_POST['select'])) {
            $select = $_POST['select'];
            for ($i = 0; $i < count($select); $i++) {
                $id = $select[$i];
                $data['verified'] = 1;
                $data['verified_at'] = date("Y-m-d H:i:s");;
                $data['verified_by'] = $this->user;
                $this->db->update('po', $data, array('id' => $id));
            }

            $true = "Selected POs Verified Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/PoList");
        } else {
            $error = "Please Check At Least One PO To Verify ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/PoList");
        }
    }

    public function hasErrorPOs()
    {
        $po = base64_decode($_POST['po']);
        $data['has_error'] = implode(",", $_POST['has_error']);
        $data['verified'] = 2;
        // $data['po'] = '';
        $data['verified_at'] = date("Y-m-d H:i:s");
        $data['verified_by'] = $this->user;
        $this->admin_model->addToLoggerUpdate('po', 74, 'id', $po, 0, 0, $this->user);
        if ($this->db->update('po', $data, array('id' => $po))) {
            $this->db->update('job', array('status' => 0), array('po' => $po));
            $this->accounting_model->sendPoRejectionMail($po);
            $true = "POs Errors Selected Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/PoList");
        } else {
            $error = "There's Something Wrong , Please try Again !!";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/PoList");
        }
    }

    public function verifyVPO()
    {

        if (isset($_POST['select'])) {
            //Upload Invoice File ..
            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/vpo/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/vpoList");
                } else {
                    $data_file = $this->file_upload->data();
                    $data['vpo_file'] = $data_file['file_name'];
                }
            } else {
                $error = "You must upload VPO attachment.";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/vpoList");
            }

            $select = $_POST['select'];
            for ($i = 0; $i < count($select); $i++) {
                $id = $select[$i];
                $data['verified'] = 1;
                $data['verified_by'] = $this->user;
                $data['verified_at'] = date("Y-m-d H:i:s");
                $data['invoice_date'] = $_POST['invoice_date'];
                $this->admin_model->addToLoggerUpdate('job_task', 87, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('job_task', $data, array('id' => $id))) {
                    $task = $this->db->get_where('job_task', array('id' => $id))->row();
                    // $data['currency']=$task->currency;
                    // $data['amount']=$task->count*$task->rate;
                    // $data['vendor']=$task->vendor;
                    // $this->accounting_model->addVPOInvoiceToJournal($data,$this->user,$this->brand,$id);
                } else {
                    $error = "Problem found please try Again  ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/vpoList");
                }
            }
            $true = "Selected POs Verified Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/vpoList");
        } else {
            $error = "Problem found please try Again  ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/vpoList");
        }
    }

    public function HasErrorVPO()
    {
        if (isset($_POST['task'])) {
            $task = base64_decode($_POST['task']);
            $data['has_error'] = implode(",", $_POST['has_error']);
            $data['verified'] = 2;
            $data['status'] = 0;
            $data['verified_at'] = date("Y-m-d H:i:s");
            $data['verified_by'] = $this->user;
            $this->admin_model->addToLoggerUpdate('job_task', 87, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('job_task', $data, array('id' => $task))) {
                $true = "VPOs Errors Selected Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/vpoList");
            } else {
                $error = "There's Something Wrong , Please try Again !!";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/vpoList");
            }
        } else {
            echo "Page Not Found ..";
        }
    }

    public function invoices()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 75);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 75);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $id = "";
                }
                //print_r($arr2);
                $cond1 = "v.customer = '$customer'";
                $cond2 = "v.issue_date BETWEEN '$date_from' AND '$date_to' ";
                $cond3 = "v.id = '$id'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['invoice'] = $this->accounting_model->AllInvoices($this->brand, $arr4);
                } else {
                    $data['invoice'] = $this->accounting_model->AllInvoicesPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllInvoices($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/invoices');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);
                $data['invoice'] = $this->accounting_model->AllInvoicesPages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/invoices.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportInvoices()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=invoicesList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 75);
        $arr2 = array();
        if (isset($_REQUEST['customer'])) {
            $customer = $_REQUEST['customer'];
            if (!empty($customer)) {
                array_push($arr2, 0);
            }
        } else {
            $customer = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 1);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        //print_r($arr2);
        $cond1 = "v.customer = '$customer'";
        $cond2 = "v.issue_date BETWEEN '$date_from' AND '$date_to' ";
        $arr1 = array($cond1, $cond2);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['invoice'] = $this->accounting_model->AllInvoices($this->brand, $arr4);

            //Filter Credit Note ..
            $arr2 = array();
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 0);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 1);
                }
            } else {
                $date_to = "";
                $date_from = "";
            }
            //print_r($arr2);
            $cond1 = "v.customer = '$customer'";
            $cond2 = "v.approved_at BETWEEN '$date_from' AND '$date_to' ";
            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4); 
            // End Filter Credit Note
            $data['creditNote'] = $this->db->query("SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM credit_note AS v WHERE (type = '1' OR type = '4') AND status = '3' AND " . $arr4 . " HAVING brand = '$this->brand' ")->result();
        }

        $this->load->view('accounting/exportInvoices.php', $data);
    }

    public function exportInvoice()
    {
        $check = $this->admin_model->checkPermission($this->role, 75);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $invoice = $this->db->get_where('invoices', array('id' => $id))->row();
            $bank = $this->db->query(" SELECT p.id,p.name,b.name,b.data,b.id AS bank FROM `payment_method` AS p LEFT OUTER JOIN bank AS b on b.id = p.bank WHERE p.id = '$invoice->payment_method'  ")->row();
            $lead = $this->db->get_where('customer_leads', array('id' => $invoice->lead))->row();
            if ($bank->bank == 1) {
                $file = "assets/uploads/excel/aaib.xlsx";
            } elseif ($bank->bank == 2) {
                $file = "assets/uploads/excel/eib.xlsx";
            }
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            //Company ..
            $objPHPExcel->getActiveSheet()->setCellValue('b' . '11', $this->customer_model->getCustomer($invoice->customer));
            $objPHPExcel->getActiveSheet()->setCellValue('b' . '14', $this->admin_model->getCountry($lead->country));
            //Invoice..
            $objPHPExcel->getActiveSheet()->setCellValue('i' . '10', $invoice->id);
            $objPHPExcel->getActiveSheet()->setCellValue('i' . '11', $invoice->issue_date);
            $objPHPExcel->getActiveSheet()->setCellValue('i' . '12', date("Y-m-d", strtotime($invoice->created_at . " +" . $invoice->payment . " days")));
            //job ..
            $pos = explode(",", $invoice->po_ids);
            $row = 17;
            $invoiceTotal = 0;
            for ($i = 0; $i < count($pos); $i++) {
                $poData = $this->db->get_where('po', array('id' => $pos[$i]))->row();
                $jobs = $this->db->get_where('job', array('po' => $poData->id))->result();
                foreach ($jobs as $job) {
                    $objWorksheet->insertNewRowBefore($row, 1);
                    $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                    $jobTotal = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);
                    $objPHPExcel->getActiveSheet()->setCellValue('a' . $row, $poData->number);
                    $objPHPExcel->getActiveSheet()->setCellValue('b' . $row, $job->name);
                    $objPHPExcel->getActiveSheet()->setCellValue('c' . $row, $this->admin_model->getServices($priceList->service));
                    $objPHPExcel->getActiveSheet()->setCellValue('d' . $row, $this->admin_model->getLanguage($priceList->source));
                    $objPHPExcel->getActiveSheet()->setCellValue('e' . $row, $this->admin_model->getLanguage($priceList->target));
                    if ($job->type == 1) {
                        $objPHPExcel->getActiveSheet()->setCellValue('f' . $row, $job->volume);
                    } elseif ($job->type == 2) {
                        $objPHPExcel->getActiveSheet()->setCellValue('f' . $row, $jobTotal / $priceList->rate);
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('g' . $row, $this->admin_model->getUnit($priceList->unit));
                    $objPHPExcel->getActiveSheet()->setCellValue('h' . $row, $priceList->rate);
                    $objPHPExcel->getActiveSheet()->setCellValue('i' . $row, $jobTotal);
                    $invoiceTotal = $invoiceTotal + $jobTotal;
                    $row++;
                }
            }
            $newRow = $row + 1;
            $objPHPExcel->getActiveSheet()->setCellValue('i' . $newRow, $invoiceTotal);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="invoice_' . $id . '.xlsx"');
            header('Cache-Control: max-age=0');
            header("Pragma: no-cache");
            header("Expires: 0");
            $objWriter->save('php://output');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addInvoice()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 76);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 76);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/addInvoice.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddInvoice()
    {
        $data['po_ids'] = implode(",", $_POST['projects']);
        $data['customer'] = $_POST['customer'];
        $data['lead'] = $_POST['lead'];
        $data['payment_method'] = $_POST['payment_method'];
        $data['issue_date'] = $_POST['issue_date'];
        $data['payment'] = $_POST['payment'];
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        // check external number 
        // start after XXXX number 
        // get invoices by brand if exists start after id+1 ; else start after XXX

        //TTG
        if ($this->brand == 1) {
            $first_serial = 18221;
        }
        //DTPZone
        elseif ($this->brand == 2) {
            $first_serial = 762;
        }
        //Europe Localize
        elseif ($this->brand == 3) {
            $first_serial = 1283;
        }
        //Columbuslang
        elseif ($this->brand == 11) {
            $first_serial = 545;
        }
        $invoice_last_serial = $this->db->query("SELECT external_serial FROM invoices join customer on customer.id = invoices.customer where customer.brand = $this->brand ORDER BY invoices.id DESC limit 1")->row()->external_serial;
        if ($invoice_last_serial)
            $data['external_serial'] = $invoice_last_serial + 1;
        else
            $data['external_serial'] = $first_serial + 1;

        if ($this->db->insert('invoices', $data)) {
            $invoice_id = $this->db->insert_id();
            $this->accounting_model->addInvoiceToJournal($_POST, $this->user, $this->brand, $invoice_id);
            $this->db->query(" UPDATE `po` SET `invoiced`='1' WHERE id IN(" . $data['po_ids'] . ") ");
            $true = "Invoice Added Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/invoices");
        } else {
            $error = "Failed To Add Invoice ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/invoices");
        }
    }

    public function getVirifiedPoByCustomer()
    {
        $lead = $_POST['lead'];
        echo $this->accounting_model->getVirifiedPoByCustomer(0, $lead);
    }

    public function getPaymentData()
    {
        $customer = $_POST['customer'];
        $issue_date = $_POST['issue_date'];
        echo $this->accounting_model->getPaymentData($customer, $issue_date);
    }

    public function payments()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 77);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 77);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                //print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "STR_TO_DATE(payment_date, '%m/%d/%Y') BETWEEN '$date_from' AND '$date_to' ";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);   
                if ($arr_1_cnt > 0) {
                    $data['payment'] = $this->accounting_model->AllPayments($this->brand, $arr4);
                } else {
                    $data['payment'] = $this->accounting_model->AllPaymentsPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllPayments($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/payments');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);
                $data['payment'] = $this->accounting_model->AllPaymentsPages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/payments.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportPayment()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Payments.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 77);
        $arr2 = array();
        if (isset($_REQUEST['customer'])) {
            $customer = $_REQUEST['customer'];
            if (!empty($customer)) {
                array_push($arr2, 0);
            }
        } else {
            $customer = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = $_REQUEST['date_from'];
            $date_to = $_REQUEST['date_to'];
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 1);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        //print_r($arr2);
        $cond1 = "customer = '$customer'";
        $cond2 = "payment_date BETWEEN '$date_from' AND '$date_to' ";
        $arr1 = array($cond1, $cond2);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['payment'] = $this->accounting_model->AllPayments($this->brand, $arr4);
        } else {
        }

        $this->load->view('accounting/exportPayments.php', $data);
    }

    public function addPayment()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 78);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 78);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/addPayment.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getClientInvoices()
    {
        $lead = $_POST['lead'];
        echo $this->accounting_model->getClientInvoices(0, $lead);
    }

    public function getClientInvoicedPOs()
    {
        $customer = $_POST['customer'];
        $payment_date = $_POST['payment_date'];
        $currency = $_POST['currency'];
        echo $this->accounting_model->getClientInvoicedPOs(0, $customer, $payment_date, $currency);
    }
    public function getAdvancedPayments()
    {
        $customer = $_POST['customer'];
        $currency = $_POST['currency'];
        $payment_date = $_POST['payment_date'];
        echo $this->accounting_model->getAdvancedPayments(0, $customer, $currency, $payment_date);
    }

    public function getCreditNotePayment()
    {
        $customer = $_POST['customer'];
        $currency = $_POST['currency'];
        $payment_date = $_POST['payment_date'];
        echo $this->accounting_model->getCreditNotePayment(0, $customer, $currency, $payment_date);
    }

    public function doAddPayment()
    {
        $data['po_ids'] = implode(",", $_POST['po']);
        $data['customer'] = $_POST['customer'];
        $data['payment_date'] = $_POST['payment_date'];
        $data['currency'] = $_POST['currency'];
        $data['deductions'] = $_POST['deductions'];
        $data['deduction_reason'] = $_POST['deduction_reason'];
        $data['advanced_payment'] = $_POST['advanced_payment'];
        if (isset($_POST['credit_note'])) {
            $data['credit_note'] = implode(",", $_POST['credit_note']);
        } else {
            $data['credit_note'] = 0;
        }
        $data['total_credit_note'] = $_POST['total_credit_note'];
        $data['net_amount'] = $_POST['net_amount'];
        $data['payment_method'] = $_POST['payment_method'];
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");

        if ($this->db->insert('payment', $data)) {
            $payment_id = $this->db->insert_id();
            $this->db->query(" UPDATE `po` SET `paid`='1' WHERE id IN (" . $data['po_ids'] . ") ");
            $this->db->query(" UPDATE `credit_note` SET `paid`='1' WHERE id IN (" . $data['credit_note'] . ") ");
            if ($data['advanced_payment'] != 0) {
                $paymentData['customer'] = $_POST['customer'];
                $paymentData['value'] = $_POST['advanced_payment'];
                $paymentData['currency'] = $_POST['currency'];
                $paymentData['payment_id'] = $payment_id;
                $paymentData['created_by'] = $this->user;
                $paymentData['created_at'] = date("Y-m-d H:i:s");
                $this->db->insert('advanced_payment', $paymentData);
            }
            //$this->accounting_model->addPaymentToJournal($_POST,$this->user,$this->brand,$payment_id);   
            if (isset($_POST['payment'])) {
                $payments = implode(",", $_POST['payment']);
                $this->db->query(" UPDATE `advanced_payment` SET `used`='1' ,payment_used = '$payment_id' WHERE id IN (" . $payments . ") ");
            }
            $true = "Payment Added Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/payments");
        } else {
            $error = "Failed To Add Payment ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/payments");
        }
    }

    public function vpoList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 87);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 87);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $code = "";
                }
                // print_r($arr2);
                $cond1 = "t.created_by = '$created_by'";
                $cond2 = "t.vendor = '$vendor'";
                $cond3 = "t.task_type = '$task_type'";
                $cond4 = "t.closed_date BETWEEN '$date_from' AND '$date_to' ";
                $cond5 = "t.code LIKE '%$code%'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['task'] = $this->accounting_model->AllVPO($data['permission'], $this->brand, $arr4);
                } else {
                    $data['task'] = $this->accounting_model->AllVPOPages($data['permission'], $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllVPO($data['permission'], $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/vpoList');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['task'] = $this->accounting_model->AllVPOPages($data['permission'], $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/vpoList.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportVpo()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vpoList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 87);
        $arr2 = array();
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 0);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 1);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['task_type'])) {
            $task_type = $_REQUEST['task_type'];
            if (!empty($task_type)) {
                array_push($arr2, 2);
            }
        } else {
            $task_type = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 3);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        // print_r($arr2);
        $cond1 = "job_task.created_by = '$created_by'";
        $cond2 = "job_task.vendor = '$vendor'";
        $cond3 = "job_task.task_type = '$task_type'";
        $cond4 = "job_task.closed_date BETWEEN '$date_from' AND '$date_to' ";
        $arr1 = array($cond1, $cond2, $cond3, $cond4);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['task'] = $this->accounting_model->AllVPO($data['permission'], $this->brand, $arr4);
        } else {
            $data['task'] = $this->accounting_model->AllVPO($data['permission'], $this->brand, 1);
        }

        $this->load->view('accounting/exportVpo.php', $data);
    }

    public function verifiedVpo()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 98);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 98);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $code = "";
                }
                // print_r($arr2);
                $cond1 = "t.created_by = '$created_by'";
                $cond2 = "t.vendor = '$vendor'";
                $cond3 = "t.task_type = '$task_type'";
                $cond4 = "t.closed_date BETWEEN '$date_from' AND '$date_to' ";
                $cond5 = "t.code LIKE '%$code%'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['task'] = $this->accounting_model->AllVPOVerified($data['permission'], $this->brand, $arr4);
                } else {
                    $data['task'] = $this->accounting_model->AllVPOVerifiedPages($data['permission'], $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllVPOVerified($data['permission'], $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/verifiedVpo');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['task'] = $this->accounting_model->AllVPOVerifiedPages($data['permission'], $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/verifiedVpo.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportVerifiedVpo()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=verifiedVpoList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 98);
        $arr2 = array();
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 0);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 1);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['task_type'])) {
            $task_type = $_REQUEST['task_type'];
            if (!empty($task_type)) {
                array_push($arr2, 2);
            }
        } else {
            $task_type = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 3);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        // print_r($arr2);
        $cond1 = "job_task.created_by = '$created_by'";
        $cond2 = "job_task.vendor = '$vendor'";
        $cond3 = "job_task.task_type = '$task_type'";
        $cond4 = "job_task.closed_date BETWEEN '$date_from' AND '$date_to' ";
        $arr1 = array($cond1, $cond2, $cond3, $cond4);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['task'] = $this->accounting_model->AllVPOVerified($data['permission'], $this->brand, $arr4);
        } else {
            $data['task'] = $this->accounting_model->AllVPOVerified($data['permission'], $this->brand, 1);
        }

        $this->load->view('accounting/exportVerifiedVpo.php', $data);
    }

    public function vendorPayments()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 90);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 90);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                // print_r($arr2);
                $cond1 = "code LIKE '%$code%'";
                $cond2 = "vendor = '$vendor'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['payment'] = $this->accounting_model->AllVendorPayment($data['permission'], $this->brand, $arr4);
                } else {
                    $data['payment'] = $this->accounting_model->AllVendorPaymentPages($data['permission'], $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllVendorPayment($data['permission'], $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/vendorPayments');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['payment'] = $this->accounting_model->AllVendorPaymentPages($data['permission'], $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/vendorPayments.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportVendorPayments()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vendorPayments.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 90);
        $arr2 = array();
        if (isset($_REQUEST['code'])) {
            $code = $_REQUEST['code'];
            if (!empty($code)) {
                array_push($arr2, 0);
            }
        } else {
            $code = "";
        }
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 1);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['task_type'])) {
            $task_type = $_REQUEST['task_type'];
            if (!empty($task_type)) {
                array_push($arr2, 2);
            }
        } else {
            $task_type = "";
        }
        // print_r($arr2);
        $cond1 = "code LIKE '%$code%'";
        $cond2 = "vendor = '$vendor'";
        $cond3 = "task_type = '$task_type'";
        $arr1 = array($cond1, $cond2, $cond3);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['payment'] = $this->accounting_model->AllVendorPayment($data['permission'], $this->brand, $arr4);
        } else {
            $data['payment'] = $this->accounting_model->AllVendorPayment($data['permission'], $this->brand, 9, 0);
        }

        $this->load->view('accounting/exportVendorPayments.php', $data);
    }

    public function addVendorPayment()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 91);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 91);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/addVendorPayment.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVendorPayment()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 91);
        if ($check) {
            if (isset($_POST['task'])) {
                $task = $_POST['task'];
            } else {
                $error = "Please make sure select at least one task ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/vendorPayments");
            }
            for ($i = 0; $i < count($task); $i++) {
                $data['task'] = $task[$i];
                $data['payment_method'] = $_POST['payment_method'];
                $data['payment_date'] = date("Y-m-d", strtotime($_POST['payment_date']));
                $data['status'] = 1;
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('vendor_payment', $data)) {
                } else {
                    $error = "Failed To Add Payment ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/vendorPayments");
                }
            }
            $true = "Payment Added Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/vendorPayments");
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getVendorVerifiedTasks()
    {
        $id = $_POST['vendor'];
        echo $this->accounting_model->getVendorVerifiedTasks($id);
    }

    public function editVendorPayment()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 92);
        if ($check) {
            //header ..
            $data['id'] = base64_decode($_GET['t']);
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 92);
            //body ..
            $data['brand'] = $this->brand;
            $data['payment'] = $this->db->get_where('vendor_payment', array('id' => $data['id']))->row();
            $data['task'] = $this->db->get_where('job_task', array('id' => $data['payment']->task))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/editVendorPayment.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditVendorPayment()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 91);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['payment_method'] = $_POST['payment_method'];
            $data['status'] = $_POST['status'];
            $this->admin_model->addToLoggerUpdate('vendor_payment', 91, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vendor_payment', $data, array('id' => $id))) {
                $true = "Payment Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."accounting/vendorPayments");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "accounting/vendorPayments");
                }
            } else {
                $error = "Failed To Edit Payment ...";
                $this->session->set_flashdata('error', $error);
                // redirect(base_url()."accounting/vendorPayments");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "accounting/vendorPayments");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function runningVPOs()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 98);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 98);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $code = "";
                }
                // print_r($arr2);
                $cond1 = "t.created_by = '$created_by'";
                $cond2 = "t.vendor = '$vendor'";
                $cond3 = "t.task_type = '$task_type'";
                $cond4 = "t.closed_date BETWEEN '$date_from' AND '$date_to' ";
                $cond5 = "t.code LIKE '%$code%'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['task'] = $this->accounting_model->AllRunningVPO($data['permission'], $this->brand, $arr4);
                } else {
                    $data['task'] = $this->accounting_model->AllRunningVPOPages($data['permission'], $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $data['count'] = $this->accounting_model->AllRunningVPO($data['permission'], $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/runningVPOs');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['task'] = $this->accounting_model->AllRunningVPOPages($data['permission'], $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/runningVPOs.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportRunningVPOs()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=RunningVpoList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 98);
        $arr2 = array();
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 0);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 1);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['task_type'])) {
            $task_type = $_REQUEST['task_type'];
            if (!empty($task_type)) {
                array_push($arr2, 2);
            }
        } else {
            $task_type = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 3);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        if (isset($_REQUEST['code'])) {
            $code = $_REQUEST['code'];
            if (!empty($code)) {
                array_push($arr2, 4);
            }
        } else {
            $code = "";
        }
        // print_r($arr2);
        $cond1 = "t.created_by = '$created_by'";
        $cond2 = "t.vendor = '$vendor'";
        $cond3 = "t.task_type = '$task_type'";
        $cond4 = "t.closed_date BETWEEN '$date_from' AND '$date_to' ";
        $cond5 = "t.code LIKE '%$code%'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);    
        if ($arr_1_cnt > 0) {
            $data['task'] = $this->accounting_model->AllRunningVPO($data['permission'], $this->brand, $arr4);
        } else {
            $data['task'] = $this->accounting_model->AllRunningVPO($data['permission'], $this->brand, 1);
        }

        $this->load->view('accounting/exportRunningVPOs.php', $data);
    }

    public function vpoStatus_old()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 106);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['invoice_status'])) {
                    $invoice_status = $_REQUEST['invoice_status'];
                    if (!empty($_REQUEST['invoice_status'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $invoice_status = "";
                }
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['payment_status'])) {
                    $payment_status = $_REQUEST['payment_status'];
                    if (!empty($payment_status)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $payment_status = "";
                }
                // print_r($arr2);
                if (isset($status) && $status == 3) {
                    $status = 0;
                }
                if (isset($invoice_status) && $invoice_status == 2) {
                    echo $invoice_status = "t.verified <> 1 OR t.verified IS NULL";
                } elseif (isset($invoice_status) && $invoice_status == 1) {
                    echo $invoice_status = "t.verified = 1";
                }
                if (isset($payment_status) && $payment_status == 2) {
                    $payment_status = "p.status <> 1 OR p.status IS NULL";
                } elseif (isset($payment_status) && $payment_status == 1) {
                    $payment_status = "p.status = 1";
                }
                $cond1 = "t.created_by = '$created_by'";
                $cond2 = "t.vendor = '$vendor'";
                $cond3 = "t.status = '$status'";
                $cond4 = $invoice_status;
                $cond5 = "t.code LIKE '%$code%'";
                $cond6 = $payment_status;
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['task'] = $this->accounting_model->vpoStatus($data['permission'], $this->brand, $arr4);
                } else {
                    //$data['task'] = $this->accounting_model->vpoStatusPages($data['permission'],$this->brand,9,0);
                }
            } else {
                //                 $limit = 9;
                //                 $offset = $this->uri->segment(3);
                //                 if($this->uri->segment(3) != NULL)
                //                 {
                //                     $offset = $this->uri->segment(3);
                //                 }else{
                //                     $offset = 0;
                //                 }
                //                 $data['count'] = $this->db->query(" SELECT Count(*) AS total FROM job_task AS t LEFT OUTER JOIN vendor AS v ON v.id = t.vendor WHERE v.brand = '$this->brand' ")->row()->total;
                //                 $config['base_url']= base_url('accounting/vpoStatus');
                //                 $config['uri_segment'] = 3;
                //                 $config['display_pages']= TRUE;
                //                 $config['per_page']  = $limit;
                //                 $config['total_rows'] = $data['count'];
                //                 $config['full_tag_open'] = "<ul class='pagination'>";
                //                 $config['full_tag_close'] ="</ul>";
                //                 $config['num_tag_open'] = '<li>';
                //                 $config['num_tag_close'] = '</li>';
                //                 $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                //                 $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                //                 $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                //                 $config['next_tagl_close'] = "</span></li>";
                //                 $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                //                 $config['prev_tagl_close'] = "</span></li>";
                //                 $config['first_tag_open'] = "<li>";
                //                 $config['first_tagl_close'] = "</li>";
                //                 $config['last_tag_open'] = "<li>";
                //                 $config['last_tagl_close'] = "</li>";
                //                 $config['next_link'] = '»';
                //                 $config['prev_link'] = '«';
                //                 $config['num_links'] = 5;
                //                 $config['show_count'] = TRUE;
                //                 $this->pagination->initialize($config);

                //                 $data['task'] = $this->accounting_model->vpoStatusPages($data['permission'],$this->brand,$limit,$offset);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/vpoStatus.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportvpoStatus_old()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=VpoList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
        $arr2 = array();
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 0);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 1);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
            if (!empty($status)) {
                array_push($arr2, 2);
            }
        } else {
            $status = "";
        }
        if (isset($_REQUEST['invoice_status'])) {
            $invoice_status = $_REQUEST['invoice_status'];
            if (!empty($_REQUEST['invoice_status'])) {
                array_push($arr2, 3);
            }
        } else {
            $invoice_status = "";
        }
        if (isset($_REQUEST['code'])) {
            $code = $_REQUEST['code'];
            if (!empty($code)) {
                array_push($arr2, 4);
            }
        } else {
            $code = "";
        }
        if (isset($_REQUEST['payment_status'])) {
            $payment_status = $_REQUEST['payment_status'];
            if (!empty($payment_status)) {
                array_push($arr2, 5);
            }
        } else {
            $payment_status = "";
        }
        // print_r($arr2);
        if (isset($status) && $status == 3) {
            $status = 0;
        }
        if (isset($invoice_status) && $invoice_status == 2) {
            $invoice_status = "t.verified <> 1 OR t.verified IS NULL";
        } elseif (isset($invoice_status) && $invoice_status == 1) {
            $invoice_status = "t.verified = 1";
        }
        if (isset($payment_status) && $payment_status == 2) {
            $payment_status = "p.status <> 1 OR p.status IS NULL";
        } elseif (isset($payment_status) && $payment_status == 1) {
            $payment_status = "p.status = 1";
        }
        $cond1 = "t.created_by = '$created_by'";
        $cond2 = "t.vendor = '$vendor'";
        $cond3 = "t.status = '$status'";
        $cond4 = $invoice_status;
        $cond5 = "t.code LIKE '%$code%'";
        $cond6 = $payment_status;
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['task'] = $this->accounting_model->vpoStatus($data['permission'], $this->brand, $arr4);
        } else {
            $data['task'] = $this->accounting_model->vpoStatus($data['permission'], $this->brand, 1);
        }

        $this->load->view('accounting/exportvpoStatus.php', $data);
    }

    public function vpoBalance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 106);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_REQUEST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    echo $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    echo $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 0);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                $cond1 = "p.payment_date BETWEEN '$date_from' AND '$date_to'";

                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['balance_new'] = $this->accounting_model->vpoBalanceNew($data['permission'], $this->brand, $arr4);
                    $data['balance_verified'] = $this->accounting_model->vpoBalanceVerified($data['permission'], $this->brand, $arr4);
                    $data['balance_paid'] = $this->accounting_model->vpoBalancePaid($data['permission'], $this->brand, $arr4);
                } else {
                }
            } else {
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/vpoBalance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportvpoBalance()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=VpoBalance.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
        $arr2 = array();
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 0);
            }
        } else {
            $date_from = "";
            $date_to = "";
        }
        $cond1 = "p.payment_date BETWEEN '$date_from' AND '$date_to'";

        $arr1 = array($cond1);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['balance_new'] = $this->accounting_model->vpoBalanceNew($data['permission'], $this->brand, $arr4);
            $data['balance_verified'] = $this->accounting_model->vpoBalanceVerified($data['permission'], $this->brand, $arr4);
            $data['balance_paid'] = $this->accounting_model->vpoBalancePaid($data['permission'], $this->brand, $arr4);
        } else {
        }
        $this->load->view('accounting_new/exportvpoBalance.php', $data);
    }


    public function cpoStatus()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 107);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 107);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['po'])) {
                    $po = $_REQUEST['po'];
                    if (!empty($po)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $po = "";
                }
                if (isset($_REQUEST['verified'])) {
                    $verified = $_REQUEST['verified'];
                    if (!empty($verified)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $verified = "";
                }
                if (isset($_REQUEST['invoiced'])) {
                    $invoiced = $_REQUEST['invoiced'];
                    if (!empty($invoiced)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $invoiced = "";
                }
                if ($verified == 3) {
                    $verified = 0;
                }
                if ($invoiced == 2) {
                    $invoiced = 0;
                }
                //print_r($arr2);
                $cond1 = "customer = '$customer'";
                $cond2 = "number LIKE '%$po%'";
                $cond3 = "verified = '$verified'";
                $cond4 = "invoiced = '$invoiced'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['cpo'] = $this->accounting_model->cpoStatus($this->brand, $arr4);
                } else {
                    $data['cpo'] = $this->accounting_model->cpoStatusPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->cpoStatus($this->brand, 1)->num_rows();
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['cpo'] = $this->accounting_model->cpoStatusPages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/cpoStatus.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function costOfSales()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 109);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 109);
            //body ..
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 0);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                //print_r($arr2);
                $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['jobs'] = $this->accounting_model->costOfSales($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                }
            } else {
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/costOfSales.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function costOfSales_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 109);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 109);
            //body ..
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 0);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                //print_r($arr2);
                $cond1 = "i.issue_date BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['jobs'] = $this->accounting_model->costOfSales($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                }
            } else {
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/costOfSales_test.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportCostOfSales()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=CostOfSales.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 109);
        $arr2 = array();
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 0);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        // print_r($arr2);
        $cond1 = "issue_date BETWEEN '$date_from' AND '$date_to'";
        $arr1 = array($cond1);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        echo $arr4 = implode(" and ", $arr3);
        //print_r($arr4);
        if ($arr_1_cnt > 0) {
            $data['jobs'] = $this->accounting_model->costOfSales($data['permission'], $this->user, $this->brand, $arr4);
            $data['creditNote'] = $this->db->query("SELECT v.*,(SELECT brand FROM customer WHERE customer.id = v.customer) AS brand FROM credit_note AS v WHERE (type = '1' OR type = '4') AND status = '3' AND " . $arr4 . " HAVING brand = '$this->brand' ")->result();
        } else {
            $data['jobs'] = $this->accounting_model->costOfSalesPages($data['permission'], $this->user, $this->brand, 9, 0);
        }

        $this->load->view('accounting/exportCostOfSales.php', $data);
    }

    public function exportCostOfSalesTemp()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 109);
        $arr2 = array();
        // if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
        //     $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
        //     $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
        //     if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,0); }
        // }else{
        //     $date_to = "";
        //     $date_from = "";
        // }
        $date_to = "2020-10-05";
        $date_from = "2020-09-05";
        array_push($arr2, 0);
        // print_r($arr2);
        $cond1 = "issue_date BETWEEN '$date_from' AND '$date_to'";
        $arr1 = array($cond1);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        echo $arr4 = implode(" and ", $arr3);
        //print_r($arr4);
        if ($arr_1_cnt > 0) {
            $jobs = $this->accounting_model->costOfSales($data['permission'], $this->user, $this->brand, $arr4);
        } else {
            $jobs = $this->accounting_model->costOfSalesPages($data['permission'], $this->user, $this->brand, 9, 0);
        }
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load('assets/uploads/excel/CostOfSales.xlsx');
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $rows = 2;
        if (isset($jobs)) {
            foreach ($jobs->result() as $job) {
                $priceList = $this->projects_model->getJobPriceListData($job->price_list);
                $total_revenue = $this->sales_model->calculateRevenueJob($job->id, $job->type, $job->volume, $priceList->id);

                $objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $job->code);
                $objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $this->customer_model->getCustomer($job->customer));
                $objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $job->number);
                $objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $this->admin_model->getServices($priceList->service));
                $objPHPExcel->getActiveSheet()->setCellValue('e' . $rows, $this->admin_model->getLanguage($priceList->source));
                $objPHPExcel->getActiveSheet()->setCellValue('f' . $rows, $this->admin_model->getLanguage($priceList->target));
                if ($job->type == 1) {
                    $objPHPExcel->getActiveSheet()->setCellValue('g' . $rows, $job->volume);
                } elseif ($job->type == 2) {
                    $objPHPExcel->getActiveSheet()->setCellValue('g' . $rows, $total_revenue / $job->volume);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('h' . $rows, $priceList->rate);
                $objPHPExcel->getActiveSheet()->setCellValue('i' . $rows, number_format($total_revenue, 2));
                $objPHPExcel->getActiveSheet()->setCellValue('j' . $rows, $this->admin_model->getCurrency($priceList->currency));
                $objPHPExcel->getActiveSheet()->setCellValue('k' . $rows, number_format($this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $job->issue_date, $total_revenue), 2));
                $objPHPExcel->getActiveSheet()->setCellValue('l' . $rows, number_format($this->accounting_model->totalCostByJobCurrency(2, $job->id), 2));
                $objPHPExcel->getActiveSheet()->setCellValue('m' . $rows, $job->closed_date);
                $objPHPExcel->getActiveSheet()->setCellValue('n' . $rows, $this->admin_model->getAdmin($job->created_by));
                $objPHPExcel->getActiveSheet()->setCellValue('o' . $rows, $this->admin_model->getAdminMulti($job->assigned_sam));
                $objPHPExcel->getActiveSheet()->setCellValue('p' . $rows, $job->issue_date);

                $rows++;
            }
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="CostOfSales.xlsx"');
        header('Cache-Control: max-age=0');
        header("Pragma: no-cache");
        header("Expires: 0");
        $objWriter->save('php://output');
    }
    ///currency rate  start 
    public function currencyRate()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 146);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 146);
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['currency'])) {
                    $currency = $_REQUEST['currency'];
                    if (!empty($currency)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $currency = "";
                }

                if (isset($_REQUEST['currency_to'])) {
                    $currency_to = $_REQUEST['currency_to'];
                    if (!empty($currency_to)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $currency_to = "";
                }

                if (isset($_REQUEST['months'])) {
                    $months = $_REQUEST['months'];
                    if (!empty($months)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $months = "";
                }

                if (isset($_REQUEST['years'])) {
                    $years = $_REQUEST['years'];
                    if (!empty($years)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $years = "";
                }

                $cond1 = "currency = '$currency'";
                $cond2 = "currency_to = '$currency_to'";
                $cond3 = "month = '$months'";
                $cond4 = "year = '$years'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);
                if ($arr_1_cnt > 0) {
                    $data['rate'] = $this->accounting_model->AllCurrenyRate($arr4);
                } else {
                    $data['rate'] = $this->accounting_model->AllCurrenyRatePages(9, 0);
                }
                $data['total_rows'] = $data['rate']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllCurrenyRate(1)->num_rows();
                $config['base_url'] = base_url('accounting/currencyRate');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['rate'] = $this->accounting_model->AllCurrenyRatePages($limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/currencyRate.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCurrencyRate()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 146);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/addCurrencyRate.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCurrencyRate()
    {
        $currency = $this->db->get('currency')->result();
        $sqlAray = array();
        foreach ($currency as $currency) {
            $data['currency_to'] = $_POST['currency'];
            $data['month'] = $_POST['month'];
            $data['year'] = $_POST['year'];
            $data['currency'] = $_POST[$currency->id];
            $data['rate'] = $_POST[$currency->name];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            array_push($sqlAray, $data);
        }
        if ($this->db->insert_batch('currenies_rate', $sqlAray)) {
            $true = "Currency Rate Added Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/currencyRate");
        } else {
            $error = "Failed To Currency Rate ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/currencyRate");
        }
    }

    public function editCurrencyRate()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 146);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 146);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['rate'] = $this->db->get_where('currenies_rate', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/editCurrencyRate.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditCurrencyRate()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 146);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['currency'] = $_POST['currency'];
            $data['currency_to'] = $_POST['currency_to'];
            $data['month'] = $_POST['month'];
            $data['year'] = $_POST['year'];
            $data['rate'] = $_POST['rate'];
            $this->admin_model->addToLoggerUpdate('currenies_rate', 146, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('currenies_rate', $data, array('id' => $id))) {
                $true = "Currency Rate Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/currencyRate");
            } else {
                $error = "Failed To Currency Rate ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/currencyRate");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCurrencyRate($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 146);
        if ($data['permission']->delete == 1) {
            $this->admin_model->addToLoggerDelete('currenies_rate', 146, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('currenies_rate', array('id' => $id))) {
                $true = "Currency Rate Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/currencyRate");
            } else {
                $error = "Failed To Delete Currency Rate ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/currencyRate");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    ////// currency rate end

    public function creditNote()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 157);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['po'])) {
                    $po = $_REQUEST['po'];
                    $poID = $this->accounting_model->getPONumberID($po);
                    if (!empty($po)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $po = "";
                }

                //print_r($arr2);
                $cond1 = "c.customer = '$customer'";
                $cond2 = "c.po = '$poID'";
                //$cond3 = "";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['creditNote'] = $this->accounting_model->creditNote($this->brand, $arr4);
                } else {
                    $data['creditNote'] = $this->accounting_model->creditNotePages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->creditNote($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/creditNote');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['creditNote'] = $this->accounting_model->creditNotePages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/creditNote.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCreditNote()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/addCreditNote.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getClientInvoicedPOsSingleChoose()
    {
        $customer = $_POST['customer'];
        $payment_date = $_POST['payment_date'];
        $currency = $_POST['currency'];
        echo $this->accounting_model->getClientInvoicedPOsSingleChoose(0, $customer, $payment_date, $currency);
    }

    public function doAddCreditNote()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($permission->add == 1) {
            $data['type'] = $_POST['type'];
            if ($data['type'] == 1 || $data['type'] == 4) {
                $data['customer'] = $_POST['customer'];
                $data['currency'] = $_POST['currency'];
                $data['issue_date'] = date("Y-m-d", strtotime($_POST['issue_date']));
                $data['po'] = $_POST['po'];
                $data['amount'] = $_POST['amount'];
                $data['description'] = $_POST['description'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/creditNote/';
                    // $config['file']['upload_path']          = './assets/uploads/creditNote/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 100000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "accounting/creditNote");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                    }
                }
            }

            if ($data['type'] == 2 || $data['type'] == 3) {
                if (!isset($_POST['pos'])) {
                    $error = "Failed To Add Credit Note, Please select at least on PO ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/creditNote");
                }
                $data['customer'] = $_POST['customer'];
                $data['currency'] = $_POST['currency'];
                $data['issue_date'] = date("Y-m-d", strtotime($_POST['issue_date']));
                $data['pos'] = implode(",", $_POST['pos']);
                $data['amount'] = $_POST['amount'];
                $data['description'] = $_POST['description'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/creditNote/';
                    // $config['file']['upload_path']          = './assets/uploads/creditNote/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 100000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "accounting/creditNote");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                    }
                }
            }
            if ($this->db->insert('credit_note', $data)) {
                $credit_note_id = $this->db->insert_id();
                $this->accounting_model->addCreditNoteToJournal($_POST, $this->user, $this->brand, $credit_note_id);
                if ($data['type'] == 1 || $data['type'] == 4) {
                    $this->accounting_model->sendPoCreditNoteMail($data['po'], $data['description']);
                }
                $true = "Credit Note Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/creditNote");
            } else {
                $error = "Failed To Add Credit Note ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/creditNote");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCreditNote()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('credit_note', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/editCreditNote.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditCreditNote()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($permission->edit == 1) {
            $type = base64_decode($_POST['type']);
            $id = base64_decode($_POST['id']);
            if ($type == 1 || $type == 4) {
                $data['customer'] = $_POST['customer'];
                $data['currency'] = $_POST['currency'];
                $data['issue_date'] = date("Y-m-d", strtotime($_POST['issue_date']));
                $data['po'] = $_POST['po'];
                $data['amount'] = $_POST['amount'];
                $data['description'] = $_POST['description'];
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/creditNote/';
                    // $config['file']['upload_path']          = './assets/uploads/creditNote/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 100000;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "accounting/creditNote");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['file'] = $data_file['file_name'];
                    }
                }
            }
            $this->admin_model->addToLoggerUpdate('credit_note', 157, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('credit_note', $data, array('id' => $id))) {
                $true = "Credit Note Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/creditNote");
            } else {
                $error = "Failed To Edit Credit Note ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/creditNote");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function closeCreditNote()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('credit_note', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/closeCreditNote.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doCloseCreditNote()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['status'] = 3;
            $data['status_by'] = $this->user;
            $data['status_at'] = date("Y-m-d H:i:s");

            $this->admin_model->addToLoggerUpdate('credit_note', 157, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('credit_note', $data, array('id' => $id))) {
                $true = "Credit Note Closed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/creditNote");
            } else {
                $error = "Failed To Close Credit Note ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/creditNote");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getClientInvoicedPOsMultipleChoose()
    {
        $customer = $_POST['customer'];
        $payment_date = $_POST['payment_date'];
        $currency = $_POST['currency'];
        echo $this->accounting_model->getClientInvoicedPOsMultipleChoose(0, $customer, $payment_date, $currency);
    }

    public function approveCreditNoteRequest()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($data['permission']->view == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('credit_note', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/approveCreditNoteRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doApproveCreditNote()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 157);
        if ($permission->view == 1) {
            $id = base64_decode($_POST['id']);
            //Approve ..
            if (isset($_POST['submit'])) {

                $data['status_by'] = $this->user;
                $data['status_at'] = date("Y-m-d H:i:s");
                $data['status'] = 1;

                $this->admin_model->addToLoggerUpdate('credit_note', 157, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('credit_note', $data, array('id' => $id))) {
                    $this->accounting_model->sendApproveCreditNoteMail($id, $data['status'], "");
                    $true = "Credit Note Request Approved Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "accounting/creditNote");
                } else {
                    $error = "Failed To Approve Credit Note Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/creditNote");
                }
            } elseif (isset($_POST['reject'])) {
                //Reject ..
                $data['reject_reason'] = $_POST['reject_reason'];
                $data['approved_by'] = $this->user;
                $data['approved_at'] = date("Y-m-d H:i:s");
                $data['status'] = 2;

                $this->admin_model->addToLoggerUpdate('credit_note', 157, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('credit_note', $data, array('id' => $id))) {
                    $this->accounting_model->sendApproveCreditNoteMail($id, $data['status'], $data['reject_reason']);
                    $true = "Credit Note Request Rejected Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "accounting/creditNote");
                } else {
                    $error = "Failed To Reject Credit Note Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/creditNote");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function dtpRevenueReport()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 164);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 164);
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();

                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 0);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }

                // print_r($arr2);

                $cond1 = "j.closed_date BETWEEN '$date_from' AND '$date_to' ";

                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['project'] = $this->accounting_model->dtpRevenueReport($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['project'] = $this->accounting_model->dtpRevenueReport($data['permission'], $this->user, 0, 0);
                }
            } else {
                $data['project'] = $this->accounting_model->dtpRevenueReport($data['permission'], $this->user, 0, 0);
            }
            // //Pages ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/dtpRevenueReport.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportDtpRevenueReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=DTP_Revenue_Report.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 164);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 164);
            //body ..

            $arr2 = array();

            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 0);
                }
            } else {
                $date_to = "";
                $date_from = "";
            }

            // print_r($arr2);

            $cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";

            $arr1 = array($cond1);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['project'] = $this->accounting_model->dtpRevenueReport($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['project'] = $this->accounting_model->dtpRevenueReport($data['permission'], $this->user, 0, 0);
            }


            //Pages ..

            $this->load->view('accounting/exportDtpRevenueReport.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportTranslationRevenueReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Translation_Revenue_Report.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        //Check Permission ..

        //header ..
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 164);
        //body ..

        //                 $arr2 = array();

        //                     if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
        //                         $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
        //                         $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
        //                         if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,0); }
        //                     }else{
        //                         $date_to = "";
        //                         $date_from = "";
        //                     }

        //                     // print_r($arr2);

        //                     $cond1 = "l.created_at BETWEEN '$date_from' AND '$date_to' ";      

        //                     $arr1 = array($cond1);
        //                     $arr_1_cnt = count($arr2);
        //                     $arr3 = array();
        //                     for($i=0; $i<$arr_1_cnt; $i++ ){
        //                     array_push($arr3,$arr1[$arr2[$i]]);
        //                     }
        //                     $arr4 = implode(" and ",$arr3);
        //                     // print_r($arr4);   

        $arr4 = "l.created_at BETWEEN '2020-01-01' AND '2021-01-01' ";
        $data['project'] = $this->accounting_model->translationRevenueReport($data['permission'], $this->user, $this->brand, $arr4);


        //Pages ..

        $this->load->view('accounting/exportTranslationRevenueReport.php', $data);
    }
    public function vpoStatus()
    {
        ini_set('memory_limit', '-1');
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 106);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $filter['v.brand ='] = $this->brand;
            if (isset($_POST['search'])) {
                if (!empty($_REQUEST['date_from'])) {
                    $filter['t.created_at >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                }
                if (!empty($_REQUEST['date_to'])) {
                    $filter['t.created_at <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
                }
                if (!empty($_REQUEST['created_by'])) {
                    $filter['t.created_by ='] = $_REQUEST['created_by'];
                }
                if (!empty($_REQUEST['vendor'])) {
                    $filter['t.vendor ='] = $_REQUEST['vendor'];
                }
                if (isset($_REQUEST['status']) && $_REQUEST['status'] != -1) {
                    $filter['t.status ='] = $_REQUEST['status'];
                }
                if (!empty($_REQUEST['invoice_status'])) {
                    if ($_REQUEST['invoice_status'] == 1) {
                        $filter['t.verified ='] = 1;
                    } else {
                        $filter['t.verified <>'] = 1;
                    }
                }
                if (!empty($_REQUEST['code'])) {
                    $filter['t.code LIKE'] = "%" . $_REQUEST['code'] . "%";
                }
                $not_added_filter = $filter;
                if (!empty($_REQUEST['payment_status'])) {
                    if ($_REQUEST['payment_status'] == 1) {
                        $filter['p.status ='] = 1;
                        $data['payment_method'] = 1;
                        $task_not_added = array();
                    } else {
                        $filter['(p.status !=1 OR p.status IS NULL)'] = NULL;
                        $data['payment_method'] = 2;
                    }
                }

                $task_added = $this->accounting_model->vpoStatus_added($filter);
                if (!isset($task_not_added)) {
                    $task_not_added = $this->accounting_model->vpoStatus_not_added($not_added_filter);
                    $data_task = array_merge($task_added->result(), $task_not_added->result());
                } else {
                    $data_task = $task_added->result();
                }

                // to sort them by id desc
                $id = array_column($data_task, 'id');
                array_multisort($id, SORT_DESC, $data_task);
                $data['task'] = $data_task;
            }


            $data['filter'] = $filter;


            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/vpoStatus.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportvpoStatus()
    {
        ini_set('memory_limit', '-1');
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=VpoList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
        $filter['v.brand ='] = $this->brand;

        if (!empty($_REQUEST['date_from'])) {
            $filter['t.created_at >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
        }
        if (!empty($_REQUEST['date_to'])) {
            $filter['t.created_at <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
        }
        if (!empty($_REQUEST['created_by'])) {
            $filter['t.created_by ='] = $_REQUEST['created_by'];
        }
        if (!empty($_REQUEST['vendor'])) {
            $filter['t.vendor ='] = $_REQUEST['vendor'];
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != -1) {
            $filter['t.status ='] = $_REQUEST['status'];
        }
        if (!empty($_REQUEST['invoice_status'])) {
            if ($_REQUEST['invoice_status'] == 1) {
                $filter['t.verified ='] = 1;
            } else {
                $filter['t.verified <>'] = 1;
            }
        }
        if (!empty($_REQUEST['code'])) {
            $filter['t.code LIKE'] = "%" . $_REQUEST['code'] . "%";
        }

        $not_added_filter = $filter;
        if (!empty($_REQUEST['payment_status'])) {
            if ($_REQUEST['payment_status'] == 1) {
                $filter['p.status ='] = 1;
                $data['payment_method'] = 1;
                $task_not_added = array();
            } else {
                $filter['(p.status !=1 OR p.status IS NULL)'] = NULL;
                $data['payment_method'] = 2;
            }
        }
        $task_added = $this->accounting_model->vpoStatus_added($filter);
        if (!isset($task_not_added)) {
            $task_not_added = $this->accounting_model->vpoStatus_not_added($not_added_filter);
            $data_task = array_merge($task_added->result(), $task_not_added->result());
        } else {
            $data_task = $task_added->result();
        }
        // to sort them by id desc
        $id = array_column($data_task, 'id');
        array_multisort($id, SORT_DESC, $data_task);
        $data['task'] = $data_task;

        $this->load->view('accounting_new/exportvpoStatus.php', $data);
    }
    /* journal start*/
    //hagar & refaat
    ///////view
    public function journal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 126);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 106);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $filter['journal.brand ='] = $this->brand;
            if (isset($_POST['search'])) {
                if (!empty($_POST['date_from'])) {
                    $filter['t.created_at >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                }
                if (!empty($_POST['date_to'])) {
                    $filter['t.created_at <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
                }
                if (!empty($_POST['journal_id'])) {
                    $filter['journal.id ='] = $_POST['journal_id'];
                }
                if (!empty($_POST['journal_transaction_id'])) {
                    $filter['t.id ='] = $_POST['journal_transaction_id'];
                }
                if (!empty($_POST['created_by'])) {
                    $filter['t.created_by ='] = $_POST['created_by'];
                }
                if (!empty($_POST['section_name_1'])) {
                    $filter['sec.id ='] = $_POST['section_name_1'];
                }
                if (!empty($_POST['category_name_1'])) {
                    $filter['cat.id ='] = $_POST['category_name_1'];
                }
                if (!empty($_POST['sup_category_1'])) {
                    $filter['sub.id ='] = $_POST['sup_category_1'];
                }
            }
            $limit = 10;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $count = $this->accounting_model->AllJournalCount($filter);
            $config['base_url'] = base_url('accounting/journal');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            $config['total_rows'] = $count;
            $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
            $config['full_tag_close'] = "</ul>";
            $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
            $config['cur_tag_close'] = "</li>";
            $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
            $config['next_tagl_close'] = "</span></li>";
            $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
            $config['prev_tagl_close'] = "</span></li>";
            $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
            $config['last_tagl_close'] = "</li>";
            $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
            $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
            $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
            $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
            $config['num_links'] = 5;
            $config['show_count'] = TRUE;
            $this->pagination->initialize($config);
            $data['journal'] = $this->accounting_model->AllJournalPages($filter, $limit, $offset);
            $data['filter'] = $filter;

            // //Pages .. 
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/journal.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    //////add journal
    public function addJournal()
    {
        $data['journal_id'] = $this->accounting_model->get_next_id();
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['journal'] = $this->db->get('journal');
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/addJournal.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddjournal()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($permission->add == 1) {
            if ($_POST['balance'] == 0) {
                $new_pair = $_POST['new_pair'];
                $data['entry_description'] = trim($_POST['entry_description']);
                $data['description'] = trim($_POST['description']);
                $data['currency'] = $_POST['currency'];
                $data['date'] = date("Y-m-d", strtotime($_POST['date']));
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['brand'] = $this->brand;
                if ($this->db->insert('journal', $data)) {
                    $insert_id = $this->db->insert_id();
                    for ($i = 1; $i < $new_pair; $i++) {
                        if (!empty($_POST['amount_' . $i])) {

                            $dataTransaction['journal_id'] = $insert_id;
                            $dataTransaction['amount'] = $_POST['amount_' . $i];
                            $dataTransaction['debit_credit'] = $_POST['debit_credit_' . $i];
                            $dataTransaction['bank'] = $_POST['bank_' . $i];
                            $dataTransaction['sup_category'] = $_POST['sup_category_' . $i];
                            $dataTransaction['created_at'] = date("Y-m-d H:i:s");

                            $this->db->insert('journal_transaction', $dataTransaction);
                        }
                    }
                } else {
                    $error = "Failed To Add Journal ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/addJournal");
                }

                $true = "Journal Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/journal");
            } else {
                $error = "Failed To Add Journal, Balance must be equal 0 ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/addJournal");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    ///update journal 
    public function editJournal()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 126);
        if ($check) {
            //header ..
            //transaction id
            $data['id'] = base64_decode($_GET['j']);
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
            $data['brand'] = $this->brand;
            //body ..
            $data['row'] = $this->db->get_where('journal', array('id' => $data['id']))->row();
            $data['transaction'] = $this->db->select('t.*,cat.id as category_id,sec.id as section_id')->from('journal_transaction AS t')->join('accounting_subcategory AS sub', 't.sup_category = sub.id')->join('accounting_category AS cat', 'sub.category_id = cat.id')
                ->join('accounting_section AS sec', 'cat.section_id = sec.id')->where(array('journal_id' => $data['id']))->get();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/editJournal.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditJournal()
    {
        $check = $this->admin_model->checkPermission($this->role, 126);
        if ($check) {
            if ($_POST['balance'] == 0) {

                $new_pair = $_POST['new_pair'];
                $id = base64_decode($_POST['id']);
                $data['entry_description'] = trim($_POST['entry_description']);
                $data['description'] = trim($_POST['description']);
                $data['currency'] = $_POST['currency'];
                $data['date'] = date("Y-m-d", strtotime($_POST['date']));
                $this->admin_model->addToLoggerUpdate('journal', 126, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('journal', $data, array('id' => $id))) {
                    $deletedTransactions = explode(",", $_POST['deletedTransactions']);
                    for ($i = 0; $i < count($deletedTransactions); $i++) {
                        if (!empty($deletedTransactions[$i])) {
                            $this->admin_model->addToLoggerDelete('journal_transaction', 126, 'id', $deletedTransactions[$i], 0, 0, $this->user);
                            $this->db->delete('journal_transaction', array('id' => $deletedTransactions[$i]));
                        }
                    }
                    for ($i = 1; $i < $new_pair; $i++) {
                        if (!empty($_POST['amount_' . $i])) {
                            $dataTransaction['journal_id'] = $id;
                            $dataTransaction['amount'] = $_POST['amount_' . $i];
                            $dataTransaction['debit_credit'] = $_POST['debit_credit_' . $i];
                            $dataTransaction['bank'] = $_POST['bank_' . $i];
                            $dataTransaction['sup_category'] = $_POST['sup_category_' . $i];
                            $dataTransaction['created_at'] = date("Y-m-d H:i:s");
                            if (!empty($_POST['tID_' . $i])) {
                                $tID = $_POST['tID_' . $i];
                                $this->admin_model->addToLoggerUpdate('journal_transaction', 126, 'id', $tID, 1, $id, $this->user);
                                $this->db->update('journal_transaction', $dataTransaction, array('id' => $tID));
                            } else {
                                $this->db->insert('journal_transaction', $dataTransaction);
                            }
                        }
                    }
                } else {
                    $error = "Failed To edit Journal ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/journal");
                }

                $true = "Journal updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/journal");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    ///delete journal
    public function deleteJournal()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('journal', 126, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('journal', array('id' => $id))) {
                $this->db->delete('journal_transaction', array('journal_id' => $id));
                $true = "Journal Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "accounting/journal");
            } else {
                $error = "Failed To Delete Journal ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "accounting/journal");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    //post request
    public function getCategories()
    {
        $section = $_POST['section'];
        $data = '<option disabled="disabled" value="" selected="selected">-- Select Category --</option>';
        $data .= $this->accounting_model->selectCategory(0, $section);

        echo $data;
    }

    public function getSupCategories()
    {
        $category = $_POST['category'];
        $data = '<option disabled="disabled" value="" selected="selected">-- Select Sup-Category --</option>';
        $data .= $this->accounting_model->selectSupCategory(0, $category);

        echo $data;
    }

    public function exportJournals()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=journalsList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        $filter = array();
        $filter_text = "";
        if (!empty($_POST['date_from'])) {
            $filter['t.created_at >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
        }
        if (!empty($_POST['date_to'])) {
            $filter['t.created_at <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
        }
        if (!empty($_POST['journal_id'])) {
            $filter['journal.id ='] = $_POST['journal_id'];
        }
        if (!empty($_POST['journal_transaction_id'])) {
            $filter['t.id ='] = $_POST['journal_transaction_id'];
        }
        if (!empty($_POST['created_by'])) {
            $filter['t.created_by ='] = $_POST['created_by'];
        }
        if (!empty($_POST['section_name_1'])) {
            $filter['sec.id ='] = $_POST['section_name_1'];
        }
        if (!empty($_POST['category_name_1'])) {
            $filter['cat.id ='] = $_POST['category_name_1'];
        }
        if (!empty($_POST['sup_category_1'])) {
            $filter['sub.id ='] = $_POST['sup_category_1'];
        }

        //$data['journal'] = $this->accounting_model->AllJournal($filter_text);
        $data['journal'] = $this->accounting_model->AllJournalPages($filter, 0, 0);
        $this->load->view('accounting_new/exportJournals.php', $data);
    }

    /////////end journal
    /*journal end*/

    public function costOfSalesTest()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 109);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 109);
            //body ..
            if (isset($_POST['search'])) {

                $filter['users.brand ='] = $this->brand;
                if (!empty($_REQUEST['date_from'])) {
                    $filter['issue_date >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                }
                if (!empty($_REQUEST['date_to'])) {
                    $filter['issue_date <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
                }
                $data['jobs'] = $this->accounting_model->costOfSalesTest($filter);
                $data['filter'] = $filter;
            } else {
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/costOfSalesTest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportCostOfSalesTest()
    {
        ini_set('memory_limit', '-1');
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=CostOfSales.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 109);
        $filter['users.brand ='] = $this->brand;
        $credit_note_filter['customer.brand ='] = $this->brand;
        if (!empty($_REQUEST['date_from'])) {
            $filter['issue_date >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $credit_note_filter['issue_date >='] = date("Y-m-d", strtotime($_REQUEST['date_from']));
        }
        if (!empty($_REQUEST['date_to'])) {
            $filter['issue_date <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
            $credit_note_filter['issue_date <='] = date("Y-m-d", strtotime($_REQUEST['date_to']));
        }

        if (count($filter) > 1) {
            $data['jobs'] = $this->accounting_model->costOfSalesTest($filter);
            $credit_note_filter['(type = 1 OR type = 4)'] = NULL;
            $credit_note_filter['v.status'] = 3;
            //var_dump($this->db->last_query());die;
            $data['creditNote'] = $this->accounting_model->costofSalesCreditNotes($credit_note_filter);
        } else {
            $data['jobs'] = $this->accounting_model->costOfSalesPagesTest($filter, 9, 0);
        }


        $this->load->view('accounting/exportCostOfSalesTest.php', $data);
    }

    //// new update 
    public function getClientInvoicedPOsSingleChooseByNumber()
    {
        $customer = $_POST['customer'];
        $payment_date = $_POST['payment_date'];
        $currency = $_POST['currency'];
        $number = $_POST['number'];
        echo $this->accounting_model->getClientInvoicedPOsSingleChooseByNumber(0, $customer, $payment_date, $currency, $number);
    }
    public function getClientInvoicedPOsMultipleChooseByNumber()
    {
        $customer = $_POST['customer'];
        $payment_date = $_POST['payment_date'];
        $currency = $_POST['currency'];
        $number = $_POST['number'];
        $list = $_POST['list'];
        echo $this->accounting_model->getClientInvoicedPOsMultipleChoosebyNumber(0, $customer, $payment_date, $currency, $number, $list);
    }

    public function vpoVendorPortalList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 87);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 87);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $code = "";
                }
                // print_r($arr2);
                $cond1 = "t.created_by = '$created_by'";
                $cond2 = "t.vendor = '$vendor'";
                $cond3 = "t.task_type = '$task_type'";
                $cond4 = "t.closed_date BETWEEN '$date_from' AND '$date_to' ";
                $cond5 = "t.code LIKE '%$code%'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['task'] = $this->accounting_model->AllVPOVPortal($data['permission'], $this->brand, $arr4);
                } else {
                    $data['task'] = $this->accounting_model->AllVPOVPortalPages($data['permission'], $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllVPOVPortal($data['permission'], $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/vpoVendorPortalList');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['task'] = $this->accounting_model->AllVPOVPortalPages($data['permission'], $this->brand, $limit, $offset);
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/vpoPortalList.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function confirmInvoiceVendorPortal()
    {

        if (isset($_POST['select'])) {

            $select = $_POST['select'];
            for ($i = 0; $i < count($select); $i++) {
                $id = $select[$i];
                $data['verified'] = 1;
                $data['verified_by'] = $this->user;
                $data['verified_at'] = date("Y-m-d H:i:s");
                //  $data['invoice_date'] = $_POST['invoice_date'];
                $this->admin_model->addToLoggerUpdate('job_task', 87, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('job_task', $data, array('id' => $id))) {
                    $task = $this->db->get_where('job_task', array('id' => $id))->row();
                } else {
                    $error = "Problem found please try Again  ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "accounting/vpoVendorPortalList");
                }
            }
            $true = "Selected POs Verified Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/vpoVendorPortalList");
        } else {
            $error = "Problem found please try Again  ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/vpoVendorPortalList");
        }
    }

    public function exportVpoPortal()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vpoList.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 87);
        $arr2 = array();
        if (isset($_REQUEST['created_by'])) {
            $created_by = $_REQUEST['created_by'];
            if (!empty($created_by)) {
                array_push($arr2, 0);
            }
        } else {
            $created_by = "";
        }
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 1);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['code'])) {
            $code = $_REQUEST['code'];
            if (!empty($code)) {
                array_push($arr2, 2);
            }
        } else {
            $code = "";
        }
        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
            $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
            $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                array_push($arr2, 3);
            }
        } else {
            $date_to = "";
            $date_from = "";
        }
        // print_r($arr2);
        $cond1 = "t.created_by = '$created_by'";
        $cond2 = "t.vendor = '$vendor'";
        $cond3 = "t.code LIKE '%$code%'";
        $cond4 = "t.closed_date BETWEEN '$date_from' AND '$date_to' ";
        $arr1 = array($cond1, $cond2, $cond3, $cond4);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['task'] = $this->accounting_model->AllVPOVPortal($data['permission'], $this->brand, $arr4);
        } else {
            $data['task'] = $this->accounting_model->AllVPOVPortal($data['permission'], $this->brand, 1);
        }

        $this->load->view('accounting/exportVpo.php', $data);
    }

    public function overDueInvoices()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 75);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 75);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $customer = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $id = "";
                }
                //print_r($arr2);
                $cond1 = "v.customer = '$customer'";
                $cond2 = "DATE_ADD(v.created_at, INTERVAL v.payment DAY) BETWEEN '$date_from' AND '$date_to' ";
                $cond3 = "v.id = '$id'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['invoice'] = $this->accounting_model->AllOverDueInvoices($this->brand, $arr4);
                } else {
                    $data['invoice'] = $this->accounting_model->AllOverDueInvoicesPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->AllOverDueInvoices($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/overDueInvoices');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);
                $data['invoice'] = $this->accounting_model->AllOverDueInvoicesPages($this->brand, $limit, $offset);
            }


            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('accounting/overDueInvoices.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportOverDueInvoices()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 75);
        if ($permission == 1) {
            $file_type = "vnd.ms-excel";
            $file_ending = "xls";
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=overDueInvoicesList.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");

            $arr2 = array();
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 0);
                }
            } else {
                $customer = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime($_REQUEST['date_to']));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 1);
                }
            } else {
                $date_to = "";
                $date_from = "";
            }
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                if (!empty($id)) {
                    array_push($arr2, 2);
                }
            } else {
                $id = "";
            }
            //print_r($arr2);
            $cond1 = "v.customer = '$customer'";
            $cond2 = "DATE_ADD(v.created_at, INTERVAL v.payment DAY) BETWEEN '$date_from' AND '$date_to' ";
            $cond3 = "v.id = '$id'";
            $arr1 = array($cond1, $cond2, $cond3);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0)
                $data['invoice'] = $this->accounting_model->AllOverDueInvoices($this->brand, $arr4);
            else
                $data['invoice'] = $this->accounting_model->AllOverDueInvoices($this->brand, 1);

            $this->load->view('accounting/exportOverDueInvoices.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function allRunningCpo()
    {
        $check = $this->admin_model->checkPermission($this->role, 206);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 206);
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['code'])) {
                    $code = $_REQUEST['code'];
                    if (!empty($code)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $code = "";
                }
                if (isset($_REQUEST['customer'])) {
                    $customer = $_REQUEST['customer'];
                    if (!empty($customer)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $customer = "";
                }

                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        if ($status == 2) {
                            $status = 0;
                        }
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }

                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 3);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                if (isset($_REQUEST['verified'])) {
                    $verified = $_REQUEST['verified'];
                    if (!empty($verified)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $verified = "";
                }
                if ($verified == 3) {
                    $verified = 0;
                }

                // print_r($arr2);
                $cond1 = "j.code LIKE '%$code%'";
                $cond2 = "p.customer = '$customer'";
                $cond3 = "j.status = '$status'";
                $cond4 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
                $cond5 = "po.verified = '$verified'";

                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['job'] = $this->accounting_model->allRunningCpo($this->brand, $arr4);
                } else {
                    $data['job'] = $this->accounting_model->allRunningCpoPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->allRunningCpo($this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/allRunningCpo');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['job'] = $this->accounting_model->allRunningCpoPages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/allRunningCpo.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportRunningCpo($data)
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 206);
        if ($permission == 1) {
            $file_type = "vnd.ms-excel";
            $file_ending = "xls";
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=RunningCpo.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");
            $arr2 = array();
            if (isset($_REQUEST['code'])) {
                $code = $_REQUEST['code'];
                if (!empty($code)) {
                    array_push($arr2, 0);
                }
            } else {
                $code = "";
            }
            if (isset($_REQUEST['customer'])) {
                $customer = $_REQUEST['customer'];
                if (!empty($customer)) {
                    array_push($arr2, 1);
                }
            } else {
                $customer = "";
            }

            if (isset($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if (!empty($status)) {
                    if ($status == 2) {
                        $status = 0;
                    }
                    array_push($arr2, 2);
                }
            } else {
                $status = "";
            }

            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 3);
                }
            } else {
                $date_from = "";
                $date_to = "";
            }
            if (isset($_REQUEST['verified'])) {
                $verified = $_REQUEST['verified'];
                if (!empty($verified)) {
                    array_push($arr2, 4);
                }
            } else {
                $verified = "";
            }
            if ($verified == 3) {
                $verified = 0;
            }

            // print_r($arr2);
            $cond1 = "j.code LIKE '%$code%'";
            $cond2 = "p.customer = '$customer'";
            $cond3 = "j.status = '$status'";
            $cond4 = "j.created_at BETWEEN '$date_from' AND '$date_to'";
            $cond5 = "po.verified = '$verified'";

            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['job'] = $this->accounting_model->allRunningCpo($this->brand, $arr4);
            } else {
                $data['job'] = $this->accounting_model->allRunningCpo($this->brand, 1);
            }

            $this->load->view('accounting_new/exportRunningCpo.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }
    // start payment methods
    public function allPaymentMethods()
    {
        $check = $this->admin_model->checkPermission($this->role, 207);
        if ($check) {
            // header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $data['name'] = $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['bank'])) {
                    $data['bank'] = $bank = $_REQUEST['bank'];
                    if (!empty($bank)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $bank = "";
                }
                if ($bank == 100) {
                    $bank = 0;
                }

                // print_r($arr2);
                $cond1 = "name LIKE '%$name%'";
                $cond2 = "bank = '$bank'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['payment_method'] = $this->accounting_model->allPaymentMethod($this->brand, $arr4);
                } else {
                    $data['payment_method'] = $this->accounting_model->allPaymentMethodPages($this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->accounting_model->allPaymentMethod($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('accounting/allPaymentMethods');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
                $config['cur_tag_close'] = "</li>";
                $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
                $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
                $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
                $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['payment_method'] = $this->accounting_model->allPaymentMethodPages($this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/allPaymentMethods.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addPaymentMethod()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 207);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('accounting_new/addPaymentMethod.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddPaymentMethod()
    {

        $data['name'] = $_POST['name'];
        $data['bank'] = $_POST['bank'];
        $data['brand'] = $this->brand;
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");

        if ($this->db->insert('payment_method', $data)) {

            $true = "Payment Method Added Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "accounting/allPaymentMethods");
        } else {
            $error = "Failed To Add Payment Method  ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "accounting/addPaymentMethod");
        }
    }

    public function deletePaymentMethod($id)
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 184);
        if ($data['permission']->delete == 1) {
            // check if already has score 
            $invoices = $this->db->get_where('invoices', array('payment_method' => $id))->row();
            $payments = $this->db->get_where('payment', array('payment_method' => $id))->row();
            if (!empty($invoices) || !empty($payments)) {
                $error = "Error! This payment method already added to invoices OR payments...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->db->delete('payment_method', array('id' => $id));
                $true = "Payment Method Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    function exportInvoicePdf()
    {
        $check = $this->admin_model->checkPermission($this->role, 75);
        if ($check) {
            $data['id'] = $id = base64_decode($_GET['t']);
            $data['invoice'] = $invoice = $this->db->get_where('invoices', array('id' => $id))->row();
            $data['bank'] = $bank = $this->db->query(" SELECT p.id,p.name,b.name,b.data,b.id AS bank FROM `payment_method` AS p LEFT OUTER JOIN bank AS b on b.id = p.bank WHERE p.id = '$invoice->payment_method'  ")->row();
            $data['lead'] = $lead = $this->db->get_where('customer_leads', array('id' => $invoice->lead))->row();
            $data['pos'] = $pos = explode(",", $invoice->po_ids);
            $data['image_src'] = base_url() . "assets/images/logo_ar.jpg";

            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('invoice_' . $id);
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(20);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();
            $html = $this->load->view('accounting_new/exportInvoicePdf.php', $data, true);

            $pdf->writeHTML($html, true, 0, true, 0);

            //   $pdf->lastPage();
            $pdf->Output("invoice_'.$id.pdf", 'I');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function HasErrorPortalVPO()
    {
        if (isset($_POST['task'])) {
            $task = base64_decode($_POST['task']);
            $data['has_error'] = implode(",", $_POST['has_error']);
            $data['verified'] = 2;
            $data['verified_at'] = date("Y-m-d H:i:s");
            $data['verified_by'] = $this->user;
            $this->admin_model->addToLoggerUpdate('job_task', 87, 'id', $task, 0, 0, $this->user);
            if ($this->db->update('job_task', $data, array('id' => $task))) {
                $true = "VPOs Errors Selected Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "There's Something Wrong , Please try Again !!";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "Page Not Found ..";
        }
    }
}
