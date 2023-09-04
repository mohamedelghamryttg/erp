<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }
    public function index()
    {

        $this->load->view('login_new.php');
    }

    public function doLogin()
    {
        $email = $this->input->post('email');
        $password = base64_encode($this->input->post('password'));
        $user = $this->db->get_where('master_user', array('email' => $email, 'password' => $password, 'status' => '1'));

        $check = $user->num_rows();
        if ($check > 0) {
            $master_user = $user->row();
            if (!empty($master_user->favourite_brand_id)) {
                $brand = $master_user->favourite_brand_id;
            } else {
                $brand = $this->db->get_where("users", array('master_user_id' => $master_user->id, 'status' => '1'))->row()->brand;
            }
            $user_account = $this->db->get_where('users', array('employees_id' => $master_user->employees_id, 'master_user_id' => $master_user->id, 'brand' => $brand, 'status' => '1'))->row();
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
                // set favourite_brand_id
                $accountData['favourite_brand_id'] = $data->brand;
                $accountData['last_login'] = date("Y-m-d H:i:s");
                $this->db->update('master_user', $accountData, array('id' => $data->master_user_id));
                $this->session->set_userdata($login);
                redirect(base_url() . 'admin');
            } else {
                $other_account = $this->db->get_where('users', array('employees_id' => $master_user->employees_id, 'master_user_id' => $master_user->id, 'status' => '1'))->row();
                if ($other_account) {
                    $data = $other_account;
                    $login = array(
                        'id' => $data->id,
                        'username' => $data->user_name,
                        'role' => $data->role,
                        'brand' => $data->brand,
                        'emp_id' => $data->employees_id,
                        'master_user' => $data->master_user_id,
                        'loggedin' => 1
                    );
                    // set favourite_brand_id
                    $accountData['favourite_brand_id'] = $data->brand;
                    $accountData['last_login'] = date("Y-m-d H:i:s");
                    $this->db->update('master_user', $accountData, array('id' => $data->master_user_id));
                    $this->session->set_userdata($login);
                    redirect(base_url() . 'admin');
                } else {
                    $true = "Your Combination Of Username And Password Are Incorrect ...";
                    $this->session->set_flashdata('true', $true);
                    redirect(base_url() . "login");
                }
            }
        } else {
            $true = "Your Combination Of Username And Password Are Incorrect ...";
            $this->session->set_flashdata('true', $true);
            redirect(base_url() . "login");
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'login');
    }

    public function attendanceTest()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://attendance.thetranslationgate.com:8080/abc/index.php/api/attendanceTest");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "filter=1");
        $data['attendance'] = json_decode(curl_exec($ch), TRUE);
        print_r($data['attendance']);
        // $this->load->view('hr/attendanceTest.php',$data);
    }



}
?>