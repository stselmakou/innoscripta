<?php

namespace App\Jobs\Processors;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewsApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Category $category,
        protected          $data
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;
        $authorName = $data['author'] ?? $data['source']['name'];
        $author = Author::where('name', $authorName)->first() ?? new Author(['name' => $authorName]);
        $author->save();
        $source = Source::where('name', $data['source']['name'])->first() ?? new Source(['name' => $data['source']['name']]);
        $source->save();

        $fields = [
            'source_id' => $source->id,
            'author_id' => $author->id,
            'category_id' => $this->category->id,
            'title' => $data['title'],
            'content' => $data['description'],
            'url' => $data['url'],
            'image_url' => $data['urlToImage'],
            'publication_date' => Carbon::parse($data['publishedAt']),
        ];
        $article = Article::where('title', $data['title'])->where('url', $data['url'])->first() ?? new Article($fields);
        $article->save();
    }
}
