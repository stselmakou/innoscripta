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

class TheGuardian implements ShouldQueue
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
        $author = Author::where('name', self::NAME)->first() ?? new Author(['name' => self::NAME]);
        $author->save();
        $source = Source::where('name', self::NAME)->first() ?? new Source(['name' => self::NAME]);
        $source->save();
        $fields = [
            'source_id' => $source->id,
            'author_id' => $author->id,
            'category_id' => $this->category->id,
            'title' => $data['webTitle'],
            'url' => $data['webUrl'],
            'publication_date' => Carbon::parse($data['webPublicationDate']),
        ];
        $article = Article::where('title', $data['webTitle'])->where('url', $data['webUrl'])->first() ?? new Article($fields);
        $article->save();
    }
}
