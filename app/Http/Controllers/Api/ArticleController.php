<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        if(!empty(\request('sort')))
        {
            $direction = 'asc';//Esta va a ser la direccion que por defecto sera hacendente cuando el campo title no contenga el (-)
            $sortFields = Str::of(\request('sort'))->explode(',');//defenimos esta variable que contendra el valor de sort que puede ser title o -title

            foreach ($sortFields as $sortField)
            {
                //dd(\request('sort'));
                // Str::of convertira su argumento en un objeto string con el valor que contiene el parametro sort(title)
                if (Str::of($sortField)->startsWith('-')) {//Con el metodo startsWith le preguntamos si el string comienza con un signo (-)
                    $direction = 'desc';
                    $sortField = Str::of($sortField)->substr(1);//Si efectivamente el valor del sort es -title le vamos a quitar el primer caracter(-) con el metodo substr
                    //importante volver a convertir la variable a objeto string para que pueda quitarle el primer caracter
                }
            }

            return ArticleCollection::make(
                Article::orderBy($sortField, $direction)->get()//sort contiene el string title y por ende lo va a ordenar de manera acendente
            );
        }else{
            return ArticleCollection::make(Article::all());
        }

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
