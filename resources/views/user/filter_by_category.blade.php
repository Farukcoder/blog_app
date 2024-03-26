@extends('layouts.app')

@section('title')
    Category wise filter
@endsection

@section('mainSection')
    <section class="section">
        <div class="py-4"></div>
        <div class="container">
            <div class="row">
                <div
                    class="col-lg-8  mb-5 mb-lg-0">
                    <h1 class="h2 mb-4">Showing items from <mark>{{ $filter_posts->first()->category_name }}</mark></h1>
                    @foreach($filter_posts as $post)
                        <article class="card mb-4">
                            <div class="post-slider">
                                <img src="{{ asset('post_thumbnails/'. $post->thumbnail) }}" class="card-img-top" alt="post-thumb">
                            </div>
                            <div class="card-body">
                                <h3 class="mb-3"><a class="post-title" href="{{ route('single_post_view', $post->id) }}">{{ $post->title }}</a></h3>
                                <ul class="card-meta list-inline">
                                    <li class="list-inline-item">
                                        <i class="ti-timer"></i>{{ date('d M Y', strtotime($post->created_at)) }}
                                    </li>
                                    <li class="list-inline-item">
                                        Category: <b class="text-primary">{{ $post->category_name }}</b>
                                    </li>
                                    <li class="list-inline-item">
                                        <ul class="card-meta-tag list-inline">
                                            <li class="list-inline-item"><a href="tags.html">Color</a></li>
                                            <li class="list-inline-item"><a href="tags.html">Recipe</a></li>
                                            <li class="list-inline-item"><a href="tags.html">Fish</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <p>{!! $post->description !!}</p>
                                <a href="{{ route('single_post_view', $post->id) }}" class="btn btn-outline-primary">Read More</a>
                            </div>
                        </article>
                    @endforeach

                    {{ $filter_posts->links('pagination::bootstrap-4') }}

                </div>
                @include('layouts.rightbar')
            </div>
        </div>
    </section>
@endsection
