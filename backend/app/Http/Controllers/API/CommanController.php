<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\PdfUpload;

class CommanController extends BaseController
{
    public function getAllCategory(Request $request){
        $success = [];
        $success = Category::select('id','name','parent_id','icon')->where('parent_id',0)->orderBy('id','DESC')->get()->append('icon_url');
        return $this->sendResponse($success, 'Get Categories');
    }
    
    public function getSubcategories(Request $request,$category_id){
        $success = [];
        
        $subcategory = Category::select('id','name','slug','parent_id')->where('parent_id',$category_id)->orderBy('id','DESC')->get();
        if(!$subcategory){
            return $this->sendError('subcategory not found');
        }
        $success = $subcategory;
        return $this->sendResponse($success, 'Get subcategory detail');
    }
    
    public function getPdfs(Request $request,$category_id, $subcategory_id = null){
        $success = [];
        
        $PdfData = PdfUpload::where('category_id',$category_id);
        if($subcategory_id){
            $PdfData = $PdfData->where('sub_category_id',$subcategory_id);
        }
        $PdfData = $PdfData->orderBy('id','DESC')->get()->append(['category_name', 'sub_category_name','pdf_url']);
        if(!$PdfData){
            return $this->sendError('PdfData not found');
        }
        $success = $PdfData;
        return $this->sendResponse($success, 'Get PdfData detail');
    }
}
