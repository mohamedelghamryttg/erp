<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Overview extends CI_Controller
{

  public $role, $user, $brand, $chart;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('Excelfile');
    $this->load->helper('form');
    $this->load->helper('html');
    $this->admin_model->verfiyLogin();
    $this->load->model('AccountModel');
    $this->load->model('CreateDatabase');
    $this->load->library('form_validation');
    $this->role = $this->session->userdata('role');
    $this->user = $this->session->userdata('id');
    $this->brand = $this->session->userdata('brand');
  }
  //*************** Overview */
  public function accounts()
  {

    if (1 == 2) {
      $this->session->set_flashdata('message', 'ahmedhmed');
    }


    $check = $this->admin_model->checkPermission($this->role, 215);
    if ($check) {
      //header ..
      $data['group'] = $this->admin_model->getGroupByRole($this->role);
      $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 215);

      $data['brand'] = $this->brand;


      $this->load->view('includes_new/header.php', $data);
      $this->load->view('account/overview');
      $this->load->view('includes_new/footer.php');
    } else {
      echo "You have no permission to access this page";
    }

  }
  public function month_sales_amount()
  {
    $setup = $this->AccountModel->getsetup();
    $vs_date1 = date('Y-m-d', strtotime($setup->sdate1));
    $vs_date2 = date('Y-m-d', strtotime($setup->sdate2));

    $this->db->select('year(issue_date) as year, month(issue_date) as month, sum(payment) as total_payment ');
    $this->db->from('invoices');
    // $this->db->where('brand', $this->brand);
    $this->db->where('issue_date BETWEEN "' . $vs_date1 . '" AND "' . $vs_date2 . '" ');
    $this->db->group_by('year(issue_date), month(issue_date)');
    $this->db->order_by("month(issue_date)");

    $query = $this->db->get();
    $data['table_invoice'] = $query->result();

    // $query1 = $this->db->query("SELECT SUM(payment) as count FROM invoices GROUP BY year(issue_date), month(issue_date) ORDER BY month(issue_date)");
    // $data['click'] = array_column($query1->result(), 'count');
    // $query2 = $this->db->query("SELECT SUM(payment) as count FROM invoices GROUP BY year(issue_date), month(issue_date) ORDER BY month(issue_date)");

    // $data['viewer'] = array_column($query2->result(), 'count');
    if ($query->num_rows() > 0) {
      $total_amount = 0;
      foreach ($query->result() as $value) {
        $total_amount += $value->total_payment;
      }

      $data['month_sales_amount'] = $total_amount;
      echo json_encode($data);
    } else {
      echo json_encode('');
    }
  }
  function receivables_calc()
  {
    $setup = $this->AccountModel->getsetup();
    $vs_date1 = date('Y-m-d', strtotime($setup->sdate1));
    $vs_date2 = date('Y-m-d', strtotime($setup->sdate2));
    $rec_code = $setup->cust_acc_id;
    
    $this->db->select('year(issue_date) as year, month(issue_date) as month, sum(payment) as total_payment ');
    $this->db->from('invoices');
    // $this->db->where('brand', $this->brand);
    $this->db->where('issue_date BETWEEN "' . $vs_date1 . '" AND "' . $vs_date2 . '" ');
    $this->db->group_by('year(issue_date), month(issue_date)');
    $this->db->order_by("month(issue_date)");

  }
  function bank_balance()
  {
    $setup = $this->AccountModel->getsetup();
    $vs_date1 = date('d-m-Y', strtotime($setup->sdate1));
    $vs_date2 = date('d-m-Y', strtotime($setup->sdate2));

    $sql = "
        SELECT
        p.*,
        SUM(p.net_amount) AS payment,
        pm.name,
        (select name from currency where id=p.currency) AS currency_name,
        (select name from bank where id=pm.bank) as bank_name
      FROM
        payment p
      INNER JOIN
        payment_method pm ON p.payment_method = pm.id
      WHERE
        p.payment_method IN(
        SELECT
          id
        FROM
          payment_method
        WHERE TYPE
          = '2'
      ) and pm.brand = '" . $this->brand . "'
        and  p.payment_date >= '" . $vs_date1 . "' and payment_date <= '" . $vs_date2 . "'
        group by p.payment_method
        order by pm.name,p.currency";

    $sql1 = "
        SELECT
 SUM((j.rate * j.count)) AS payment,p.*,
pm.name,
        (select name from currency where id=j.currency) AS currency_name,
        (select name from bank where id=pm.bank) as bank_name
	
FROM
  vendor_payment AS p
  INNER JOIN
        payment_method pm ON p.payment_method = pm.id
LEFT OUTER JOIN
  job_task AS j ON j.id = p.task
  where
  p.payment_method IN(
        SELECT
          id
        FROM
          payment_method
        WHERE TYPE
          = '2'
      ) and pm.brand = '" . $this->brand . "'
      and  p.payment_date >= '" . $vs_date1 . "' and payment_date <= '" . $vs_date2 . "'
        group by p.payment_method
        order by pm.name,j.currency;
        ";

    $sql2 = "select t.*,t.payment as in_pay,xx.payment as out_pay from 
(SELECT p.*,
        SUM(p.net_amount) AS payment,
        pm.name,
        (select name from currency where id=p.currency) AS currency_name,
        (select name from bank where id=pm.bank) as bank_name
      FROM
        payment p
      INNER JOIN
        payment_method pm ON p.payment_method = pm.id
      WHERE
        p.payment_method IN(
        SELECT
          id
        FROM
          payment_method
        WHERE TYPE
          = '2'
      )and pm.brand = '" . $this->brand . "'
      and  p.payment_date >= '" . $vs_date1 . "' and payment_date <= '" . $vs_date2 . "'
        group by p.payment_method
        order by pm.name,p.currency
) as t

inner JOIN 

(SELECT
 SUM((j.rate * j.count)) AS payment,p.*,
pm.name,
        (select name from currency where id=j.currency) AS currency_name,
        (select name from bank where id=pm.bank) as bank_name
FROM
  vendor_payment AS p
  INNER JOIN
        payment_method pm ON p.payment_method = pm.id
LEFT OUTER JOIN
  job_task AS j ON j.id = p.task
  where
  p.payment_method IN(
        SELECT
          id
        FROM
          payment_method
        WHERE TYPE
          = '2'
      ) and pm.brand = '" . $this->brand . "'
      and  p.payment_date >= '" . $vs_date1 . "' and payment_date <= '" . $vs_date2 . "'
    group by p.payment_method
        order by pm.name,j.currency) as xx
        on
        xx.payment_method = t.payment_method";
    // print_r($sql);
    print_r($sql2);
    die;
    $query = $this->db->query($sql2);
    $data['bank_payments'] = $query->result();
    if ($query->num_rows() > 0) {
      echo json_encode($data);
    } else {
      echo json_encode('');
    }


  }

}