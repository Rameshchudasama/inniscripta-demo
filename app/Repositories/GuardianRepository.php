<?php

namespace App\Repositories;

use App\Interfaces\NewsRepositoryInterface;
use App\Models\Guardian;

class GuardianRepository implements NewsRepositoryInterface 
{

    /**
     * This function is responsible to store articles from guardian.
     *
     * @param array $articleDetails
     * @author N/A
     * @return Bool it returns boolean true if all articles stored successfully otherwise returns false
     */
    public function storeArticles(array $articleDetails) 
    {
        Guardian::truncate();
        return Guardian::insert($articleDetails);
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
        $articles = Guardian::select('*');
        if(isset($filterOptions['search_query'])){
            $searchQuery = $filterOptions['search_query'];
            $articles->where(function($q) use($searchQuery){
                $q->where('type','LIKE','%'.$searchQuery.'%')
                  ->orWhere('section_id','LIKE','%'.$searchQuery.'%')
                  ->orWhere('section_name','LIKE','%'.$searchQuery.'%')
                  ->orWhere('web_title','LIKE','%'.$searchQuery.'%')
                  ->orWhere('pillar_id','LIKE','%'.$searchQuery.'%')
                  ->orWhere('pillar_name','LIKE','%'.$searchQuery.'%');
            });
        }
        if(isset($filterOptions['date'])){
            $articles->whereDate('web_publication_date',$filterOptions['date']);
        }
        if(isset($filterOptions['source'])){
            $sourceNames = explode(",",$filterOptions['source']);
            $articles->whereIn('section_name',$sourceNames);
        }
        return $articles->paginate(10);
    }
}
