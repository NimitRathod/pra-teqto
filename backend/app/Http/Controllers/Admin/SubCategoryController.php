<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class SubCategoryController extends Controller
{
    public $parent_category;
    function __construct(){

        $this->parent_category = Category::select('id','name','parent_id')->where('parent_id',0)->orderBy('id','DESC')->get();
    } 
    public function index()
    {
        $data = Category::select('id','name','slug','parent_id')->where('parent_id',"!=",0)->orderBy('id','DESC')->get()->append('parent_category');
        return view('admin.module.sub-category.index',compact('data'));
    }
    
    public function create()
    {
        $parent_category = $this->parent_category;
        return view('admin.module.sub-category.form',compact('parent_category'));
    }    
    
    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->category_name);
        
        Validator::validate($request->all(), [
            'category_name' => 'required',
            'slug' => 'required',
        ]);
        try{
            $input = $request->all();
            $input['name'] = $request->category_name;
            $input['parent_id'] = $request->category_id;
            
            Category::create($input);
            return redirect()->route('sub-category.index')->with('success','Sub-Category created successfully');
            
            return $request->all();
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        try{
            $edit = Category::orderBy('id','DESC')->findOrFail($id);
            if($edit){

                $parent_category = $this->parent_category;
                // return $edit;
                return view('admin.module.sub-category.form',compact('edit','parent_category'));
            }
            return redirect()->back()->with('error',"Sub-Category not found");
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    
    
    public function update(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->category_name);
        
        Validator::validate($request->all(), [
            'category_name' => 'required',
            'slug' => 'required',
            'category_icon' => 'nullable|mimes:png,jpg,jpeg|max:1024'
        ]);

        try{
            $update = Category::findOrFail($id);
            
            $update['name'] = $request->category_name;
            $update['slug'] = $request->slug;
            
            if($request->hasFile('category_icon')){
                $image = $request->file('category_icon');
                
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path(Category::STOREAGE_FOLDER), $fileName);
                
                $update['icon'] = Category::STOREAGE_FOLDER.$fileName;
            }
            $update->save();

            return redirect()->route('sub-category.index')->with('success','Sub-Category update successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }
    

    public function destroy($id)
    {
        try{
            $category = Category::findOrFail($id);
            if($category->delete()){
                return redirect()->route('sub-category.index')->with('success','Sub-Category delte successfully');
            }
            return redirect()->back()->with('error',"Something want to wrong");
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }
}
