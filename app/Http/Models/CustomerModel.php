<?php

namespace App\Http\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'cmpny_name', 'cmpny_has_agreement','cmpny_tier','cmpny_pay_terms','cmpny_del_req','cmpny_status','cmpny_','cmpny_','cmpny_',
        'cmpny_id','cnct_name','cnct_title','cnct_did_no','cnct_mob_no','cnct_board_no','cnct_email_prmy',
        'cnct_email_sndry','cnct_skype','cnct_linkedin','cnct_hiremode','cmpny_type_id','cnct_address','cnct_location','cnct_region','cnct_country',
        'cnct_web','cnct_domain','cnct_domain_id','cnct_technology','cnct_owned','cmpgrp_name',
        'srvc_id','srvc_cat','cnct_priority','cnct_parent','cnct_mode','cnct_status','cnct_created',
        'cnct_last_contacted','ccstg_id','cnct_w_location',
    ];
}

?>