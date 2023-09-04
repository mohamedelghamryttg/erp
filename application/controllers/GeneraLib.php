<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GeneraLib extends CI_Controller
{
    var $role, $user, $brand;
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Excelfile');
        $this->admin_model->verfiyLogin();
        $this->role = $this->session->userdata('role');
        $this->brand = $this->session->userdata('brand');
        $this->user = $this->session->userdata('id');
    }

    public function GenListPages($screen, $dbf_file, $view_name, $search_array, $search, $reset)
    {
        $check = $this->admin_model->checkPermission($this->role, $screen);
        if ($check) {
            //header ..
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, $screen);
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
            for ($i = 0; $i < $search_array; $i++) {
                if (strtotime($search_array->name) !== false) {
                    $var = $data[$search_array->name] = $this->session->userdata($search_array->name);
                } else {
                    if ($this->session->userdata($search_array->name)) {
                        $var = $data[$search_array->name] = $this->session->userdata($search_array->name);
                    }
                }

                $var = $this->input->post('date_from');

            }


            if ($search) {
                $var = $this->input->post($search_array->name);
                if (!empty($name)) {
                    $this->session->set_userdata($search_array->name, $name);
                } else {
                    $this->session->unset_userdata($search_array->name);
                }

                $date_from = $this->input->post('date_from');
                $date_to = $this->input->post('date_to');
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
                array_push($arr1, "name LIKE '%$name%'");
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
                array_push($arr3, $arr1[$arr2[$i]]);
            }
            $arr4 = implode(" and ", $arr3);

            if ($arr_1_cnt > 0) {
                $data['languages'] = $this->admin_model->RecordsPagesLib($dbf_file, $arr4, 'name', $limit, $offset);
                $count = $this->admin_model->AllRecordsPagesLib($dbf_file, $arr4)->num_rows();
            } else {
                $data['languages'] = $this->admin_model->RecordsPagesLib($dbf_file, '1', 'name', $limit, $offset);
                $count = $this->admin_model->AllRecordsPagesLib($dbf_file, '1')->num_rows();
            }
            $data['total_rows'] = $count;
            $config['total_rows'] = $count;
            $this->pagination->initialize($config);

            // //Pages ..
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('admin_new/' . $view_name);
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }

}