<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use File;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";

    CONST STOREAGE_FOLDER = "uploads/category_icon/";

    public $fillable = [
        'name',
        'slug',
        'icon',
        'parent_id'
    ];

    public function getIconUrlAttribute(){
        # icon_url
        if($this->icon){
            if(File::exists($this->icon)){
                return env("APP_URL").$this->icon;
            }
        }
        return "";
    }

    public function getParentCategoryAttribute(){
        # parent_category
        if($this->parent_id && $this->parent_id > 0){
            $getParentCategory = self::find($this->parent_id);
            if($getParentCategory){
                return $getParentCategory->name;
            }
        }
        return "";
    }
}
