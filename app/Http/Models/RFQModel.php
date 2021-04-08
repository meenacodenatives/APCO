<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class RFQModel extends Model
{
    use HasFactory;

    protected $table = 'rfq';

    public $fillable = [
        'customer_name',
        'contact_name',
        'email',
        'phone',
        'skype_id',
        'website',
        'address',
        'description',
        'total_pdt_price',
        'labourcharge',
        'transportcharge',
        'margin',
        'final_value',
        'proposed_value',
        'product_id',
        'discount_type',
        'discount_value',
        'parent_id',
        'amc',
        'is_child',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
}


