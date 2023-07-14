<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;



class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }

    public function index1()
    {
        $posts1 = Post::where('is_published', 0)->first();
        dd($posts1->title);
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post.create', compact('categories', 'tags'));
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => '',
        ]);

        $tags = $data['tags'];
        unset($data['tags']);

        $post = Post::create($data);

        $post->tags()->attach($tags);


        return redirect()->route('post.index');
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Post $post)
    {

        $data = request()->validate([
            'title' => 'string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => '',
        ]);

        $tags = $data['tags'];
        unset($data['tags']);

        $post->update($data);
        $post->tags()->sync($tags);
        return redirect()->route('post.show', $post->id);
    }

    public function delete()
    {
        $post = Post::find(3);

        $post->delete();

        dd('deleted');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }

    public function restore()
    {
        $post = Post::withTrashed()->find(3);

        $post->restore();

        dd('restore');
    }

    public function firstOrCreate()
    {

        $anotherPost = [
            'title' => 'some post',
            'content' => 'mmmmmmmmm whats on your mind?',
            'image' => 'some image.jpg',
            'likes' => 210,
            'is_published' => 1
        ];

        $post = Post::firstOrCreate([
            'title' => 'some title of post',
        ], [
            'title' => 'some title of post',
            'content' => 'mmmmmmmmm whats on your mind?',
            'image' => 'some image.jpg',
            'likes' => 210,
            'is_published' => 1
        ]);

        dump($post->content);
        dd('end');
    }

    public function updateOrCreate()
    {

        $anotherPost = [
            'title' => 'm1m1m1m1m1m1m1m1 post',
            'content' => '41241234 whats on your mind?',
            'image' => '111111111111111 image.jpg',
            'likes' => 21110,
            'is_published' => 0
        ];

        $post = Post::updateOrCreate([
            'title' => 'some title of post'
        ], [
            'title' => 'some title of post',
            'content' => '41241234 whats on your mind?',
            'image' => '111111111111111 image.jpg',
            'likes' => 21110,
            'is_published' => 0
        ]);

        dump($post->content);
    }
}
