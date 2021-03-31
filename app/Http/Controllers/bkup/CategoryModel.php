<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'created_at',
        'created_by',
        'modified_by',
        'updated_at'
    ];
    public function childs() {
        return $this->hasMany('App\Http\Models\CategoryModel','parent_category','id') ;
    }
}