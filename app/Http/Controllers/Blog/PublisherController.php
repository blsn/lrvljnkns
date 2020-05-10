<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Gate;

class PublisherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        if (Gate::denies('create-posts')) {
            return redirect(route('dashboard'));
        }
        $posts = Post::all(); // all
        return view('blog.publisher')->with('posts', $posts);
    }
}
