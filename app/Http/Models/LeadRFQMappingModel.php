<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class LeadRFQMappingModel extends Model
{
    use HasFactory;

    protected $table = 'lead_rfq_mapping';

    public $fillable = [
        'lead_id',
        'rfq_id',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
}


