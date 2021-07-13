<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortArticlesTest extends TestCase
{
     use RefreshDatabase;
    /* @test */
    public function test_it_can_sort_articles_by_title_asc()
    {
        Article::factory()->create(['title' => 'C Title']);
        Article::factory()->create(['title' => 'A Title']);
        Article::factory()->create(['title' => 'B Title']);

        $url = route('api.v1.articles.index', ['sort' => 'title']);//sort ordena recursos por defecto de manera acendente, le estamos diciendo que lo ordene acendentemente por el titulo
        $this->getJson($url)->assertSeeInOrder([
            'A Title',
            'B Title',
            'C Title',
        ]);//hacemos el llamado a la ruta api
    }

    /* @test */
    public function test_it_can_sort_articles_by_title_desc()
    {
        Article::factory()->create(['title' => 'C Title']);
        Article::factory()->create(['title' => 'A Title']);
        Article::factory()->create(['title' => 'B Title']);

        $url = route('api.v1.articles.index', ['sort' => '-title']);//con el signo (-) detras del title va a hacer que la direccion del orden cambie a decendente
        $this->getJson($url)->assertSeeInOrder([
            'C Title',
            'B Title',
            'A Title',
        ]);
    }

    /* @test */
    public function test_it_can_sort_articles_by_title_and_content()
    {
        Article::factory()->create([
            'title' => 'C Title',
            'content' => 'B content'
        ]);
        Article::factory()->create([
            'title' => 'A Title',
            'content' => 'C content'
        ]);
        Article::factory()->create([
            'title' => 'B Title',
            'content' => 'D content'
        ]);

        \DB::listen(function ($db){
            dump($db->sql);
        });

        $url = route('api.v1.articles.index').'?sort=title,-content';//concatenamos con el sort para que ordene primero por el titulo y despues intente ordenarlo por el contenido

        $this->getJson($url)->assertSeeInOrder([
            'C Title',
            'B Title',
            'A Title',
        ]);
    }
}
