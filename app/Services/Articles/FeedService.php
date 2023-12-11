<?php

namespace App\Services\Articles;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FeedService
{
    /**
     * @param $params
     * @return LengthAwarePaginator
     */
    public function get($params): LengthAwarePaginator
    {
        $user = Auth::user();
        $authors = $params['author_ids'] ?? $user?->preference?->author_ids;
        $categories = $params['category_ids'] ?? $user?->preference?->category_ids;
        $sources = $params['source_ids'] ?? $user?->preference?->source_ids;
        return Article::search()
            ->when($categories, fn($query) => $query->whereIn('category_id', explode(',',$categories)))
            ->when($sources, fn($query) => $query->whereIn('source_id', explode(',',$sources)))
            ->when($authors, fn($query) => $query->whereIn('author_id', explode(',',$authors)))
            ->when(isset($params['date']), fn($query) => $query->whereBetween('published_at', $params['date']))
            ->paginate(20);
    }
}
