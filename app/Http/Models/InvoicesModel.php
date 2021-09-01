<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class InvoicesModel extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    public $fillable = [
    'customer_id',
    'invoice_no',
    'invoice_date',
    'delivery_note',
    'payment_mode',
    'supplier_reference',
    'other_reference',
    'order_no',
    'order_dated',
    'despatch_document_no',
    'delivery_note_date',
    'despatched_via',
    'destination',
    'terms_of_delivery',
    'work_order_id',
    'amount',
    'description',
    'HSNSAC',
    'address',
    'taxable_value',
    'central_tax',
    'state_tax',
    'total_tax_amount',
    'is_active',
    'remarks',
    'bank_name',
    'account_no',
    'branch_name',
    'ifsc_code',
    'created_at',
    'created_by',
    'modified_by',
    'updated_at',
    'deleted_at',
];
}


