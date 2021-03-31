<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';

    public $fillable = [
        'category',
        'product_name',
        'product_type',
        'actual_price',
        'selling_price',
        'quantity',
        'units',
        'batch_number',
        'mfg_date',
        'expiry_date',
        'price',
        'gst',
        'product_code',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
}