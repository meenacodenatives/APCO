<?php
//Controller for handling Email
//Created by codenatives
//Created date - 20-01-2021
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Http\Models\EmailModel;


class EmailController extends Controller
{

    public function __construct() {
    }

    public function createEmail($emailInput)
    {
        $email_model = new EmailModel();
        $result = $email_model->saveEmail($emailInput);
    return response()->json(array('status' => $result), 200);
    }
        
}
