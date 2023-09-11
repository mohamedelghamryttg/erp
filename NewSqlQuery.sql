ALTER TABLE `automation_tickets` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:new / 1 :opened / 2:in progress /3:closed / 4:pending / 5:cancelled';
ALTER TABLE `automation_tickets` ADD `comment` TEXT NULL AFTER `send_flg`; 

CREATE view active_employees AS 
select id, name , department ,manager from employees
where status = 0
CREATE VIEW attendance_view AS select log.`USRID`,log.`SRVDT` as SignIn,log.`location` as SignInLocation,`log2`.`SRVDT` AS SignOut,`log2`.`location` AS SignOutLocation from `attendance_log` `log` left join `attendance_log` `log2` on ( `log`.`USRID` = `log2`.`USRID` and `log2`.`TNAKEY` = '2' and ( `log2`.`SRVDT` between `log`.`SRVDT` and (`log`.`SRVDT` + interval 18 hour) ) and (`log2`.`SRVDT` > `log`.`SRVDT`) ) where ((`log`.`TNAKEY` = 1) and (year(`log`.`SRVDT`) > 2022)) order by `log2`.`SRVDT` desc; 