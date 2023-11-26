<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Http;

class NewsApiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsapi:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch an articles from newsapi and store it in database';


    protected $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->newsRepository = $newsRepository;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiResponse = Http::get(env('NEWSAPI_URL').'everything?q=apple&sortBy=popularity&apiKey='.env('NEWSAPI_KEY'));
        $response = json_decode($apiResponse->body());
        $articles = [];
        if($response->status == "ok"){
            foreach($response->articles as $key => $value){
                $articles[$key]['source_id'] = $value->source->id;
                $articles[$key]['source_name'] = $value->source->name;
                $articles[$key]['author'] = $value->author;
                $articles[$key]['title'] = $value->title;
                $articles[$key]['description'] = $value->description;
                $articles[$key]['url'] = $value->url;
                $articles[$key]['url_to_image'] = $value->urlToImage;
                $articles[$key]['published_at'] = date("Y-m-d h:i:s",strtotime($value->publishedAt));
                $articles[$key]['content'] = $value->content;
            }
        }
        if(!empty($articles)){
            $this->newsRepository->storeArticles($articles);
        }
    }
}
