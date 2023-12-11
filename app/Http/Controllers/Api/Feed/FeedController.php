<?php

namespace App\Http\Controllers\Api\Feed;

use App\Http\Controllers\Controller;
use App\Models\Preference;
use App\Services\Articles\FeedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function __construct(
        protected FeedService $feedService
    )
    {

    }

    public function get(Request $request)
    {
        $articles = $this->feedService->get($request->all());
        return compact('articles');
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $data = [
            'category_ids' => $request->post('category_ids'),
            'author_ids' => $request->post('author_ids'),
            'source_ids' => $request->post('source_ids')
        ];
        if ($user->preference === null) {
            $preference = new Preference($data);
            $user->preference()->save($preference);
        } else {
            $user->preference->update($data);
        }
    }
}
