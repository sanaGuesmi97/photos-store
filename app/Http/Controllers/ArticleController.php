<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(StoreArticleRequest $request)
    {   
        $article = new Article();
            $article->title = $request->title;
            $article->content = $request->content;

            $article->save();
            return $article;

       
    }
    public function index()
    {
        try {
            $article = Article::all();
            return ArticleResource::collection($article);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
     
    }
    public function show($id)
    {
        try {
            $article = Article::findOrFail($id);
            return new ArticleResource($article);
        } catch (\Exception $e) {
            return $e->getMessage();
        };
    }
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::find($id);
        $article->update($request->all());
        return $article;
    }
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return 'deleted';
    }
    public function restore($id)
    {
        $article = Article::withTrashed()->find($id);
        $article->restore();
        return 'restored one';
    }


}
