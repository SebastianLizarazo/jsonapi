<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListArticleTest extends TestCase
{
     use RefreshDatabase;

    /* @test */
    public function test_can_fetch_single_article()//verificar que podemos optener un articulo especifico
    {
        $article = Article::factory()->create();
                                    ///api/v1/articles/'.$article->getRouteKey()
        $response = $this->getJson(route('api.v1.articles.show', $article));//Definimos el nombre de la ruta a la que queremos hacer referencia

        $response->assertExactJson([//Queremos verificar que recibimos exactamente la estructura que definimos acá abajo de un documento JsonApi
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content,
                ],
                'links' => [//vamos al link self que apunta a si mismo, por eso es la misma url de arriba
                    'self' => route('api.v1.articles.show', $article),//encerramos la ruta dentro del helper url que contiene el dominio definido en la variable url del archivo .env
                            //para que lo coloque como prefijo y se convierta en una ruta completa o absoluta
                ]
            ]
        ]);
    }

    /* @test */
    public function test_can_fetch_all_articles()//verificar que podemos optener un articulo especifico
    {
        $article = Article::factory()->count(3)->create();

        $response = $this->getJson(route('api.v1.articles.index'));//Definimos el nombre de la ruta a la que queremos hacer referencia

        $response->assertExactJson([//Queremos verificar que recibimos exactamente la estructura que definimos acá abajo de un documento JsonApi
            'data' => [
                [
                    'type' => 'articles',
                    'id' => (string) $article[0]->getRouteKey(),
                    'attributes' => [
                        'title' => $article[0]->title,
                        'slug' => $article[0]->slug,
                        'content' => $article[0]->content,
                    ],
                    'links' => [//vamos al link self que apunta a si mismo, por eso es la misma url de arriba
                        'self' => route('api.v1.articles.show', $article[0]),//encerramos la ruta dentro del helper url que contiene el dominio definido en la variable url del archivo .env
                        //para que lo coloque como prefijo y se convierta en una ruta completa o absoluta
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string) $article[1]->getRouteKey(),
                    'attributes' => [
                        'title' => $article[1]->title,
                        'slug' => $article[1]->slug,
                        'content' => $article[1]->content,
                    ],
                    'links' => [//vamos al link self que apunta a si mismo, por eso es la misma url de arriba
                        'self' => route('api.v1.articles.show', $article[1]),//encerramos la ruta dentro del helper url que contiene el dominio definido en la variable url del archivo .env
                        //para que lo coloque como prefijo y se convierta en una ruta completa o absoluta
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => (string) $article[2]->getRouteKey(),
                    'attributes' => [
                        'title' => $article[2]->title,
                        'slug' => $article[2]->slug,
                        'content' => $article[2]->content,
                    ],
                    'links' => [//vamos al link self que apunta a si mismo, por eso es la misma url de arriba
                        'self' => route('api.v1.articles.show', $article[2]),//encerramos la ruta dentro del helper url que contiene el dominio definido en la variable url del archivo .env
                        //para que lo coloque como prefijo y se convierta en una ruta completa o absoluta
                    ]
                ],
            ],
            'links' =>[
                'self' => route('api.v1.articles.index')
            ],
            'meta' => [
                'articles_count' => 3
            ]
        ]);
    }
}
