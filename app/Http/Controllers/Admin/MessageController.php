<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $msgObj = new ContactMessage();

        $messages = $msgObj->join('users', 'users.id', '=', 'contact_messages.user_id')
            ->select('contact_messages.*', 'users.name as user_name', 'users.photo as user_photo', 'users.email as user_email')
            ->orderby('contact_messages.id', 'desc')
            ->get();

        return view('admin.messages', compact('messages'));
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
        ContactMessage::find($id)->delete();

        $notify = ['message' => 'Message deleted', 'alert-type' => 'success'];

        return redirect()->back()->with($notify);
    }
}
