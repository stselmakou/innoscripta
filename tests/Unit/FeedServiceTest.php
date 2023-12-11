<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Services\Articles\FeedService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class FeedServiceTest extends TestCase
{
    public function testGetArticles(): void
    {
        $source = Source::factory()->create();
        $author = Author::factory()->create();
        $category = Category::factory()->create();
        Article::factory()->create(
            [
                'source_id' => $source->id,
                'author_id' => $author->id,
                'category_id' => $category->id
            ]
        );

        $service = new FeedService();
        $response = $service->get(['author_ids', '1']);
        //TODO add assertCount
        self::assertInstanceOf(LengthAwarePaginator::class, $response);
    }
}
