<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return Inertia::render('posts/Index', [
            'posts' => $posts
        ]);
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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
        ]);

        $user = Auth::user();
        $data['user_id'] = $user->id;

        Post::create($data);

        return redirect()->route('posts.index')
            ->with('success', 'Post create !');
        }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return inertia::render('Articles/Show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug' .$post->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
        ]);

        $user = Auth::user();
        $data['user_id'] = $user->id;

        Post::update($data);

        return redirect()->route('posts.index')
            ->with('success', 'Post create !');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return Redirect::route('posts.index')->with('success', 'Post supprimé avec succès.');
    }
}
