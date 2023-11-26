<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\NewYorkTimesRepository;
use Illuminate\Support\Facades\Http;

class NewYorkTimesApiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newyorktimesapi:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $newYorkTimeRepository;

    public function __construct(NewYorkTimesRepository $newYorkTimeRepository)
    {
        parent::__construct();
        $this->newYorkTimeRepository = $newYorkTimeRepository;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiResponse = Http::get(env('NEW_YORK_TIMES_URL').'articlesearch.json?sort=newest&api-key='.env('NEW_YORK_TIMES_API_KEY'));
        $response = json_decode($apiResponse->body());
        $articles = [];
        if($response->status == "OK"){
            foreach($response->response->docs as $key => $value){
                $articles[$key]['web_url'] = $value->web_url;
                $articles[$key]['snippet'] = $value->snippet;
                $articles[$key]['lead_paragraph'] = $value->lead_paragraph;
                $articles[$key]['source'] = $value->source;
                $articles[$key]['headline'] = $value->headline->main;
                $articles[$key]['publication_date'] = date("Y-m-d h:i:s",strtotime($value->pub_date));
                $articles[$key]['document_type'] = $value->document_type;
                $articles[$key]['news_desk'] = $value->news_desk;
                $articles[$key]['section_name'] = $value->section_name;
                $articles[$key]['subsection_name'] = isset($value->subsection_name) ? $value->subsection_name : null;
                $articles[$key]['byline'] = $value->byline->original;
                $articles[$key]['type_of_material'] = $value->type_of_material;
                $articles[$key]['word_count'] = $value->word_count;
                $articles[$key]['uri'] = $value->uri;
            }
        }
        if(!empty($articles)){
            $this->newYorkTimeRepository->storeArticles($articles);
        }
    }
}
