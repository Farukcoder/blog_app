<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionAnswerLike;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objPost = new Post();

        $posts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.status', 1)
            ->orderBy('posts.id', 'DESC')
            ->paginate(3);

        $recentPosts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.status', 1)
            ->orderBy('posts.id', 'DESC')
            ->limit(5)
            ->get();

        $categoris = Category::all();

        return view('user.index', compact('posts', 'categoris', 'recentPosts'));
    }

    public function single_post_view($id)
    {
        $postObj = new Post();

        $post = $postObj->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.id', $id)
            ->orderBy('posts.id', 'DESC')
            ->first();
        $commentObj = new PostComment();

        $comments = $commentObj->join('users', 'users.id', '=', 'post_comments.user_id')
            ->select('post_comments.*', 'users.name as user_name', 'users.photo as user_photo')
            ->where('post_comments.post_id', $id)
            ->paginate(3);

        return view('user.single_post_view', compact('post', 'comments'));
    }

    public function filter_by_category($id)
    {
        $objPost = new Post();

        $filter_posts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.status', 1)
            ->where('posts.category_id', $id)
            ->orderBy('posts.id', 'DESC')
            ->paginate(5);

        $recentPosts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.status', 1)
            ->orderBy('posts.id', 'DESC')
            ->limit(5)
            ->get();

        $categoris = Category::all();

        return view('user.filter_by_category', compact('filter_posts', 'recentPosts', 'categoris'));
    }

    public function comment_store(Request $request, $id)
    {
        $data = [
            'post_id' => $id,
            'user_id' => auth()->user()->id,
            'comment' => $request->comment
        ];

        PostComment::create($data);

        $notify = ['message' => 'Comment successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function questions()
    {
        $qustionObj = new Question();
        $objPost = new Post();

        $questions = $qustionObj->join('categories', 'categories.id', '=', 'questions.category_id')
            ->join('users', 'users.id', '=', 'questions.user_id')
            ->select('questions.*', 'categories.name as category_name', 'users.name as user_name', 'users.photo as user_photo')
            ->orderby('questions.id', 'desc')
            ->paginate(5);

        $posts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.status', 1)
            ->orderBy('posts.id', 'DESC')
            ->paginate(3);


        $categoris = Category::all();

        return view('user.questions', compact('categoris', 'questions', 'posts'));
    }

    public function question_store(Request $request)
    {
        $request->validate([
           'category_id' => 'required',
            'question' => 'required'
        ]);

        $data = [
          'user_id' => auth()->user()->id,
          'category_id' => $request->category_id,
          'question' => $request->question
        ];

        Question::create($data);

        $notify = ['message' => 'Question successfully added', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function question_delete($id)
    {
        Question::find($id)->delete();

        $notify = ['message' => 'Question deleted done', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);

    }

    public function questionAnswers($id)
    {
        $questionObj = new Question();
        $answerObj = new QuestionAnswer();

        $question = $questionObj->join('categories', 'categories.id', '=', 'questions.category_id')
            ->join('users', 'users.id', '=', 'questions.user_id')
            ->select('questions.*', 'categories.name as category_name', 'users.name as user_name', 'users.photo as user_photo')
            ->where('questions.id', $id)
            ->orderby('questions.id', 'desc')
            ->first();

        $answers = $answerObj->join('users', 'users.id', '=', 'question_answers.user_id')
            ->select('question_answers.*', 'users.name as user_name', 'users.photo as user_photo')
            ->where('question_answers.question_id', $id)
            ->orderby('question_answers.id', 'desc')
            ->paginate(5);

        return view('user.question_answers', compact('question', 'answers'));
    }

    public function questionAnswerStore(Request $request, $id)
    {
        $data = [
          'question_id' => $id,
          'user_id' => auth()->user()->id,
          'answer' => $request->answer
        ];

        QuestionAnswer::create($data);

        $notify = ['message' => 'Answer added', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);

    }

    public function questionAnswerDelete($id)
    {
        QuestionAnswer::find($id)->delete();

        $notify = ['message' => 'Answer deleted done', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function questionAnswerLike($id)
    {
        $data = [
            'answer_id' => $id,
            'user_id' => auth()->user()->id
        ];

        QuestionAnswerLike::create($data);

        return redirect()->back();
    }

    public function questionAnswerUnlike($id)
    {
        QuestionAnswerLike::where('answer_id', $id)->where('user_id', auth()->user()->id)->delete();

        return redirect()->back();
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function contactStore(Request $request)
    {
        $data = [
            'user_id' => auth()->user()->id,
            'subject' => $request->subject,
            'message' => $request->message
        ];

        ContactMessage::create($data);

        $notify = ['message' => 'Message sent successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }

    public function about()
    {
        return view('user.about');
    }

}
