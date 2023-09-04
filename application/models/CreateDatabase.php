<?php

use PHPUnit\SebastianBergmann\Environment\Console;

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class CreateDatabase extends CI_Model
{

  public function createDatabaseAccountTables()
  {
    // start acc_setup //
    $this->load->dbforge();
    if ($this->db->table_exists('acc_setup') == FALSE) {
      $this->db->query("CREATE TABLE `acc_setup` (
                `id` int NOT NULL AUTO_INCREMENT,
                `brand` int NOT NULL,
                `sdate1`  	date  NULL,
                `sdate2`  	date  NULL,
                `cashin_num`  	varchar(10)  NULL,
                `cashout_num`  	varchar(10)  NULL,
                `bankin_num`  	varchar(10)  NULL,
                `bankout_num`  	varchar(10)  NULL,
                `manual_num`  	varchar(10)  NULL,
                `rec_num`  	varchar(10)  NULL,
                `pay_num`  	varchar(10)  NULL,

                `cash_acc_id` int  NULL,
                `cash_acc_acode` varchar(20)  NULL,

                `bank_acc_id` int  NULL,
                `bank_acc_acode` varchar(20)  NULL,

                `cust_acc_id` int  NULL,
                `cust_acc_acode` varchar(20)  NULL,

                `ven_acc_id`  int NULL,
                `ven_acc_acode` varchar(20)  NULL,

                `rev_acc_id` int  NULL,
                `rev_acc_acode` varchar(20)  NULL,

                `exp_acc_id`  int NULL,
                `exp_acc_acode` varchar(20)  NULL,

                `local_currency_id`  int NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->field_exists('rev_num', 'acc_setup') == FALSE) {
      $fields = array('rev_num' => array('type' => 'varchar(20)', 'null' => FALSE, 'AFTER' => 'pay_num'));
      $this->dbforge->add_column('acc_setup', $fields);
    }
    if ($this->db->field_exists('exp_num', 'acc_setup') == FALSE) {
      $fields = array('exp_num' => array('type' => 'varchar(20)', 'null' => FALSE, 'AFTER' => 'rev_num'));
      $this->dbforge->add_column('acc_setup', $fields);
    }
    if ($this->db->field_exists('begin_num', 'acc_setup') == FALSE) {
      $fields = array('begin_num' => array('type' => 'varchar(10)', 'null' => FALSE, 'AFTER' => 'exp_num'));
      $this->dbforge->add_column('acc_setup', $fields);
    }
    // end acc_setup //
    //start search_cond //
    if ($this->db->table_exists('search_cond') == FALSE) {
      $this->db->query("CREATE TABLE `search_cond` (
                `id` int NOT NULL AUTO_INCREMENT,
                `screen` int NOT NULL,
                `user` varchar(20) NOT NULL,
                `date1` date  NULL,
                `date2` date null,
                `data1` varchar(100),
                `data2` varchar(100),
                `data3` varchar(100),
                `data4` varchar(100),
                `data5` varchar(100),
                `data6` varchar(100),
                `data7` varchar(100),
                `data8` varchar(100),
                `data9` varchar(100),
                `data10` varchar(100),
                `data11` varchar(100),
                `data12` varchar(100),
                `data13` varchar(100),
                `data14` varchar(100),
                `data15` varchar(100),

                `num1` DECIMAL(20,5)  NULL,
                `num2` DECIMAL(20,5)  NULL,
                `num3` DECIMAL(20,5)  NULL,
                `num4` DECIMAL(20,5)  NULL,
                `num5` DECIMAL(20,5)  NULL,
                `num6` DECIMAL(20,5)  NULL,
                `num7` DECIMAL(20,5)  NULL,
                `num8` DECIMAL(20,5)  NULL,
                `num9` DECIMAL(20,5)  NULL,
                `num10` DECIMAL(20,5)  NULL,
                `id1` int  NULL,
                `id2` int  NULL,
                `id3` int  NULL,
                `id4` int  NULL,
                `id5` int  NULL,
                `id6` int  NULL,
                `id7` int  NULL,
                `id8` int  NULL,
                `id9` int  NULL,
                `id10` int  NULL,                
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    //end search_cond //

    // start account_chart //
    if ($this->db->table_exists('account_chart') == FALSE) {
      $this->db->query("CREATE TABLE `account_chart` (
                `id` int  NOT NULL AUTO_INCREMENT,
                `acode` varchar(20) NOT NULL,
                `ccode` varchar(20) NOT NULL,
                `name` varchar(255) NOT NULL,
                `acc_type_id` int(11),
                `acc_type` varchar(100),
                `acc_close_id` int(11),
                `acc_close` varchar(100),
                `parent_id` int(11),
                `parent` varchar(100),
                `currency_id` int(11),
                `currency` varchar(100),
                `brand` int(11),
                `level` int(1),
                `acc` int(2),
                `acc_thrd_party` int(1),
                `created_by` varchar(100),
                `created_at` varchar(100),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->field_exists('beg_balance', 'account_chart') == FALSE) {
      $fields = array('beg_balance' => array('type' => 'DECIMAL(18,5)', 'null' => FALSE, 'AFTER' => 'acc_thrd_party'));
      $this->dbforge->add_column('account_chart', $fields);
    }
    if ($this->db->field_exists('beg_balance_type', 'account_chart') == FALSE) {
      $fields = array('beg_balance_type' => array('type' => 'varchar(1)', 'null' => FALSE, 'AFTER' => 'beg_balance'));
      $this->dbforge->add_column('account_chart', $fields);
    }
    if ($this->db->field_exists('budget', 'account_chart') == FALSE) {
      $fields = array('budget' => array('type' => 'DECIMAL(18,5)', 'null' => FALSE, 'AFTER' => 'beg_balance_type'));
      $this->dbforge->add_column('account_chart', $fields);
    }
    if ($this->db->field_exists('budget_type', 'account_chart') == FALSE) {
      $fields = array('budget_type' => array('type' => 'varchar(1)', 'null' => FALSE, 'AFTER' => 'budget'));
      $this->dbforge->add_column('account_chart', $fields);
    }
    //end account_chart //
    // start bank //
    if ($this->db->table_exists('bank') == FALSE) {
      $this->db->query("CREATE TABLE if not exists `bank` (
                `id` int NOT NULL AUTO_INCREMENT,
                `name` text NOT NULL,
                `account_id` int NOT NULL,
                `brand` int NOT NULL,
                `ost_code` varchar(20) ,
                `ost_id` int ,
                `p_ost_code` varchar(20) ,               
                `currency_id` int,
                `created_by` int,
                `created_at` varchar(20),
                `data` text,
                PRIMARY KEY (`id`)             
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }

    if ($this->db->field_exists('account_id', 'bank') == FALSE) {
      $fields = array('account_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'name'));
      $this->dbforge->add_column('bank', $fields);
    }

    if ($this->db->field_exists('brand', 'bank') == FALSE) {
      $fields = array('brand' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'account_id'));
      $this->dbforge->add_column('bank', $fields);
    }

    if ($this->db->field_exists('ost_code', 'bank') == FALSE) {
      $fields = array('ost_code' => array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE, 'AFTER' => 'brand'));
      $this->dbforge->add_column('bank', $fields);
    }

    if ($this->db->field_exists('ost_id', 'bank') == FALSE) {
      $fields = array('ost_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'ost_code'));
      $this->dbforge->add_column('bank', $fields);
    }

    if ($this->db->field_exists('p_ost_code', 'bank') == FALSE) {
      $fields = array('p_ost_code' => array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE, 'AFTER' => 'ost_id'));
      $this->dbforge->add_column('bank', $fields);
    }

    if ($this->db->field_exists('currency_id', 'bank') == FALSE) {
      $fields = array('currency_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'p_ost_code'));
      $this->dbforge->add_column('bank', $fields);
    }
    if ($this->db->field_exists('created_by', 'bank') == FALSE) {
      $fields = array('created_by' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'data'));
      $this->dbforge->add_column('bank', $fields);
    }
    if ($this->db->field_exists('created_at', 'bank') == FALSE) {
      $fields = array('created_at' => array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE, 'AFTER' => 'created_by'));
      $this->dbforge->add_column('bank', $fields);
    }
    // end bank //

    // start payment_method //
    if ($this->db->table_exists('payment_method') == FALSE) {
      $this->db->query("CREATE TABLE `payment_method` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` text NOT NULL,
                `type` int(1) ,
                `account_id` int(11) NOT NULL,
                `brand` int,
                `ost_code` int(20) ,
                `ost_id` int(11) ,
                `p_ost_code` int(20) ,              
                `currency_id` int(11),
                `currency` varchar(100),
                `created_by` int(11),
                `created_at` varchar(100),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->field_exists('account_id', 'payment_method') == FALSE) {
      $fields = array('account_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'name'));
      $this->dbforge->add_column('payment_method', $fields);
    }

    if ($this->db->field_exists('ost_id', 'payment_method') == FALSE) {
      $fields = array('ost_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'account_id'));
      $this->dbforge->add_column('payment_method', $fields);
    }

    if ($this->db->field_exists('ost_code', 'payment_method') == FALSE) {
      $fields = array('ost_code' => array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE, 'AFTER' => 'ost_id'));
      $this->dbforge->add_column('payment_method', $fields);
    }

    if ($this->db->field_exists('p_ost_code', 'payment_method') == FALSE) {
      $fields = array('p_ost_code' => array('type' => 'varchar', 'constraint' => 20, 'null' => FALSE, 'AFTER' => 'ost_code'));
      $this->dbforge->add_column('payment_method', $fields);
    }

    if ($this->db->field_exists('p_ost_id', 'payment_method') == FALSE) {
      $fields = array('p_ost_id' => array('type' => 'int', 'null' => true, 'AFTER' => 'p_ost_code'));
      $this->dbforge->add_column('payment_method', $fields);
    }

    if ($this->db->field_exists('currency_id', 'payment_method') == FALSE) {
      $fields = array('currency_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'p_ost_code'));
      $this->dbforge->add_column('payment_method', $fields);
    }

    if ($this->db->field_exists('type', 'payment_method') == FALSE) {
      $fields = array('type' => array('type' => 'int(1)', 'null' => FALSE, 'AFTER' => 'name'));
      $this->dbforge->add_column('payment_method', $fields);
    }
    if ($this->db->field_exists('bank', 'payment_method') == FALSE) {
      $fields = array('bank' => array('type' => 'int', 'null' => true, 'AFTER' => 'type'));
      $this->dbforge->add_column('payment_method', $fields);
    }
    if ($this->db->field_exists('acc_code', 'payment_method') == FALSE) {
      $fields = array('acc_code' => array('type' => 'varchar(50)', 'null' => true, 'AFTER' => 'bank'));
      $this->dbforge->add_column('payment_method', $fields);
    }
    if ($this->db->field_exists('ccode', 'payment_method') == FALSE) {
      $fields = array('ccode' => array('type' => 'varchar(5)', 'null' => true, 'AFTER' => 'id'));
      $this->dbforge->add_column('payment_method', $fields);
    }
    if ($this->db->field_exists('payment_desc', 'payment_method') == FALSE) {
      $fields = array('payment_desc' => array('type' => 'TEXT', 'null' => true, 'AFTER' => 'brand'));
      $this->dbforge->add_column('payment_method', $fields);
    }
    // end payment_method //
    // start cashin //
    if ($this->db->table_exists('cashin') == FALSE) {
      $this->db->query("CREATE TABLE `cashin` (
                `id` int NOT NULL AUTO_INCREMENT,
                `cash_type` int NOT NULL,
                `ccode` varchar(10) DEFAULT NULL,
                `doc_no` varchar(10) DEFAULT NULL,
                `cash_id` int DEFAULT NULL,
                `date` date NOT NULL,
                `trn_type` varchar(20) NULL,
                `trn_id` int DEFAULT NULL,
                `trn_code` int NULL,
                `amount` decimal(18,3) NOT NULL,
                `currency_id` int NOT NULL,
                `rate` decimal(18,5) NOT NULL,
                `rem` text,
                `brand` int NOT NULL,
                `created_by` int NOT NULL,
                `created_at` varchar(20),
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    // end cashin //
    // start cashout //
    if ($this->db->table_exists('cashout') == FALSE) {
      $this->db->query("CREATE TABLE `cashout` (
                `id` int NOT NULL AUTO_INCREMENT,
                `cash_type` int NOT NULL,
                `ccode` varchar(10) DEFAULT NULL,
                `doc_no` varchar(10) DEFAULT NULL,
                `cash_id` int DEFAULT NULL,
                `date` date NOT NULL,
                `trn_type` varchar(20) NULL,
                `trn_id` int DEFAULT NULL,
                `trn_code` int NULL,
                `amount` decimal(18,3) NOT NULL,
                `currency_id` int NOT NULL,
                `rate` decimal(18,5) NOT NULL,
                `rem` text,
                `brand` int NOT NULL,
                `created_by` int NOT NULL,
                `created_at` varchar(20),
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    // end cashout //
    // start entry_data //
    if ($this->db->table_exists('entry_data') == FALSE) {
      $this->db->query("CREATE TABLE `entry_data` (
                `id` int NOT NULL AUTO_INCREMENT,
                `brand` int NOT NULL,
                `trns_type`  	varchar(100)  NULL,
                `trns_id` int  NULL,
                `trns_ser` varchar(20)  NULL,
                `trns_code` varchar(20)  NULL,
                `deb_amount` DECIMAL(20,5)  NULL,
                `crd_amount` DECIMAL(20,5)  NULL,
                `deb_acc_id` int  NULL,
                `crd_acc_id`  int NULL,
                `deb_acc_acode` varchar(20)  NULL,
                `crd_acc_acode` varchar(20) NULL,
                `trns_date` date NULL,
                `currency_id` int NULL,
                `rate` DECIMAL(20,5) NULL,
                `ev_deb` DECIMAL(20,5) NULL,
                `ev_crd` DECIMAL(20,5) NULL,
                `deb_account` int NULL,
                `crd_account` int NULL,
                `typ_account` varchar(20) NULL,
                `main_acc_id`  int NULL,
                `main_acc_acode` varchar(20)  NULL,
                `data1` varchar(250) NULL,
                `data2` varchar(250) NULL,
                `data3` varchar(250) NULL,
                `data4` varchar(250) NULL,
                `data5` varchar(250) NULL,
                `date1` date NULL,
                `date2` date NULL,
                `date3` date NULL,
                `date4` date NULL,
                `date5` date NULL,                                  
                `created_by` int  NULL,
                `created_at` date NULL,
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->field_exists('tot_id', 'entry_data') == FALSE) {
      $fields = array('tot_id' => array('type' => 'int', 'null' => FALSE, 'AFTER' => 'id'));
      $this->dbforge->add_column('entry_data', $fields);
    }
    // end entry_data //
    // start entry_data_total //
    if ($this->db->table_exists('entry_data_total') == FALSE) {
      $this->db->query("CREATE TABLE `entry_data_total` (
                `id` int NOT NULL AUTO_INCREMENT,
                `brand` int NOT NULL,
                `trns_type`  	varchar(100)  NULL,
                `trns_id` int  NULL,
                `trns_ser` varchar(20)  NULL,
                `trns_code` varchar(20)  NULL,
                `amount` DECIMAL(20,5)  NULL,
                `trns_date` date NULL,
                `currency_id` int NULL,
                `rate` DECIMAL(20,5) NULL,
                `ev_amount` DECIMAL(20,5) NULL,
                `data1` varchar(250) NULL,
                `data2` varchar(250) NULL,
                `data3` varchar(250) NULL,
                `data4` varchar(250) NULL,
                `data5` varchar(250) NULL,
                `date1` date NULL,
                `date2` date NULL,
                `date3` date NULL,
                `date4` date NULL,
                `date5` date NULL,                                  
                `created_by` int  NULL,
                `created_at` date NULL,
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->field_exists('deb_account', 'entry_data_total') == FALSE) {
      $fields = array('deb_account' => array('type' => 'int', 'null' => true, 'AFTER' => 'ev_amount'));
      $this->dbforge->add_column('entry_data_total', $fields);
    }
    if ($this->db->field_exists('crd_account', 'entry_data_total') == FALSE) {
      $fields = array('crd_account' => array('type' => 'int', 'null' => true, 'AFTER' => 'deb_account'));
      $this->dbforge->add_column('entry_data_total', $fields);
    }
    if ($this->db->field_exists('typ_account', 'entry_data_total') == FALSE) {
      $fields = array('typ_account' => array('type' => 'varchar(20)', 'null' => true, 'AFTER' => 'ev_amount'));
      $this->dbforge->add_column('entry_data_total', $fields);
    }
    // end entry_data_total //
    // start manual_master //
    if ($this->db->table_exists('manual_master') == FALSE) {
      $this->db->query("CREATE TABLE `manual_master` (
                `id` int NOT NULL AUTO_INCREMENT,
                `brand` int NOT NULL,
                `ccode` varchar(10),
                `doc_no` varchar(10),
                `date` date,
                `currency_id` int,
                `rate` decimal(18,5),
                `rem` text,
                `tot_deb` decimal(18,3),
                `tot_ev_deb` decimal(18,3),
                `tot_crd` decimal(18,3),
                `tot_ev_crd` decimal(18,3),
                `created_by` int NULL,
                `created_at` varchar(20),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }

    // end manual_master //

    // start manual_details //
    if ($this->db->table_exists('manual_details') == FALSE) {
      $this->db->query("CREATE TABLE `manual_details` (
                `id` int  NOT NULL AUTO_INCREMENT,
                `tot_id` int NOT NULL,
                `brand` int NOT NULL,
                `tot_code` varchar(10)  NULL,
                `date` date  NULL,
                `currency_id` int  NULL,
                `rate` decimal(18,5)  NULL,
                `deb_amount` decimal(18,3)  NULL,
                `ev_deb_amount` decimal(18,3)  NULL,
                `crd_amount` decimal(18,3)  NULL,
                `ev_crd_amount` decimal(18,3)  NULL,
                `account_id` int  NULL,
                `acc_acode` varchar(20)  NULL,
                `third_party_id` int  NULL,
                `created_by` int NULL,
                `created_at` varchar(20),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->field_exists('data1', 'manual_details') == FALSE) {
      $fields = array('data1' => array('type' => 'text', 'null' => true, 'AFTER' => 'third_party_id'));
      $this->dbforge->add_column('manual_details', $fields);
    }
    // end manual_details //
    // start bank in out //
    if ($this->db->table_exists('bankin') == FALSE) {
      $this->db->query("CREATE TABLE `bankin` (
                `id` int  NOT NULL AUTO_INCREMENT,
                `ccode` varchar(10) DEFAULT NULL,
                `doc_no` varchar(10) DEFAULT NULL,
                `date` date NOT NULL,
                `trn_type` int NOT NULL,
                `trn_id` int DEFAULT NULL,
                `trn_code` int NOT NULL,
                `amount` decimal(18,3) NOT NULL,
                `currency_id` int NOT NULL,
                `rate` decimal(18,5) NOT NULL,
                `check_no` varchar(10) DEFAULT NULL,
                `rem` text,
                `brand` int NOT NULL,
                `bank_id` int NOT NULL,
                `bank_type` int NOT NULL,
                `created_by` int NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }

    if ($this->db->table_exists('bankout') == FALSE) {
      $this->db->query("CREATE TABLE `bankout` (
                `id` int  NOT NULL AUTO_INCREMENT,
                `ccode` varchar(10) DEFAULT NULL,
                `doc_no` varchar(10) DEFAULT NULL,
                `date` date NOT NULL,
                `trn_type` int NOT NULL,
                `trn_id` int DEFAULT NULL,
                `trn_code` int NOT NULL,
                `amount` decimal(18,3) NOT NULL,
                `currency_id` int NOT NULL,
                `rate` decimal(18,5) NOT NULL,
                `check_no` varchar(10) DEFAULT NULL,
                `rem` text,
                `brand` int NOT NULL,
                `bank_id` int NOT NULL,
                `bank_type` int NOT NULL,
                `created_by` int NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }

    // account type //
    if ($this->db->table_exists('account_type') == FALSE) {
      $this->db->query("CREATE TABLE `account_type` (
                `id` int  NOT NULL AUTO_INCREMENT,
                `name` varchar(200)  NULL,
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->get('account_type')->num_rows() != 0) {
      $sql = "delete from  account_type";
      $this->db->query($sql);
      $sql = "ALTER TABLE account_type AUTO_INCREMENT = 1";
      $this->db->query($sql);
    }
    $this->db->insert('account_type', ['name' => 'Income']);
    $this->db->insert('account_type', ['name' => 'Expense']);
    $this->db->insert('account_type', ['name' => 'Other Expense']);
    $this->db->insert('account_type', ['name' => 'Cash']);
    $this->db->insert('account_type', ['name' => 'Accounts Receivable']);
    $this->db->insert('account_type', ['name' => 'Accounts Payable']);
    $this->db->insert('account_type', ['name' => 'Fixed Asset']);
    $this->db->insert('account_type', ['name' => 'Other Current Asset']);
    $this->db->insert('account_type', ['name' => 'Equity']);
    $this->db->insert('account_type', ['name' => 'Other Current Liability']);
    $this->db->insert('account_type', ['name' => 'Stock']);
    $this->db->insert('account_type', ['name' => 'Cost of Sales']);
    // end account type //

    // account close //
    if ($this->db->table_exists('account_close') == FALSE) {
      $this->db->query("CREATE TABLE `account_close` (
                `id` int  NOT NULL AUTO_INCREMENT,
                `name` varchar(200)  NULL,
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->get('account_close')->num_rows() != 0) {
      $sql = "delete from account_close";
      $this->db->query($sql);
      $sql = "ALTER TABLE account_close AUTO_INCREMENT = 1";
      $this->db->query($sql);
    }
    $this->db->insert('account_close', ['name' => 'Trading']);
    $this->db->insert('account_close', ['name' => 'Cost Of Goods Sold']);
    $this->db->insert('account_close', ['name' => 'Profit & Loss']);
    $this->db->insert('account_close', ['name' => 'Operation']);
    $this->db->insert('account_close', ['name' => 'Balance Sheet']);
    $this->db->insert('account_close', ['name' => 'Revenue & Expenses']);
    $this->db->insert('account_close', ['name' => 'Other']);

    // end account close //
    // start invoices
    if ($this->db->table_exists('invoices') == TRUE) {
      if ($this->db->field_exists('amount', 'invoices') == FALSE) {
        $fields = array('amount' => array('type' => 'DECIMAL(18,3)', 'null' => true, 'AFTER' => 'status'));
        $this->dbforge->add_column('invoices', $fields);
      }
      if ($this->db->field_exists('ev_amount', 'invoices') == FALSE) {
        $fields = array('ev_amount' => array('type' => 'DECIMAL(18,3)', 'null' => true, 'AFTER' => 'amount'));
        $this->dbforge->add_column('invoices', $fields);
      }
      if ($this->db->field_exists('currency', 'invoices') == FALSE) {
        $fields = array('currency' => array('type' => 'int', 'null' => true, 'AFTER' => 'ev_amount'));
        $this->dbforge->add_column('invoices', $fields);
      }
      if ($this->db->field_exists('rate', 'invoices') == FALSE) {
        $fields = array('rate' => array('type' => 'DECIMAL(18,5)', 'null' => true, 'AFTER' => 'currency'));
        $this->dbforge->add_column('invoices', $fields);
      }
    }
    if ($this->db->table_exists('invoices_details') == false) {
      $this->db->query("CREATE TABLE `invoices_details` (
                `id` int NOT NULL AUTO_INCREMENT,
                `brand` int NOT NULL,
                `invoive_id` int ,
                `po_id` int,
                `total_amount` decimal(18,3),
                
                    


                PRIMARY KEY (`id`)

                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    if ($this->db->table_exists('invoices_collection') == false) {
      $this->db->query("CREATE TABLE `invoices_collection` (
                `id` int NOT NULL AUTO_INCREMENT,
                `brand` int NOT NULL,
                `invoive_id` int ,
                `payment_id`  int ,
                `invoice_currency` int ,
                `payment_currency`  int ,
                `invoice_date` date ,
                `payment_date` date ,
                `coll_type` varchar(20),

                `invoice_amount` decimal(18,3),
                `paymnet_amount` decimal(18,3),
                `rate` decimal(18,5),
                `invoice_ev` decimal(18,3),
                `paymnet_ev` decimal(18,3),
                `remain` decimal(18,3) ,
                `rem` text,
               
                PRIMARY KEY (`id`)

            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }


    // end invoices
    // GENERAL LEDGET PROCEDURE

    $this->db->query("DROP PROCEDURE IF EXISTS `trialbalance`");

    $sql = "CREATE PROCEDURE `trialbalance` (IN `brand` INT, IN `trns_date1` DATE, IN `trns_date2` DATE, IN `currency_id` INT, IN `limits` INT, IN `offsets` INT)  SELECT 
            a.id AS id,
            a.ccode AS ccode,
            a.acode AS acode,
            a.name AS name,
            a.acc AS acc,
            a.parent_id AS parent_id,
            a.level as level,


            ((SELECT 
                    IFNULL(SUM(IFNULL(ed.deb_amount, 0)), 0)
                FROM
                    entry_data ed
                WHERE
                    ( ed.deb_acc_acode like CONCAT(a.acode,'%') )                     
                    and (ed.brand = brand ) and (ed.trns_date < trns_date1 ) and (ed.trns_type <> 'Begin Entry') 
                    and (ed.currency_id =currency_id ))";
    $sql .= " + ";

    $sql .= "(SELECT 
                    IFNULL(SUM(IFNULL(ed.deb_amount, 0)), 0)
                FROM
                    entry_data ed
                WHERE
                    ( ed.deb_acc_acode like CONCAT(a.acode,'%') )                     
                    and (ed.brand = brand ) and (ed.trns_type = 'Begin Entry') 
                    and (ed.currency_id =currency_id ))

                    )  AS beg_debit
                    ,
            ((SELECT 
                    IFNULL(SUM(IFNULL(ed.crd_amount, 0)), 0) 
                FROM
                    entry_data ed
                WHERE
                    (ed.crd_acc_acode like CONCAT(a.acode,'%') )
                    and (ed.brand = brand ) and (ed.trns_date <   trns_date1 ) and (ed.trns_type <> 'Begin Entry') 
                    and (ed.currency_id = currency_id ))";
    $sql .= " + ";
    $sql .= "(SELECT 
                    IFNULL(SUM(IFNULL(ed.crd_amount, 0)), 0) 
                FROM
                    entry_data ed
                WHERE
                    (ed.crd_acc_acode like CONCAT(a.acode,'%') )
                    and (ed.brand = brand ) and  (ed.trns_type = 'Begin Entry') 
                    and (ed.currency_id = currency_id ))
                    
                    ) AS beg_credit

            ,
            (SELECT 
                    IFNULL(SUM(IFNULL(ed.deb_amount, 0)), 0)
                FROM
                    entry_data ed
                WHERE
                    ( ed.deb_acc_acode like CONCAT(a.acode,'%') )                     
                    and (ed.brand = brand) and (ed.trns_date BETWEEN   trns_date1  and trns_date2 ) and (ed.trns_type <> 'Begin Entry') 
                    and (ed.currency_id = currency_id )

                    )  AS debit
                    ,
            (SELECT 
                    IFNULL(SUM(IFNULL(ed.crd_amount, 0)), 0) 
                FROM
                    entry_data ed
                WHERE
                    (ed.crd_acc_acode like CONCAT(a.acode,'%') )
                    and (ed.brand = brand) and (ed.trns_date BETWEEN  trns_date1  and trns_date2 ) and (ed.trns_type <> 'Begin Entry') 
                    and (ed.currency_id = currency_id )
                    
                    ) AS credit
        FROM
            account_chart a , entry_data e 
            where a.brand = brand

            group by a.id
            ORDER BY a.acode
            limit limits
             offset offsets";
    $this->db->query($sql);


    $this->db->query("DROP PROCEDURE IF EXISTS `trialbalance_ev`");

    $sql = "CREATE DEFINER=`root`@`localhost` PROCEDURE `trialbalance_ev`(
            IN `brand` INT,
            IN `trns_date1` DATE,
            IN `trns_date2` DATE,
            IN `currency_id` INT,
            IN `limits` INT,
            IN `offsets` INT,
            IN `loc_curr` INT
          )
          SELECT
            a.id AS id,
            a.ccode AS ccode,
            a.acode AS acode,
            a.name AS name,
            a.acc AS acc,
            a.parent_id AS parent_id,
            a.level AS level,
            (
              (
                  SELECT IFNULL(
                  SUM(
                      IFNULL(ed.deb_amount,0) 
                      * 
                      IFNULL((SELECT rate FROM currenies_rate WHERE currency = ed.currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date) LIMIT 1 ),1) 
                      * 
                      IFNULL((SELECT rate FROM currenies_rate WHERE currency = currency_id    AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date) LIMIT 1),1)
                  )
                  
                  ,0) 
                  FROM
                    entry_data ed
                  WHERE
                    (
                      ed.deb_acc_acode LIKE CONCAT(a.acode,
                      '%')
                    ) AND(ed.brand = brand) AND (ed.trns_date < trns_date1) AND (ed.trns_type <> 'Begin Entry')
              ) 
            +
            (
            SELECT IFNULL(
            SUM(
                IFNULL(ed.deb_amount,0)
                * 
                IFNULL((SELECT rate FROM currenies_rate WHERE currency = ed.currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date) LIMIT 1),1) 
                * 
                IFNULL((SELECT rate FROM currenies_rate WHERE currency = currency_id    AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date) LIMIT 1),1)
              )
              ,0)
            FROM
              entry_data ed
            WHERE
              (
                ed.deb_acc_acode LIKE CONCAT(a.acode,
                '%')
              ) AND(ed.brand = brand) AND(ed.trns_type = 'Begin Entry')
          )
            ) AS beg_debit,
            (
              (
              SELECT IFNULL(
                  SUM(
                      IFNULL(ed.crd_amount,0)
                      * 
                      IFNULL((SELECT rate FROM currenies_rate WHERE currency = ed.currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date) LIMIT 1),1) 
                      * 
                      IFNULL((SELECT rate FROM currenies_rate WHERE currency = currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date) LIMIT 1),1)
                      ),
                0)
              FROM
                entry_data ed
              WHERE
                (
                  ed.crd_acc_acode LIKE CONCAT(a.acode,
                  '%')
                ) AND(ed.brand = brand) AND(ed.trns_date < trns_date1) AND(ed.trns_type <> 'Begin Entry')
            ) +(
            SELECT IFNULL
              (SUM(IFNULL(ed.crd_amount,
              0) * IFNULL(
                (
                SELECT
                  rate
                FROM
                  currenies_rate
                WHERE
                  currency = ed.currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date)
                LIMIT 1
              ),
              1
              ) * IFNULL(
                (
                SELECT
                  rate
                FROM
                  currenies_rate
                WHERE
            currency = currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date)     LIMIT 1
              ),
              1
              )
              ),
              0)
            FROM
              entry_data ed
            WHERE
              (
                ed.crd_acc_acode LIKE CONCAT(a.acode,
                '%')
              ) AND(ed.brand = brand) AND(ed.trns_type = 'Begin Entry')
          )
            ) AS beg_credit,
            (
            SELECT IFNULL
              (
                SUM(IFNULL(ed.deb_amount,0) * IFNULL(
                    (
                    SELECT
                      rate
                    FROM
                      currenies_rate
                    WHERE
                      currency = ed.currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date)
                    LIMIT 1
                  ),
                  1
                  ) * IFNULL(
                    (
                    SELECT
                      rate
                    FROM
                      currenies_rate
                    WHERE
           currency = currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date)          LIMIT 1
                  ),
                  1
                  )
                ),
                0
              )
            FROM
              entry_data ed
            WHERE
              (
                ed.deb_acc_acode LIKE CONCAT(a.acode,
                '%')
              ) AND(ed.brand = brand) AND(
                ed.trns_date >= trns_date1 AND ed.trns_date <= trns_date2
              ) AND(ed.trns_type <> 'Begin Entry')
          ) AS debit,
          (
          SELECT IFNULL
            (
              SUM(
                IFNULL(ed.crd_amount,
                0) * IFNULL(
                  (
                  SELECT
                    rate
                  FROM
                    currenies_rate
                  WHERE
                    currency = ed.currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date)
                  LIMIT 1
                ),
                1
                ) * IFNULL(
                  (
                  SELECT
                    rate
                  FROM
                    currenies_rate
                  WHERE
           currency = currency_id AND currency_to = loc_curr AND MONTH = MONTH(ed.trns_date) AND YEAR = YEAR(ed.trns_date)        LIMIT 1
                ),
                1
                )
              ),
              0
            )
          FROM
            entry_data ed
          WHERE
            (
              ed.crd_acc_acode LIKE CONCAT(a.acode,
              '%')
            ) AND(ed.brand = brand) AND(
              ed.trns_date >= trns_date1 AND ed.trns_date <= trns_date2
            ) AND(ed.trns_type <> 'Begin Entry')
          ) AS credit
          FROM
            account_chart a,
            entry_data e
          WHERE
            a.brand = brand
          GROUP BY
            a.id
          ORDER BY
            a.acode
          LIMIT limits OFFSET offsets";

    $this->db->query($sql);

    // END GENERAL LEDGET PROCEDURE

    // start begin_master //
    if ($this->db->table_exists('begin_master') == FALSE) {
      $this->db->query("CREATE TABLE `begin_master` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `brand` int NOT NULL,
                        `ccode` varchar(10),
                        `doc_no` varchar(10),
                        `date` date,
                        `currency_id` int,
                        `rate` decimal(18,5),
                        `rem` text,
                        `tot_deb` decimal(18,3),
                        `tot_ev_deb` decimal(18,3),
                        `tot_crd` decimal(18,3),
                        `tot_ev_crd` decimal(18,3),
                        `created_by` int NULL,
                        `created_at` varchar(20),
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    // end begin_master //

    // start begin_details //
    if ($this->db->table_exists('begin_details') == FALSE) {
      $this->db->query("CREATE TABLE `begin_details` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `tot_id` int NOT NULL,
                        `brand` int NOT NULL,
                        `tot_code` varchar(10)  NULL,
                        `date` date  NULL,
                        `currency_id` int  NULL,
                        `rate` decimal(18,5)  NULL,
                        `deb_amount` decimal(18,3)  NULL,
                        `ev_deb_amount` decimal(18,3)  NULL,
                        `crd_amount` decimal(18,3)  NULL,
                        `ev_crd_amount` decimal(18,3)  NULL,
                        `account_id` int  NULL,
                        `acc_acode` varchar(20)  NULL,
                        `created_by` int NULL,
                        `created_at` varchar(20),
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    // end begin_details //

    //ttg_branch //
    if ($this->db->table_exists('ttg_branch') == TRUE) {
      if ($this->db->field_exists('brand', 'ttg_branch') == FALSE) {
        $fields = array('brand' => array('type' => 'int', 'null' => false, 'AFTER' => 'name'));
        $this->dbforge->add_column('ttg_branch', $fields);
      }
      if ($this->db->field_exists('created_by', 'ttg_branch') == FALSE) {
        $fields = array('created_by' => array('type' => 'int', 'null' => true, 'AFTER' => 'brand'));
        $this->dbforge->add_column('ttg_branch', $fields);
      }
      if ($this->db->field_exists('created_at', 'ttg_branch') == FALSE) {
        $fields = array('created_at' => array('type' => 'date', 'null' => true, 'AFTER' => 'created_by'));
        $this->dbforge->add_column('ttg_branch', $fields);
      }
      if ($this->db->field_exists('office_desc', 'ttg_branch') == FALSE) {
        $fields = array('office_desc' => array('type' => 'TEXT', 'null' => true, 'AFTER' => 'created_at'));
        $this->dbforge->add_column('ttg_branch', $fields);
      }
    }
    // start begin_details //
    if ($this->db->table_exists('pm_setup') == FALSE) {
      $this->db->query("CREATE TABLE `pm_setup` (
                      `id` int NOT NULL AUTO_INCREMENT,
                      `brand` int NOT NULL,
                      `qmemail` varchar(200)  NULL,
                      `qmemailsub` varchar(200)  NULL,
                      `qmemaildesc` text  NULL,
                      `block_v_no` int(1)  NULL,
                      `pm_ev_name1` varchar(100) null,
                      `pm_ev_per1` int(3) null,
                      `pm_ev_name2` varchar(100) null,
                      `pm_ev_per2` int(3) null,
                      `pm_ev_name3` varchar(100) null,
                      `pm_ev_per3` int(3) null,
                      `pm_ev_name4` varchar(100) null,
                      `pm_ev_per4` int(3) null,
                      `pm_ev_name5` varchar(100) null,
                      `pm_ev_per5` int(3) null,
                      `pm_ev_name6` varchar(100) null,
                      `pm_ev_per6` int(3) null,
                      `v_ev_name1` varchar(100) null,
                      `v_ev_per1` int(3) null,
                      `v_ev_name2` varchar(100) null,
                      `v_ev_per2` int(3) null,
                      `v_ev_name3` varchar(100) null,
                      `v_ev_per3` int(3) null,
                      `v_ev_name4` varchar(100) null,
                      `v_ev_per4` int(3) null,
                      `v_ev_name5` varchar(100) null,
                      `v_ev_per5` int(3) null,
                      `v_ev_name6` varchar(100) null,
                      `v_ev_per6` int(3) null,
                      `cuemailsub` varchar(200)  NULL,
                      `cuemaildesc` text  NULL,
                      `c_ev_name1` varchar(100) null,
                      `c_ev_per1` int(3) null,
                      `c_ev_name2` varchar(100) null,
                      `c_ev_per2` int(3) null,
                      `c_ev_name3` varchar(100) null,
                      `c_ev_per3` int(3) null,
                      `c_ev_name4` varchar(100) null,
                      `c_ev_per4` int(3) null,
                      `c_ev_name5` varchar(100) null,
                      `c_ev_per5` int(3) null,
                      `c_ev_name6` varchar(100) null,
                      `c_ev_per6` int(3) null,
                      PRIMARY KEY (`id`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    // end begin_details //
    // services //
    if ($this->db->table_exists('services') == TRUE) {
      if ($this->db->field_exists('qclog', 'services') == FALSE) {
        $fields = array('qclog' => array('type' => 'int', 'null' => true, 'AFTER' => 'abbreviations'));
        $this->dbforge->add_column('services', $fields);
      }

      for ($i = 1; $i < 31; $i++) {
        if ($this->db->field_exists('logcheck' . $i, 'services') == FALSE) {
          $fields = array('logcheck' . $i => array('type' => 'varchar(100)', 'null' => true));
          $this->dbforge->add_column('services', $fields);
        }
      }
      for ($i = 1; $i < 6; $i++) {
        if ($this->db->field_exists('logcheckn' . $i, 'services') == FALSE) {
          $fields = array('logcheckn' . $i => array('type' => 'varchar(100)', 'null' => true));
          $this->dbforge->add_column('services', $fields);
        }
      }
      for ($i = 1; $i < 31; $i++) {
        if ($this->db->field_exists('logcheckg' . $i, 'services') == FALSE) {
          $fields = array('logcheckg' . $i => array('type' => 'int', 'null' => true));
          $this->dbforge->add_column('services', $fields);
        }
      }
      for ($i = 1; $i < 6; $i++) {
        if ($this->db->field_exists('logcheckng' . $i, 'services') == FALSE) {
          $fields = array('logcheckng' . $i => array('type' => 'int', 'null' => true));
          $this->dbforge->add_column('services', $fields);
        }
      }

    }
    // end services // 
    // Q. C. Checklist Category   
    if ($this->db->table_exists('qcchklist_cat') == FALSE) {
      $this->db->query("CREATE TABLE  `qcchklist_cat` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `created_by` int(11) NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }
    // client pm //
    if ($this->db->table_exists('client_pm') == FALSE) {
      $this->db->query("CREATE TABLE  `client_pm` (
        `id` int NOT NULL AUTO_INCREMENT,
        `code` int(5) UNSIGNED ZEROFILL NOT NULL,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `customer_id` int(11) NOT NULL,
        `created_by` int(11) NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }
    // end client pm //
    // client job //
    if ($this->db->table_exists('job') == TRUE) {
      if ($this->db->field_exists('client_pm_id', 'job') == FALSE) {
        $fields = array('client_pm_id' => array('type' => 'int', 'null' => true, 'AFTER' => 'attached_email'));
        $this->dbforge->add_column('job', $fields);
      }
    }
    // end job //

    // automation_tickets //
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('approval', 'automation_tickets') == FALSE) {
        $fields = array('approval' => array('type' => 'int', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('emp_approval_id', 'automation_tickets') == FALSE) {
        $fields = array('emp_approval_id' => array('type' => 'int', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('emp_approval_email', 'automation_tickets') == FALSE) {
        $fields = array('emp_approval_email' => array('type' => 'varchar(100)', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('emp_approval_at', 'automation_tickets') == FALSE) {
        $fields = array('emp_approval_at' => array('type' => 'datetime', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('send_approval_at', 'automation_tickets') == FALSE) {
        $fields = array('send_approval_at' => array('type' => 'datetime', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('send_approval_by', 'automation_tickets') == FALSE) {
        $fields = array('send_approval_by' => array('type' => 'int', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    if ($this->db->table_exists('automation_tickets') == TRUE) {
      if ($this->db->field_exists('send_flg', 'automation_tickets') == FALSE) {
        $fields = array('send_flg' => array('type' => 'int', 'null' => true));
        $this->dbforge->add_column('automation_tickets', $fields);
      }
    }
    // end automation_tickets //
  }
}