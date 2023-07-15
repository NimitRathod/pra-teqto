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
        <form class="row g-3" action="{{ (isset($edit) && isset($edit->id)) ? route('category.update',[$edit->id]) : route('category.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            @isset($edit)
            @method('PUT')
            @endisset
            <div class="col-md-6">
                <label for="category_name" class="form-label">Category name</label>
                <input type="text" id="category_name"  class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') ? old('category_name') : (isset($edit) ? $edit->name : '') }}" placeholder="Enter category name" required>
            </div>
            <div class="{{ (isset($edit) && isset($edit->id)) ? 'col-md-4' : 'col-md-6' }}">
                <label for="category_icon" class="form-label">Category Icon</label>
                <input type="file" class="form-control" name="category_icon" aria-label="file example" accept="image/png, image/gif, image/jpeg" {{ (isset($edit) && isset($edit->id)) ? '' : 'required' }}>
            </div>
            @if(isset($edit))
            <div class="col-md-2">
                <label for="category_icon" class="form-label">&nbsp;</label>
                @if(isset($edit->icon))
                <img src="{{ $edit->icon_url }}" alt="{{ $edit->name }}" width="75px"/>
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