<?php

namespace App\Http\Controllers;
use App\Post;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTopicRequest;
use App\Transformers\TopicTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TopicController extends Controller
{
    public function index()
    {
        #-------- listar los ultimos topics
        $topics = Topic::latestFirst()->paginate(3);
        #-------- $topicsCollection, extrae la coleccion de topics
        $topicsCollection = $topics->getCollection();

        return fractal()
            #------ listar la coleccion de topics
            ->collection($topicsCollection)
            #------ solo nec. el topic yel user
            ->parseIncludes(['user'])
            #------ transformar con el TopicTransformer
            ->transformWith(new TopicTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($topics))
            #------ y lo devolvemos como un array
            ->toArray();
    }


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

        return fractal()
            ->item($topic)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->toArray();


    }
}
