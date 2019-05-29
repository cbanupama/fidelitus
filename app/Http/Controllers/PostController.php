<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryId = Input::get('category_id');

        if($categoryId === '' || $categoryId === null) {
            $posts = Post::with('category')->get();
        } else {
            $posts = Post::with('category')->where('category_id', $categoryId)->get();
        }

        $categories = Category::all();
        return view('post.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = Storage::disk('public')->putFile('images', $request->file('image'));

        $post = Post::create([
            'category_id'  => $request->get('category_id'),
            'title'        => $request->get('title'),
            'body'         => $request->get('body'),
            'image'        => $path,
            'youtube_link' => $request->get('youtube_link')
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('category')->findOrFail($id);

        return redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('post.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::with('category')->findOrFail($id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
        } else {
            $path = $post->image;
        }

        $post->category_id = $request->get('category_id');
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->image = $path;
        $post->youtube_link = $request->get('youtube_link');
        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index');
    }
}
