<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    
    public function index()
    {
        $data = Category::where('parent_id',0)->orderBy('id','DESC')->get()->append('icon_url');
        return view('admin.module.category.index',compact('data'));
    }
    
    public function create()
    {
        return view('admin.module.category.form');
    }
    
    
    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->category_name);
        
        Validator::validate($request->all(), [
            'category_name' => 'required',
            'slug' => 'required||unique:categories,slug',
            'category_icon' => 'nullable|mimes:png,jpg,jpeg|max:1024'
        ]);
        try{
            $input = $request->all();
            $input['name'] = $request->category_name;
            
            if($request->hasFile('category_icon')){
                $image = $request->file('category_icon');
                
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path(Category::STOREAGE_FOLDER), $fileName);
                
                $input['icon'] = Category::STOREAGE_FOLDER.$fileName;
                // return $input;
            }
            Category::create($input);
            return redirect()->route('category.index')->with('success','category created successfully');
            
            return $request->all();
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
            return redirect()->back()->with('error','Something goes wrong while uploading file!');
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
                $edit = $edit->append('icon_url');
                return view('admin.module.category.form',compact('edit'));
            }
            return redirect()->back()->with('error',"Category not found");
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    
    
    public function update(Request $request, $id)
    {
        $request['slug'] = Str::slug($request->category_name);
        
        Validator::validate($request->all(), [
            'category_name' => 'required',
            'slug' => 'required||unique:categories,slug,'.$id,
            'category_icon' => 'nullable|mimes:png,jpg,jpeg|max:1024'
        ]);

        try{
            $update = Category::findOrFail($id);
            

            // $update = $request->all();
            $update['name'] = $request->category_name;
            $update['slug'] = $request->slug;
            
            if($request->hasFile('category_icon')){
                $image = $request->file('category_icon');
                
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path(Category::STOREAGE_FOLDER), $fileName);
                
                $update['icon'] = Category::STOREAGE_FOLDER.$fileName;
                // return $update;
            }
            $update->save();
            // Category::create($update);
            return redirect()->route('category.index')->with('success','category update successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }
    

    public function destroy($id)
    {
        try{
            $category = Category::findOrFail($id);
            if($category->delete()){
                return redirect()->route('category.index')->with('success','category delte successfully');
            }
            return redirect()->back()->with('error',"Something want to wrong");
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }
}
