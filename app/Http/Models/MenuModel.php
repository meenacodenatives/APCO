<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
class MenuModel extends Model
{
    use HasFactory;

    protected $table = 'menu';

    public $fillable = [
        'menu_name',
        'menu_controller',
        'menu_type',
        'menu_icon',
        'menu_order',
        'menu_level',
        'menu_link',
        'menu_parent',
        'menu_status',
        'created_at',
        'menu_created_by',
        'menu_modified_by',
        'updated_at'
    ];
    public function childs() {
        DB::enableQueryLog();
        return $this->hasMany('App\Http\Models\MenuModel','menu_parent','id') ;
    }
}


