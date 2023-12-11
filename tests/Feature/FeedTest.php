<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Article;
use Illuminate\Support\Facades\Log;

class FeedTest extends TestCase
{
    public function testArticlesList(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.loc',
            'password' => Hash::make('secret'),
        ]);
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
        $user->createToken('Test Token');
        $this->actingAs($user)
            ->get('api/feed')
            ->assertOk()
            ->assertJsonStructure([
                'articles'
            ]);
    }

    public function testSavePreferences(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.loc',
            'password' => Hash::make('secret'),
        ]);

        $user->createToken('Test Token');
        $this->actingAs($user)
            ->post('api/feed', ['article_ids', '1'])
            ->assertOk();
    }
}
