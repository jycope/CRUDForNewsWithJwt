<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        $transformedNews = $news->map(fn ($itemNews) => new NewsCollection($itemNews));

        return $transformedNews;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $news = new News(); 
        $news->fill($validator->validated());
        $news->save();
    
        return response('Новость создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {        
        return new NewsCollection($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $news->fill($validator->validated());
        $news->save();

        return response('Новость изменена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {        
        $news->delete();

        return response('Новость удалена');
    }
}
