<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class WorkOrderModel extends Model
{
    use HasFactory;

    protected $table = 'work_orders';

    public $fillable = [
        'rfq_id',
        'customer_id',
        'work_order_date',
        'work_order_no',
        'lead_id',
        'description',
        'address',
        'total_pdt_price',
        'final_value',
        'last_tracked_comment',
        'last_tracked_date',
        'status',
        'is_active',
        'is_recurring',
        'created_at',
        'created_by',
        'modified_by',
        'updated_at',
        'deleted_at',
    ];
}


