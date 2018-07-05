<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function comments()
    {
        $comments = Comment::all();
        return view('admin.comments',comapct('comments'));
    }

    public function deleteComment($id)
    {
        $comment = Comment::where('id',$id)->first();
        $comment->delete();
        return back();
    }
    public function posts()
    {
        $posts = Post::all();
        return view('admin.posts',compact('posts'));
    }

    public function postEdit($id)
    {
        $post = Post::where('id', $id)->first();
        return view('admin.editPost',compact('post'));
    }

    public function postEditPost(CreatePost $request,$id)
    {
        $post = Post::where('id', $id)->first();
        $post = Post::Where('id', $id)->where('user_id', Auth::id())->first();
        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->save();

        return back()->with('success', "Post updated successfully");
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->first();
        // $post = Post::where('id', $id)->where('user_id', Auth::id())->first();
        $post->delete();
        return back();
    }

    public function users()
    {
        return view('admin.users');
    }
}
