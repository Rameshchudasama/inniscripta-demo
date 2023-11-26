<?php

namespace App\Repositories;

use App\Interfaces\NewsRepositoryInterface;
use App\Models\News;

class NewsRepository implements NewsRepositoryInterface 
{

    /**
     * This function is responsible to store articles from newsapi.
     *
     * @param array $articleDetails
     * @author N/A
     * @return Bool it returns boolean true if all articles stored successfully otherwise returns false
     */
    public function storeArticles(array $articleDetails) 
    {
        News::truncate();
        return News::insert($articleDetails);
    }
    /**
     * This function is responsible to search articles from system database.
     *
     * @param array $filterOptions
     * @author N/A
     * @return \Illuminate\Http\Response
     */
    public function searchArticles(array $filterOptions) 
    {
        $articles = News::select('*');
        if(isset($filterOptions['search_query'])){
            $searchQuery = $filterOptions['search_query'];
            $articles->where(function($q) use($searchQuery){
                $q->where('source_id','LIKE','%'.$searchQuery.'%')
                  ->orWhere('source_name','LIKE','%'.$searchQuery.'%')
                  ->orWhere('author','LIKE','%'.$searchQuery.'%')
                  ->orWhere('title','LIKE','%'.$searchQuery.'%')
                  ->orWhere('description','LIKE','%'.$searchQuery.'%')
                  ->orWhere('content','LIKE','%'.$searchQuery.'%');
            });
        }
        if(isset($filterOptions['date'])){
            $articles->whereDate('published_at',$filterOptions['date']);
        }
        if(isset($filterOptions['source'])){
            $sourceNames = explode(",",$filterOptions['source']);
            $articles->whereIn('source_name',$sourceNames);
        }
        if(isset($filterOptions['authors'])){
            $authorNames = explode(",",$filterOptions['authors']);
            $articles->whereIn('author',$authorNames);
        }
        return $articles->paginate(10);
    }
}
