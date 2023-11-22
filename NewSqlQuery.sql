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

ALTER TABLE `customer` ADD `customer_profile` TEXT NULL AFTER `client_type`, ADD `notes` TEXT NULL AFTER `customer_profile`; 
