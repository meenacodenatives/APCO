<?php

namespace App\Http\Controllers;

use App\Http\Models\CustomerModel;
use App\Http\Models\EmployeeModel;

use Illuminate\Http\Request;
use Session;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getCustomer(EmployeeModel $EmployeeModel)
    {
        //
        $type='Add';
        $customer='';
        $state= app('App\Http\Controllers\CountryController')->getStates();
        $status =$EmployeeModel->getLookup('user_status');
        $company_type =$EmployeeModel->getLookup('customer_company_type');
        $choice =$EmployeeModel->getLookup('customer_choice');
        $region = array();
        $location = array();
        return view('add-customer', compact('type','company_type','choice','status','customer','state','region','location'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCustomer(Request $request,CustomerModel $customer)
    {
        //
       
        $customer_choice=$_POST['data']['customer_choice'];
        $is_product=($customer_choice=='Product') ? "Yes" : "No";
        $is_service=($customer_choice=='Service') ? "Yes" : "No";
        $param = array(
            'customer_client_name'=>$_POST['data']['customer_name'],
            'customer_type'=>$_POST['data']['company_type'],
            'customer_id'=>$_POST['data']['customer_id'],
            'customer_board_no'=> $_POST['data']['board_no'],
            'customer_direct_no'=> $_POST['data']['customer_direct_no'],
            'customer_contact_name'=>$_POST['data']['contact_name'],
            'customer_gst_number'=>$_POST['data']['customer_gst_number'],
            'customer_status'=>$_POST['data']['customer_status'],
            'customer_state'=>!empty($_POST['data']['customer_state']) ?$_POST['data']['customer_state'] : NULL,
            'is_product'=> $is_product,
            'is_service'=> $is_service,
            'customer_region'=>!empty($_POST['data']['customer_region']) ?$_POST['data']['customer_region'] : NULL,
            'customer_location'=>!empty($_POST['data']['customer_location']) ?$_POST['data']['customer_location'] : NULL,
            'customer_address'=> $_POST['data']['customer_address'],
            'customer_email_secondary'=>$_POST['data']['customer_email_secondary'],
            'customer_mob_no'=> $_POST['data']['customer_mobile_no'],
            'customer_web'=> $_POST['data']['contact_web'],
            'customer_email_primary'=> $_POST['data']['customer_email_primary'],
            'customer_mode'=> $_POST['data']['customer_mode'],
            'is_active'=>true
            );
            DB::enableQueryLog();
        if($_POST['data']['id']!=0)
        {
            $param['customer_modified'] = Session::get('user-id');
            $param['updated_at'] = date('Y-m-d H:i:s');
            CustomerModel::whereId($_POST['data']['id'])->update($param);
            $result=1;
        }
        else
        {
            $param['customer_created'] = Session::get('user-id');
            $param['created_date'] = date('Y-m-d H:i:s');
            CustomerModel::create($param);
            $result=1;
        }
        return response()->json(array('status' => $result), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function showCustomer(CustomerModel $customer,EmployeeModel $EmployeeModel)
    {
        //
        $allCustomers=DB::table('customer')->select('*')
            ->get()->sortByDesc("id");
                          //  $query = DB::getQueryLog();
                    //   $query = end($query);
                    //   print_r($updateExist);
                    // echo "cc=".$updateExist; 
                    // exit;
        $status =$EmployeeModel->getLookup('user_status');
        //return \View::make('showCustomer')->with(["allCustomers" => $res]);
        return view('showCustomer', compact('allCustomers','status'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function viewSingleCustomer($id,CustomerModel $customer,EmployeeModel $EmployeeModel)
    {
        //
        $type='Edit';
        $de_id=base64_decode($id);
        $customer = CustomerModel::findOrFail($de_id);
        $status =app('App\Http\Models\EmployeeModel')->getLookup('user_status');
        $company_type =$EmployeeModel->getLookup('customer_company_type');
        $choice =$EmployeeModel->getLookup('customer_choice');
        $rowStateID=$customer->customer_state ;
        $rowLocationID=$customer->customer_region;
        $state = app('App\Http\Controllers\CountryController')->getStates();
        $region =app('App\Http\Controllers\CountryController')->getRegionFromStates($rowStateID,'edit');
        $location =app('App\Http\Controllers\CountryController')->getLocationFromRegion($rowLocationID,'edit');
        return view('add-customer', compact('choice','company_type','type','status','customer','state','region','location'));

    //    return \View::make('add-customer')->with(["data" => $res]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerModel $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerModel $customer)
    {
        //
        $Customer = CustomerModel::findOrFail($_POST['data']['id']);
        $Customer->delete();
        $result=1;
        return response()->json(array('status' => $result), 200);
    }
}
