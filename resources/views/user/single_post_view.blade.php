@extends('layouts.app')

@section('mainSection')
    <div class="py-4"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="mb-5 col-lg-9 mb-lg-0">
                    <article>
                        <div class="mb-4">
                            <img src="{{ asset('post_thumbnails/' . $post->thumbnail) }}" class="card-img" alt="post-thumb">
                        </div>

                        <h1 class="h2">{{ $post->title }}</h1>
                        <ul class="my-3 card-meta list-inline">
                            <li class="list-inline-item">
                                <i class="ti-calendar"></i>{{ date('d M Y', strtotime($post->created_at)) }}
                            </li>
                            <li class="list-inline-item">
                                Category: <b class="text-primary">{{ $post->category_name }}</b>
                            </li>
                        </ul>
                        <h4 class="card-text">{{ $post->subtitle }}</h4>
                        <div class="content">
                            <p>
                                @php
                                    echo $post->description;
                                @endphp
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-lg-9 col-md-12">
                    <div class="mb-5 border-top mt-4 pt-5">
                        <h3 class="mb-4">Comments</h3>
                        @foreach($comments as $comment)
                            <div class="media d-block d-sm-flex mb-4 pb-4">
                                <a class="d-inline-block mr-2 mb-3 mb-md-0" href="#">
                                    @if($comment->user_photo)
                                        <img src="{{ asset('assets/images/userphotos/'. $comment->user_photo) }}" class="mr-3 rounded-circle" alt="" style="height: 30px">
                                    @else
                                        <img src="{{ asset('assets/images/userphotos/default.jpg') }}" class="mr-3 rounded-circle" alt="" style="height: 30px">
                                    @endif

                                </a>
                                <div class="media-body">
                                    <a href="#!" class="h4 d-inline-block mb-3">{{$comment->user_name}}</a>

                                    <p>{!! $comment->comment !!}</p>

                                    <span class="text-black-800 mr-3 font-weight-600">{{ date('d M Y', strtotime($comment->created_at)) }}</span>
                                </div>
                            </div>
                        @endforeach
                        {{ $comments->links('pagination::bootstrap-4') }}
                    </div>

                    <div>
                        <h3 class="mb-4">Leave a Reply</h3>
                        <form action="{{ route('comment_store', $post->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control shadow-none summernote" name="comment" rows="7" required></textarea>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Comment Now</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
