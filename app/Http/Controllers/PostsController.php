<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;
use Gate;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all(); // all
        // $posts = Post::orderBy('title', 'desc')->get(); // all order by 'title'
        // $posts = Post::where('title', 'Post two')->get(); // only 'Post'
        // $posts = DB::select('select * from posts where id = ?', [2]); // only post id 2
        // $posts = Post::orderBy('title', 'asc')->take(1)->get(); // limit to 1 post only
        $posts = Post::orderBy('created_at', 'desc')->paginate(3); // pagination, given 1 number
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required',
            'body'          => 'required',
            'cover_image'   => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('cover_image')) { // handle File Upload
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName(); // get filename with the extension
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); // get just filename
            $extension = $request->file('cover_image')->getClientOriginalExtension(); // get just ext
            $fileNameToStore = $filename.'_'.time().'.'.$extension; // unique filename to store by name and time stamp
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore); // upload image
        } else {
            $fileNameToStore = 'noimage.jpg'; // image name when not upload
        }        
        $post = new Post; // creatre new post
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        // if (auth()->user()->id !== $post->user_id) {
        if (Gate::denies('create-posts')) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required'
        ]);
        if ($request->hasFile('cover_image')) { // handle File Upload
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName(); // get filename with the extension
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); // get just filename
            $extension = $request->file('cover_image')->getClientOriginalExtension(); // get just ext
            $fileNameToStore = $filename.'_'.time().'.'.$extension; // unique filename to store by name and time stamp
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore); // upload image
        }        
        $post = Post::find($id); // this post
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('cover_image')) {
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/posts')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        // if (auth()->user()->id !== $post->user_id) {
        if (Gate::denies('create-posts')) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image); // delete image
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post removed');
    }
}
