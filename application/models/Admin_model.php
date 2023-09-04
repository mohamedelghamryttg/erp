<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Admin_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function verfiyLogin()
	{
		$loggedin = $this->session->userdata('loggedin');
		if (!isset($loggedin) || $loggedin != 1) {
			$this->load->helper('url');
			redirect(base_url() . "login/");
		}
	}

	public function checkPermission($role, $screen)
	{
		$num = $this->db->get_where('permission', array('screen' => $screen, 'role' => $role))->num_rows();
		if ($num > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function addToLoggerDelete($table_name = "", $screen = "", $transaction_id_name = "", $transaction_id = "", $parent = "", $parent_id = "", $created_by = "")
	{
		//Table Structure ...
		$table_structure = $this->db->query(" SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='falaq' AND `TABLE_NAME`='$table_name' ")->result();
		$key = array();
		$count = 0;
		$columns_name = "";
		foreach ($table_structure as $column) {
			array_push($key, $column->COLUMN_NAME);
			if ($count == 0) {
				$columns_name = $column->COLUMN_NAME;
			} else {
				$columns_name .= "," . $column->COLUMN_NAME;
			}
			$count++;
		}
		//Get Data ...
		$data = $this->db->get_where($table_name, array($transaction_id_name => $transaction_id))->result();
		foreach ($data as $data) {
			$data_count = 0;
			$columns_value = "";
			foreach ($key as $value) {
				if ($data_count == 0) {
					$columns_value = "'" . $data->$value . "'";
				} else {
					$columns_value .= ",'" . $data->$value . "'";
				}
				$data_count++;
			}
			$logger['screen'] = $screen;
			$logger['data'] = "INSERT INTO $table_name($columns_name)VALUES($columns_value);";
			$logger['table_name'] = $table_name;
			$logger['transaction_id_name'] = $transaction_id_name;
			$logger['transaction_id'] = $transaction_id;
			$logger['type'] = 2;
			$logger['parent'] = $parent;
			$logger['parent_id'] = $parent_id;
			$logger['created_by'] = $created_by;
			$logger['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('logger', $logger);
		}
	}

	public function addToLoggerUpdate($table_name = "", $screen = "", $transaction_id_name = "", $transaction_id = "", $parent = "", $parent_id = "", $created_by = "")
	{
		//Table Structure ...
		$table_structure = $this->db->query(" SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='falaq' AND `TABLE_NAME`='$table_name' ")->result();
		$key = array();
		$count = 0;
		foreach ($table_structure as $column) {
			array_push($key, $column->COLUMN_NAME);
		}
		//Get Data ...
		$data = $this->db->get_where($table_name, array($transaction_id_name => $transaction_id))->result();
		foreach ($data as $data) {
			$data_count = 0;
			$sets = "";
			foreach ($key as $value) {
				if ($data_count == 0) {
					$sets = $value . " = '" . $data->$value . "'";
				} else {
					$sets .= "," . $value . " = '" . $data->$value . "'";
				}
				$data_count++;
			}
			$logger['screen'] = $screen;
			$logger['data'] = "UPDATE $table_name SET $sets WHERE $transaction_id_name = $transaction_id;";
			$logger['table_name'] = $table_name;
			$logger['transaction_id_name'] = $transaction_id_name;
			$logger['transaction_id'] = $transaction_id;
			$logger['type'] = 1;
			$logger['parent'] = $parent;
			$logger['parent_id'] = $parent_id;
			$logger['created_by'] = $created_by;
			$logger['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('logger', $logger);
		}
	}

	public function getGroupByRole($role)
	{
		$sql = "SELECT DISTINCT `groups` FROM `permission` WHERE `role` = '$role' AND `groups` <> '0' ";

		$result = $this->db->query($sql)->result();
		return $result;
	}

	public function getGroupByScreen($screen)
	{
		$result = $this->db->query(" SELECT * FROM `screen` WHERE id = '$screen' ")->row();
		return $result->groups;
	}

	public function getGroup($group)
	{
		if ($group == 0) {
			return "";
		} else {
			$result = $this->db->get_where('group', array('id' => $group))->row();
			return $result;
		}
	}

	public function getScreen($screen)
	{
		$result = $this->db->get_where('screen', array('id' => $screen))->row();
		return $result;
	}

	public function getScreenName($screen)
	{
		$result = $this->db->get_where('screen', array('id' => $screen))->row();
		return $result->name ?? '';
	}
	public function getScreenID($screen_name)
	{
		$result = $this->db->get_where('screen', array('name' => $screen_name))->row();
		return $result->id;
	}
	public function selectScreen($id = "")
	{
		$screen = $this->db->get('screen')->result();
		$data = "";
		foreach ($screen as $screen) {
			if ($screen->id == $id) {
				$data .= "<option value='" . $screen->id . "' selected='selected'>" . $screen->name . "</option>";
			} else {
				$data .= "<option value='" . $screen->id . "'>" . $screen->name . "</option>";
			}
		}
		return $data;
	}

	public function allRoles()
	{
		$data = $this->db->get('role');
		return $data;
	}
	public function getRole($role)
	{
		$result = $this->db->get_where('role', array('id' => $role))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectRole($id = "")
	{
		$role = $this->db->get('role')->result();
		$data = "";
		foreach ($role as $role) {
			if ($role->id == $id) {
				$data .= "<option value='" . $role->id . "' selected=''>" . $role->name . "</option>";
			} else {
				$data .= "<option value='" . $role->id . "'>" . $role->name . "</option>";
			}
		}
		return $data;
	}


	public function selectEmployees($id = "")
	{
		$employees = $this->db->get('employees')->result();
		$data = "";
		foreach ($employees as $employees) {
			if ($employees->id == $id) {
				$data .= "<option value='" . $employees->id . "' selected=''>" . $employees->name . "</option>";
			} else {
				$data .= "<option value='" . $employees->id . "'>" . $employees->name . "</option>";
			}
		}
		return $data;
	}


	public function selectGroup($id = "")
	{
		$group = $this->db->get('group')->result();
		$data = "";
		foreach ($group as $group) {
			if ($group->id == $id) {
				$data .= "<option value='" . $group->id . "' selected=''>" . $group->name . "</option>";
			} else {
				$data .= "<option value='" . $group->id . "'>" . $group->name . "</option>";
			}
		}
		return $data;
	}

	public function getScreenByGroupAndRole($groups, $role)
	{
		$result = $this->db->query(" SELECT p.* FROM `permission` AS p INNER JOIN screen AS s ON p.screen = s.id WHERE s.menu = '1' and p.groups = '$groups' and p.role = '$role' ")->result();
		return $result;
	}

	public function getScreenByPermissionByRole($role, $screen)
	{
		$result = $this->db->get_where('permission', array('role' => $role, 'screen' => $screen))->row();
		return $result;
	}

	public function getUser($user)
	{
		$result = $this->db->get_where('users', array('id' => $user))->row();
		if (isset($result->user_name)) {
			return $result->user_name;
		} else {
			return '';
		}
	}

	public function getUserImage($user)
	{
		$result = $this->db->get_where('users', array('id' => $user))->row();
		return $result->image;
	}
	public function allPermissions($limit, $offset, $filter = '')
	{

		$this->db->limit($limit, $offset);
		if ($filter) {
			$sql = "select * from permission where " . $filter . " order by id  LIMIT $limit OFFSET $offset ";

			$data = $this->db->query($sql);
		} else {
			$sql = "select * from permission order by id  LIMIT $limit OFFSET $offset ";

			$data = $this->db->query($sql);
		}

		return $data;
	}

	public function selectBrand($id = "")
	{
		$brand = $this->db->get('brand')->result();
		$data = "";
		foreach ($brand as $brand) {
			if ($brand->id == $id) {
				$data .= "<option value='" . $brand->id . "' selected='selected'>" . $brand->name . "</option>";
			} else {
				$data .= "<option value='" . $brand->id . "'>" . $brand->name . "</option>";
			}
		}
		return $data;
	}

	public function getBrand($brand)
	{
		$result = $this->db->get_where('brand', array('id' => $brand))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectRegion($id = "")
	{
		$region = $this->db->get('regions')->result();
		$data = "";
		foreach ($region as $region) {
			if ($region->id == $id) {
				$data .= "<option value='" . $region->id . "' selected='selected'>" . $region->name . "</option>";
			} else {
				$data .= "<option value='" . $region->id . "'>" . $region->name . "</option>";
			}
		}
		return $data;
	}

	public function getRegion($region)
	{
		$result = $this->db->get_where('regions', array('id' => $region))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectCountries($id = "", $region = "")
	{
		$countries = $this->db->get_where('countries', array('region' => $region))->result();
		$data = "";
		foreach ($countries as $countries) {
			if ($countries->id == $id) {
				$data .= "<option value='" . $countries->id . "' selected='selected'>" . $countries->name . "</option>";
			} else {
				$data .= "<option value='" . $countries->id . "'>" . $countries->name . "</option>";
			}
		}
		return $data;
	}

	public function selectAllCountries($id = "")
	{
		$countries = $this->db->get('countries')->result();
		$data = '';
		foreach ($countries as $countries) {
			if ($countries->id == $id) {
				$data .= "<option value='" . $countries->id . "' selected='selected'>" . $countries->name . "</option>";
			} else {
				$data .= "<option value='" . $countries->id . "'>" . $countries->name . "</option>";
			}
		}
		return $data;
	}

	public function getCountry($country)
	{
		$result = $this->db->get_where('countries', array('id' => $country))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectFollowUp($select = "")
	{
		if ($select == 1) {
			$selected1 = 'selected';
			$selected3 = '';
			$selected2 = '';
		} elseif ($select == 2) {
			$selected2 = 'selected';
			$selected3 = '';
			$selected1 = '';
		} else {
			$selected1 = '';
			$selected2 = '';
			$selected3 = 'selected';
		}

		$outpt = '
		<option value="0" ' . $selected3 . '>-- Select Follow-Up --</option>
		<option value="2" ' . $selected2 . '>Team Leader</option>
                  <option value="1" ' . $selected1 . '>Team</option>';
		return $outpt;
	}

	public function getFollowUp($select = "")
	{
		if ($select == 1) {
			$outpt = 'Team';
		} elseif ($select == 2) {
			$outpt = 'Team Leader';
		} else {
			$outpt = "";
		}
		return $outpt;
	}

	public function getAdmin($admin = "")
	{
		$result = $this->db->get_where('users', array('id' => $admin))->row();
		if (isset($result->user_name)) {
			return $result->user_name;
		} else {
			return '';
		}
	}

	public function getAdminMulti($ids = 0)
	{
		if ($ids == NULL) {
			$ids = 0;
		}
		$result = $this->db->query(" SELECT GROUP_CONCAT(user_name SEPARATOR '- ') AS names FROM `users` WHERE id IN(" . $ids . ")  ")->row();
		if (isset($result->names)) {
			return $result->names;
		} else {
			return '';
		}
	}

	public function selectLanguage($id = "")
	{
		$languages = $this->db->order_by('name', 'ASC')->get('languages')->result();
		$data = '';
		foreach ($languages as $languages) {
			if ($languages->id == $id) {
				$data .= "<option value='" . $languages->id . "' selected='selected'>" . $languages->name . "</option>";
			} else {
				$data .= "<option value='" . $languages->id . "'>" . $languages->name . "</option>";
			}
		}
		return $data;
	}

	public function getLanguage($languages)
	{
		$result = $this->db->get_where('languages', array('id' => $languages))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function getLanguageID($languages)
	{
		$result = $this->db->get_where('languages', array('name' => $languages))->row();
		if (isset($result->id)) {
			return $result->id;
		} else {
			return '';
		}
	}

	public function selectTaskType($id = "", $parent = "")
	{
		$task = $this->db->get_where('task_type', array('parent' => $parent))->result();
		$data = "";
		foreach ($task as $task) {
			if ($task->id == $id) {
				$data .= "<option value='" . $task->id . "' selected='selected'>" . $task->name . "</option>";
			} else {
				$data .= "<option value='" . $task->id . "'>" . $task->name . "</option>";
			}
		}
		return $data;
	}

	public function selectAllTaskType($id = "")
	{
		$task = $this->db->get('task_type')->result();
		$data = "";
		foreach ($task as $task) {
			if ($task->id == $id) {
				$data .= "<option value='" . $task->id . "' selected='selected'>" . $task->name . "</option>";
			} else {
				$data .= "<option value='" . $task->id . "'>" . $task->name . "</option>";
			}
		}
		return $data;
	}

	public function getTaskType($task_type)
	{
		$result = $this->db->get_where('task_type', array('id' => $task_type))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function getTaskTypeID($task_type)
	{
		$result = $this->db->get_where('task_type', array('name' => $task_type))->row();
		if (isset($result->id)) {
			return $result->id;
		} else {
			return '';
		}
	}

	public function getTaskTypeParent($task_type)
	{
		$parent = $this->db->get_where('task_type', array('id' => $task_type))->row()->parent;
		return $parent;
	}

	public function selectServices($id = "")
	{
		$service = $this->db->get('services')->result();
		$data = "";
		$data .= "<option disabled='disabled' selected='selected'> Select Service</option>";
		foreach ($service as $service) {
			if ($service->id == $id) {
				$data .= "<option value='" . $service->id . "' selected='selected'>" . $service->name . "</option>";
			} else {
				$data .= "<option value='" . $service->id . "'>" . $service->name . "</option>";
			}
		}
		return $data;
	}

	public function getServices($services)
	{
		$result = $this->db->get_where('services', array('id' => $services))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}
	public function selectServicesCat($id = "")
	{
		$service = $this->db->get('qcchklist_cat')->result();
		$data = "";
		$data .= "<option disabled='disabled' selected='selected'>-- Select Category --</option>";
		foreach ($service as $service) {
			if ($service->id == $id) {
				$data .= "<option value='" . $service->id . "' selected='selected'>" . $service->name . "</option>";
			} else {
				$data .= "<option value='" . $service->id . "'>" . $service->name . "</option>";
			}
		}
		return $data;
	}
	public function getServicesID($services)
	{
		$result = $this->db->get_where('services', array('name' => $services))->row();
		if (isset($result->id)) {
			return $result->id;
		} else {
			return '';
		}
	}

	public function selectFields($id = "")
	{
		$fields = $this->db->get_where('fields', array('status' => 0))->result();
		$data = "";
		foreach ($fields as $fields) {
			if ($fields->id == $id) {
				$data .= "<option value='" . $fields->id . "' selected='selected'>" . $fields->name . "</option>";
			} else {
				$data .= "<option value='" . $fields->id . "'>" . $fields->name . "</option>";
			}
		}
		return $data;
	}

	public function selectFieldsCheckBoxs($ids = "")
	{
		$fields = $this->db->get('fields_proz')->result();
		$data = "<table class='table table-striped'><tr>";
		$x = 1;
		foreach ($fields as $fields) {
			if ($x % 6 == 0) {
				$data .= "</tr><tr>";
			}
			if (in_array($fields->id, explode(",", $ids))) {
				$data .= "<td><input type='checkbox' name='fields[]' value='" . $fields->id . "' checked=''></td><td style='vertical-align: middle;'>" . $fields->name . "</td>";
			} else {
				$data .= "<td><input type='checkbox' name='fields[]' value='" . $fields->id . "'></td><td style='vertical-align: middle;'>" . $fields->name . "</td>";
			}
			$x++;
		}
		$data .= "</table>";
		return $data;
	}

	public function getFieldsProz($fields)
	{
		$result = $this->db->get_where('fields_proz', array('id' => $fields))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectMultiFields($id = "")
	{
		$fields = $this->db->get_where('fields', array('status' => 0))->result();
		$data = "";
		$arr_id = explode(",", $id);
		foreach ($fields as $fields) {
			if (in_array($fields->id, $arr_id)) {
				$data .= "<option value='" . $fields->id . "' selected='selected'>" . $fields->name . "</option>";
			} else {
				$data .= "<option value='" . $fields->id . "'>" . $fields->name . "</option>";
			}
		}
		return $data;
	}

	public function getFields($fields)
	{
		$result = $this->db->get_where('fields', array('id' => $fields))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function getFieldsID($fields)
	{
		$result = $this->db->get_where('fields', array('name' => $fields))->row();
		if (isset($result->id)) {
			return $result->id;
		} else {
			return '';
		}
	}

	public function selectUnit($id = "")
	{
		$unit = $this->db->get('unit')->result();
		$data = "";
		foreach ($unit as $unit) {
			if ($unit->id == $id) {
				$data .= "<option value='" . $unit->id . "' selected='selected'>" . $unit->name . "</option>";
			} else {
				$data .= "<option value='" . $unit->id . "'>" . $unit->name . "</option>";
			}
		}
		return $data;
	}

	public function getUnit($unit)
	{
		$result = $this->db->get_where('unit', array('id' => $unit))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function getUnitID($unit)
	{
		$result = $this->db->get_where('unit', array('name' => $unit))->row();
		if (isset($result->id)) {
			return $result->id;
		} else {
			return '';
		}
	}

	public function selectCurrency($id = "")
	{
		$currency = $this->db->get('currency')->result();
		$data = "";
		foreach ($currency as $currency) {
			if ($currency->id == $id) {
				$data .= "<option value='" . $currency->id . "' selected='selected'>" . $currency->name . "</option>";
			} else {
				$data .= "<option value='" . $currency->id . "'>" . $currency->name . "</option>";
			}
		}
		return $data;
	}

	public function getCurrency($currency)
	{
		$result = $this->db->get_where('currency', array('id' => $currency))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function getCurrencyID($currency)
	{
		$result = $this->db->get_where('currency', array('name' => $currency))->row();
		if (isset($result->id)) {
			return $result->id;
		} else {
			return '';
		}
	}

	public function getUserEmail($id)
	{
		$mail = $this->db->get_where('users', array('id' => $id))->row()->email;
		return $mail;
	}

	public function getUserData($id)
	{
		$user = $this->db->get_where('users', array('id' => $id))->row();
		return $user;
	}

	public function selectTimeZone($id = "")
	{
		$time_zone = $this->db->get_where('time_zone', array('status' => 1))->result();
		$data = "";
		foreach ($time_zone as $time_zone) {
			if ($time_zone->id == $id) {
				$data .= "<option value='" . $time_zone->id . "' selected='selected'>" . $time_zone->zone . " - " . $time_zone->gmt . "</option>";
			} else {
				$data .= "<option value='" . $time_zone->id . "'>" . $time_zone->zone . " - " . $time_zone->gmt . "</option>";
			}
		}
		return $data;
	}

	public function getTimeZone($time_zone)
	{
		$result = $this->db->get_where('time_zone', array('id' => $time_zone))->row();
		if (isset($result->zone)) {
			return $result->zone . ' - ' . $result->gmt;
		} else {
			return '';
		}
	}

	public function selectAllPm($id, $brand)
	{
		$sql = "SELECT id,user_name FROM `users` WHERE (role = '2' OR role = '29' OR role = '16' OR role = '42' OR role = '43' OR role = '45' OR role = '47' OR role = '52') AND brand = '$brand' ";
		$pm = $this->db->query($sql)->result();
		$data = "";
		foreach ($pm as $pm) {
			if ($pm->id == $id) {
				$data .= "<option value='" . $pm->id . "' selected='selected'>" . $pm->user_name . "</option>";
			} else {
				$data .= "<option value='" . $pm->id . "'>" . $pm->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectAllVm($brand)
	{
		$pm = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '11') AND brand = '$brand' AND status = '1' ")->result();
		$data = "";
		foreach ($pm as $pm) {
			// if ($pm->id == $id) {
			// 	$data .= "<option value='" . $pm->id . "' selected='selected'>" . $pm->user_name . "</option>";
			// } else {
			$data .= "<option value='" . $pm->id . "'>" . $pm->user_name . "</option>";
			// }
		}
		return $data;
	}

	public function selectAllPmAndSales($id, $brand)
	{
		$user = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '2' OR role = '3' OR role = '12' OR role = '16' OR role = '20' OR role = '29' OR role = '42' OR role = '43' OR role = '45' OR role = '47' OR role = '49') AND brand = '$brand' ORDER BY user_name ASC ")->result();
		$data = "";
		foreach ($user as $user) {
			if ($user->id == $id) {
				$data .= "<option value='" . $user->id . "' selected='selected'>" . $user->user_name . "</option>";
			} else {
				$data .= "<option value='" . $user->id . "'>" . $user->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectAllUsersByMail($brand, $id = 0)
	{
		$user = $this->db->query("SELECT id,user_name,email FROM `users` WHERE brand = '$brand' AND status = '1' ")->result();
		$data = "";
		foreach ($user as $user) {
			if ($user->id == $id) {
				$data .= "<option value='" . $user->id . "' selected='selected'>" . $user->user_name . " - " . $user->email . "</option>";
			} else {
				$data .= "<option value='" . $user->id . "'>" . $user->user_name . " - " . $user->email . "</option>";
			}
		}
		return $data;
	}

	public function getUsersByMail($admin)
	{
		$result = $this->db->get_where('users', array('id' => $admin))->row();
		if (isset($result->user_name)) {
			return $result->user_name . ' - ' . $result->email;
		} else {
			return '';
		}
	}

	public function selectDialect($id = "", $language = "")
	{
		$dialect = $this->db->get_where('languages_dialect', array('language' => $language))->result();
		$data = "";
		foreach ($dialect as $dialect) {
			if ($dialect->id == $id) {
				$data .= "<option value='" . $dialect->id . "' selected='selected'>" . $dialect->dialect . "</option>";
			} else {
				$data .= "<option value='" . $dialect->id . "'>" . $dialect->dialect . "</option>";
			}
		}
		return $data;
	}

	public function getDialect($dialect)
	{
		$result = $this->db->get_where('languages_dialect', array('id' => $dialect))->row();
		if (isset($result->dialect)) {
			return $result->dialect;
		} else {
			return '';
		}
	}

	public function selectDTPTaskType($id = "")
	{
		$task_type = $this->db->get('dtp_task_type')->result();
		$data = "";
		foreach ($task_type as $task_type) {
			if ($task_type->id == $id) {
				$data .= "<option value='" . $task_type->id . "' selected='selected'>" . $task_type->name . "</option>";
			} else {
				$data .= "<option value='" . $task_type->id . "'>" . $task_type->name . "</option>";
			}
		}
		return $data;
	}

	public function getDTPTaskType($task_type)
	{
		$result = $this->db->get_where('dtp_task_type', array('id' => $task_type))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectDTPApplication($id = "")
	{
		$application = $this->db->get('dtp_application')->result();
		$data = "";
		foreach ($application as $application) {
			if ($application->id == $id) {
				$data .= "<option value='" . $application->id . "' selected='selected'>" . $application->name . "</option>";
			} else {
				$data .= "<option value='" . $application->id . "'>" . $application->name . "</option>";
			}
		}
		return $data;
	}

	public function getDTPApplication($application)
	{
		$result = $this->db->get_where('dtp_application', array('id' => $application))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectDTPDirection($id = "")
	{
		$task_type = $this->db->get('dtp_direction')->result();
		$data = "";
		foreach ($task_type as $task_type) {
			if ($task_type->id == $id) {
				$data .= "<option value='" . $task_type->id . "' selected='selected'>" . $task_type->name . "</option>";
			} else {
				$data .= "<option value='" . $task_type->id . "'>" . $task_type->name . "</option>";
			}
		}
		return $data;
	}

	public function getDTPDirection($task_type)
	{
		$result = $this->db->get_where('dtp_direction', array('id' => $task_type))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectAllTranslator($brand, $user_id, $id = 0)
	{
		$translator = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '27' OR role = '28') AND brand = '$brand' AND status = '1' ")->result();
		$data = "";
		foreach ($translator as $translator) {
			if ($translator->id == $id) {
				$data .= "<option value='" . $translator->id . "' selected='selected'>" . $translator->user_name . "</option>";
			} else {
				$data .= "<option value='" . $translator->id . "'>" . $translator->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectLETaskType($id = "")
	{
		$task_type = $this->db->get('le_task_type')->result();
		$data = "";
		foreach ($task_type as $task_type) {
			if ($task_type->id == $id) {
				$data .= "<option value='" . $task_type->id . "' selected='selected'>" . $task_type->name . "</option>";
			} else {
				$data .= "<option value='" . $task_type->id . "'>" . $task_type->name . "</option>";
			}
		}
		return $data;
	}

	public function getLETaskType($task_type)
	{
		$result = $this->db->get_where('le_task_type', array('id' => $task_type))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectLESubject($id = "")
	{
		$subject = $this->db->get('le_subject_matter')->result();
		$data = "";
		foreach ($subject as $subject) {
			if ($subject->id == $id) {
				$data .= "<option value='" . $subject->id . "' selected='selected'>" . $subject->name . "</option>";
			} else {
				$data .= "<option value='" . $subject->id . "'>" . $subject->name . "</option>";
			}
		}
		return $data;
	}

	public function getLESubject($subject)
	{
		$result = $this->db->get_where('le_subject_matter', array('id' => $subject))->row();
		if (isset($result->name)) {
			return $result->name;
		} else {
			return '';
		}
	}

	public function selectAllLE($brand, $id = 0)
	{
		$translator = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '25' OR role = '26') AND brand = '$brand' ")->result();
		$data = "";
		foreach ($translator as $translator) {
			if ($translator->id == $id) {
				$data .= "<option value='" . $translator->id . "' selected='selected'>" . $translator->user_name . "</option>";
			} else {
				$data .= "<option value='" . $translator->id . "'>" . $translator->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectAllDTP($brand, $id = 0)
	{
		$translator = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '23' OR role = '24') AND brand = '$brand' ")->result();
		$data = "";
		foreach ($translator as $translator) {
			if ($translator->id == $id) {
				$data .= "<option value='" . $translator->id . "' selected='selected'>" . $translator->user_name . "</option>";
			} else {
				$data .= "<option value='" . $translator->id . "'>" . $translator->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectUsersEmail($email = "")
	{
		$user = $this->db->query("SELECT * FROM `employee` ")->result();
		$data = "";
		$singleEmail = explode(";", $email);
		foreach ($user as $user) {
			if (in_array($user->email, $singleEmail)) {
				$data .= "<option value='" . $user->email . "' selected='selected'>" . $user->email . "</option>";
			} else {
				$data .= "<option value='" . $user->email . "'>" . $user->email . "</option>";
			}
		}
		return $data;
	}


	public function selectMultiplePm($id = "", $brand = "")
	{
		$pm = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '2' OR role = '29' OR role = '16' OR role = '47' OR role = '52') AND brand = '$brand' AND status = '1' ")->result();
		$data = "";
		$singlePM = explode(";", $id);
		foreach ($pm as $pm) {
			if (in_array($pm->id, $singlePM)) {
				$data .= "<option value='" . $pm->id . "' selected='selected'>" . $pm->user_name . "</option>";
			} else {
				$data .= "<option value='" . $pm->id . "'>" . $pm->user_name . "</option>";
			}
		}
		return $data;
	}

	public function dtpCOGS($permission, $user, $brand, $filter)
	{
		if ($permission->view == 1) {
			$data = $this->db->query("SELECT l.*,j.price_list,j.name,j.code,j.volume,j.type,j.start_date,j.delivery_date,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM dtp_request AS l 
            LEFT OUTER JOIN job AS j on l.job_id = j.id WHERE j.id <> 0 AND " . $filter . " HAVING brand = '$this->brand' order by j.id desc ");
		}
		return $data;
	}

	public function AllLanguages($filter)
	{

		$data = $this->db->query("SELECT * FROM `languages` WHERE " . $filter . "  ORDER BY `name`");
		return $data;
	}

	public function AllLanguagesPages($limit, $offset)
	{
		$data = $this->db->query("SELECT * FROM `languages`  ORDER BY  name  LIMIT $limit OFFSET $offset ");
		return $data;
	}

	public function AllRecords($dbf_file, $filter, $order = "")
	{
		if ($order == "") {
			$order = 'id';
		}
		$sql = "SELECT * FROM `" . $dbf_file . "` WHERE " . $filter . "  ORDER BY " . $order;
		$data = $this->db->query($sql);
		return $data;
	}

	public function AllRecordsPages($dbf_file, $limit, $offset, $order = "")
	{
		if ($order == "") {
			$order = 'id';
		}
		$data = $this->db->query("SELECT * FROM `" . $dbf_file . "`  ORDER BY  " . $order . " LIMIT $limit OFFSET $offset ");
		return $data;
	}

	public function AllRecordsPagesLib($dbf_file, $filter, $limit, $offset, $order = "")
	{
		if ($order == "") {
			$order = 'id';
		}
		$sql = "SELECT * FROM `" . $dbf_file . "` WHERE " . $filter . "  ORDER BY  " . $order . " LIMIT $limit OFFSET $offset ";

		$data = $this->db->query($sql);
		return $data;
	}
	public function AllRecordsLib($dbf_file, $filter, $order = "")
	{
		if ($order == "") {
			$order = 'id';
		}
		$data = $this->db->query("SELECT * FROM `" . $dbf_file . "` WHERE " . $filter);
		return $data;
	}
	public function get_record_range_ID($dbf_file, $name)
	{
		$recodrs_id = "( ";
		$data = $this->db->query("SELECT * FROM `" . $dbf_file . "` where name like '%" . $name . "%'")->result();
		foreach ($data as $value) {
			$recodrs_id .= $value->id . ",";
		}
		$recodrs_id = substr($recodrs_id, 0, -1);
		$recodrs_id .= ")";
		if ($recodrs_id == "()") {
			$recodrs_id = "(0)";
		}
		return $recodrs_id;
	}
	//le amount request 
	public function selectLeLinguistFormat($id = "")
	{
		$linguist_format = $this->db->get('le_linguist_format')->result();
		$data = "";
		foreach ($linguist_format as $linguist_format) {
			if ($linguist_format->id == $id) {
				$data .= "<option value='" . $linguist_format->id . "' selected='selected'>" . $linguist_format->linguist_format . "</option>";
			} else {
				$data .= "<option value='" . $linguist_format->id . "'>" . $linguist_format->linguist_format . "</option>";
			}
		}
		return $data;
	}
	public function getLeLinguistFormat($id)
	{
		$result = $this->db->get_where('le_linguist_format', array('id' => $id))->row();
		if (isset($result->linguist_format)) {
			return $result->linguist_format;
		} else {
			return '';
		}
	}
	public function selectDeliverableFormat($id = "")
	{
		$deliverable_format = $this->db->get('le_deliverable_format')->result();
		$data = "";
		foreach ($deliverable_format as $deliverable_format) {
			if ($deliverable_format->id == $id) {
				$data .= "<option value='" . $deliverable_format->id . "' selected='selected'>" . $deliverable_format->deliverable_format . "</option>";
			} else {
				$data .= "<option value='" . $deliverable_format->id . "'>" . $deliverable_format->deliverable_format . "</option>";
			}
		}
		return $data;
	}
	public function getDeliverableFormat($id)
	{
		$result = $this->db->get_where('le_deliverable_format', array('id' => $id))->row();
		if (isset($result->deliverable_format)) {
			return $result->deliverable_format;
		} else {
			return '';
		}
	}

	public function selectLEUnit($id = "")
	{
		$unit = $this->db->query(" SELECT * FROM unit WHERE le = 1 ")->result();
		$data = "";
		foreach ($unit as $unit) {
			if ($unit->id == $id) {
				$data .= "<option value='" . $unit->id . "' selected='selected'>" . $unit->name . "</option>";
			} else {
				$data .= "<option value='" . $unit->id . "'>" . $unit->name . "</option>";
			}
		}
		return $data;
	}

	public function selectLeFormat($id = "")
	{
		$format = $this->db->get('le_format')->result();
		$data = "";
		foreach ($format as $format) {
			if ($format->id == $id) {
				$data .= "<option value='" . $format->id . "' selected='selected'>" . $format->format . "</option>";
			} else {
				$data .= "<option value='" . $format->id . "'>" . $format->format . "</option>";
			}
		}
		return $data;
	}
	public function getLeFormat($id)
	{
		$result = $this->db->get_where('le_format', array('id' => $id))->row();
		if (isset($result->format)) {
			return $result->format;
		} else {
			return '';
		}
	}

	public function selectDtpEmployeeId($id = "", $brand = "")
	{
		$dtp = $this->db->query(" SELECT * FROM users WHERE (role = '23' OR role = '24') AND brand = '$this->brand' AND status = '1' ")->result();
		$data = "";
		foreach ($dtp as $dtp) {
			if ($dtp->id == $id) {
				$data .= "<option value='" . $dtp->employees_id . "' selected='selected'>" . $dtp->user_name . "</option>";
			} else {
				$data .= "<option value='" . $dtp->employees_id . "'>" . $dtp->user_name . "</option>";
			}
		}
		return $data;
	}
	public function selectLeEmployeeId($id = "", $brand = "")
	{
		$le = $this->db->query(" SELECT * FROM users WHERE (role = '25' OR role = '26') AND brand = '$this->brand' AND status = '1' ")->result();
		$data = "";
		foreach ($le as $le) {
			if ($le->id == $id) {
				$data .= "<option value='" . $le->employees_id . "' selected='selected'>" . $le->user_name . "</option>";
			} else {
				$data .= "<option value='" . $le->employees_id . "'>" . $le->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectTranslatorEmployeeId($id = "", $brand = "")
	{
		$translator = $this->db->query(" SELECT * FROM users WHERE (role = '27' OR role = '28') AND brand = '$this->brand' AND status = '1' ")->result();
		$data = "";
		foreach ($translator as $translator) {
			if ($translator->id == $id) {
				$data .= "<option value='" . $translator->employees_id . "' selected='selected'>" . $translator->user_name . "</option>";
			} else {
				$data .= "<option value='" . $translator->employees_id . "'>" . $translator->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectTranslatorTeamleader($id = "", $brand = "")
	{
		$translator = $this->db->query(" SELECT * FROM users WHERE (role = '28') AND brand = '$this->brand' AND status = '1' ")->result();
		$data = "";
		foreach ($translator as $translator) {
			if ($translator->id == $id) {
				$data .= "<option value='" . $translator->id . "' selected='selected'>" . $translator->user_name . "</option>";
			} else {
				$data .= "<option value='" . $translator->id . "'>" . $translator->user_name . "</option>";
			}
		}
		return $data;
	}

	public function selectMarketingEmployeeId($id = "", $brand = "")
	{
		$marketing = $this->db->query(" SELECT * FROM users WHERE (role = '22' OR role = '34' OR role = '35') AND brand = '$this->brand' AND status = '1' ")->result();
		$data = "";
		foreach ($marketing as $marketing) {
			if ($marketing->id == $id) {
				$data .= "<option value='" . $marketing->employees_id . "' selected='selected'>" . $marketing->user_name . "</option>";
			} else {
				$data .= "<option value='" . $marketing->employees_id . "'>" . $marketing->user_name . "</option>";
			}
		}
		return $data;
	}

	//Operational Report ...
	public function operationalReportBYPM($brand, $brandName, $start_date, $end_date)
	{
		$pm = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE (u.role = '2' OR u.role = '29' OR u.role = '16' OR role = '20' OR u.role = '42' OR u.role = '43' OR u.role = '45' OR u.role = '47' OR u.role = '52') AND u.brand = '$brand' ");
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load('assets/uploads/excel/operationalReportBYPM.xlsx');
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$rows = 3;
		foreach ($pm->result() as $pm) {
			$runningProjects = $this->db->query(" SELECT * FROM `job` WHERE created_at < '$end_date' AND created_by = '$pm->id' AND project_id <> 0 AND status = 0 ");
			$totalRunning = 0;
			foreach ($runningProjects->result() as $running) {
				$priceList = $this->projects_model->getJobPriceListData($running->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($running->id, $running->type, $running->volume, $priceList->id);
				$totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $running->created_at, $total_revenue);
			}
			$closedProjects = $this->db->query(" SELECT * FROM `job` WHERE closed_date BETWEEN '$start_date' AND '$end_date' AND status ='1' AND created_by = '$pm->id' ");
			$totalClosed = 0;
			foreach ($closedProjects->result() as $closed) {
				$priceList = $this->projects_model->getJobPriceListData($closed->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($closed->id, $closed->type, $closed->volume, $priceList->id);
				$totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $closed->created_at, $total_revenue);
			}
			if ($totalClosed == 0 && $totalRunning == 0) {
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $pm->user_name);
				$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $runningProjects->num_rows());
				$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $totalRunning);
				$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $closedProjects->num_rows());
				$objPHPExcel->getActiveSheet()->setCellValue('e' . $rows, $totalClosed);

				$rows++;
			}
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$fileName = 'operationalReportBYPM_' . $brandName . '_' . date('Y_m_d') . '.xlsx';
		$objWriter->save(getcwd() . '/assets/uploads/OperationalReport/' . $fileName);

		return $fileName;
	}

	public function sendOperationalReportBYPM($TTGfile, $DTPfile, $Europefile, $Columbusfile, $start_date, $end_date)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$TTGfileName = base_url() . 'assets/uploads/OperationalReport/' . $TTGfile;
		$this->email->attach($TTGfileName);

		$DTPfileName = base_url() . 'assets/uploads/OperationalReport/' . $DTPfile;
		$this->email->attach($DTPfileName);

		$EuropefileName = base_url() . 'assets/uploads/OperationalReport/' . $Europefile;
		$this->email->attach($EuropefileName);

		$ColumbusfileName = base_url() . 'assets/uploads/OperationalReport/' . $Columbusfile;
		$this->email->attach($ColumbusfileName);

		$this->email->from("erp@aixnexus.com");
		$this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, heba.adam@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com ");
		$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("Operational Report By PM");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
    <body>
	<p>Hi,</p>
	<p>Kindly find Operational Report PM from ' . $start_date . ' To ' . $end_date . '</p>
   	<p>TTG,EuropeLocalize,Localizera,Columbuslang</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
	}

	public function operationalReportBYCustomer($brand, $brandName, $start_date, $end_date)
	{
		$customer = $this->db->query(" SELECT c.id,c.name,c.brand,c.status,l.id AS leadID,l.customer,l.region FROM customer_leads AS l LEFT OUTER JOIN customer AS c ON l.customer = c.id HAVING c.status = '2' AND brand = '$brand' ORDER BY c.name ASC ");
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load('assets/uploads/excel/operationalReportBYCustomer.xlsx');
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$rows = 3;
		foreach ($customer->result() as $customer) {
			$runningProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.created_at < '$end_date' AND p.lead = '$customer->leadID' AND project_id <> 0 AND j.status = 0 ");
			$totalRunning = 0;
			foreach ($runningProjects->result() as $running) {
				$priceList = $this->projects_model->getJobPriceListData($running->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($running->id, $running->type, $running->volume, $priceList->id);
				$totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $running->created_at, $total_revenue);
			}
			$closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.closed_date BETWEEN '$start_date' AND '$end_date' AND j.status ='1' AND p.lead = '$customer->leadID' ");
			$totalClosed = 0;
			foreach ($closedProjects->result() as $closed) {
				$priceList = $this->projects_model->getJobPriceListData($closed->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($closed->id, $closed->type, $closed->volume, $priceList->id);
				$totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $closed->created_at, $total_revenue);
			}

			$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $customer->name);
			$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $this->admin_model->getRegion($customer->region));
			$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $runningProjects->num_rows());
			$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $totalRunning);
			$objPHPExcel->getActiveSheet()->setCellValue('e' . $rows, $closedProjects->num_rows());
			$objPHPExcel->getActiveSheet()->setCellValue('f' . $rows, $totalClosed);

			$rows++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$fileName = 'operationalReportBYCustomer_' . $brandName . '_' . date('Y_m_d') . '.xlsx';
		$objWriter->save(getcwd() . '/assets/uploads/OperationalReport/' . $fileName);

		return $fileName;
	}

	public function sendOperationalReportBYCustomer($TTGfile, $DTPfile, $Europefile, $Columbusfile, $start_date, $end_date)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$TTGfileName = base_url() . 'assets/uploads/OperationalReport/' . $TTGfile;
		$this->email->attach($TTGfileName);

		$DTPfileName = base_url() . 'assets/uploads/OperationalReport/' . $DTPfile;
		$this->email->attach($DTPfileName);

		$EuropefileName = base_url() . 'assets/uploads/OperationalReport/' . $Europefile;
		$this->email->attach($EuropefileName);

		$ColumbusfileName = base_url() . 'assets/uploads/OperationalReport/' . $Columbusfile;
		$this->email->attach($ColumbusfileName);

		$this->email->from("erp@aixnexus.com");
		$this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, heba.adam@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("Operational Report By Customer");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
    <body>
	<p>Hi,</p>
	<p>Kindly find Operational Report Customer from ' . $start_date . ' To ' . $end_date . '</p>
   	<p>TTG,EuropeLocalize,Localizera,Columbuslang</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
	}

	public function operationalReportBYSAM($brand, $brandName, $start_date, $end_date)
	{
		$sam = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE u.status = '1' AND (u.role = '3' OR u.role = '29' OR role = '12' OR role = '20') AND u.brand = '$brand' ");
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load('assets/uploads/excel/operationalReportBYSAM.xlsx');
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$rows = 3;
		foreach ($sam->result() as $sam) {
			$runningProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = p.lead AND customer_sam.sam = '$sam->id') AS assigned FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.project_id <> 0 AND j.status = 0 AND j.created_at < '$end_date' HAVING assigned = '1' ");
			$totalRunning = 0;
			foreach ($runningProjects->result() as $running) {
				$priceList = $this->projects_model->getJobPriceListData($running->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($running->id, $running->type, $running->volume, $priceList->id);
				$totalRunning = $totalRunning + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $running->created_at, $total_revenue);
			}
			$closedProjects = $this->db->query(" SELECT j.*,p.customer,p.lead,(SELECT COUNT(*) FROM customer_sam WHERE customer_sam.lead = p.lead AND customer_sam.sam = '$sam->id') AS assigned FROM job AS j LEFT OUTER JOIN project AS p ON j.project_id = p.id WHERE j.project_id <> 0 AND j.status = 1 AND j.closed_date BETWEEN '$start_date' AND '$end_date' HAVING assigned = '1' ");
			$totalClosed = 0;
			foreach ($closedProjects->result() as $closed) {
				$priceList = $this->projects_model->getJobPriceListData($closed->price_list);
				$total_revenue = $this->sales_model->calculateRevenueJob($closed->id, $closed->type, $closed->volume, $priceList->id);
				$totalClosed = $totalClosed + $this->accounting_model->transfareTotalToCurrencyRate($priceList->currency, 2, $closed->created_at, $total_revenue);
			}

			$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $sam->user_name);
			$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $runningProjects->num_rows());
			$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $totalRunning);
			$objPHPExcel->getActiveSheet()->setCellValue('d' . $rows, $closedProjects->num_rows());
			$objPHPExcel->getActiveSheet()->setCellValue('e' . $rows, $totalClosed);

			$rows++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$fileName = 'operationalReportBYSAM_' . $brandName . '_' . date('Y_m_d') . '.xlsx';
		$objWriter->save(getcwd() . '/assets/uploads/OperationalReport/' . $fileName);

		return $fileName;
	}

	public function sendOperationalReportBYSAM($TTGfile, $DTPfile, $Europefile, $Columbusfile, $start_date, $end_date)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$TTGfileName = base_url() . 'assets/uploads/OperationalReport/' . $TTGfile;
		$this->email->attach($TTGfileName);

		$DTPfileName = base_url() . 'assets/uploads/OperationalReport/' . $DTPfile;
		$this->email->attach($DTPfileName);

		$EuropefileName = base_url() . 'assets/uploads/OperationalReport/' . $Europefile;
		$this->email->attach($EuropefileName);

		$ColumbusfileName = base_url() . 'assets/uploads/OperationalReport/' . $Columbusfile;
		$this->email->attach($ColumbusfileName);

		$this->email->from("erp@aixnexus.com");
		$this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, heba.adam@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("Operational Report By SAM");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
    <body>
	<p>Hi,</p>
	<p>Kindly find Operational Report SAM from ' . $start_date . ' To ' . $end_date . '</p>
   	<p>TTG,EuropeLocalize,Localizera,Columbuslang</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
	}

	public function operationalReportBYSAMActivities($brand, $brandName, $start_date, $end_date)
	{
		$sam = $this->db->query(" SELECT u.id,u.user_name FROM users AS u WHERE u.status = '1' AND (u.role = '3' OR u.role = '29' OR role = '12' OR role = '20') AND u.brand = '$brand' ");
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load('assets/uploads/excel/operationalReportSAMActivities.xlsx');
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$rows = 3;
		foreach ($sam->result() as $sam) {
			$activities = $this->db->query(" SELECT COUNT(*) AS total FROM `sales_activity` WHERE created_at BETWEEN '$start_date' AND '$end_date' AND created_by = '$sam->id' ")->row();
			$busimess = $this->db->query(" SELECT COUNT(*) AS total FROM `sales_business_reviews` WHERE created_at BETWEEN '$start_date' AND '$end_date' AND created_by = '$sam->id' ")->row();

			$objPHPExcel->getActiveSheet()->setCellValue('a' . $rows, $sam->user_name);
			$objPHPExcel->getActiveSheet()->setCellValue('b' . $rows, $activities->total);
			$objPHPExcel->getActiveSheet()->setCellValue('c' . $rows, $busimess->total);

			$rows++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$fileName = 'operationalReportBYSAMActivities_' . $brandName . '_' . date('Y_m_d') . '.xlsx';
		$objWriter->save(getcwd() . '/assets/uploads/OperationalReport/' . $fileName);

		return $fileName;
	}

	public function sendOperationalReportBYSAMActivities($TTGfile, $DTPfile, $Europefile, $Columbusfile, $start_date, $end_date)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$TTGfileName = base_url() . 'assets/uploads/OperationalReport/' . $TTGfile;
		$this->email->attach($TTGfileName);

		$DTPfileName = base_url() . 'assets/uploads/OperationalReport/' . $DTPfile;
		$this->email->attach($DTPfileName);

		$EuropefileName = base_url() . 'assets/uploads/OperationalReport/' . $Europefile;
		$this->email->attach($EuropefileName);

		$ColumbusfileName = base_url() . 'assets/uploads/OperationalReport/' . $Columbusfile;
		$this->email->attach($ColumbusfileName);

		$this->email->from("erp@aixnexus.com");
		$this->email->to("mohammad@thetranslationgate.com, shehab@thetranslationgate.com, sam-spocs@thetranslationgate.com, heba.adam@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("Operational Report By SAM Activties");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
    <body>
	<p>Hi,</p>
	<p>Kindly find Operational Report SAM Activties from ' . $start_date . ' To ' . $end_date . '</p>
   	<p>TTG,EuropeLocalize,Localizera,Columbuslang</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
	}

	public function getHomeQuickAction($role = 0)
	{
	}

	public function translationCOGS($permission, $user, $brand, $filter)
	{
		if ($permission->view == 1) {

			$sql = "SELECT j.*,p.number,i.id AS invoiceId,i.issue_date,i.lead,i.customer,(SELECT brand FROM `users` WHERE users.id = i.created_by) AS brand  FROM job AS j
        LEFT OUTER JOIN po AS p ON p.id = j.po
        LEFT OUTER JOIN invoices AS i ON FIND_IN_SET(p.id, i.po_ids) > 0
        WHERE " . $filter . " HAVING brand = '$brand' order by issue_date desc ";

			// $sql = "SELECT l.*,j.id AS job_id,j.price_list,j.name,j.code,j.volume,j.type AS job_type,j.created_at AS job_created_at,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM translation_request AS l 
			// LEFT OUTER JOIN job AS j on l.job_id = j.id WHERE j.id <> 0 AND l.status = '3' AND " . $filter . " HAVING brand = '$this->brand' order by j.id desc ";

			$data = $this->db->query($sql);
		}
		return $data;
	}

	public function leCOGS($permission, $user, $brand, $filter)
	{
		if ($permission->view == 1) {

			$sql = "SELECT l.*,j.id AS job_id,j.price_list,j.name,j.code,j.volume AS job_volume,j.type AS job_type,j.created_at AS job_created_at,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand 
			,(select unit from le_request_job where request_id = l.id limit 1) as unit
			,(select sum(volume) from le_request_job where request_id = l.id ) as count
			FROM le_request AS l 
			LEFT OUTER JOIN job AS j on l.job_id = j.id WHERE j.id <> 0 AND l.status = '3' AND " . $filter . " HAVING brand = '$this->brand' order by j.id desc ";

			$data = $this->db->query($sql);
		}
		return $data;
	}

	public function accountingDtpCOGS($permission, $user, $brand, $filter)
	{
		// if($permission->view == 1){
		//     $data = $this->db->query("SELECT l.*,j.price_list,j.name,j.code,j.volume,j.type,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand FROM dtp_request AS l 
		//     LEFT OUTER JOIN job AS j on l.job_id = j.id WHERE j.id <> 0 AND ".$filter." HAVING brand = '$this->brand' order by j.id desc ");
		// }
		// return $data;
		if ($permission->view == 1) {
			$sql = " SELECT DISTINCT(job_id), j.*,(SELECT brand FROM `users` WHERE users.id = j.created_by) AS brand
	 		FROM dtp_request AS d 
										LEFT OUTER JOIN job AS j ON j.id = d.job_id
										WHERE " . $filter . " HAVING brand = '$this->brand' order by j.id desc";

			$data = $this->db->query($sql);
		}
		return $data;
	}


	public function AllVendorsAccounts($brand, $filter)
	{

		$data = $this->db->query(" SELECT * FROM `vendor` WHERE " . $filter . " AND brand = '$brand' ORDER BY id ASC , id DESC ");
		return $data;
	}

	public function AllVendorsAccountsPages($brand, $limit, $offset)
	{
		$data = $this->db->query("SELECT * FROM `vendor` WHERE brand = '$brand' ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
		return $data;
	}

	public function selectAllVmTicketsUsers($id, $brand)
	{
		if ($brand == 3)
			$user = $this->db->query("SELECT DISTINCT users.id,users.user_name FROM `users` Join vm_ticket on users.id = vm_ticket.created_by And vm_ticket.from_id = 0 AND vm_ticket.ticket_from = 3 AND users.brand = 3 order by user_name ASC")->result();
		else
			$user = $this->db->query("SELECT DISTINCT users.id,users.user_name FROM `users` Join vm_ticket on users.id = vm_ticket.created_by And vm_ticket.from_id = 0 AND vm_ticket.ticket_from = 3 order by user_name ASC")->result();
		$data = "";
		foreach ($user as $user) {
			if ($user->id == $id) {
				$data .= "<option value='" . $user->id . "' selected='selected'>" . $user->user_name . "</option>";
			} else {
				$data .= "<option value='" . $user->id . "'>" . $user->user_name . "</option>";
			}
		}
		return $data;
	}

	// single reports
	public function sendSingleOperationalReportBYBrand($pmFile, $customerFile, $brand, $brandName)
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		$PMfileName = base_url() . 'assets/uploads/OperationalReport/' . $pmFile;
		$this->email->attach($PMfileName);

		$CustomerfileName = base_url() . 'assets/uploads/OperationalReport/' . $customerFile;
		$this->email->attach($CustomerfileName);

		$this->email->from("erp@aixnexus.com");

		if ($brand == 1) {
			$this->email->to("asmaa@thetranslationgate.com, lobna.abdou@thetranslationgate.com, esraa@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		} elseif ($brand == 11) {
			$this->email->to("asmaa@thetranslationgate.com, lobna.abdou@thetranslationgate.com, bela.levi@columbuslang.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		} elseif ($brand == 2) {
			$this->email->to("dalia.diab@localizera.com, lobna.abdou@thetranslationgate.com, sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		} elseif ($brand == 3) {
			$this->email->to("asmaa@thetranslationgate.com, lobna.abdou@thetranslationgate.com, lina.mashad@thetranslationgate.com,	sabeeh.mohamed@thetranslationgate.com , maged.abdelmoniem@thetranslationgate.com");
		}

		$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("Operational Report");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
    <body>
	<p>Good Morning all,</p>
        <p>Hope you are doing well and safe.</p>
	<p>These are the daily reports for ' . $brandName . ':</p>
   	<p>1-	Operational report by Customers.</p>
        <p>2-	Operational report by PM.</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
		$this->email->clear(TRUE);
	}

	// new
	public function checkIfUserIsManager($user_id)
	{
		$data = False;
		$emp_id = $this->db->get_where('users', array('id' => $user_id))->row()->employees_id;
		$rows = $this->db->get_where('employees', array('manager' => $emp_id))->num_rows();
		if ($rows > 0) {
			$data = True;
		}

		return $data;
	}
	// send new password for users
	public function sendUsersNewPassword($user_id)
	{
		$user = $this->db->get_where('users', array('id' => $user_id))->row();
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		$this->email->from("erp@aixnexus.com");


		$this->email->to("$user->email");


		//$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("ERP Account");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
        <body>
	<p>Good Morning ' . $user->user_name . ' ,</p>
        <p>Hope you are doing well and safe.</p>
	<p>Below is your new account information on Falaq:</p>
   	<p>Email: ' . $user->email . '</p>
        <p>Password: ' . base64_decode($user->password) . '</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
		$this->email->clear(TRUE);
	}

	public function sendNewPasswordAccountsDetails($user_id)
	{
		$user = $this->db->get_where('users', array('id' => $user_id))->row();
		$userAccounts = $this->db->get_where('users', array('employees_id' => $user->employees_id))->result();
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		$this->email->from("erp@aixnexus.com");


		$this->email->to("$user->email");


		$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("ERP Accounts");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
        <body>
	<p>Hi ' . $user->user_name . ' ,</p>        
	<p>Below is your new accounts information on Falaq:</p>';
		foreach ($userAccounts as $val) {
			$message .= '<p>Email: ' . $val->email . '</p>
            <p>Password: ' . base64_decode($val->password) . '</p><hr/>';
		}

		$message .= '<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
		$this->email->clear(TRUE);
	}

	public function AllUsersLogger($permission, $limit, $offset, $filter)
	{
		if ($permission->view == 1) {
			$data = $this->db->query("SELECT * FROM `logger` WHERE " . $filter . " Order By id DESC LIMIT $limit OFFSET $offset ");
		}
		return $data;
	}

	public function AllUsersLoggerCount($filter)
	{

		$data = $this->db->query("SELECT count(id) as count FROM `logger` WHERE " . $filter . " Order By id DESC")->row()->count;

		return $data;
	}

	public function SelectAllUsers($id)
	{

		$users = $this->db->get('users')->result();
		$data = "";
		foreach ($users as $user) {
			if ($user->id == $id) {
				$data .= "<option value='" . $user->id . "' selected='selected'>" . $user->user_name . "<span class='font-size-xs text-danger'>( " . self::getBrand($user->brand) . ")</span></option>";
			} else {
				$data .= "<option value='" . $user->id . "'>" . $user->user_name . "( " . self::getBrand($user->brand) . ")</option>";
			}
		}
		return $data;
	}

	public function addToLoggerRestore($table_name = "", $screen = "", $transaction_id_name = "", $transaction_id = "", $parent = "", $parent_id = "", $created_by = "")
	{
		//Table Structure ...
		$table_structure = $this->db->query(" SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='falaq' AND `TABLE_NAME`='$table_name' ")->result();
		$key = array();
		$count = 0;
		foreach ($table_structure as $column) {
			array_push($key, $column->COLUMN_NAME);
		}
		//Get Data ...
		$data = $this->db->get_where($table_name, array($transaction_id_name => $transaction_id))->result();
		foreach ($data as $data) {
			$data_count = 0;
			$sets = "";
			foreach ($key as $value) {
				if ($data_count == 0) {
					$sets = $value . " = '" . $data->$value . "'";
				} else {
					$sets .= ", " . $value . " = '" . $data->$value . "'";
				}
				$data_count++;
			}
			$logger['screen'] = $screen;
			$logger['data'] = "UPDATE $table_name SET $sets WHERE $transaction_id_name = $transaction_id; DELETE FROM $table_name  WHERE $transaction_id_name = $transaction_id;";
			$logger['table_name'] = $table_name;
			$logger['transaction_id_name'] = $transaction_id_name;
			$logger['transaction_id'] = $transaction_id;
			$logger['type'] = 5;
			$logger['parent'] = $parent;
			$logger['parent_id'] = $parent_id;
			$logger['created_by'] = $created_by;
			$logger['created_at'] = date("Y-m-d H:i:s");
			$this->db->insert('logger', $logger);
		}
	}

	public function selectMultiServices($id = "")
	{
		$service = $this->db->get('services')->result();
		$data = "";
		$arr_id = explode(",", $id);
		foreach ($service as $service) {
			if (in_array($service->id, $arr_id)) {
				$data .= "<option value='" . $service->id . "' selected='selected'>" . $service->name . "</option>";
			} else {
				$data .= "<option value='" . $service->id . "'>" . $service->name . "</option>";
			}
		}
		return $data;
	}

	public function selectMultiDTPApplication($id = "")
	{
		$application = $this->db->get('dtp_application')->result();
		$data = "";
		$arr_id = explode(",", $id);
		foreach ($application as $application) {
			if (in_array($application->id, $arr_id)) {
				$data .= "<option value='" . $application->id . "' selected='selected'>" . $application->name . "</option>";
			} else {
				$data .= "<option value='" . $application->id . "'>" . $application->name . "</option>";
			}
		}
		return $data;
	}

	public function getMultiFields($id)
	{
		$data = "";
		$arr_id = explode(",", $id);
		foreach ($arr_id as $row) {
			$field = $this->db->get_where('fields', array('id' => $row))->row();
			if ($field) {
				$data .= $field->name . ", ";
			}
		}
		$data = rtrim($data, ', ');
		if (isset($data)) {
			return $data;
		} else {
			return '';
		}
	}

	public function getMultiServices($id)
	{
		$service = $this->db->get('services')->result();
		$data = "";
		$arr_id = explode(",", $id);
		foreach ($arr_id as $row) {
			$service = $this->db->get_where('services', array('id' => $row))->row();
			if ($service) {
				$data .= $service->name . ",";
			}
		}
		$data = rtrim($data, ', ');
		return $data;
	}

	public function getMultiDTPApplication($id)
	{
		$application = $this->db->get('dtp_application')->result();
		$data = "";
		$arr_id = explode(",", $id);
		foreach ($arr_id as $row) {
			$application = $this->db->get_where('dtp_application', array('id' => $row))->row();
			if ($application) {
				$data .= $application->name . ",";
			}
		}
		$data = rtrim($data, ', ');
		return $data;
	}

	public function getRadioData($answer, $type = '')
	{

		$data = "";
		if ($answer == '1') {
			$data = 'YES';
		} elseif ($answer == '0') {
			$data = 'NO';
		}
		if ($type && $answer == '1') {
			$data = $type;
		} elseif ($type && $answer == '0') {
			$data = 'NON ' . $type;
		}
		return $data;
	}

	public function getMasterUserBrands($master_user)
	{
		$user = $this->db->get_where('master_user', array('id' => $master_user, 'status' => '1'))->row();
		$data = $this->db->get_where('users', array('employees_id' => $this->session->userdata('emp_id'), 'master_user_id' => $master_user, 'status' => '1'))->result();
		return $data;
	}

	public function getBrandImage($brand)
	{
		if ($brand == 1)
			$data = "logo_ar.png";
		elseif ($brand == 2)
			$data = "localizera_logo.png";
		elseif ($brand == 3)
			$data = "europe.png";
		elseif ($brand == 11)
			$data = "columbus_logo.jpg";

		return $data;
	}

	// send Master password for users
	public function sendMasterUsersNewPassword($user_id)
	{

		$user = $this->db->get_where('master_user', array('id' => $user_id, 'status' => '1'))->row();
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
			'smtp_port' => 25,
			'smtp_user' => 'erp@aixnexus.com',
			'smtp_pass' => 'EXoYlsum6Do@',
			'charset' => 'utf-8',
			'validate' => TRUE,
			'wordwrap' => TRUE,
		);
		$this->load->library('email', $config);

		$this->email->set_newline("\r\n");

		$this->email->from("erp@aixnexus.com");


		$this->email->to("$user->email");

		//$this->email->cc("dev@thetranslationgate.com");
		$this->email->subject("Falaq Account");
		$message = '<!DOCTYPE ><html dir=ltr>
	<head>
	</head>
        <body>
	<p>Hi ' . $user->user_name . ' ,</p>        
	<p>Please find below your login credentials for your Falaq account</p>	
        <p><b>Link : </b><a href="' . base_url() . '">' . base_url() . '</a></p>
   	<p><b>Email : </b>' . $user->email . '</p>
        <p><b>Password : </b>' . base64_decode($user->password) . '</p>
	<p>Thank You!</p>
	</body>
	</html>';
		$this->email->message($message);
		$this->email->set_header('Reply-To', "dev@thetranslationgate.com");
		$this->email->set_mailtype('html');
		$this->email->send();
		$this->email->clear(TRUE);
	}

	public function checkIfUserIsEmployeeManager($emp_id)
	{
		$data = False;
		$manager_id = $this->db->get_where('employees', array('id' => $emp_id))->row()->manager;
		if ($manager_id == $this->emp_id) {
			$data = True;
		}
		return $data;
	}

	public function AllOffices($filter)
	{

		$data = $this->db->query(" SELECT * FROM `ttg_branch` WHERE " . $filter . "  ORDER BY id ASC , id DESC ");
		return $data;
	}

	public function AllOfficesPages($limit, $offset, $brand)
	{
		$data = $this->db->query("SELECT * FROM `ttg_branch`  where brand = " . $brand . " ORDER BY id ASC , id DESC LIMIT $limit OFFSET $offset ");
		return $data;
	}

	public function getUserEmployees2Level($emp_id)
	{
		$idsArray = array();
		$firstIDs = $this->db->query("SELECT id FROM `employees` WHERE manager = " . $emp_id)->result();
		foreach ($firstIDs as $row) {
			//  array_push($idsArray, $row->id);                
			$secondIDs =  $this->db->query("SELECT id FROM `employees` WHERE manager = " . $row->id)->result();
			foreach ($secondIDs as $row2)
				array_push($idsArray, $row2->id);
		}

		if (!empty($idsArray)) {
			$empIds = implode(" , ", $idsArray);
			return $empIds;
		} else
			return false;
	}
}
