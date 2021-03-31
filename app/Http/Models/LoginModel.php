<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model {

    public function checkAuthentication($param) {
        $auth = DB::select("select * from user_profile where email = '" . $param['data']['email'] . "' and password = '" . sha1($_POST['data']['password']) . "' and is_active = true");
        if (count($auth) > 0) {
            if ($auth[0]->status == 'Active') {
                return $auth; //success
            } else if ($auth[0]->status == 'Inactive') {
                return 2; //Inactive
            } else {
                return 3; //blocked
            }
        }
        return 0; //invalid credentials
    }

}

?>
