@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100">
                    <h3>Sub Category</h3>
                    <a href="{{ route('sub-category.create') }}" class="btn btn-primary ms-auto">Create Sub  Category</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 pt-5">
        @if(isset($data))
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Parent Category</td>
                        <td>Name</td>
                        <td>Slug</td>
                        <td width="100px">Action</td>
                    </tr>
                </thead>
                @foreach ($data as $item)
                <tr>
                    <td>{{$item->id ?? ''}}</td>
                    <td>{{$item->parent_category ?? ''}}</td>
                    <td>{{$item->name ?? ''}}</td>
                    <td>{{$item->slug ?? ''}}</td>
                    <td>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sub-category.edit',[$item->id]) }}" class="btn btn-info btn-sm">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('sub-category.destroy', [$item->id]) }}" class="inline-block align-middle">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    </div>
    @endsection
    
    @section('page-script')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    
    <script>
        $('.table').DataTable({
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ]
        });
    </script>
    @endsection