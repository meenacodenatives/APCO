<?php

namespace App\Http\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = 'customer';

    protected $fillable = [
        'customer_id', 'customer_client_name','customer_contact_name','customer_direct_no','customer_mob_no','customer_board_no','customer_email_primary','customer_email_secondary','customer_type',
        'customer_address','customer_gst_number','customer_location','customer_region','customer_state','customer_web','customer_mode',
        'customer_status','customer_created','is_product','is_service','customer_modified','updated_at','created_at'
    ];
}

?>