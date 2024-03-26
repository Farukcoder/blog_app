@extends('layouts.app')
@section('title')
    Questions
@endsection
@section('mainSection')
    @include('layouts.banner')
    <!-- questions section -->
    <section class="section-sm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8  mb-5 mb-lg-0">
                    <h2 class="h5 section-title">Questions</h2>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="h5">Frequently asked questions</h3>
                            <a href="#askQuestion" class="btn btn-primary">Ask a Question</a>
                    </div>

                    @foreach($questions as $question)
                    <div class="card mt-4 border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="#" class="btn-link h4">{{ $question->question }}</a>
                                @if($question->user_id == auth()->user()->id)
                                    <form action="{{ route('question_delete', $question->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-danger border-0 bg-white delete"> <i class="fas fa-trash"></i> </button>
                                    </form>
                                @endif
                            </div>

                            <ul class="card-meta list-inline mt-4">
                                <li class="list-inline-item">
                                    <a href="#" class="card-meta-author">
                                        @if($question->user_photo)
                                            <img src="{{ asset('assets/images/userphotos/'. $question->user_photo) }}">
                                        @else
                                            <img src="{{ asset('assets/images/userphotos/default.jpg'. $question->user_photo) }}">
                                        @endif
                                        <span>{{ $question->user_name }}</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar"></i>{{ date('d M Y', strtotime($question->created_at)) }}
                                </li>
                                <li class="list-inline-item text-primary">
                                    <i class="ti-bookmark"></i>{{ $question->category_name }}
                                </li>
                                <li class="list-inline-item text-primary">
                                    <i class="ti-comment"></i>
                                    @php
                                        $answers = DB::table('question_answers')->where('question_answers.question_id', $question->id)->count();
                                        echo $answers;
                                    @endphp
                                    @if($answers > 1)
                                        answers
                                    @else
                                        answer
                                    @endif

                                </li>
                            </ul>

                            <a href="{{ route('question_answers', $question->id) }}" class="btn btn-outline-primary btn-sm mt-4 py-1">See answers</a>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-f">
                        {{ $questions->links('pagination::bootstrap-5') }}
                    </div>


                    <!-- ask question form -->
                    <h3 class="h4 mb-3" id="askQuestion">Ask a question</h3>

                    <form action="{{ route('question_store') }}" method="post">
                    @csrf
                        <div class="form-group mb-3">
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option disabled selected>Choose Category</option>
                               @foreach($categoris as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                               @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <textarea class="form-control @error('question') is-invalid @enderror" name="question" rows="10" required placeholder="Enter question here..."></textarea>
                            @error('question')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit Question</button>
                    </form>

                </div>
                @include('layouts.rightbar')
            </div>
        </div>
    </section>
@endsection
