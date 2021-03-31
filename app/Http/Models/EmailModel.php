<?php

namespace App\Http\Models;

use DB;
use Mail;
use Session;
use Illuminate\Database\Eloquent\Model;

class EmailModel extends Model {
    public function saveEmail($details) {
        //$email_to=$details['email_to'];
       // Mail::to($email_to)->send(new \App\Mail\mail($details));
        //dd('Mail Send Successfully');
        DB::table("email_notification")->insert($details);
        return 1;
    }


}

?>
