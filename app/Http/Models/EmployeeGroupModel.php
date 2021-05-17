<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class EmployeeGroupModel extends Model
{
    use HasFactory;

    protected $table = 'user_group';

    public $fillable = [
        'group_name',
        'group_code',
        'group_status',
        'created_at',
        'created_by',
        'modified_by',
        'updated_at'
    ];

}


