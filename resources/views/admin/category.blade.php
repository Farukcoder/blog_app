@extends('admin.layouts.app')

@section('title')
    Category
@endsection

@php
    $page = 'Category';
@endphp

@section('main_content')
    <!-- Categories DataTales Start-->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">Add Category</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categoris as $sl => $category)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->created_at->setTimezone('Asia/Dhaka')->format('d-m-Y h:i:s A') }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="{{'#category'. $category->id .'EditModal'}}"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- category edit Modal Start-->
                        <div class="modal fade" id="{{'category'. $category->id .'EditModal'}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('category.update', $category->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="put">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="category name">Category Name</label>
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category name" value="{{ $category->name }}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" name="description" id="description" class="form-control" rows="5" > {{ $category->description }}</textarea>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary" type="submit">Update Category</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- category edit Modal End-->
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Categories DataTales End -->

    <!-- category add Modal Start-->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category name">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Category name" value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text" name="description" id="description" class="form-control" rows="5" > {{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- category add Modal End-->
@endsection
