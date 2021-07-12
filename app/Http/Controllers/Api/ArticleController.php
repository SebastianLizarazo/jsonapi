<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return ArticleCollection::make(Article::all());

        /*
        return response()->json([//retornamos una respuesta de tipo json
            'data' => Article::all()->map(function ($article){//Obtenemos todos los articulos y por cada uno(map) retornamos el resource object
                return [
                    'type' => 'articles',
                    'id' => (string) $article->getRouteKey(),
                    'attributes' => [
                        'title' => $article->title,
                        'slug' => $article->slug,
                        'content' => $article->content,
                    ],
                    'links' => [//vamos a llamar a su mismo link self que apunta a si mismo, por eso
                        'self' => route('api.v1.articles.show',$article),
                    ]
                ];
            })
        ]);
        */
    }

    public function show(Article $article)
    {
        return ArticleResource::make($article);//Llamamos a la estructura del recurso que definimos en el article resource y creamos un recurso con el articulo como parametro
    }
}
