<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class InvoiceItemsModel extends Model
{
    use HasFactory;

    protected $table = 'invoices_items';

    public $fillable = [
        'invoice_id',
        'hsnsac',
        'product_id',
        'quantity',
        'units',
        'price',
        'subtotal',
        'total_pdt_price',
        'services_description',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
}


