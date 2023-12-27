<?php

use PHPUnit\SebastianBergmann\Environment\Console;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AccountModel extends CI_Model
{
    public $brand, $category = 'account_chart';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->brand = $this->session->userdata('brand');
    }

    function getSetup()
    {
        $setup = $this->db->get_where('acc_setup', array('brand' => $this->brand))->row();
        return $setup;
    }

    function get_chart_list($limit, $offset)
    {
        $sql = "select * from account_chart where brand = " . $this->brand . " order by `acode`" . " limit " . $limit . " OFFSET  " . $offset;
        $data = $this->db->query("select * from account_chart where brand = " . $this->brand . " order by `acode`" . " limit " . $limit . " OFFSET  " . $offset);
        return $data->result();
    }

    function tree_all()
    {
        $result = $this->db->query("SELECT id, name,name as text,parent_id FROM account_chart where brand =" . $this->brand)->result_array();
        foreach ($result as $row) {
            $data[] = $row;
        }
        return $data;
    }
    function get_accountRowID($id)
    {
        $query = $this->db->get_where("account_chart", array('id' => $id))->row();
        return $query;
    }

    function get_account()
    {
        $query = $this->db->get_where("account_chart", array('brand' => $this->brand));
        return $query;
    }
    function selectcombo($table_name, $id, $brand)
    {
        if ($brand == "" || $brand == "All") {
            $result = $this->db->get($table_name)->result();
        } else {
            $result = $this->db->get_where($table_name, array('brand' => $brand))->result();
        }
        $data = "";
        foreach ($result as $item) {
            if ($item->id == $id) {
                $data .= "<option value='" . $item->id . "' selected='selected'>" . $item->name . "</option>";
            } else {
                $data .= "<option value='" . $item->id . "'>" . $item->name . "</option>";
            }
        }
        return $data;
    }
    function selectPaymentCombo($table_name, $id, $brand, $type)
    {
        $result = $this->db->get_where($table_name, array('brand' => $brand, 'type' => $type))->result();
        $data = "";
        foreach ($result as $item) {
            if ($item->id == $id) {
                $data .= "<option value='" . $item->id . "' selected='selected'>" . $item->name . "</option>";
            } else {
                $data .= "<option value='" . $item->id . "'>" . $item->name . "</option>";
            }
        }
        return $data;
    }
    function select_chart($table_name, $id = "", $brands = "", $closing = "", $type = "")
    {
        $sql_text = array();
        if ($id != "") {
            $sql_text['id'] = $id;
        }

        if ($brands != "") {
            $sql_text['brand'] = $brands;
        }
        if ($closing != "") {
            $sql_text['close'] = $closing;
        }
        if ($type != "") {
            $sql_text['type'] = $type;
        }
        $query = $this->db->get_where($table_name, $sql_text)->result();
        return $query;
    }

    function get_select($table_name)
    {

        $query = $this->db->order_by('name', 'ASC')->get($table_name)->result();
        $data = "";
        foreach ($query as $item) {

            $data .= "<option value='" . $item->id . "'>" . $item->name . "</option>";
        }
        return $data;
    }

    function AllChart($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * from account_chart 
                 WHERE " . $filter . " ORDER BY id DESC");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * from account_chart 
                 WHERE created_by = '$user' AND " . $filter . " ORDER BY id DESC");
        }
        return $data;
    }

    function AllChartPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `account_chart` ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `account_chart` WHERE created_by = '$user' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    function getByNAME($table_name, $field)
    {
        $result = $this->db->get_where($table_name, array('name' => $field, 'brand' => $this->brand))->row();
        if (isset($result->id)) {
            return $result->id;
        } else {
            return '';
        }
    }

    function getByID($table_name, $field)
    {
        if ($field !== "") {
            $result = $this->db->get_where($table_name, array('id' => $field))->row();
            if (isset($result->name)) {
                return $result->name;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    function getAcodeByID($field)
    {
        if ($field !== "") {
            $result = $this->db->get_where('account_chart', array('id' => $field))->row();
            if (isset($result->acode)) {
                return $result->acode;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    function selectCurrency($id = "")
    {
        $language = $this->db->order_by('name', 'ASC')->get_where('currency')->result();
        $data = '';
        foreach ($language as $languages) {
            if ($languages->id == $id && $id != "") {
                $data .= "<option value='" . $languages->id . "' selected='selected'>" . $languages->name . "</option>";
            } else {
                $data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
            }
        }

        return $data;
    }
    function selectCombo_Name($table_name, $id = "")
    {
        $language = $this->db->order_by('name', 'ASC')->get_where($table_name)->result();
        $data = '';
        foreach ($language as $languages) {
            if ($languages->id == $id && $id != "") {
                $data .= "<option value='" . $languages->id . "' selected='selected'>" . $languages->name . "</option>";
            } else {
                $data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
            }
        }

        return $data;
    }

    function selectCombo_New($table_name, $id = "")
    {
        $languages = $this->db->order_by('name', 'ASC')->get_where($table_name, array('brand' => $this->brand))->result();
        $data = '';
        foreach ($languages as $languages) {
            if ($languages->id == $id && $id != "") {
                $data .= "<option value='" . $languages->id . "' selected='selected'>" . $languages->name . "</option>";
            } else {
                $data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
            }
        }

        return $data;
    }
    function selectCombo_Where($table_name, $filter_array, $id = '')
    {
        if ($table_name == 'account_chart') {
            $this->db->order_by('name', 'ASC');
        }

        $languages = $this->db->get_where($table_name, $filter_array)->result();
        $data = '';
        foreach ($languages as $languages) {
            if ($languages->id == $id && $id != "") {
                $data .= "<option value='" . $languages->id . "' selected='selected'>" . $languages->name . "</option>";
            } else {
                $data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
            }
        }

        return $data;
    }
    function selectCombo_3p($table_name, $filter_array, $id = '')
    {
        $languages = $this->db->get_where($table_name, $filter_array)->result();
        $data = '';
        foreach ($languages as $languages) {
            if ($languages->id == $id && $id != "") {
                $data .= "<option value='" . $languages->id . "' selected='selected'>" . $languages->name . "</option>";
            } else {
                $data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
            }
        }

        return $data;
    }
    function selectCombo_Double($table_name, $id = "")
    {
        $languages = $this->db->order_by('name', 'ASC')->get($table_name)->result();
        $data = '';
        foreach ($languages as $languages) {
            $bank = $this->getByID('bank', $languages->bank);
            $cash = $this->getByID('cash', $languages->cash);
            if ($languages->id == $id && $id != "") {
                $data .= "<option value='" . $languages->id . "' selected='selected'>" . $bank->name . " - " . $cash->name . "</option>";
            } else {
                $data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
            }
        }

        return $data;
    }

    function select_chart_main($brand, $p_id = "")
    {
        $result = $this->db->order_by('acode', 'ASC')->get_where('account_chart', array('brand' => $brand, 'acc' => 1))->result();
        $data = "";
        foreach ($result as $result) {
            if ($result->id == $id) {
                $data .= "<option value='" . $result->id . "' selected='selected'>" . $result->name . "</option>";
            } else {
                $data .= "<option value='" . $result->id . "'>" . $result->name . "</option>";
            }
        }
        return $data;
    }
    function select_chart_sub($brand, $id = "")
    {
        $result = $this->db->order_by('acode', 'ASC')->get_where('account_chart', array('brand' => $brand, 'acc' => 0))->result();
        $data = "";
        foreach ($result as $result) {
            if ($result->id == $id) {
                $data .= "<option value='" . $result->id . "' selected='selected'>" . $result->name . "</option>";
            } else {
                $data .= "<option value='" . $result->id . "'>" . $result->name . "</option>";
            }
        }
        return $data;
    }
    function select_chart_acc($brand, $id = "")
    {
        $result = $this->db->order_by('acode', 'ASC')->get_where('account_chart', array('brand' => $brand, 'acc' => 1))->result();
        $data = "";
        foreach ($result as $result) {
            if ($result->id == $id) {
                $data .= "<option value='" . $result->id . "' selected='selected'>" . $result->name . "</option>";
            } else {
                $data .= "<option value='" . $result->id . "'>" . $result->name . "</option>";
            }
        }
        return $data;
    }

    function getchartData($id = '')
    {
        $result = $this->db->get_where('account_chart', array('id' => $id))->row();

        if (isset($result)) {
            return $result;
        } else {
            return '';
        }
    }

    function getaccountByParentId($category_id)
    {
        $chart = $this->db->select('*,name as text')->from('account_chart')->order_by('level', 'ASC')->WHERE('parent_id', $category_id)->get()->result_array();
        for ($i = 0; $i < count($chart); $i++) {
            if ($this->getaccountByParentId($chart[$i]['id'])) {
                $chart[$i]['child'] = $this->getaccountByParentId($chart[$i]['id']);
            }
        }
        return $chart;
    }

    function insert_data($table_name, $data_array, $sql_where)
    {
        $sql = "delete from  " . $table_name . $sql_where;
        $this->db->query($sql);
        $sql = "ALTER TABLE " . $table_name . " AUTO_INCREMENT = 1";
        $this->db->query($sql);
        $this->db->insert_batch($table_name, $data_array);
    }

    function get_lastrecord($table_name, $id)
    {
        $query = $this->db
            ->select('*')
            ->from($table_name)
            ->where('parent_id', $id)
            ->order_by('acode', 'desc')
            ->limit(1)
            ->get()->row();
        return $query;
    }
    function get_level($id)
    {
        $level = $this->db
            ->select('*')
            ->from('account_chart')
            ->where('id', $id)
            ->get()->row();
        return $level->level;
    }
    function insertimport($data, $brand)
    {
        $sql = "delete from  account_chart where brand = '" . $brand . "'";
        $this->db->query($sql);
        //$sql = "ALTER TABLE " . $table_name . " AUTO_INCREMENT = 1";
        //$this->db->query($sql);
        $this->db->insert_batch('account_chart', $data);

        $query = $this->db->query("SELECT * FROM account_chart where brand = '" . $brand . "'");
        $result = $query->result();

        foreach ($result as $rowaccount) {
            if ($rowaccount->parent !== "" && $rowaccount->parent_id !== "") {
                $partnerid = $this->getByNAME('account_chart', $rowaccount->parent);
                $this->db->where('parent', $rowaccount->parent);
                $this->db->where('brand', $this->brand);
                $this->db->update('account_chart', array('parent_id' => $partnerid));
            }
        }
    }

    function AllBanks($filter)
    {
        $data = $this->db->query(" SELECT * FROM `bank` WHERE " . $filter . "  ORDER BY id ASC , id DESC ");
        return $data;
    }

    function AllBanksPages($limit, $offset, $filter = 1)
    {
        $data = $this->db->query("SELECT * FROM `bank` WHERE " . $filter . " ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }
    function AddCashCode($filter)
    {
        $data = $this->db->query(" SELECT * FROM `cash_code` WHERE " . $filter . "  ORDER BY id ASC ");
        return $data;
    }

    function AddCashCodePages($limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `cash_code`  ORDER BY id ASC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    function AllPaymentMethodfilter($limit, $offset, $filter, $brand)
    {
        if ($filter == '') {
            if ($limit != 0) {
                $data = $this->db->query(" SELECT * FROM `payment_method` HAVING brand = '$brand'   ORDER BY id LIMIT $limit OFFSET $offset ");
            } else {
                $data = $this->db->query(" SELECT * FROM `payment_method`  HAVING brand = '$brand'   ORDER BY id ");
            }
        } else {
            if ($limit != 0) {
                $data = $this->db->query(" SELECT * FROM `payment_method` WHERE " . $filter . " HAVING brand = '$brand'   ORDER BY id LIMIT $limit OFFSET $offset ");
            } else {
                $data = $this->db->query(" SELECT * FROM `payment_method` WHERE " . $filter . " HAVING brand = '$brand'   ORDER BY id ");
            }
        }
        return $data;
    }

    function AllPaymentMethodPages($limit, $offset)
    {
        if ($limit != 0) {
            $data = $this->db->query("SELECT * FROM `payment_method` where brand =" . $this->brand . " ORDER BY id  LIMIT $limit OFFSET $offset ");
        } else {
            $data = $this->db->query("SELECT * FROM `payment_method` where brand =" . $this->brand . " ORDER BY id ");
        }

        return $data;
    }
    function AllPaymentMethod($filter, $brand)
    {
        $data = $this->db->query("SELECT * FROM `payment_method` where brand =" . $this->brand . " ORDER BY id ");
        return $data;
    }
    //************// Cash

    function AllCash($brand, $type, $filter)
    {
        if ($type == '1') {
            return $data = $this->db->query(" SELECT * FROM `cashin` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY date  ");
        } else {
            return $data = $this->db->query(" SELECT * FROM `cashout` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY date  ");
        }
    }
    function AllCashPagesFilter($brand, $type, $filter, $limit, $offset)
    {
        if ($filter != '') {
            if ($type == '1') {
                return $data = $this->db->query(" SELECT * FROM `cashin` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY date  LIMIT $limit OFFSET $offset  ");
            } else {

                return $data = $this->db->query(" SELECT *  FROM `cashout` WHERE " . $filter . "HAVING brand = '$brand' ORDER BY date  LIMIT $limit OFFSET $offset ");
            }
        } else {
            if ($type == '1') {
                return $data = $this->db->query(" SELECT * FROM `cashin`  HAVING brand = '$brand' ORDER BY date  LIMIT $limit OFFSET $offset  ");
            } else {

                return $data = $this->db->query(" SELECT *  FROM `cashout` HAVING brand = '$brand' ORDER BY date  LIMIT $limit OFFSET $offset ");
            }
        }
    }
    function AllCashPages($brand, $type, $limit, $offset)
    {
        if ($type == '1') {
            return $data = $this->db->query(" SELECT * FROM `cashin`  HAVING brand = '$brand' ORDER BY date  LIMIT $limit OFFSET $offset  ");
        } else {

            return $data = $this->db->query(" SELECT *  FROM `cashout` HAVING brand = '$brand' ORDER BY date  LIMIT $limit OFFSET $offset ");
        }
    }
    function Allrevenue($brand, $id, $parent_id)
    {
        $parent_id = $this->db->get_where('acc_setup', array('brand' => $brand))->row()->rev_acc_id;
        $parent = $this->db->get_where('account_chart', array('id' => $parent_id))->row();
        $parent_code = $parent->acode;
        $parent_level = $parent->level;
        //00-00-000-000-000-000
        $lens = 0;
        switch ($parent_level) {
            case '1':
                $sub_code = substr($parent_code, 0, 2);
                $lens = 2;
                break;
            case '2':
                $sub_code = substr($parent_code, 0, 5);
                $lens = 5;
                break;
            case '3':
                $sub_code = substr($parent_code, 0, 9);
                $lens = 9;
                break;
            case '4':
                $sub_code = substr($parent_code, 0, 13);
                $lens = 13;
                break;
            case '5':
                $sub_code = substr($parent_code, 0, 17);
                $lens = 17;
                break;
            case '6':
                $sub_code = substr($parent_code, 0, 21);
                $lens = 21;
                break;
            default:
                $sub_code = "";
                $lens = 0;
                break;
        }
        $sql = "SELECT * FROM account_chart where brand = " . $brand . " and SUBSTRING(acode,1," . $lens . ") = '" . $sub_code . "' and acc = 0 order by acode";
        $query = $this->db->query($sql)->result();
        $data = "";
        foreach ($query as $item) {
            if ($item->id == $id) {
                $data .= "<option value='" . $item->id . "' selected='selected'>" . $item->name . "</option>";
            } else {
                $data .= "<option value='" . $item->id . "'>" . $item->name . "</option>";
            }
        }

        return $data;
    }
    function Allexpenses($brand, $id, $parent_id)
    {
        $parent_id = $this->db->get_where('acc_setup', array('brand' => $brand))->row()->exp_acc_id;
        $parent = $this->db->get_where('account_chart', array('id' => $parent_id))->row();
        $parent_code = $parent->acode;
        $parent_level = $parent->level;

        $lens = 0;
        switch ($parent_level) {
            case '1':
                $sub_code = substr($parent_code, 0, 2);
                $lens = 2;
                break;
            case '2':
                $sub_code = substr($parent_code, 0, 5);
                $lens = 5;
                break;
            case '3':
                $sub_code = substr($parent_code, 0, 9);
                $lens = 9;
                break;
            case '4':
                $sub_code = substr($parent_code, 0, 13);
                $lens = 13;
                break;
            case '5':
                $sub_code = substr($parent_code, 0, 17);
                $lens = 17;
                break;
            case '6':
                $sub_code = substr($parent_code, 0, 21);
                $lens = 21;
                break;
            default:
                $sub_code = "";
                $lens = 0;
                break;
        }
        $sql = "SELECT * FROM account_chart where brand = " . $brand . " and SUBSTRING(acode,1," . $lens . ") = '" . $sub_code . "' and acc = 0 order by id desc";
        $query = $this->db->query($sql)->result();

        $data = "";
        foreach ($query as $item) {
            if ($item->id == $id) {
                $data .= "<option value='" . $item->id . "' selected='selected'>" . $item->name . "</option>";
            } else {
                $data .= "<option value='" . $item->id . "'>" . $item->name . "</option>";
            }
        }

        return $data;
    }
    function getrate($currency_id, $date)
    {
        $rate = 0;
        $currencyTo = $this->db->get_where('acc_setup', array('brand' => $this->brand))->row()->local_currency_id;
        $ldate = strtotime($date);

        $year = date("Y", $ldate);
        $month = date("m", $ldate);
        if ($currencyTo === '' || $currencyTo === null) {
            $rate = 0;
        } else {
            if ($currency_id == $currencyTo) {
                $rate = 1;
            } else {
                $mainCurrencyData = $this->db->get_where('currenies_rate', array('year' => $year, 'month' => $month, 'currency' => $currency_id, 'currency_to' => $currencyTo))->row();
                if (empty($mainCurrencyData)) {
                    $rate = 0;
                } else {
                    $rate = $mainCurrencyData->rate;
                }
            }
        }
        return $rate;
    }
    //***************** */ End Cash
    //***************** */ Bank
    function Allbankin($filter)
    {
        $data = $this->db->query(" SELECT * FROM `bankin` WHERE " . $filter . "  ORDER BY id ASC , id DESC ");
        return $data;
    }

    function AllbankinPages($brand, $type, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `bankin`  ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }

    function Allbanktrn($brand, $type, $filter)
    {
        if ($type == '1') {
            return $data = $this->db->query(" SELECT * FROM `bankin` where '$filter'  HAVING brand = '$brand' ORDER BY date ");
        } else {

            return $data = $this->db->query(" SELECT *  FROM `bankout` where '$filter' HAVING brand = '$brand' ORDER BY date ");
        }
    }

    function AllbanktrnPages($brand, $type, $limit, $offset)
    {
        if ($type == '1') {
            return $data = $this->db->query(" SELECT * FROM `bankin` HAVING brand = '$brand' ORDER BY date   LIMIT $limit OFFSET $offset  ");
        } else {

            return $data = $this->db->query(" SELECT *  FROM `bankout`  HAVING brand = '$brand' ORDER BY date   LIMIT $limit OFFSET $offset  ");
        }

        $data = $this->db->query("SELECT * FROM `bankout`  ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }
    function getpayment_method($field)
    {
        if ($field !== "") {
            $result = $this->db->get_where('payment_method', array('id' => $field))->row();

            if (isset($result->name)) {
                return $result->name;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    function getpayment_method_account_id($field)
    {
        if ($field !== "") {
            $result = $this->db->get_where('payment_method', array('id' => $field))->row();

            if (isset($result->account_id)) {
                return $result->account_id;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    //***************** */ Manual Entry */ *************//
    function AllManualEntries($brand, $sort_by, $filter, $limit, $offset)
    {
        if ($limit == 0) {
            if ($sort_by == '') {
                $data = $this->db->query(" SELECT * FROM `manual_master` WHERE  $filter  HAVING brand = '$brand' ORDER BY id ");
            } else {
                $data = $this->db->query(" SELECT * FROM `manual_master` WHERE  $filter  HAVING brand = '$brand' ORDER BY $sort_by");
            }
        } else {
            if ($sort_by == '') {
                $data = $this->db->query(" SELECT * FROM `manual_master` WHERE  $filter  HAVING brand = '$brand' ORDER BY id LIMIT  $limit  OFFSET  $offset ");
            } else {
                $data = $this->db->query(" SELECT * FROM `manual_master` WHERE  $filter  HAVING brand = '$brand' ORDER BY $sort_by LIMIT  $limit  OFFSET  $offset ");
            }
        }
        return $data;
    }

    function AllManualEntriesPages($brand, $sort_by, $limit, $offset)
    {
        if ($sort_by == '') {
            $data = $this->db->query("SELECT * FROM `manual_master` HAVING brand = '$brand' ORDER BY id  LIMIT $limit OFFSET $offset ");
        } else {
            $data = $this->db->query("SELECT * FROM `manual_master` HAVING brand = '$brand' ORDER BY $sort_by  LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    function AllEntries($table_name, $brand, $filter)
    {
        $data = $this->db->query(" SELECT * FROM `" . $table_name . "` WHERE " . $filter . " HAVING brand = '$brand' ORDER BY date  ");
        return $data;
    }

    function AllEntriesPages($table_name, $brand, $limit, $offset)
    {
        $data = $this->db->query("SELECT * FROM `" . $table_name . "` HAVING brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
        return $data;
    }
}
