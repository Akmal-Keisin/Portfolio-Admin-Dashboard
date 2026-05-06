<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\StoreArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreArticleRequest $request)
    {
        $validated = $request->validated();

        // Use a transaction to ensure Article and Tags save together
        DB::transaction(function () use ($validated) {

            $article = Article::create([
                'title'       => $validated['title'],
                'excerpt'     => $this->generateExcerptFromJSON($validated['content']),
                'content'     => $validated['content'],
                'category_id' => $validated['category'],
                'author_id'   => Auth::id(),
            ]);

            if (!empty($validated['tags'])) {
                $article->tags()->sync($validated['tags']);
            }
        });

        return redirect()->route('article.index')
            ->with('success', 'Article created successfully.');
    }
    /**
     * Recursively search the TipTap JSON tree to find the first block of text.
     */
    private function generateExcerptFromJSON(array $content, int $maxLength = 160): string
    {
        $text = '';

        if (isset($content['content']) && is_array($content['content'])) {
            foreach ($content['content'] as $node) {
                // Find a paragraph block
                if (($node['type'] ?? '') === 'paragraph' && isset($node['content'])) {
                    foreach ($node['content'] as $textNode) {
                        if (($textNode['type'] ?? '') === 'text') {
                            $text .= $textNode['text'] . ' ';
                        }
                    }

                    // Once we have a paragraph, format it and break
                    if (strlen(trim($text)) > 0) {
                        break;
                    }
                }
            }
        }

        return str()->limit(trim($text), $maxLength);
    }
}
