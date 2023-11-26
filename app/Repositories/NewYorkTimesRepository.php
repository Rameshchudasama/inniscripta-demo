<?php

namespace App\Repositories;

use App\Interfaces\NewsRepositoryInterface;
use App\Models\NewYorkTimes;
use App\Models\NewYorkTimesArticleKeywords;

class NewYorkTimesRepository implements NewsRepositoryInterface 
{
    /**
     * This function is responsible to store articles from new york times api.
     *
     * @param array $articleDetails
     * @author N/A
     * @return Bool it returns boolean true if all articles stored successfully otherwise returns false
     */
    public function storeArticles(array $articleDetails) 
    {
        NewYorkTimes::truncate();
        return NewYorkTimes::insert($articleDetails);
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
        $articles = NewYorkTimes::select('*');
        if(isset($filterOptions['search_query'])){
            $searchQuery = $filterOptions['search_query'];
            $articles->where(function($q) use($searchQuery){
                $q->where('snippet','LIKE','%'.$searchQuery.'%')
                  ->orWhere('lead_paragraph','LIKE','%'.$searchQuery.'%')
                  ->orWhere('source','LIKE','%'.$searchQuery.'%')
                  ->orWhere('headline','LIKE','%'.$searchQuery.'%')
                  ->orWhere('document_type','LIKE','%'.$searchQuery.'%')
                  ->orWhere('news_desk','LIKE','%'.$searchQuery.'%')
                  ->orWhere('section_name','LIKE','%'.$searchQuery.'%')
                  ->orWhere('subsection_name','LIKE','%'.$searchQuery.'%')
                  ->orWhere('byline','LIKE','%'.$searchQuery.'%')
                  ->orWhere('type_of_material','LIKE','%'.$searchQuery.'%');
            });
        }
        if(isset($filterOptions['date'])){
            $articles->whereDate('publication_date',$filterOptions['date']);
        }
        if(isset($filterOptions['source'])){
            $sourceNames = explode(",",$filterOptions['source']);
            $articles->whereIn('source',$sourceNames);
        }
        if(isset($filterOptions['authors'])){
            $authorNames = explode(",",$filterOptions['authors']);
            $articles->whereIn('byline',$authorNames);
        }
        return $articles->paginate(10);
    }
}
