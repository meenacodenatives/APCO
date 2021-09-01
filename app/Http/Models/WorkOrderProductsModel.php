<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class WorkOrderProductsModel extends Model
{
    use HasFactory;

    protected $table = 'work_order_products';

    public $fillable = [
        'product_id',
        'quantity',
        'units',
        'price',
        'subtotal',
        'work_order_id',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
}


