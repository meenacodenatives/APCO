<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class RFQProductsModel extends Model
{
    use HasFactory;

    protected $table = 'rfq_products';

    public $fillable = [
        'product_name',
        'product_id',
        'quantity',
        'units',
        'selling_price',
        'rfq_id',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
}


