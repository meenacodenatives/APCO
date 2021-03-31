<?php
//Controller for handling Password Reset 
//Created by codenatives
//Created date - 27-01-2021
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\PasswordResetModel;
use App\Http\Models\CronModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


class PasswordResetController extends Controller
{
        public function __construct() {
        }
        public function getUserPwd(Request $request)
        {
          $pwd_model = new PasswordResetModel();
          $secret=Crypt::encryptString($_POST['data']['email']);
          $secret1=substr($secret,0,25);
          $param = array(
            'secret_key'=>$secret1,
            'email'=>$_POST['data']['email']
            );
          $res = $pwd_model->getforgotPwd($param);
          return response()->json(array('status' => $res), 200);
        }
        public function changePwd(Request $request)
        {
          $pwd_model = new PasswordResetModel();
          $param = array(
            'secret_key'=>$_POST['data']['secret_key'],
            'password'=>sha1($_POST['data']['password'])
            );
            $res = $pwd_model->updatePwd($param);
            return response()->json(array('status' => $res), 200);

        }
        public function getSecretKey($secretKey)
        {
         return \View::make('change-password')->with(["data" => $secretKey]);
        }
        
  
}
