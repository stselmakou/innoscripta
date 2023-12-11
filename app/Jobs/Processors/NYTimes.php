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

class NYTimes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public const NAME = 'The Guardian';

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
        $authorName = $data['byline']['original'] ?? self::NAME;
        $author = Author::where('name', $authorName)->first() ?? new Author(['name' => $authorName]);
        $author->save();
        $source = Source::where('name', $data['source'])->first() ?? new Source(['name' => $data['source']]);
        $source->save();

        $fields = [
            'source_id' => $source->id,
            'author_id' => $author->id,
            'category_id' => $this->category->id,
            'title' => $data['headline']['main'],
            'content' => $data['lead_paragraph'],
            'url' => $data['web_url'],
            'image_url' => $data['multimedia'][0]['url'] ?? '',
            'publication_date' => Carbon::parse($data['pub_date']),
        ];
        $article = Article::where('title', $data['headline']['main'])->where('url', $data['web_url'])->first() ?? new Article($fields);
        $article->save();
    }
}
