<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hr extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
        $this->emp_id = $this->session->userdata('emp_id');
    }

    public function meetingRoom()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 133);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 133);
            //body ..
            $data['meeting'] = $this->db->query(" SELECT * FROM `meeting_room_schedule` ORDER BY id DESC ")->result();
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/calendar.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function meetingRoomList()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 134);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 134);
            //body ..
            $data['meeting'] = $this->db->query(" SELECT * FROM `meeting_room_schedule` ORDER BY id DESC ");
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/meetingRoomList.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addMeeting()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 134);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addMeeting.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddMeeting()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 134);
        if ($permission->add == 1) {
            $data['title'] = $_POST['title'];
            $data['attendees'] = implode(";", $_POST['attendees']);
            $data['description'] = $_POST['description'];
            $data['start'] = $_POST['start_date'];
            $data['end'] = $_POST['end_date'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('meeting_room_schedule', $data)) {
                $this->hr_model->meetingMail($data);
                $true = "Meeting Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/meetingRoomList");
            } else {
                $error = "Failed To Add Meeting ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/meetingRoomList");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editMeeting()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 134);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['meeting_room_schedule'] = $this->db->get_where('meeting_room_schedule', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editMeeting.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditMeeting()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 134);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['title'] = $_POST['title'];
            $data['attendees'] = implode(";", $_POST['attendees']);
            $data['description'] = $_POST['description'];
            $data['start'] = $_POST['start_date'];
            $data['end'] = $_POST['end_date'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('meeting_room_schedule', 134, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('meeting_room_schedule', $data, array('id' => $id))) {
                $true = "Meeting Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/meetingRoomList");
            } else {
                $error = "Failed To Edit Meeting ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/meetingRoomList");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteMeeting($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 134);
        if ($check) {
            $this->admin_model->addToLoggerDelete('meeting_room_schedule', 134, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('meeting_room_schedule', array('id' => $id))) {
                $true = "Meeting Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/meetingRoomList");
            } else {
                $error = "Failed To Delete Meeting ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/meetingRoomList");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function division()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 137);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 137);

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
                $cond1 = "name LIKE '%$name%'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);


                if ($arr_1_cnt > 0) {
                    $data['division'] = $this->hr_model->AllDivision($this->brand, $arr4);
                } else {
                    $data['division'] = $this->hr_model->AllDivisionPages($this->brand, 9, 0);
                }
                $data['total_rows'] = $data['division']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllDivision($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('hr/division');
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

                $data['division'] = $this->hr_model->AllDivisionPages($this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/division.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addDivision()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 137);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addDivision.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddDivision()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 137);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");


            if ($this->db->insert('division', $data)) {
                $true = "Division Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/division");
            } else {
                $error = "Failed To Add Division ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/division");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editDivision()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 137);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['division'] = $this->db->get_where('division', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editDivision.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditDivision()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 137);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['brand'] = $this->brand;
            $this->admin_model->addToLoggerUpdate('division', 137, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('division', $data, array('id' => $id))) {
                $true = "Division Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/division");
            } else {
                $error = "Failed To Edit Division ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/division");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteDivision($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 137);
        if ($data['permission']->delete == 1) {
            $this->admin_model->addToLoggerDelete('division', 137, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('division', array('id' => $id))) {
                $true = "Division Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/division");
            } else {
                $error = "Failed To Delete Division ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/division");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function department()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 138);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['division'])) {
                    $division = $_REQUEST['division'];
                    if (!empty($division)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $division = "";
                }

                if (isset($_REQUEST['name'])) {
                    $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }
                $cond1 = "division = '$division'";
                $cond2 = "name LIKE '%$name%'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                //print_r($arr4);

                if ($arr_1_cnt > 0) {
                    $data['department'] = $this->hr_model->AllDepartment($this->brand, $arr4);
                } else {
                    $data['department'] = $this->hr_model->AllDepartmentPages($this->brand, 9, 0);
                }
                $data['total_rows'] = $data['department']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllDepartment($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('hr/department');
                $config['uri_segment'] = 3;
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

                $data['department'] = $this->hr_model->AllDepartmentPages($this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/department.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addDepartment()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addDepartment.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function doAddDepartment()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['division'] = $_POST['division'];
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('department', $data)) {
                $true = "Department Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/department");
            } else {
                $error = "Failed To Add Department ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/department");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editDepartment()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['department'] = $this->db->get_where('department', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editDepartment.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditDepartment()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['division'] = $_POST['division'];
            $data['brand'] = $this->brand;
            $this->admin_model->addToLoggerUpdate('department', 138, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('department', $data, array('id' => $id))) {
                $true = "Department Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/department");
            } else {
                $error = "Failed To Edit Department ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/department");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteDepartment($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 138);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('department', 138, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('department', array('id' => $id))) {
                $true = "Department Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/department");
            } else {
                $error = "Failed To Delete Department ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/department");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function structure()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 139);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 139);
            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['division'])) {
                    $division = $_REQUEST['division'];
                    if (!empty($division)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $division = "";
                }

                if (isset($_REQUEST['department'])) {
                    $department = $_REQUEST['department'];
                    if (!empty($department)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $department = "";
                }

                if (isset($_REQUEST['title'])) {
                    $title = $_REQUEST['title'];
                    if (!empty($title)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $title = "";
                }

                $cond1 = "division = '$division'";
                $cond2 = "department = '$department'";
                $cond3 = "title LIKE '%$title%'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['structure'] = $this->hr_model->AllStructure($this->brand, $arr4);
                } else {
                    $data['structure'] = $this->hr_model->AllStructurePages($this->brand, 9, 0);
                }
                $data['total_rows'] = $data['structure']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllStructure($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('hr/structure');
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

                $data['structure'] = $this->hr_model->AllStructurePages($this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/structure.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addStructure()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 139);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addStructure.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function doAddStructure()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 139);
        if ($permission->add == 1) {
            $data['title'] = $_POST['title'];
            $data['division'] = $_POST['division'];
            $data['department'] = $_POST['department'];
            $data['track'] = $_POST['track'];
            $data['brand'] = $this->brand;
            if (empty($_POST['parent']) || $_POST['parent'] === "") {
                $data['parent'] = NULL;
            } else {
                $data['parent'] = $_POST['parent'];
            }
            if (empty($_POST['grand_parent']) || $_POST['grand_parent'] === "") {
                $data['grand_parent'] = NULL;
            } else {
                $data['grand_parent'] = $_POST['grand_parent'];
            }
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('structure', $data)) {
                $true = "Structure Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/structure");
            } else {
                $error = "Failed To Add Structure ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/structure");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editStructure()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 139);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['structure'] = $this->db->get_where('structure', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editStructure.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditStructure()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 139);
        if ($permission->edit == 1) {
            $referer = $_POST['referer'];
            $id = base64_decode($_POST['id']);
            $data['title'] = $_POST['title'];
            $data['division'] = $_POST['division'];
            $data['department'] = $_POST['department'];
            $data['track'] = $_POST['track'];
            $data['brand'] = $this->brand;
            if (empty($_POST['parent']) || $_POST['parent'] === "") {
                $data['parent'] = NULL;
            } else {
                $data['parent'] = $_POST['parent'];
            }
            if (empty($_POST['grand_parent']) || $_POST['grand_parent'] === "") {
                $data['grand_parent'] = NULL;
            } else {
                $data['grand_parent'] = $_POST['grand_parent'];
            }
            $this->admin_model->addToLoggerUpdate('structure', 139, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('structure', $data, array('id' => $id))) {
                $true = "Structure Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/structure");
                }
            } else {
                $error = "Failed To Edit Structure ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/structure");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteStructure($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 139);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('structure', 139, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('structure', array('id' => $id))) {
                $true = "Structure Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/structure");
            } else {
                $error = "Failed To Delete Structure ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/structure");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function employees()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 140);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
            $data['employees'] = $this->db->query(" SELECT * FROM `employees` WHERE brand = '$this->brand' ");

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

                if (isset($_REQUEST['title'])) {
                    $title = $_REQUEST['title'];
                    if (!empty($title)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $title = "";
                }

                if (isset($_REQUEST['division'])) {
                    $division = $_REQUEST['division'];
                    if (!empty($division)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $division = "";
                }

                if (isset($_REQUEST['department'])) {
                    $department = $_REQUEST['department'];
                    if (!empty($department)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $department = "";
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    if ($status != NULL) {
                        array_push($arr2, 4);
                    }
                } else {
                    $status = "";
                }
                if (isset($_REQUEST['resigned_from']) && isset($_REQUEST['resigned_to'])) {
                    $resigned_from = date("Y-m-d", strtotime($_REQUEST['resigned_from']));
                    $resigned_to = date("Y-m-d", strtotime($_REQUEST['resigned_to']));
                    if (!empty($_REQUEST['resigned_from']) && !empty($_REQUEST['resigned_to'])) {
                        array_push($arr2, 5);
                    }
                } else {
                    $resigned_from = "";
                    $resigned_to = "";
                }
                $idsArray = array();
                if (isset($_REQUEST['social_ins']) && $_REQUEST['social_ins'] != NULL) {
                    $data['social_ins'] = $social_ins = $_REQUEST['social_ins'];
                    $emp_ids = $this->db->query("SELECT employee_id FROM social_insurance where deactivation_date='0000-00-00' or deactivation_date is null ")->result_array();
                    foreach ($emp_ids as $value)
                        array_push($idsArray, $value['employee_id']);

                    $idsArray = implode(',', $idsArray);
                    if (strlen($idsArray) == 0)
                        $idsArray = "''";
                    array_push($arr2, 6);

                } else {
                    $data['social_ins'] = $social_ins = "";
                }


                //print_r($arr2);
                $cond1 = "name LIKE '%$name%'";
                $cond2 = "title = '$title'";
                $cond3 = "division = '$division'";
                $cond4 = "department = '$department'";
                $cond5 = "status = '$status'";
                $cond6 = "resignation_date BETWEEN '$resigned_from' AND '$resigned_to'";
                if (count($idsArray) != 0) {
                    if ($social_ins == 1) {
                        $cond7 = "id IN ($idsArray)";
                        $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                    } else {
                        $cond7 = "id NOT IN ($idsArray)";
                    }
                } else {
                    $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
                }
                $arr3 = array();
                $arr_1_cnt = count($arr2);
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);

                if ($arr_1_cnt > 0) {
                    $data['employees'] = $this->hr_model->AllEmployees($arr4);
                } else {
                    $data['employees'] = $this->hr_model->AllEmployeesPages(9, 0);
                }
                $data['total_rows'] = $data['employees']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllEmployees(1)->num_rows();
                $config['base_url'] = base_url('hr/employees');
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

                $data['employees'] = $this->hr_model->AllEmployeesPages($limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $data['birthdayData'] = $this->db->query("SELECT * FROM `employees`AS e WHERE MONTH(CURRENT_TIMESTAMP) = ( SELECT EXTRACT(MONTH FROM e.birth_date))AND status = 0");
            //contract notifaction 10 days
            $data['contractData'] = $this->db->query("SELECT *,DATEDIFF(contract_date,CURRENT_TIMESTAMP)AS days FROM `employees` where DATEDIFF(contract_date,CURRENT_TIMESTAMP)>=0 AND DATEDIFF(contract_date,CURRENT_TIMESTAMP) <=10 AND status = 0");

            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/employees.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportEmployees()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Employees.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 140);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
            //$data['employees'] = $this->db->query(" SELECT * FROM `employees` WHERE brand = '$this->brand' ");
            $data['employees'] = $this->db->query(" SELECT * FROM `employees` ");
            //body ..

            $arr2 = array();
            if (isset($_REQUEST['name'])) {
                $name = $_REQUEST['name'];
                if (!empty($name)) {
                    array_push($arr2, 0);
                }
            } else {
                $name = "";
            }

            if (isset($_REQUEST['title'])) {
                $title = $_REQUEST['title'];
                if (!empty($title)) {
                    array_push($arr2, 1);
                }
            } else {
                $title = "";
            }

            if (isset($_REQUEST['division'])) {
                $division = $_REQUEST['division'];
                if (!empty($division)) {
                    array_push($arr2, 2);
                }
            } else {
                $division = "";
            }

            if (isset($_REQUEST['department'])) {
                $department = $_REQUEST['department'];
                if (!empty($department)) {
                    array_push($arr2, 3);
                }
            } else {
                $department = "";
            }
            if (isset($_REQUEST['status'])) {
                $status = $_REQUEST['status'];
                if ($status != NULL) {
                    array_push($arr2, 4);
                }
            } else {
                $status = "";
            }
            if (isset($_REQUEST['resigned_from']) && isset($_REQUEST['resigned_to'])) {
                $resigned_from = date("Y-m-d", strtotime($_REQUEST['resigned_from']));
                $resigned_to = date("Y-m-d", strtotime($_REQUEST['resigned_to']));
                if (!empty($_REQUEST['resigned_from']) && !empty($_REQUEST['resigned_to'])) {
                    array_push($arr2, 5);
                }
            } else {
                $resigned_from = "";
                $resigned_to = "";
            }
            // social Ins.
            $idsArray = array();
            if (isset($_REQUEST['social_ins']) && $_REQUEST['social_ins'] != NULL) {
                $social_ins = $_REQUEST['social_ins'];
                $emp_ids = $this->db->query("SELECT employee_id FROM social_insurance where deactivation_date='0000-00-00' or deactivation_date is null")->result_array();

                foreach ($emp_ids as $value)
                    array_push($idsArray, $value['employee_id']);

                $idsArray = implode(',', $idsArray);
                if (strlen($idsArray) == 0)
                    $idsArray = "''";
                array_push($arr2, 6);

            } else {
                $social_ins = "";
            }
            // print_r($arr2);
            $cond1 = "name LIKE '%$name%'";
            $cond2 = "title = '$title'";
            $cond3 = "division = '$division'";
            $cond4 = "department = '$department'";
            $cond5 = "status = '$status'";
            $cond6 = "resignation_date BETWEEN '$resigned_from' AND '$resigned_to'";
            if (count($idsArray) != 0) {
                if ($social_ins == 1) {
                    $cond7 = "id IN ($idsArray)";
                    $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6, $cond7);
                } else {
                    $cond7 = "id NOT IN ($idsArray)";
                }
            } else {
                $arr1 = array($cond1, $cond2, $cond3, $cond4, $cond5, $cond6);
            }

            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['employees'] = $this->hr_model->AllEmployees($arr4);
            } else {
                $data['employees'] = $this->hr_model->AllEmployees(1);
            }

            // //Pages ..

            $this->load->view('hr/exportEmployees.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addEmployees()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/addEmployees.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddEmployees()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['gender'] = $_POST['gender'];
            $data['birth_date'] = $_POST['birth_date'];
            $data['national_id'] = $_POST['national_id'];
            $data['division'] = $_POST['division'];
            $data['department'] = $_POST['department'];
            $data['title'] = $_POST['title'];
            $data['manager'] = $_POST['manager'];
            $data['time_zone'] = $_POST['time_zone'];
            $data['office_location'] = $_POST['office_location'];
            $data['prob_period'] = $_POST['prob_period'];
            $data['hiring_date'] = $_POST['hiring_date'];
            $data['contract_date'] = $_POST['contract_date'];
            $data['contract_type'] = $_POST['contract_type'];
            $data['status'] = $_POST['status'];
            $data['resignation_date'] = $_POST['resignation_date'];
            $data['email'] = $_POST['email'];
            $data['emergency'] = $_POST['emergency'];
            $data['brand'] = $_POST['brand'];
            $data['phone'] = $_POST['phone'];
            $data['position_comment'] = $_POST['position_comment'];
            $data['workplace_model'] = $_POST['workplace_model'] ?? '';
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if (isset($_POST['other_emails'])) {
                $other_emails = implode(" ; ", $_POST['other_emails']);
                $data['other_emails'] = $other_emails;
            }

            if ($this->db->insert('employees', $data)) {
                $true = "Employee Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/employees");
            } else {
                $error = "Failed To Add Employee ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/employees");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editEmployees()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['employees'] = $this->db->get_where('employees', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/editEmployees.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditEmployees()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
        if ($permission->edit == 1) {
            $referer = $this->input->post('referer');
            $id = base64_decode($this->input->post('id'));
            $data['name'] = $this->input->post('name');
            $data['gender'] = $this->input->post('gender');
            $data['birth_date'] = $this->input->post('birth_date');
            $data['national_id'] = $this->input->post('national_id');
            $data['division'] = $this->input->post('division');
            $data['department'] = $this->input->post('department');
            $data['title'] = $this->input->post('title');
            $data['manager'] = $this->input->post('manager');
            $data['time_zone'] = $this->input->post('time_zone');
            $data['office_location'] = $this->input->post('office_location');
            $data['hiring_date'] = $this->input->post('hiring_date');
            $data['prob_period'] = $this->input->post('prob_period');
            $data['contract_date'] = $this->input->post('contract_date');
            $data['contract_type'] = $this->input->post('contract_type');
            $data['status'] = $this->input->post('status');
            if ($data['status'] == 1) {
                $data['resignation_date'] = $this->input->post('resignation_date');
            } else {
                $data['resignation_date'] = NULL;
            }
            $data['resignation_reason'] = $this->input->post('resignation_reason');
            $data['resignation_comment'] = $this->input->post('resignation_comment');
            $data['email'] = $this->input->post('email');
            $data['emergency'] = $this->input->post('emergency');
            $data['brand'] = $this->input->post('brand');
            $data['phone'] = $this->input->post('phone');
            $data['position_comment'] = $this->input->post('position_comment');
            $other_emails = ($this->input->post('other_emails') ? implode(' ; ', $this->input->post('other_emails')) : '');
            $data['other_emails'] = $other_emails;
            $data['workplace_model'] = $_POST['workplace_model'] ?? '';
            $this->admin_model->addToLoggerUpdate('employees', 140, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('employees', $data, array('id' => $id))) {
                $true = "Employee Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/employees");
                }
            } else {
                $error = "Failed To Edit Employee ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/employees");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deleteEmployees($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 140);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('employees', 140, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('employees', array('id' => $id))) {
                $true = "Employee Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/employees");
            } else {
                $error = "Failed To Delete Employee ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/employees");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function getDepartment()
    {
        $division = $_POST['division'];
        $data = $this->hr_model->selectDepartment(0, $division);
        echo $data;
    }

    public function getTitle()
    {
        $department = $_POST['department'];
        $division = $_POST['division'];
        $data = $this->hr_model->selectPosition(0, $department, $division);
        echo $data;
    }

    public function getTitleData()
    {
        $title = $_POST['title'];
        echo $this->hr_model->getTitleData($title);
    }

    public function getDirectManagerByTitle()
    {
        $title = $_POST['title'];
        echo $this->hr_model->getDirectManagerByTitle($title);
    }

    public function testCURL($value = '')
    {
        // Client
        $ch = curl_init('http://attendance.thetranslationgate.com/abc/index.php/api/logDate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000000);
        $data = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_errno > 0) {
            echo "cURL Error ($curl_errno): $curl_error\n";
        } else {
            echo "Data received: $data\n";
        }
    }

    public function attendanceMac()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 145);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
            //body ..
            if (isset($_POST['search'])) {
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
                if (isset($_REQUEST['user'])) {
                    $user = $_REQUEST['user'];
                    if (!empty($_REQUEST['user'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $user = "";
                }
                $cond1 = "DEVDT BETWEEN '$date_from' AND '$date_to'";
                $cond2 = "USRID = '$user'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                $data['attendance'] = $this->hr_model->attendanceMac($data['permission'], $arr4);
                // print_r($data['attendance']);
            }
            // //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/attendance.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function attendance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 145);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
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
                if (isset($_REQUEST['user'])) {
                    $user = $_REQUEST['user'];
                    if (!empty($_REQUEST['user'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $user = "";
                }
                $idsArray = array();
                if (isset($_REQUEST['department']) && !empty($_REQUEST['department'])) {
                    $data['department'] = $department = $_REQUEST['department'];
                    $ids = $this->db->query("SELECT id FROM employees WHERE department = $department")->result_array();

                    foreach ($ids as $value)
                        array_push($idsArray, $value['id']);

                    $idsArray = implode(',', $idsArray);
                    array_push($arr2, 2);
                } else {
                    $department = '';
                }
                $cond1 = "DATE(l.SRVDT) BETWEEN '$date_from' AND '$date_to'";
                $cond2 = "USRID = '$user'";
                if (count($idsArray) != 0) {
                    $cond3 = "USRID IN ($idsArray)";
                    $arr1 = array($cond1, $cond2, $cond3);
                } else {
                    $arr1 = array($cond1, $cond2);
                }
               // $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                $data['attendance'] = $this->hr_model->attendance($data['permission'], $arr4);
                //print_r($data['attendance']);
            }
            // missing requests 
            $title = $this->db->query(" SELECT title FROM employees WHERE id = '$this->emp_id' ")->row()->title;
            $start_date = date("Y-m-d", strtotime("-45 days"));
            $end_date = date("Y-m-d", strtotime("+1 day"));
            $data['missingRequests'] = $this->hr_model->getMissingAttendanceRequests($this->emp_id, $title, $start_date, $end_date)->result();

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendance/mainAttendance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportAttendanceLog()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=AttendanceLog.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
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
        if (isset($_REQUEST['user'])) {
            $user = $_REQUEST['user'];
            if (!empty($_REQUEST['user'])) {
                array_push($arr2, 1);
            }
        } else {
            $user = "";
        }
        $idsArray = array();
        if (isset($_REQUEST['department']) && !empty($_REQUEST['department'])) {
            $data['department'] = $department = $_REQUEST['department'];
            $ids = $this->db->query("SELECT id FROM employees WHERE department = $department")->result_array();

            foreach ($ids as $value)
                array_push($idsArray, $value['id']);

            $idsArray = implode(',', $idsArray);
            array_push($arr2, 2);
        } else {
            $department = '';
        }
        $cond1 = "DATE(l.SRVDT) BETWEEN '$date_from' AND '$date_to'";
        $cond2 = "USRID = '$user'";
        if (count($idsArray) != 0) {
            $cond3 = "USRID IN ($idsArray)";
            $arr1 = array($cond1, $cond2, $cond3);
        } else {
            $arr1 = array($cond1, $cond2);
        }
        $arr1 = array($cond1, $cond2, $cond3);
        $arr_1_cnt = count($arr2);
        $arr3 = array();
        for ($i = 0; $i < $arr_1_cnt; $i++) {
            array_push($arr3, $arr1[$arr2[$i]]);
        }
        $arr4 = implode(" and ", $arr3);
        $data['attendance'] = $this->hr_model->attendance($data['permission'], $arr4);
        $this->load->view('hr/exportAttendanceLog.php', $data);
    }

    public function attendanceTest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://attendance.thetranslationgate.com/abc/index.php/api/attendanceTest");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "filter=1");
        $data['attendance'] = json_decode(curl_exec($ch), TRUE);
        print_r($data['attendance']);
        // $this->load->view('hr/attendanceTest.php',$data);
    }

    public function remoteAccess()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendance/remoteAccess.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddRemoteAccess()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($permission->add == 1) {
            $userData = $this->db->get_where('users', array('id' => $this->user))->row()->employees_id;
            if ($userData == 0) {
                $error = "Failed To Add Attendance ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/attendance");
            }
            $data['SRVDT'] = date("Y-m-d H:i:s");
            $data['USRID'] = $userData;
            $data['TNAKEY'] = $_POST['TNAKEY'];
            $data['location'] = $_POST['location'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;
            // check if attendance already exists with same location
            $checkSameLocation = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $userData . " AND location = " . $_POST['location'] . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date("Y-m-d") . "%' ORDER BY id DESC LIMIT 1")->row();
            if ($checkSameLocation > 0 && $_POST['TNAKEY'] != 2) {
                $error = "Attendance Already Exists ...";
                $error .= "<br/>".$this->hr_model->getTnakeyType($checkSameLocation->TNAKEY)." : ".$checkSameLocation->SRVDT." ( ".$this->hr_model->getLocationType($checkSameLocation->location)." )";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/attendance");
            } else {
                // check if exists with differnet location
                $check = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $userData . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date("Y-m-d") . "%' AND location !=" . $_POST['location'] . " ORDER BY id DESC LIMIT 1")->row();
                $this->admin_model->addToLoggerDelete('attendance_log', 145, 'id', $check->id, 0, 0, $this->user);
                $this->db->delete('attendance_log', array('id' => $check->id));

                if ($this->db->insert('attendance_log', $data)) {
                    $true = "Attendance Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/attendance");
                } else {
                    $error = "Failed To Add Attendance ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/attendance");
                }
            }

        } else {
            echo "You have no permission to access this page";
        }
    }


    /////start vocation
    public function vacation()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 143);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
            $year = date("Y");
            //body ..
            // $data['vacation'] = $this->db->query(" SELECT * FROM `vacation_transaction` WHERE emp_id = (SELECT employees_id FROM users WHERE id = '$this->user')");
            $data['vacation'] = $this->db->query(" SELECT * FROM `vacation_transaction` WHERE emp_id = '$this->emp_id' and EXTRACT(YEAR FROM created_at) = '$year'");
            $data['requests'] = $this->hr_model->getRequestsForDirectManager($this->emp_id);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/vacation.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addVacation()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/addVacationRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddVacationRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($permission->add == 1) {
            // $data['emp_id'] = $this->hr_model->getEmpId($this->user);
            $data['emp_id'] = $this->emp_id;
            $data['type_of_vacation '] = $_POST['type_of_vacation'];
            $data['start_date'] = $_POST['start_date'];
            //calculate end date 
            $data['end_date'] = $this->hr_model->getEndDate($_POST['type_of_vacation'], $_POST['start_date'], $_POST['end_date'], $_POST['relative_degree']);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['relative_degree'] = $_POST['relative_degree'];
            $availableDays = $_POST['available_days'];
            if ($data['type_of_vacation '] == 1 || $data['type_of_vacation '] == 2 || $data['type_of_vacation '] == 3) {
                $data['requested_days'] = $_POST['requested_days'];
            } elseif ($data['type_of_vacation '] == 5) {
                $data['requested_days'] = 90;
            } elseif ($data['type_of_vacation '] == 7) {
                $data['requested_days'] = 30;
            } else {
                $data['requested_days'] = $this->hr_model->getRequestedDays($_POST['start_date'], $data['end_date']);
            }
            ///for sick leave document 
            if ($data['type_of_vacation '] == 3) {
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/sickLeaveDocument/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar|gif|jpg|png|jpeg';
                    // $config['file']['max_size']             = 10000;
                    // $config['file']['max_width']            = 1024;
                    // $config['file']['max_height']           = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "hr/vacation");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['sick_leave_file'] = $data_file['file_name'];
                    }
                } else {
                    $error = "You must upload Sick Leave Document.";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/vacation");
                }
            } else {
                $data['sick_leave_file'] = " ";
            }
            ///
            if ($availableDays >= 0 && $data['requested_days'] > 0 && $availableDays - $data['requested_days'] >= 0) {
                if ($this->db->insert('vacation_transaction', $data)) {
                    $this->admin_model->addToLoggerUpdate('vacation_balance', 143, 'id', $this->db->insert_id(), 101, 101, $this->user);
                    $this->hr_model->sendVacationRequestMail($data, $this->brand);
                    $true = "Request Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/vacation");
                } else {
                    $error = "Failed To Add Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/vacation");
                }
            } else {
                $error = "Failed To Add Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacation");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    //edit vacation Request
    public function editVacationRequest()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('vacation_transaction', array('id' => $data['id']))->row();
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/editVacationRequest.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditVacationRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($permission->add == 1) {
            $id = base64_decode($_POST['id']);
            $data['emp_id'] = $this->emp_id;
            $data['type_of_vacation '] = $_POST['type_of_vacation'];
            $data['start_date'] = $_POST['start_date'];
            //calculate end date 
            $data['end_date'] = $this->hr_model->getEndDate($_POST['type_of_vacation'], $_POST['start_date'], $_POST['end_date'], $_POST['relative_degree']);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['relative_degree'] = $_POST['relative_degree'];
            $availableDays = $_POST['available_days'];
            if ($data['type_of_vacation '] == 1 || $data['type_of_vacation '] == 2 || $data['type_of_vacation '] == 3) {
                $data['requested_days'] = $_POST['requested_days'];
            } else {
                $data['requested_days'] = $this->hr_model->getRequestedDays($_POST['start_date'], $data['end_date']);
            }
            ///for sick leave document 
            if ($data['type_of_vacation '] == 3) {
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/sickLeaveDocument/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar';
                    $config['file']['max_size'] = 10000;
                    $config['file']['max_width'] = 1024;
                    $config['file']['max_height'] = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "hr/vacation");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['sick_leave_file'] = $data_file['file_name'];
                    }
                } else {
                    $data['sick_leave_file'] = $this->db->query("SELECT sick_leave_file FROM vacation_transaction Where id = '$id'")->row()->sick_leave_file;
                }
            } else {
                $data['sick_leave_file'] = " ";
            }
            ///
            if ($availableDays >= 0 && $data['requested_days'] > 0 && $availableDays - $data['requested_days'] >= 0) {
                $this->admin_model->addToLoggerUpdate('vacation_transaction', 143, 'id', $id, 103, 103, $this->user);
                if ($this->db->update('vacation_transaction', $data, array('id' => $id))) {
                    $true = "Request Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/vacation");
                } else {
                    $error = "Failed To Updated Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/vacation");
                }
            } else {
                $error = "Failed To Updated Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacation");
            }

        } else {
            echo "You have no permission to access this page";
        }
    }

    //delete vacation request
    public function deleteVacationRequest()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['i']);
            $this->admin_model->addToLoggerDelete('vacation_transaction', 143, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vacation_transaction', array('id' => $id))) {
                $true = "Vacation Request Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/vacation");
            } else {
                $error = "Failed To Delete vacation Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacation");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function responseToVacation()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..          
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('vacation_transaction', array('id' => $data['id']))->row();
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/responseToVacation.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doUpdateVacationStatus()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 143);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $data['status'] = $_POST['status'];
            $data['status_by'] = $this->user;
            $data['status_at'] = date("Y-m-d H:i:s");
            if ($this->db->update('vacation_transaction', $data, array('id' => $id))) {
                if ($data['status'] == 1) {
                    $startDate = $_POST['start_date'];
                    $endDate = $_POST['end_date'];
                    $typeOfVacation = $_POST['type_of_vacation_'];
                    $id = $_POST['emp_id_'];
                    $day_type = $_POST['day_type'] ?? 0;
                    $days = $this->hr_model->getRequestedDays($startDate, $endDate, $typeOfVacation, $day_type);
                    $this->hr_model->updataVacationBalance($days, $id, $typeOfVacation);
                }
                $true = "Status changed Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/vacation");
            } else {
                $error = "Failed To change request status ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacation");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function calculateAvailableVacationDays()
    {
        $type_of_vacation = $_POST['type_of_vacation'];
        $relative_degree = $_POST['relative_degree'];
        $emp_id = $_POST['emp_id'] ?? $this->emp_id;
        echo $data = $this->hr_model->calculateAvailableVacationDays($type_of_vacation, $emp_id, $relative_degree);
    }
    public function showEndDate()
    {
        $type_of_vacation = $_POST['type_of_vacation'];
        $relative_degree = $_POST['relative_degree'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        echo $data = $this->hr_model->getEndDate($type_of_vacation, $start_date, $end_date, $relative_degree);
    }
    public function checkVacationCredite()
    {
        //calculate number of days
        $type_of_vacation = $_POST['type_of_vacation'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $day_type = $_POST['day_type'] ?? 0;
        $emp_id = $_POST['emp_id'] ?? $this->emp_id;
        if ($type_of_vacation == 1 or $type_of_vacation == 2 or $type_of_vacation == 3 or $type_of_vacation == 8) {
            $requested_days = $this->hr_model->getRequestedDays($start_date, $end_date, $type_of_vacation, $day_type);
        } else {
            $end_date = $this->hr_model->getEndDate($type_of_vacation, $start_date, $end_date);
            $requested_days = $this->hr_model->getRequestedDays($start_date, $end_date, $type_of_vacation);
        }
        $available_days = $this->hr_model->checkVacationCredite($type_of_vacation, $requested_days, $emp_id);
        $data = array("available_days" => $available_days, "requested_days" => $requested_days);
        echo json_encode($data);
    }
    public function onApprove()
    {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $emp_id = $_POST['emp_id'];
        echo $data = $this->hr_model->onApprove($start_date, $end_date, $emp_id);
    }
    public function onApproveGetAvailableDays()
    {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $emp_id = $_POST['emp_id'];
        $type_of_vacation = $_POST['type_of_vacation'];
        $day_type = $_POST['day_type'] ?? 0;
        if ($type_of_vacation == 1 or $type_of_vacation == 2 or $type_of_vacation == 3 or $type_of_vacation == 8) {
            $requested_days = $this->hr_model->getRequestedDays($start_date, $end_date, $type_of_vacation, $day_type);
        } else {
            $end_date = $this->hr_model->getEndDate($type_of_vacation, $start_date, $end_date);
            $requested_days = $this->hr_model->getRequestedDays($start_date, $end_date, $type_of_vacation);
        }
        $available_days = $this->hr_model->checkVacationCredite($type_of_vacation, $requested_days, $emp_id);
        $data = array("available_days" => $available_days, "requested_days" => $requested_days);
        echo json_encode($data);
    }

    ////////// 
    public function vacationBalance()
    {
        //$data['vacation'] = $this->db->query(" SELECT * FROM `vacation`");
        $check = $this->admin_model->checkPermission($this->role, 150);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 150);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['year'])) {
                    $year = $_REQUEST['year'];
                    if (!empty($year)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $year = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $employee_name = "";
                }

                $cond1 = "year LIKE '%$year%'";
                $cond2 = "emp_id = '$employee_name'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['vacation_balance'] = $this->hr_model->AllVacationBalance($data['permission'], $this->user, $this->brand, $arr4);
                } else {
                    $data['vacation_balance'] = $this->hr_model->AllVacationBalancePages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['vacation_balance']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllVacationBalance($data['permission'], $this->user, $this->brand, 1)->num_rows();
                $config['base_url'] = base_url('hr/vacationBalance/');
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

                $data['vacation_balance'] = $this->hr_model->AllVacationBalancePages($data['permission'], $this->user, $this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/vacationBalance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addVacationBalance()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 150);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addVacationBalance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddVacationBalance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 150);
        if ($permission->add == 1) {
            $data['emp_id '] = $_POST['employee'];
            $data['current_year '] = $_POST['current_year'];
            //$data['previous_year'] = $_POST['previous_year'];
            //  $data['annual_leave'] = $_POST['annual_leave'];
            //$data['casual_leave'] = $_POST['casual_leave'];
            $data['sick_leave'] = $_POST['sick_leave'];
            $data['marriage'] = $_POST['marriage'];
            $data['maternity_leave'] = $_POST['maternity_leave'];
            //$data['death_leave'] = $_POST['death_leave'];
            //$data['double_days'] = $_POST['double_days'];
            $data['year '] = date("Y");
            $data['brand '] = $this->brand;

            if ($this->db->insert('vacation_balance', $data)) {
                $this->admin_model->addToLoggerUpdate('vacation_balance', 150, 'id', $this->db->insert_id(), 100, 100, $this->user);
                $true = "Request Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/vacationBalance");
            } else {
                $error = "Failed To Add Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacationBalance");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editVacationBalance()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 150);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('vacation_balance', array('id' => $data['id']))->row();
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editVacationBalance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditVacationBalance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 150);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $data['current_year'] = $_POST['current_year'];
            // $data['previous_year'] = $_POST['previous_year'];
            // $data['annual_leave'] = $_POST['annual_leave'];
            // $data['casual_leave'] = $_POST['casual_leave'];
            $data['sick_leave'] = $_POST['sick_leave'];
            $data['marriage'] = $_POST['marriage'];
            $data['maternity_leave'] = $_POST['maternity_leave'];
            // $data['death_leave'] = $_POST['death_leave'];
            // $data['double_days'] = $_POST['double_days'];
            $referer = $_POST['referer'];
            $this->admin_model->addToLoggerUpdate('vacation_balance', 150, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('vacation_balance', $data, array('id' => $id))) {
                $true = "ٌRequest updated Successfully ...";
                $this->session->set_flashdata('true', $true);

                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/vacationBalance");
                }
            } else {
                $error = "Failed To update request ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/vacationBalance");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deleteVacationBalance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 150);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['i']);
            echo $id;
            $this->admin_model->addToLoggerDelete('vacation_balance', 150, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('vacation_balance', array('id' => $id))) {
                $true = "Employee Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete Employee...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportVacationBalance()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=exportVacationBalance.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        $check = $this->admin_model->checkPermission($this->role, 150);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 150);
            //body ..
            $data['user'] = $this->user;
            $arr2 = array();
            if (isset($_REQUEST['year'])) {
                $year = $_REQUEST['year'];
                if (!empty($year)) {
                    array_push($arr2, 0);
                }
            } else {
                $year = "";
            }
            if (isset($_REQUEST['employee_name'])) {
                $employee_name = $_REQUEST['employee_name'];
                if (!empty($employee_name)) {
                    array_push($arr2, 1);
                }
            } else {
                $employee_name = "";
            }

            $cond1 = "year LIKE '%$year%'";
            $cond2 = "emp_id = '$employee_name'";

            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['vacation_balance'] = $this->hr_model->AllVacationBalance($data['permission'], $this->user, $this->brand, $arr4);
            } else {
                $data['vacation_balance'] = $this->hr_model->AllVacationBalance($data['permission'], $this->user, $this->brand, 9, 0);
            }
            $this->load->view('hr/exportVacationBalance.php', $data);

        } else {
            echo "You have no permission to access this page";
        }


    }
    //employee script 
    public function allEmployeesForVacatoinTable()
    {
        $current_year = date("Y");
        $brand = $this->brand;
        $users = $this->db->query(" SELECT * FROM `employees` WHERE status != 1 AND brand = 1 OR brand = 2 ")->result();
        foreach ($users as $user) {
            $this->db->query("INSERT INTO vacation_balance (emp_id,current_year,sick_leave,maternity_leave,marriage,hajj,year,brand)
            VALUES ($user->id, 21,15,90,5,30,2021,$user->brand)");
        }
    }
    ////////// 30-12-2021
    //employee script 
    public function allEmployeesForVacatoinTable_new()
    {
        //SELECT * FROM `vacation_balance` where year = 2023 and emp_id In ( select emp_id from vacation_balance WHERE `current_year` >= 6 AND `year` = 2022 )
        $current_year = 2023;
        $brand = $this->brand;
        $employees = $this->db->query(" SELECT * FROM `employees` WHERE status != 1 AND (brand = 1 OR brand = 2) ")->result();
        foreach ($employees as $employee) {
            $balanceData = $this->db->query(" SELECT * FROM `vacation_balance` WHERE year = 2022 and emp_id = $employee->id ");
            if ($balanceData->num_rows() > 0) {
                $previous_year_data = $balanceData->row();
                $previous = $previous_year_data->current_year;
                if ($previous <= 5) {
                    $previous_year = $previous;
                } else {
                    $previous_year = 5;
                }
                //print_r($employees);
                $this->db->query("INSERT INTO vacation_balance (emp_id,current_year,previous_year,sick_leave,maternity_leave,marriage,hajj,year,brand) VALUES ($employee->id,21,$previous_year,15,90,5,30,$current_year,$employee->brand)");
            } else {
                $this->db->query("INSERT INTO vacation_balance (emp_id,current_year,previous_year,sick_leave,maternity_leave,marriage,hajj,year,brand) VALUES ($employee->id,21,0,15,90,5,30,$current_year,$employee->brand)");
            }

        }
    }
    ////////// 
    //missing attendance  
    public function missingAttendance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 145);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
            //body ..
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date']) && isset($_REQUEST['date'])) {
                    $date = date("Y-m-d", strtotime($_REQUEST['date']));
                    if (!empty($_REQUEST['date'])) {
                        array_push($arr2, 0);
                    }

                } else {
                    $date = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($_REQUEST['employee_name'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $employee_name = "";
                }
                $cond1 = "SRVDT LIKE '%$date%'";
                $cond2 = "USRID = '$employee_name'";
                $arr1 = array($cond1, $cond2);
                //print_r($arr1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['missingAttendance'] = $this->hr_model->AllMissingAttendance($data['permission'], $this->user, $arr4);
                } else {
                    $data['missingAttendance'] = $this->hr_model->AllMissingAttendancePages($data['permission'], $this->user, $this->brand, 9, 0);
                }
                $data['total_rows'] = $data['missingAttendance']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllMissingAttendance($data['permission'], $this->user, 1)->num_rows();
                $config['base_url'] = base_url('hr/missingAttendance');
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
                $data['missingAttendance'] = $this->hr_model->AllMissingAttendancePages($data['permission'], $this->user, $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendance/missingAttendance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addMissingAttendance()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendance/addMissingAttendance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addMissingAttendanceForEmployee()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($data['permission']->add == 1 && ($this->role == 31 || $this->role == 46 || $this->role == 21)) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendance/addMissingAttendanceForEmployee.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddMissingAttendance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($permission->add == 1) {
            $userData = $this->db->get_where('users', array('id' => $this->user))->row()->employees_id;
            $date = date_create($_POST['date']);

            // check max number of missing attendance // after 21-4-2023          
            $missing_num = $this->hr_model->getNumOfMissingAttendance($userData, $date);
            if ($missing_num >= 20) {
                $error = "Failed ! You reach Maximum records of missing access ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            }
            if (date("Y-m-d H:i") < $_POST['date']) {
                $error = "Failed ! Date is greater than Today ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            }

            $data['SRVDT'] = date_format($date, 'Y-m-d H:i:s');
            $data['USRID'] = $userData;
            $data['TNAKEY'] = $_POST['TNAKEY'];
            $data['location'] = $_POST['location'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;
            //team coaches exception 
            $title = $this->db->query(" SELECT title FROM employees WHERE id = '$this->emp_id' ")->row()->title;
            $manager = $this->db->query(" SELECT manager FROM employees WHERE id = '$this->emp_id' ")->row()->manager;
            if ($title == 11 or $title == 15 or $title == 16 or $title == 17 or $title == 28 or $title == 37 or $title == 40 or $title == 44 or $title == 48 or $title == 51 or $title == 54 or $title == 56 or $title == 59 or $title == 77 or $title == 93 or $title == 96 or $title == 97 or $title == 98 or $manager == 13 or $manager == 14 or $manager == 120 or $title == 100 or $title == 101 or $title == 104 or $title == 108 or $title == 107 or $title == 41 or $title == 122 or $manager == 25 or $title == 123 or $title == 126 or $title == 125 or $title == 173 or $title == 131 or $title == 148 or $title == 146 or $title == 135 or $title == 163) {
                $data['manager_approval'] = 1;
            }

            // check if attendance already exists with same location
            $checkSameLocation = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $userData . " AND location = " . $_POST['location'] . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date_format($date, 'Y-m-d') . "%' ORDER BY id DESC LIMIT 1")->row();
            if ($checkSameLocation > 0) {
                $error = "Attendance Already Exists ...";
                $error .= "<br/>".$this->hr_model->getTnakeyType($checkSameLocation->TNAKEY)." : ".$checkSameLocation->SRVDT." ( ".$this->hr_model->getLocationType($checkSameLocation->location)." )";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            } else {
                if ($this->db->insert('missing_attendance', $data)) {
                    $missing_id = $this->db->insert_id();
                    $this->hr_model->sendMissingAttendanceRequestMail($data, $this->brand);
                    // add to attendance log
                    if ($data['manager_approval'] == 1) {
                        $employee_data = $this->db->query("SELECT * FROM missing_attendance WHERE id = '$missing_id'")->row();
                        //add to attendance log  
                        $attendance_log_data['SRVDT'] = $employee_data->SRVDT;
                        $attendance_log_data['USRID'] = $employee_data->USRID;
                        $attendance_log_data['TNAKEY'] = $employee_data->TNAKEY;
                        $attendance_log_data['location'] = $employee_data->location;
                        $attendance_log_data['created_at'] = $employee_data->created_at;
                        $attendance_log_data['created_by'] = $employee_data->created_by;

                        // check if exists with differnet location
                        $check = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $userData . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date_format($date, 'Y-m-d') . "%' AND location != $employee_data->location ORDER BY id DESC LIMIT 1")->row();
                        $this->admin_model->addToLoggerDelete('attendance_log', 145, 'id', $check->id, 0, 0, $this->user);
                        $this->db->delete('attendance_log', array('id' => $check->id));
                        // end check
                        if ($this->db->insert('attendance_log', $attendance_log_data)) {

                            $true = "The Record Added To attendance log Successfully";
                            $this->session->set_flashdata('true', $true);
                            redirect(base_url() . "hr/missingAttendance");
                        } else {
                            $error = "Failed To Add The Record Added To attendance log ...";
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "hr/missingAttendance");
                        }
                    }

                    $true = " Missing Attendance Request Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/missingAttendance");
                } else {
                    $error = "Failed To Add Missing Attendance Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/missingAttendance");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddMissingAttendanceForEmployee()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($permission->add == 1) {
            $userData = $this->db->get_where('employees', array('id' => $_POST['emp_id']))->row();
            $date = date_create($_POST['date']);
            if (date("Y-m-d H:i") < $_POST['date']) {
                $error = "Failed ! Date is greater than Today ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            }
            $data['SRVDT'] = date_format($date, 'Y-m-d H:i:s');
            $data['USRID'] = $_POST['emp_id'];
            $data['TNAKEY'] = $_POST['TNAKEY'];
            $data['location'] = $_POST['location'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;
            //team coaches exception 
            $title = $this->db->query(" SELECT title FROM employees WHERE id = '$userData->id' ")->row()->title;
            $manager = $this->db->query(" SELECT manager FROM employees WHERE id = '$userData->id' ")->row()->manager;
            if ($title == 11 or $title == 15 or $title == 16 or $title == 17 or $title == 28 or $title == 37 or $title == 40 or $title == 44 or $title == 48 or $title == 51 or $title == 54 or $title == 56 or $title == 59 or $title == 93 or $title == 96 or $title == 97 or $title == 98 or $manager == 13 or $manager == 14 or $manager == 120 or $title == 100 or $title == 101 or $title == 104 or $title == 108 or $title == 107 or $title == 41 or $title == 122 or $manager == 25) {
                $data['manager_approval'] = 1;
            }

            // check if attendance already exists with same location 
            $checkSameLocation = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $_POST['emp_id'] . " AND location = " . $_POST['location'] . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date_format($date, 'Y-m-d') . "%' ORDER BY id DESC LIMIT 1")->row();
            if ($checkSameLocation > 0) {
                $error = "Attendance Already Exists ...";
                $error .= "<br/>".$this->hr_model->getTnakeyType($checkSameLocation->TNAKEY)." : ".$checkSameLocation->SRVDT." ( ".$this->hr_model->getLocationType($checkSameLocation->location)." )";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            } else {
                if ($this->db->insert('missing_attendance', $data)) {
                    $missing_id = $this->db->insert_id();
                    $this->hr_model->sendMissingAttendanceRequestMail($data, $userData->brand);
                    // add to attendance log
                    if ($data['manager_approval'] == 1) {
                        $employee_data = $this->db->query("SELECT * FROM missing_attendance WHERE id = '$missing_id'")->row();
                        //add to attendance log  
                        $attendance_log_data['SRVDT'] = $employee_data->SRVDT;
                        $attendance_log_data['USRID'] = $employee_data->USRID;
                        $attendance_log_data['TNAKEY'] = $employee_data->TNAKEY;
                        $attendance_log_data['location'] = $employee_data->location;
                        $attendance_log_data['created_at'] = $employee_data->created_at;
                        $attendance_log_data['created_by'] = $employee_data->created_by;

                        // check if exists with differnet location
                        $check = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $_POST['emp_id'] . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date_format($date, 'Y-m-d') . "%' AND location != $employee_data->location ORDER BY id DESC LIMIT 1")->row();
                        $this->admin_model->addToLoggerDelete('attendance_log', 145, 'id', $check->id, 0, 0, $this->user);
                        $this->db->delete('attendance_log', array('id' => $check->id));
                        // end check
                        if ($this->db->insert('attendance_log', $attendance_log_data)) {
                            ////
                            $true = "The Record Added To attendance log Successfully";
                            $this->session->set_flashdata('true', $true);
                            redirect(base_url() . "hr/missingAttendance");
                        } else {
                            $error = "Failed To Add The Record Added To attendance log ...";
                            $this->session->set_flashdata('error', $error);
                            redirect(base_url() . "hr/missingAttendance");
                        }
                    }
                    $true = " Missing Attendance Request Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/missingAttendance");
                } else {
                    $error = "Failed To Add Missing Attendance Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/missingAttendance");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editMissingAttendance()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('missing_attendance', array('id' => $data['id']))->row();
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendance/editMissingAttendance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditMissingAttendance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 145);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $date = date_create($_POST['date']);
            $data['SRVDT'] = date_format($date, 'Y-m-d H:i:s');
            $data['TNAKEY'] = $_POST['TNAKEY'];
            $data['location'] = $_POST['location'];
            $referer = $_POST['referer'];

            // check max number of missing attendance  // after 21-4 
            if ($this->role != 31) {
                $record = $this->db->get_where('missing_attendance', array('id' => $id))->row();
                $missing_num = $this->hr_model->getNumOfMissingAttendance($record->USRID, $date, $id);
                if ($missing_num >= 20) {
                    $error = "Failed ! You reach Maximum records of missing access ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/missingAttendance");
                }
            }
            // check if attendance already exists with same location 
            $checkSameLocation = $this->db->query("SELECT * FROM attendance_log  WHERE USRID = " . $record->USRID . " AND location = " . $_POST['location'] . " AND TNAKEY = " . $_POST['TNAKEY'] . " AND SRVDT like'" . date_format($date, 'Y-m-d') . "%' ORDER BY id DESC LIMIT 1")->row();
            if ($checkSameLocation > 0) {
                $error = "Attendance Already Exists ...";
                $error .= "<br/>".$this->hr_model->getTnakeyType($checkSameLocation->TNAKEY)." : ".$checkSameLocation->SRVDT." ( ".$this->hr_model->getLocationType($checkSameLocation->location)." )";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            } else {
                //add logger 
                $this->admin_model->addToLoggerUpdate('missing_attendance', 145, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('missing_attendance', $data, array('id' => $id))) {
                    $true = "ٌRequest updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    if (!empty($referer)) {
                        redirect($referer);
                    } else {
                        redirect(base_url() . "hr/missingAttendance");
                    }
                } else {
                    $error = "Failed To update request ...";
                    $this->session->set_flashdata('error', $error);
                    if (!empty($referer)) {
                        redirect($referer);
                    } else {
                        redirect(base_url() . "hr/missingAttendance");
                    }
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deleteMissingAttendance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['i']);
            $this->admin_model->addToLoggerDelete('missing_attendance', 145, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('missing_attendance', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/missingAttendance");
            } else {
                $error = "Failed To Delete Record...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/missingAttendance");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    //////////
    //18/12/2019

    ////////////////////// 

    /////start social insurance 
    public function socialInsurance()
    {
        $check = $this->admin_model->checkPermission($this->role, 152);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['insurance_number'])) {
                    $array = str_split($_REQUEST['insurance_number']);
                    $insurance_number = implode(" ", $array);
                    if (!empty($insurance_number)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $insurance_number = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $employee_name = "";
                }

                $cond1 = "insurance_number LIKE '%$insurance_number%'";
                $cond2 = "employee_id = '$employee_name'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['socialInsurance'] = $this->hr_model->AllSocialInsurance($data['permission'], $this->user, $arr4);

                } else {
                    $data['socialInsurance'] = $this->hr_model->AllSocialInsurancePages($data['permission'], $this->user, 9, 0);

                }
                $data['total_rows'] = $data['socialInsurance']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllSocialInsurance($data['permission'], $this->user, 1)->num_rows();
                $config['base_url'] = base_url('hr/socialInsurance/');
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

                $data['socialInsurance'] = $this->hr_model->AllSocialInsurancePages($data['permission'], $this->user, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/socialInsurance.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addSocialInsurance()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/addSocialInsurance.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddSocialInsurance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
        if ($permission->add == 1) {
            // $userData = $this->db->get_where('users',array('id'=>$this->user))->row()->employees_id;
            $data['employee_id'] = $_POST['employee'];
            $data['year'] = $_POST['year'];
            $date = date_create($_POST['date']);
            // $data['deactivation_date'] = date_format($date,'Y-m-d H:i:s'); 
            $data['deactivation_date'] = $_POST['deactivation_date'];
            $data['activation_date'] = $_POST['activation_date'];
            $data['basic'] = $_POST['basic'];
            $data['variable'] = $_POST['variable'];
            //get social insurance id 
            $array = array($_POST['1'], $_POST['2'], $_POST['3'], $_POST['4'], $_POST['5'], $_POST['6'], $_POST['7'], $_POST['8'], $_POST['9']);
            $data['insurance_number'] = implode(" ", $array);
            $data['currency'] = $_POST['currency'];
            $data['country'] = $_POST['country'];
            $data['total_deductions'] = $_POST['total_deductions'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;

            if ($this->db->insert('social_insurance', $data)) {
                $true = " Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/socialInsurance");
            } else {
                $error = "Failed To Add The Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/socialInsurance");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function getGenderAndDateOfBirth()
    {
        $employee_id = $_POST['employee_id'];
        $data = $this->db->query("SELECT * FROM employees WHERE id = '$employee_id'")->row();
        echo json_encode($data);
    }

    public function editSocialInsurance()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('social_insurance', array('id' => $data['id']))->row();
            $data['insurance_number'] = explode(" ", $data['row']->insurance_number);
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/editSocialInsurance.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditSocialInsurance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 152);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $data['employee_id'] = $_POST['employee'];
            $data['year'] = $_POST['year'];
            $date = date_create($_POST['date']);
            //$data['deactivation_date'] = date_format($date,'Y-m-d H:i:s');
            $data['deactivation_date'] = $_POST['deactivation_date'];
            $data['activation_date'] = $_POST['activation_date'];
            $data['basic'] = $_POST['basic'];
            $data['variable'] = $_POST['variable'];
            $array = array($_POST['1'], $_POST['2'], $_POST['3'], $_POST['4'], $_POST['5'], $_POST['6'], $_POST['7'], $_POST['8'], $_POST['9']);
            $data['insurance_number'] = implode(" ", $array);
            $data['currency'] = $_POST['currency'];
            $data['country'] = $_POST['country'];
            $data['total_deductions'] = $_POST['total_deductions'];
            $referer = $_POST['referer'];
            //add logger 
            $this->admin_model->addToLoggerUpdate('social_insurance', 152, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('social_insurance', $data, array('id' => $id))) {
                $true = "Record updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/socialInsurance");
                }
            } else {
                $error = "Failed To update The Record ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/socialInsurance");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteSocialInsurance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['i']);
            $this->admin_model->addToLoggerDelete('social_insurance', 152, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('social_insurance', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                //redirect(base_url()."hr/socialInsurance");   
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete The Record...";
                $this->session->set_flashdata('error', $error);
                //redirect(base_url()."hr/socialInsurance");  
                redirect($_SERVER['HTTP_REFERER']);

            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportSocialInsurance()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=socialInsurance.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 152);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
            //body ..
            $arr2 = array();
            if (isset($_REQUEST['insurance_number'])) {
                $array = str_split($_REQUEST['insurance_number']);
                $insurance_number = implode(" ", $array);
                if (!empty($insurance_number)) {
                    array_push($arr2, 0);
                }
            } else {
                $insurance_number = "";
            }
            if (isset($_REQUEST['employee_name'])) {
                $employee_name = $_REQUEST['employee_name'];
                if (!empty($employee_name)) {
                    array_push($arr2, 1);
                }
            } else {
                $employee_name = "";
            }

            $cond1 = "insurance_number LIKE '%$insurance_number%'";
            $cond2 = "employee_id = '$employee_name'";

            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            // print_r($arr4);     
            if ($arr_1_cnt > 0) {
                $data['socialInsurance'] = $this->hr_model->AllSocialInsurance($data['permission'], $this->user, $arr4);

            } else {
                $data['socialInsurance'] = $this->hr_model->AllSocialInsurance($data['permission'], $this->user, 9, 0);

            }
            $this->load->view('hr/exportSocialInsurance.php', $data);

            // //Pages ..
        } else {
            echo "You have no permission to access this page";
        }
    }

    ///////////

    public function medicalInsurance()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 151);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 151);

            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['employee_id'])) {
                    $employee_id = $_REQUEST['employee_id'];
                    if (!empty($employee_id)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $employee_id = "";
                }


                $cond1 = "employee_id LIKE '%$employee_id%'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);


                if ($arr_1_cnt > 0) {
                    $data['medical'] = $this->hr_model->AllMedicalInsurance($this->brand, $arr4);
                } else {
                    $data['medical'] = $this->hr_model->AllMedicalInsurancePages($this->brand, 9, 0);
                }
                $data['total_rows'] = $data['medical']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllMedicalInsurance($this->brand, 1)->num_rows();
                $config['base_url'] = base_url('hr/medicalInsurance');
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

                $data['medical'] = $this->hr_model->AllMedicalInsurancePages($this->brand, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/medicalInsurance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function addMedicalInsurance()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 151);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addMedicalInsurance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddMedicalInsurance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 151);
        if ($permission->add == 1) {
            $data['employee_id'] = $_POST['employee_id'];
            $data['year'] = $_POST['year'];
            $data['crt'] = $_POST['crt'];
            $data['activation_date'] = $_POST['activation_date'];
            $data['deduction'] = $_POST['deduction'];
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $members = $_POST['members'];
            if ($this->db->insert('medical_insurance', $data)) {
                if ($members > 0) {
                    $sqlArray = array();
                    $dataFamily['employee_id'] = $_POST['employee_id'];
                    $dataFamily['year'] = $_POST['year'];
                    for ($i = 1; $i <= $members; $i++) {
                        $dataFamily['name'] = $_POST['name_' . $i];
                        $dataFamily['birth_date'] = $_POST['birth_date_' . $i];
                        $dataFamily['activation_date'] = $_POST['activation_date_' . $i];
                        $dataFamily['type'] = $_POST['type_' . $i];
                        $dataFamily['fees'] = $_POST['fees_' . $i];
                        $dataFamily['created_by'] = $this->user;
                        $dataFamily['created_at'] = date("Y-m-d H:i:s");
                        array_push($sqlArray, $dataFamily);
                    }
                    if ($this->db->insert_batch('medical_family_members', $sqlArray)) {
                        $true = "Added Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "hr/medicalInsurance");
                    } else {
                        $error = "Failed To Add Family Member ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "hr/medicalInsurance");
                    }
                } else {
                    $true = "Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/medicalInsurance");
                }
            } else {
                $error = "Failed To Add Medical Insurance ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/medicalInsurance");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editMedicalInsurance()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 151);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['medical'] = $this->db->get_where('medical_insurance', array('id' => $data['id']))->row();
            $data['family'] = $this->db->get_where('medical_family_members', array('employee_id' => $data['medical']->employee_id))->result();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editMedicalInsurance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function removeFamilyMemberTable()
    {
        $id = $_POST['id'];

        if ($this->db->delete('medical_family_members', array('id' => $id))) {
            echo "1";
        } else {
            echo "0";
        }
    }

    public function doEditMedicalInsurance()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 151);
        if ($data['permission']->edit == 1) {
            //Medical Insurance ..
            $id = base64_decode($_POST['id']);
            $medical['employee_id'] = $_POST['employee_id'];
            $medical['year'] = $_POST['year'];
            $medical['crt'] = $_POST['crt'];
            $medical['activation_date'] = $_POST['activation_date'];
            $medical['deduction'] = $_POST['deduction'];
            // Members Table ..
            $employee_id_old = base64_decode($_POST['employee_id_old']);
            $membersTable = $this->db->get_where('medical_family_members', array('employee_id' => $employee_id_old))->result();
            foreach ($membersTable as $membersTable) {
                $dataMemberTable['name'] = $_POST['name_table_' . $membersTable->id];
                $dataMemberTable['birth_date'] = $_POST['birth_date_table_' . $membersTable->id];
                $dataMemberTable['activation_date'] = $_POST['activation_date_table_' . $membersTable->id];
                $dataMemberTable['type'] = $_POST['type_table_' . $membersTable->id];
                $dataMemberTable['fees'] = $_POST['fees_table_' . $membersTable->id];
                $dataMemberTable['employee_id'] = $medical['employee_id'];
                $dataMemberTable['year'] = $medical['year'];
                $this->admin_model->addToLoggerUpdate('medical_family_members', 151, 'id', $membersTable->id, 0, 0, $this->user);
                $this->db->update('medical_family_members', $dataMemberTable, array('id' => $membersTable->id));
            }
            // New Members Add ..
            $newMembers = $_POST['new_res'];
            $sqlArray = array();
            for ($i = 1; $i < $newMembers; $i++) {
                $dataFamily['name'] = $_POST['name_' . $i];
                $dataFamily['birth_date'] = $_POST['birth_date_' . $i];
                $dataFamily['activation_date'] = $_POST['activation_date_' . $i];
                $dataFamily['type'] = $_POST['type_' . $i];
                $dataFamily['fees'] = $_POST['fees_' . $i];
                $dataFamily['employee_id'] = $medical['employee_id'];
                $dataFamily['year'] = $medical['year'];
                array_push($sqlArray, $dataFamily);
            }
            $this->db->insert_batch('medical_family_members', $sqlArray);
            //Update Medical ..
            $this->admin_model->addToLoggerUpdate('medical_insurance', 151, 'id', $id, 0, 0, $this->user);
            $this->db->update('medical_insurance', $medical, array('id' => $id));
            $true = "Edited Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "hr/medicalInsurance");
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deleteMedicalInsurance()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 151);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['t']);
            $employee_id = base64_decode($_GET['e']);
            $this->admin_model->addToLoggerDelete('medical_insurance', 151, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('medical_insurance', array('id' => $id))) {
                $this->admin_model->addToLoggerDelete('medical_family_members', 151, 'employee_id', $employee_id, 0, 0, $this->user);
                $this->db->delete('medical_family_members', array('employee_id' => $employee_id));
                $true = "Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/medicalInsurance");
            } else {
                $error = "Failed To Delete...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/medicalInsurance");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function hrReports()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 159);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 159);
            //body ..
            $brand = $this->brand;
            if (isset($_GET['search'])) {
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

                if (isset($_REQUEST['report'])) {
                    $data['report'] = $_REQUEST['report'];
                    if ($data['report'] == 1) {
                        $data['manpower'] = $this->db->query(" SELECT * FROM `department` HAVING brand = '$this->brand' ");

                    } elseif ($data['report'] == 2) {
                        $data['gender'] = $this->db->query(" SELECT * FROM `employees` HAVING brand = '$this->brand' ");
                    } elseif ($data['report'] == 3) {
                        $data['turnover'] = $this->db->query(" SELECT * FROM `employees` WHERE resignation_date BETWEEN '$date_from' AND '$date_to' HAVING brand = '$this->brand' ");

                    } elseif ($data['report'] == 4) {

                    }
                }
            } else {
                $data['report'] = 0;
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/hrReports.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function holidaysPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 160);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 160);

            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['holiday_name'])) {
                    $holiday_name = $_REQUEST['holiday_name'];
                    if (!empty($holiday_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $holiday_name = "";
                }
                $cond1 = "holiday_name LIKE '%$holiday_name%'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);


                if ($arr_1_cnt > 0) {
                    $data['holiday'] = $this->hr_model->AllHolidayPlan($arr4);
                } else {
                    $data['holiday'] = $this->hr_model->AllHolidayPlanPages(9, 0);
                }
                $data['total_rows'] = $data['holiday']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllHolidayPlan(1)->num_rows();
                $config['base_url'] = base_url('hr/holidaysPlan');
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

                $data['holiday'] = $this->hr_model->AllHolidayPlanPages($limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/holidaysPlan.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addHolidaysPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 160);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/addHolidaysPlan.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddHolidaysPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 160);
        if ($permission->add == 1) {
            $sqlAray = array();
            $new_pair = $_POST['new_pair'];
            for ($i = 1; $i < $new_pair; $i++) {
                $data['holiday_name'] = $_POST['holiday_name'];
                $data['holiday_date'] = $_POST['holiday_date_' . $i];
                $data['created_at'] = date("Y-m-d H:i:s");
                $data['created_by'] = $this->user;
                array_push($sqlAray, $data);
            }
            if ($this->db->insert_batch('holidays_plan', $sqlAray)) {
                $true = " Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/holidaysPlan");
            } else {
                $error = "Failed To Add The Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/holidaysPlan");
            }

        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editHolidaysPlan()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 160);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('holidays_plan', array('id' => $data['id']))->row();
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/editHolidaysPlan.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditHolidaysPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 160);
        if ($check) {
            $id = base64_decode($_POST['id']);
            $data['holiday_name'] = $_POST['holiday_name'];
            $data['holiday_date'] = $_POST['holiday_date'];
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->user;
            $referer = $_POST['referer'];
            //add logger 
            $this->admin_model->addToLoggerUpdate('holidays_plan', 160, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('holidays_plan', $data, array('id' => $id))) {
                $true = "Record updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/holidaysPlan");
                }
            } else {
                $error = "Failed To update The Record ...";
                $this->session->set_flashdata('error', $error);
                if (!empty($referer)) {
                    redirect($referer);
                } else {
                    redirect(base_url() . "hr/holidaysPlan");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteHolidaysPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 160);
        if ($permission->delete == 1) {
            $id = base64_decode($_GET['i']);
            $this->admin_model->addToLoggerDelete('holidays_plan', 160, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('holidays_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/holidaysPlan");
                // redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Delete The Record...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/holidaysPlan");
                // redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function validateHolidayDate()
    {
        $holiday_date = $_POST['holiday_date'];
        $data = $this->db->query("SELECT * FROM holidays_plan WHERE holiday_date = '$holiday_date'")->num_rows();
        echo $data;
    }


    //

    public function viewVacationRequests()
    {
        $check = $this->admin_model->checkPermission($this->role, 162);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 162);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                    if (!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])) {
                        $data['date_from'] = $date_from;
                        $data['date_to'] = $date_to;
                        array_push($arr2, 0);
                    }
                } else {
                    $date_to = "";
                    $date_from = "";
                }
                if (isset($_REQUEST['emp_id'])) {
                    $data['emp_id'] = $emp_id = $_REQUEST['emp_id'];
                    if (!empty($_REQUEST['emp_id'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $emp_id = "";
                }
                if (isset($_REQUEST['type_of_vacation'])) {
                    $data['type_of_vacation'] = $type_of_vacation = $_REQUEST['type_of_vacation'];
                    if (!empty($_REQUEST['type_of_vacation'])) {
                        array_push($arr2, 2);
                    }
                } else {
                    $type_of_vacation = "";
                }
                $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";
                $cond2 = "emp_id = '$emp_id'";
                $cond3 = "type_of_vacation = '$type_of_vacation'";
                $arr1 = array($cond1, $cond2, $cond3);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['vacation_requests'] = $this->hr_model->AllVacationRequests($arr4);
                } else {
                    $data['vacation_requests'] = $this->hr_model->AllVacationRequestsPages(9, 0);
                }
                $data['total_rows'] = $data['vacation_requests']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllVacationRequests(1)->num_rows();
                $config['base_url'] = base_url('hr/viewVacationRequests/');
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

                $data['vacation_requests'] = $this->hr_model->AllVacationRequestsPages($limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewVacationRequests.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function exportViewVacationRequests()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=ViewVacationRequests.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 162);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 162);
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
            if (isset($_REQUEST['emp_id'])) {
                $emp_id = $_REQUEST['emp_id'];
                if (!empty($_REQUEST['emp_id'])) {
                    array_push($arr2, 1);
                }
            } else {
                $emp_id = "";
            }
            $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $cond2 = "emp_id = '$emp_id'";
            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['vacation_requests'] = $this->hr_model->AllVacationRequests($arr4);
            } else {
                // $data['vacation_requests'] = $this->hr_model->AllVacationRequestsPages(9,0);
                $data['vacation_requests'] = $this->db->query(" SELECT * FROM `vacation_transaction` ORDER BY id DESC ");
            }
            $this->load->view('hr/exportViewVacationRequests.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }
    //  

    ///missing attendance 

    public function missingAttendanceApprovalForManager_old()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);

        $data['manager_approval'] = $_POST['manager_approval'];
        if ($this->db->update('missing_attendance', $data, array('id' => $_POST['id']))) {
            $true = "Your Action Added Successfully";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To Add your Action ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function missingAttendanceApprovalForManager()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        $id = $_POST['id'];
        $data['manager_approval'] = $_POST['manager_approval'];
        if ($this->db->update('missing_attendance', $data, array('id' => $_POST['id']))) {
            if ($data['manager_approval'] == 1) {
                $employee_data = $this->db->query("SELECT * FROM missing_attendance WHERE id = '$id'")->row();
                //add to attendance log  
                $attendance_log_data['SRVDT'] = $employee_data->SRVDT;
                $attendance_log_data['USRID'] = $employee_data->USRID;
                $attendance_log_data['TNAKEY'] = $employee_data->TNAKEY;
                $attendance_log_data['location'] = $employee_data->location;
                $attendance_log_data['created_at'] = $employee_data->created_at;
                $attendance_log_data['created_by'] = $employee_data->created_by;
                // check if exists with differnet location
                if ($employee_data->location != null)
                    $check = $this->db->query("SELECT * FROM attendance_log WHERE USRID = " . $employee_data->USRID . " AND TNAKEY = " . $employee_data->TNAKEY . " AND SRVDT like'" . date_format(date_create($employee_data->SRVDT), 'Y-m-d') . "%' AND location != $employee_data->location ORDER BY id DESC LIMIT 1")->row();
                else
                    $check = $this->db->query("SELECT * FROM attendance_log WHERE USRID = " . $employee_data->USRID . " AND TNAKEY = " . $employee_data->TNAKEY . " AND SRVDT like'" . date_format(date_create($employee_data->SRVDT), 'Y-m-d') . "%'  ORDER BY id DESC LIMIT 1")->row();
               if(!empty($check)){                    
                    $this->admin_model->addToLoggerDelete('attendance_log', 145, 'id', $check->id, 0, 0, $this->user);
                    $this->db->delete('attendance_log', array('id' => $check->id));
                }
                // end check
                if ($this->db->insert('attendance_log', $attendance_log_data)) {
                    ////
                    $true = "The Record Added To attendance log Successfully";
                    $this->session->set_flashdata('true', $true);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $error = "Failed To Add The Record Added To attendance log ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $true = "Your Action Added Successfully";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $error = "Failed To Add your Action ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function missingAttendanceApprovalForHR()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
        $id = $_POST['id'];
        $data['hr_approval'] = $_POST['hr_approval'];
        if ($this->db->update('missing_attendance', $data, array('id' => $_POST['id']))) {
            if ($data['hr_approval'] == 1) {
                $employee_data = $this->db->query("SELECT * FROM missing_attendance WHERE id = '$id'")->row();
                //add to attendance log  
                $attendance_log_data['SRVDT'] = $employee_data->SRVDT;
                $attendance_log_data['USRID'] = $employee_data->USRID;
                $attendance_log_data['TNAKEY'] = $employee_data->TNAKEY;
                $attendance_log_data['created_at'] = $employee_data->created_at;
                $attendance_log_data['created_by'] = $employee_data->created_by;
                if ($this->db->insert('attendance_log', $attendance_log_data)) {
                    ////
                    $true = "The Record Added To attendance log Successfully";
                    $this->session->set_flashdata('true', $true);
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $error = "Failed To Add The Record Added To attendance log ...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $true = "Your Action Added Successfully";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }

        } else {
            $error = "Failed To Add your Action ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    ///

    public function timeTable()
    {
        $check = $this->admin_model->checkPermission($this->role, 172);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 162);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                //  $arr2 = array();
                //   if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])){
                //      $date_from = date("Y-m-d", strtotime($_REQUEST['date_from']));
                //      $date_to = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                //      if(!empty($_REQUEST['date_from']) && !empty($_REQUEST['date_to'])){ array_push($arr2,0); }
                //  }else{
                //      $date_to = "";
                //      $date_from = "";
                //  }
                //  if(isset($_REQUEST['emp_id'])){
                //      $emp_id = $_REQUEST['emp_id'];
                //      if(!empty($_REQUEST['emp_id'])){ array_push($arr2,1); }
                //  }else{
                //      $emp_id= "";
                //  }
                //  $cond1 = "created_at BETWEEN '$date_from' AND '$date_to' ";  
                //  $cond2 = "emp_id = '$emp_id'";
                //  $arr1 = array($cond1,$cond2);
                //  $arr_1_cnt = count($arr2);
                //  $arr3 = array();
                //  for($i=0; $i<$arr_1_cnt; $i++ ){
                //  array_push($arr3,$arr1[$arr2[$i]]);
                //  }
                //  $arr4 = implode(" and ",$arr3);
                //  if($arr_1_cnt > 0){
                //      $data['vacation_requests'] = $this->hr_model->AllVacationRequests($arr4);
                // }else{
                //      $data['vacation_requests'] = $this->hr_model->AllVacationRequestsPages(9,0);
                //  }
                //  $data['total_rows'] = $data['vacation_requests']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllVacationRequests(1)->num_rows();
                $config['base_url'] = base_url('hr/timeTable/');
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

                //$data['vacation_requests'] = $this->hr_model->AllVacationRequestsPages($limit,$offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('hr/timeTable.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    ///

    //for approved requests 
    public function editApprovedRequest()
    {
        $check = $this->admin_model->checkPermission($this->role, 162);
        if ($check) {
            $id = $_POST['row_id'];
            $empId = $_POST['emp_id'];
            $days = $_POST['days'];
            $type_of_vacation = $_POST['type_of_vacation'];
            $data['type_of_vacation'] = $_POST['type_of_vacation'];
            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['updated_by'] = $this->user;
            $credite = $this->db->get_where('vacation_balance', array('emp_id' => $empId))->row();
            if ($type_of_vacation == 1) {
                //from casual to annual
                $updated_balance['annual_leave'] = $credite->annual_leave + $days;
                $updated_balance['casual_leave'] = $credite->casual_leave - $days;
                $this->admin_model->addToLoggerUpdate('vacation_balance', 162, 'emp_id', $empId, 104, 104, $this->user);
                $this->db->update('vacation_balance', $updated_balance, array('emp_id' => $empId, 'year' => $credite->year));
                $this->admin_model->addToLoggerUpdate('vacation_transaction', 162, 'id', $id, 104, 104, $this->user);
                if ($this->db->update('vacation_transaction', $data, array('id' => $id))) {
                    $true = "Record Updated Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/viewVacationRequests");
                } else {
                    $error = "Failed To update The Record ...";
                    $this->session->set_flashdata('error', $error);

                    redirect(base_url() . "hr/viewVacationRequests");
                }
            } else {
                if ($type_of_vacation == 2 and $days <= 2) {
                    //from annual to casual
                    $updated_balance['annual_leave'] = $credite->annual_leave - $days;
                    $updated_balance['casual_leave'] = $credite->casual_leave + $days;
                    $this->admin_model->addToLoggerUpdate('vacation_balance', 162, 'emp_id', $empId, 104, 104, $this->user);
                    $this->db->update('vacation_balance', $updated_balance, array('emp_id' => $empId, 'year' => $credite->year));
                    $this->admin_model->addToLoggerUpdate('vacation_transaction', 162, 'id', $id, 104, 104, $this->user);
                    if ($this->db->update('vacation_transaction', $data, array('id' => $id))) {
                        $true = "Record Updated Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "hr/viewVacationRequests");
                    } else {
                        $error = "Failed To update The Record ...";
                        $this->session->set_flashdata('error', $error);

                        redirect(base_url() . "hr/viewVacationRequests");
                    }
                } else {
                    $error = "you can't convert requests greater than 2 days to casual ...";
                    $this->session->set_flashdata('error', $error);

                    redirect(base_url() . "hr/viewVacationRequests");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }

    }

    public function rejectApprovedRequest()
    {
        $check = $this->admin_model->checkPermission($this->role, 162);
        if ($check) {
            $year = date("Y");
            $month = date('m');
            $id = $_POST['row_id'];
            $empId = $_POST['emp_id'];
            $days = $_POST['days'];
            $type_of_vacation = $_POST['type_of_vacation'];
            $data['type_of_vacation'] = $_POST['type_of_vacation'];
            $data['status'] = 0;
            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['updated_by'] = $this->user;
            $credite = $this->db->get_where('vacation_balance', array('emp_id' => $empId, 'year' => $year))->row();
            $this->admin_model->addToLoggerUpdate('vacation_balance', 162, 'emp_id', $empId, 105, 105, $this->user);
            $this->admin_model->addToLoggerUpdate('vacation_transaction', 162, 'id', $id, 105, 105, $this->user);

            if ($type_of_vacation == 1) {
                // annual                   
                if ($month <= 3) {

                    if ($days + $credite->current_year + $credite->casual_leave > 21) {
                        $temp1 = 21 - ($credite->current_year + $credite->casual_leave);
                        $temp2 = $days - $temp1;
                        $updated_balance['current_year'] = $credite->current_year + $temp1;
                        $updated_balance['previous_year'] = $credite->previous_year + $temp2;

                    } else {
                        $updated_balance['current_year'] = $credite->current_year + $days;
                    }
                } else {
                    $updated_balance['current_year'] = $credite->current_year + $days;
                }

                $updated_balance['annual_leave'] = $credite->annual_leave - $days;


            } elseif ($type_of_vacation == 2) {
                // casual
                $updated_balance['casual_leave'] = $credite->casual_leave - $days;
                $updated_balance['current_year'] = $credite->current_year + $days;

            } elseif ($type_of_vacation == 3) {
                //for sick leave
                $updated_balance['sick_leave'] = $credite->sick_leave + $days;

            } elseif ($type_of_vacation == 4) {
                //for mariage leave
                $updated_balance['marriage'] = $credite->marriage + $days;

            }

            if ($type_of_vacation == 1 || $type_of_vacation == 2 || $type_of_vacation == 3 || $type_of_vacation == 4) {
                $this->db->update('vacation_balance', $updated_balance, array('emp_id' => $empId, 'year' => $year));
            }

            if ($this->db->update('vacation_transaction', $data, array('id' => $id))) {
                $true = "Record Updated Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/viewVacationRequests");
            } else {
                $error = "Failed To update The Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/viewVacationRequests");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    /// test new designe 

    public function socialInsurance_test()
    {
        $check = $this->admin_model->checkPermission($this->role, 152);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
            //body ..
            $data['user'] = $this->user;
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['insurance_number'])) {
                    $array = str_split($_REQUEST['insurance_number']);
                    $insurance_number = implode(" ", $array);
                    if (!empty($insurance_number)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $insurance_number = "";
                }
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $employee_name = "";
                }

                $cond1 = "insurance_number LIKE '%$insurance_number%'";
                $cond2 = "employee_id = '$employee_name'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                // print_r($arr4);     
                if ($arr_1_cnt > 0) {
                    $data['socialInsurance'] = $this->hr_model->AllSocialInsurance($data['permission'], $this->user, $arr4);

                } else {
                    $data['socialInsurance'] = $this->hr_model->AllSocialInsurancePages($data['permission'], $this->user, 9, 0);

                }
                $data['total_rows'] = $data['socialInsurance']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllSocialInsurance($data['permission'], $this->user, 1)->num_rows();
                $config['base_url'] = base_url('hr/socialInsurance/');
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

                $data['socialInsurance'] = $this->hr_model->AllSocialInsurancePages($data['permission'], $this->user, $limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/socialInsurance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addSocialInsurance_test()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addSocialInsurance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editSocialInsurance_test()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 152);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('social_insurance', array('id' => $data['id']))->row();
            $data['insurance_number'] = explode(" ", $data['row']->insurance_number);
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editSocialInsurance.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function holidaysPlan_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 160);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 160);

            //body ..

            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['holiday_name'])) {
                    $holiday_name = $_REQUEST['holiday_name'];
                    if (!empty($holiday_name)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $holiday_name = "";
                }
                $cond1 = "holiday_name LIKE '%$holiday_name%'";
                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);


                if ($arr_1_cnt > 0) {
                    $data['holiday'] = $this->hr_model->AllHolidayPlan($arr4);
                } else {
                    $data['holiday'] = $this->hr_model->AllHolidayPlanPages(9, 0);
                }
                $data['total_rows'] = $data['holiday']->num_rows();
            } else {
                $limit = 10;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->hr_model->AllHolidayPlan(1)->num_rows();
                $config['base_url'] = base_url('hr/holidaysPlan');
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

                $data['holiday'] = $this->hr_model->AllHolidayPlanPages($limit, $offset);
                $data['total_rows'] = $count;
            }
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/holidaysPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addHolidaysPlan_test()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 160);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addHolidaysPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editHolidaysPlan_test()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 160);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('holidays_plan', array('id' => $data['id']))->row();
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editHolidaysPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    ///


    public function attendance_test()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 145);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 145);
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
                if (isset($_REQUEST['user'])) {
                    $user = $_REQUEST['user'];
                    if (!empty($_REQUEST['user'])) {
                        array_push($arr2, 1);
                    }
                } else {
                    $user = "";
                }
                $cond1 = "DATE(l.SRVDT) BETWEEN '$date_from' AND '$date_to'";
                $cond2 = "USRID = '$user'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                $data['attendance'] = $this->hr_model->attendance($data['permission'], $arr4);
                //print_r($data['attendance']);
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/attendanceFalaq.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    ////


    public function addVacation_test()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addVacationRequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }



    public function editVacationRequest_test()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($data['permission']->add == 1) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['id'] = base64_decode($_GET['i']);
            $data['row'] = $this->db->get_where('vacation_transaction', array('id' => $data['id']))->row();
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editVacationRequest.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function pmVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 180);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 180);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['pm_vacation_plan'] = $this->hr_model->AllPmVacationPlan($data['permission'], $group_id);
            //$data['pm_vacation_plan'] = $this->db->query("SELECT * FROM `pm_vacation_plan` WHERE brand = '$this->brand' AND region = '$region' ");
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/pmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewPmVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 180);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 180);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['pm_vacation_plan'] = $this->hr_model->AllPmVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewPmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addPmVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 180);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            //$region =  $this->db->query("SELECT region_id from employees WHERE id = '$this->emp_id' ")->row()->region_id;


            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            // print_r($data['region']); die();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addPmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddPmVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 180);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/pmVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/pmVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editPmVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 180);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editPmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditPmVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 180);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 180, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/pmVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/pmVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deletePmVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 180);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 180, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/pmVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/pmVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function calculateRequestedDaysForPmVacationPlane()
    {
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $quarter = $_POST['quarter'];
        $edit = $_POST['edit'];
        $id = $_POST['id'];
        $requested_days = $this->hr_model->getRequestedDays($date_from, $date_to);
        $totalOldRequests = $this->hr_model->calculateRequestedDaysForPmVacationPlane($this->user, $quarter, $edit, $id);
        $data = array("totalOldRequests" => $totalOldRequests, "requested_days" => $requested_days);
        echo json_encode($data);
        // echo $data ;
    }

    public function checkForPmsVacationPlansAtSameRegion()
    {
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $group_id = $_POST['group_id'];
        $edit = $_POST['edit'];
        $id = $_POST['id'];
        $data = $this->hr_model->checkForPmsVacationPlansAtSameRegion($date_from, $date_to, $group_id, $edit, $id);
        echo $data;
    }
    //
    // Vm Vactions Plan
    public function vmVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 182);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 182);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['vm_vacation_plan'] = $this->hr_model->AllVmVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/vmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewVmVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 182);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 182);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['vm_vacation_plan'] = $this->hr_model->AllVmVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewVmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addVmVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 182);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addVmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddVmVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 182);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/vmVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vmVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editVmVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 182);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editVmVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditVmVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 182);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 182, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/vmVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vmVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteVmVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 182);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 182, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/vmVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vmVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // qality assurnce vacation plan
    public function qaVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 183);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 183);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['qa_vacation_plan'] = $this->hr_model->AllQaVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/qaVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewQaVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 183);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 183);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['qa_vacation_plan'] = $this->hr_model->AllQaVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewQaVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addQaVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 183);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addQaVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddQaVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 183);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/qaVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/qaVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editQaVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 183);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editQaVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditQaVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 183);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 183, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/qaVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/qaVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteQaVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 183);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 183, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/qaVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/qaVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }




    // automation vacation plan
    public function automationVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 185);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 185);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['automation_vacation_plan'] = $this->hr_model->AllAutomationVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/automationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewAutomationVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 185);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 185);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['automation_vacation_plan'] = $this->hr_model->AllAutomationVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewAutomationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addAutomationVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 185);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addAutomationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddAutomationVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 185);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/automationVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/automationVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editAutomationVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 185);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editAutomationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditAutomationVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 185);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 185, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/automationVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/automationVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteAutomationVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 185);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 185, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/automationVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/automationVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // Translation Vactions Plan
    public function translationVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 188);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 188);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['translation_vacation_plan'] = $this->hr_model->AllTranslationVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/translationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewTranslationVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 188);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 188);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['translation_vacation_plan'] = $this->hr_model->AllTranslationVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewTranslationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addTranslationVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 188);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addTranslationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddTranslationVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 188);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/translationVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/translationVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editTranslationVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 188);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editTranslationVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditTranslationVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 188);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 188, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/translationVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/translationVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteTranslationVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 188);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 188, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/translationVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/translationVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    // DTP Vactions Plan
    public function dtpVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 186);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 186);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['dtp_vacation_plan'] = $this->hr_model->AllDTPVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/dtpVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewDTPVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 186);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 186);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['dtp_vacation_plan'] = $this->hr_model->AllDTPVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewDTPVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addDTPVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 186);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addDTPVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddDTPVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 186);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/dtpVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/dtpVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editDTPVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 186);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editDTPVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditDTPVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 186);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 186, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/dtpVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/dtpVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteDTPVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 186);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 186, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/dtpVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/dtpVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    // LE Vactions Plan
    public function leVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 187);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 187);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['le_vacation_plan'] = $this->hr_model->AllLEVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/leVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function viewLEVacationPlan()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 187);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 187);
            //body ..
            $group_id = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            $data['le_vacation_plan'] = $this->hr_model->AllLEVacationPlan($data['permission'], $group_id);
            //Pages ..

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/viewLEVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addLEVacationPlan()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 187);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addLEVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddLEVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 187);
        if ($permission->add == 1) {
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");

            if ($this->db->insert('pm_vacation_plan', $data)) {
                $true = "Record Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/leVacationPlan");
            } else {
                $error = "Failed To Add Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/leVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editLEVacationPlan()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 187);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('pm_vacation_plan', array('id' => $data['id']))->row();
            $data['group_id'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row()->group_id;

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/editLEVacationPlan.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditLEVacationPlan()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 187);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['date_from'] = $_POST['date_from'];
            $data['date_to'] = $_POST['date_to'];
            $requested_days = $this->hr_model->getRequestedDays($data['date_from'], $data['date_to']);
            $data['requested_days'] = $requested_days;
            $data['group_id'] = $this->db->query("SELECT group_id from employees WHERE id = '$this->emp_id' ")->row()->group_id;
            $data['brand'] = $this->brand;
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $this->admin_model->addToLoggerUpdate('pm_vacation_plan', 187, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('pm_vacation_plan', $data, array('id' => $id))) {
                $true = "Record Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/leVacationPlan");
            } else {
                $error = "Failed To Edit Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/leVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteLEVacationPlan($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 187);
        if ($check) {
            $this->admin_model->addToLoggerDelete('pm_vacation_plan', 187, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('pm_vacation_plan', array('id' => $id))) {
                $true = "Record Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "hr/leVacationPlan");
            } else {
                $error = "Failed To Delete Record ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/leVacationPlan");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    // Vacation Plan Requests
    public function vacationPlanRequests()
    {
        $check = $this->admin_model->checkPermission($this->role, 189);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 189);
            //body ..
            $limit = 10;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $filter['e.manager ='] = $this->emp_id;
            $data['vacations'] = $this->hr_model->getVacationRequest($filter, $limit, $offset);
        } else {
            echo "You have no permission to access this page";
        }
    }

    // time sheet
    public function timeSheet()
    {
        $check = $this->admin_model->checkPermission($this->role, 197);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 197);
            //body ..//          
            if (isset($_REQUEST['payroll_month']) && !empty($_REQUEST['payroll_month'])) {
                // explode year & month 
                $data['payroll_month'] = $_REQUEST['payroll_month'];

                // set dates    
                $dates = $this->hr_model->getDatesFromPayrollMonth($_REQUEST['payroll_month']);
                $data['month'] = $month = $dates['month'];
                $data['year'] = $year = $dates['year'];
                $data['year_str'] = $year_str = $dates['year_str'];
                $data['date_to'] = $date_to = $dates['date_to'];
                $data['date_from'] = $date_from = $dates['date_from'];

            } else {
                $data['year'] = $year = 0;
                $data['month'] = $month = 0;

                if (isset($_REQUEST['date_from']) && !empty($_REQUEST['date_from'])) {
                    $data['date_from'] = $date_from = $_REQUEST['date_from'];
                } else {
                    $data['date_from'] = $date_from = date("Y-m-d", strtotime("-15 day"));
                }

                if (isset($_REQUEST['date_to']) && !empty($_REQUEST['date_to'])) {
                    $data['date_to'] = $date_to = $_REQUEST['date_to'];
                } else {
                    $data['date_to'] = $date_to = date("Y-m-d", strtotime("-1 day"));
                }
            }

            if (isset($_REQUEST['department']) && !empty($_REQUEST['department'])) {
                $data['department'] = $department = $_REQUEST['department'];
                $where = "  AND department = $department";
            } else {
                $data['department'] = "";
                $where = '';
            }
            if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) {
                $data['name'] = $name = $_REQUEST['name'];
                $where .= "  AND id = $name";
            } else {
                $data['name'] = "";
                $where .= '';
            }
            if ($permission->view == 1 && (isset($_REQUEST['search']) || isset($_REQUEST['export']))) {
                $data['employees'] = $this->db->query("SELECT id,name FROM employees WHERE status = 0 $where")->result();
            } elseif ($permission->view == 2) {
                $data['employees'] = $this->db->query("SELECT id,name FROM employees WHERE status = 0 AND( manager = $this->emp_id || id = $this->emp_id) $where")->result();
            }

            //   $data['employees'] = $this->db->query("SELECT id,name FROM employees WHERE status = 0 $where")->result();
            $endDate = date('Y-m-d', strtotime("+1 day", strtotime($date_to)));
            $data['days'] = new DatePeriod(new DateTime($date_from), new DateInterval('P1D'), new DateTime($endDate));

            if ($date_to < $date_from) {
                $error = "Error! Please Select End Date greater than Start Date  ...";
                $this->session->set_flashdata('error', $error);

            }

            if (isset($_REQUEST['export'])) {
                $this->exportTimeSheet($data);
            } else {
                //Pages ..
                $this->load->view('includes_new/header.php', $data);
                $this->load->view('hr_new/timeSheet.php');
                $this->load->view('includes_new/footer.php');
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportTimeSheet($data)
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 197);
        if ($permission == 1) {
            $file_type = "vnd.ms-excel";
            $file_ending = "xls";
            header("Content-Type: application/$file_type");
            header("Content-Disposition: attachment; filename=TimeSheet.$file_ending");
            header("Pragma: no-cache");
            header("Expires: 0");


            $this->load->view('hr_new/exportTimeSheet.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }

    // new role for hr to add vactaion for employees

    public function addVacationForEmployees()
    {
        // Check Permission ..
        $permission = $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($data['permission']->add == 1 && ($permission->role == 31 || $permission->role == 21 || $permission->role == 46)) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('hr_new/addVacationForEmployees.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddVacationForEmployees()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 143);
        if ($permission->add == 1 && ($permission->role == 31 || $permission->role == 21 || $permission->role == 46)) {

            if (strlen($_POST['start_date']) < 1 || strlen($_POST['end_date']) < 1) {
                $error = "Please Add Start Date and End Date...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacation");
            }
            $manager_id = $this->hr_model->getManagerId($_POST['emp_id']);
            $emp_id = $data['emp_id'] = $_POST['emp_id'];
            $typeOfVacation = $data['type_of_vacation '] = $_POST['type_of_vacation'];
            $startDate = $data['start_date'] = $_POST['start_date'];
            //calculate end date 
            $endDate = $data['end_date'] = $this->hr_model->getEndDate($_POST['type_of_vacation'], $_POST['start_date'], $_POST['end_date'], $_POST['relative_degree']);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['relative_degree'] = $_POST['relative_degree'];
            $availableDays = $_POST['available_days'];
            if ($data['type_of_vacation '] == 1 || $data['type_of_vacation '] == 2 || $data['type_of_vacation '] == 3) {
                $data['requested_days'] = $_POST['requested_days'];
            } elseif ($data['type_of_vacation '] == 5) {
                $data['requested_days'] = 90;
            } elseif ($data['type_of_vacation '] == 7) {
                $data['requested_days'] = 30;
            } else {
                $data['requested_days'] = $this->hr_model->getRequestedDays($_POST['start_date'], $data['end_date']);
            }
            ///for sick leave document 
            if ($data['type_of_vacation '] == 3) {
                if ($_FILES['file']['size'] != 0) {
                    $config['file']['upload_path'] = './assets/uploads/sickLeaveDocument/';
                    $config['file']['encrypt_name'] = TRUE;
                    $config['file']['allowed_types'] = 'zip|rar|gif|jpg|png|jpeg';
                    // $config['file']['max_size']             = 10000;
                    // $config['file']['max_width']            = 1024;
                    // $config['file']['max_height']           = 768;
                    $this->load->library('upload', $config['file'], 'file_upload');
                    if (!$this->file_upload->do_upload('file')) {
                        $error = $this->file_upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "hr/vacation");
                    } else {
                        $data_file = $this->file_upload->data();
                        $data['sick_leave_file'] = $data_file['file_name'];
                    }
                } else {
                    $error = "You must upload Sick Leave Document.";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/vacation");
                }
            } else {
                $data['sick_leave_file'] = " ";
            }
            ///
            if ($availableDays >= 0 && $data['requested_days'] > 0 && $availableDays - $data['requested_days'] >= 0) {
                // check if mananger = hr team leader
                if ($manager_id == 25) {
                    $data['status'] = 1;
                    $data['status_by'] = $this->user;
                    $data['status_at'] = date("Y-m-d H:i:s");
                }
                if ($this->db->insert('vacation_transaction', $data)) {
                    if ($manager_id == 25) {
                        $days = $this->hr_model->getRequestedDays($startDate, $endDate, $typeOfVacation);
                        $this->hr_model->updataVacationBalance($days, $emp_id, $typeOfVacation);
                    } else {
                        $this->hr_model->sendVacationRequestMail($data, $this->brand);
                    }
                    $this->admin_model->addToLoggerUpdate('vacation_balance', 143, 'id', $this->db->insert_id(), 101, 101, $this->user);
                    $true = "Vacation Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "hr/viewVacationRequests");
                } else {
                    $error = "Failed To Add Request ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "hr/vacation");
                }
            } else {
                $error = "Failed To Add Request ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "hr/vacation");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    // restore data from table attendance_approval
    public function insertAttendanceApprovalDataIntoLogTable()
    {
        exit();
        $count = 0;
        $locations = $this->db->get('attendance_approval')->result();
        foreach ($locations as $row) {
            $data['SRVDT'] = $row->SRVDT;
            $data['USRID'] = $row->USRID;
            $data['TNAKEY'] = $row->TNAKEY;
            $data['location'] = $row->location;
            $data['created_at'] = $row->created_at;
            $data['created_by'] = $row->created_by;
            if ($this->db->insert('attendance_log', $data)) {
                $id = $this->db->insert_id();
                $count++;
                print_r($id . ' : ' . $data['USRID'] . '<br/>');
            }
        }
        // print_r($count);
    }

    public function approveTimeSheet()
    {
        $data['emp_id'] = $_POST['emp_id'];
        $data['payroll_month'] = $_POST['payroll_month'];
        $data['manager_approval'] = $_POST['manager_approval'];
        $data['comment'] = $_POST['comment'] ?? '';
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['created_by'] = $this->user;
        if ($this->db->insert('timesheet_approval', $data)) {
            if ($data['manager_approval'] == 2) {
                // send email to hr with reject & reject reason
                $this->hr_model->sendRejectTimeSheetMail($data);
            }
            $true = "Data Saved Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $error = "Failed To Save ...";
            $this->session->set_flashdata('error', $error);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
} ?> 