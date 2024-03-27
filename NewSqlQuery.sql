ALTER TABLE `automation_tickets` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:new / 1 :opened / 2:in progress /3:closed / 4:pending / 5:cancelled';
ALTER TABLE `automation_tickets` ADD `comment` TEXT NULL AFTER `send_flg`; 

CREATE view active_employees AS 
select id, name , department ,manager from employees
where status = 0

CREATE VIEW attendance_view AS select log.`USRID`,log.`SRVDT` as SignIn,log.`location` as SignInLocation,`log2`.`SRVDT` AS SignOut,`log2`.`location` AS SignOutLocation from `attendance_log` `log` left join `attendance_log` `log2` on ( `log`.`USRID` = `log2`.`USRID` and `log2`.`TNAKEY` = '2' and ( `log2`.`SRVDT` between `log`.`SRVDT` and (`log`.`SRVDT` + interval 18 hour) ) and (`log2`.`SRVDT` > `log`.`SRVDT`) ) where ((`log`.`TNAKEY` = 1) and (year(`log`.`SRVDT`) > 2022)) order by `log2`.`SRVDT` desc;

ALTER TABLE `translation_request` ADD `work_hours` INT(11) NULL AFTER `start_after_id`, ADD `overtime_hours` INT(11) NULL AFTER `work_hours`, ADD `doublepaid_hours` INT(11) NULL AFTER `overtime_hours`; 
ALTER TABLE `le_request` ADD `work_hours` INT(11) NULL AFTER `start_after_id`, ADD `overtime_hours` INT(11) NULL AFTER `work_hours`, ADD `doublepaid_hours` INT(11) NULL AFTER `overtime_hours`; 
ALTER TABLE `dtp_request` ADD `work_hours` INT(11) NULL AFTER `start_after_id`, ADD `overtime_hours` INT(11) NULL AFTER `work_hours`, ADD `doublepaid_hours` INT(11) NULL AFTER `overtime_hours`;  

ALTER TABLE `project` ADD `min_profit_percentage` DOUBLE NULL AFTER `created_at`, ADD `approval_by` INT NULL AFTER `min_profit_percentage`, ADD `approval_at` DATETIME NULL AFTER `approval_by`; 
ALTER TABLE `pm_setup` ADD `min_profit_percentage` DOUBLE NULL AFTER `brand`;


CREATE TABLE IF NOT EXISTS `emp_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `salary` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) 

ALTER TABLE `customer` DROP COLUMN  `customer_profile` , DROP COLUMN  `notes` ; 

ALTER TABLE `customer_portal` ADD `customer_profile` TEXT NULL AFTER `additional_info`, ADD `notes` TEXT NULL AFTER `customer_profile`; 
 


ALTER TABLE `kpi_incidents_log` ADD `confirmed` TINYINT(1) NOT NULL DEFAULT '0' AFTER `file`; 

CREATE TABLE `commission_setting` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  `year` varchar(4) NOT NULL,
  `month` varchar(2) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `standalone_per` double NOT NULL,
  `teamleader_per` double NOT NULL,
  `cogs_per` double NOT NULL,
  `rev_target_from_1` double NOT NULL,
  `rev_target_from_2` double NOT NULL,
  `rev_target_from_3` double DEFAULT NULL,
  `rev_target_from_4` double DEFAULT NULL,
  `rev_target_from_5` double DEFAULT NULL,
  `rev_target_6` double DEFAULT NULL COMMENT 'more than ...\r\n',
  `rev_target_to_1` double NOT NULL,
  `rev_target_to_2` double NOT NULL,
  `rev_target_to_3` double DEFAULT NULL,
  `rev_target_to_4` double DEFAULT NULL,
  `rev_target_to_5` double DEFAULT NULL,
  `cogs_per_l1` double NOT NULL,
  `cogs_per_l2` double NOT NULL,
  `cogs_per_l3` double DEFAULT NULL,
  `cogs_per_l4` double DEFAULT NULL,
  `cogs_per_l5` double DEFAULT NULL,
  `cogs_per_l6` double DEFAULT NULL,
  `cogs_per_m1` double NOT NULL,
  `cogs_per_m2` double NOT NULL,
  `cogs_per_m3` double DEFAULT NULL,
  `cogs_per_m4` double DEFAULT NULL,
  `cogs_per_m5` double DEFAULT NULL,
  `cogs_per_m6` double DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `commission_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `commission_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;


ALTER TABLE `kpi_score` ADD `manager_approval` TINYINT(1) NOT NULL DEFAULT '0' AFTER `status`; 
ALTER TABLE `kpi_score` ADD `approved_by` INT(11) NULL AFTER `created_at`;
ALTER TABLE `kpi_score` ADD `approved_at` DATETIME NULL AFTER `approved_by`; 

ALTER TABLE `customer_evaluation` ADD `brand` int(11) NOT NULL AFTER `id`; 

ALTER TABLE `cashin` MODIFY `trn_code` varchar(20);

ALTER TABLE `cashout` MODIFY `trn_code` varchar(20);

ALTER TABLE `bankin` MODIFY `trn_code` varchar(20);

ALTER TABLE `bankout` MODIFY `trn_code` varchar(20);


ALTER TABLE `cashin` ADD `doc_file`   TEXT NULL AFTER `rem`;
ALTER TABLE `cashin` ADD `name_file`   TEXT NULL AFTER `doc_file`;
ALTER TABLE `cashin` ADD `desc_file`   TEXT NULL AFTER `name_file`;


ALTER TABLE `cashout` ADD `doc_file`   TEXT NULL AFTER `rem`;
ALTER TABLE `cashout` ADD `name_file`   TEXT NULL AFTER `doc_file`;
ALTER TABLE `cashout` ADD `desc_file`   TEXT NULL AFTER `name_file`;


ALTER TABLE `bankin` ADD `doc_file`   TEXT NULL AFTER `rem`;
ALTER TABLE `bankin` ADD `name_file`   TEXT NULL AFTER `doc_file`;
ALTER TABLE `bankin` ADD `desc_file`   TEXT NULL AFTER `name_file`;


ALTER TABLE `bankout` ADD `doc_file`   TEXT NULL AFTER `rem`;
ALTER TABLE `bankout` ADD `name_file`   TEXT NULL AFTER `doc_file`;
ALTER TABLE `bankout` ADD `desc_file`   TEXT NULL AFTER `name_file`;


ALTER TABLE `manual_master` ADD `doc_file`   TEXT NULL AFTER `rem`;
ALTER TABLE `manual_master` ADD `name_file`   TEXT NULL AFTER `doc_file`;
ALTER TABLE `manual_master` ADD `desc_file`   TEXT NULL AFTER `name_file`;



ALTER TABLE `customer_portal` MODIFY COLUMN `portal` varchar(300) NULL;
ALTER TABLE `customer_portal` MODIFY COLUMN `link` varchar(300)  NULL;
ALTER TABLE `customer_portal` MODIFY COLUMN `username` varchar(300) NULL;
ALTER TABLE `customer_portal` MODIFY COLUMN `password` varchar(300) NULL;
ALTER TABLE `customer_portal` MODIFY COLUMN `additional_info` longtext  NULL;

ALTER TABLE `cashin` ADD `audit_chk`   tinyint(1)  NULL AFTER `desc_file`;
ALTER TABLE `cashin` ADD `audit_by`   int(11) NULL AFTER `audit_chk`;
ALTER TABLE `cashin` ADD `audit_date`   datetime NULL AFTER `audit_by`;
ALTER TABLE `cashin` ADD `audit_comment`   TEXT NULL AFTER `audit_date`;

ALTER TABLE `cashout` ADD `audit_chk`   tinyint(1)  NULL AFTER `desc_file`;
ALTER TABLE `cashout` ADD `audit_by`   int(11) NULL AFTER `audit_chk`;
ALTER TABLE `cashout` ADD `audit_date`   datetime NULL AFTER `audit_by`;
ALTER TABLE `cashout` ADD `audit_comment`   TEXT NULL AFTER `audit_date`;


INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (NULL, '1', 'Cash In Audit', 'admin/audit', '0'); 

ALTER TABLE `employees` ADD `emp_brands` varchar(50)  NULL DEFAULT Null AFTER `workplace_model`; 
UPDATE `employees` SET `emp_brands`= CONCAT(brand, ', ') ; 

ALTER TABLE `bankin` ADD `audit_chk`   tinyint(1)  NULL AFTER `desc_file`;
ALTER TABLE `bankin` ADD `audit_by`   int(11) NULL AFTER `audit_chk`;
ALTER TABLE `bankin` ADD `audit_date`   datetime NULL AFTER `audit_by`;
ALTER TABLE `bankin` ADD `audit_comment`   TEXT NULL AFTER `audit_date`;

ALTER TABLE `bankout` ADD `audit_chk`   tinyint(1)  NULL AFTER `desc_file`;
ALTER TABLE `bankout` ADD `audit_by`   int(11) NULL AFTER `audit_chk`;
ALTER TABLE `bankout` ADD `audit_date`   datetime NULL AFTER `audit_by`;
ALTER TABLE `bankout` ADD `audit_comment`   TEXT NULL AFTER `audit_date`;

INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (239, '1', 'Cash In Audit', 'admin/audit', '0'); 
INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (240, '1', 'Cash Out Audit', 'admin/audit', '0'); 
INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (241, '1', 'Bank In Audit', 'admin/audit', '0'); 
INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (242, '1', 'Bank Out Audit', 'admin/audit', '0'); 

ALTER TABLE `permission` ADD `menu_order`   int DEFAULT 0   AFTER `menu` ;

INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (243, '26', 'Commission List', 'commission/commissionList', '0'); 


ALTER TABLE `job` ADD `revenue`   DECIMAL(18,5) DEFAULT 0   AFTER `qc_flag` ;
ALTER TABLE `job` ADD `revenue_local`   DECIMAL(18,5) DEFAULT 0   AFTER `revenue` ;

ALTER TABLE `job` ADD `cost`   DECIMAL(18,5) DEFAULT 0   AFTER `revenue_local` ;
ALTER TABLE `job` ADD `cost_ex`   DECIMAL(18,5) DEFAULT 0   AFTER `cost` ;
ALTER TABLE `job` ADD `cost_tr`   DECIMAL(18,5) DEFAULT 0   AFTER `cost_ex` ;
ALTER TABLE `job` ADD `cost_le`   DECIMAL(18,5) DEFAULT 0   AFTER `cost_tr` ;
ALTER TABLE `job` ADD `cost_dtp`   DECIMAL(18,5) DEFAULT 0   AFTER `cost_le` ;
ALTER TABLE `job` ADD `profit`   DECIMAL(18,5) DEFAULT 0   AFTER `cost_dtp` ;


ALTER TABLE `commission_setting` CHANGE  rev_target_6  rev_target_from_6 double DEFAULT NULL;
ALTER TABLE `commission_setting` ADD  fixed_emp1  int after cogs_per_m6 DEFAULT NULL;
ALTER TABLE `commission_setting` ADD  fixed_emp1  int after cogs_per_m6 DEFAULT NULL;
ALTER TABLE `commission_setting` ADD  fixed_emp1  int after cogs_per_m6 DEFAULT NULL;
ALTER TABLE `commission_setting` ADD  fixed_emp1  int after cogs_per_m6 DEFAULT NULL;
ALTER TABLE `commission_setting` ADD  fixed_emp1  int after cogs_per_m6 DEFAULT NULL;



ALTER TABLE `payroll` ADD `num_month` TINYINT(1) NULL AFTER `comment`, ADD `monthly_installment` DOUBLE NULL AFTER `num_month`; 
<<<<<<< Updated upstream
INSERT INTO `group` (`id`, `name`, `icon`) VALUES ('27', 'Profit Share', '<span class=\"svg-icon svg-icon-primary svg-icon-2x\"><!--begin::Svg Icon | path:C:\\wamp64\\www\\keenthemes\\themes\\metronic\\theme\\html\\demo5\\dist/../src/media/svg/icons\\Code\\Settings4.svg--><svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"24px\" height=\"24px\" viewBox=\"0 0 24 24\" version=\"1.1\">\r\n    <g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">\r\n        <rect x=\"0\" y=\"0\" width=\"24\" height=\"24\"/>\r\n        <path d=\"M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z\" fill=\"#000000\" fill-rule=\"nonzero\" opacity=\"0.3\"/>\r\n        <path d=\"M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z\" fill=\"#000000\"/>\r\n    </g>\r\n</svg><!--end::Svg Icon--></span>');
INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES ('244', '27', 'Profit Share', 'profitShare/', '1');
INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES ('245', '27', 'Settings', 'profitShare/settings', '1')
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '27', '244', '1', '0', '1', '1', '1', '1', '3017'); 
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '27', '244', '21', '0', '1', '1', '1', '1', '3017'); 
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '27', '244', '31', '0', '1', '1', '1', '1', '3017'); 
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '27', '245', '1', '0', '1', '1', '1', '1', '3017'); 
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '27', '245', '21', '0', '1', '1', '1', '1', '3017'); 
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '27', '245', '31', '0', '1', '1', '1', '1', '3017'); 

CREATE TABLE `company_target` (
  `id` int(11) NOT NULL,
  `year` varchar(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 
ALTER TABLE `company_target`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `company_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `company_target_details` (
  `id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `target` double NOT NULL,
  `acheived_1` double NOT NULL DEFAULT 0 COMMENT '1:The first half ',
  `acheived_2` double NOT NULL DEFAULT 0 COMMENT '2:The second half 	'
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `company_target_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_id` (`target_id`);
ALTER TABLE `company_target_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `emp_finance_2023` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `salary` double NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emp_finance_2023`
--

INSERT INTO `emp_finance_2023` (`id`, `emp_id`, `salary`, `created_by`, `created_at`) VALUES
(1, 12, 15000, 357, '2023-09-22 15:16:21'),
(2, 35, 15000, 357, '2023-10-02 15:16:21'),
(3, 221, 150000, 357, '2024-01-08 11:22:16'),
(4, 155, 10000, 357, '2024-01-10 11:14:09'),
(5, 222, 100000, 357, '2024-01-11 13:30:03'),
(6, 223, 0, 357, '2024-01-11 13:34:15'),
(7, 224, 0, 357, '2024-01-11 13:39:02'),
(8, 227, 0, 357, '2024-01-11 15:46:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emp_finance_2023`
--
ALTER TABLE `emp_finance_2023`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emp_finance_2023`
--
ALTER TABLE `emp_finance_2023`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

CREATE TABLE `kpi_teamleaders` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `half` tinyint(1) NOT NULL,
  `year` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kpi_teamleaders`
--

INSERT INTO `kpi_teamleaders` (`id`, `emp_id`, `half`, `year`, `score`, `created_by`, `created_at`) VALUES
(1, 224, 1, '2023', 0, 357, '2024-02-02 18:46:25'),
(2, 224, 2, '2023', 1, 357, '2024-02-02 18:46:25'),
(3, 16, 1, '2023', 0, 357, '2024-02-02 18:46:25'),
(4, 16, 2, '2023', 1, 357, '2024-02-02 18:46:25'),
(5, 23, 2, '2023', 3, 357, '2024-02-02 18:46:25'),
(6, 25, 1, '2023', 4, 357, '2024-02-02 18:46:25'),
(7, 23, 1, '2023', 2, 357, '2024-02-02 18:46:25'),
(8, 25, 2, '2023', 2, 357, '2024-02-02 18:46:25'),
(9, 35, 1, '2023', 1, 357, '2024-02-02 18:46:25'),
(10, 35, 2, '2023', 2, 357, '2024-02-02 18:46:25'),
(11, 40, 1, '2023', 3, 357, '2024-02-02 18:46:25'),
(12, 40, 2, '2023', 4, 357, '2024-02-02 18:46:25'),
(13, 43, 1, '2023', 0, 357, '2024-02-02 18:46:25'),
(14, 43, 2, '2023', 0, 357, '2024-02-02 18:46:25'),
(15, 44, 1, '2023', 0, 357, '2024-02-02 18:46:25'),
(16, 44, 2, '2023', 3, 357, '2024-02-02 18:46:25'),
(17, 45, 1, '2023', 3, 357, '2024-02-02 18:46:25'),
(18, 45, 2, '2023', 3, 357, '2024-02-02 18:46:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kpi_teamleaders`
--
ALTER TABLE `kpi_teamleaders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kpi_teamleaders`
--
ALTER TABLE `kpi_teamleaders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `employees` ADD `region_id` INT(11) NULL DEFAULT NULL AFTER `emp_brands`; 

CREATE TABLE `profitshare_bonus` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `half` tinyint(1) NOT NULL,
  `year` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

ALTER TABLE `profitshare_bonus`
  ADD PRIMARY KEY (`id`);

INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES ('247', '3', 'Rate Indicator', 'sales/rateIndicator', '1');
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '3', '247', '1', '0', '1', '1', '1', '1', '3035');
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '3', '247', '21', '0', '1', '1', '1', '1', '3035');
=======

ALTER TABLE `job` ADD KEY `project_id` (`project_id`);

ALTER TABLE `permission` ADD KEY `groups` (`groups`);

INSERT INTO `screen` (`id`,`groups`,`name`,`url`,`menu`) VALUES(236,26,'PM Commissions Rules','commission/commissionRules',1);
INSERT INTO `screen` (`id`,`groups`,`name`,`url`,`menu`) VALUES(243,26,'Commission List','commission/commissionList',1);
INSERT INTO `screen` (`id`,`groups`,`name`,`url`,`menu`) VALUES(246,26,'Commissions Matrix','commission',1);

CREATE TABLE `pmcommission_rules` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `year` varchar(4) NOT NULL,
  `month` varchar(2) NOT NULL,
  `pm_id` int(11) NOT NULL,
  `stnd_rule` int(1) NULL,
  `pm_rule` int(1) NULL,
  `super_rule` int(1) NULL,
  `mang_rule` int(1) NULL,
  
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `screen` (`id`, `groups`, `name`, `url`, `menu`) VALUES (249, '25', 'VM Setting', 'settings/vm_settings', '1');
INSERT INTO `permission` (`id`, `groups`, `screen`, `role`, `follow`, `add`, `edit`, `delete`, `view`, `menu_order`) VALUES (NULL, '25', '249', '21', '2', '1', '1', '1', '1', '2990');

CREATE TABLE `vm_setup` (
  `id` int(11) NOT NULL,
  `acceptance_offers_hours` double DEFAULT NULL,
  `unaccepted_offers_email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `vm_setup` (`id`, `acceptance_offers_hours`, `unaccepted_offers_email`) VALUES
(1, 1, "nehal.allam@thetranslationgate.com");

ALTER TABLE `vm_setup`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vm_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
