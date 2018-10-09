<?php

namespace App\Http\Controllers;
use App\Post;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTopicRequest;

class TopicController extends Controller
{
    public function store(StoreTopicRequest $request)
    {
        #====== Crear nueva instancia
        $topic = new Topic;
        #====== guardar el titulo del request
        $topic->title = $request->title;
        #====== asociar el User con el topic
        #=== para eso accedemos al user relationship
        #usamos el associate method y le pasamos el user que queremos asociar
        $topic->user()->associate($request->user());

        #=== save post in the topic
        $post = new Post;
        #====== guardar el body del request
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        #====== guardar el post a ese topic
        $topic->posts()->save($post);

        
    }
}
