<?php

namespace App\Http\Controllers;
use App\Post;
use App\Like;
use App\Topic;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function store(Request $request, Topic $topic, Post $post)
    {
        $this->authorize('like', $post);

        if ($request->user()->hasLikedPost($post)) {
            #-- 409 = conflict, something is in there and we cant insert it
            return response(null, 409);
        }

        $like = new Like;
        $like->user()->associate($request->user());

        $post->likes()->save($like);

        return response(null, 204);
    }
}
