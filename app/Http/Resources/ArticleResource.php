<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {//En este lugar le damos un formato al reosurce object
        return [//retornamos la estructura del recurso
            'type' => 'articles',
            'id' => (string) $this->resource->getRouteKey(),//$this->resource = el articulo actual
            'attributes' => [
                'title' => $this->resource->title,
                'slug' => $this->resource->slug,
                'content' => $this->resource->content,
            ],
            'links' => [//vamos a llamar a su mismo link self que apunta a si mismo, por eso
                'self' => route('api.v1.articles.show',$this->resource),
            ]
        ];
    }
}
