<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AccountReport extends CI_Controller
{

    public $role, $user, $brand, $chart;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form', 'html');
        $this->load->library('Excelfile');
        $this->admin_model->verfiyLogin();
        $this->load->model('AccountModel');
        $this->load->library('form_validation');
        $this->role = $this->session->userdata('role');
        $this->user = $this->session->userdata('id');
        $this->brand = $this->session->userdata('brand');
    }
    public function dataEntryRep()
    {
        $check = $this->admin_model->checkPermission($this->role, 228);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 228);
            $data['brand'] = $this->brand;

            $data['user'] = $this->user;
            $trns_type = $this->input->post('acc_type');
            $setup = $this->AccountModel->getsetup();
            $data['acc_setup'] = $setup;

            $data['vs_date1'] = $setup->sdate1;
            $data['vs_date2'] = date('Y-m-d', strtotime($setup->sdate2));

            $data['startrom'] = 0;

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/report/dataEntryRep');
            $this->load->view('includes_new/footer.php');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function dataEntryRep_list()
    {
        $check = $this->admin_model->checkPermission($this->role, 228);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 228);
            $data['brand'] = $this->brand;

            $data['user'] = $this->user;

            $trns_type = $this->input->post('acc_type');
            $trns_date1 = date('Y-m-d', strtotime($this->input->post('date1')));
            $trns_date2 = date('Y-m-d', strtotime($this->input->post('date2')));
            $setup = $this->AccountModel->getsetup();
            $data['acc_setup'] = $setup;

            $data['vs_date1'] = date('Y-m-d', strtotime($setup->sdate1));
            $data['vs_date2'] = date('Y-m-d', strtotime($setup->sdate2));
            $trns_type_id = '';
            $where = '(brand = "' . $this->brand . '") and (trns_date BETWEEN  "' . $trns_date2 . '" and "' . $trns_date1 . '") ';

            switch ($trns_type) {
                case '1':
                    $where .= " and (trns_type = 'Begin Entry')";
                    break;
                case '2':
                    $where .= " and (trns_type = 'Cash In' or trns_type = 'Cash Out')";
                    break;
                case '3':
                    $where .= " and (trns_type = 'Revenue')";
                    break;
                case '4':
                    $where .= " and (trns_type = 'Expenses')";
                    break;
                case '5':
                    $where .= " and (trns_type = 'Bank In' or trns_type = 'Bank Out')";
                    break;
                case '6':
                    $where .= " and (trns_type = 'Recivebal')";
                    break;
                case '7':
                    $where .= " and (trns_type = 'Payable')";
                    break;
                case '8':
                    $where .= " and (trns_type = 'Manual Entry')";
                    break;
                case '9':
                    break;

                default:
                    $where .= " and (1 = 2)";
                    break;
            }
            // $data['entry_rep'] = $this->db->query("select * from entry_data d where " . $where . " order by trns_type")->result();

            $sql = "select trns_id,trns_code,trns_ser,deb_amount,crd_amount,
        IFNULL((select name from account_chart  where id =deb_acc_id  and brand =" . $this->brand . " ),'') as deb_acc_name, 
        IFNULL((select name from account_chart  where id =crd_acc_id  and brand =" . $this->brand . " ),'') as crd_acc_name, 
        rate
         ,IFNULL((select name from currency c where c.id =currency_id  ),'') as currency , ev_deb,ev_crd from entry_data d where " . $where . " order by trns_type,trns_id,id";

            $data['entry_rep'] = $this->db->query($sql)->result();
            $sql = "select * from entry_data_total where " . $where . "   order by trns_type,trns_id";

            $data['entry_head'] = $this->db->query($sql)->result();

            echo json_encode($data);
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function subledger()
    {
        $check = $this->admin_model->checkPermission($this->role, 230);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 230);
            $data['brand'] = $this->brand;

            $data['user'] = $this->user;

            $setup = $this->AccountModel->getSetup();
            $data['setup'] = $setup;
            $data['vs_date1'] = $setup->sdate1;
            $data['vs_date2'] = date('Y-m-d', strtotime($setup->sdate2));

            $data['currency_id'] = $setup->local_currency_id;

            $data['vs_currency'] = $this->admin_model->getCurrency($setup->local_currency_id);
            // echo '<pre>';
            // print_r($data);
            // die;
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/report/subledger');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function subledger_calc()
    {

        $data['brand'] = $this->brand;
        $data['user'] = $this->user;
        $curr_type = $this->input->post('currency_type');
        $currency_id = $this->input->post('currency_id');
        $trns_date1 = date('Y-m-d', strtotime($this->input->post('from_date')));
        $trns_date2 = date('Y-m-d', strtotime($this->input->post('to_date')));
        $account_no = $this->input->post('account_id');

        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $local_currency = $setup->local_currency_id;
        if ($currency_id == $local_currency)
            $rate = 1;

        $where = ' (e.brand = "' . $this->brand . '") ';
        $where_date = ' and (e.trns_date BETWEEN  "' . $trns_date1 . '" and "' . $trns_date2 . '")';
        $add_where = '(e.deb_acc_id = "' . $account_no . '" or e.crd_acc_id = "' . $account_no . '")';

        $where_date_befor = ' and (trns_date <  "' . $trns_date1 . '")';
        $in_where = ' (brand = "' . $this->brand . '")   and (deb_acc_id = "' . $account_no . '" or crd_acc_id = "' . $account_no . '")';
        $currency_where_e = ' and (e.currency_id = "' . $currency_id . '") ';
        $currency_where = ' and (currency_id = "' . $currency_id . '") ';
        $rate_currency = "/ ifnull((select rate from currenies_rate where currency = e.currency_id and currency_to = '" . $local_currency . "' and month = month(e.trns_date) and year = year(e.trns_date) limit 1),1) ";
        if ($curr_type === '1') {
            $sql0 = "select sum(ifnull(e.deb_amount,0)) as debit,sum(ifnull(e.crd_amount,0)) as credit,sum(ifnull(e.ev_deb,0)) as ev_debit,sum(ifnull(e.ev_crd,0)) as ev_credit 
            from entry_data e             
            where trns_code in (select trns_code from entry_data where  " . $in_where . $where_date_befor . ") and (" . $where . $currency_where . $where_date_befor . " and " . $add_where . ") order by e.trns_date";


            $sql1 = "select e.*,ifnull(e.deb_amount,0) as debit,ifnull(e.crd_amount,0) as credit,ifnull(e.ev_deb,0) as ev_debit,ifnull(e.ev_crd,0) as ev_credit ,c.name as currency,a1.acode as deb_acode,a1.name as deb_name,a2.acode as crd_acode ,a2.name as crd_name 
                from entry_data e 
                left join currency c on c.id = e.currency_id 
                left join account_chart a1 on a1.id = e.deb_acc_id 
                left join account_chart a2 on a2.id = e.crd_acc_id 
    
                where trns_code in (select trns_code from entry_data where " . $in_where . $where_date . $currency_where . ") and (" . $where . $currency_where_e . $where_date . " and " . $add_where . ") order by e.trns_date";
        } else {
            $sql0 = "select sum(ifnull(e.ev_deb,0) " . $rate_currency . ")  as debit,sum(ifnull(e.ev_crd,0) " . $rate_currency . ") as credit,sum(ifnull(e.ev_deb,0)) as ev_debit,sum(ifnull(e.ev_crd,0)) as ev_credit 
            from entry_data e             
            where trns_code in (select trns_code from entry_data where  " . $in_where . $where_date_befor . ") and (" . $where . $where_date_befor . " and " . $add_where . ") order by e.trns_date";


            $sql1 = "select e.*,(ifnull(e.ev_deb,0) " . $rate_currency . ") as debit,(ifnull(e.ev_crd,0) " . $rate_currency . ") as credit,ifnull(e.ev_deb,0) as ev_debit,ifnull(e.ev_crd,0) as ev_credit ,c.name as currency,a1.acode as deb_acode,a1.name as deb_name,a2.acode as crd_acode ,a2.name as crd_name 
                from entry_data e 
                left join currency c on c.id = e.currency_id 
                left join account_chart a1 on a1.id = e.deb_acc_id 
                left join account_chart a2 on a2.id = e.crd_acc_id 
    
                where trns_code in (select trns_code from entry_data where " . $in_where . $where_date . ") and (" . $where . $where_date . " and " . $add_where . ") order by e.trns_date";

        }
        // print_r($sql1);
        // die;

        $data['beg_ledger'] = $this->db->query($sql0)->result_array();
        $data['trns_ledger'] = $this->db->query($sql1)->result_array();
        // echo '<pre>';
        // print_r($data['beg_ledger']);
        // die;
        echo json_encode($data);

    }
    public function generalledger()
    {
        $check = $this->admin_model->checkPermission($this->role, 229);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 229);
            $data['brand'] = $this->brand;


            $data['user'] = $this->user;
            $setup = $this->AccountModel->getsetup();
            $data['acc_setup'] = $setup;

            $data['vs_date1'] = $setup->sdate1;
            $data['vs_date2'] = date('Y-m-d', strtotime($setup->sdate2));

            $data['currency_id'] = $setup->local_currency_id;
            $data['vs_currency'] = $this->admin_model->getCurrency($setup->local_currency_id);
            // echo '<pre>';
            // print_r($data);
            // die;
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/report/generalledger');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function accountAnalysis()
    {
        $check = $this->admin_model->checkPermission($this->role, 235);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 235);
            $data['brand'] = $this->brand;
            $data['user'] = $this->user;
            $setup = $this->AccountModel->getsetup();
            $data['acc_setup'] = $setup;

            $data['vs_date1'] = $setup->sdate1;
            $data['vs_date2'] = date('Y-m-d', strtotime($setup->sdate2));

            $data['currency_id'] = $setup->local_currency_id;
            $data['vs_currency'] = $this->admin_model->getCurrency($setup->local_currency_id);
            // echo '<pre>';
            // print_r($data);
            // die;
            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/report/accountAnalysis');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function generalledger_calc()
    {
        $data['brand'] = $this->brand;
        $data['user'] = $this->user;
        $curr_type = $this->input->post('currency_type');
        $currency_id = $this->input->post('currency_id');
        $trns_date1 = date('Y-m-d', strtotime($this->input->post('from_date')));
        $trns_date2 = date('Y-m-d', strtotime($this->input->post('to_date')));
        $account_id = $this->input->post('account_id');
        $account_no = $this->AccountModel->getAcodeByID($this->input->post('account_id'));

        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $local_currency = $setup->local_currency_id;

        $local_currency = $setup->local_currency_id;
        if ($currency_id == $local_currency)
            $rate = 1;

        $where = ' (e.brand = "' . $this->brand . '") ';
        $where_date = ' and (ed.trns_date BETWEEN  "' . $trns_date1 . '" and "' . $trns_date2 . '")';
        $add_where = '(ed.main_acc_id = "' . $account_id . '" or ed.main_acc_id = "' . $account_id . '")';

        $where_date_befor = ' and (trns_date <=  "' . $trns_date1 . '")';
        $in_where = ' (brand = "' . $this->brand . '")   and (main_acc_id = "' . $account_id . '" or main_acc_id = "' . $account_id . '")';
        $currency_where_e = ' and (e.currency_id = "' . $currency_id . '") ';
        $currency_where = ' and (currency_id = "' . $currency_id . '") ';
        $rate_currency = "/ ifnull((select rate from currenies_rate where currency = e.currency_id and currency_to = '" . $local_currency . "' and month = month(e.trns_date) and year = year(e.trns_date) limit 1),1) ";
        if ($curr_type === '1') {
            $sql0 = "select sum(ifnull(e.deb_amount,0)) as debit,sum(ifnull(e.crd_amount,0)) as credit,sum(ifnull(e.ev_deb,0)) as ev_debit,sum(ifnull(e.ev_crd,0)) as ev_credit 
            from entry_data e             
            where trns_code in (select trns_code from entry_data where  " . $in_where . $where_date_befor . ") and (" . $where . $currency_where . $where_date_befor . " and " . $add_where . ") order by e.trns_date";


            $sql1 = "select e.*,ifnull(e.deb_amount,0) as debit,ifnull(e.crd_amount,0) as credit,ifnull(e.ev_deb,0) as ev_debit,ifnull(e.ev_crd,0) as ev_credit ,c.name as currency,a1.acode as deb_acode,a1.name as deb_name,a2.acode as crd_acode ,a2.name as crd_name 
                from entry_data e 
                left join currency c on c.id = e.currency_id 
                left join account_chart a1 on a1.id = e.main_acc_id 
                left join account_chart a2 on a2.id = e.main_acc_id 

                where trns_code in (select trns_code from entry_data where " . $in_where . $where_date . $currency_where . ") and (" . $where . $currency_where_e . $where_date . " and " . $add_where . ") order by e.trns_date";
        } else {
            $sql1 = "SELECT
            a.id AS id,
            a.ccode AS ccode,
            a.acode AS acode,
            a.name AS name,
            a.acc AS acc,
            a.parent_id AS parent_id,
            a.level AS LEVEL,@beg_debit :=
            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_crd, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.crd_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                " . $where_date_befor . "
                AND (ed.trns_type <> 'Begin Entry')) 
		+ 
        (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_crd, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                    currency = '" . $local_currency . "'
                                    AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                1)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.crd_acc_acode LIKE CONCAT(a.acode, '%'))
            AND (ed.brand = '" . $this->brand . "')        
                AND (ed.trns_type = 'Begin Entry'))
) as beg_debit 
,@beg_credit :=

            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_deb, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.deb_acc_acode LIKE CONCAT(a.acode, '%'))
            AND (ed.brand = '" . $this->brand . "')
            " . $where_date_befor . "
                AND (ed.trns_type <> 'Begin Entry')) 
		+ 
        (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_deb, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                    currency = '" . $local_currency . "'
                                    AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                1)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.deb_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                AND (ed.trns_type = 'Begin Entry'))
) as beg_credit           
            ,@debit :=
            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_deb, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.deb_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                " . $where_date . "
                AND (ed.trns_type <> 'Begin Entry'))
                ) AS debit
                
        ,@credit :=

            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_crd, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.crd_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                " . $where_date . "
                AND (ed.trns_type <> 'Begin Entry'))
                  
            ) AS credit
            
            ,@beg_debit-@beg_credit+@debit-@credit as balance

               from account_chart a 

               where a.acc = 1 and brand = '" . $this->brand . "' and acode LIKE CONCAT('" . $account_no . "', '%') order by a.acode";

        }
        // var_dump($sql1);
        // $data['beg_ledger'] = $this->db->query($sql0)->result_array();
        $data['trns_ledger'] = $this->db->query($sql1)->result_array();

        echo json_encode($data);
    }
    public function accountAnalysis_calc()
    {
        $data['brand'] = $this->brand;
        $data['user'] = $this->user;
        $curr_type = $this->input->post('currency_type');
        $currency_id = $this->input->post('currency_id');
        $trns_date1 = date('Y-m-d', strtotime($this->input->post('from_date')));
        $trns_date2 = date('Y-m-d', strtotime($this->input->post('to_date')));
        $account_id = $this->input->post('account_id');
        $account_no = $this->AccountModel->getAcodeByID($this->input->post('account_id'));

        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $local_currency = $setup->local_currency_id;

        $local_currency = $setup->local_currency_id;
        if ($currency_id == $local_currency)
            $rate = 1;

        $where = ' (e.brand = "' . $this->brand . '") ';
        $where_date = ' and (ed.trns_date BETWEEN  "' . $trns_date1 . '" and "' . $trns_date2 . '")';
        $add_where = '(ed.main_acc_id = "' . $account_id . '" or ed.main_acc_id = "' . $account_id . '")';

        $where_date_befor = ' and (trns_date <  "' . $trns_date1 . '")';
        $in_where = ' (brand = "' . $this->brand . '")   and (main_acc_id = "' . $account_id . '" or main_acc_id = "' . $account_id . '")';
        $currency_where_e = ' and (e.currency_id = "' . $currency_id . '") ';
        $currency_where = ' and (currency_id = "' . $currency_id . '") ';
        $rate_currency = "/ ifnull((select rate from currenies_rate where currency = e.currency_id and currency_to = '" . $local_currency . "' and month = month(e.trns_date) and year = year(e.trns_date) limit 1),1) ";
        if ($curr_type === '1') {
            $sql0 = "select sum(ifnull(e.deb_amount,0)) as debit,sum(ifnull(e.crd_amount,0)) as credit,sum(ifnull(e.ev_deb,0)) as ev_debit,sum(ifnull(e.ev_crd,0)) as ev_credit 
            from entry_data e             
            where trns_code in (select trns_code from entry_data where  " . $in_where . $where_date_befor . ") and (" . $where . $currency_where . $where_date_befor . " and " . $add_where . ") order by e.trns_date";


            $sql1 = "select e.*,ifnull(e.deb_amount,0) as debit,ifnull(e.crd_amount,0) as credit,ifnull(e.ev_deb,0) as ev_debit,ifnull(e.ev_crd,0) as ev_credit ,c.name as currency,a1.acode as deb_acode,a1.name as deb_name,a2.acode as crd_acode ,a2.name as crd_name 
                from entry_data e 
                left join currency c on c.id = e.currency_id 
                left join account_chart a1 on a1.id = e.main_acc_id 
                left join account_chart a2 on a2.id = e.main_acc_id 

                where trns_code in (select trns_code from entry_data where " . $in_where . $where_date . $currency_where . ") and (" . $where . $currency_where_e . $where_date . " and " . $add_where . ") order by e.trns_date";
        } else {
            $sql1 = "SELECT
            a.id AS id,
            a.ccode AS ccode,
            a.acode AS acode,
            a.name AS name,
            a.acc AS acc,
            a.parent_id AS parent_id,
            a.level AS LEVEL,@beg_debit :=
            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_crd, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.crd_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                " . $where_date_befor . "
                AND (ed.trns_type <> 'Begin Entry')) 
		+ 
        (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_crd, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                    currency = '" . $local_currency . "'
                                    AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                1)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.crd_acc_acode LIKE CONCAT(a.acode, '%'))
            AND (ed.brand = '" . $this->brand . "')        
                AND (ed.trns_type = 'Begin Entry'))
) as beg_debit 
,@beg_credit :=

            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_deb, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.deb_acc_acode LIKE CONCAT(a.acode, '%'))
            AND (ed.brand = '" . $this->brand . "')
            " . $where_date_befor . "
                AND (ed.trns_type <> 'Begin Entry')) 
		+ 
        (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_deb, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                    currency = '" . $local_currency . "'
                                    AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                1)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.deb_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                AND (ed.trns_type = 'Begin Entry'))
) as beg_credit           
            ,@debit :=
            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_deb, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.deb_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                " . $where_date . "
                AND (ed.trns_type <> 'Begin Entry'))
                ) AS debit
                
        ,@credit :=

            ( (SELECT 
            IFNULL(SUM(IFNULL(ed.ev_crd, 0) * IFNULL((SELECT 
                                        rate
                                    FROM
                                        currenies_rate
                                    WHERE
                                        currency = '" . $local_currency . "'
                                            AND currency_to ='" . $currency_id . "'
                                            AND MONTH = MONTH(ed.trns_date)
                                            AND YEAR = YEAR(ed.trns_date)
                                    LIMIT 1),
                                0)),
                        0)
        FROM
            entry_data ed
        WHERE
            (ed.crd_acc_acode LIKE CONCAT(a.acode, '%'))
                AND (ed.brand = '" . $this->brand . "')
                " . $where_date . "
                AND (ed.trns_type <> 'Begin Entry'))
                  
            ) AS credit
            
            ,@beg_debit-@beg_credit+@debit-@credit as balance

               from account_chart a 

               where  brand = '" . $this->brand . "' and acode LIKE CONCAT('" . $account_no . "', '%') order by a.acode";

        }
        // var_dump($sql1);
        // $data['beg_ledger'] = $this->db->query($sql0)->result_array();
        $data['trns_ledger'] = $this->db->query($sql1)->result_array();

        echo json_encode($data);
    }
    public function trialbalance()
    {
        $check = $this->admin_model->checkPermission($this->role, 231);
        if ($check) {
            $data['group'] = $this->admin_model->getGroupByRole($this->role);
            $data['permission'] = $this->admin_model->getScreenByPermissionByRole($this->role, 231);
            $data['brand'] = $this->brand;

            $data['user'] = $this->user;
            $setup = $this->AccountModel->getsetup();
            $data['acc_setup'] = $setup;

            $data['vs_date1'] = $setup->sdate1;
            $data['vs_date2'] = date('Y-m-d', strtotime($setup->sdate2));

            $data['currency_id'] = $setup->local_currency_id;
            $data['vs_currency'] = $this->admin_model->getCurrency($setup->local_currency_id);

            $this->load->view('includes_new/header.php', $data);
            $this->load->view('account/report/trialbalance');
            $this->load->view('includes_new/footer.php');
        } else {
            echo "You have no permission to access this page";
        }
    }
    public function trialbalance_calc()
    {
        $data['brand'] = $this->brand;
        $data['user'] = $this->user;
        $curr_type = $this->input->post('currency_type');
        $currency_id = $this->input->post('currency_id');
        $trns_date1 = date('Y-m-d', strtotime($this->input->post('from_date')));
        $trns_date2 = date('Y-m-d', strtotime($this->input->post('to_date')));
        $account_no = $this->AccountModel->getAcodeByID($this->input->post('account_id'));

        $setup = $this->AccountModel->getSetup();
        $data['setup'] = $setup;

        $local_currency = $setup->local_currency_id;
        if ($currency_id == $local_currency)
            $rate = 1;

        if ($curr_type === '1') {
            $sql1 = "call trialbalance(" . $this->brand . ",'" . $trns_date1 . "','" . $trns_date2 . "'," . $currency_id . ",999999999,0," . $local_currency . ")";
        } else {
            $sql1 = "call trialbalance_ev(" . $this->brand . ",'" . $trns_date1 . "','" . $trns_date2 . "'," . $currency_id . ",999999999,0," . $local_currency . ")";
            ;

        }
        // print_r($sql1);
        // die;

        $data['trns_ledger'] = $this->db->query($sql1)->result();
        // echo '<pre>';
        // print_r($data['trns_ledger']);
        // die;
        echo json_encode($data);
    }

    // public function generate_pdf()
    // {
    //     //load pdf library
    //     $this->load->library('Pdf');

    //     $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //     // set document information
    //     $pdf->SetCreator(PDF_CREATOR);
    //     $pdf->SetAuthor('https://roytuts.com');
    //     $pdf->SetTitle('Sales Information for Products');
    //     $pdf->SetSubject('Report generated using Codeigniter and TCPDF');
    //     $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

    //     // set default header data
    //     //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    //     // set header and footer fonts
    //     $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    //     $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    //     // set default monospaced font
    //     $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //     // set margins
    //     $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    //     $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    //     $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //     // set auto page breaks
    //     $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //     // set image scale factor
    //     $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //     // set font
    //     $pdf->SetFont('times', 'BI', 12);

    //     // ---------------------------------------------------------


    //     //Generate HTML table data from MySQL - start
    //     $template = array(
    //         'table_open' => '<table border="1" cellpadding="2" cellspacing="1">'
    //     );

    //     $this->table->set_template($template);

    //     $this->table->set_heading('Product Id', 'Price', 'Sale Price', 'Sales Count', 'Sale Date');

    //     $salesinfo = $this->product_model->get_salesinfo();

    //     foreach ($salesinfo as $sf):
    //         $this->table->add_row($sf->id, $sf->price, $sf->sale_price, $sf->sales_count, $sf->sale_date);
    //     endforeach;

    //     $html = $this->table->generate();
    //     //Generate HTML table data from MySQL - end

    //     // add a page
    //     $pdf->AddPage();

    //     // output the HTML content
    //     $pdf->writeHTML($html, true, false, true, false, '');

    //     // reset pointer to the last page
    //     $pdf->lastPage();

    //     //Close and output PDF document
    //     $pdf->Output(md5(time()) . '.pdf', 'D');
    // }
}