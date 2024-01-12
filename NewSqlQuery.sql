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

INSERT INTO `commission_setting` (`id`, `brand_id`, `region_id`, `year`, `month`, `date_from`, `date_to`, `standalone_per`, `teamleader_per`, `cogs_per`, `rev_target_from_1`, `rev_target_from_2`, `rev_target_from_3`, `rev_target_from_4`, `rev_target_from_5`, `rev_target_6`, `rev_target_to_1`, `rev_target_to_2`, `rev_target_to_3`, `rev_target_to_4`, `rev_target_to_5`, `cogs_per_l1`, `cogs_per_l2`, `cogs_per_l3`, `cogs_per_l4`, `cogs_per_l5`, `cogs_per_l6`, `cogs_per_m1`, `cogs_per_m2`, `cogs_per_m3`, `cogs_per_m4`, `cogs_per_m5`, `cogs_per_m6`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 2, '2023', '10', '2023-11-01', '2023-11-30', 3, 0.75, 60, 1, 3, NULL, NULL, NULL, 7.5, 3, 7.5, NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, 4, 1, 1.5, NULL, NULL, NULL, 2, 357, '2023-11-02 12:22:27', NULL, NULL),
(2, 1, 2, '2023', '09', '2023-11-01', '2023-11-30', 3, 0.75, 60, 1, 3, NULL, NULL, NULL, 7.5, 3, 7.5, NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, 4, 1, 1.5, NULL, NULL, NULL, 2, 357, '2023-11-02 12:22:27', NULL, NULL),
(3, 2, 0, '2023', '10', '2023-11-02', '2023-11-30', 3, 0.75, 60, 1, 3, 0, 0, 0, 7.5, 3, 7.5, 0, 0, 0, 2, 3, 0, 0, 0, 4, 1, 1.5, 0, 0, 0, 2, 357, '2023-11-03 15:55:23', NULL, NULL),
(5, 2, 0, '2023', '09', '2023-10-29', '2023-11-07', 3, 0.75, 60, 1, 3.1, 0, 0, 0, 7.5, 3, 7.5, 0, 0, 0, 2, 3, 0, 0, 0, 4, 1, 1.5, 0, 0, 0, 2, 357, '2023-11-06 14:14:04', 357, '2023-11-06 14:36:34'),
(6, 1, 2, '2023', '11', '2023-11-01', '2023-11-30', 3, 0.75, 60, 1, 3, NULL, NULL, NULL, 7.5, 3, 7.5, NULL, NULL, NULL, 2, 3, NULL, NULL, NULL, 4, 1, 1.5, NULL, NULL, NULL, 2, 357, '2023-11-06 14:41:46', NULL, NULL),
(7, 2, 0, '2023', '11', '2023-11-01', '2023-11-30', 3, 0.75, 60, 1, 3, 0, 0, 0, 7.5, 3, 7.5, 0, 0, 0, 2, 3, 0, 0, 0, 4, 1, 1.5, 0, 0, 0, 2, 357, '2023-11-06 14:41:46', NULL, NULL);

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

ALTER TABLE `payroll` ADD `num_month` TINYINT(1) NULL AFTER `comment`, ADD `monthly_installment` DOUBLE NULL AFTER `num_month`; 