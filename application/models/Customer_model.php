<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Auth
 *
 * Author:  MOHAMED EL-SHEHABY
 *
 */

class Customer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*public function AllCustomers($permission,$user,$brand)
       {
           if($permission->view == 1){
               $data = $this->db->order_by('id','desc')->get_where('customer',array('brand' => $brand));
           }elseif($permission->view == 2){
               $data = $this->db->order_by('id','desc')->get_where('customer',array('created_by'=>$user,'brand' => $brand));
           }
           return $data;
       }*/
    public function AllCustomers($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `customer` WHERE brand = '$brand' AND " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `customer` WHERE brand = '$brand' AND created_by ='$user' AND " . $filter . " ORDER BY id DESC ");
        }
        return $data;
    }
    //hagar  
    public function AllCustomersPages($permission, $user, $brand, $limit, $offset, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT * FROM `customer` WHERE brand = '$brand'  AND " . $filter . " ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT * FROM `customer` WHERE brand = '$brand' AND created_by ='$user'  AND " . $filter . " ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }
    public function selectCustomerCreatedBy($id, $brand = "")
    {
        $createdBy = $this->db->order_by('name', 'ASC')->get_where('customer', array('brand' => $brand))->result();
        $data = "";
        foreach ($createdBy as $createdBy) {
            if ($createdBy->id == $id) {
                $data .= "<option value='" . $createdBy->created_by . "' selected='selected'>" . $this->admin_model->getAdmin($createdBy->created_by) . "</option>";
            } else {
                $data .= "<option value='" . $createdBy->created_by . "'>" . $this->admin_model->getAdmin($createdBy->created_by) . "</option>";
            }
        }
        return $data;
    }

    public function customerById($id)
    {
        $data = $this->db->get_where('customer', array('id' => $id));
        return $data->row();
    }

    public function allCustomerLeads($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query("  SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c WHERE " . $filter . " HAVING CustomerStatus = 1 ORDER BY id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c WHERE created_by = '$user' AND " . $filter . " HAVING CustomerStatus = 1 ORDER BY id desc ");
        }
        return $data;
    }

    public function allCustomerLeadsPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 1 ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c WHERE created_by = '$user' HAVING CustomerStatus = 1 ORDER BY id DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    //    public function allCustomerBranches($permission,$user,$brand)
    // {
    // 	if($permission->view == 1){
    // 		$data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 2 ORDER BY id desc ");
    // 	}elseif($permission->view == 2){
    // 		$data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$user' AND customer_sam.lead = c.id) AS total,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 2 AND total = 1 ORDER BY id desc ");
    // 	}
    // 	return $data;
    // }

    public function allCustomerBranches($permission, $user, $brand, $filter)
    {

        if ($permission->view == 1) {
            $data = $this->db->query("  SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c WHERE " . $filter . " HAVING CustomerStatus = 2 ORDER BY id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$user' AND customer_sam.lead = c.id) AS total,c.* FROM `customer_leads` AS c WHERE " . $filter . " HAVING CustomerStatus = 2 AND total = 1 ORDER BY id desc ");
        }
        return $data;
    }

    public function allCustomerBranchesPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 2 ORDER BY id desc LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$user' AND customer_sam.lead = c.id) AS total,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 2 AND total = 1 ORDER BY id desc LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function allCustomerPM($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT(SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c WHERE " . $filter . " HAVING CustomerStatus = 2 ORDER BY id desc ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT(SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$user' AND customer_pm.lead = c.id) AS total,c.* FROM `customer_leads` AS c WHERE " . $filter . " HAVING CustomerStatus = 2 AND total = 1 ORDER BY id desc ");
        }
        return $data;
    }

    public function allCustomerPmPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query(" SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 2 ORDER BY id desc LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT (SELECT status FROM customer WHERE c.customer = customer.id AND customer.brand = '$brand') AS CustomerStatus,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$user' AND customer_pm.lead = c.id) AS total,c.* FROM `customer_leads` AS c HAVING CustomerStatus = 2 AND total = 1 ORDER BY id desc LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    /*public function allProductLines($permission,$user,$brand)
     {
         if($permission->view == 1){
             $data = $this->db->order_by('id','desc')->get_where('customer_product_line',array('brand'=>$brand));
         }elseif($permission->view == 2){
             $data = $this->db->order_by('id','desc')->get_where('customer_product_line',array('created_by'=>$user,'brand'=>$brand));
         }
         return $data;
     }*/
    public function allProductLines($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM customer_product_line WHERE brand = '$brand' AND " . $filter . " ORDER BY id DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM customer_product_line WHERE brand = '$brand' AND created_by = '$user' AND " . $filter . " ORDER BY id DESC ");
        }
        return $data;
    }
    public function allProductLinesPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT * FROM customer_product_line WHERE brand = '$brand' ORDER BY id DESC LIMIT $limit OFFSET $offset");
        } elseif ($permission->view == 2) {
            $data = $this->db->query("SELECT * FROM customer_product_line WHERE brand = '$brand' AND created_by = '$user' ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
        return $data;
    }

    public function customerContacts($permission, $user, $lead)
    {
        if ($permission->view == 1) {
            $data = $this->db->order_by('id', 'desc')->get_where('customer_contacts', array('lead' => $lead));
        } elseif ($permission->view == 2) {
            $data = $this->db->order_by('id', 'desc')->get_where('customer_contacts', array('created_by' => $user, 'lead' => $lead));
        }
        return $data;
    }

    public function customerPortal($permission, $user, $customer)
    {
        if ($permission->view == 1) {
            $data = $this->db->order_by('id', 'desc')->get_where('customer_portal', array('customer' => $customer));
        } elseif ($permission->view == 2) {
            $data = $this->db->order_by('id', 'desc')->get_where('customer_portal', array('created_by' => $user, 'customer' => $customer));
        }
        return $data;
    }

    public function SelectType($id = "")
    {
        $type = $this->db->get('customer_type')->result();
        $data = "";
        foreach ($type as $type) {
            if ($type->id == $id) {
                $data .= "<option value='" . $type->id . "' selected='selected'>" . $type->name . "</option>";
            } else {
                $data .= "<option value='" . $type->id . "'>" . $type->name . "</option>";
            }
        }
        return $data;
    }

    public function getType($type)
    {
        $result = $this->db->get_where('customer_type', array('id' => $type))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function SelectStatus($id = "")
    {
        $status = $this->db->get('customer_status')->result();
        $data = "";
        foreach ($status as $status) {
            if ($status->id == $id) {
                $data .= "<option value='" . $status->id . "' selected='selected'>" . $status->name . "</option>";
            } else {
                $data .= "<option value='" . $status->id . "'>" . $status->name . "</option>";
            }
        }
        return $data;
    }

    public function getStatus($status)
    {
        $result = $this->db->get_where('customer_status', array('id' => $status))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function customersSam($id = '')
    {
        $data = $this->db->get_where('customer_sam', array('lead' => $id));
        return $data;
    }

    public function customersPm($id = '')
    {
        $data = $this->db->get_where('customer_pm', array('lead' => $id));
        if ($data->num_rows() > 0) {
            return $data->row()->pm;
        } else {
            return "";
        }
    }

    public function customersPmRow($id = '')
    {
        $data = $this->db->get_where('customer_pm', array('lead' => $id));
        return $data;
    }

    public function selectCustomer($id = "")
    {
        $customer = $this->db->order_by('name', 'ASC')->get_where('customer')->result();
        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }
        return $data;
    }

    public function selectCustomerLead($id = "", $brand = "")
    {
        $customer = $this->db->order_by('name', 'ASC')->get_where('customer', array('status' => 1, 'brand' => $brand))->result();
        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }
        return $data;
    }

    public function selectCustomerExisting($id = "", $brand = "")
    {
        $customer = $this->db->order_by('name', 'ASC')->get_where('customer', array('status' => 2, 'brand' => $brand))->result();
        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }
        return $data;
    }

    public function selectCustomerBySam($id = "", $sam = "", $permission = "", $brand = "")
    {
        // if($permission->view == 1){
        // 	$customer = $this->db->query("SELECT c.id,c.name FROM `customer` AS c WHERE c.brand = '$brand' ORDER BY name ASC ")->result();
        // }elseif($permission->view == 2){
        // 	$customer = $this->db->query("SELECT c.id,c.name,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$sam' AND customer_sam.customer = c.id) AS total FROM `customer` AS c WHERE brand = '$brand' HAVING total >= '1' ORDER BY name ASC ")->result();
        // }

        if ($permission->view == 1) {
            $customer = $this->db->query("SELECT DISTINCT c.id,c.name FROM customer_sam AS s LEFT OUTER JOIN customer AS c ON c.id = s.customer WHERE c.id > 0 AND c.brand = '$brand' ORDER BY name ASC ")->result();
        } elseif ($permission->view == 2) {
            $customer = $this->db->query("SELECT DISTINCT c.id,c.name,s.sam FROM customer_sam AS s LEFT OUTER JOIN customer AS c ON c.id = s.customer WHERE c.id > 0 AND s.sam = '$sam' AND c.brand = '$brand' ORDER BY c.name ASC ")->result();
        }

        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }

        return $data;
    }

    public function selectCustomerByPm($id = "", $pm = "", $permission = "", $brand = "")
    {
        if ($permission->view == 1) {
            $customer = $this->db->query("SELECT c.id,c.name,c.brand FROM `customer` AS c WHERE brand = '$brand' AND status='2' ORDER BY name ASC ")->result();
        } elseif ($permission->view == 2) {
            $customer = $this->db->query("SELECT c.id,c.name,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$pm' AND customer_pm.customer = c.id) AS total,c.brand FROM `customer` AS c WHERE  brand = '$brand' AND status='2' HAVING total > '0' ORDER BY name ASC ")->result();
        }

        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }
        return $data;
    }

    public function selectExistingCustomerBySam($id = "", $sam = "", $permission = "", $brand = "")
    {
        if ($permission->view == 1) {
            $customer = $this->db->query("SELECT c.id,c.name,c.status FROM `customer` AS c WHERE c.brand = '$brand' AND status = '2' ORDER BY name ASC ")->result();
        } elseif ($permission->view == 2) {
            $customer = $this->db->query("SELECT c.id,c.name,c.status,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$sam' AND customer_sam.customer = c.id) AS total FROM `customer` AS c WHERE brand = '$brand' AND status = '2' HAVING total >= '1' ORDER BY name ASC ")->result();
        }

        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }
        return $data;
    }

    public function selectCustomerBranches($id = "", $brand = "")
    {
        $customer = $this->db->query(" SELECT * FROM `customer` WHERE brand = '$brand' AND status = '2' ORDER BY name ASC ")->result();

        $data = "";
        foreach ($customer as $customer) {
            if ($customer->id == $id) {
                $data .= "<option value='" . $customer->id . "' selected='selected'>" . $customer->name . "</option>";
            } else {
                $data .= "<option value='" . $customer->id . "'>" . $customer->name . "</option>";
            }
        }
        return $data;
    }

    public function getCustomer($id)
    {
        $result = $this->db->get_where('customer', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function selectSamCustomer($id, $brand)
    {
        $sql = "SELECT id,user_name,(SELECT count(*) FROM `customer_sam` WHERE sam = users.id AND `lead` = '$id' ) AS total FROM `users` WHERE (role = '3' OR role = '12' OR role = '20' OR role = '10' OR role = '29' OR role = '40') AND brand = '$brand' HAVING total = '0' ";

        $sam = $this->db->query($sql)->result();
        $data = "";
        foreach ($sam as $sam) {
            if ($sam->id == $id) {
                $data .= "<option value='" . $sam->id . "' selected='selected'>" . $sam->user_name . "</option>";
            } else {
                $data .= "<option value='" . $sam->id . "'>" . $sam->user_name . "</option>";
            }
        }
        return $data;
    }

    public function selectAllSam($id, $brand)
    {
        $sam = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '3' OR role = '12' OR role = '10' OR role = '29' OR role = '40') AND brand = '$brand' ")->result();
        $data = "";
        foreach ($sam as $sam) {
            if ($sam->id == $id) {
                $data .= "<option value='" . $sam->id . "' selected='selected'>" . $sam->user_name . "</option>";
            } else {
                $data .= "<option value='" . $sam->id . "'>" . $sam->user_name . "</option>";
            }
        }
        return $data;
    }


    public function selectSamEmployeeId($id = "", $brand = "")
    {
        $sam = $this->db->query(" SELECT * FROM users WHERE (role = '3' OR role = '12' OR role = '10' OR role = '40') AND brand = '$this->brand' AND status = '1' ")->result();
        foreach ($sam as $sam) {
            if ($sam->id == $id) {
                $data .= "<option value='" . $sam->employees_id . "' selected='selected'>" . $sam->user_name . "</option>";
            } else {
                $data .= "<option value='" . $sam->employees_id . "'>" . $sam->user_name . "</option>";
            }
        }
        return $data;
    }

    public function selectAllSamMarketing($id, $brand)
    {
        $sam = $this->db->query("SELECT id,user_name FROM `users` WHERE (role = '3' OR role = '12' OR role = '10' OR role = '22' OR role = '30' OR role = '40') AND brand = '$brand' AND status ='1' ORDER BY user_name ASC ")->result();
        $data = "";
        foreach ($sam as $sam) {
            if ($sam->id == $id) {
                $data .= "<option value='" . $sam->id . "' selected='selected'>" . $sam->user_name . "</option>";
            } else {
                $data .= "<option value='" . $sam->id . "'>" . $sam->user_name . "</option>";
            }
        }
        return $data;
    }

    public function selectPmCustomer($id, $brand)
    {
        $pm = $this->db->query("SELECT `id`,`user_name`,(SELECT count(*) FROM `customer_pm` WHERE `pm` = users.id AND `lead` = '$id' ) AS total FROM `users` WHERE (role = '2' or role = '29' OR role = '16' OR role = '42' OR role = '43' OR role = '45' OR role = '47' OR role = '52') AND brand = '$brand' HAVING total = '0' ")->result();
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

    public function customerLeadStatus($id)
    {
        $row = $this->db->get_where('customer', array('id' => $id))->row();
        return $row->status;
    }

    public function getAllPriceList($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `customer_price_list` AS l WHERE " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$user' AND customer_sam.customer = l.customer) AS total FROM `customer_price_list` AS l WHERE " . $filter . " HAVING brand = '$brand' AND total > 0 ORDER BY ID DESC ");
        }
        return $data;
    }

    public function getAllPriceListPages($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `customer_price_list` AS l HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand,(SELECT COUNT(*) FROM `customer_sam` WHERE sam = '$user' AND customer_sam.customer = l.customer) AS total FROM `customer_price_list` AS l HAVING brand = '$brand' AND total > 0 ORDER BY ID DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function getLeadData($lead, $customer, $sam)
    {
        $row = $this->db->query(" SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                        	<th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        foreach ($row as $row) {
            if ($lead == $row->id) {
                $radio = "required";
                $checked = "checked";
            } else {
                $radio = "";
                $checked = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" value="' . $row->id . '" ' . $radio . ' ' . $checked . '></td>
                        <input type="text" name="lead_status" id="lead_status" value="' . $this->customer_model->customerLeadStatus($customer) . '" hidden="" required="">
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function leadDataPm($lead, $customer, $pm)
    {
        $row = $this->db->query(" SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        foreach ($row as $row) {
            if ($lead == $row->id) {
                $radio = "required";
                $checked = "checked";
            } else {
                $radio = "";
                $checked = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" onclick="getProductLineByLead()" ' . $checked . ' value="' . $row->id . '" ' . $radio . '></td>
                        <input type="text" name="lead_status" id="lead_status" value="' . $this->customer_model->customerLeadStatus($customer) . '" hidden="" required="">
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function leadDataAccounting($lead, $customer)
    {
        $row = $this->db->query(" SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        foreach ($row as $row) {
            if ($lead == $row->id) {
                $radio = "required";
                $checked = "checked";
            } else {
                $radio = "";
                $checked = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" onclick="getVirifiedPoByCustomer();clearPaymentData();" ' . $checked . ' value="' . $row->id . '" ' . $radio . '></td>
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getLeadRowData($lead)
    {
        $row = $this->db->get_where('customer_leads', array('id' => $lead))->row();
        $brand = $this->db->get_where('customer', array('id' => $row->customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <tr class="">
                        <input type="text" name="customer" id="customer" value="' . $row->customer . '" hidden="" required="">
                        <input type="text" name="lead_status" id="lead_status" value="' . $this->customer_model->customerLeadStatus($row->customer) . '" hidden="" required="">
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>
                    </tbody>
                </table>';
        echo $data;
    }

    public function leadDataPayment($lead, $customer)
    {
        $row = $this->db->query(" SELECT c.* FROM `customer_leads` AS c WHERE c.customer='$customer' ")->result();
        $brand = $this->db->get_where('customer', array('id' => $customer))->row()->brand;
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Brand</th>
                            <th>Type</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        foreach ($row as $row) {
            if ($lead == $row->id) {
                $radio = "required";
                $checked = "checked";
            } else {
                $radio = "";
                $checked = "";
            }
            $data .= '<tr class="">
                        <td><input type="radio" name="lead" id="lead" onclick="getClientInvoices();" ' . $checked . ' value="' . $row->id . '" ' . $radio . '></td>
                            <td>' . $this->admin_model->getRegion($row->region) . '</td>
                            <td>' . $this->admin_model->getCountry($row->country) . '</td>
                            <td>' . $this->admin_model->getBrand($brand) . '</td>
                            <td>' . $this->customer_model->getType($row->type) . '</td>
                        </tr>';
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getCustomerContact($lead, $contact_id)
    {
        $result = $this->db->get_where('customer_contacts', array('lead' => $lead))->result();
        $data = '<table class="table table-striped table-hover table-bordered" style="overflow:scroll;">
                    <thead>
                        <tr>
                            <th>Choose</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Job Title</th>
                            <th>Location</th>
                            <th>Skype Account</th>
                        </tr>
                    </thead>
        
                    <tbody>';
        $x = 1;
        foreach ($result as $row) {
            if ($x == 1) {
                $radio = "required";
            } else {
                $radio = "";
            }
            if ($contact_id == $row->id) {
                $checked = 'checked="checked"';
            } else {
                $checked = "";
            }
            $data .= '<tr class="">
                            <td><input type="radio" name="contact_id" value="' . $row->id . '" ' . $radio . ' ' . $checked . '></td>
                            <td>' . $row->name . '</td>
                            <td>' . $row->email . '</td>
                            <td>' . $row->phone . '</td>
                            <td>' . $row->job_title . '</td>
                            <td>' . $row->location . '</td>
                            <td>' . $row->skype_account . '</td>
                        </tr>';
            $x++;
        }
        $data .= '</tbody></table>';
        echo $data;
    }

    public function getLeadDataByCustomer($lead)
    {
        $row = $this->db->get_where('customer_leads', array('id' => $lead))->row();
        return $row;
    }

    public function selectProductLine($id = "", $brand = "")
    {
        $customer_product_line = $this->db->order_by('name', 'ASC')->get_where('customer_product_line', array('brand' => $brand))->result();
        $data = "";
        foreach ($customer_product_line as $customer_product_line) {
            if ($customer_product_line->id == $id) {
                $data .= "<option value='" . $customer_product_line->id . "' selected='selected'>" . $customer_product_line->name . "</option>";
            } else {
                $data .= "<option value='" . $customer_product_line->id . "'>" . $customer_product_line->name . "</option>";
            }
        }
        return $data;
    }

    public function getProductLine($id)
    {
        $result = $this->db->get_where('customer_product_line', array('id' => $id))->row();
        if (isset($result->name)) {
            return $result->name;
        } else {
            return '';
        }
    }

    public function getProductLineID($productLine, $brand)
    {
        $result = $this->db->get_where('customer_product_line', array('name' => $productLine, 'brand' => $brand))->row();
        if (isset($result->id)) {
            return $result->id;
        } else {
            return '';
        }
    }

    public function selectProductLineByCustomer($lead = "", $id = "")
    {
        $lines = $this->db->query(" SELECT DISTINCT product_line FROM `customer_price_list` WHERE `lead` = '$lead' ")->result();
        foreach ($lines as $lines) {
            if ($lines->product_line == $id) {
                $data .= "<option value='" . $lines->product_line . "' selected='selected'>" . $this->customer_model->getProductLine($lines->product_line) . "</option>";
            } else {
                $data .= "<option value='" . $lines->product_line . "'>" . $this->customer_model->getProductLine($lines->product_line) . "</option>";
            }
        }

        echo $data;
    }

    public function getAllPriceListPm($permission, $user, $brand, $filter)
    {
        if ($permission->view == 1) {
            echo "View All";
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `customer_price_list` AS l WHERE " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        } elseif ($permission->view == 2) {
            echo "View only Assigned";
            $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$user' AND customer_pm.customer = l.customer) AS total FROM `customer_price_list` AS l WHERE " . $filter . " HAVING brand = '$brand' AND total > 0 ORDER BY ID DESC ");
        }
        return $data;
    }

    public function getAllPriceListPagesPm($permission, $user, $brand, $limit, $offset)
    {
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `customer_price_list` AS l HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset ");
        } elseif ($permission->view == 2) {
            $data = $this->db->query(" SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand,(SELECT COUNT(*) FROM `customer_pm` WHERE pm = '$user' AND customer_pm.customer = l.customer) AS total FROM `customer_price_list` AS l HAVING brand = '$brand' AND total > 0 ORDER BY ID DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function AllChatRooms($permission, $user, $brand)
    {
        $data = $this->db->order_by('id', 'desc')->get_where('website_chat', array('brand' => $brand));
        return $data;
    }

    public function chatRoomStatus($status)
    {
        if ($status == 0) {
            return "Running";
        } else if ($status == 1) {
            return "Closed";
        }
    }
    public function chatMessages($roomId)
    {
        $data = $this->db->order_by('id', 'desc')->get_where('website_chat_room', array('room' => $roomId));
        return $data;
    }

    public function samLeadsTable($rowId)
    {
        $dataHTML = "";
        $SamCustomer = $this->customer_model->customersSam($rowId);
        $permission = $this->admin_model->getScreenByPermissionByRole($this->role, 14);
        if ($SamCustomer->num_rows() == 0) {
            if ($permission->follow == 2) {
                $dataHTML .= '<a href="#myModal' . $rowId . '" data-toggle="modal" class="btn btn-success" >Assign SAM</a>';
            }
        } else {
            $dataHTML .= '<table style="border-collapse:collapse;">
        <tr><td style="border: 1px solid #ddd;">SAM Name</td>';
            if ($permission->follow == 2) {
                $dataHTML .= '<td style="border: 1px solid #ddd;"></td>
          <td style="border: 1px solid #ddd;"></td>';
            }
            $dataHTML .= '</tr>';
            $i = 0;
            $count = $SamCustomer->num_rows();
            foreach ($SamCustomer->result() as $sam) {
                $dataHTML .= '<tr>
                <td style="border: 1px solid #ddd;">' . $this->admin_model->getAdmin($sam->sam) . '</td>';
                if ($permission->follow == 2) {
                    $dataHTML .= '<td style="border: 1px solid #ddd;"><a onclick="deleteSamCustomer(' . $sam->id . ',' . $rowId . ')"> 
                <i class="fa fa-times text-danger text"></i> </a></td>';
                }
                if ($i < 1) {
                    if ($permission->follow == 2) {
                        $dataHTML .= '<td rowspan="' . $count . '" style="border: 1px solid #ddd;"><a href="#myModal' . $rowId . '" data-toggle="modal" class="btn btn-success" >Assign SAM</a></td>';
                    }
                }
                $dataHTML .= '</tr>';
                $i = $i + 1;
            }
            $dataHTML .= '</table>';
        }
        $leadData = $this->db->get_where('customer_leads', array('id' => $rowId))->row();
        $dataHTML .= '<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal' . $rowId . '" class="modal fade">
                 <div class="modal-dialog">
                     <div class="modal-content">
                         <div class="modal-header">
                             <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                             <h4 class="modal-title">Assign SAM To this Customer</h4>
                         </div>
                         <div class="modal-body">

                          <input name="lead" id="lead_' . $rowId . '" type="hidden" value="' . $rowId . '" >
                          <input name="customer" id="customer_' . $rowId . '" type="hidden" value="' . $leadData->customer . '" >
                         <div class="form-group">
                           <label for="sam">Select SAM</label>
                             <select name="sam" id="sam_' . $rowId . '" class="form-control m-b" id="sam" required >
                               <option disabled="disabled" selected="selected">Select SAM</option>
                               ' . $this->customer_model->selectSamCustomer($rowId, $this->brand) . '
                             </select>
                         </div>

                         <button class="btn btn-default" type="submit" aria-hidden="true" data-dismiss="modal" class="close" onclick="assignSamCustomer(' . $rowId . ')">Submit</button>
                       </form>
                   </div>
                 </div>
               </div>
            </div>';

        return $dataHTML;
    }

    public function getAssignedPM($lead, $pm = 0)
    {
        $row = $this->db->query(" SELECT c.*,u.user_name,u.status FROM customer_pm AS c LEFT OUTER JOIN users AS u ON c.pm = u.id WHERE `lead` = '$lead' HAVING u.status = 1 ")->result();
        $data = "<option value='' disabled='' selected='selected'>-- Select PM --</option>";
        foreach ($row as $row) {
            if ($row->pm == $pm) {
                $data .= "<option value='" . $row->pm . "' selected='selected'>" . $row->user_name . "</option>";
            } else {
                $data .= "<option value='" . $row->pm . "'>" . $row->user_name . "</option>";
            }
        }
        return $data;
    }

    public function assignSamCustomerMail($user, $lead)
    {
        $createdByMail = $this->admin_model->getUserEmail($this->user);
        $sam = $this->admin_model->getUserData($user);
        $mailTo = $sam->email;

        $leadData = $this->db->get_where('customer_leads', array('id' => $lead))->row();

        $customerData = self::customerById($leadData->customer);
        $country = $this->admin_model->getCountry($leadData->country);

        $subject = $customerData->name;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $createdByMail . "\r\n";
        $headers .= 'From: ' . $createdByMail . "\r\n" . 'Reply-To: ' . $createdByMail . "\r\n";

        $message = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
                        <title>Falaq| Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear ' . $sam->user_name . ',</p>
                       <p> You have been assigned to a new customer</p>
                       <p>By : ' . $this->admin_model->getUser($this->user) . '</p>
                       <p>Customer Name: ' . $customerData->name . ' - ' . $country . '</p>
                       <p>Thanks</p>
                    </body>
                    </html>';
        mail($mailTo, $subject, $message, $headers);
    }

    public function UnAssignSamCustomerMail($user, $lead)
    {
        $createdByMail = $this->admin_model->getUserEmail($this->user);
        $sam = $this->admin_model->getUserData($user);
        $mailTo = $sam->email;

        $leadData = $this->db->get_where('customer_leads', array('id' => $lead))->row();

        $customerData = self::customerById($leadData->customer);
        $country = $this->admin_model->getCountry($leadData->country);

        $subject = $customerData->name;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "Cc: " . $createdByMail . "\r\n";
        $headers .= 'From: ' . $createdByMail . "\r\n" . 'Reply-To: ' . $createdByMail . "\r\n";

        $message = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
                        <title>Falaq| Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear ' . $sam->user_name . ',</p>
                       <p style="color: red;font-weight: bold;"> You are no longer assigned to this customer.</p>
                       <p>By : ' . $this->admin_model->getUser($this->user) . '</p>
                       <p>Customer Name: ' . $customerData->name . ' - ' . $country . '</p>
                       <p>Thanks</p>
                    </body>
                    </html>';
        mail($mailTo, $subject, $message, $headers);
    }


    public function SelectSource($id = "")
    {
        $source = $this->db->get('source_lead')->result();
        $data = "";
        foreach ($source as $source) {
            if ($source->id == $id) {
                $data .= "<option value='" . $source->id . "' selected='selected'>" . $source->source . "</option>";
            } else {
                $data .= "<option value='" . $source->id . "'>" . $source->source . "</option>";
            }
        }
        return $data;
    }

    public function getSource($source)
    {
        $result = $this->db->get_where('source_lead', array('id' => $source))->row();
        if (isset($result->source)) {
            return $result->source;
        } else {
            return '';
        }
    }

    public function addLastUpdated($table_name, $row_id)
    {
        if ($table_name == 'customer_contacts' || $table_name == 'customer_portal') {
            $data['updated_by'] = $this->user;
            $data['update_at'] = date("Y-m-d H:i:s");
        } else {
            $data['updated_by'] = $this->user;
            $data['updated_at'] = date("Y-m-d H:i:s");
        }
        $this->db->update($table_name, $data, array('id' => $row_id));
    }

    public function getAllPriceListWaitingApproval($permission, $user, $brand, $filter)
    {
        $emp_id = $this->db->get_where('users', array('id' => $user))->row()->employees_id;
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `customer_price_list` AS l WHERE approved = 0 AND created_by IN (select id from users where employees_id IN (select id from employees where manager = $emp_id)) AND " . $filter . " HAVING brand = '$brand' ORDER BY ID DESC ");
        }
        return $data;
    }

    public function getAllPriceListWaitingApprovalPages($permission, $user, $brand, $limit, $offset)
    {
        $emp_id = $this->db->get_where('users', array('id' => $user))->row()->employees_id;
        if ($permission->view == 1) {
            $data = $this->db->query("SELECT l.*,(SELECT brand FROM customer WHERE customer.id = l.customer) AS brand FROM `customer_price_list` AS l  WHERE approved = 0 AND created_by IN (select id from users where employees_id IN (select id from employees where manager = $emp_id)) HAVING brand = '$brand' ORDER BY ID DESC LIMIT $limit OFFSET $offset ");
        }
        return $data;
    }

    public function sendApprovalPriceMail($id, $approve)
    {
        $row = $this->db->get_where('customer_price_list', array('id' => $id))->row();
        $sam = $this->db->get_where('users', array('id' => $row->created_by))->row();
        $userMail = $this->db->get_where('users', array('id' => $this->user))->row()->email;
        $mailTo = $sam->email;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $userMail . "\r\n";
        $headers .= "Cc: " . $userMail . "\r\n";
        if ($approve == 1) {
            $subject = "Price List Approved #" . $id . " - " . date("Y-m-d H:i:s");
        } else if ($approve == 2) {
            $subject = "Price List Rejected #" . $id . " - " . date("Y-m-d H:i:s");
        }
        $message = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
                        <title>Falaq| Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Dear ' . $sam->user_name . ',</p>
                       <p>Please check , Price List for customer :' . $this->customer_model->getCustomer($row->customer) . ' </p>
                       <p>Please check , Price List for customer :' . $this->customer_model->getCustomer($row->customer) . ' </p>
                       <p>Comment : ' . $row->approved_comment . '</p>
                       <p>Thanks</p>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($mailTo, $subject, $message, $headers);
    }

    public function sendNewPriceMail($id, $type)
    {
        $row = $this->db->get_where('customer_price_list', array('id' => $id))->row();
        $sam = $this->db->get_where('users', array('id' => $this->user))->row();
        $ManagerMail = $this->projects_model->getUserManagerEmail($this->user);
        $mailFrom = $sam->email;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . $mailFrom . "\r\n";
        if ($type == 1) {
            $subject = "New Price List #" . $id . " - " . date("Y-m-d H:i:s");
        } else if ($type == 2) {
            $subject = "Price List Updated  #" . $id . " - " . date("Y-m-d H:i:s");
        }
        $message = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <link rel="shortcut icon" href="' . base_url() . 'assets/images/favicon.png">
                        <title>Falaq| Site Manager</title>
                        <style>
                        body {
                            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                            font-size: 14px;
                            line-height: 1.428571429;
                            color: #333;
                        }
                        section#unseen
                        {
                            overflow: scroll;
                            width: 100%
                        }
                        </style>
                        <!--Core js-->
                    </head>

                    <body>
                    <p>Hi ,</p>
                       <p>New customer price list need your approval </p>
                       <p>created by : ' . $sam->user_name . '</p>
                       <p>Please Check  : <a href="' . base_url() . 'customer/viewPriceList?t=' . base64_encode($row->id) . '">Follow This Link</a></p>
                       <p>Thanks</p>
                    </body>
                    </html>';
        //    echo "$message"; 
        mail($ManagerMail, $subject, $message, $headers);
    }
}
