<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Server extends CI_Controller
{
	var $role, $user, $brand;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('Excelfile');
	}

	public function followUpRemainder()
	{
		$key = base64_decode($_GET['t']);
		if ($key == '@falaq123') {
			$row = $this->db->get_where('sales_follow_up', array('remainder' => 0))->result();
			foreach ($row as $row) {
				$next = strtotime($row->new_hitting) - 60 * 60;
				$after = strtotime("-1 hour");
				if ($next <= $after) {
					$this->sales_model->RemainderMail($row);
				}
			}
		} else {
		}
	}

	public function MeetingRemainder()
	{
		$key = base64_decode($_GET['t']);
		if ($key == '@falaq123') {
			$row = $this->db->get_where('meeting_room_schedule', array('remainder' => 0))->result();
			foreach ($row as $row) {
				$next = strtotime($row->start) - 70 * 60;
				$after = strtotime("-10 minutes");
				if ($next <= $after) {
					$this->hr_model->meetingMailRemainder($row);
					$this->db->update('meeting_room_schedule', array('remainder' => 1), array('id' => $row->id));
				}
			}
		} else {
		}
	}

	public function changeTicketToClose()
	{
		$key = base64_decode($_GET['t']);
		if ($key == '@falaq123') {
			$this->vendor_model->changeTicketToClose();
		} else {
		}
	}

	public function sendLateDeliveryJobs()
	{
		//https://falaq.thetranslationgate.com/server/sendLateDeliveryJobs?t=QGZhbGFxMTIz
		$key = base64_decode($_GET['t']);
		if ($key == '@falaq123') {
			$now = date("Y-m-d H:i:s");
			$nowFilter = "delivery_date < '$now'";
			$jobs = $this->projects_model->lateDeliveryReport($nowFilter, 1);
			$total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objReader->load('assets/uploads/excel/Late_jobs.xlsx');
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$rows = 2;
			foreach ($jobs->result() as $row) {
				$priceList = $this->projects_model->getJobPriceListData($row->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($row->id, $row->type, $row->volume, $priceList->id);
				$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $this->admin_model->getAdmin($row->created_by));
				$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $row->code);
				$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $row->name);
				$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $this->admin_model->getServices($priceList->service));
				$objPHPExcel->getActiveSheet()->setCellValue('e' . $rows, $this->admin_model->getLanguage($priceList->source));
				$objPHPExcel->getActiveSheet()->setCellValue('f' . $rows, $this->admin_model->getLanguage($priceList->target));
				$objPHPExcel->getActiveSheet()->setCellValue('g' . $rows, $total_revenue);
				$objPHPExcel->getActiveSheet()->setCellValue('h' . $rows, $this->admin_model->getCurrency($priceList->currency));
				$objPHPExcel->getActiveSheet()->setCellValue('i' . $rows, $row->start_date);
				$objPHPExcel->getActiveSheet()->setCellValue('j' . $rows, $row->delivery_date);
				$rows++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$fileName = 'late_delivery_report_' . date("Y-m-d_H_i_s") . '.xlsx';
			$objWriter->save(getcwd() . '/assets/uploads/late_delivery_daily_report/' . $fileName);
			$this->projects_model->sendLateDeliveryJobsMail($fileName);
		}
	}

	public function ticketsCheck()
	{
		$ticket = $this->db->query("SELECT * FROM vm_ticket WHERE status = '5'");
		foreach ($ticket->result() as $row) {
			$statusRow = $this->db->query("SELECT * FROM vm_ticket_time WHERE ticket = '$row->id' AND status = '5' ORDER BY id DESC LIMIT 1")->row();
			$lastDate = strtotime($statusRow->created_at);
			$currentDate = strtotime("now");
			$diff = $currentDate - $lastDate;
			$days = abs($lastDate - $currentDate) / 60 / 60 / 24;
			echo $row->id . " - " . $days . " - " . $diff;
			echo "</br>=============</br>";
		}
	}

	public function activeCustomersDaily()
	{
		// $key = base64_decode($_GET['t']);
		$key = '@falaq123';
		$brand = base64_decode($_GET['b']);
		$brand_name = $this->db->query("SELECT * FROM `brand` where id = '$brand'")->row()->abbreviations;

		$dbReportName =   "activeCustomersDaily - $brand_name";
		$sended = true;
		$query_tasks = $this->db->get_where('cron_tasks', array('command' => "$dbReportName"))->row();

		if ($query_tasks) {
			if ($query_tasks->report_date) {
				if (date("d",  strtotime($query_tasks->report_date)) == date("d")) {
					$sended = true;
				} else {
					$sended = false;
				}
			} else {

				$sended = false;
			}
			if ($sended == false) {
				$tasks_date = array('report_date' => date("Y-m-d"));
				$this->db->where('command', "$dbReportName");
				$this->db->update('cron_tasks', $tasks_date);

				if ($key == '@falaq123') {
					$day = date('D', strtotime("now"));
					$date = date("Y-m-d");
					if ($day == "Mon") {
						$yesterday_date = date("Y-m-d", strtotime("-3 days"));
					} else {
						$yesterday_date = date("Y-m-d", strtotime("-1 days"));
					}
					$activeCustomers = $this->db->query("SELECT l.id AS `lead`,l.customer,l.region,l.country,(SELECT COUNT(*) FROM project AS p
												LEFT OUTER JOIN job AS j ON p.id = j.project_id
												WHERE j.created_at BETWEEN '$yesterday_date' AND '$date' AND p.customer = l.customer AND p.lead = l.id) AS jobs_num
												FROM customer_leads AS l
												LEFT OUTER JOIN customer AS c ON c.id = l.customer
												WHERE c.status = '2' AND c.brand = '$brand'  
												HAVING jobs_num > '0'");

					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objPHPExcel = $objReader->load('assets/uploads/excel/Active_Customer_Daily.xlsx');
					$objWorksheet = $objPHPExcel->getActiveSheet();
					$rows = 2;
					foreach ($activeCustomers->result() as $row) {
						$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $this->customer_model->getCustomer($row->customer));
						$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $this->admin_model->getRegion($row->region));
						$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $this->admin_model->getCountry($row->country));
						$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $row->jobs_num);

						$rows++;
					}
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$fileName = 'active_customers_daily_' . $yesterday_date . '_' . $brand_name . '.xlsx';
					$objWriter->save(getcwd() . '/assets/uploads/active_customers_report/' . $fileName);
					$this->projects_model->activeCustomersDaily($fileName, $brand_name);
				}
			}
		} else {

			$tasks_date = array('command' => "$dbReportName", 'report_date' => date("Y-m-d"));
			$this->db->insert('cron_tasks', $tasks_date);
			// $key = base64_decode($_GET['t']);

			if ($key == '@falaq123') {
				$day = date('D', strtotime("now"));
				$date = date("Y-m-d");
				if ($day == "Mon") {
					$yesterday_date = date("Y-m-d", strtotime("-3 days"));
				} else {
					$yesterday_date = date("Y-m-d", strtotime("-1 days"));
				}
				$activeCustomers = $this->db->query("SELECT l.id AS `lead`,l.customer,l.region,l.country,(SELECT COUNT(*) FROM project AS p
												LEFT OUTER JOIN job AS j ON p.id = j.project_id
												WHERE j.created_at BETWEEN '$yesterday_date' AND '$date' AND p.customer = l.customer AND p.lead = l.id) AS jobs_num
												FROM customer_leads AS l
												LEFT OUTER JOIN customer AS c ON c.id = l.customer
												WHERE c.status = '2' AND c.brand = '$brand'  
												HAVING jobs_num > '0'");

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$objPHPExcel = $objReader->load('assets/uploads/excel/Active_Customer_Daily.xlsx');
				$objWorksheet = $objPHPExcel->getActiveSheet();
				$rows = 2;
				foreach ($activeCustomers->result() as $row) {
					$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $this->customer_model->getCustomer($row->customer));
					$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $this->admin_model->getRegion($row->region));
					$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $this->admin_model->getCountry($row->country));
					$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $row->jobs_num);

					$rows++;
				}
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$fileName = 'active_customers_daily_' . $yesterday_date . '_' . $brand_name . '.xlsx';
				$objWriter->save(getcwd() . '/assets/uploads/active_customers_report/' . $fileName);
				$this->projects_model->activeCustomersDaily($fileName, $brand_name);
			}
		}
	}

	public function activeCustomersWeekly()
	{
		// $key = base64_decode($_GET['t']);
		$key = '@falaq123';
		$brand = base64_decode($_GET['b']);
		$brand_name = $this->db->query("SELECT * FROM `brand` where id = '$brand'")->row()->abbreviations;
		if ($key == '@falaq123') {
			//https://falaq.thetranslationgate.com/server/activeCustomersWeekly?t=QGZhbGFxMTIz
			$date = date("Y-m-d");
			$week_date = date("Y-m-d", strtotime("-7 days"));
			$activeCustomers = $this->db->query("SELECT l.id AS `lead`,l.customer,l.region,l.country,(SELECT COUNT(*) FROM project AS p
												LEFT OUTER JOIN job AS j ON p.id = j.project_id
												WHERE j.created_at BETWEEN '$week_date' AND '$date' AND p.customer = l.customer AND p.lead = l.id) AS jobs_num
												FROM customer_leads AS l
												LEFT OUTER JOIN customer AS c ON c.id = l.customer
												WHERE c.status = '2' AND c.brand = '$brand'  
												HAVING jobs_num > '0'");

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objReader->load('assets/uploads/excel/Active_Customer_Daily.xlsx');
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$rows = 2;
			foreach ($activeCustomers->result() as $row) {
				$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $this->customer_model->getCustomer($row->customer));
				$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $this->admin_model->getRegion($row->region));
				$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $this->admin_model->getCountry($row->country));
				$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $row->jobs_num);

				$rows++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$fileName = 'active_customers_weekly_' . $week_date . '-' . $date . '_' . $brand_name . '.xlsx';
			$objWriter->save(getcwd() . '/assets/uploads/active_customers_report/' . $fileName);
			$this->projects_model->activeCustomersWeekly($fileName, $brand_name);
		}
	}

	public function activeCustomersMonthly()
	{
		$key = base64_decode($_GET['t']);
		if ($key == '@falaq123') {
			//https://falaq.thetranslationgate.com/server/activeCustomersMonthly?t=QGZhbGFxMTIz
			$date = date("Y-m-d");
			$month_date = date("Y-m-d", strtotime("-1 month"));
			$activeCustomers = $this->db->query("SELECT l.id AS `lead`,l.customer,l.region,l.country,(SELECT COUNT(*) FROM project AS p
												LEFT OUTER JOIN job AS j ON p.id = j.project_id
												WHERE j.created_at BETWEEN '$month_date' AND '$date' AND p.customer = l.customer AND p.lead = l.id) AS jobs_num
												FROM customer_leads AS l
												LEFT OUTER JOIN customer AS c ON c.id = l.customer
												WHERE c.status = '2' AND c.brand = '1'  
												HAVING jobs_num > '0'");

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objReader->load('assets/uploads/excel/Active_Customer_Daily.xlsx');
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$rows = 2;
			foreach ($activeCustomers->result() as $row) {
				$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $this->customer_model->getCustomer($row->customer));
				$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $this->admin_model->getRegion($row->region));
				$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $this->admin_model->getCountry($row->country));
				$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $row->jobs_num);

				$rows++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$fileName = 'active_customers_monthly_' . $month_date . '-' . $date . '.xlsx';
			$objWriter->save(getcwd() . '/assets/uploads/active_customers_report/' . $fileName);
			$this->projects_model->activeCustomersMonthly($fileName);
		}
	}

	public function operationalReportBYPM_old()
	{
		$key = base64_decode($_GET['t']);
		if ($key == '@falaq123') {
			//https://falaq.thetranslationgate.com/server/operationalReportBYPM?t=QGZhbGFxMTIz
			$day = date('d', strtotime("now"));
			if ($day > "06") {
				$start_date = date('Y-m', strtotime("now")) . "-06";
				$end_date = date('Y-m-d', strtotime("+1 day"));
			} else if ($day <= "06") {
				$start_date = date('Y-m', strtotime("-1 month")) . "-06";
				$end_date = date('Y-m-d', strtotime("+1 day"));
			}
			// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

			$TTGFileName = $this->admin_model->operationalReportBYPM(1, "TTG", $start_date, $end_date);
			$DTPFileName = $this->admin_model->operationalReportBYPM(2, "Localizera", $start_date, $end_date);
			$EuropeFileName = $this->admin_model->operationalReportBYPM(3, "EuropeLocalize", $start_date, $end_date);
			$ColumbusFileName = $this->admin_model->operationalReportBYPM(11, "Columbuslang", $start_date, $end_date);

			$this->admin_model->sendOperationalReportBYPM($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
		}
	}

	public function operationalReportBYCustomer()
	{
		$sended = true;
		$query_tasks = $this->db->get_where('cron_tasks', array('command' => 'operationalReportBYCustomer'))->row();

		if ($query_tasks) {
			if ($query_tasks->report_date) {
				if (date("d",  strtotime($query_tasks->report_date)) == date("d")) {
					$sended = true;
				} else {
					$sended = false;
				}
			} else {

				$sended = false;
			}
			// var_dump($sended);
			// die;
			if ($sended == false) {
				$tasks_date = array('report_date' => date("Y-m-d"));
				$this->db->where('command', 'operationalReportBYCustomer');
				$this->db->update('cron_tasks', $tasks_date);

				$key = base64_decode($_GET['t']);
				if ($key == '@falaq123') {
					$day = date('d', strtotime("now"));
					if ($day > "06") {
						$start_date = date('Y-m', strtotime("now")) . "-06";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					} else if ($day <= "06") {
						$start_date = date('Y-m', strtotime("-1 month")) . "-06";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					}
					// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

					$TTGFileName = $this->admin_model->operationalReportBYCustomer(1, "TTG", $start_date, $end_date);
					$DTPFileName = $this->admin_model->operationalReportBYCustomer(2, "Localizera", $start_date, $end_date);
					$EuropeFileName = $this->admin_model->operationalReportBYCustomer(3, "EuropeLocalize", $start_date, $end_date);
					$ColumbusFileName = $this->admin_model->operationalReportBYCustomer(11, "Columbuslang", $start_date, $end_date);

					$this->admin_model->sendOperationalReportBYCustomer($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
				}
			}
		} else {

			$tasks_date = array('command' => 'operationalReportBYCustomer', 'report_date' => date("Y-m-d"));
			$this->db->insert('cron_tasks', $tasks_date);
			$key = base64_decode($_GET['t']);
			if ($key == '@falaq123') {
				$day = date('d', strtotime("now"));
				if ($day > "06") {
					$start_date = date('Y-m', strtotime("now")) . "-06";
					$end_date = date('Y-m-d', strtotime("+1 day"));
				} else if ($day <= "06") {
					$start_date = date('Y-m', strtotime("-1 month")) . "-06";
					$end_date = date('Y-m-d', strtotime("+1 day"));
				}
				// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

				$TTGFileName = $this->admin_model->operationalReportBYCustomer(1, "TTG", $start_date, $end_date);
				$DTPFileName = $this->admin_model->operationalReportBYCustomer(2, "Localizera", $start_date, $end_date);
				$EuropeFileName = $this->admin_model->operationalReportBYCustomer(3, "EuropeLocalize", $start_date, $end_date);
				$ColumbusFileName = $this->admin_model->operationalReportBYCustomer(11, "Columbuslang", $start_date, $end_date);

				$this->admin_model->sendOperationalReportBYCustomer($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
			}
		}
	}

	public function operationalReportBYSAM()
	{
		$sended = true;
		$query_tasks = $this->db->get_where('cron_tasks', array('command' => 'operationalReportBYSAM'))->row();

		if ($query_tasks) {
			if ($query_tasks->report_date) {
				if (date("d",  strtotime($query_tasks->report_date)) == date("d")) {
					$sended = true;
				} else {
					$sended = false;
				}
			} else {

				$sended = false;
			}
			// var_dump($sended);
			// die;
			if ($sended == false) {
				$tasks_date = array('report_date' => date("Y-m-d"));
				$this->db->where('command', 'operationalReportBYSAM');
				$this->db->update('cron_tasks', $tasks_date);

				$key = base64_decode($_GET['t']);
				if ($key == '@falaq123') {
					//https://falaq.thetranslationgate.com/server/operationalReportBYSAM?t=QGZhbGFxMTIz
					$day = date('d', strtotime("now"));
					if ($day > "01") {
						$start_date = date('Y-m', strtotime("now")) . "-01";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					} else if ($day == "01") {
						$start_date = date('Y-m', strtotime("-1 month")) . "-01";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					}
					// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

					$TTGFileName = $this->admin_model->operationalReportBYSAM(1, "TTG", $start_date, $end_date);
					$DTPFileName = $this->admin_model->operationalReportBYSAM(2, "Localizera", $start_date, $end_date);
					$EuropeFileName = $this->admin_model->operationalReportBYSAM(3, "EuropeLocalize", $start_date, $end_date);
					$ColumbusFileName = $this->admin_model->operationalReportBYSAM(11, "Columbuslang", $start_date, $end_date);

					$this->admin_model->sendOperationalReportBYSAM($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
				}
			}
		} else {

			$tasks_date = array('command' => 'operationalReportBYSAM', 'report_date' => date("Y-m-d"));
			$this->db->insert('cron_tasks', $tasks_date);
			$key = base64_decode($_GET['t']);
			if ($key == '@falaq123') {
				//https://falaq.thetranslationgate.com/server/operationalReportBYSAM?t=QGZhbGFxMTIz
				$day = date('d', strtotime("now"));
				if ($day > "01") {
					$start_date = date('Y-m', strtotime("now")) . "-01";
					$end_date = date('Y-m-d', strtotime("+1 day"));
				} else if ($day == "01") {
					$start_date = date('Y-m', strtotime("-1 month")) . "-01";
					$end_date = date('Y-m-d', strtotime("+1 day"));
				}
				// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

				$TTGFileName = $this->admin_model->operationalReportBYSAM(1, "TTG", $start_date, $end_date);
				$DTPFileName = $this->admin_model->operationalReportBYSAM(2, "Localizera", $start_date, $end_date);
				$EuropeFileName = $this->admin_model->operationalReportBYSAM(3, "EuropeLocalize", $start_date, $end_date);
				$ColumbusFileName = $this->admin_model->operationalReportBYSAM(11, "Columbuslang", $start_date, $end_date);

				$this->admin_model->sendOperationalReportBYSAM($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
			}
		}
	}

	public function operationalReportBYSAMActivities()
	{
		$sended = true;
		$query_tasks = $this->db->get_where('cron_tasks', array('command' => 'operationalReportBYSAMActivities'))->row();

		if ($query_tasks) {
			if ($query_tasks->report_date) {
				if (date("d",  strtotime($query_tasks->report_date)) == date("d")) {
					$sended = true;
				} else {
					$sended = false;
				}
			} else {

				$sended = false;
			}
			// var_dump($sended);
			// die;
			if ($sended == false) {
				$tasks_date = array('report_date' => date("Y-m-d"));
				$this->db->where('command', 'operationalReportBYSAMActivities');
				$this->db->update('cron_tasks', $tasks_date);

				$key = base64_decode($_GET['t']);
				if ($key == '@falaq123') {
					//https://falaq.thetranslationgate.com/server/operationalReportBYSAMActivities?t=QGZhbGFxMTIz
					$day = date('d', strtotime("now"));
					if ($day > "01") {
						$start_date = date('Y-m', strtotime("now")) . "-01";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					} else if ($day == "01") {
						$start_date = date('Y-m', strtotime("-1 month")) . "-01";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					}
					// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

					$TTGFileName = $this->admin_model->operationalReportBYSAMActivities(1, "TTG", $start_date, $end_date);
					$DTPFileName = $this->admin_model->operationalReportBYSAMActivities(2, "Localizera", $start_date, $end_date);
					$EuropeFileName = $this->admin_model->operationalReportBYSAMActivities(3, "EuropeLocalize", $start_date, $end_date);
					$ColumbusFileName = $this->admin_model->operationalReportBYSAMActivities(11, "Columbuslang", $start_date, $end_date);

					$this->admin_model->sendOperationalReportBYSAMActivities($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
				}
			}
		} else {

			$tasks_date = array('command' => 'operationalReportBYSAMActivities', 'report_date' => date("Y-m-d"));
			$this->db->insert('cron_tasks', $tasks_date);
			$key = base64_decode($_GET['t']);
			if ($key == '@falaq123') {
				//https://falaq.thetranslationgate.com/server/operationalReportBYSAMActivities?t=QGZhbGFxMTIz
				$day = date('d', strtotime("now"));
				if ($day > "01") {
					$start_date = date('Y-m', strtotime("now")) . "-01";
					$end_date = date('Y-m-d', strtotime("+1 day"));
				} else if ($day == "01") {
					$start_date = date('Y-m', strtotime("-1 month")) . "-01";
					$end_date = date('Y-m-d', strtotime("+1 day"));
				}
				// echo "Start Date: ".$start_date."----"."End Date:".$end_date;

				$TTGFileName = $this->admin_model->operationalReportBYSAMActivities(1, "TTG", $start_date, $end_date);
				$DTPFileName = $this->admin_model->operationalReportBYSAMActivities(2, "Localizera", $start_date, $end_date);
				$EuropeFileName = $this->admin_model->operationalReportBYSAMActivities(3, "EuropeLocalize", $start_date, $end_date);
				$ColumbusFileName = $this->admin_model->operationalReportBYSAMActivities(11, "Columbuslang", $start_date, $end_date);

				$this->admin_model->sendOperationalReportBYSAMActivities($TTGFileName, $DTPFileName, $EuropeFileName, $ColumbusFileName, $start_date, $end_date);
			}
		}
	}
	// single reports
	public function singleOperationalReportBYBrand()
	{

		$brand = $this->db->get('brand')->result();
		foreach ($brand as $row) {
			if ($row->id != 4) {
				$PmFileName = 'operationalReportBYPM_' . $row->abbreviations . '_' . date('Y_m_d') . '.xlsx';
				$CustomerFileName = 'operationalReportBYCustomer_' . $row->abbreviations . '_' . date('Y_m_d') . '.xlsx';

				if ($row->id == 3) {
					$PmFileName = 'operationalReportBYPM_EuropeLocalize_' . date('Y_m_d') . '.xlsx';
					$CustomerFileName = 'operationalReportBYCustomer_EuropeLocalize_' . date('Y_m_d') . '.xlsx';
				}
				$this->admin_model->sendSingleOperationalReportBYBrand($PmFileName, $CustomerFileName, $row->id, $row->name);
			}
		}
	}
	public function operationalReportBYPM()
	{
		$sql = "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
		$this->db->query($sql);

		$sended = true;
		$query_tasks = $this->db->get_where('cron_tasks', array('command' => 'operationalReportBYPM'))->row();
		if ($query_tasks) {
			if ($query_tasks->report_date) {
				if (date("d",  strtotime($query_tasks->report_date)) == date("d")) {
					$sended = true;
				} else {
					$sended = false;
				}
			} else {

				$sended = false;
			}

			if ($sended == false) {
				$tasks_date = array('report_date' => date("Y-m-d"));
				$this->db->where('command', 'operationalReportBYPM');
				$this->db->update('cron_tasks', $tasks_date);

				$key = base64_decode($_GET['t']);
				if ($key == '@falaq123') {
					// https: //falaq.thetranslationgate.com/server/operationalReportBYPM?t=QGZhbGFxMTIz

					$day = date('d', strtotime("now"));
					if ($day > "06") {
						$start_date = date('Y-m', strtotime("now")) . "-06";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					} else if ($day <= "06") {
						$start_date = date('Y-m', strtotime("-1 month")) . "-06";
						$end_date = date('Y-m-d', strtotime("+1 day"));
					}
					$operationalReportBYPMFileName = $this->admin_model->operationalReportBYPM($start_date, $end_date);
					$this->admin_model->sendOperationalReportBYPM_new($operationalReportBYPMFileName, $start_date, $end_date);
				}
			}
		} else {

			$tasks_date = array('command' => 'operationalReportBYPM', 'report_date' => date("Y-m-d"));
			$this->db->insert('cron_tasks', $tasks_date);
			$day = date('d', strtotime("now"));
			if ($day > "06") {
				$start_date = date('Y-m', strtotime("now")) . "-06";
				$end_date = date('Y-m-d', strtotime("+1 day"));
			} else if ($day <= "06") {
				$start_date = date('Y-m', strtotime("-1 month")) . "-06";
				$end_date = date('Y-m-d', strtotime("+1 day"));
			}

			$operationalReportBYPMFileName = $this->admin_model->operationalReportBYPM($start_date, $end_date);
			$this->admin_model->sendOperationalReportBYPM_new($operationalReportBYPMFileName, $start_date, $end_date);
		}
	}
}
