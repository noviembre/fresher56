<?php

namespace App\Http\Controllers;
use App\Post;
use App\Topic;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use App\Transformers\PostTransformer;

class PostController extends Controller
{
    public function store(StorePostRequest $request, Topic $topic)
    {
        #--- we do not need authorize anything because anyone can reply
        $post = new Post;
        $post->body = $request->body;
        #--- asociar el user actual al post
        $post->user()->associate($request->user());

        #-- from the topic we get in access it the posts relationship
        #-- save the post in there
        $topic->posts()->save($post);

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }
}
