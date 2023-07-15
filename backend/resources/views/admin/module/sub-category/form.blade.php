@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex w-100">
            <h3> {{ (isset($edit) && isset($edit->id)) ? 'Edit Category' : 'Create Category' }} </h3>
            <a href="{{ URL::previous() }}" class="btn btn-primary ms-auto">Back</a>
        </div>
    </div>
    <div class="col-md-12 border m-2 p-3">
        <form class="row g-3" action="{{ (isset($edit) && isset($edit->id)) ? route('sub-category.update',[$edit->id]) : route('sub-category.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            @isset($edit)
            @method('PUT')
            @endisset
            <div class="col-md-6">
                <label for="category_id" class="form-label">Select Category</label>                
                <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" name="category_id" aria-label="Default select example" required>
                    <option selected value="">Select Category</option>
                    @if ($parent_category)
                    @foreach ($parent_category as $item)
                    <option value="{{ $item->id }}" @if((isset($edit) && isset($edit->parent_id) && $edit->parent_id == $item->id) || (old('category_id') && old('category_id') == $item->id)) selected @endif>{{ $item->name }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="category_name" class="form-label">Category name</label>
                <input type="text" id="category_name"  class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') ? old('category_name') : (isset($edit) ? $edit->name : '') }}" placeholder="Enter category name" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Save form</button>
            </div>
        </form>
    </div>
</div>

@endsection