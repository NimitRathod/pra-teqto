<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Models\Category;

class CommanController extends BaseController
{
    public function getAllCategory(Request $request){
        $success = [];
        $success = Category::select('id','name','parent_id')->where('parent_id',0)->orderBy('id','DESC')->get();
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
}
