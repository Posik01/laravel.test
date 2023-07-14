<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Controllers\Post\BaseController;
use App\Http\Requests\Post\UpdateRequest;


class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Post $post)
    {
        $data = $request->validate();

        $this->service->update($post, $data);

        return redirect()->route('post.show', $post->id);
    }
}
