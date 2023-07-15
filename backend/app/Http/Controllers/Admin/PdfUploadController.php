<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\PdfUpload;

class PdfUploadController extends Controller
{
    public $parent_category;
    function __construct(){

        $this->parent_category = Category::select('id','name','parent_id')->where('parent_id',0)->orderBy('id','DESC')->get();
    } 

    public function index()
    {
        $data = PdfUpload::select('id','category_id','sub_category_id','pdf')->orderBy('id','DESC')->get()->append(['category_name','subcategory_name','pdf_url']);
        return view('admin.module.pdf.index',compact('data'));
    }

   
    public function create()
    {
        $parent_category = $this->parent_category;
        return view('admin.module.pdf.form',compact('parent_category'));
    }


    public function store(Request $request)
    {
        // return $request->all();
        Validator::validate($request->all(), [
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'pdf_upload' => 'required|mimes:pdf|max:5120'
        ]);
        try{
            $input = $request->all();
           
            if($request->hasFile('pdf_upload')){
                $image = $request->file('pdf_upload');
                
                $fileName = Str::slug($image->getClientOriginalName()).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path(PdfUpload::STOREAGE_FOLDER), $fileName);
                
                $input['pdf'] = PdfUpload::STOREAGE_FOLDER.$fileName;
                // return $input;
            }
            PdfUpload::create($input);
            return redirect()->route('pdf-upload.index')->with('success','PDF created successfully');
            
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
            $edit = PdfUpload::orderBy('id','DESC')->findOrFail($id);
            if($edit){
                $edit = $edit->append(['pdf_url']);
                $parent_category = $this->parent_category;
                $child_category = Category::select('id','name','parent_id')->where('parent_id',$edit->category_id)->orderBy('id','DESC')->get();
                return view('admin.module.pdf.form',compact('edit','parent_category','child_category'));
            }
            return redirect()->back()->with('error',"Data not found");
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        Validator::validate($request->all(), [
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'pdf_upload' => 'nullable|mimes:pdf|max:5120'
        ]);
        try{
            $update = PdfUpload::findOrFail($id);

            $update->category_id = $request->category_id;
            $update->sub_category_id = $request->sub_category_id;
           
            if($request->hasFile('pdf_upload')){
                $image = $request->file('pdf_upload');
                
                $fileName = Str::slug($image->getClientOriginalName()).time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path(PdfUpload::STOREAGE_FOLDER), $fileName);
                
                $update->pdf = PdfUpload::STOREAGE_FOLDER.$fileName;
                // return $input;
            }
            $update->save();
            return redirect()->route('pdf-upload.index')->with('success','PDF created successfully');
            
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try{
            $pdfUpload = PdfUpload::findOrFail($id);
            if($pdfUpload->delete()){
                return redirect()->route('pdf-upload.index')->with('success','Pdf delte successfully');
            }
            return redirect()->back()->with('error',"Something want to wrong");
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage())->withInput();
        }
    }
}
