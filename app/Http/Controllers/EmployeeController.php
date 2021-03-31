<?php

//Controller for handling employee crud and other actions
//Handling employee groups
//Created by : Codenatives
//Created date : 2020-12-10

namespace App\Http\Controllers;

use App\Http\Models\EmployeeModel;
use Illuminate\Http\Request;
use Session;
use App\Http\Models\CronModel;

class Employeecontroller extends Controller {

    public function __construct() {
        
    }

    public function showEmployees(Request $request) {
        $employee_model = new EmployeeModel();
        $res['employees'] = $employee_model->getEmployees();
        return \View::make('employees')->with(["data" => $res]);
    }

    public function addEmployee(Request $request) {
        $employee_model = new EmployeeModel();

        $link = $_SERVER["REQUEST_URI"];
        $link_array = explode('/', $link);
        $page = end($link_array);
        $type = 'add';
        $res['employee'] = array();
        if ($page != 'add-employee') { //edit employee
            $type = 'edit';
            $res['employee'] = $employee_model->getSingleEmployee($page);
        }


        $res['type'] = $type;
        $res['gender'] = $employee_model->getLookup('user_gender');
        $res['category'] = $employee_model->getLookup('user_category');
        $res['status'] = $employee_model->getLookup('user_status');
        $res['country'] = $employee_model->getCountry();
        return \View::make('add-employee')->with(["data" => $res]);
    }

    public function getCountryLocation(Request $request) {
        $employee_model = new EmployeeModel();
        if ($_POST['data']['country'] > 0) {
            $res['location'] = $employee_model->getCountryLocation($_POST['data']['country']);
            if (count($res['location']) > 0) {
                $location = '<option value="">Select</option>';
                foreach ($res['location'] as $loc) {
                    $location .= '<option value="' . $loc->id . '">' . $loc->name . '</option>';
                }
                echo $location;
            }
            echo 0;
        }
        echo 0;
    }

    public function saveProfile(Request $request) {
        $employee_model = new EmployeeModel();
        if ($_POST['data']['country'] > 0) {
            $param = array(
                'firstname' => $_POST['data']['fname'],
                'lastname' => $_POST['data']['lname'],
                'category' => $_POST['data']['category'],
                'phone' => $_POST['data']['phone'],
                'country' => $_POST['data']['country'],
                'location' => $_POST['data']['location'],
                'dob' => $_POST['data']['dob'],
                'joining_date' => $_POST['data']['doj'],
                'gender' => $_POST['data']['gender'],
                'address' => $_POST['data']['address'],
                'status' => $_POST['data']['status'],
                'is_active' => true
            );
            if ($_POST['data']['dor'] != '') {
                $param['relieve_date'] = $_POST['data']['dor'];
                $param['relieve_reason'] = $_POST['data']['relieve'];
            }
            if ($_POST['data']['password'] != '') {
                $param['password'] = sha1($_POST['data']['password']);
            }
            if ($_POST['data']['id'] == '0') {
                $param['email'] = $_POST['data']['email'];
                $param['created_by'] = Session::get('user-id');
                $param['created_date'] = date('Y-m-d H:i:s');
            } else {
                $param['modified_by'] = Session::get('user-id');
                $param['modified_date'] = date('Y-m-d H:i:s');
            }
            $result = $employee_model->saveProfile($param, $_POST['data']['id']);
            return response()->json(array('status' => $result), 200);
        }
        return response()->json(array('status' => 0), 200);
    }

    public function deleteEmployee(Request $request) {
        $employee_model = new EmployeeModel();
        $res = $employee_model->deleteEmployee($_POST['data']['id']);
        return response()->json(array('status' => $res), 200);
    }

}
