<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
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
            ->get();

        $categoris = Category::all();

        return view('user.index', compact('posts', 'categoris'));
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

        $posts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->where('posts.status', 1)
            ->where('posts.category_id', $id)
            ->orderBy('posts.id', 'DESC')
            ->get();
        return view('user.filter_by_category', compact('posts'));
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
