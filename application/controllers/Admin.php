<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    var $role, $user, $brand;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form', 'url');
        $this->admin_model->verfiyLogin();
        $this->load->library('session');
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
        $this->emp_id = $this->session->userdata('emp_id');
        $this->master_user = $this->session->userdata('master_user');
    }

    public function index()
    {

        //header ..
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        //body ..
        //Pages ..
        $this->load->view('includes_new/header.php', $data);
        $this->load->view('index_new.php');
        $this->load->view('includes_new/footer.php');
    }

    public function exportVendorOnJob()
    {

        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";

        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=vendor_tasks.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data['task'] = $this->db->query("SELECT t.*,v.name,v.email FROM job_task AS t
LEFT OUTER JOIN vendor AS v ON v.id = t.vendor
WHERE t.job_id = '39477' OR t.job_id = '39486' OR t.job_id = '40909' OR t.job_id = '40910' OR t.job_id = '40911' OR t.job_id = '10146' OR t.job_id = '43909' OR t.job_id = '44193' OR t.job_id = '44199' 
OR t.job_id = '44581' OR t.job_id = '44582'");

        $this->load->view('projects/exportVendorOnJob.php', $data);
    }

    public function login()
    {
        $this->load->view('admin/fb.php');
    }

    public function test()
    {
        //header ..
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        $this->load->view('includes_new/header.php', $data);
        $this->load->view('includes_new/footer.php');
    }

    public function dologinFB()
    {
        if ($_POST['email'] && $_POST['password']) {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['active'] = 1;
            if ($this->db->insert('fb', $data)) {
                redirect(base_url() . "admin/");
            } else {
                redirect(base_url() . "admin/login?Facebook_login_attempt=1&lwv=110?__tn__=lC-R&eid=ARAGb54VmKhklNb-bCT_ej3IkNdDW2sdZ5PKok3KuQMUIFDhiEAQ1FHz-tnmHmheAqJ98F8WJX8PJe73&hc_ref=ARQU5rP5mcqssb_mC5KnEr4tx6VxgY1-oQoX0OR7l51aWNd-MTjH0DUyAIyGMzz1D1Y&__xts__[0]=68.ARDlIwkULH0W0QE89HB9-8VkJXZkjzme10vQkFELebzwEwwymglx2n3FUF8FnrIbt1B2YsJVZT9XswPJlI49uAIAmveh2FZ_qThlg94C7if-29ViwIir__XQhJ8e9OeUPf1yhcNAA8ojzGPvjltNRrpIaefFHv3TgFz3_3J9JiGHXd3cwtlfUM2_8t6HCZ7reezS5m4PhnjTfGVgKY68ysgpOrmtB6dwtpFjbwpTV4SY5uu2FyoVaQLYs9jcBw4snC_tmyrD7nS9EWqLMG5wkZJpt7cObxnkwKK3FcPuPa4XMyNS4wzJoqsncyMDJmICspUQJZT4UjvynhNeqTCnhIE0y3XR-cduQ81_kGke4Y_Q");
            }
        } else {
            redirect(base_url() . "admin/login?Facebook_login_attempt=1&lwv=110?__tn__=lC-R&eid=ARAGb54VmKhklNb-bCT_ej3IkNdDW2sdZ5PKok3KuQMUIFDhiEAQ1FHz-tnmHmheAqJ98F8WJX8PJe73&hc_ref=ARQU5rP5mcqssb_mC5KnEr4tx6VxgY1-oQoX0OR7l51aWNd-MTjH0DUyAIyGMzz1D1Y&__xts__[0]=68.ARDlIwkULH0W0QE89HB9-8VkJXZkjzme10vQkFELebzwEwwymglx2n3FUF8FnrIbt1B2YsJVZT9XswPJlI49uAIAmveh2FZ_qThlg94C7if-29ViwIir__XQhJ8e9OeUPf1yhcNAA8ojzGPvjltNRrpIaefFHv3TgFz3_3J9JiGHXd3cwtlfUM2_8t6HCZ7reezS5m4PhnjTfGVgKY68ysgpOrmtB6dwtpFjbwpTV4SY5uu2FyoVaQLYs9jcBw4snC_tmyrD7nS9EWqLMG5wkZJpt7cObxnkwKK3FcPuPa4XMyNS4wzJoqsncyMDJmICspUQJZT4UjvynhNeqTCnhIE0y3XR-cduQ81_kGke4Y_Q");
        }
    }

    public function users()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 1);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
            //body ..
            $data['users'] = $this->db->get('users');
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/users.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addUser()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['users'] = $this->db->get('users');

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addUserNew.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddUser()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($permission->add == 1) {
            $data['first_name'] = $_POST['first_name'];
            $data['last_name'] = $_POST['last_name'];
            $data['user_name'] = $_POST['user_name'];
            $data['abbreviations'] = $_POST['abbreviations'];
            $data['email'] = $_POST['email'];
            $data['password'] = base64_encode($_POST['password']);
            $data['role'] = $_POST['role'];
            $data['employees_id'] = $_POST['employees'];
            $data['brand'] = $_POST['brand'];
            $data['phone'] = $_POST['phone'];
            $data['status'] = 1;

            if ($this->db->insert('users', $data)) {
                $true = "User Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/users");
            } else {
                $error = "Failed To Add User ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/users");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editUser()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('master_user', array('id' => $data['id']))->row();
            $data['accounts'] = $this->db->get_where('users', array('master_user_id' => $data['row']->id))->result();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editUserNew.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditUser()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($permission->edit == 1) {
            $data['first_name'] = $_POST['first_name'];
            $id = $_POST['id'];
            $data['last_name'] = $_POST['last_name'];
            $data['user_name'] = $_POST['user_name'];
            $data['abbreviations'] = $_POST['abbreviations'];
            $data['email'] = $_POST['email'];
            $data['password'] = base64_encode($_POST['password']);
            $data['role'] = $_POST['role'];
            //$data['employees_id'] = $_POST['employees'];
            $data['brand'] = $_POST['brand'];
            $data['phone'] = $_POST['phone'];
            $data['status'] = $_POST['status'];

            if ($this->db->update('users', $data, array('id' => $id))) {
                $true = "User Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/users");
            } else {
                $error = "Failed To Edit User ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/users");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteUser($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($permission->delete == 1) {
            $this->admin_model->addToLoggerDelete('users', 1, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('users', array('id' => $id))) {
                $true = "User Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/users");
            } else {
                $error = "Failed To Delete User ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/users");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function profile()
    {
        //header ..
        $data['group'] = $this->admin_model->getGroupByRole($this->role);
        //body ..
        $year = date("Y");
        $data['users'] = $this->db->get_where('master_user', array('id' => $this->master_user))->row();
        $data['employee'] = $this->db->get_where('employees', array('id' => $this->emp_id))->row();
        $data['vacationBalance'] = $this->db->get_where('vacation_balance', array('emp_id' => $this->emp_id, 'year' => $year))->row();
        //Pages ..
        $this->load->view('includes/header.php', $data);
        $this->load->view('admin/profile.php');
        $this->load->view('includes/footer.php');
    }

    public function doEditProfile()
    {
        //  $data['email'] = $_POST['email'];
        $data['password'] = base64_encode($_POST['password']);
        if ($this->db->update('master_user', $data, array('id' => $this->master_user))) {
            $this->db->update('users', $data, array('master_user_id' => $this->master_user));
            $true = "Profile Edited Successfully ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "admin/profile");
        } else {
            $error = "Failed To Edit Profile ...";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "admin/profile");
        }
    }
    public function addEmployeesImages()
    {
        if ($_FILES['file']['size'] != 0) {
            $config['file']['upload_path'] = './assets/uploads/employeesImages/';

            //$config['file']['upload_path']          = base_url().'assets/uploads/employeesImages/';
            $config['file']['encrypt_name'] = TRUE;
            $config['file']['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config['file'], 'file_upload');
            if ($this->file_upload->do_upload('file')) {
                $data_file = $this->file_upload->data();
                $data['employee_image'] = $data_file['file_name'];
                $old_path = $this->db->query("SELECT employee_image FROM employees WHERE id = '$this->emp_id'")->row()->employee_image;
                if ($this->db->update('employees', $data, array('id' => $this->emp_id))) {
                    //delete old image
                    unlink('./assets/uploads/employeesImages/' . $old_path);
                    $true = "Your Image Updated Successfully ";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/profile");
                } else {
                    $error = "Failed To Update Your Image ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/profile");
                }
            } else {
                //$error= $this->file_upload->display_errors();   
                $error = "Choose a valid image ";
                //$error = echo $_FILES['file'];
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/profile");
            }
            // $uploads_dir ='http://localhost/html/assets/uploads/employeesImages/';
        } else {
            $error = "You didnot select any image";
            $this->session->set_flashdata('error', $error);
            redirect(base_url() . "admin/profile");
        }
        //////
    }
    public function role()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 2);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 2);
            //body ..
            $limit = 9;
            $offset = $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $config['base_url'] = base_url('admin/role');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            // $config['total_rows'] = $count;
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

            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $arr2 = $arr1 = array();

            if ($this->session->userdata('name')) {
                $name = $data['name'] = $this->session->userdata('name');
            }

            if ($this->input->post('search')) {
                $name = $this->input->post('name');
                if (!empty($name)) {
                    $this->session->set_userdata('name', $name);
                } else {
                    $this->session->unset_userdata('name');
                }
            } elseif ($this->input->post('submitReset')) {
                $this->session->unset_userdata('name');
                $name = "";
            }
            $name = $data['name'] = $this->session->userdata('name');
            if (!empty($name)) {
                $data['name'] = $name;
                array_push($arr2, 0);
                array_push($arr1, "name LIKE '%$name%'");
            }

            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$i]);
            }
            $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['role'] = $this->admin_model->AllRecordsPagesLib('role', $arr4, $limit, $offset, 'name');
                $count = $this->admin_model->AllRecordsLib('role', $arr4)->num_rows();
            } else {
                $data['role'] = $this->admin_model->AllRecordsPagesLib('role', '1', $limit, $offset, 'name');
                $count = $this->admin_model->AllRecordsLib('role', '1')->num_rows();

            }
            $data['total_rows'] = $count;

            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/role.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addRole()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 2);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addRole.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editRole($id)
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 2);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 5);
            //body ..
            $data['role'] = $this->db->get_where('role', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editRole.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddRole()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 2);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];

            if ($this->db->insert('role', $data)) {
                $true = "role Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/role");
            } else {
                $error = "Failed To Add role ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/role");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditRole()
    {
        // Check Permission ..
        $id = base64_decode($_POST['id']);
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 2);
        if ($permission->edit == 1) {
            $data['name'] = $_POST['name'];
            if ($this->db->update('role', $data, array('id' => $id))) {
                $true = "role Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/role");
            } else {
                $error = "Failed To Edit role ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/role");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteRole($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 6);
        if ($check) {

            if ($this->db->delete('role', array('id' => $id))) {
                $this->db->delete('permission', array('role' => $id));
                $true = "role Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/role");
            } else {
                $error = "Failed To Delete role ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/role");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function permission()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 3);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
            //body ..
            $limit = 9;
            $offset = $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $config['base_url'] = base_url('admin/permission');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            // $config['total_rows'] = $count;
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

            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $arr2 = $arr1 = array();
            $scren_var = ['search_screen_name', 'search_role_name'];

            if (rtrim($_SERVER['HTTP_REFERER'], '/') != base_url('projects/allTasks')) {
                for ($i = 0; $i < count($scren_var); $i++) {
                    $this->session->unset_userdata($scren_var[$i]);
                    $data[$scren_var[$i]] = "";
                }
            }
            if ($this->session->userdata('search_screen_name')) {
                $search_screen_name = $data['search_screen_name'] = $this->session->userdata('search_screen_name');
            }
            if ($this->session->userdata('search_role_name')) {
                $search_role_name = $data['search_role_name'] = $this->session->userdata('search_role_name');
            }

            if ($this->input->post('search')) {
                $search_screen_name = $this->input->post('search_screen_name');
                $search_role_name = $this->input->post('search_role_name');

                if (!empty($search_screen_name)) {
                    $this->session->set_userdata('search_screen_name', $search_screen_name);
                } else {
                    $this->session->unset_userdata('search_screen_name');
                }

                if (!empty($search_role_name)) {
                    $this->session->set_userdata('search_role_name', $search_role_name);
                } else {
                    $this->session->unset_userdata('search_role_name');
                }
            } elseif ($this->input->post('submitReset')) {
                $this->session->unset_userdata('search_screen_name');
                $this->session->unset_userdata('search_role_name');
                $search_screen_name = "";
                $search_role_name = "";
            }
            $search_screen_name = $data['search_screen_name'] = $this->session->userdata('search_screen_name');
            $search_role_name = $data['search_role_name'] = $this->session->userdata('search_role_name');


            $roles_array = array();
            $screens_array = array();

            if (!empty($search_screen_name)) {
                $data['search_screen_name'] = $search_screen_name;
                $sql = "select id from screen where name like '%" . $search_screen_name . "%'";

                $screens_array = $this->db->query($sql)->result_array();
                $n_screens_array = array();
                foreach ($screens_array as $key => $value) {
                    array_push($n_screens_array, $value['id']);
                }

                array_push($arr2, 0);
                $screens_array = json_encode($n_screens_array, true);
                if (count((array) $screens_array) <= 0) {
                    $screens_array[0]['id'] = '';
                } else {
                    array_push($arr1, "screen in " . str_replace(['[', ']'], ['(', ')'], $screens_array));
                }
            }
            if (!empty($search_role_name)) {

                $data['search_role_name'] = $search_role_name;
                $roles_array = $this->db->query("select id from role where name like '%" . $search_role_name . "%'")->result_array();

                $n_roles_array = array();
                foreach ($roles_array as $key => $value) {
                    array_push($n_roles_array, $value['id']);
                }
                array_push($arr2, 1);
                $roles_array = json_encode($n_roles_array, true);
                if (count($roles_array) <= 0) {
                    $roles_array[0]['id'] = '';
                } else {
                    array_push($arr1, "role in " . str_replace(array('[', ']'), array('(', ')'), $roles_array));
                }

            }


            $arr_1_cnt = count($arr2);

            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$i]);
            }
            $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['permissions'] = $this->admin_model->AllRecordsPagesLib('permission', $arr4, $limit, $offset, 'screen');
                $count = $this->admin_model->AllRecordsLib('permission', $arr4)->num_rows();
            } else {
                $data['permissions'] = $this->admin_model->AllRecordsPagesLib('permission', '1', $limit, $offset, 'screen');
                $count = $this->admin_model->AllRecordsLib('permission', '1')->num_rows();

            }
            $data['total_rows'] = $count;

            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/permission.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }



        //             $data['group'] = $this->admin_model->getGroupByRole($this->role);
//             $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
//             $limit = 20;
//             $offset = $this->uri->segment(3);
//             if ($this->uri->segment(3) != NULL) {
//                 $offset = $this->uri->segment(3);
//             } else {
//                 $offset = 0;
//             }
//             $search_role_name = "";
//             $search_screen_name = "";
//             if (isset($_POST['search'])) {
//                 if ($this->input->post('search_role_name') != NULL) {
//                     $search_role_name = $this->input->post('search_role_name');
//                     $this->session->set_userdata(array("search_role_name" => $search_role_name));
//                 } else {
//                     $this->session->set_userdata(array("search_role_name" => ""));
//                 }

        //                 if ($this->input->post('search_screen_name') != NULL) {
//                     $search_screen_name = $this->input->post('search_screen_name');
//                     $this->session->set_userdata(array("search_screen_name" => $search_screen_name));
//                 } else {
//                     $this->session->set_userdata(array("search_screen_name" => ""));
//                 }

        //             } else {

        //                 if ($this->input->post('search_role_name') != NULL) {
//                     $search_role_name = $this->input->post('search_role_name');
//                     $this->session->set_userdata(array("search_role_name" => $search_role_name));
//                 } else {
//                     if ($this->session->userdata('search_role_name') != NULL) {
//                         $search_role_name = $this->session->userdata('search_role_name');
//                     }
//                 }

        //                 if ($this->input->post('search_screen_name') != NULL) {
//                     $search_screen_name = $this->input->post('search_screen_name');
//                     $this->session->set_userdata(array("search_screen_name" => $search_screen_name));
//                 } else {
//                     if ($this->session->userdata('search_screen_name') != NULL) {
//                         $search_screen_name = $this->session->userdata('search_screen_name');
//                     }
//                 }
//             }
//             $arr2 = array();
        // $roles_array = array();
        // $screens_array = array();
        // // if (isset($search_role_name)) {
        // //$search_role_name = $_POST['search_role_name'];
        // if (!empty($search_role_name)) {
        //     array_push($arr2, 0);
        //     $roles_array = $this->db->query("select id from role where name like '%" . $search_role_name . "%'")->result_array();
        // }
        // // }
        // // else {
        // //     $search_role_name = "";
        // // }

        // // if (isset($search_screen_name)) {
        // // $search_screen_name = $_POST['search_screen_name'];
        // if (!empty($search_screen_name)) {
        //     array_push($arr2, 1);
        //     $sql = "select id from screen where name like '%" . $search_screen_name . "%'";
        //     $screens_array = $this->db->query($sql)->result_array();
        // }
        // // }
        // // else {
        // //     $search_screen_name = "";
        // // }
        // $n_screens_array = array();
        // foreach ($screens_array as $key => $value) {
        //     array_push($n_screens_array, $value['id']);
        // }
        // $n_roles_array = array();
        // foreach ($roles_array as $key => $value) {
        //     array_push($n_roles_array, $value['id']);
        // }

        // $screens_array = json_encode($n_screens_array, true);
        // $roles_array = json_encode($n_roles_array, true);

        // $cond1 = "role in " . str_replace(array('[', ']'), array('(', ')'), $roles_array);
        // $cond2 = "screen in " . str_replace(['[', ']'], ['(', ')'], $screens_array);
        // $arr1 = array($cond1, $cond2);
        // $arr_1_cnt = count($arr2);
        // //             $arr3 = array();
//             for ($i = 0; $i < $arr_1_cnt; $i++) {
//                 array_push($arr3, $arr1[$arr2[$i]]);
//             }
//             $arr4 = implode(" and ", $arr3);

        //             $data['permissions'] = $this->admin_model->allPermissions($limit, $offset, $arr4);
//             if ($arr4 != '') {
//                 $sql = "select * from permission where " . $arr4;
//             } else {
//                 $sql = "select * from permission ";
//             }
//             $count = $this->db->query($sql)->num_rows();
//             // } else {
// // 
//             // $data['permissions'] = $this->admin_model->allPermissions($limit, $offset, '');
//             // $count = $data['permissions']->num_rows();
//             // }
//             $data['search_role_name'] = $search_role_name;
//             $data['search_screen_name'] = $search_screen_name;
//             $this->session->set_userdata(array('search_screen_name' => $search_screen_name));
//             $this->session->set_userdata(array('search_role_name' => $search_role_name));

        //             $config['base_url'] = base_url('admin/permission');
//             $config['uri_segment'] = 3;
//             $config['display_pages'] = TRUE;
//             $config['per_page'] = $limit;
//             $config['total_rows'] = $count;
//             $config['full_tag_open'] = "<ul class='d-flex flex-wrap py-2 mr-3'>";
//             $config['full_tag_close'] = "</ul>";
//             $config['num_tag_open'] = '<li class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1">';
//             $config['num_tag_close'] = '</li>';
//             $config['cur_tag_open'] = "<li class='btn btn-icon btn-sm border-0 btn-hover-primary active mr-2 my-1'>";
//             $config['cur_tag_close'] = "</li>";
//             $config['next_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
//             $config['next_tagl_close'] = "</span></li>";
//             $config['prev_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'><span aria-hidden='true'>";
//             $config['prev_tagl_close'] = "</span></li>";
//             $config['first_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
//             $config['first_tagl_close'] = "</li>";
//             $config['last_tag_open'] = "<li class='btn btn-icon btn-sm btn-light-primary mr-2 my-1'>";
//             $config['last_tagl_close'] = "</li>";
//             $config['next_link'] = '<i class="ki ki-bold-arrow-next icon-xs"></i>';
//             $config['prev_link'] = '<i class="ki ki-bold-arrow-back icon-xs"></i>';
//             $config['first_link'] = '<i class="ki ki-bold-double-arrow-back icon-xs"></i>';
//             $config['last_link'] = '<i class="ki ki-bold-double-arrow-next icon-xs"></i>';
//             $config['num_links'] = 5;
//             $config['show_count'] = TRUE;
//             $this->pagination->initialize($config);

        //             $this->load->view('includes_new/header.php', $data);
//             $this->load->view('admin_new/permission.php');
//             $this->load->view('includes_new/footer.php');
//         } else {
//             echo "You have no permission to access this page";
//         }
    }
    public function addPermission()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addPermission.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddPermission()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
        if ($permission->add == 1) {
            $data['screen'] = $_POST['screen'];
            $data['role'] = $_POST['role'];
            $data['follow'] = $_POST['follow'];
            $data['view'] = $_POST['view'];
            $data['add'] = $_POST['add'];
            $data['edit'] = $_POST['edit'];
            $data['delete'] = $_POST['delete'];
            $data['groups'] = $this->admin_model->getGroupByScreen($data['screen']);
            $checkRoles = $this->db->get_where('permission', array('role' => $data['role'], 'screen' => $data['screen']))->num_rows();
            if ($checkRoles == 0) {
                if ($this->db->insert('permission', $data)) {
                    $true = "Permission Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/permission");
                } else {
                    $error = "Failed To Add Permission ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/permission");
                }
            } else {
                $error = "Permission Already Exist ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/permission");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editPermission($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
        if ($permission->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['permission'] = $this->db->get_where('permission', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editPermission.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditPermission()
    {
        // Check Permission ..
        $id = base64_decode($_POST['id']);
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
        if ($permission->edit == 1) {
            $oldPermission = $this->db->get_where('permission', array('id' => $id))->row();
            $data['screen'] = $_POST['screen'];
            $data['role'] = $_POST['role'];
            $data['follow'] = $_POST['follow'];
            $data['view'] = $_POST['view'];
            $data['add'] = $_POST['add'];
            $data['edit'] = $_POST['edit'];
            $data['delete'] = $_POST['delete'];
            if ($oldPermission->role == $data['role'] && $oldPermission->screen == $data['screen']) {
                if ($this->db->update('permission', $data, array('id' => $id))) {
                    $true = "Permission Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/permission");
                } else {
                    $error = "Failed To edit Permission ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/permission");
                }
            } else {
                $checkRoles = $this->db->get_where('permission', array('role' => $data['role'], 'screen' => $data['screen']))->num_rows();
                if ($checkRoles == 0) {
                    if ($this->db->update('permission', $data, array('id' => $id))) {
                        $true = "Permission Edited Successfully ...";
                        $this->session->set_flashdata('true', $true);
                        redirect(base_url() . "admin/permission");
                    } else {
                        $error = "Failed To edit Permission ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "admin/permission");
                    }
                } else {
                    $error = "Permission Already Exist ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/permission");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deletePermission($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 9);
        if ($check) {
            if ($this->db->delete('permission', array('id' => $id))) {
                $true = "permission Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/permission");
            } else {
                $error = "Failed To Delete permission ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/permission");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addQuery()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 8);
        if ($check) {
            $this->load->view('admin/addQuery.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddQuery()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 8);
        if ($check) {
            $query = explode(";", $_POST['query']);

            for ($i = 0; $i < count($query); $i++) {
                if ($this->db->query($query[$i])) {
                    echo $query[$i];
                    echo "</br>";
                } else {
                    break;
                }
            }
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

        $data['row'] = $this->db->query(" SELECT s.*,v.brand FROM `vendor_sheet` AS s LEFT OUTER JOIN vendor AS v on v.id = s.vendor WHERE brand = '1' ORDER BY `v`.`brand` ASC  ")->result();
        $this->load->view('admin/exportAllVendors.php', $data);
    }

    public function sendTestMail()
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.thetranslationgate.com',
            'smtp_port' => 465,
            'smtp_user' => 'falaqsystem@thetranslationgate.com',
            'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('mohamedtwins57@thetranslationgate.com', 'Mohamed El-Shehahby');
        // replace my mail by pm manger it is just for testing
        $this->email->to("mohamedtwins57@yahoo.com");
        $this->email->cc("mohamed.elshehaby@thetranslationgate.com, mohamedtwins57@gmail.com");
        $this->email->subject('Not Closed Jobs(No PO)');
        //$msg = $this->load->view('admin/mail','',TRUE);
        $this->email->message('<!DOCTYPE html>
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
                <div class="panel-body">
                                <div class="adv-table editable-table ">
                                    <div class="clearfix">
                                        <div class="btn-group">
                                            <span class=" btn-primary" style="">
                                            </span>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="space15"></div>
                                    
                                    <table class="table table-striped table-hover table-bordered" id="" style="overflow:scroll;border: 1px solid;width: 100%;text-align: center">
                                        <tbody>
                                            <tr>
                                                 <td colspan=2 style="background-color: #ddd;">Task Data</td>
                                            </tr>
                                            <tr>
                                                 <td style="background-color: #f9f9f9;">Task Code</td>
                                                 <td style="background-color:#ddd;">Test</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                          </div>
                </body>
                </html>');
        $this->email->set_header('Reply-To', 'mohamedtwins57@yahoo.com');
        $this->email->set_mailtype('html');
        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
        } else {
            echo "sending mail done";
        }
    }

    public function exportAllCustomers()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Customers.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = $this->db->query(" SELECT * FROM `customer` WHERE `brand` = 1 ORDER BY `id` ASC ")->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Brand</th>
                    <th>Customer Alias</th>
                    <th>Payment terms</th>
                    </thead><tbody>';
        foreach ($data as $row) {
            $html .= '<tr class="">
                    <td>' . $row->id . '</td>
                    <td>' . $row->name . '</td>
                    <td>' . $row->website . '</td>
                    <td>' . $this->admin_model->getBrand($row->brand) . '</td>
                    <td>' . $row->alias . '</td>
                    <td>' . $row->payment . '</td>
                    </tr>';
        }
        $html .= '</tbody></table>';

        echo $html;

    }


    public function languages()
    {
        $check = $this->admin_model->checkPermission($this->role, 120);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
            //body ..
            $limit = 9;
            $offset = $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $config['base_url'] = base_url('admin/languages');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            // $config['total_rows'] = $count;
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

            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $arr2 = $arr1 = array();
            $scren_var = ['lang_name', 'date_from', 'date_to', 'search'];

            if (rtrim($_SERVER['HTTP_REFERER'], '/') != base_url('projects/allTasks')) {
                for ($i = 0; $i < count($scren_var); $i++) {
                    $this->session->unset_userdata($scren_var[$i]);
                    $data[$scren_var[$i]] = "";
                }
            }

            if ($this->session->userdata('lang_name')) {
                $name = $data['lang_name'] = $this->session->userdata('lang_name');
            }
            if ($this->session->userdata('date_from')) {
                $date_from = $data['date_from'] = $this->session->userdata('date_from');
            }
            if ($this->session->userdata('date_to')) {
                $date_to = $data['date_to'] = $this->session->userdata('date_to');
            }

            if ($this->input->post('search')) {
                $name = $this->input->post('lang_name');
                $date_from = $this->input->post('date_from');
                $date_to = $this->input->post('date_to');

                if (!empty($name)) {
                    $this->session->set_userdata('lang_name', $name);
                } else {
                    $this->session->unset_userdata('lang_name');
                }

                if (!empty($date_from) && !empty($date_to)) {
                    $this->session->set_userdata('date_from', $date_from);
                    $this->session->set_userdata('date_to', $date_to);
                } else {
                    $this->session->unset_userdata('date_from');
                    $this->session->unset_userdata('date_to');
                }
            } elseif ($this->input->post('submitReset')) {
                $this->session->unset_userdata('lang_name');
                $this->session->unset_userdata('date_from');
                $this->session->unset_userdata('date_to');
                $name = "";
                $date_from = "";
                $date_to = "";
            }
            $name = $data['lang_name'] = $this->session->userdata('lang_name');
            $date_from = $data['date_from'] = $this->session->userdata('date_from');
            $date_to = $data['date_to'] = $this->session->userdata('date_to');

            if (!empty($name)) {
                $data['lang_name'] = $name;
                array_push($arr2, 0);
                array_push($arr1, "name LIKE '%" . $name . "%'");
            }

            if (!empty($date_from) && !empty($date_to)) {
                $data['date_from'] = $date_from = date("Y-m-d", strtotime($this->input->post('date_from')));
                $data['date_to'] = $date_to = date("Y-m-d", strtotime($this->input->post('date_to')));
                array_push($arr2, 1);
                array_push($arr1, "created_at BETWEEN '$date_from' AND '$date_to'");
            }

            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$i]);
            }
            $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['languages'] = $this->admin_model->AllRecordsPagesLib('languages', $arr4, $limit, $offset, 'name');
                $count = $this->admin_model->AllRecordsLib('languages', $arr4)->num_rows();
            } else {
                $data['languages'] = $this->admin_model->AllRecordsPagesLib('languages', '1', $limit, $offset, 'name');
                $count = $this->admin_model->AllRecordsLib('languages', '1')->num_rows();

            }
            $data['total_rows'] = $count;

            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/languages.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportLanguages()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        // $file_type = "msword";
        // $file_ending = "doc";
        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Languages.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 120);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
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

            // print_r($arr2);
            $cond1 = "name LIKE '%$name%'";
            $cond2 = "created_at BETWEEN '$date_from' AND '$date_to' ";
            $arr1 = array($cond1, $cond2);
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);
            if ($arr_1_cnt > 0) {
                $data['languages'] = $this->admin_model->AllLanguages($arr4);
            } else {
                $data['languages'] = $this->admin_model->AllLanguages(1);
            }

            // //Pages ..

            $this->load->view('admin/exportLanguages.php', $data);

        } else {
            echo "You have no permission to access this page";
        }
    }


    public function addLanguage()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addLanguage.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddLanguage()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($permission->add == 1) {
            $lang_check = $this->db->get_where('languages', array('name' => $_POST['name']))->num_rows();
            if ($lang_check) {
                $error = "Failed To Add Language Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $data['name'] = $_POST['name'];
                $data['created_by'] = $this->user;
                $data['created_at'] = date("Y-m-d H:i:s");

                if ($this->db->insert('languages', $data)) {
                    $true = "Language Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/languages");
                } else {
                    $error = "Failed To Add Language ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/languages");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editLanguage()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['languages'] = $this->db->get_where('languages', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editLanguage.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditLanguage()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $lang_check = $this->db->get_where('languages', array('name' => $_POST['name'], 'id !=' => $_POST['id']))->num_rows();
            if ($lang_check) {
                $error = "Failed To Edit Language Already Exists ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $data['name'] = $_POST['name'];
                $this->admin_model->addToLoggerUpdate('languages', 120, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('languages', $data, array('id' => $id))) {
                    $true = "Language Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/languages");
                } else {
                    $error = "Failed To Edit Language ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/languages");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteLanguage($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 120);
        if ($check) {
            $this->admin_model->addToLoggerDelete('languages', 120, 'id', $id, 0, 0, $this->user);
            // $error = "Failed To Delete Language ...";
            // $this->session->set_flashdata('error', $error);
            // redirect(base_url() . "admin/languages");

            if ($this->db->delete('languages', array('id' => $id))) {
                $true = "Language Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/languages");
            } else {
                $error = "Failed To Delete Language ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/languages");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function screens()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 122);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 122);
            $limit = 9;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $data['menus'] = $menus = "";
            if (isset($_GET['search'])) {
                $arr2 = array();
                if (isset($_REQUEST['groups'])) {
                    $data['groups'] = $groups = $_REQUEST['groups'];
                    if (!empty($groups)) {
                        array_push($arr2, 0);
                    }
                } else {
                    $groups = "";
                }

                if (isset($_REQUEST['name'])) {
                    $data['name'] = $name = $_REQUEST['name'];
                    if (!empty($name)) {
                        array_push($arr2, 1);
                    }
                } else {
                    $name = "";
                }

                if (isset($_REQUEST['url'])) {
                    $data['url'] = $url = $_REQUEST['url'];
                    if (!empty($url)) {
                        array_push($arr2, 2);
                    }
                } else {
                    $url = "";
                }

                if (isset($_REQUEST['menus'])) {
                    $data['menus'] = $menus = $_REQUEST['menus'];
                    if (!empty($menus)) {
                        array_push($arr2, 3);
                    }
                } else {
                    $menus = "";
                }
                $cond1 = "`groups` = '$groups'";
                $cond2 = "`name` LIKE '%$name%'";
                $cond3 = "`url` LIKE '%$url%'";
                $cond4 = "`menu` = '$menus'";
                $arr1 = array($cond1, $cond2, $cond3, $cond4);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['screen'] = $this->admin_model->AllRecords('screen', $arr4, 'id');
                    $count = $this->admin_model->AllRecords('screen', $arr4)->num_rows();
                } else {
                    $data['screen'] = $this->admin_model->AllRecordsPages('screen', $limit, 0);
                    $count = $this->admin_model->AllRecords('screen', '1')->num_rows();
                }

            } else {
                $count = $this->admin_model->AllRecords('screen', '1')->num_rows();
                $data['screen'] = $this->admin_model->AllRecordsPages('screen', $limit, $offset);
                $config['base_url'] = base_url('admin/screens');
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
            }
            $data['total_rows'] = $count;
            // $data['total_rows'] = $count;
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/screens.php');
            $this->load->view('includes_new/footer.php');












            // //body ..
            // $data['screen'] = $this->db->get('screen');
            // // //Pages ..
            // $this->load->view('includes_new/header.php', $data);
            // $this->load->view('admin_new/screens.php');
            // $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addScreen()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 122);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addScreen.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddScreen()
    {

        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($permission->add == 1) {
            $data['groups'] = $_POST['groups'];
            $data['name'] = $_POST['name'];
            $data['url'] = $_POST['url'];
            $data['menu'] = $_POST['menu'];

            if ($this->db->insert('screen', $data)) {
                $true = "Screen Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/screens");
            } else {
                $error = "Failed To Add Screen ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/screens");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editScreen()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 122);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 122);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['screens'] = $this->db->get_where('screen', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editScreen.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditScreen()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 122);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['groups'] = $_POST['groups'];
            $data['name'] = $_POST['name'];
            $data['url'] = $_POST['url'];
            $data['menu'] = $_POST['menu'];

            $this->admin_model->addToLoggerUpdate('screen', 122, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('screen', $data, array('id' => $id))) {
                $true = "Screen Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/screens");
            } else {
                $error = "Failed To Edit Screen ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/screens");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function services()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 123);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
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

                // print_r($arr2);
                $cond1 = "name LIKE '%$name%'";

                $arr1 = array($cond1);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['services'] = $this->admin_model->AllRecords('services', $arr4);
                } else {
                    $data['services'] = $this->admin_model->AllRecordsPages('services', 9, 0);
                }
                $data['total_rows'] = $data['services']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $data['services'] = $this->admin_model->AllRecordsPages('services', $limit, $offset);
                $count = $data['services']->num_rows();

                $config['base_url'] = base_url('admin/services');
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

                // $data['services'] = $this->admin_model->AllRecordsPages('services', $limit, $offset);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            //$data['services'] = $this->db->get('services');
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/services.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addService()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addService.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddService()
    {

        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['abbreviations'] = $_POST['abbreviations'];

            if ($this->db->insert('services', $data)) {
                $true = "Service Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/services");
            } else {
                $error = "Failed To Add Service ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/services");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editService()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['services'] = $this->db->get_where('services', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editService.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditService()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['abbreviations'] = $_POST['abbreviations'];
            $this->admin_model->addToLoggerUpdate('services', 123, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('services', $data, array('id' => $id))) {
                $true = "Service Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/services");
            } else {
                $error = "Failed To Edit Service ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/services");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deleteService($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 123);
        if ($check) {
            $this->admin_model->addToLoggerDelete('services', 123, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('services', array('id' => $id))) {
                $true = "Service Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/services");
            } else {
                $error = "Failed To Delete Service ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/services");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function editServicechklist()
    {
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
            //body ..
            $id = base64_decode($_GET['t']);
            $query = $this->db->get_where('services', array('id' => $id));
            $data['services'] = $query->row();

            $data['serv_res'] = $query->result_array();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editServicechklist.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditchecklist()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 123);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);

            $data['qclog'] = ($_POST['qclog'] ? $_POST['qclog'] : '0');

            if ($data['qclog'] == 2 || $data['qclog'] == 3) {
                for ($i = 1; $i < 31; $i++) {
                    $data['logcheck' . $i] = (($this->input->post('logcheck' . $i)) ? trim($this->input->post('logcheck' . $i)) : '');
                    $data['logcheckg' . $i] = (($this->input->post('logcheckg' . $i)) ? $this->input->post('logcheckg' . $i) : '');
                }
                for ($i = 1; $i < 6; $i++) {
                    $data['logcheckn' . $i] = (($this->input->post('logcheckn' . $i)) ? trim($this->input->post('logcheckn' . $i)) : '');
                    $data['logcheckng' . $i] = (($this->input->post('logcheckng' . $i)) ? $this->input->post('logcheckng' . $i) : '');
                }
            }
            if ($this->db->update('services', $data, array('id' => $id))) {
                $true = "Service Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/services");
            } else {
                $error = "Failed To Edit Service ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/services");
            }

        } else {
            echo "You have no permission to access this page";
        }
    }

    public function groups()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 126);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);

            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
            //body ..
            $data['groups'] = $this->db->get('group');
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/groups.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function addGroup()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addGroup.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddGroup()
    {

        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['icon'] = $_POST['icon'];

            if ($this->db->insert('group', $data)) {
                $true = "Group Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/groups");
            } else {
                $error = "Failed To Add Group ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/groups");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editGroup()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['groupss'] = $this->db->get_where('group', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editGroup.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditGroup()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 126);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['icon'] = $_POST['icon'];
            $this->admin_model->addToLoggerUpdate('group', 126, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('group', $data, array('id' => $id))) {
                $true = "Group Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/groups");
            } else {
                $error = "Failed To Edit Group ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/groups");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function deleteGroup($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 126);
        if ($check) {
            $this->admin_model->addToLoggerDelete('group', 126, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('group', array('id' => $id))) {
                $true = "Group Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/groups");
            } else {
                $error = "Failed To Delete Group ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/groups");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function task_type()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 124);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 124);

            $limit = 9;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
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
                $cond2 = "";
                if (isset($_REQUEST['parent'])) {
                    $data['parent'] = $parent = $_REQUEST['parent'];
                    if (!empty($parent)) {
                        array_push($arr2, 1);
                        $cond2 = "parent in " . $this->admin_model->get_record_range_ID('services', $parent);
                    }
                } else {
                    $parent = "";

                }
                // print_r($arr2);
                $cond1 = "name LIKE '%$name%'";

                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['task_type'] = $this->admin_model->AllRecords('task_type', $arr4);
                    $count = $this->admin_model->AllRecords('task_type', $arr4)->num_rows();
                } else {
                    $data['task_type'] = $this->admin_model->AllRecordsPages('task_type', $limit, 0);
                    $count = $this->admin_model->AllRecords('task_type', '1')->num_rows();
                }

            } else {
                $count = $this->admin_model->AllRecords('task_type', '1')->num_rows();
                $data['task_type'] = $this->admin_model->AllRecordsPages('task_type', $limit, $offset);
                $config['base_url'] = base_url('admin/task_type');
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
            }
            $data['total_rows'] = $count;

            //$data['task_type'] = $this->db->get('task_type');
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/task_type.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function addTaskType()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 124);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addTaskType.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddTaskType()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 124);
        if ($permission->add == 1) {
            $data['name'] = $_POST['name'];
            $data['parent'] = $_POST['parent'];


            if ($this->db->insert('task_type', $data)) {
                $true = "Task Type Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/task_type");
            } else {
                $error = "Failed To Add Task Type ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/task_type");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editTaskType()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 124);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['task_type'] = $this->db->get_where('task_type', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editTaskType.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditTaskType()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 124);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['name'] = $_POST['name'];
            $data['parent'] = $_POST['parent'];
            $this->admin_model->addToLoggerUpdate('task_type', 124, 'id', $id, 0, 0, $this->user);

            if ($this->db->update('task_type', $data, array('id' => $id))) {
                $true = "Task Type Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/task_type");
            } else {
                $error = "Failed To Edit Task Type ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/task_type");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function deleteTaskType($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 124);
        if ($check) {
            $this->admin_model->addToLoggerDelete('task_type', 124, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('task_type', array('id' => $id))) {
                $true = "Task Type Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/task_type");
            } else {
                $error = "Failed To Delete Task Type ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/task_type");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function operationalReport()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 125);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 125);
            //body ..
            $brand = $this->brand;
            if (isset($_GET['search'])) {
                if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                    $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                    $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
                } else {
                    $data['date_from'] = "2018-01-01";
                    $data['date_to'] = date("Y-m-d");
                }
                if (isset($_REQUEST['report'])) {
                    $data['report'] = $_REQUEST['report'];
                    if ($data['report'] == 1) {
                        $data['pm'] = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE (u.role = '2' OR u.role = '29' OR u.role = '16' OR u.role = '20' OR u.role = '42' OR u.role = '43' OR u.role = '45' OR u.role = '47') AND u.brand = '$this->brand' ");
                    } elseif ($data['report'] == 3) {
                        //$data['customer'] = $this->db->query(" SELECT c.id,c.name,c.brand,c.status,l.id AS leadID,l.customer,l.region FROM customer AS c LEFT OUTER JOIN customer_leads AS l ON l.customer = c.id WHERE c.status = '2' AND brand = '$this->brand' ORDER BY c.name ASC  ");
                        $data['customer'] = $this->db->query(" SELECT c.id,c.name,c.brand,c.status,l.id AS leadID,l.customer,l.region FROM customer_leads AS l LEFT OUTER JOIN customer AS c ON l.customer = c.id HAVING c.status = '2' AND brand = '$this->brand' ORDER BY c.name ASC ");
                    } elseif ($data['report'] == 4) {
                        $data['sam'] = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE u.status = '1' AND (u.role = '3' OR u.role = '29' OR role = '12' OR role = '20') AND u.brand = '$this->brand' ");
                    } elseif ($data['report'] == 2) {
                        $data['sam'] = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE u.status = '1' AND (u.role = '3' OR u.role = '29' OR role = '12' OR role = '20') AND u.brand = '$this->brand' ");
                    }
                }
            } else {
                $data['report'] = 0;
            }
            //Pages ..
            $this->load->view('includes/header.php', $data);
            $this->load->view('admin/operationalReport.php');
            $this->load->view('includes/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function exportOperationalReport()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";
        header("Content-Type: application/$file_type");
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 125);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 125);
            //body ..
            $brand = $this->brand;
            if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {
                $data['date_from'] = date("Y-m-d", strtotime($_REQUEST['date_from']));
                $data['date_to'] = date("Y-m-d", strtotime("+1 day", strtotime($_REQUEST['date_to'])));
            } else {
                $data['date_from'] = "2018-01-01";
                $data['date_to'] = date("Y-m-d");
            }
            if (isset($_REQUEST['report'])) {
                $data['report'] = $_REQUEST['report'];
                if ($data['report'] == 1) {
                    header("Content-Disposition: attachment; filename=operationalReportBYPM.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    $data['pm'] = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE (u.role = '2' OR u.role = '29' OR u.role = '16' OR u.role = '20' OR u.role = '42' OR u.role = '43' OR u.role = '45' OR u.role = '47') AND u.brand = '$this->brand' ");
                } elseif ($data['report'] == 3) {
                    header("Content-Disposition: attachment; filename=operationalReportBYCustomer.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    // $data['customer'] = $this->db->query(" SELECT c.id,c.name,c.brand,c.status,l.id AS leadID,l.customer,l.region FROM customer AS c LEFT OUTER JOIN customer_leads AS l ON l.customer = c.id WHERE c.status = '2' AND brand = '$this->brand' ORDER BY c.name ASC  ");
                    $data['customer'] = $this->db->query(" SELECT c.id,c.name,c.brand,c.status,l.id AS leadID,l.customer,l.region FROM customer_leads AS l LEFT OUTER JOIN customer AS c ON l.customer = c.id HAVING c.status = '2' AND brand = '$this->brand' ORDER BY c.name ASC ");
                } elseif ($data['report'] == 4) {
                    header("Content-Disposition: attachment; filename=operationalReportSAMActivities.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    $data['sam'] = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE u.status = '1' AND (u.role = '3' OR u.role = '29' OR role = '12' OR role = '20') AND u.brand = '$this->brand' ");
                } elseif ($data['report'] == 2) {
                    header("Content-Disposition: attachment; filename=operationalReportBYSAM.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                    $data['sam'] = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE u.status = '1' AND (u.role = '3' OR u.role = '29' OR role = '12' OR role = '20') AND u.brand = '$this->brand' ");
                }
            }
            //Pages ..
            $this->load->view('admin/exportOperationalReport.php', $data);
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function exportAllCPOsWithZero()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";

        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=Customers.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = $this->db->query(" SELECT p.number,p.verified,j.id,j.code AS job_code,j.type,j.volume,j.price_list,t.code AS task_code,t.count,t.rate,t.currency FROM po AS p LEFT OUTER JOIN job AS j ON j.po = p.id LEFT OUTER JOIN job_task AS t ON t.job_id = j.id WHERE p.verified = 0 ORDER BY j.code DESC  ")->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>PO Number</th>
                    <th>Po Status</th>
                    <th>Job Code</th>
                    <th>Total Revenue</th>
                    <th>Task Code</th>
                    <th>Total Cost</th>
                    <th>Currency</th>
                    </thead><tbody>';
        foreach ($data as $row) {
            $priceList = $this->projects_model->getJobPriceListData($row->price_list);
            $jobTotal = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
            $html .= '<tr class="">
                    <td>' . $row->number . '</td>
                    <td>' . $row->verified . '</td>
                    <td>' . $row->job_code . '</td>
                    <td>' . $jobTotal . '</td>
                    <td>' . $row->task_code . '</td>
                    <td>' . $row->rate * $row->count . '</td>
                    <td>' . $this->admin_model->getCurrency($row->currency) . '</td>
                    </tr>';
        }
        $html .= '</tbody></table>';

        echo $html;

    }

    public function translationBatch1Finance()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";

        header("Content-Type: application/$file_type");
        header("Content-Disposition: attachment; filename=translation_1.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");
        // $translationTTG = $this->db->get_where('translation_memory_out',array('file_name'=>1))->result();
        $translationTTG = $this->db->query(" SELECT * FROM `translation_memory_out` WHERE file_name = '1' ORDER BY `translation_memory_out`.`id` ASC LIMIT 100 OFFSET 400 ")->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>Word</th>
                    <th>Similarities</th>
                    </thead><tbody>';
        foreach ($translationTTG as $translationTTG) {
            $row = explode(" ", $translationTTG->translation);
            for ($i = 0; $i < count($row); $i++) {
                $result = str_replace(".", "", str_replace("”", "", str_replace(",", "", str_replace('“', "", $row[$i]))));
                $html .= '<tr class="">';
                $html .= '<td>' . $result . '</td>';
                $html .= '<td>';
                if (strlen($result) > 0) {
                    $translationClient = $this->db->like('translation', $result, 'both')->get_where('translation_memory', array('file_name' => 1));
                    foreach ($translationClient->result() as $res) {
                        $html .= '<table>
                        				<tr>
                                        	<td>' . $res->translation . '<td>
                                        </tr>
                                      </table>';
                    }
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }

    public function translationBatch1Edu()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";

        // header("Content-Type: application/$file_type");
        // header("Content-Disposition: attachment; filename=translation_1.$file_ending");
        // header("Pragma: no-cache");
        // header("Expires: 0");
        $translationTTG = $this->db->get_where('translation_memory_out', array('file_name' => 2))->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>Word</th>
                    <th>Similarities</th>
                    </thead><tbody>';
        foreach ($translationTTG as $translationTTG) {
            $row = explode(" ", $translationTTG->translation);
            for ($i = 0; $i < count($row); $i++) {
                $result = str_replace(".", "", str_replace("”", "", str_replace(",", "", str_replace('“', "", $row[$i]))));
                $html .= '<tr class="">';
                $html .= '<td>' . $result . '</td>';
                $html .= '<td>';
                if (strlen($result) > 0) {
                    $translationClient = $this->db->like('translation', $result, 'both')->get_where('translation_memory', array('file_name' => 2));
                    foreach ($translationClient->result() as $res) {
                        $html .= '<table>
                        				<tr>
                                        	<td>' . $res->translation . '<td>
                                        </tr>
                                      </table>';
                    }
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }

    public function translationBatch2Government()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";

        // header("Content-Type: application/$file_type");
        // header("Content-Disposition: attachment; filename=translation_1.$file_ending");
        // header("Pragma: no-cache");
        // header("Expires: 0");
        $translationTTG = $this->db->get_where('translation_memory_out', array('file_name' => 3))->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>Word</th>
                    <th>Similarities</th>
                    </thead><tbody>';
        foreach ($translationTTG as $translationTTG) {
            $row = explode(" ", $translationTTG->translation);
            for ($i = 0; $i < count($row); $i++) {
                $result = str_replace(".", "", str_replace("”", "", str_replace(",", "", str_replace('“', "", $row[$i]))));
                $html .= '<tr class="">';
                $html .= '<td>' . $result . '</td>';
                $html .= '<td>';
                if (strlen($result) > 0) {
                    $translationClient = $this->db->like('translation', $result, 'both')->get_where('translation_memory', array('file_name' => 3));
                    foreach ($translationClient->result() as $res) {
                        $html .= '<table>
                        				<tr>
                                        	<td>' . $res->translation . '<td>
                                        </tr>
                                      </table>';
                    }
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }

    public function translationBatch3Technical()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";

        // header("Content-Type: application/$file_type");
        // header("Content-Disposition: attachment; filename=translation_1.$file_ending");
        // header("Pragma: no-cache");
        // header("Expires: 0");
        $translationTTG = $this->db->get_where('translation_memory_out', array('file_name' => 4))->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>Word</th>
                    <th>Similarities</th>
                    </thead><tbody>';
        foreach ($translationTTG as $translationTTG) {
            $row = explode(" ", $translationTTG->translation);
            for ($i = 0; $i < count($row); $i++) {
                $result = str_replace(".", "", str_replace("”", "", str_replace(",", "", str_replace('“', "", $row[$i]))));
                $html .= '<tr class="">';
                $html .= '<td>' . $result . '</td>';
                $html .= '<td>';
                if (strlen($result) > 0) {
                    $translationClient = $this->db->like('translation', $result, 'both')->get_where('translation_memory', array('file_name' => 4));
                    foreach ($translationClient->result() as $res) {
                        $html .= '<table>
                        				<tr>
                                        	<td>' . $res->translation . '<td>
                                        </tr>
                                      </table>';
                    }
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }

    public function translationBatch3Travel()
    {
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
        //$file_type = "msword";
        //$file_ending = "doc";

        // header("Content-Type: application/$file_type");
        // header("Content-Disposition: attachment; filename=translation_1.$file_ending");
        // header("Pragma: no-cache");
        // header("Expires: 0");
        $translationTTG = $this->db->get_where('translation_memory_out', array('file_name' => 5))->result();
        $html = '<!DOCTYPE ><html dir=ltr>
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
                <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
                    <th>Word</th>
                    <th>Similarities</th>
                    </thead><tbody>';
        foreach ($translationTTG as $translationTTG) {
            $row = explode(" ", $translationTTG->translation);
            for ($i = 0; $i < count($row); $i++) {
                $result = str_replace(".", "", str_replace("”", "", str_replace(",", "", str_replace('“', "", $row[$i]))));
                $html .= '<tr class="">';
                $html .= '<td>' . $result . '</td>';
                $html .= '<td>';
                if (strlen($result) > 0) {
                    $translationClient = $this->db->like('translation', $result, 'both')->get_where('translation_memory', array('file_name' => 5));
                    foreach ($translationClient->result() as $res) {
                        $html .= '<table>
                        				<tr>
                                        	<td>' . $res->translation . '<td>
                                        </tr>
                                      </table>';
                    }
                    $html .= '</td>';
                }
                $html .= '</tr>';
            }
        }
        $html .= '</tbody></table>';
        echo $html;
    }

    public function sendVPOMail()
    {

        $mailTo = "mohamedtwins57@gmail.com";
        // $mailTo = "mohamed.elshehaby@thetranslationgate.com";
        $subject = "Vendor VPO Test ";

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.thetranslationgate.com',
            'smtp_port' => 465,
            'smtp_user' => 'falaqsystem@thetranslationgate.com',
            'smtp_pass' => 'GaU6FjtJ$*Hb8P-j',
            'charset' => 'utf-8',
            'validate' => TRUE,
            'wordwrap' => TRUE,
            'dkim_domain' => 'thetranslationgate.com',
            'dkim_private' => '/home/ubuntu/mail.private',
            'dkim_selector' => 'mail',
            'dkim_passphrase' => '',
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from("mohamed.elshehaby@thetranslationgate.com");
        $this->email->cc("mohamed.elshehaby@thetranslationgate.com");
        // replace my mail by pm manger it is just for testing
        $this->email->to($mailTo);
        $this->email->subject($subject);

        $msg = "Test";
        //echo $msg;
        $this->email->message($msg);
        $this->email->set_header('Reply-To', $pmMail);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function translationManagemet()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 178);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 178);
            //body ..
            $data['users'] = $this->db->get_where('users', array('role' => 27, 'status' => 1));
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/translationManagemet.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editTranslationManagement()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 178);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('users', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editTranslationManagement.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditTranslationManagement()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 178);
        if ($permission->edit == 1) {
            $id = $this->uri->segment(3);
            $data['teamleader'] = $_POST['teamleader'];

            if ($this->db->update('users', $data, array('id' => $id))) {
                $true = "Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/translationManagemet");
            } else {
                $error = "Failed To Edit ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/translationManagemet");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function systemTraining()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 181);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 181);
            //body ..
            $data['automation'] = $this->db->get('automation');
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/systemTraining.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function addSystemTraining()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 181);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/addSystemTraining.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddSystemTraining()
    {

        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 181);
        if ($permission->add == 1) {
            $data['title'] = $_POST['title'];
            $data['link'] = $_POST['link'];

            if ($this->db->insert('automation', $data)) {
                $true = "Added Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/systemTraining");
            } else {
                $error = "Failed To Add ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/systemTraining");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function editSystemTraining()
    {

        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 118);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 118);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['automation'] = $this->db->get_where('automation', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editSystemTraining.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditSystemTraining()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 118);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['title'] = $_POST['title'];
            $data['link'] = $_POST['link'];
            $this->admin_model->addToLoggerUpdate('automation', 118, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('automation', $data, array('id' => $id))) {
                $true = "Edited Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/systemTraining");
            } else {
                $error = "Failed To Edit ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/systemTraining");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function deleteSystemTraining($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 118);
        if ($check) {
            $this->admin_model->addToLoggerDelete('automation', 118, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('automation', array('id' => $id))) {
                $true = "Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/systemTraining");
            } else {
                $error = "Failed To Delete ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/systemTraining");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function viewTraining()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 181);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 181);
            //body ..
            $linkId = base64_decode($_GET['t']);
            $data['videoData'] = $this->db->get_where('automation', array('id' => $linkId))->row();
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/viewTraining.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updatePODate()
    {
        /*$pos = array('11553479','11553482','11553945','11553042','11553421','11552659','11549397','11550017','11550377','11552658','11550770','11554514','11554079','11555355','11555164','11555354','11555356','11555292','11555293','11555714','11555876','11554688','11553947','11553329','11555877','11555032','11554695','11555357','11555163','11558283','11558282','11557347','11555878','11558284','11557349','11557348','11556612','11556626','11558689','11559302','11554687','11556610','11556609','11556607','11556611','11556608','11558530','11557414','11559259','11558285','11559751','11555933','11560348','11560683','11562473','11561929','11562472','11560678','11561103','11561794','11561793','11561631','11561104','11561930');
        for($i=0;$i<count($pos);$i++){
            $poNumber = $pos[$i];
            $poID = $this->db->query("SELECT * FROM `po` WHERE `number` LIKE '$poNumber'")->row()->id;
            $this->db->query("UPDATE `po` SET `created_at` = '2022-03-04 00:00:00' WHERE `number` LIKE '$poNumber'");
            $this->db->query("UPDATE `job` SET `closed_date` = '2022-03-04 00:00:00' WHERE po = '$poID'");
            echo "updated: ".$poNumber." Job: ".$poID."</br>";
        }*/
    }
    public function vendorsAccounts()
    {
        $check = $this->admin_model->checkPermission($this->role, 200);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 200);
            //body ..
            $limit = 9;
            $offset = $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $config['base_url'] = base_url('admin/vendorsAccounts');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            // $config['total_rows'] = $count;
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

            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $arr2 = $arr1 = array();
            $scren_var = ['name', 'email'];

            if (rtrim($_SERVER['HTTP_REFERER'], '/') != base_url('projects/allTasks')) {
                for ($i = 0; $i < count($scren_var); $i++) {
                    $this->session->unset_userdata($scren_var[$i]);
                    $data[$scren_var[$i]] = "";
                }
            }

            if ($this->session->userdata('name')) {
                $name = $data['name'] = $this->session->userdata('name');
            }
            if ($this->session->userdata('email')) {
                $email = $data['email'] = $this->session->userdata('email');
            }
            if ($this->input->post('search')) {
                $name = $this->input->post('name');
                $email = $this->input->post('email');

                if (!empty($name)) {
                    $this->session->set_userdata('name', $name);
                } else {
                    $this->session->unset_userdata('name');
                }
                if (!empty($email)) {
                    $this->session->set_userdata('email', $email);
                } else {
                    $this->session->unset_userdata('email');
                }
            } elseif ($this->input->post('submitReset')) {
                $this->session->unset_userdata('name');
                $name = "";
                $this->session->unset_userdata('email');
                $email = "";
            }
            $name = $data['name'] = $this->session->userdata('name');
            $email = $data['email'] = $this->session->userdata('email');
            if (!empty($name)) {
                $data['name'] = $name;
                array_push($arr2, 0);
                array_push($arr1, "name LIKE '%" . $name . "%'");
            }
            if (!empty($email)) {
                $data['email'] = $email;
                array_push($arr2, 1);
                array_push($arr1, "email LIKE '%" . $email . "%'");
            }
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$i]);
            }
            $arr4 = implode(" and ", $arr3) . " and brand = '" . $this->brand . "'";

            if ($arr_1_cnt > 0) {
                $data['vendorsAccounts'] = $this->admin_model->AllRecordsPagesLib('vendor', $arr4, $limit, $offset, 'name');
                $count = $this->admin_model->AllRecordsLib('vendor', $arr4)->num_rows();
            } else {
                $data['vendorsAccounts'] = $this->admin_model->AllRecordsPagesLib('vendor', "brand = '" . $this->brand . "'", $limit, $offset, 'name');
                $count = $this->admin_model->AllRecordsLib('vendor', '1')->num_rows();

            }
            $data['total_rows'] = $count;
            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/vendorsAccounts.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }


    public function editVendorAccount()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 200);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['id'] = base64_decode($_GET['t']);
            $data['row'] = $this->db->get_where('vendor', array('id' => $data['id']))->row();

            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/editVendorAccount.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    // start new permission design
    public function rolePermissions($role_id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 3);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
            //body ..
            $data['role'] = $this->db->get_where('role', array('id' => $role_id))->row();
            $data['permissions'] = $this->db->get_where('permission', array('role' => $role_id))->result();
            $data['screens'] = $this->db->get('screen');
            //  $data['groups'] = $this->admin_model->getGroupByScreen($data['screen']);
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/rolePermissions.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function saveRolePermissions()
    {
        // Check Permission ..
        $check = $this->admin_model->getScreenByPermissionByRole($this->role, 3);
        if ($check->add == 1) {
            //            print_r($_POST);exit();
            $role_id = $_POST['role_id'];
            foreach ($_POST['screen_id'] as $screen) {
                $data['screen'] = $screen;
                $data['role'] = $_POST['role_id'];
                $data['follow'] = $_POST["follow_$screen"] ?? 0;
                $data['view'] = $_POST["view_$screen"] ?? 0;
                $data['add'] = $_POST["add_$screen"] ?? 0;
                $data['edit'] = $_POST["edit_$screen"] ?? 0;
                $data['delete'] = $_POST["delete_$screen"] ?? 0;
                $data['groups'] = $this->admin_model->getGroupByScreen($screen);

                // check if exists
                $checkRoles = $this->db->get_where('permission', array('role' => $data['role'], 'screen' => $data['screen']))->num_rows();
                // if not exists insert new one else update row
                if ($checkRoles == 0) {
                    // check if new data exits 
                    if ($data['follow'] > 0 || $data['view'] > 0 || $data['add'] > 0 || $data['edit'] > 0 || $data['delete'] > 0) {
                        if ($this->db->insert('permission', $data)) {
                            $true = "Permissions Added Successfully ...";
                            $this->session->set_flashdata('true', $true);
                        } else {
                            $error = "Failed To Add Permissions ...";
                            $this->session->set_flashdata('error', $error);
                        }
                    }
                } else {
                    if ($this->db->update('permission', $data, array('role' => $data['role'], 'screen' => $data['screen']))) {
                        $true = "Permission Added Successfully ...";
                        $this->session->set_flashdata('true', $true);
                    } else {
                        $error = "Failed To Add Permissions ...";
                        $this->session->set_flashdata('error', $error);
                    }
                }

            }
            redirect(base_url() . "admin/rolePermissions/$role_id");
        }
    }

    public function ResetAndGeneratePasswordUsers()
    {
        $users = $this->db->get_where("users", array('status' => '1', 'pass_reset' => '0'))->result();
        foreach ($users as $k => $user) {
            if ($user->id != 432 && $k <= 100) {
                $password = $this->vendor_model->generateVendorPassword();
                $data['password'] = base64_encode($password);
                $data['pass_reset'] = 1;
                $this->db->update('users', $data, array('id' => $user->id));
                $this->admin_model->sendUsersNewPassword($user->id);
            }
        }
    }

    public function SendNewPasswordTransUsers()
    {
        $users = $this->db->get_where("users", array('status' => '1', 'employees_id' => '41'))->result();
        foreach ($users as $user) {
            if ($user->brand == 1) {
                $this->admin_model->sendNewPasswordAccountsDetails($user->id);
            }
        }
    }

    // for logger
    public function listUserActivity()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 214);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 214);
            //body ..
            $data['user'] = $this->user;
            $data['brand'] = $this->brand;
            $limit = 9;
            $offset = $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            $config['base_url'] = base_url('admin/userLogger');
            $config['uri_segment'] = 3;
            $config['display_pages'] = TRUE;
            $config['per_page'] = $limit;
            // $config['total_rows'] = $count;
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

            $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $arr2 = $arr1 = array();

            if ($this->session->userdata('created_by')) {
                $created_by = $data['created_by'] = $this->session->userdata('created_by');
            }
            if ($this->session->userdata('table_name')) {
                $table_name = $data['table_name'] = $this->session->userdata('table_name');
            }
            if ($this->session->userdata('screen')) {
                $screen = $data['screen'] = $this->session->userdata('screen');
            }
            if ($this->session->userdata('type')) {
                $type = $data['type'] = $this->session->userdata('type');
            }
            if ($this->session->userdata('date_from')) {
                $date_from = $data['date_from'] = $this->session->userdata('date_from');
            }
            if ($this->session->userdata('date_to')) {
                $date_to = $data['date_to'] = $this->session->userdata('date_to');
            }
            //***********//
            if ($this->input->post('search')) {
                $created_by = $this->input->post('created_by');
                $table_name = $this->input->post('table_name');
                $screen = $this->input->post('screen');
                $type = $this->input->post('type');
                $date_from = date("Y-m-d", strtotime($this->input->post('date_from')));
                $date_to = date("Y-m-d", strtotime($this->input->post('date_to')));

                if (!empty($created_by)) {
                    $this->session->set_userdata('created_by', $created_by);
                } else {
                    $this->session->unset_userdata('created_by');
                }
                if (!empty($table_name)) {
                    $this->session->set_userdata('table_name', $table_name);
                } else {
                    $this->session->unset_userdata('table_name');
                }
                if (!empty($screen)) {
                    $this->session->set_userdata('screen', $screen);
                } else {
                    $this->session->unset_userdata('screen');
                }
                if (!empty($type)) {
                    $this->session->set_userdata('type', $type);
                } else {
                    $this->session->unset_userdata('type');
                }
                if (!empty($date_from)) {
                    $this->session->set_userdata('date_from', $date_from);
                } else {
                    $this->session->unset_userdata('date_from');
                }
                if (!empty($date_to)) {
                    $this->session->set_userdata('date_to', $date_to);
                } else {
                    $this->session->unset_userdata('date_to');
                }
                //********************//
            } elseif ($this->input->post('submitReset')) {
                $this->session->unset_userdata('created_by');
                $created_by = "";
                $this->session->unset_userdata('table_name');
                $table_name = "";
                $this->session->unset_userdata('screen');
                $screen = "";
                $this->session->unset_userdata('type');
                $type = "";
                $this->session->unset_userdata('date_from');
                $date_from = "";
                $this->session->unset_userdata('date_to');
                $date_to = "";
                //**********************//
            }
            $created_by = $data['created_by'] = $this->session->userdata('created_by');
            $table_name = $data['table_name'] = $this->session->userdata('table_name');
            $screen = $data['screen'] = $this->session->userdata('screen');
            $type = $data['type'] = $this->session->userdata('type');
            $date_from = $data['date_from'] = $this->session->userdata('date_from');
            $date_to = $data['date_to'] = $this->session->userdata('date_to');
            //**********************//
            if (!empty($created_by)) {
                $data['created_by'] = $created_by;
                array_push($arr2, 0);
                array_push($arr1, "created_by = '$created_by'");

            }
            if (!empty($table_name)) {
                $data['table_name'] = $table_name;
                array_push($arr2, 1);
                array_push($arr1, "table_name LIKE '%" . $table_name . "%'");
            }
            if (!empty($screen)) {
                $data['screen'] = $screen;
                array_push($arr2, 2);
                array_push($arr1, "screen = '$screen'");

            }
            if (!empty($type)) {
                $data['type'] = $type;
                array_push($arr2, 3);
                array_push($arr1, "type = '$type'");

            }
            if (!empty($date_from) && !empty($date_to)) {
                $data['date_from'] = $date_from;
                $data['date_to'] = $date_to;
                array_push($arr2, 4);
                array_push($arr1, "created_at BETWEEN '$date_from' AND '$date_to' ");

            }
            //************************//
            $arr_1_cnt = count($arr2);
            $arr3 = array();
            for ($i = 0; $i < $arr_1_cnt; $i++) {
                array_push($arr3, $arr1[$i]);
            }
            $arr4 = implode(" and ", $arr3);
            ini_set('memory_limit', '-1');
            if ($arr_1_cnt > 0) {
                $data['logger'] = $this->admin_model->AllRecordsPagesLib('logger', $arr4, $limit, $offset, 'id');
                $count = $this->admin_model->AllRecordsLib('logger', $arr4)->num_rows();
            } else {
                $data['logger'] = $this->admin_model->AllRecordsPagesLib('logger', '1', $limit, $offset, 'id');
                $count = $this->admin_model->AllRecordsLib('logger', '1')->num_rows();

            }
            $data['total_rows'] = $count;

            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/userLogger.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }


    }

    public function userLoggerRestoreData($id)
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 214);
        if ($permission->delete == 1) {
            // get current row id data of logger
            $row = $this->db->get_where('logger', array('id' => $id))->row();
            $table_name = $row->table_name;
            $transaction_id_name = $row->transaction_id_name;
            $transaction_id = $row->transaction_id;
            // if type restore data -> check first if id already exists          
            $checkID = $this->db->get_where($table_name, array($transaction_id_name => $transaction_id))->row();
            if (!empty($checkID)) {
                $error = "Failed To Run ,Duplicate entry for key 'PRIMARY' ";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
            // run current query              
            if ($this->db->query($row->data)) {
                // add to logger
                $this->admin_model->addToLoggerRestore("$table_name", 214, "$transaction_id_name", $transaction_id, 0, 0, $this->user);
                $true = "Query runs Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Run ,Check DB...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doAddUserData()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($permission->add == 1) {
            // check if alredy exists with email || username && employees_id
            $check_employee = $this->db->get_where('master_user', array('employees_id' => $_POST['employees']))->num_rows();
            if ($check_employee == 0) {
                $where = "email='" . $_POST['email'] . "' OR user_name='" . $_POST['user_name'] . "'";
                $check_email = $this->db->where($where)->get('master_user')->num_rows();
                if ($check_email == 0) {
                    // get last code;
                    $last_code = $this->db->select_max('ccode')->get('master_user')->row()->ccode;
                    $ccode = $data['ccode'] = $last_code ? $last_code + 1 : "00001";
                    $data['user_name'] = $_POST['user_name'];
                    $data['email'] = $_POST['email'];
                    $data['password'] = base64_encode($_POST['password']);
                    $data['employees_id'] = $_POST['employees'];
                    $data['phone'] = $_POST['phone'];
                    $data['status'] = 1;
                    if ($this->db->insert('master_user', $data)) {
                        $user_id = $this->db->insert_id();
                        $error = "";
                        foreach ($_POST['accountFirstName'] as $k => $val) {
                            $num = $k + 1;
                            // check if brand account already exists with employees_id & brand
                            // update : check if email already exists with employees_id 
                            $check_account = $this->db->get_where('users', array('employees_id' => $_POST['employees'], 'email' => $_POST['accountEmail'][$k]))->num_rows();
                            if ($check_account == 0) {
                                $accountData['first_name'] = $_POST['accountFirstName'][$k];
                                $accountData['last_name'] = $_POST['accountLastName'][$k];
                                $accountData['user_name'] = $_POST['accountUserName'][$k];
                                $accountData['abbreviations'] = $_POST['accountAbbreviations'][$k];
                                $accountData['email'] = $_POST['accountEmail'][$k];
                                $accountData['role'] = $_POST['accountRole'][$k];
                                $accountData['brand'] = $_POST['accountBrand'][$k];
                                $accountData['employees_id'] = $_POST['employees'];
                                $accountData['password'] = base64_encode($_POST['password']);
                                $accountData['master_user_id'] = $user_id;
                                $accountData['master_user_code'] = $ccode;
                                $accountData['status'] = 1;

                                if ($this->db->insert('users', $accountData)) {
                                } else {
                                    $error .= "Failed To Add Account#$num For brand : " . $this->admin_model->getBrand($_POST['accountBrand'][$k]) . "<br/>";
                                }
                            } else {
                                $error .= "Failed To Add Account#$num (Email Already Exists) <br/>";
                            }
                        }
                        if (strlen($error) > 0) {
                            $this->session->set_flashdata('error', $error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {

                            $true = "User Added Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            redirect(base_url() . "admin/masterUsers");
                        }
                    } else {
                        $error = "Failed To Add User ...";
                        $this->session->set_flashdata('error', $error);
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $error = "This Email Or User Name Already Exists In Master Users...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Employee Already Has Master Account ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function doEditUserData()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
        if ($permission->edit == 1) {
            $id = $_POST['id'];

            $check_employee = $this->db->get_where('master_user', array('employees_id' => $_POST['employees'], 'id !=' => $id))->num_rows();
            if ($check_employee == 0) {
                $where = "id != " . $id . " AND (email='" . $_POST['email'] . "' OR user_name='" . $_POST['user_name'] . "')";
                $check_email = $this->db->where($where)->get('master_user')->num_rows();
                if ($check_email == 0) {
                    $data['user_name'] = $_POST['user_name'];
                    $data['email'] = $_POST['email'];
                    $data['password'] = base64_encode($_POST['password']);
                    $data['employees_id'] = $_POST['employees'];
                    $data['phone'] = $_POST['phone'];
                    $data['status'] = $_POST['status'];
                    if ($this->db->update('master_user', $data, array('id' => $id))) {
                        $ccode = $this->db->get_where('master_user', array('id' => $id))->row()->ccode;
                        $error = "";
                        foreach ($_POST['accountFirstName'] as $k => $val) {
                            $accountData['first_name'] = $_POST['accountFirstName'][$k];
                            $accountData['last_name'] = $_POST['accountLastName'][$k];
                            $accountData['user_name'] = $_POST['accountUserName'][$k];
                            $accountData['abbreviations'] = $_POST['accountAbbreviations'][$k];
                            $accountData['email'] = $_POST['accountEmail'][$k];
                            $accountData['role'] = $_POST['accountRole'][$k];
                            $accountData['brand'] = $_POST['accountBrand'][$k];
                            $accountData['employees_id'] = $_POST['employees'];
                            $accountData['password'] = base64_encode($_POST['password']);
                            $accountData['master_user_id'] = $id;
                            $accountData['master_user_code'] = $ccode;
                            $accountData['status'] = $_POST['status'] == 0 ? $_POST['status'] : $_POST['accountStatus'][$k];
                            if (!empty($_POST['accountId'][$k])) {
                                $num = $k + 1;
                                // check if brand account already exists with employees_id & brand
                                // update : check if email already exists with employees_id                       
                                $check_account = $this->db->get_where('users', array('employees_id' => $_POST['employees'], 'email' => $_POST['accountEmail'][$k], 'id !=' => $_POST['accountId'][$k]))->num_rows();
                                if ($check_account == 0) {
                                    if ($this->db->update('users', $accountData, array('id' => $_POST['accountId'][$k]))) {

                                    } else {
                                        $error .= "Failed To Add Account#$num For brand : " . $this->admin_model->getBrand($_POST['accountBrand'][$k]) . "<br/>";
                                    }
                                } else {
                                    $error .= "Failed To Edit Account#$num (Email Already Exists) <br/>";
                                }
                            } else {
                                // check if brand account already exists with employees_id & brand
                                // update : check if email already exists with employees_id     
                                $check_account = $this->db->get_where('users', array('employees_id' => $_POST['employees'], 'email' => $_POST['accountEmail'][$k]))->num_rows();
                                if ($check_account == 0) {
                                    if ($this->db->insert('users', $accountData)) {

                                    } else {
                                        $error .= "Failed To Add Account#$num For brand : " . $this->admin_model->getBrand($_POST['accountBrand'][$k]) . "<br/>";
                                    }
                                } else {

                                    $error .= "Failed To Add Account#$num (Email Already Exists) <br/>";
                                }
                            }
                        }
                        if (strlen($error) > 0) {
                            $this->session->set_flashdata('error', $error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $true = "User Edited Successfully ...";
                            $this->session->set_flashdata('true', $true);
                            redirect(base_url() . "admin/masterUsers");
                        }
                    } else {
                        $error = "Failed To Edit User ...";
                        $this->session->set_flashdata('error', $error);
                        redirect(base_url() . "admin/masterUsers");
                    }
                } else {
                    $error = "This Email Or User Name Already Exists In Master Users...";
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $error = "This Employee Already Has Master Account ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function masterUsers()
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 1);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 1);
            //body ..
            if (isset($_GET['search'])) {
                $where = " 1 ";
                if (isset($_REQUEST['employee_name'])) {
                    $employee_name = $_REQUEST['employee_name'];
                    if (!empty($employee_name)) {
                        $data['employee_name'] = $employee_name;
                        $where .= " AND (ms.employees_id = $employee_name)";
                    }
                }
                if (isset($_REQUEST['user_name'])) {
                    $user_name = $_REQUEST['user_name'];
                    if (!empty($user_name)) {
                        $data['user_name'] = $user_name;
                        $where .= " AND (ms.user_name = '$user_name' OR us.user_name = '$user_name')";
                    }
                }
                if (isset($_REQUEST['brand'])) {
                    $brand = $_REQUEST['brand'];
                    if (!empty($brand)) {
                        $data['brand'] = $brand;
                        $where .= " AND us.brand = '$brand'";
                    }
                }
                if (isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    if (!empty($email)) {
                        $data['email'] = $email;
                        $where .= " AND (ms.email LIKE '%$email%' OR us.email LIKE '%$email%')";
                    }
                }
                if (isset($_REQUEST['abbreviations'])) {
                    $abbreviations = $_REQUEST['abbreviations'];
                    if (!empty($abbreviations)) {
                        $data['abbreviations'] = $abbreviations;
                        $where .= " AND abbreviations = '$abbreviations'";
                    }
                }
                if (isset($_REQUEST['status'])) {
                    $status = $_REQUEST['status'];
                    $data['status'] = $status;
                    if (!empty($status)) {
                        if ($status == 2) {
                            $status = 0;
                        }

                        $where .= " AND (ms.status = '$status' OR us.status = '$status')";
                    }
                }

                $data['users'] = $this->db->query("SELECT ms.* from master_user as ms left join users as us on us.master_user_code = ms.ccode  where $where group BY ms.id");


            } else {
                $data['users'] = $this->db->get('master_user');
            }
            //start breadcrumb
            // $this->breadcrumbs->add('Home', base_url() . 'admin');
            // $this->breadcrumbs->add('Users', base_url() . 'admin/masterUsers');
            // $data['breadcrumb'] = $this->breadcrumbs->output();
            //end breadcrumb
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/usersNew.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function InsertDataIntoMasterUsers()
    {
        exit();
        $insertCount = 0;
        $updateCount = 0;
        $employees = $this->db->select('distinct(employees_id)')->where('employees_id !=', 0)->get('users')->result();
        foreach ($employees as $emp) {
            $user = $this->db->get_where("users", array('employees_id' => $emp->employees_id))->row();
            $last_code = $this->db->select_max('ccode')->get('master_user')->row()->ccode;
            $ccode = $data['ccode'] = $last_code ? $last_code + 1 : "00001";
            $data['user_name'] = $user->user_name;
            $data['email'] = $user->email;
            $data['password'] = $user->password;
            $data['employees_id'] = $user->employees_id;
            $data['phone'] = $user->phone;
            $data['status'] = $user->status;
            if ($this->db->insert('master_user', $data)) {
                $insertCount++;
                $user_id = $this->db->insert_id();
                $accountData['master_user_id'] = $user_id;
                $accountData['master_user_code'] = $ccode;
                if ($this->db->update('users', $accountData, array('employees_id' => $user->employees_id))) {
                    $c = $this->db->get_where("users", array('employees_id' => $user->employees_id))->num_rows();
                    $updateCount += $c;
                }
            }
        }
        // users with employees_id =0
        $emptyUsers = $this->db->get_where("users", array('employees_id' => 0))->result();
        foreach ($emptyUsers as $user) {

            $last_code = $this->db->select_max('ccode')->get('master_user')->row()->ccode;
            $ccode = $data['ccode'] = $last_code ? $last_code + 1 : "00001";
            $data['user_name'] = $user->user_name;
            $data['email'] = $user->email;
            $data['password'] = $user->password;
            $data['employees_id'] = $user->employees_id;
            $data['phone'] = $user->phone;
            $data['status'] = $user->status;
            if ($this->db->insert('master_user', $data)) {
                $user_id = $this->db->insert_id();
                $accountData['master_user_id'] = $user_id;
                $accountData['master_user_code'] = $ccode;
                $this->db->update('users', $accountData, array('id' => $user->id));
            }
        }
        echo 'Num Of Master Users Inserted = ' . $insertCount;
        echo '<br> Num Of Users Updated = ' . $updateCount;
    }

    public function switchBrand()
    {
        $brand = $this->input->post('brand');
        $email = $this->input->post('email');
        $user = $this->db->get_where('master_user', array('id' => $this->session->userdata('master_user'), 'status' => '1'));
        $check = $user->num_rows();

        if ($check > 0) {
            $master_user = $user->row();
            $user_account = $this->db->get_where('users', array('employees_id' => $master_user->employees_id, 'master_user_id' => $master_user->id, 'brand' => $brand, 'email' => $email, 'status' => '1'))->row();
            if ($user_account) {
                $data = $user_account;
                $login = array(
                    'id' => $data->id,
                    'username' => $data->user_name,
                    'role' => $data->role,
                    'brand' => $data->brand,
                    'emp_id' => $data->employees_id,
                    'master_user' => $data->master_user_id,
                    'loggedin' => 1
                );
                $this->session->set_userdata($login);
                $accountData['favourite_brand_id'] = $data->brand;
                $accountData['last_login'] = date("Y-m-d H:i:s");
                $this->db->update('master_user', $accountData, array('id' => $data->master_user_id));
                $response['status'] = "success";

                // redirect(base_url().'admin');
            } else {
                $this->session->sess_destroy();
                $response['status'] = "error";
                $response['msg'] = "Your Account Isn't Actived For This Brand ... Please Check...";

                //redirect(base_url()."login");
            }
        } else {
            $this->session->sess_destroy();
            $response['status'] = "error";
            $response['msg'] = "Please Login First...";

            // redirect(base_url()."login");
        }
        echo json_encode($response);
    }

    // send emails with master details
    public function SendMasterUsersPassword()
    {
        $count = 0;
        $last_id = 0;
        $users = $this->db->get_where("master_user", array('status' => '1'))->result();
        foreach ($users as $user) {
            //            if($user->id == 26){
            $this->admin_model->sendMasterUsersNewPassword($user->id);
            $count++;
            $last_id = $user->id;

            //            }
        }
        echo '<br> Num Of Users  = ' . $count;
        echo '<br> last ID   = ' . $last_id;
    }
    // Offices //
    public function offices()
    {
        $check = $this->admin_model->checkPermission($this->role, 120);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
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
                $cond2 = "brand ='$this->brand'";
                $arr1 = array($cond1, $cond2);
                $arr_1_cnt = count($arr2);
                $arr3 = array();
                for ($i = 0; $i < $arr_1_cnt; $i++) {
                    array_push($arr3, $arr1[$arr2[$i]]);
                }
                $arr4 = implode(" and ", $arr3);
                if ($arr_1_cnt > 0) {
                    $data['offices'] = $this->admin_model->AllOffices($arr4);
                } else {
                    $data['offices'] = $this->admin_model->AllOfficesPages(9, 0);
                }
                $data['total_rows'] = $data['offices']->num_rows();
            } else {
                $limit = 9;
                $offset = $this->uri->segment(3);
                if ($this->uri->segment(3) != NULL) {
                    $offset = $this->uri->segment(3);
                } else {
                    $offset = 0;
                }
                $count = $this->admin_model->AllOffices(1)->num_rows();

                $config['base_url'] = base_url('admin/offices');
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

                $data['offices'] = $this->admin_model->AllOfficesPages($limit, $offset, $this->brand);
                $data['total_rows'] = $count;
            }
            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/offices.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function officesAdd()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($data['permission']->add == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            //body ..
            $data['brand'] = $this->brand;
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/officesAdd.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doAddOffices()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($permission->add == 1) {
            $data['brand'] = $this->brand;
            $data['name'] = $_POST['name'];
            $data['office_desc'] = $_POST['office_desc'];
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            $dub = $this->db->get_where('ttg_branch', array('name' => $_POST['name'], 'brand' => $this->brand))->num_rows();
            if ($dub > 0) {
                $error = "Duplicated Entry Office Name ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/offices");

            } else {
                if ($this->db->insert('ttg_branch', $data)) {
                    $true = "Office Added Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/offices");
                } else {
                    $error = "Failed To Add Office ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/offices");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function officesEdit()
    {
        // Check Permission ..
        $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($data['permission']->edit == 1) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
            //body ..
            $id = base64_decode($_GET['t']);
            $data['offices'] = $this->db->get_where('ttg_branch', array('id' => $id))->row();
            //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/officesEdit.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function doEditOffices()
    {
        // Check Permission ..
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 120);
        if ($permission->edit == 1) {
            $id = base64_decode($_POST['id']);
            $data['brand'] = $this->brand;
            $data['name'] = $_POST['name'];
            $data['office_desc'] = $_POST['office_desc'];
            $dub = $this->db->get_where('ttg_branch', array('name' => $_POST['name'], 'brand' => $this->brand, 'id <>' => $id))->num_rows();
            if ($dub > 0) {
                $error = "Duplicated Entry Office Name ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/offices");
            } else {
                $this->admin_model->addToLoggerUpdate('ttg_branch', 120, 'id', $id, 0, 0, $this->user);
                if ($this->db->update('ttg_branch', $data, array('id' => $id))) {
                    $true = "Office Edited Successfully ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "admin/offices");
                } else {
                    $error = "Failed To Edit Office ...";
                    $this->session->set_flashdata('error', $error);
                    redirect(base_url() . "admin/offices");
                }
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function officesDelete($id)
    {
        // Check Permission ..
        $check = $this->admin_model->checkPermission($this->role, 120);
        if ($check) {
            $this->admin_model->addToLoggerDelete('ttg_branch', 120, 'id', $id, 0, 0, $this->user);
            if ($this->db->delete('ttg_branch', array('id' => $id))) {
                $true = "Office Deleted Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect(base_url() . "admin/offices");
            } else {
                $error = "Failed To Delete Office ...";
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . "admin/offices");
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function managerQCcategory()
    {
        $check = $this->admin_model->checkPermission($this->role, 232);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 232);

            $limit = 10;
            $offset = $this->uri->segment(3);
            if ($this->uri->segment(3) != NULL) {
                $offset = $this->uri->segment(3);
            } else {
                $offset = 0;
            }
            $count = $this->db->get('qcchklist_cat')->num_rows();
            $config['base_url'] = base_url('admin/managerQCcategory');
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

            $data['qcchklist_cat'] = $this->db->query("SELECT * FROM `qcchklist_cat` Order By id  LIMIT $limit OFFSET $offset ");

            $data['total_rows'] = $count;

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/managerQCcategory.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function savemanagerQCcategory()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 232);
        if ($permission->add == 1) {
            $data['name'] = trim($_POST['name']);
            $data['created_by'] = $this->user;
            $data['created_at'] = date("Y-m-d H:i:s");
            if ($this->db->insert('qcchklist_cat', $data)) {
                $true = "Data Saved Successfully ...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $error = "Failed To Add Data ...";
                $this->session->set_flashdata('error', $error);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }

    public function updatemanagerQCcategory()
    {
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 232);
        if ($permission->edit == 1) {
            $id = $_POST['id'];
            $data['name'] = trim($_POST['name']);
            $this->admin_model->addToLoggerUpdate('qcchklist_cat', 232, 'id', $id, 0, 0, $this->user);
            if ($this->db->update('qcchklist_cat', $data, array('id' => $id))) {
                $true = "Data Updated Successfully...";
                $this->session->set_flashdata('true', $true);
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            echo "You have no permission to access this page";
        }
    }
	
}
?>   