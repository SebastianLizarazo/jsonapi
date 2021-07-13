<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ArticleResource::collection($this->collection),//Por cada articulo tendremos la estructura del article resource
            'links' => [
                'self' => route('api.v1.articles.index'),
            ],
            'meta' => [
                'articles_count' => $this->collection->count()//cuenta cuantos articulos hay en la coleccion
            ]
        ];
    }
}
