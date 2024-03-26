@extends('admin.layouts.app')
@section('title')
    Message
@endsection

@php
    $page = 'message';
@endphp
@section('main_content')
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
                        <th>Photo</th>
                        <th>Name & Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $sl => $message)
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>
                                <img src="{{ asset('assets/images/userphotos/' . $message->user_photo) }}" alt=""
                                     style="width: 50px">
                            </td>
                            <td>{{ $message->user_name }} <br>
                                <small>{{ $message->user_email }}</small></td>
                            <td>{{ $message->subject }}</td>

                            <td>{!! $message->message !!}</td>

                            <td>
                                <div class="d-flex">

                                    <a class="mr-2 btn btn-info btn-sm" href="mailto:{{ $message->user_email }}" target="_blank">
                                        <i class="fas fa-envelope"></i>
                                    </a>

                                    <form action="{{ route('message.destroy', $message->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
