<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoris = Category::all();

        $objPost = new Post();

        $posts = $objPost->join('categories AS CA', 'CA.id', '=', 'posts.category_id')
            ->select('posts.*', 'CA.name as category_name')
            ->get();

        return view('admin.post', compact('categoris', 'posts'));
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
        $request->validate([
            "title" => 'required|max:255',
            "category_id" => 'required',
            "description" => 'required',
        ]);

        $data = [
          'title' => $request->title,
          'category_id' => $request->category_id,
          'description' => $request->description,
          'status' => $request->status
        ];

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension;

            ///image resize
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($file);
            $thumbnail->resize(600, 360)->save(public_path('post_thumbnails/'. $filename));

            $data['thumbnail'] = $filename;
        }

        Post::create($data);

        $notify = ['message' => 'Post created successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
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
        $request->validate([
            "title" => 'required|max:255',
            "category_id" => 'required',
            "description" => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status
        ];

        if ($request->hasFile('thumbnail')) {

            if ($request->old_thumb) {
                File::delete(public_path('post_thumbnails/' . $request->old_thumb));
            }

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension;

            //image resize
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($file);
            $thumbnail->resize(600, 360)->save(public_path('post_thumbnails/'. $filename));

            $data['thumbnail'] = $filename;
        }

        Post::where('id', $id)->update($data);

        $notify = ['message' => 'Post Updated successfully', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if ($post->thumbnails) {
            File::delete(public_path('post_thumbnails/'. $post->thumbnails));
        }

        $post->delete();

        $notify = ['message' => 'Post successfully Deleted', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }
}
