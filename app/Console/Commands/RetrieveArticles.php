<?php

namespace App\Console\Commands;

use App\Jobs\Articles\ProcessForCategory;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Config;
use App\Models\Category;

class RetrieveArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:innoscripta:retrieve-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve articles from defined list';

    public function __construct(
        protected Application $app
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = Category::get();
        $categories->each(fn (Category $category) => ProcessForCategory::dispatch($category));

    }
}
