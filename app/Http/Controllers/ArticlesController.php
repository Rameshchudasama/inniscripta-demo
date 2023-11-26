<?php

namespace App\Http\Controllers;

use App\Repositories\NewsRepository;
use App\Repositories\GuardianRepository;
use App\Repositories\NewYorkTimesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticlesController extends Controller
{
    protected $newsRepository;
    protected $guardianRepository;
    protected $newYorkTimesRepository;

    public function __construct(
        NewsRepository $newsRepository, 
        GuardianRepository $guardianRepository, 
        NewYorkTimesRepository $newYorkTimesRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->guardianRepository = $guardianRepository;
        $this->newYorkTimesRepository = $newYorkTimesRepository;
    }

    /**
     * This function is responsible to search articles by search query, filtering criteria and user preferences.
     *
     * @param object $request
     * @author N/A
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = $this->getArticles($request->all());
        if(count($articles)){
            $data = ['status' => 200,'message' => "Articles found successfully",'articles' => $articles];
        }else{
            $data = ['status' => 400,'message' => "No articles found",'articles' => []];
        }
        return response()->json($data);
    }
    /**
     * This function is responsible to search articles from news api, guardian api and new york times data.
     *
     * @param array $filterOptions
     * @author N/A
     * @return \Illuminate\Http\Response
     */
    public function getArticles($filterOptions){
        switch ($filterOptions['api_source']) {
            case 1: /** Get Articles From New Api Data */
                $response = $this->newsRepository->searchArticles($filterOptions);
                break;
            case 2: /** Get Articles From Guardian Api Data */
                $response = $this->guardianRepository->searchArticles($filterOptions);
                break;
            case 3: /** Get Articles From New York Times Api Data */
                $response = $this->newYorkTimesRepository->searchArticles($filterOptions);
                break;
        }
        return $response;
    }
}
