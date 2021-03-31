<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'category';
   // public $timestamps = true;

    public $fillable = [
        'name',
        'description',
        'code',
        'parent_category',
        'is_child',
        'created_at',
        'created_by',
        'is_active',
        'modified_by',
        'updated_at'
    ];
    public function childs() {
        DB::enableQueryLog();
        // $cat=$this->hasMany('App\Http\Models\CategoryModel','parent_category','id');
        // echo '<pre>';
        // dd($cat); 
        // echo '</pre>';
        // exit;
        return $this->hasMany('App\Http\Models\CategoryModel','parent_category','id') ;
    }
}