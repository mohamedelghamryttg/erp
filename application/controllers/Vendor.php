<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
{
    var $role, $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
    }

    public function index()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 42);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 42);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    if (!empty($email)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $email = "";
                }
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['contact'])) {
                    $contact = $_REQUEST['contact'];
                    if (!empty($contact)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $contact = "";
                }
                if (isset($_REQUEST['country'])) {
                    $country = $_REQUEST['country'];
                    if (!empty($country)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $country = "";
                }
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $type = "";
                }
                if (isset($_REQUEST['dialect'])) {
                    $dialect = $_REQUEST['dialect'];
                    if (!empty($dialect)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $dialect = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 8);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 9);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['unit'])) {
                    $unit = $_REQUEST['unit'];
                    if (!empty($unit)) {
                        array_push($arr2, 10);
                    }
                } else {
                    $unit = "";
                }
                if (isset($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                    if (!empty($subject)) {
                        array_push($arr2, 11);
                    }
                } else {
                    $subject = "";
                }
                if (isset($_REQUEST['tools'])) {
                    $tools = $_REQUEST['tools'];
                    if (!empty($tools)) {
                        array_push($arr2, 12);
                    }
                } else {
                    $tools = "";
                }
                if (isset($_REQUEST['rate'])) {
                    $rate = $_REQUEST['rate'];
                    if (!empty($rate)) {
                        array_push($arr2, 13);
                    }
                } else {
                    $rate = "";
                }

                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 14);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                // print_r($arr2);
                $cond1 = "email LIKE '%$email%'";
                $cond2 = "name LIKE '%$name%'";
                $cond3 = "contact LIKE '%$contact%'";
                $cond4 = "country = '$country'";
                $cond5 = "type = '$type'";
                $cond6 = "dialect LIKE '%$dialect%'";
                $cond7 = "source_lang = '$source_lang'";
                $cond8 = "target_lang = '$target_lang'";
                $cond9 = "service = '$service'";
                $cond10 = "task_type = '$task_type'";
                $cond11 = "unit = '$unit'";
                $cond12 = "(v.subject = '$subject' OR v.subject LIKE '$subject,%' OR v.subject LIKE '%,$subject' OR v.subject LIKE '%,$subject,%')";
                $cond13 = "(v.tools = '$tools' OR v.tools LIKE '$tools,%' OR v.tools LIKE '%,$tools' OR v.tools LIKE '%,$tools,%')";
                $cond14 = "rate <= '$rate'";
                $cond15 = "v.created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9, $cond10, $cond11, $cond12, $cond13, $cond14, $cond15);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vendor'] = $this->vendor_model->AllVendors($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->AllVendors($data['permission'], $this->user, 1000, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/index');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vendors.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportVendorsTicket()
    {
        $id = base64_decode($_GET['t']);
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vendors_ticket_$id.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $check = $this->admin_model->checkPermission($this->role, 42);
        if ($check) {
            $data['id'] = $id;
            $data['ticket_resources'] = $this->db->get_where('vm_ticket_resource', array('ticket' => $id));
            $this->load->view('vendor/exportVendorsTicket.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportVendors()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vendors.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $check = $this->admin_model->checkPermission($this->role, 42);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 42);
            //body ..
            $data['user'] = $this->user;

            $arr2 = array();
            if (isset($_REQUEST['email'])) {
                $email = $_REQUEST['email'];
                if (!empty($email)) {
                    array_push($arr2, 0);
                }
            } else {
                $email = "";
            }
            if (isset($_REQUEST['name'])) {
                $name = $_REQUEST['name'];
                if (!empty($name)) {
                    array_push($arr2, 1);
                }
            } else {
                $name = "";
            }
            if (isset($_REQUEST['contact'])) {
                $contact = $_REQUEST['contact'];
                if (!empty($contact)) {
                    array_push($arr2, 2);
                }
            } else {
                $contact = "";
            }
            if (isset($_REQUEST['country'])) {
                $country = $_REQUEST['country'];
                if (!empty($country)) {
                    array_push($arr2, 3);
                }
            } else {
                $country = "";
            }
            if (isset($_REQUEST['type'])) {
                $type = $_REQUEST['type'];
                if (!empty($type)) {
                    array_push($arr2, 4);
                }
            } else {
                $type = "";
            }
            if (isset($_REQUEST['dialect'])) {
                $dialect = $_REQUEST['dialect'];
                if (!empty($dialect)) {
                    array_push($arr2, 5);
                }
            } else {
                $dialect = "";
            }
            if (isset($_REQUEST['source_lang'])) {
                $source_lang = $_REQUEST['source_lang'];
                if (!empty($source_lang)) {
                    array_push($arr2, 6);
                }
            } else {
                $source_lang = "";
            }
            if (isset($_REQUEST['target_lang'])) {
                $target_lang = $_REQUEST['target_lang'];
                if (!empty($target_lang)) {
                    array_push($arr2, 7);
                }
            } else {
                $target_lang = "";
            }
            if (isset($_REQUEST['service'])) {
                $service = $_REQUEST['service'];
                if (!empty($service)) {
                    array_push($arr2, 8);
                }
            } else {
                $service = "";
            }
            if (isset($_REQUEST['task_type'])) {
                $task_type = $_REQUEST['task_type'];
                if (!empty($task_type)) {
                    array_push($arr2, 9);
                }
            } else {
                $task_type = "";
            }
            if (isset($_REQUEST['unit'])) {
                $unit = $_REQUEST['unit'];
                if (!empty($unit)) {
                    array_push($arr2, 10);
                }
            } else {
                $unit = "";
            }
            if (isset($_REQUEST['subject'])) {
                $subject = $_REQUEST['subject'];
                if (!empty($subject)) {
                    array_push($arr2, 11);
                }
            } else {
                $subject = "";
            }
            if (isset($_REQUEST['tools'])) {
                $tools = $_REQUEST['tools'];
                if (!empty($tools)) {
                    array_push($arr2, 12);
                }
            } else {
                $tools = "";
            }
            if (isset($_REQUEST['rate'])) {
                $rate = $_REQUEST['rate'];
                if (!empty($rate)) {
                    array_push($arr2, 13);
                }
            } else {
                $rate = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 14);
                }
            } else {
                $date_from = "";
                $date_to = "";
            }

            // print_r($arr2);
            $cond1 = "email LIKE '%$email%'";
            $cond2 = "name LIKE '%$name%'";
            $cond3 = "contact LIKE '%$contact%'";
            $cond4 = "country = '$country'";
            $cond5 = "type = '$type'";
            $cond6 = "dialect LIKE '%$dialect%'";
            $cond7 = "source_lang = '$source_lang'";
            $cond8 = "target_lang = '$target_lang'";
            $cond9 = "service = '$service'";
            $cond10 = "task_type = '$task_type'";
            $cond11 = "unit = '$unit'";
            $cond12 = "(v.subject = '$subject' OR v.subject LIKE '$subject,%' OR v.subject LIKE '%,$subject' OR v.subject LIKE '%,$subject,%')";
            $cond13 = "(v.tools = '$tools' OR v.tools LIKE '$tools,%' OR v.tools LIKE '%,$tools' OR v.tools LIKE '%,$tools,%')";
            $cond14 = "rate = '$rate'";
            $cond15 = "v.created_at BETWEEN '$date_from' AND '$date_to'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9, $cond10, $cond11, $cond12, $cond13, $cond14, $cond15);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     

            if ($arr_1_cnt > 0) {
                $data['vendor'] = $this->vendor_model->AllVendors($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, 9, 0);
            }

            // //Pages ..

            $this->load->view('vendor/exportVendors.php', $data);

        } else {
            echo "You have no permission to access this page";
        }



    }


    public function ttgVendor()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 127);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 127);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    if (!empty($email)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $email = "";
                }
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['contact'])) {
                    $contact = $_REQUEST['contact'];
                    if (!empty($contact)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $contact = "";
                }
                if (isset($_REQUEST['country'])) {
                    $country = $_REQUEST['country'];
                    if (!empty($country)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $country = "";
                }
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $type = "";
                }
                if (isset($_REQUEST['dialect'])) {
                    $dialect = $_REQUEST['dialect'];
                    if (!empty($dialect)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $dialect = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 8);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 9);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['unit'])) {
                    $unit = $_REQUEST['unit'];
                    if (!empty($unit)) {
                        array_push($arr2, 10);
                    }
                } else {
                    $unit = "";
                }
                // print_r($arr2);
                $cond1 = "email LIKE '%$email%'";
                $cond2 = "name LIKE '%$name%'";
                $cond3 = "contact LIKE '%$contact%'";
                $cond4 = "country = '$country'";
                $cond5 = "type = '$type'";
                $cond6 = "dialect LIKE '%$dialect%'";
                $cond7 = "source_lang = '$source_lang'";
                $cond8 = "target_lang = '$target_lang'";
                $cond9 = "service = '$service'";
                $cond10 = "task_type = '$task_type'";
                $cond11 = "unit = '$unit'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9, $cond10, $cond11);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vendor'] = $this->vendor_model->AllVendorsTTG($data['permission'], $this->user, 1, $arr4);
                } else {
                    $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->AllVendors($data['permission'], $this->user, 1000, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/index');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/ttgVendor.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function copyTTGVendor()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 127);
        if ($permission->add == 1) {
            $vendorSheet = base64_decode($_GET['t']);
            $sheetData = $this->db->get_where('vendor_sheet', array('id' => $vendorSheet))->row();
            $vendorData = $this->db->get_where('vendor', array('id' => $sheetData->vendor))->row();
            $dtpVendor = $this->db->get_where('vendor', array('email' => $vendorData->email, 'brand' => 2));
            if ($dtpVendor->num_rows() == 0) {
                $data['name'] = $vendorData->name;
                $data['email'] = $vendorData->email;
                $data['contact'] = $vendorData->contact;
                $data['country'] = $vendorData->country;
                $data['mother_tongue'] = $vendorData->mother_tongue;
                $data['profile'] = $vendorData->profile;
                $data['type'] = $vendorData->type;
                $data['color'] = $vendorData->color;
                $data['subject'] = $vendorData->subject;
                $data['tools'] = $vendorData->tools;
                $data['brand'] = $this->brand;
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('vendor', $data)) {
                    $dataSheet['vendor'] = $this->db->insert_id();
                    $dataSheet['source_lang'] = $sheetData->source_lang;
                    $dataSheet['target_lang'] = $sheetData->target_lang;
                    $dataSheet['dialect'] = $sheetData->dialect;
                    $dataSheet['service'] = $sheetData->service;
                    $dataSheet['task_type'] = $sheetData->task_type;
                    $dataSheet['unit'] = $sheetData->unit;
                    $dataSheet['rate'] = $sheetData->rate;
                    $dataSheet['currency'] = $sheetData->currency;
                    $dataSheet['subject'] = $sheetData->subject;
                    $dataSheet['tools'] = $sheetData->tools;
                    $dataSheet['comment'] = $sheetData->comment;
                    $dataSheet['copied'] = 1;
                    $dataSheet['created_by'] = $this->user;
                    $dataSheet['created_at'] = date("Y-m-d H:i:s");
                    if ($this->db->insert('vendor_sheet', $dataSheet)) {
                        $this->db->update('vendor_sheet', array('copied' => 1), array('id' => $vendorSheet));
                        $true = "Vendor Copied Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "vendor/ttgVendor");
                    } else {
                        $error = "Failed To Copy Vendor Sheet ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "vendor/ttgVendor");
                    }
                } else {
                    $error = "Failed To Copy Vendor ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "vendor/ttgVendor");
                }
            } else {
                $vendorData = $dtpVendor->row();
                $dataSheet['vendor'] = $vendorData->id;
                $dataSheet['source_lang'] = $sheetData->source_lang;
                $dataSheet['target_lang'] = $sheetData->target_lang;
                $dataSheet['dialect'] = $sheetData->dialect;
                $dataSheet['service'] = $sheetData->service;
                $dataSheet['task_type'] = $sheetData->task_type;
                $dataSheet['unit'] = $sheetData->unit;
                $dataSheet['rate'] = $sheetData->rate;
                $dataSheet['currency'] = $sheetData->currency;
                $dataSheet['subject'] = $sheetData->subject;
                $dataSheet['tools'] = $sheetData->tools;
                $dataSheet['comment'] = $sheetData->comment;
                $dataSheet['copied'] = 1;
                $dataSheet['created_by'] = $this->user;
                $dataSheet['created_at'] = date("Y-m-d H:i:s");
                if ($this->db->insert('vendor_sheet', $dataSheet)) {
                    $this->db->update('vendor_sheet', array('copied' => 1), array('id' => $vendorSheet));
                    $true = "Vendor Copied Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "vendor/ttgVendor");
                } else {
                    $error = "Failed To Copy Vendor Sheet ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "vendor/ttgVendor");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function vmticket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 49);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 49);
            //body ..
            $data['user'] = $this->user;
            $data['id'] = base64_decode($_GET['t']);
            $data['ticket'] = $this->vendor_model->viewSalesVmTickets($data['permission'], $this->user, $data['id']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function vmPmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 49);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 49);
            //body ..
            $data['user'] = $this->user;
            $data['id'] = base64_decode($_GET['t']);
            $opportunity = $this->projects_model->getProjectData($data['id']);
            $data['ticket'] = $this->vendor_model->viewPmVmTickets($data['permission'], $this->user, $data['id']);
            $data['sales_ticket'] = $this->vendor_model->viewSalesVmTickets($data['permission'], $this->user, $opportunity->opportunity);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vmPmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addVmTicket()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 49);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['user'] = $this->user;
            $data['from_id'] = $_GET['t'];
            $data['id'] = base64_decode($_GET['t']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addVmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVmTicket()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 49);
        if ($permission->add == 1) {
            $data['from_id'] = base64_decode($_POST['from_id']);
            $data['request_type'] = $_POST['request_type'];
            if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                $data['number_of_resource'] = $_POST['number_of_resource'];
            } else {
                $data['number_of_resource'] = 0;
            }
            //$subject =  $this->db->query("SELECT project_name FROM sales_opportunity WHERE id = '".$data['from_id']."'")->row()->project_name;
            $data['task_type'] = $_POST['task_type'];
            $data['service'] = $_POST['service'];
            $data['rate'] = $_POST['rate'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['currency'] = $_POST['currency'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['due_date'] = $_POST['delivery_date'];
            $data['subject'] = $_POST['subject'];
            $data['ticket_subject'] = $_POST['ticket_subject'];
            $data['software'] = $_POST['software'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['ticket_from'] = 1;
            $data['status'] = 1;

            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/tickets/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('vm_ticket', $data)) {
                $ticketNumber = $this->db->insert_id();
                $this->vendor_model->sendNewTicketEmail($this->user, $ticketNumber, $this->brand, $data['ticket_subject'], $data['from_id']);
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmTicket?t=" . base64_encode($data['from_id']));
            } else {
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmTicket?t=" . base64_encode($data['from_id']));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addVmPmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 50);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 50);
            //body ..
            $data['user'] = $this->user;
            $data['from_id'] = $_GET['t'];
            $data['id'] = base64_decode($_GET['t']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addVmPmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVmPmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 50);
        if ($check) {
            $data['from_id'] = base64_decode($_POST['from_id']);
            $data['request_type'] = $_POST['request_type'];
            if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                $data['number_of_resource'] = $_POST['number_of_resource'];
            } else {
                $data['number_of_resource'] = 0;
            }
            $subject = $this->db->query("SELECT name FROM project WHERE id = '" . $data['from_id'] . "'")->row()->name;
            $data['task_type'] = $_POST['task_type'];
            $data['service'] = $_POST['service'];
            $data['rate'] = $_POST['rate'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['currency'] = $_POST['currency'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['due_date'] = $_POST['delivery_date'];
            $data['subject'] = $_POST['subject'];
            $data['ticket_subject'] = $_POST['ticket_subject'];
            $data['software'] = $_POST['software'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['ticket_from'] = 2;
            $data['status'] = 1;

            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/tickets/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('vm_ticket', $data)) {
                $ticketNumber = $this->db->insert_id();
                $this->vendor_model->sendNewTicketEmail($this->user, $ticketNumber, $this->brand, $subject);
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmPmTicket?t=" . base64_encode($data['from_id']));
            } else {
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmPmTicket?t=" . base64_encode($data['from_id']));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 51);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 51);
            //body ..
            $data['user'] = $this->user;
            $data['id'] = base64_decode($_GET['t']);
            $data['from_id'] = $_GET['from'];
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/editVmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editVmPmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 51);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 51);
            //body ..
            $data['user'] = $this->user;
            $data['id'] = base64_decode($_GET['t']);
            $data['from_id'] = $_GET['from'];
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/editVmPmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function requesterTicketView()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 51);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 51);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $data['id'] = base64_decode($_GET['t']);
            $data['from_id'] = $_GET['from'];
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            $data['response'] = $this->db->get_where('vm_ticket_response', array('ticket' => $data['id']))->result();
            $data['log'] = $this->db->get_where('vm_ticket_time', array('ticket' => $data['id']))->result();
            $data['ticket_resource'] = $this->db->get_where('vm_ticket_resource', array('ticket' => $data['id']));
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/requesterTicketView.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function requesterTicketViewSales()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 51);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 51);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $data['id'] = base64_decode($_GET['t']);
            $data['from_id'] = $_GET['from'];
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            $data['response'] = $this->db->get_where('vm_ticket_response', array('ticket' => $data['id']))->result();
            $data['log'] = $this->db->get_where('vm_ticket_time', array('ticket' => $data['id']))->result();
            $data['ticket_resource'] = $this->db->get_where('vm_ticket_resource', array('ticket' => $data['id']));
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/requesterTicketViewSales.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 51);
        if ($check) {
            $from_id = $_POST['from_id'];
            $id = base64_decode($_POST['id']);

            $row_created_date = $this->db->get_where('vm_ticket', array('id' => $id))->row()->created_at;

            if ($row_created_date > $_POST['start_date'] || $row_created_date > $_POST['delivery_date']) {
                $error = "Error , Please Check Start Date & Delivery Date ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
            if ($_POST['start_date'] > $_POST['delivery_date']) {
                $error = "Error , Please Check Delivery Date must be >= Start Date ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $data['request_type'] = $_POST['request_type'];
            if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                $data['number_of_resource'] = $_POST['number_of_resource'];
            } else {
                $data['number_of_resource'] = 0;
            }
            $data['task_type'] = $_POST['task_type'];
            $data['service'] = $_POST['service'];
            $data['rate'] = $_POST['rate'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['currency'] = $_POST['currency'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['due_date'] = $_POST['delivery_date'];
            $data['subject'] = $_POST['subject'];
            $data['ticket_subject'] = $_POST['ticket_subject'];
            $data['software'] = $_POST['software'];
            $data['comment'] = $_POST['comment'];

            $this->admin_model->addToLoggerUpdate('vm_ticket', 51, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vm_ticket', $data, array('id' => $id))) {
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmTicket?t=" . $from_id);
            } else {
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmTicket?t=" . $from_id);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditVmPmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 51);
        if ($check) {
            $from_id = $_POST['from_id'];
            $id = base64_decode($_POST['id']);
            $data['request_type'] = $_POST['request_type'];
            if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                $data['number_of_resource'] = $_POST['number_of_resource'];
            } else {
                $data['number_of_resource'] = 0;
            }
            $data['task_type'] = $_POST['task_type'];
            $data['service'] = $_POST['service'];
            $data['rate'] = $_POST['rate'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['currency'] = $_POST['currency'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['due_date'] = $_POST['delivery_date'];
            $data['subject'] = $_POST['subject'];
            $data['ticket_subject'] = $_POST['ticket_subject'];
            $data['software'] = $_POST['software'];
            $data['comment'] = $_POST['comment'];

            $this->admin_model->addToLoggerUpdate('vm_ticket', 51, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vm_ticket', $data, array('id' => $id))) {
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmPmTicket?t=" . $from_id);
            } else {
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmPmTicket?t=" . $from_id);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 52);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $from_id = $_GET['from'];
            $this->admin_model->addToLoggerDelete('vm_ticket', 52, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vm_ticket', array('id' => $id))) {
                $true = "Ticket Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmTicket?t=" . $from_id);
            } else {
                $error = "Failed To Delete Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmTicket?t=" . $from_id);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteVmPmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 52);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $from_id = $_GET['from'];
            $this->admin_model->addToLoggerDelete('vm_ticket', 52, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vm_ticket', array('id' => $id))) {
                $true = "Ticket Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmPmTicket?t=" . $from_id);
            } else {
                $error = "Failed To Delete Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmPmTicket?t=" . $from_id);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updatedSubjectToolsColumnsToVendors()
    {
        $vendors = $this->db->get_where('vendor')->result();
        foreach ($vendors as $vendor) {
            echo $vendor->name;
            $vendorSheet = $this->db->get_where('vendor_sheet', array('vendor' => $vendor->id))->row();
            $data['subject'] = $vendorSheet->subject;
            $data['tools'] = $vendorSheet->tools;
            $data['sheet_fields'] = $vendorSheet->sheet_fields;
            $data['sheet_tools'] = $vendorSheet->sheet_tools;
            $this->db->update('vendor', $data, array('id' => $vendor->id));
            echo "</br>-----------------------------------</br>";
        }
    }

    public function addVendor()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 53);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 53);
            //body ..
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addVendor.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVendor()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 53);
        if ($check) {
            $new_pair = $_POST['new_pair'];
            if ($_POST['resource'] == 1) {
                // echo    "New Resource ...";
                $data['name'] = $_POST['name'];
                $data['email'] = $_POST['email'];
                $data['contact'] = $_POST['contact'];
                $data['phone_number'] = $_POST['phone_number'];
                $data['country'] = $_POST['country'];
                $data['mother_tongue'] = $_POST['mother_tongue'];
                $data['profile'] = $_POST['profile'];
                $data['type'] = $_POST['type'];
                $data['color'] = $_POST['color'];
                $data['subject'] = implode(",", $_POST['subject']);
                $data['tools'] = implode(",", $_POST['tools']);
                if ($_FILES['cv']['size'] != 0) {
                    $config['cv']['upload_path'] = './assets/uploads/vendors/';
                    // $config['cv']['upload_path']          = './assets/uploads/vendors/';
                    $config['cv']['encrypt_name'] = TRUE;
                    $config['cv']['allowed_types'] = 'zip|rar';
                    $config['cv']['max_size'] = 10000;
                    $config['cv']['max_width'] = 1024;
                    $config['cv']['max_height'] = 768;
                    $this->load->library('upload', $config['cv'], 'cv_upload');
                    if (!$this->cv_upload->do_upload('cv')) {
                        $error = $this->cv_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $data_file = $this->cv_upload->data();
                        $data['cv'] = $data_file['file_name'];
                    }
                }
                ///
                if ($_FILES['certificate']['size'] != 0) {
                    $config['certificate']['upload_path'] = './assets/uploads/certificate/';
                    $config['certificate']['encrypt_name'] = TRUE;
                    $config['certificate']['allowed_types'] = 'zip|rar';
                    $config['certificate']['max_size'] = 10000;
                    $config['certificate']['max_width'] = 1024;
                    $config['certificate']['max_height'] = 768;
                    $this->load->library('upload', $config['certificate'], 'certificate_upload');
                    if (!$this->certificate_upload->do_upload('certificate')) {
                        $error = $this->certificate_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $data_file = $this->certificate_upload->data();
                        $data['certificate'] = $data_file['file_name'];
                    }
                }
                ////
                if ($_FILES['NDA']['size'] != 0) {
                    $config['NDA']['upload_path'] = './assets/uploads/NDA/';
                    // $config['NDA']['upload_path']          = './assets/uploads/vendors/';
                    $config['NDA']['encrypt_name'] = TRUE;
                    $config['NDA']['allowed_types'] = 'zip|rar';
                    $config['NDA']['max_size'] = 10000;
                    $config['NDA']['max_width'] = 1024;
                    $config['NDA']['max_height'] = 768;
                    $this->load->library('upload', $config['NDA'], 'nda_upload');
                    if (!$this->nda_upload->do_upload('NDA')) {
                        $error = $this->nda_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $data_file = $this->nda_upload->data();
                        $data['NDA'] = $data_file['file_name'];
                    }
                }
                $data['brand'] = $this->brand;
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");

                if ($this->db->insert('vendor', $data)) {

                    $vendor_id = $this->db->insert_id();
                    // vendor password & send email
                    if ($this->brand == 1 || $this->brand == 3 || $this->brand == 11 || $this->brand == 2) {
                        $password = $this->vendor_model->generateVendorPassword();
                        $dataPass['password'] = base64_encode($password);
                        $dataPass['first_login'] = '1';
                        $this->db->update('vendor', $dataPass, array('id' => $vendor_id));
                        $this->vendor_model->SendVendorNewAccountEmailPortal($vendor_id);
                    }
                    //end
                    $dataSheet['vendor'] = $vendor_id;

                    for ($i = 1; $i < $new_pair; $i++) {
                        $dataSheet['source_lang'] = $_POST['source_lang_' . $i];
                        $dataSheet['target_lang'] = $_POST['target_lang_' . $i];
                        $dataSheet['dialect'] = $_POST['dialect_' . $i];
                        $dataSheet['service'] = $_POST['service_' . $i];
                        $dataSheet['task_type'] = $_POST['task_type_' . $i];
                        $dataSheet['unit'] = $_POST['unit_' . $i];
                        $dataSheet['rate'] = $_POST['rate_' . $i];
                        $dataSheet['special_rate'] = $_POST['special_rate_' . $i];
                        $dataSheet['currency'] = $_POST['currency_' . $i];
                        $dataSheet['created_by'] = $this->user;
                        $dataSheet['created_at'] = date("Y-m-d H:i:s");
                        if ($this->db->insert('vendor_sheet', $dataSheet)) {

                        } else {
                            $error = "Failed To Add Vendor Sheet ...";
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "vendor/");
                        }
                    }
                    $true = "Vendor Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "vendor/");
                } else {
                    $error = "Failed To Add Vendor ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "vendor/");
                }
            } else if ($_POST['resource'] == 2) {
                // echo "Existing Resource ..";
                $dataSheet['vendor'] = $_POST['vendor'];
                for ($i = 1; $i < $new_pair; $i++) {
                    $dataSheet['source_lang'] = $_POST['source_lang_' . $i];
                    $dataSheet['target_lang'] = $_POST['target_lang_' . $i];
                    $dataSheet['dialect'] = $_POST['dialect_' . $i];
                    $dataSheet['service'] = $_POST['service_' . $i];
                    $dataSheet['task_type'] = $_POST['task_type_' . $i];
                    $dataSheet['unit'] = $_POST['unit_' . $i];
                    $dataSheet['rate'] = $_POST['rate_' . $i];
                    $dataSheet['special_rate'] = $_POST['special_rate_' . $i];
                    $dataSheet['currency'] = $_POST['currency_' . $i];
                    $dataSheet['created_by'] = $this->user;
                    $dataSheet['created_at'] = date("Y-m-d H:i:s");
                    if ($this->db->insert('vendor_sheet', $dataSheet)) {

                    } else {
                        $error = "Failed To Add Vendor Sheet ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "vendor/");
                    }
                }
                $true = "Vendor Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/");
            }

        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editVendor()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 80);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 80);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->vendor_model->getVendorData($data['id']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/editVendor.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditVendor()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 80);
        if ($check) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['contact'] = $_POST['contact'];
            $data['phone_number'] = $_POST['phone_number'];
            $data['country'] = $_POST['country'];
            $data['mother_tongue'] = $_POST['mother_tongue'];
            $data['profile'] = $_POST['profile'];
            $data['type'] = $_POST['type'];
            $data['color'] = $_POST['color'];
            $data['color_comment'] = $_POST['color_comment'];
            $data['status'] = $_POST['status'];
            $data['subject'] = implode(",", $_POST['subject']);
            $data['tools'] = implode(",", $_POST['tools']);
            if ($_FILES['cv']['size'] != 0) {
                $config['cv']['upload_path'] = './assets/uploads/vendors/';
                // $config['cv']['upload_path']          = './assets/uploads/vendors/';
                $config['cv']['encrypt_name'] = TRUE;
                $config['cv']['allowed_types'] = 'zip|rar';
                $config['cv']['max_size'] = 10000;
                $config['cv']['max_width'] = 1024;
                $config['cv']['max_height'] = 768;
                $this->load->library('upload', $config['cv'], 'cv_upload');
                if (!$this->cv_upload->do_upload('cv')) {
                    $error = $this->cv_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->cv_upload->data();
                    $data['cv'] = $data_file['file_name'];
                }
            }
            ///
            if ($_FILES['certificate']['size'] != 0) {
                $config['certificate']['upload_path'] = './assets/uploads/certificate/';
                $config['certificate']['encrypt_name'] = TRUE;
                $config['certificate']['allowed_types'] = 'zip|rar';
                $config['certificate']['max_size'] = 10000;
                $config['certificate']['max_width'] = 1024;
                $config['certificate']['max_height'] = 768;
                $this->load->library('upload', $config['certificate'], 'certificate_upload');
                if (!$this->certificate_upload->do_upload('certificate')) {
                    $error = $this->certificate_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->certificate_upload->data();
                    $data['certificate'] = $data_file['file_name'];
                }
            }
            ////
            if ($_FILES['NDA']['size'] != 0) {
                $config['NDA']['upload_path'] = './assets/uploads/NDA/';
                // $config['NDA']['upload_path']          = './assets/uploads/vendors/';
                $config['NDA']['encrypt_name'] = TRUE;
                $config['NDA']['allowed_types'] = 'zip|rar';
                $config['NDA']['max_size'] = 10000;
                $config['NDA']['max_width'] = 1024;
                $config['NDA']['max_height'] = 768;
                $this->load->library('upload', $config['NDA'], 'nda_upload');
                if (!$this->nda_upload->do_upload('NDA')) {
                    $error = $this->nda_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->nda_upload->data();
                    $data['NDA'] = $data_file['file_name'];
                }
            }
            $this->admin_model->addToLoggerUpdate('vendor', 80, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vendor', $data, array('id' => $id))) {
                $true = "Vendor Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                // redirect(base_url()."vendor/");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "vendor");
                }
            } else {
                $error = "Failed To Edit Vendor ...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."vendor/");
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "vendor");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteVendor()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 42);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('vendor', 81, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vendor', array('id' => $id))) {
                $this->admin_model->addToLoggerDelete('vendor_sheet', 81, 'vendor', $id, 1, 0, $this->user);
                $this->db->delete('vendor_sheet', array('vendor' => $id));
                $true = "Vendor Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."vendor/");
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Vendor ...";
                $this->session->set_flashdata('error', $error);
                // redirect(base_url()."vendor/");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function vendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 54);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 54);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['dialect'])) {
                    $dialect = $_REQUEST['dialect'];
                    if (!empty($dialect)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $dialect = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $task_type = "";
                }
                // print_r($arr2);
                $cond1 = "vendor = '$vendor'";
                $cond2 = "dialect LIKE '%$dialect%'";
                $cond3 = "source_lang = '$source_lang'";
                $cond4 = "target_lang = '$target_lang'";
                $cond5 = "service = '$service'";
                $cond6 = "task_type = '$task_type'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vendor'] = $this->vendor_model->viewVmSheet($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['vendor'] = $this->vendor_model->viewVmSheetPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->viewVmSheet($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/vendorSheet');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['vendor'] = $this->vendor_model->viewVmSheetPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vendorSheet.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportAllVendors()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vendors.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $arr2 = array();
        if (isset($_REQUEST['vendor'])) {
            $vendor = $_REQUEST['vendor'];
            if (!empty($vendor)) {
                array_push($arr2, 0);
            }
        } else {
            $vendor = "";
        }
        if (isset($_REQUEST['dialect'])) {
            $dialect = $_REQUEST['dialect'];
            if (!empty($dialect)) {
                array_push($arr2, 1);
            }
        } else {
            $dialect = "";
        }
        if (isset($_REQUEST['source_lang'])) {
            $source_lang = $_REQUEST['source_lang'];
            if (!empty($source_lang)) {
                array_push($arr2, 2);
            }
        } else {
            $source_lang = "";
        }
        if (isset($_REQUEST['target_lang'])) {
            $target_lang = $_REQUEST['target_lang'];
            if (!empty($target_lang)) {
                array_push($arr2, 3);
            }
        } else {
            $target_lang = "";
        }
        if (isset($_REQUEST['service'])) {
            $service = $_REQUEST['service'];
            if (!empty($service)) {
                array_push($arr2, 4);
            }
        } else {
            $service = "";
        }
        if (isset($_REQUEST['task_type'])) {
            $task_type = $_REQUEST['task_type'];
            if (!empty($task_type)) {
                array_push($arr2, 5);
            }
        } else {
            $task_type = "";
        }
        // print_r($arr2);
        $cond1 = "vendor = '$vendor'";
        $cond2 = "dialect LIKE '%$dialect%'";
        $cond3 = "source_lang = '$source_lang'";
        $cond4 = "target_lang = '$target_lang'";
        $cond5 = "service = '$service'";
        $cond6 = "task_type = '$task_type'";
        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        // print_r($arr4);     
        if ($arr_1_cnt > 0) {
            $data['row'] = $this->db->query(" SELECT s.*,v.brand,v.email,v.contact,v.profile,v.general,v.quality,v.communication,v.commitment FROM `vendor_sheet` AS s LEFT OUTER JOIN vendor AS v on v.id = s.vendor WHERE brand = '$this->brand' AND " . $arr4 . " ORDER BY `v`.`brand` ASC  ")->result();
            //$data['row'] = $this->db->query(" SELECT name,email FROM `vendor` WHERE brand = '3' AND ".$arr4."");

        } else {
            $data['row'] = $this->db->query(" SELECT s.*,v.brand,v.email,v.contact,v.profile,v.general,v.quality,v.communication,v.commitment FROM `vendor_sheet` AS s LEFT OUTER JOIN vendor AS v on v.id = s.vendor WHERE brand = '$this->brand' ORDER BY `v`.`brand` ASC  ")->result();
            //$data['row'] = $this->db->query(" SELECT name,email FROM `vendor` WHERE brand = '3'");
        }

        $this->load->view('admin/exportAllVendors.php', $data);
        //$this->load->view('admin/exportAllVendorsNamesEmails.php',$data);
    }

    public function exportVendorCountPerLanguage()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vendorCountPerLanguage.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['language'] = $this->db->get('languages')->result();
        $this->load->view('vendor/exportVendorCountPerLanguage.php', $data);
    }

    public function exportAllVendorsContacts()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=AllVendors.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['vendor'] = $this->db->get_where('vendor', array('brand' => 11));
        $this->load->view('vendor/exportAllVendors.php', $data);
    }

    public function addVendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 55);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 55);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addVendorSheet.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 55);
        if ($check) {
            $data['vendor'] = $_POST['vendor'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['dialect'] = $_POST['dialect'];
            $data['service'] = $_POST['service'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['rate'] = $_POST['rate'];
            $data['currency'] = $_POST['currency'];
            $subject = $_POST['subject'];
            $data['subject'] = implode(",", $_POST['subject']);
            $data['tools'] = implode(",", $_POST['tools']);
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('vendor_sheet', $data)) {
                $true = "Vendor Data Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vendorSheet");
            } else {
                $error = "Failed To Add Vendor Data ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vendorSheet");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editVendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 82);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 82);
            //body ..
            $data['brand'] = $this->brand;
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->vendor_model->getVendorSheetData($data['id']);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/editVendorSheet.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditVendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 82);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $data['vendor'] = $_POST['vendor'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['dialect'] = $_POST['dialect'];
            $data['service'] = $_POST['service'];
            $data['task_type'] = $_POST['task_type'];
            $data['unit'] = $_POST['unit'];
            $data['rate'] = $_POST['rate'];
            $data['special_rate'] = $_POST['special_rate'];
            $data['currency'] = $_POST['currency'];
            $subject = $_POST['subject'];
            $data['comment'] = $_POST['comment'];

            $this->admin_model->addToLoggerUpdate('vendor_sheet', 82, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vendor_sheet', $data, array('id' => $id))) {
                $true = "Vendor Data Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vendorProfile?t=" . base64_encode($data['vendor']));
            } else {
                $error = "Failed To Edit Vendor Data ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vendorProfile?t=" . base64_encode($data['vendor']));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteVendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->getScreenByPermissionByRole($this->role, 54);
        if ($check->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('vendor_sheet', 54, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vendor_sheet', array('id' => $id))) {
                $true = "Vendor Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."vendor/vendorSheet");
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Vendor Record ...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."vendor/vendorSheet");
                redirect($_SERVER['HTTP_REFERER']);

            }
        } else {
            echo "You have no permission to access this page";
        }
    }

   public function tickets()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 56);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 56);
            //body ..
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['request_type'])) {
                    $request_type = $_REQUEST['request_type'];
                    if (!empty($request_type)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $request_type = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $id = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $created_by = "";
                }
                if (isset($_REQUEST['software'])) {
                    $software = $_REQUEST['software'];
                    if (!empty($software)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $software = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 8);
                    }
                } else {
                    $date_from = "";
                }
                // print_r($arr2);
                $cond1 = "request_type = '$request_type'";
                $cond2 = "service = '$service'";
                $cond3 = "status = '$status'";
                $cond4 = "id = '$id'";
                $cond5 = "source_lang = '$source_lang'";
                $cond6 = "target_lang = '$target_lang'";
                $cond7 = "created_by = '$created_by'";
                $cond8 = "software = '$software'";
                $cond9 = "created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['ticket'] = $this->vendor_model->viewVmTickets($data['brand'], $arr4);
                } else {
                    $data['ticket'] = $this->vendor_model->viewVmTickets($data['brand']);
                }
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v HAVING brand = '$this->brand' ")->num_rows();
                $config['base_url'] = base_url('vendor/tickets');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 10;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['ticket'] = $this->vendor_model->viewVmTicketsPages($data['brand'], $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/tickets.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportTickets()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Tickets.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $check = $this->admin_model->checkPermission($this->role, 56);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 56);
            //body ..
            $data['brand'] = $this->brand;

            $arr2 = array();
            if (isset($_REQUEST['request_type'])) {
                $request_type = $_REQUEST['request_type'];
                if (!empty($request_type)) {
                    array_push($arr2, 0);
                }
            } else {
                $request_type = "";
            }
            if (isset($_REQUEST['service'])) {
                $service = $_REQUEST['service'];
                if (!empty($service)) {
                    array_push($arr2, 1);
                }
            } else {
                $service = "";
            }
            if (isset($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if (!empty($status)) {
                    array_push($arr2, 2);
                }
            } else {
                $status = "";
            }
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                if (!empty($id)) {
                    array_push($arr2, 3);
                }
            } else {
                $id = "";
            }
            if (isset($_REQUEST['source_lang'])) {
                $source_lang = $_REQUEST['source_lang'];
                if (!empty($source_lang)) {
                    array_push($arr2, 4);
                }
            } else {
                $source_lang = "";
            }
            if (isset($_REQUEST['target_lang'])) {
                $target_lang = $_REQUEST['target_lang'];
                if (!empty($target_lang)) {
                    array_push($arr2, 5);
                }
            } else {
                $target_lang = "";
            }
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 6);
                }
            } else {
                $created_by = "";
            }
            if (isset($_REQUEST['software'])) {
                $software = $_REQUEST['software'];
                if (!empty($software)) {
                    array_push($arr2, 7);
                }
            } else {
                $software = "";
            }
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 8);
                }
            } else {
                $date_from = "";
            }
            // print_r($arr2);
            $cond1 = "request_type = '$request_type'";
            $cond2 = "service = '$service'";
            $cond3 = "status = '$status'";
            $cond4 = "id = '$id'";
            $cond5 = "source_lang = '$source_lang'";
            $cond6 = "target_lang = '$target_lang'";
            $cond7 = "created_by = '$created_by'";
            $cond8 = "software = '$software'";
            $cond9 = "created_at BETWEEN '$date_from' AND '$date_to'";
            $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['ticket'] = $this->vendor_model->viewVmTickets($data['brand'], $arr4);
            } else {
                $data['ticket'] = $this->vendor_model->viewVmTickets($data['brand']);
            }

            // //Pages ..

            $this->load->view('vendor/exportTickets.php', $data);

        } else {
            echo "You have no permission to access this page";
        }



    }

    public function vmTicketView()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 57);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 57);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $this->vendor_model->changeTicketToOpen($data['id'], $this->user);
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            $data['response'] = $this->db->get_where('vm_ticket_response', array('ticket' => $data['id']))->result();
            $data['team_response'] = $this->db->get_where('vm_ticket_team_response', array('ticket' => $data['id']))->result();
            $data['log'] = $this->db->get_where('vm_ticket_time', array('ticket' => $data['id']))->result();
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vmTicketView.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function ticketRespone()
    {

        // $config['file']['upload_path']          = './assets/uploads/tickets/';
        if ($_FILES['file']['size'] != 0) {
            $config['file']['upload_path'] = './assets/uploads/tickets/';
            $config['file']['encrypt_name'] = TRUE;
            $ext = preg_replace("/.*\.([^.]+)$/", "\\1", $_FILES['file']['name']);
            $fileType = $_FILES['file']['type'];
            echo $config['file']['allowed_types'] = $ext . '|' . $fileType;
            $config['file']['max_size'] = 100000000;
            $this->load->library('upload', $config['file'], 'file_upload');
            if (!$this->file_upload->do_upload('file')) {
                $error = $this->file_upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $data_file = $this->file_upload->data();
                $data['file'] = $data_file['file_name'];
            }
        }
        $data['ticket'] = base64_decode($_POST['id']);
        $data['response'] = trim($_POST['comment']);
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");
        $ticket_data = $this->db->get_where('vm_ticket', array('id' => $data['ticket']))->row();
        // if($ticket_data->ticket_from == 1){
        //   $subject =  $this->db->query("SELECT project_name FROM sales_opportunity WHERE id = '".$ticket_data->from_id."'")->row()->project_name;
        // }elseif ($ticket_data->ticket_from == 2) {
        //   $subject =  $this->db->query("SELECT name FROM project WHERE id = '".$ticket_data->from_id."'")->row()->name; 
        //  }
        if (strlen(trim($data['response'])) > 0) {
            if ($this->db->insert('vm_ticket_response', $data)) {
                $this->vendor_model->TicketReplyMail($ticket_data->created_by, $data['ticket'], $this->brand, $data['response'], $ticket_data->ticket_subject);
                $true = "Ticket Reply Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Ticket Reply ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Failed To Add Ticket Reply ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function ticketVMTeamRespone()
    {
        $data['ticket'] = base64_decode($_POST['id']);
        $data['response'] = trim($_POST['comment']);
        $data['created_by'] = $this->user;
        $data['created_at'] = date("Y-m-d H:i:s");

        if (strlen(trim($data['response'])) > 0) {
            if ($this->db->insert('vm_ticket_team_response', $data)) {
                $true = "Ticket Reply Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Ticket Reply ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Failed To Add VMTeam Ticket Reply ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function rejectTicekt()
    {
        $id = base64_decode($_GET['t']);
        $comment = $_POST['comment'];
        $ticket_data = $this->db->get_where('vm_ticket', array('id' => $id))->row();
        $this->admin_model->addToLoggerUpdate('vm_ticket', 56, 'id', $id, 0, 0, $this->user);
        if ($this->db->update('vm_ticket', array('status' => 0), array('id' => $id))) {
            $this->vendor_model->sendTicketMail($ticket_data->created_by, $id, "Rejected Request" . $ticket_data->ticket_subject, "</p>VM Team rejected your ticket.</p>Reason: " . $comment . " <p>", $this->brand);
            $true = "Ticket Rejected Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed Reject ticket, please try again! ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function changeTicketStatus()
    {
        error_reporting(0);
        $ticket = base64_decode($_POST['id']);
        $status = $_POST['status'];
        $new_res = $_POST['new_res'];
        $ticket_data = $this->db->get_where('vm_ticket', array('id' => $ticket))->row();
        // if($ticket_data->ticket_from == 1){
        //    $subject =  $this->db->query("SELECT project_name FROM sales_opportunity WHERE id = '".$ticket_data->from_id."'")->row()->project_name;
        // }elseif ($ticket_data->ticket_from == 2) {
        //   $subject =  $this->db->query("SELECT name FROM project WHERE id = '".$ticket_data->from_id."'")->row()->name; 
        // }
        if ($ticket_data->request_type == 5) {
            $ticketResource['ticket'] = $ticket;
            $ticketResource['created_by'] = $this->user;
            if ($_FILES['file']['size'] != 0) {
                //$config['file_'.$i]['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/tickets/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $ticketResource['file'] = $data_file['file_name'];
                }
                $this->db->insert('vm_ticket_resource', $ticketResource);
            }


        }
        if ($ticket_data->request_type == 4) {
            $ticketResource['ticket'] = $ticket;
            $ticketResource['number_of_resource'] = $_POST['number_of_resource'];

            if (isset($_POST['resource_row'])) {
                $this->db->update('vm_ticket_resource', $ticketResource, array('id' => $_POST['resource_row']));

            } else {
                $this->db->insert('vm_ticket_resource', $ticketResource);
            }
        }

        if ($status == 3) {
            if ($this->db->update('vm_ticket', array('status' => 5), array('id' => $ticket))) {
                $this->vendor_model->addTicketTimeStatus($ticket, $this->user, 5);
                $this->vendor_model->sendTicketMail($ticket_data->created_by, $ticket, "Partly Closed Request for project : " . $ticket_data->ticket_subject, "VM Team send a request to close your ticket please send your action", $this->brand);
                $true = "Ticket Status Changed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Change Ticket Status ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } elseif ($status == 4) {
            if ($this->db->update('vm_ticket', array('status' => $status), array('id' => $ticket))) {
                $this->vendor_model->addTicketTimeStatus($ticket, $this->user, $status);
                $this->vendor_model->sendTicketMail($ticket_data->created_by, $ticket, "Ticket Closed", "Your Ticket Closed at " . date("Y-m-d H:i:s") . "-" . $ticket_data->ticket_subject, $this->brand);
                $true = "Ticket Status Changed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Change Ticket Status ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } elseif ($status == 2 || $status == 5) {
            $true = "Ticket Updated Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function addTicketResource()
    {
        $check = $this->admin_model->checkPermission($this->role, 79);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 79);
            //body ..
            $id = $_GET['t'];
            $data['brand'] = $this->brand;
            $data['ticket'] = $id;
            $data['resources'] = $this->db->get_where('vm_ticket_resource', array('ticket' => base64_decode($id)))->num_rows();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addTicketResource.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddticketResource()
    {
        error_reporting(0);
        $check = $this->admin_model->checkPermission($this->role, 79);
        if ($check) {
            $ticket = base64_decode($_POST['id']);
            $loop = $this->db->get_where('vm_ticket_resource', array('ticket' => base64_decode($ticket)))->num_rows();
            for ($i = $loop + 1; $i < $_POST['new_res']; $i++) {
                if ($_POST['ticket_response_type_' . $i] == 1) {
                    // echo "New"."</br>";
                    $vendor['ticket_id'] = $ticket;
                    $vendor['i'] = $i;
                    $vendor['name'] = $_POST['name_' . $i];
                    $vendor['email'] = $_POST['email_' . $i];
                    $vendor['contact'] = $_POST['contact_' . $i];
                    $vendor['phone_number'] = $_POST['phone_number_' . $i];
                    $vendor['country'] = $_POST['country_' . $i];
                    $vendor['mother_tongue'] = $_POST['mother_tongue_' . $i];
                    $vendor['profile'] = $_POST['profile_' . $i];
                    $vendor['subject'] = implode(",", $_POST['subject_' . $i]);
                    $vendor['tools'] = implode(",", $_POST['tools_' . $i]);
                    $vendor['color'] = $_POST['color_' . $i];
                    $vendor['brand'] = $this->brand;
                    $vendor['created_by'] = $this->user;
                    $vendor['created_at'] = date("Y-m-d H:i:s");

                    if ($_FILES['file_' . $i]['size'] != 0) {

                        //$config['file_'.$i]['upload_path']          = './assets/uploads/vendors/';
                        $config['file_' . $i]['upload_path'] = './assets/uploads/vendors/';
                        $config['file_' . $i]['encrypt_name'] = TRUE;
                        $config['file_' . $i]['allowed_types'] = 'zip|rar';
                        $config['file_' . $i]['max_size'] = 10000;
                        $config['file_' . $i]['max_width'] = 1024;
                        $config['file_' . $i]['max_height'] = 768;
                        $this->load->library('upload', $config['file_' . $i], 'file_upload');
                        if (!$this->file_upload->do_upload('file_' . $i)) {
                            $error = $this->file_upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "vendor/vmTicketView?t=" . base64_encode($ticket));
                        } else {
                            $data_file = $this->file_upload->data();
                            $vendor['cv'] = $data_file['file_name'];
                        }
                    }

                    if (isset($_POST['row_' . $i]) && isset($_POST['sheet_row_' . $i])) {
                        $this->db->update('vendor', $vendor, array('id' => $_POST['row_' . $i]));
                        $vendorSheet['vendor'] = $_POST['row_' . $i];
                    } else {
                        if (strlen(trim($vendor['name'])) > 0) {
                            $this->db->insert('vendor', $vendor);
                            // vendor password & send email
                            $vendor_id = $this->db->insert_id();
                            if ($this->brand == 1 || $this->brand == 3) {
                                $password = $this->vendor_model->generateVendorPassword();
                                $dataPass['password'] = base64_encode($password);
                                $dataPass['first_login'] = '1';
                                $this->db->update('vendor', $dataPass, array('id' => $vendor_id));
                                $this->vendor_model->SendVendorNewAccountEmailPortal($vendor_id);
                            }
                            //end
                            $vendorSheet['vendor'] = $vendor_id;
                        } else {
                            $vendorSheet['vendor'] = 0;
                        }
                    }

                    $vendorSheet['ticket_id'] = $ticket;
                    $vendorSheet['i'] = $i;
                    $vendorSheet['dialect'] = $_POST['dialect_' . $i];
                    $vendorSheet['source_lang'] = $_POST['source_lang_' . $i];
                    $vendorSheet['target_lang'] = $_POST['target_lang_' . $i];
                    $vendorSheet['service'] = $_POST['service_' . $i];
                    $vendorSheet['task_type'] = $_POST['task_type_' . $i];
                    $vendorSheet['unit'] = $_POST['unit_' . $i];
                    $vendorSheet['rate'] = $_POST['rate_' . $i];
                    $vendorSheet['special_rate'] = $_POST['special_rate_' . $i];
                    $vendorSheet['currency'] = $_POST['currency_' . $i];
                    $vendorSheet['created_by'] = $this->user;
                    $vendorSheet['created_at'] = date("Y-m-d H:i:s");

                    $ticketResource['ticket'] = $ticket;
                    $ticketResource['type'] = $_POST['ticket_response_type_' . $i];
                    $ticketResource['i'] = $i;
                    $ticketResource['vendor'] = $vendorSheet['vendor'];
                    $ticketResource['created_by'] = $this->user;

                    if (isset($_POST['resource_row_' . $i])) {
                        $this->db->update('vm_ticket_resource', $ticketResource, array('id' => $_POST['resource_row_' . $i]));

                    } else {
                        $this->db->insert('vm_ticket_resource', $ticketResource);
                        $vendorSheet['i'] = $this->db->insert_id();
                        $this->db->update('vendor', array('i' => $vendorSheet['i']), array('id' => $vendorSheet['vendor']));
                    }

                    if (isset($_POST['row_' . $i]) && isset($_POST['sheet_row_' . $i])) {
                        $this->db->update('vendor_sheet', $vendorSheet, array('id' => $_POST['sheet_row_' . $i]));
                    } else {
                        if ($vendorSheet['vendor'] != 0) {
                            $this->db->insert('vendor_sheet', $vendorSheet);
                        }
                    }

                } elseif ($_POST['ticket_response_type_' . $i] == 2) {
                    // echo "Select Existing Resource"."</br>";
                    $ticketResource['ticket'] = $ticket;
                    $ticketResource['type'] = $_POST['ticket_response_type_' . $i];
                    $ticketResource['i'] = $i;
                    $ticketResource['vendor'] = $_POST['vendor_' . $i];
                    $ticketResource['created_by'] = $this->user;
                    if (isset($_POST['resource_row_' . $i])) {
                        $this->db->update('vm_ticket_resource', $ticketResource, array('id' => $_POST['resource_row_' . $i]));

                    } else {
                        $this->db->insert('vm_ticket_resource', $ticketResource);
                    }
                } elseif ($_POST['ticket_response_type_' . $i] == 3) {
                    echo "Select Existing Resource & Adding New Pair" . "</br>";
                    $vendorSheet['vendor'] = $_POST['vendor_' . $i];
                    $vendorSheet['ticket_id'] = $ticket;
                    $vendorSheet['i'] = $i;
                    $vendorSheet['dialect'] = $_POST['dialect_' . $i];
                    $vendorSheet['source_lang'] = $_POST['source_lang_' . $i];
                    $vendorSheet['target_lang'] = $_POST['target_lang_' . $i];
                    $vendorSheet['service'] = $_POST['service_' . $i];
                    $vendorSheet['unit'] = $_POST['unit_' . $i];
                    $vendorSheet['task_type'] = $_POST['task_type_' . $i];
                    $vendorSheet['rate'] = $_POST['rate_' . $i];
                    $vendorSheet['special_rate'] = $_POST['special_rate_' . $i];
                    $vendorSheet['currency'] = $_POST['currency_' . $i];
                    $vendorSheet['created_by'] = $this->user;
                    $vendorSheet['created_at'] = date("Y-m-d H:i:s");

                    $ticketResource['ticket'] = $ticket;
                    $ticketResource['type'] = $_POST['ticket_response_type_' . $i];
                    $ticketResource['i'] = $i;
                    $ticketResource['vendor'] = $_POST['vendor_' . $i];
                    $ticketResource['created_by'] = $this->user;

                    if (isset($_POST['resource_row_' . $i])) {
                        $this->db->update('vm_ticket_resource', $ticketResource, array('id' => $_POST['resource_row_' . $i]));

                    } else {
                        $this->db->insert('vm_ticket_resource', $ticketResource);
                        $vendorSheet['i'] = $this->db->insert_id();
                    }

                    if (isset($_POST['sheet_row_' . $i])) {
                        $this->db->update('vendor_sheet', $vendorSheet, array('id' => $_POST['sheet_row_' . $i]));
                    } else {
                        if ($vendorSheet['vendor'] != 0) {
                            $this->db->insert('vendor_sheet', $vendorSheet);
                        }
                    }
                }
            }
            $ticket_data = $this->db->get_where('vm_ticket', array('id' => $ticket))->row();
            $this->vendor_model->sendTicketMail($ticket_data->created_by, $ticket, "New Resource" . $ticket_data->ticket_subject, "Your Ticket has been updated with a new resource , please check. Date : " . date("Y-m-d H:i:s"), $this->brand);
            $true = "Ticket Updated Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "vendor/vmTicketView?t=" . base64_encode($ticket));
        } else {
            echo "You have no permission to access this page";
        }
    }

    /*public function editTicketResource(){
        $check = $this->admin_model->checkPermission($this->role,79);
        if($check){
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role,79);
            //body ..
            $data['brand'] = $this->brand;
            $data['id'] = base64_decode($_GET['t']);
            $data['ticket'] = base64_decode($_GET['d']);
            $data['ticket_resources'] = $this->db->get_where('vm_ticket_resource',array('id'=>$data['id']))->row();
            $data['resource'] = $this->db->get_where('vendor',array('id'=>$data['ticket_resources']->vendor))->row();
            $data['sheet'] = $this->db->get_where('vendor_sheet',array('i'=>$data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php',$data);
            $this->load->view('vendor/editTicketResource.php');
            $this->load->view('includes/footer.php'); 
            // }
        }else{
            echo "You have no permission to access this page";
        }
    }

    public function doEditticketResource(){
        $check = $this->admin_model->checkPermission($this->role,79);
        if($check){
            $ticket = $_POST['ticket'];
            $id = $_POST['id'];
            if($_POST['ticket_response_type'] == 1){
                        // echo "New"."</br>";
                        $vendor['ticket_id'] = $ticket; 
                        $vendor['name'] = $_POST['name'];
                        $vendor['email'] = $_POST['email'];
                        $vendor['contact'] = $_POST['contact'];
                        $vendor['country'] = $_POST['country'];
                        $vendor['mother_tongue'] = $_POST['mother_tongue'];
                        $vendor['profile'] = $_POST['profile'];
                        $vendor['color'] = $_POST['color'];
                        $vendor['created_at'] = date("Y-m-d H:i:s");
                        $vendor['subject'] = implode(",", $_POST['subject']);
                        $vendor['created_by'] = $this->user;

                        if ($_FILES['file']['size'] != 0)
                        {

                            //$config['file']['upload_path']          = './assets/uploads/vendors/';
                            $config['file']['upload_path']          = './assets/uploads/vendors/';
                            $config['file']['encrypt_name']         = TRUE;
                            $config['file']['allowed_types']  = 'zip|rar';
                            $config['file']['max_size']             = 10000;
                            $config['file']['max_width']            = 1024;
                            $config['file']['max_height']           = 768;
                            $this->load->library('upload', $config['file'], 'file_upload');
                            if ( ! $this->file_upload->do_upload('file'))
                            {
                                $error= $this->file_upload->display_errors();   
                                $this->session->set_flashdata('error', $error);
                                redirect(base_url()."vendor/vmTicketView?t=".base64_encode($ticket));             
                            }
                            else
                            {
                                $data_file = $this->file_upload->data();
                                $vendor['cv'] = $data_file['file_name'];
                            }
                        }                

                        $this->db->update('vendor',$vendor,array('i'=>$id));                    

                        $vendorSheet['ticket_id'] = $ticket;
                        $vendorSheet['dialect'] = $_POST['dialect'];
                        $vendorSheet['source_lang'] = $_POST['source_lang'];
                        $vendorSheet['target_lang'] = $_POST['target_lang'];
                        $vendorSheet['service'] = $_POST['service'];
                        $vendorSheet['task_type'] = $_POST['task_type'];
                        $vendorSheet['unit'] = $_POST['unit'];
                        $vendorSheet['rate'] = $_POST['rate'];
                        $vendorSheet['currency'] = $_POST['currency'];
                        $vendorSheet['created_by'] = $this->user;
                        $vendorSheet['tools'] = implode(",", $_POST['tools']);

                        $ticketResource['ticket'] = $ticket;
                        $ticketResource['i'] = $i;
                        $ticketResource['created_by'] = $this->user;

                        $this->db->update('vm_ticket_resource',$ticketResource,array('id'=>$id));

                        $this->db->update('vendor_sheet',$vendorSheet,array('i'=>$id));
                    

                    }elseif($_POST['ticket_response_type'] == 2){
                        echo "Select Existing Resource"."</br>";
                        $ticketResource['vendor'] = $_POST['vendor'];
                        $ticketResource['created_by'] = $this->user;
                        $this->db->update('vm_ticket_resource',$ticketResource,array('id'=>$id));
                    }elseif($_POST['ticket_response_type'] == 3){
                        echo "Select Existing Resource & Adding New Pair"."</br>";
                        $vendorSheet['vendor'] = $_POST['vendor'];
                        $vendorSheet['ticket_id'] = $ticket;
                        $vendorSheet['dialect'] = $_POST['dialect'];
                        $vendorSheet['source_lang'] = $_POST['source_lang'];
                        $vendorSheet['target_lang'] = $_POST['target_lang'];
                        $vendorSheet['service'] = $_POST['service'];
                        $vendorSheet['unit'] = $_POST['unit'];
                        $vendorSheet['task_type'] = $_POST['task_type'];
                        $vendorSheet['rate'] = $_POST['rate'];
                        $vendorSheet['currency'] = $_POST['currency'];
                        $vendorSheet['created_by'] = $this->user;

                        $ticketResource['vendor'] = $_POST['vendor'];
                        $ticketResource['created_by'] = $this->user;

                        $this->db->update('vm_ticket_resource',$ticketResource,array('id'=>$id));                        

                        $this->db->update('vendor_sheet',$vendorSheet,array('i'=>$id));
                    }

                    $true = "Ticket Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url()."vendor/vmTicketView?t=".base64_encode($ticket));
        }else{
            echo "You have no permission to access this page";
        }
    }*/

    public function deleteTicketResource()
    {
        $check = $this->admin_model->checkPermission($this->role, 79);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $ticket = base64_decode($_GET['d']);
            $old = $this->db->get_where('vm_ticket_resource', array('id' => $id))->row();
            $this->admin_model->addToLoggerDelete('vm_ticket_resource', 79, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vm_ticket_resource', array('id' => $id))) {
                $this->db->update('vendor', array('ticket_id' => '0', 'i' => '0'), array('ticket_id' => $old->ticket, 'i' => $old->id));
                $this->db->update('vendor_sheet', array('ticket_id' => '0', 'i' => '0'), array('ticket_id' => $old->ticket, 'i' => $old->id));
                $true = "Recource Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmTicketView?t=" . base64_encode($ticket));
            } else {
                $error = "Failed To Delete Recource ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/vmTicketView?t=" . base64_encode($ticket));
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function confirmCloseTicket()
    {
        $ticket = base64_decode($_POST['id']);
        $accept = $_POST['accept'];
        if ($accept == 1) {
            $status = $this->db->get_where('vm_ticket', array('id' => $ticket))->row()->status;
            $new = $status - 2;
            if ($this->db->update('vm_ticket', array('status' => $new), array('id' => $ticket))) {
                $this->vendor_model->addTicketTimeStatus($ticket, $this->user, $new);
                $this->vendor_model->ticketAcceptanceMail($ticket, $accept);
                $true = "Ticket Status Changed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Change Ticket Status ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else if ($accept == 2) {
            if ($this->db->update('vm_ticket', array('status' => 2), array('id' => $ticket))) {
                $this->vendor_model->addTicketTimeStatus($ticket, $this->user, 2);
                $this->vendor_model->ticketAcceptanceMail($ticket, $accept);
                $true = "Ticket Status Changed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Change Ticket Status ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function getVendorData()
    {
        $id = $_POST['vendor'];
        $source_lang = $_POST['source'];
        $target_lang = $_POST['target'];
        $task_type = $_POST['task_type'];
        $vendor = $this->db->get_where('vendor', array('id' => $id))->row();
        $row = $this->db->get_where('vendor_sheet', array('vendor' => $id, 'task_type' => $task_type, 'source_lang' => $source_lang, 'target_lang' => $target_lang))->result();
        $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                            <thead>
                                <tr>
                                     <th>#</th>
                                     <th>Unit</th>
                                     <th>Rate</th>
                                     <th>Currency</th>
                                     <th>Email</th>
                                     <th>Special Rate</th>
                                </tr>
                            </thead>                            
                            <tbody>';
        $i = 1;
        foreach ($row as $row) {
            if ($i == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            if (isset($row->rate)) {
                $data .= '<tr class="">
                        <input type="text" id="unit_' . $i . '" name="unit_' . $i . '" value="' . $row->unit . '" hidden="">
                        <input type="text" id="currency_' . $i . '" name="currency_' . $i . '" value="' . $row->currency . '" hidden="">
                        <td><input type="radio" name="select" id="select" onclick="calculateVendorCostChecked()" ' . $radio . ' value="' . $i . '"></td>
                        <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                        <td><input onblur="calculateVendorCost(' . $i . ')" type="text" id="rate_' . $i . '" name="rate_' . $i . '" value="' . $row->rate . '"></td>
                        <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                        <td>' . $vendor->email . '</td>
                        <td>' . $row->special_rate . '</td>
                        </tr>';
            }
            $i++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getVendorDataLEFreelancer()
    {
        $id = $_POST['vendor'];
        $vendor = $this->db->get_where('vendor', array('id' => $id))->row();
        $row = $this->db->get_where('vendor_sheet', array('vendor' => $id, 'task_type' => '43'))->result();
        $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                            <thead>
                                <tr>
                                     <th>#</th>
                                     <th>Unit</th>
                                     <th>Rate</th>
                                     <th>Currency</th>
                                     <th>Email</th>
                                     <th>Special Rate</th>
                                </tr>
                            </thead>                            
                            <tbody>';
        $i = 1;
        foreach ($row as $row) {
            if ($i == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            if (isset($row->rate)) {
                $data .= '<tr class="">
                        <input type="text" id="unit_' . $i . '" name="unit_' . $i . '" value="' . $row->unit . '" hidden="">
                        <input type="text" id="currency_' . $i . '" name="currency_' . $i . '" value="' . $row->currency . '" hidden="">
                        <td><input type="radio" name="select" id="select" onclick="calculateVendorCostChecked()" ' . $radio . ' value="' . $i . '"></td>
                        <td>' . $this->admin_model->getUnit($row->unit) . '</td>
                        <td><input onblur="calculateVendorCost(' . $i . ')" type="text" id="rate_' . $i . '" name="rate_' . $i . '" value="' . $row->rate . '"></td>
                        <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                        <td>' . $vendor->email . '</td>
                        <td>' . $row->special_rate . '</td>
                        </tr>';
            }
            $i++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getVendorByTask($flag = 0)
    {
        $brand = $this->brand;
        $task_type = $_POST['task_type'];
        $service = $_POST['service'];
        $source = $_POST['source'];
        $target = $_POST['target'];

        $vendor = $this->db->query(" SELECT DISTINCT v.id,v.name FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON s.vendor = v.id WHERE v.brand = '$brand' AND s.source_lang = '$source' AND s.target_lang = '$target' AND s.service = '$service' AND task_type = '$task_type' AND v.status = '0' ORDER BY v.name ASC ")->result();

        $data = "<option disabled='disabled' selected=''></option>";
        if ($flag == 1)
            $data .= '<option value="all"> Send To All Vendors</option>';
        foreach ($vendor as $vendor) {

            $data .= "<option value='" . $vendor->id . "'>" . $vendor->name . "</option>";
        }
        echo $data;
    }

    public function vendorProfile()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 79);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 79);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['vendor'] = $this->vendor_model->getVendorData($data['id']);
            $data['vendorSkills'] = $this->db->get_where('vendor_skills', array('vendor_id' => $data['id']))->row();
            $data['vendorSheet'] = $this->vendor_model->getVendorSheetByVendor($data['id']);
            $data['feedback'] = $this->db->get_where('task_feedback', array('vendor_id' => $data['id']))->num_rows();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vendorProfile.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function salesVendorSheet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 86);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 86);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $data['rate'] = '';
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['vendor'])) {
                    $vendor = $_REQUEST['vendor'];
                    if (!empty($vendor)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $vendor = "";
                }
                if (isset($_REQUEST['dialect'])) {
                    $dialect = $_REQUEST['dialect'];
                    if (!empty($dialect)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $dialect = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['country'])) {
                    $country = $_REQUEST['country'];
                    if (!empty($country)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $country = "";
                }
                if (isset($_REQUEST['unit'])) {
                    $unit = $_REQUEST['unit'];
                    if (!empty($unit)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $unit = "";
                }
                if (isset($_REQUEST['rate'])) {
                    $rate = $_REQUEST['rate'];
                    if (!empty($rate)) {
                        array_push($arr2, 8);
                    }
                } else {
                    $rate = "";
                }
                if (isset($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                    if (!empty($subject)) {
                        array_push($arr2, 9);
                    }
                } else {
                    $subject = "";
                }
                if (isset($_REQUEST['tools'])) {
                    $tools = $_REQUEST['tools'];
                    if (!empty($tools)) {
                        array_push($arr2, 10);
                    }
                } else {
                    $tools = "";
                }
                // print_r($arr2);
                $cond1 = "vendor = '$vendor'";
                $cond2 = "dialect LIKE '%$dialect%'";
                $cond3 = "source_lang = '$source_lang'";
                $cond4 = "target_lang = '$target_lang'";
                $cond5 = "service = '$service'";
                $cond6 = "task_type = '$task_type'";
                $cond7 = "r.country = '$country'";
                $cond8 = "unit = '$unit'";
                $cond9 = "rate <= '$rate'";
                $cond10 = "(r.subject = '$subject' OR r.subject LIKE '$subject,%' OR r.subject LIKE '%,$subject' OR r.subject LIKE '%,$subject,%')";
                $cond11 = "(r.tools = '$tools' OR r.tools LIKE '$tools,%' OR r.tools LIKE '%,$tools' OR r.tools LIKE '%,$tools,%')";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9, $cond10, $cond11);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vendor'] = $this->vendor_model->viewVmSheet($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['vendor'] = $this->vendor_model->viewVmSheetPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->viewVmSheet($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/salesVendorSheet');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);
                $rate = '';
                $data['vendor'] = $this->vendor_model->viewVmSheetPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }
            $data['rate'] = $rate;
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/salesVendorSheet.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getVendorInfo()
    {
        $id = $_POST['vendor'];
        echo $this->vendor_model->getVendorInfo($id);
    }

    public function vmActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 96);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 96);
            //body ..
            $data['brand'] = $this->brand;
            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 0);
                    }
                } else {
                    $date_from = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "v.created_at BETWEEN '$date_from' AND '$date_to'";
                $cond2 = "t.created_by = '$created_by'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    //$permission,$brand,$user,$filter=1)
                    $data['ticket'] = $this->vendor_model->viewVmTicketsActivity($data['permission'], $data['brand'], $this->user, $arr4);
                } else {
                    $data['ticket'] = $this->vendor_model->viewVmTicketsActivity($data['permission'], $data['brand'], $this->user);
                }
            } else {
                $data['ticket'] = "";
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/vmActivity.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportVmActivity()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vmAcitvitySheet.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 96);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 96);
            //body ..
            $data['brand'] = $this->brand;
            $arr2 = array();
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                    array_push($arr2, 0);
                }
            } else {
                $date_from = "";
            }
            if (isset($_REQUEST['created_by'])) {
                $created_by = $_REQUEST['created_by'];
                if (!empty($created_by)) {
                    array_push($arr2, 1);
                }
            } else {
                $created_by = "";
            }
            // print_r($arr2);
            $cond1 = "v.created_at BETWEEN '$date_from' AND '$date_to'";
            $cond2 = "t.created_by = '$created_by'";
            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                //$permission,$brand,$user,$filter=1)
                $data['ticket'] = $this->vendor_model->viewVmTicketsActivity($data['permission'], $data['brand'], $this->user, $arr4);
            } else {
                $data['ticket'] = $this->vendor_model->viewVmTicketsActivity($data['permission'], $data['brand'], $this->user);
            }
            //Pages ..
            $this->load->view('vendor/exportVmActivity.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function uploadCV()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 101);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 101);
            //body ..
            $data['user'] = $this->user;

            if (isset($_POST['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['field'])) {
                    $field = implode(",", $_REQUEST['field']);
                    ;
                    if (!empty($field)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $field = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "source_lang = '$source_lang'";
                $cond2 = "target_lang = '$target_lang'";
                $cond3 = "field IN (" . $field . ")";
                $cond4 = "created_by = '$created_by'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['cv'] = $this->vendor_model->AllVendorsCV($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['cv'] = $this->vendor_model->AllVendorsCVPages($data['permission'], $this->user, $this->brand, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->AllVendorsCV($data['permission'], $this->user, $this->brand, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/uploadCV');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['cv'] = $this->vendor_model->AllVendorsCVPages($data['permission'], $this->user, $this->brand, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/uploadCV.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addCV()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 101);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addCV.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCV()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 101);
        if ($permission->add == 1) {
            // $config['file']['upload_path']          = './assets/uploads/vendorCV/';
            $config['upload_path'] = './assets/uploads/vendorCV/';
            $config['allowed_types'] = 'png|image/png|zip|rar|xlsx|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|docx|application/vnd.openxmlformats-officedocument.wordprocessingml.document|pdf|application/pdf';
            $config['max_size'] = 1000000000000;

            $files = $_FILES;
            $count = count($_FILES['file']['name']);

            for ($i = 0; $i < $count; $i++) {


                $_FILES['file']['name'] = $files['file']['name'][$i];
                $_FILES['file']['type'] = $files['file']['type'][$i];
                $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
                $_FILES['file']['error'] = $files['file']['error'][$i];
                $_FILES['file']['size'] = $files['file']['size'][$i];

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $upload_data = $this->upload->data();
                    echo $data['file'] = $upload_data['file_name'];
                }

                $data['brand'] = $this->brand;
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['source_lang'] = $_POST['source_lang'];
                $data['target_lang'] = $_POST['target_lang'];
                $data['dialect'] = $_POST['dialect'];
                $data['field'] = implode(",", $_POST['fields']);
                $data['comment'] = $_POST['comment'];
                if ($this->db->insert('vendor_cv', $data)) {
                    $true = "CV Uploaded Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    // redirect(base_url()."vendor/uploadCV");
                } else {
                    $error = "Failed To Upload CV  ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "vendor/uploadCV");
                }
            }
            redirect(base_url() . "vendor/uploadCV");
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCV()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 101);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('vendor_cv', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/editCV.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditCV()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 101);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendorCV/';
                $config['file']['upload_path'] = './assets/uploads/vendorCV/';
                $config['file']['file_name'] = $_FILES['file']['name'];
                $config['file']['allowed_types'] = 'png|image/png|zip|rar|xlsx|application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|docx|application/vnd.openxmlformats-officedocument.wordprocessingml.document|pdf|application/pdf';
                $config['file']['max_size'] = 1000000000;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "vendor/uploadCV");
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['dialect'] = $_POST['dialect'];
            $data['field'] = implode(",", $_POST['fields']);
            $data['comment'] = $_POST['comment'];
            $this->admin_model->addToLoggerUpdate('vendor_cv', 101, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vendor_cv', $data, array('id' => $id))) {
                $true = "Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/uploadCV");
            } else {
                $error = "Failed To Update ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/uploadCV");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCV()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 101);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('vendor_cv', 101, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vendor_cv', array('id' => $id))) {
                $true = "Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/uploadCV");
            } else {
                $error = "Failed To Delete ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/uploadCV");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getDialect()
    {
        $language = $_POST['language'];
        $data = "<option disabled='disabled' value='' selected=''>-- Select Dialect --</option>";
        $data .= $this->admin_model->selectDialect(0, $language);
        echo $data;
    }


    public function validateEmail()
    {
        $email = $_POST['email'];
        echo $data = $this->vendor_model->validateEmail($email, $this->brand);
    }
    public function validateEmailEdit()
    {
        $email = $_POST['email'];
        $id = $_POST['id'];
        echo $data = $this->vendor_model->validateEmailEdit($email, $id, $this->brand);
    }

    public function salesVmTickets()
    {
        ini_set('memory_limit', '-1');
        //Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 154);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 154);
            //body ..
            $data['user'] = $this->user;
            if (isset($_REQUEST['created_by']) && !empty($_REQUEST['created_by'])) {
                $data['created_by'] = $filter_created_by = $_REQUEST['created_by'];
                $data['ticket'] = $this->vendor_model->viewVmTicketWithoutOpp($data['permission'], $this->brand, $this->user, $data, $filter_created_by);

            } else {
                $data['ticket'] = $this->vendor_model->viewVmTicketWithoutOpp($data['permission'], $this->brand, $this->user, $data);
            }
            // $data['ticket'] = $this->vendor_model->viewVmTicketWithoutOpp($data['permission'],$this->brand,$this->user,$data);
            // Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/salesVmTickets.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function addSalesVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 154);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 154);
            //body ..
            $data['user'] = $this->user;

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/addSalesVmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddSalesVmTicket()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 154);
        if ($permission->add == 1) {
            $data['from_id'] = 0;
            $data['request_type'] = $_POST['request_type'];
            if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                $data['number_of_resource'] = $_POST['number_of_resource'];
            } else {
                $data['number_of_resource'] = 0;
            }
            $subject = $_POST['ticket_subject'];
            $data['task_type'] = $_POST['task_type'];
            $data['service'] = $_POST['service'];
            $data['rate'] = $_POST['rate'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['currency'] = $_POST['currency'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['due_date'] = $_POST['delivery_date'];
            $data['subject'] = $_POST['subject'];
            $data['ticket_subject'] = $_POST['ticket_subject'];
            $data['software'] = $_POST['software'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['ticket_from'] = 3;
            $data['status'] = 1;

            if ($_FILES['file']['size'] != 0) {
                //$config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/tickets/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['file'] = $data_file['file_name'];
                }
            }

            if ($this->db->insert('vm_ticket', $data)) {
                $ticketNumber = $this->db->insert_id();
                $this->vendor_model->sendNewTicketEmail($this->user, $ticketNumber, $this->brand, $subject, 0);
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/salesVmTickets");
            } else {
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/salesVmTickets");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editSalesVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 154);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 154);
            //body ..
            $data['user'] = $this->user;
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/editSalesVmTicket.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditSalesVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 154);
        if ($check) {
            $from_id = 0;
            $id = base64_decode($_POST['id']);
            $row_created_date = $this->db->get_where('vm_ticket', array('id' => $id))->row()->created_at;

            if ($row_created_date > $_POST['start_date'] || $row_created_date > $_POST['delivery_date']) {
                $error = "Error , Please Check Start Date & Delivery Date ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
            if ($_POST['start_date'] > $_POST['delivery_date']) {
                $error = "Error , Please Check Delivery Date must be >= Start Date ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }

            $data['request_type'] = $_POST['request_type'];
            if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                $data['number_of_resource'] = $_POST['number_of_resource'];
            } else {
                $data['number_of_resource'] = 0;
            }
            $data['task_type'] = $_POST['task_type'];
            $data['service'] = $_POST['service'];
            $data['rate'] = $_POST['rate'];
            $data['count'] = $_POST['count'];
            $data['unit'] = $_POST['unit'];
            $data['currency'] = $_POST['currency'];
            $data['source_lang'] = $_POST['source_lang'];
            $data['target_lang'] = $_POST['target_lang'];
            $data['start_date'] = $_POST['start_date'];
            $data['delivery_date'] = $_POST['delivery_date'];
            $data['due_date'] = $_POST['delivery_date'];
            $data['subject'] = $_POST['subject'];
            $data['ticket_subject'] = $_POST['ticket_subject'];
            $data['software'] = $_POST['software'];
            $data['comment'] = $_POST['comment'];

            $this->admin_model->addToLoggerUpdate('vm_ticket', 154, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vm_ticket', $data, array('id' => $id))) {
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/salesVmTickets");
            } else {
                $error = "Failed To Add Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/salesVmTickets");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteSalesVmTicket()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 154);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $this->admin_model->addToLoggerDelete('vm_ticket', 154, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vm_ticket', array('id' => $id))) {
                $true = "Ticket Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/salesVmTickets");
            } else {
                $error = "Failed To Delete Ticket ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/salesVmTickets");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    // tickets with issue
    public function ticketsWithIssue()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 169);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 169);
            //body ..
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['request_type'])) {
                    $request_type = $_REQUEST['request_type'];
                    if (!empty($request_type)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $request_type = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $id = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "request_type = '$request_type'";
                $cond2 = "service = '$service'";
                $cond3 = "status = '$status'";
                $cond4 = "id = '$id'";
                $cond5 = "source_lang = '$source_lang'";
                $cond6 = "target_lang = '$target_lang'";
                $cond7 = "created_by = '$created_by'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['ticket'] = $this->vendor_model->viewVmTicketsWithIssues($this->role, $this->user, $data['brand'], $arr4);
                } else {
                    $data['ticket'] = $this->vendor_model->viewVmTicketsWithIssues($this->role, $this->user, $data['brand']);
                }
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v HAVING brand = '$this->brand' ")->num_rows();
                $config['base_url'] = base_url('vendor/ticketsWithIssue');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 10;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['ticket'] = $this->vendor_model->viewVmTicketsWithIssuesPages($this->role, $this->user, $data['brand'], $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('vendor/ticketsWithIssue.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    //

    //vendor ticket issue 
    public function addIssueToVendorTicket()
    {

        $data['issue'] = $_POST['issue'];
        $data['issue_by'] = $this->user;
        $data['issue_status'] = 1;
        if ($this->db->update('vm_ticket', $data, array('id' => $_POST['ticket_id']))) {
            $true = "Your Issue Added Successfully";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To add ticket issue ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    ///

    public function sendCampaignEmail()
    {
        //if($this->role == 1){

        // $config = Array(
        //'protocol' => 'smtp',
        //'smtp_host' => 'mail.thetranslationgate.com',
        //'smtp_port' => 465,
        //'smtp_user' => 'falaqsystem@thetranslationgate.com',
        //'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
        //'charset'=>'utf-8',
        //'validate'=>TRUE,
        //'wordwrap'=> TRUE,

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
            'smtp_port' => 25,
            'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
            //'smtp_user' => 'root',
            'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        // $fileName= base_url().'assets/images/Vendor_Camp_Img.jpg';
        // $this->email->attach($fileName);
        // $cid = $this->email->attachment_cid($fileName);
        // $fileName_2= base_url().'assets/images/Vendor_Camp_Btn.png';
        // $this->email->attach($fileName_2);
        // $cid_2 = $this->email->attachment_cid($fileName_2);	


        $customers = $this->db->get_where('vendor_camp_ttg', array('sent' => 1))->result();
        foreach ($customers as $row) {
            $mailTo = $row->email;
            $subject = "TTG Domains";


            $this->email->from('vm@thetranslationgate.com');
            // $this->email->cc('vm@thetranslationgate.com');
            $this->email->bcc('mohamed.elshehaby@thetranslationgate.com');

            // replace my mail by pm manger it is just for testing
            $this->email->to($mailTo);

            $this->email->subject($subject);

            $msg = '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta name="description" content="">
                    <meta name="author" content="">
                    <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
                    <title>Falaq| Site Manager</title>
                    <style>
                    body {
                        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                        font-size: 18px;
                        line-height: 1.428571429;
                        color: #333;
                    }
                    p {
                        font-size: 18px;
                    }
                    section#unseen
                    {
                        overflow: scroll;
                    }
                    </style>
                    <!--Core js-->
                </head>
                <body>
                	<p>Dear ' . $row->name . ',</p>

					<p>Hope you’re doing well,</p>

					<p>This is to notify you that our E-mails domain are <b>@thetranslationgate.com</b> & <b>@thetranslationgate.net</b> so please exclude any other domains, and DON’T cooperate with them as they’re NOT belong to us.</p>

					<p>Thanks for your kind understanding!</p>

                </body>
                </html>';
            echo $msg;
            $this->email->message($msg);
            $this->email->set_header('Reply-To', 'vm@thetranslationgate.com');
            $this->email->set_mailtype('html');
            $this->email->send();
        }

        //}else{
        //echo "You have no permission to access this page";
        //}
    }


    ///test views 

    public function ticketsWithIssue_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 169);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 169);
            //body ..
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['request_type'])) {
                    $request_type = $_REQUEST['request_type'];
                    if (!empty($request_type)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $request_type = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $id = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "request_type = '$request_type'";
                $cond2 = "service = '$service'";
                $cond3 = "status = '$status'";
                $cond4 = "id = '$id'";
                $cond5 = "source_lang = '$source_lang'";
                $cond6 = "target_lang = '$target_lang'";
                $cond7 = "created_by = '$created_by'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['ticket'] = $this->vendor_model->viewVmTicketsWithIssues($this->role, $this->user, $data['brand'], $arr4);
                } else {
                    $data['ticket'] = $this->vendor_model->viewVmTicketsWithIssues($this->role, $this->user, $data['brand']);
                }
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v HAVING brand = '$this->brand' ")->num_rows();
                $config['base_url'] = base_url('vendor/ticketsWithIssue');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 10;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['ticket'] = $this->vendor_model->viewVmTicketsWithIssuesPages($this->role, $this->user, $data['brand'], $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/ticketsWithIssue.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function tickets_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 56);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 56);
            //body ..
            $data['brand'] = $this->brand;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['request_type'])) {
                    $request_type = $_REQUEST['request_type'];
                    if (!empty($request_type)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $request_type = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if (!empty($status)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    if (!empty($id)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $id = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['created_by'])) {
                    $created_by = $_REQUEST['created_by'];
                    if (!empty($created_by)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $created_by = "";
                }
                // print_r($arr2);
                $cond1 = "request_type = '$request_type'";
                $cond2 = "service = '$service'";
                $cond3 = "status = '$status'";
                $cond4 = "id = '$id'";
                $cond5 = "source_lang = '$source_lang'";
                $cond6 = "target_lang = '$target_lang'";
                $cond7 = "created_by = '$created_by'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['ticket'] = $this->vendor_model->viewVmTickets($data['brand'], $arr4);
                } else {
                    $data['ticket'] = $this->vendor_model->viewVmTickets($data['brand']);
                }
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->db->query(" SELECT v.*,(SELECT brand FROM `users` WHERE users.id = v.created_by) AS brand FROM `vm_ticket` AS v HAVING brand = '$this->brand' ")->num_rows();
                $config['base_url'] = base_url('vendor/tickets');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 10;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['ticket'] = $this->vendor_model->viewVmTicketsPages($data['brand'], $limit, $offset);
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/tickets.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function vmTicketView_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 57);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 57);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $this->vendor_model->changeTicketToOpen($data['id'], $this->user);
            $data['row'] = $this->db->get_where('vm_ticket', array('id' => $data['id']))->row();
            $data['response'] = $this->db->get_where('vm_ticket_response', array('ticket' => $data['id']))->result();
            $data['team_response'] = $this->db->get_where('vm_ticket_team_response', array('ticket' => $data['id']))->result();
            $data['log'] = $this->db->get_where('vm_ticket_time', array('ticket' => $data['id']))->result();
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/vmTicketView.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    ///
    public function companies()
    {
        $check = $this->admin_model->checkPermission($this->role, 175);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['region'])) {
                    $region = $_REQUEST['region'];
                    if (!empty($region)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $region = "";
                }
                // print_r($arr2);
                $cond1 = "name LIKE '%$name%'";
                $cond2 = "region = '$region'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['companies'] = $this->vendor_model->AllCompanies($this->brand, $arr4);
                } else {
                    $data['companies'] = $this->vendor_model->AllCompaniesPages($this->brand, 9, 0);
                }
                $data['total_rows'] = $data['companies']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->AllCompanies($this->brand, 1)->num_rows();

                $config['base_url'] = base_url('vendor/companies');
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

                $data['companies'] = $this->vendor_model->AllCompaniesPages($this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/companies.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportCompanies()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=companies.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $check = $this->admin_model->checkPermission($this->role, 175);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
            //body ..
            $data['user'] = $this->user;

            $arr2 = array();
            if (isset($_REQUEST['name'])) {
                $name = $_REQUEST['name'];
                if (!empty($name)) {
                    array_push($arr2, 0);
                }
            } else {
                $name = "";
            }
            if (isset($_REQUEST['region'])) {
                $region = $_REQUEST['region'];
                if (!empty($region)) {
                    array_push($arr2, 1);
                }
            } else {
                $region = "";
            }

            // print_r($arr2);
            $cond1 = "name LIKE '%$name%'";
            $cond2 = "region = '$region'";
            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     

            if ($arr_1_cnt > 0) {
                $data['companies'] = $this->vendor_model->AllCompanies($this->brand, $arr4);
            } else {
                $data['companies'] = $this->vendor_model->AllCompanies($this->brand, 9, 0);
            }

            // //Pages ..

            $this->load->view('vendor/exportCompanies.php', $data);

        } else {
            echo "You have no permission to access this page";
        }



    }

    public function addCompany()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/addCompany.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddCompany()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['country'] = $_POST['country'];
            $data['region'] = $_POST['region'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['brand'] = $this->brand;

            if ($this->db->insert('companies', $data)) {
                $true = "Company Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/companies");
            } else {
                $error = "Failed To Add Company ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/companies");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editCompany()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['companies'] = $this->db->get_where('companies', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/editCompany.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditCompany()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 175);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['country'] = $_POST['country'];
            $data['region'] = $_POST['region'];
            $data['comment'] = $_POST['comment'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['brand'] = $this->brand;
            $this->admin_model->addToLoggerUpdate('companies', 175, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('companies', $data, array('id' => $id))) {
                $true = "Company Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/companies");
            } else {
                $error = "Failed To Edit Company ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/companies");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteCompany($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 175);
        if ($check) {
            $this->admin_model->addToLoggerDelete('companies', 175, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('companies', array('id' => $id))) {
                $true = "Company Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/companies");
            } else {
                $error = "Failed To Delete Company ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "vendor/companies");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    ///////// 
    public function favouriteVendor()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 176);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 176);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    if (!empty($email)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $email = "";
                }
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['contact'])) {
                    $contact = $_REQUEST['contact'];
                    if (!empty($contact)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $contact = "";
                }
                if (isset($_REQUEST['country'])) {
                    $country = $_REQUEST['country'];
                    if (!empty($country)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $country = "";
                }
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $type = "";
                }
                if (isset($_REQUEST['dialect'])) {
                    $dialect = $_REQUEST['dialect'];
                    if (!empty($dialect)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $dialect = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 8);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 9);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['unit'])) {
                    $unit = $_REQUEST['unit'];
                    if (!empty($unit)) {
                        array_push($arr2, 10);
                    }
                } else {
                    $unit = "";
                }
                if (isset($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                    if (!empty($subject)) {
                        array_push($arr2, 11);
                    }
                } else {
                    $subject = "";
                }
                if (isset($_REQUEST['tools'])) {
                    $tools = $_REQUEST['tools'];
                    if (!empty($tools)) {
                        array_push($arr2, 12);
                    }
                } else {
                    $tools = "";
                }
                if (isset($_REQUEST['rate'])) {
                    $rate = $_REQUEST['rate'];
                    if (!empty($rate)) {
                        array_push($arr2, 13);
                    }
                } else {
                    $rate = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 14);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                // print_r($arr2);
                $cond1 = "email LIKE '%$email%'";
                $cond2 = "name LIKE '%$name%'";
                $cond3 = "contact LIKE '%$contact%'";
                $cond4 = "country = '$country'";
                $cond5 = "type = '$type'";
                $cond6 = "dialect LIKE '%$dialect%'";
                $cond7 = "source_lang = '$source_lang'";
                $cond8 = "target_lang = '$target_lang'";
                $cond9 = "service = '$service'";
                $cond10 = "task_type = '$task_type'";
                $cond11 = "unit = '$unit'";
                $cond12 = "(v.subject = '$subject' OR v.subject LIKE '$subject,%' OR v.subject LIKE '%,$subject' OR v.subject LIKE '%,$subject,%')";
                $cond13 = "(v.tools = '$tools' OR v.tools LIKE '$tools,%' OR v.tools LIKE '%,$tools' OR v.tools LIKE '%,$tools,%')";
                $cond14 = "rate = '$rate'";
                $cond15 = "v.created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9, $cond10, $cond11, $cond12, $cond13, $cond14, $cond15);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vendor'] = $this->vendor_model->AllFavouriteVendor($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['vendor'] = $this->vendor_model->AllFavouriteVendorPages($data['permission'], $this->user, 1000, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->AllFavouriteVendor($data['permission'], $this->user, 1000, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/favouriteVendor');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['vendor'] = $this->vendor_model->AllFavouriteVendorPages($data['permission'], $this->user, 1000, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/favouriteVendor.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    /// /

    public function index_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 42);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 42);
            //body ..
            $data['user'] = $this->user;

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    if (!empty($email)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $email = "";
                }
                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                if (isset($_REQUEST['contact'])) {
                    $contact = $_REQUEST['contact'];
                    if (!empty($contact)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $contact = "";
                }
                if (isset($_REQUEST['country'])) {
                    $country = $_REQUEST['country'];
                    if (!empty($country)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $country = "";
                }
                if (isset($_REQUEST['type'])) {
                    $type = $_REQUEST['type'];
                    if (!empty($type)) {
                        array_push($arr2, 4);
                    }
                } else {
                    $type = "";
                }
                if (isset($_REQUEST['dialect'])) {
                    $dialect = $_REQUEST['dialect'];
                    if (!empty($dialect)) {
                        array_push($arr2, 5);
                    }
                } else {
                    $dialect = "";
                }
                if (isset($_REQUEST['source_lang'])) {
                    $source_lang = $_REQUEST['source_lang'];
                    if (!empty($source_lang)) {
                        array_push($arr2, 6);
                    }
                } else {
                    $source_lang = "";
                }
                if (isset($_REQUEST['target_lang'])) {
                    $target_lang = $_REQUEST['target_lang'];
                    if (!empty($target_lang)) {
                        array_push($arr2, 7);
                    }
                } else {
                    $target_lang = "";
                }
                if (isset($_REQUEST['service'])) {
                    $service = $_REQUEST['service'];
                    if (!empty($service)) {
                        array_push($arr2, 8);
                    }
                } else {
                    $service = "";
                }
                if (isset($_REQUEST['task_type'])) {
                    $task_type = $_REQUEST['task_type'];
                    if (!empty($task_type)) {
                        array_push($arr2, 9);
                    }
                } else {
                    $task_type = "";
                }
                if (isset($_REQUEST['unit'])) {
                    $unit = $_REQUEST['unit'];
                    if (!empty($unit)) {
                        array_push($arr2, 10);
                    }
                } else {
                    $unit = "";
                }
                if (isset($_REQUEST['subject'])) {
                    $subject = $_REQUEST['subject'];
                    if (!empty($subject)) {
                        array_push($arr2, 11);
                    }
                } else {
                    $subject = "";
                }
                if (isset($_REQUEST['tools'])) {
                    $tools = $_REQUEST['tools'];
                    if (!empty($tools)) {
                        array_push($arr2, 12);
                    }
                } else {
                    $tools = "";
                }
                if (isset($_REQUEST['rate'])) {
                    $rate = $_REQUEST['rate'];
                    if (!empty($rate)) {
                        array_push($arr2, 13);
                    }
                } else {
                    $rate = "";
                }
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        array_push($arr2, 14);
                    }
                } else {
                    $date_from = "";
                    $date_to = "";
                }
                // print_r($arr2);
                $cond1 = "email LIKE '%$email%'";
                $cond2 = "name LIKE '%$name%'";
                $cond3 = "contact LIKE '%$contact%'";
                $cond4 = "country = '$country'";
                $cond5 = "type = '$type'";
                $cond6 = "dialect LIKE '%$dialect%'";
                $cond7 = "source_lang = '$source_lang'";
                $cond8 = "target_lang = '$target_lang'";
                $cond9 = "service = '$service'";
                $cond10 = "task_type = '$task_type'";
                $cond11 = "unit = '$unit'";
                $cond12 = "(v.subject = '$subject' OR v.subject LIKE '$subject,%' OR v.subject LIKE '%,$subject' OR v.subject LIKE '%,$subject,%')";
                $cond13 = "(v.tools = '$tools' OR v.tools LIKE '$tools,%' OR v.tools LIKE '%,$tools' OR v.tools LIKE '%,$tools,%')";
                $cond14 = "rate = '$rate'";
                $cond15 = "v.created_at BETWEEN '$date_from' AND '$date_to'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7, $cond8, $cond9, $cond10, $cond11, $cond12, $cond13, $cond14, $cond15);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vendor'] = $this->vendor_model->AllVendors($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, 9, 0);
                }
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->vendor_model->AllVendors($data['permission'], $this->user, 1000, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('vendor/index');
                $config['uri_segment'] = 3;
                $config['display_pages'] = TRUE;
                $config['per_page'] = $limit;
                $config['total_rows'] = $count;
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = "</ul>";
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='#'>";
                $config['cur_tag_close'] = "<span class='sr-only'(current)></span></a></li>";
                $config['next_tag_open'] = "<li><span aria-hidden='true'>";
                $config['next_tagl_close'] = "</span></li>";
                $config['prev_tag_open'] = "<li><span aria-hidden='true'>";
                $config['prev_tagl_close'] = "</span></li>";
                $config['first_tag_open'] = "<li>";
                $config['first_tagl_close'] = "</li>";
                $config['last_tag_open'] = "<li>";
                $config['last_tagl_close'] = "</li>";
                $config['next_link'] = '»';
                $config['prev_link'] = '«';
                $config['num_links'] = 5;
                $config['show_count'] = TRUE;
                $this->pagination->initialize($config);

                $data['vendor'] = $this->vendor_model->AllVendorsPages($data['permission'], $this->user, 1000, $limit, $offset);
            }

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/vendors.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addToFavouriteVendor()
    {
        // Check Permission ..

        $id = base64_decode($_GET['t']);
        $data['favourite'] = $_GET['f'];
        // $id = $_POST['id'];
        // $favourite = $_POST['favourite'];
        // $data['favourite'] = $favourite ;
        if ($this->db->update('vendor', $data, array('id' => $id))) {

            $true = "Vendor Updated Successfully ...";
            $this->session->set_flashdata('true', $true);
            //redirect(base_url()."vendor/");
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $error = "Failed Updated Vendor  ...";
            $this->session->set_flashdata('error', $error);
            // //  // redirect(base_url()."vendor/");
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function addVendor_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 53);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 53);
            //body ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/addVendor.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editVendor_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 80);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 80);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->vendor_model->getVendorData($data['id']);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/editVendor.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    ////

    /*public function vendorGeneratePassword()
    {
        $vendors = $this->db->get_where("vendor",array('brand'=>'5000'))->result();
        foreach($vendors as $vendor){
            $password = $this->vendor_model->generateVendorPassword();
            $data['password']= base64_encode($password);
            $data['first_login']= '1';
            $this->db->update('vendor',$data,array('id'=>$vendor->id));
            echo "vendor name: ".$vendor->name." password: ".$password."</br>";
        }
    }*/

    /*public function SendVendorNewAccountEmail(){
        
        $subject = "Columbuslang || Nexus New Profile";
    
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
        'smtp_port' => 25,
        'smtp_user' => 'AKIARCWPPYXV6IPKFDTQ',
        'smtp_pass' => 'BHAaMA9R+c6HT7kw3CF6PnlfabN+u5C99ZuouuwKm7vF',
        'charset'=>'utf-8',
         'validate'=>TRUE,
        'wordwrap'=> TRUE,
      );
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");

      $vendors = $this->db->get_where('vendor_camp',array('sent'=>50000))->result();
        foreach($vendors as $vendor){
      $this->email->from("vm@columbuslang.com");
      $this->email->to($vendor->email);
      $this->email->subject($subject);
      echo $message = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="'.base_url().'assets/images/favicon.png">
                        <title>Falaq| Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear '.$vendor->name.',</p>
                       <p>We hope this finds you well and in good health. </p>
                       <p>Columbus Lang would like to announce the launch of our new system and the related processes; our new portal is now called “Nexus”. </p>
                       <p>The following steps will introduce the process and how to get our work done through “Nexus”; please see the below steps:</p>
                       <p><b>Step 1 :</b> You need to create a new profile on Nexus.</p>
                       <p><b>Step 2 :</b> You need to create your initial username and password. Your password can be changed later on.</p>
                       <p><b>Step 3 :</b> The profile includes all your data: Job Acquisition, Job Acceptance, Purchase Orders, and the Created Invoices.</p>
                       <p><b>N.B:</b>  Any offline work is not allowed. We only take into consideration the work completed online through Nexus following the process explained above.</p>
                       <p></p>
                       <p><b>Please find below your login credentials for your Nexus account:</b></p>
                       <p>Link: <a href="https://aixnexus.com/columbuslang.com/">https://aixnexus.com/columbuslang.com/</a></p>
                       <p>Email: '.$vendor->email.'</p>
                       <p>Password: '.base64_decode($vendor->password).'</p>
                       <p></p>
                       <p><b>Please make sure to change your password after signing in.</b></p>
                       <p></p>
                       <p>For more information on using the system, kindly <a href="https://aixnexus.com/columbuslang.com/home/training">Click Here</a> </p>
                       <p>For any questions, feedbacks or comments, we are always glad to assist you. Please contact us at help@aixnexus.com </p>
                       <p>We sincerely appreciate your time and efforts.</p>
                    </body>
                    </html>';
                  $this->email->message($message);
                  $this->email->set_header('Reply-To', "vm@columbuslang.com");
                  $this->email->set_mailtype('html');
                  $this->email->send();
        }
    }*/

    public function vendorGeneratePasswordVendor()
    {
        $vendors = $this->db->get_where("vendor", array('id' => '22906'))->result();
        foreach ($vendors as $vendor) {
            $password = $this->vendor_model->generateVendorPassword();
            $data['password'] = base64_encode($password);
            $data['first_login'] = '1';
            $this->db->update('vendor', $data, array('id' => $vendor->id));
            echo "vendor name: " . $vendor->name . " password: " . $password . "</br>";
        }
    }

    public function SendVendorNewAccountEmailVendor()
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
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        //  $vendors = $this->db->get_where('vendor',array('id'=>'4522'))->result();
        $vendors = $this->db->get_where('vendor', array('id' => '9744'))->result();
        foreach ($vendors as $vendor) {
            $vendor_brand = $vendor->brand;
            $data['vendor'] = $vendor;
            $data['nexusLink'] = $nexusLink = $this->projects_model->getNexusLinkByBrand($vendor_brand);

            if ($vendor_brand == 1) {
                $subject = "TTG || Nexus New Profile";
                $vm_email = "vm@thetranslationgate.com";
                $message = $this->load->view("nexus/new_profile_ttg.php", $data, true);
            } elseif ($vendor_brand == 3) {
                $subject = "Europe Localize || Nexus New Profile";
                $vm_email = "vm@europelocalize.com";
                $message = $this->load->view("nexus/new_profile_el.php", $data, true);
            } elseif ($vendor_brand == 11) {
                $subject = "Columbuslang || Nexus New Profile";
                $vm_email = "Vendormanagement@Columbuslang.com";
                $message = $this->load->view("nexus/new_profile_cl.php", $data, true);
            } elseif ($vendor_brand == 2) {
                $subject = "Localizera || Nexus New Profile";
                $vm_email = "vm@localizera.com";
                $message = $this->load->view("nexus/new_profile_loc.php", $data, true);
            }

            $this->email->from($vm_email);
            $this->email->cc("help@aixnexus.com");
            $this->email->to($vendor->email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_header('Reply-To', $vm_email);
            $this->email->set_mailtype('html');
            $this->email->send();
            echo $message;
            // print_r($this->email->print_debugger());
        }
    }

    // get all vendors
    public function getAllVendorsByTask()
    {

        $brand = $this->brand;
        $task_type = $_POST['task_type'];
        $service = $_POST['service'];
        $source = $_POST['source'];
        $target = $_POST['target'];

        $vendors = $this->db->query(" SELECT DISTINCT v.id,v.name,v.email FROM `vendor` AS v LEFT OUTER JOIN vendor_sheet AS s ON s.vendor = v.id WHERE v.brand = '$brand' AND s.source_lang = '$source' AND s.target_lang = '$target' AND s.service = '$service' AND task_type = '$task_type' AND v.status = '0' ORDER BY v.name ASC ")->result();

        $data = '<table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;">
                        <thead>
                            <tr>
                                 <th><input type="checkbox" id="checkAll" checked="true" onChange="checkAllBox()"></th>
                                 <th>Name</th>                                     
                                 <th>Email</th>                                     
                            </tr>
                        </thead>                            
                        <tbody>';
        foreach ($vendors as $vendor) {
            $data .= '<tr class="">'
                . '<td><input type="checkbox" name="vendors[]" id="select" value="' . $vendor->id . '" checked ></td>'
                . '<td>' . $vendor->name . '</td>'
                . '<td>' . $vendor->email . '</td>'
                . '</tr>';
        }
        $data .= '</tbody></table>';
        echo $data;

    }
    //add & remove Vendor from Favourite list
    public function changeVendorFavourite()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 176);
        if ($check) {
            $id = base64_decode($_GET['t']);
            $data['favourite'] = $_GET['f'];
            $this->admin_model->addToLoggerUpdate('vendor', 176, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vendor', $data, array('id' => $id))) {
                $true = "Vendor Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed Updated Vendor  ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // vendor skills
    public function editVendorSkills()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 80);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 80);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('vendor_skills', array('vendor_id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/editVendorSkills.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditVendorSkills()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 80);
        if ($check) {

            $id = base64_decode($_POST['vendor_id']);
            $data['vendor_id'] = $id;
            $data['strong_fields'] = implode(",", $_POST['strong_fields']);
            $data['services'] = implode(",", $_POST['services']);
            $data['capacity'] = $_POST['capacity'];

            $data['voice_over'] = $_POST['voice_over'] ?? null;
            $data['voice_over_sample'] = $_POST['voice_over_sample'] ?? null;
            $data['voice_over_studio'] = $_POST['voice_over_studio'] ?? null;
            $data['trans_creation_sample'] = $_POST['trans_creation_sample'] ?? null;
            $data['dtp'] = $_POST['dtp'] ?? null;
            $data['dtp_tools'] = implode(",", $_POST['dtp_tools']);
            $data['sworn_translation'] = $_POST['sworn_translation'] ?? null;
            $data['other_certificates'] = $_POST['other_certificates'] ?? null;

            // $config['file']['upload_path']          = './assets/uploads/vendors/';
            $config['file']['upload_path'] = './assets/uploads/vendors/';
            $config['file']['encrypt_name'] = TRUE;
            $config['file']['allowed_types'] = 'zip|rar';
            $config['file']['max_size'] = 10000;
            $config['file']['max_width'] = 1024;
            $config['file']['max_height'] = 768;

            if ($_FILES['sworn_translation_certificate']['size'] != 0) {
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('sworn_translation_certificate')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['sworn_translation_certificate'] = $data_file['file_name'];
                }
            }

            if ($_FILES['other_certificates_files']['size'] != 0) {
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('other_certificates_files')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $data['other_certificates_files'] = $data_file['file_name'];
                }
            }

            $true = "Vendor Data Edited Successfully ...";
            $error = "Failed To Edit Vendor Data ...";
            $row = $this->db->get_where('vendor_skills', array('vendor_id' => $id))->num_rows();
            if ($row > 0) {
                $this->admin_model->addToLoggerUpdate('vendor_skills', 80, 'id', $row->id, 0, 0, $this->user);
                if ($this->db->update('vendor_skills', $data, array('vendor_id' => $id))) {
                    $this->session->set_flashdata('true', $true);
                } else {
                    $this->session->set_flashdata('error', $error);
                }
            } else {
                if ($this->db->insert('vendor_skills', $data)) {
                    $this->session->set_flashdata('true', $true);
                } else {
                    $this->session->set_flashdata('error', $error);
                }

            }

            redirect(base_url() . "vendor/vendorProfile?t=" . base64_encode($id));
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewAllVendorFeedback()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 79);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 79);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['vendor'] = $this->vendor_model->getVendorData($data['id']);
            $data['feedback'] = $this->db->get_where('task_feedback', array('vendor_id' => $data['id']))->result();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('vendor_new/allVendorFeedback.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    // new design & one collection page
    public function addSalesVmTicketMultiLang()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 154);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 154);
            //body ..
            $data['user'] = $this->user;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/vm/addSalesVmTicketMultiLang.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddSalesVmTicketMultiLang()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 154);
        if ($permission->add == 1) {

            if (empty($_POST['start_date']) || empty($_POST['delivery_date'])) {
                $error = "Error , Please Check Start Date & Delivery Date ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
            $error = "";
            if ($_FILES['file']['size'] != 0) {
                //  $config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/tickets/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $file_name = $data_file['file_name'];
                }
            }
            foreach ($_POST['target_lang'] as $k => $target_lang) {
                $data['from_id'] = 0;
                $data['request_type'] = $_POST['request_type'];
                if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                    $data['number_of_resource'] = $_POST['number_of_resource'];
                } else {
                    $data['number_of_resource'] = 0;
                }
                $subject = $_POST['ticket_subject'];
                $data['task_type'] = $_POST['task_type'];
                $data['service'] = $_POST['service'];
                $data['count'] = $_POST['count'];
                $data['unit'] = $_POST['unit'];
                $data['currency'] = $_POST['currency'];
                $data['source_lang'] = $_POST['source_lang'];
                $data['start_date'] = $_POST['start_date'];
                $data['delivery_date'] = $_POST['delivery_date'];
                $data['due_date'] = $_POST['delivery_date'];
                $data['subject'] = $_POST['subject'];
                $data['ticket_subject'] = $_POST['ticket_subject'];
                $data['software'] = $_POST['software'];
                $data['comment'] = $_POST['comment'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['ticket_from'] = 3;
                $data['status'] = 1;

                $data['target_lang'] = $target_lang;
                $data['rate'] = $_POST['rate'][$k];
                $data['file'] = $file_name ?? '';

                if ($this->db->insert('vm_ticket', $data)) {
                    $ticketNumber = $this->db->insert_id();
                    $this->vendor_model->sendNewTicketEmail($this->user, $ticketNumber, $this->brand, $subject, 0);

                } else {
                    $error .= "Failed To Add Ticket For " . $target_lang . "<br/>";

                }
            }
            if (strlen($error) > 0) {
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/salesVmTickets");
            }

        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addVmTicketMultiLang()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 49);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['user'] = $this->user;
            $data['from_id'] = $_GET['t'];
            $data['id'] = base64_decode($_GET['t']);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('sales_new/vm/addVmTicketMultiLang.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddVmTicketMultiLang()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 49);
        if ($permission->add == 1) {

            if (empty($_POST['start_date']) || empty($_POST['delivery_date'])) {
                $error = "Error , Please Check Start Date & Delivery Date ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
            $error = "";
            if ($_FILES['file']['size'] != 0) {
                //  $config['file']['upload_path']          = './assets/uploads/vendors/';
                $config['file']['upload_path'] = './assets/uploads/tickets/';
                $config['file']['encrypt_name'] = TRUE;
                $config['file']['allowed_types'] = 'zip|rar';
                $config['file']['max_size'] = 10000;
                $config['file']['max_width'] = 1024;
                $config['file']['max_height'] = 768;
                $this->load->library('upload', $config['file'], 'file_upload');
                if (!$this->file_upload->do_upload('file')) {
                    $error = $this->file_upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data_file = $this->file_upload->data();
                    $file_name = $data_file['file_name'];
                }
            }
            foreach ($_POST['target_lang'] as $k => $target_lang) {
                $data['from_id'] = base64_decode($_POST['from_id']);
                $data['request_type'] = $_POST['request_type'];
                if ($data['request_type'] == 1 || $data['request_type'] == 5 || $data['request_type'] == 4) {
                    $data['number_of_resource'] = $_POST['number_of_resource'];
                } else {
                    $data['number_of_resource'] = 0;
                }
                $data['task_type'] = $_POST['task_type'];
                $data['service'] = $_POST['service'];
                $data['count'] = $_POST['count'];
                $data['unit'] = $_POST['unit'];
                $data['currency'] = $_POST['currency'];
                $data['source_lang'] = $_POST['source_lang'];
                $data['start_date'] = $_POST['start_date'];
                $data['delivery_date'] = $_POST['delivery_date'];
                $data['due_date'] = $_POST['delivery_date'];
                $data['subject'] = $_POST['subject'];
                $data['ticket_subject'] = $_POST['ticket_subject'];
                $data['software'] = $_POST['software'];
                $data['comment'] = $_POST['comment'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['ticket_from'] = 1;
                $data['status'] = 1;

                $data['target_lang'] = $target_lang;
                $data['rate'] = $_POST['rate'][$k];
                $data['file'] = $file_name ?? '';

                if ($this->db->insert('vm_ticket', $data)) {
                    $ticketNumber = $this->db->insert_id();
                    $this->vendor_model->sendNewTicketEmail($this->user, $ticketNumber, $this->brand, $data['ticket_subject'], $data['from_id']);

                } else {
                    $error .= "Failed To Add Ticket For " . $target_lang . "<br/>";

                }
            }

            if (strlen($error) > 0) {
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $true = "Ticket Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "vendor/vmTicket?t=" . base64_encode($data['from_id']));
            }

        } else {
            echo "You have no permission to access this page";
        }
    }

      // send vendor Campaign
    public function vendorCampaignEmail($campaignID,$brand)
    {
        // check if table exists
        // then if not create it        
        // if yes get active vendor with brand & add to table
        // if has data already get data from this with send_flag = 0 & limit 1 
        // send email // after send update_flag = 1
        
        $tableName = 'camp_'.$campaignID;
  // step 1  
        if (!$this->db->table_exists('camp_'.$campaignID) )
        {               
            $this->vendor_model->CreateCampaignTable($tableName);
            echo 'Table Created Successfully';
        }           
// end step 1
// step 2
        $query = $this->db->get("$tableName");
        if($query->num_rows() > 0) {  
           //  $this->vendor_model->sendCampaignVendors($tableName);
           echo 'Table already exists.... Please send emails';
        }else{
            $this->vendor_model->getActiveVendors($brand,$campaignID);
         //   $this->vendor_model->sendCampaignVendors($tableName);
             echo 'Data added Successfully';
        }
        
        
    }
    public function sendVendorCampaignEmail($tableName)
    {

        $this->vendor_model->sendCampaignVendors($tableName);      
        
        
    }
}
?>
