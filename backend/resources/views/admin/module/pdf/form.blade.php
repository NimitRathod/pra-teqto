@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex w-100">
            <h3> {{ (isset($edit) && isset($edit->id)) ? 'Edit PDF' : 'Create PDF' }} </h3>
            <a href="{{ URL::previous() }}" class="btn btn-primary ms-auto">Back</a>
        </div>
    </div>
    <div class="col-md-12 border m-2 p-3">
        <form class="row g-3" action="{{ (isset($edit) && isset($edit->id)) ? route('pdf-upload.update',[$edit->id]) : route('pdf-upload.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            @isset($edit)
            @method('PUT')
            @endisset

            <div class="col-md-6">
                <label for="category_id" class="form-label">Select Category</label>                
                <select id="category_id" class="form-control select_category @error('category_id') is-invalid @enderror" name="category_id" aria-label="Default select example" required>
                    <option selected value="">Select Category</option>
                    @if ($parent_category)
                    @foreach ($parent_category as $item)
                    <option value="{{ $item->id }}" @if((isset($edit) && isset($edit->category_id) && $edit->category_id == $item->id) || (old('category_id') && old('category_id') == $item->id)) selected @endif>{{ $item->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="sub_category_id" class="form-label">Select Sub Category</label>                
                <select id="sub_category_id" class="form-control select_subcategory @error('sub_category_id') is-invalid @enderror" name="sub_category_id" aria-label="Default select example">
                    <option disabled selected value="">Select Parent Category</option>
                    @if (isset($edit))
                    @foreach ($child_category as $item)
                    <option value="{{ $item->id }}" @if((isset($edit) && isset($edit->sub_category_id) && $edit->sub_category_id == $item->id) || (old('sub_category_id') && old('sub_category_id') == $item->id)) selected @endif>{{ $item->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="pdf_upload" class="form-label">Upload PDF</label>
                <input type="file" class="form-control" name="pdf_upload" aria-label="file example" accept="application/pdf" {{ (isset($edit) && isset($edit->id)) ? '' : 'required' }}>
            </div>
            @if(isset($edit))
            <div class="col-md-2">
                <label for="pdf_upload" class="form-label">&nbsp;</label>
                @if(isset($edit->pdf_url))
                <a href="{{ $edit->pdf_url }}" target="_blank" class="form-control btn btn-info"> View </a>
                @endif
            </div>
            @endif
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save form</button>
            </div>
        </form>
    </div>
</div>
@endsection


@section('page-script')
@include('admin.partials.select_category_get_subcategory')
@endsection