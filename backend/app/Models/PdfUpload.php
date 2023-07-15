<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use File;
class PdfUpload extends Model
{
    use HasFactory;

    protected $table = "pdf_upload";

    CONST STOREAGE_FOLDER = "uploads/pdf/";

    public $fillable = [
        'category_id',
        'sub_category_id',
        'pdf',
    ];

    public function getPdfUrlAttribute(){
        # pdf_url
        if($this->pdf){
            if(File::exists($this->pdf)){
                return env("APP_URL").$this->pdf;
            }
        }
        return "";
    }

    public function getCategoryNameAttribute(){
        # category_name
        if($this->category_id && $this->category_id > 0){
            $category = Category::find($this->category_id);
            if($category){
                return $category->name;
            }
        }
        return "";
    }
    
    public function getSubCategoryNameAttribute(){
        # sub_category_name
        if($this->sub_category_id && $this->sub_category_id > 0){
            $Subcategory = Category::find($this->sub_category_id);
            if($Subcategory){
                return $Subcategory->name;
            }
        }
        return "";
    }
}
