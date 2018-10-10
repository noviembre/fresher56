<?php

namespace App\Http\Controllers;
use App\Post;
use App\Topic;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
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

    #------ we receive the post.
    #------ no vamos a usar el topic pero... como el post esta dentro del grupo del topic....
    #------ entocnes si lo incluimos
    public function update(UpdatePostRequest $request, Topic $topic, Post $post)
    {
        #-- policie: I authorize the update from the post
        $this->authorize('update', $post);

        $post->body = $request->get('body', $post->body);
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function destroy(Topic $topic, Post $post)
    {
        $this->authorize('destroy', $post);
        $post->delete();
        return response(null, 204);
    }

}
