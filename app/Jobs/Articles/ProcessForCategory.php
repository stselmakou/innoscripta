<?php

namespace App\Jobs\Articles;

use App\Models\Category;
use Illuminate\Support\Facades\App;
use App\Traits\DispatchesJobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ProcessForCategory implements ShouldQueue
{
    use Dispatchable, DispatchesJobs, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var Category
     */
    private Category $category;

    /**
     * Create a new job instance.
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $category = $this->category;
        $articlesSources = Config::get('article_sources');
        foreach ($articlesSources as $articlesSource) {
            $retriever = App::make($articlesSource['retriever'], ['apiKey' => $articlesSource['api_key'], 'apiUrl' => $articlesSource['api_url']]);
            $processor = App::make($articlesSource['processor'], ['category' => $category, 'data' => []]);
            collect($retriever->fetch($category->name))->each(fn($data) => $processor->dispatch($category, $data));
        }
    }
}
