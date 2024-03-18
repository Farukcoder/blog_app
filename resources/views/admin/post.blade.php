@extends('admin.layouts.app')

@section('title')
    Post
@endsection

@php
    $page = 'Post';
@endphp

@section('main_content')
    <!-- Post DataTales Start-->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
            <button class="btn btn-primary" data-toggle="modal" data-target="#postModal">Add Post</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Thumbnail</th>
                        <th>Status</th>
                        <th>Created date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $sl => $post)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td>
                                <img src="{{ asset('post_thumbnails/' . $post->thumbnail) }}" alt=""
                                     style="width: 100px">
                            </td>

                            <td>
                                @if($post->status = 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>

                            <td>{{ $post->created_at->setTimezone('Asia/Dhaka')->format('d-m-Y h:i:s A') }}</td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="{{'#post'. $post->id .'EditModal'}}"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- post edit Modal Start-->
                        <div class="modal fade" id="{{'post'. $post->id .'EditModal'}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="put">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="post title">Title</label>
                                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Post title" value="{{ $post->title }}">
                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="post category">Post Category</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    @foreach($categoris as $category)
                                                        <option value="{{ $category->id }}" @if($category->id == $post->category_id) selected @endif>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Post Description</label>
                                                <textarea type="text" name="description" id="description" class="form-control" rows="5" > {{ $post->description }}</textarea>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Post Thumbnail</label>
                                                <input type="file" class="form-control-file" name="thumbnail" id="thumbnail">
                                                <input type="hidden" name="old_thumb" value="{{ $post->thumbnail }}">
                                                @error('thumbnail')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <label for="status" class="form-check-label">
                                                <input type="checkbox" value="1" name="status" id="status" @if($post->status == 1) checked @endif> Status
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-primary" type="submit">Update Post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Post edit Modal End-->
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Posts DataTales End -->

    <!-- Post add Modal Start-->
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="post title">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Post title" value="{{ old('title') }}">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post category">Post Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">--Select Category--</option>
                                @foreach($categoris as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Post Description</label>
                            <textarea type="text" name="description" id="description" class="form-control" rows="5" > {{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Post Thumbnail</label>
                            <input type="file" class="form-control-file" name="thumbnail" id="thumbnail">
                            @error('thumbnail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label for="status" class="form-check-label">
                            <input type="checkbox" value="1" name="status" id="status"> Status
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Add Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Post add Modal End-->
@endsection
