<?php

namespace App\Http\Controllers\Admin\Post;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Post\BaseController;
use App\Http\Filters\PostFilter;
use App\Http\Requests\Post\FilterRequest;


class IndexAdminController extends Controller
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
        $posts = Post::filter($filter)->paginate(10);
        return view('admin.post.index', compact('posts'));
    }
}
