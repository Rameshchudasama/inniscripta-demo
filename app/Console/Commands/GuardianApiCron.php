<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\GuardianRepository;
use Illuminate\Support\Facades\Http;

class GuardianApiCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guardianapi:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $guardianRepository;

    public function __construct(GuardianRepository $guardianRepository)
    {
        parent::__construct();
        $this->guardianRepository = $guardianRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiResponse = Http::get(env('GUARDIAN_URL').'search?order-by=newest&page-size=200&api-key='.env('GUARDIAN_API_KEY'));
        $response = json_decode($apiResponse->body());
        $articles = [];
        if($response->response->status == "ok"){
            foreach($response->response->results as $key => $value){
                $articles[$key]['type'] = $value->type;
                $articles[$key]['section_id'] = $value->sectionId;
                $articles[$key]['section_name'] = $value->sectionName;
                $articles[$key]['web_publication_date'] = date("Y-m-d h:i:s",strtotime($value->webPublicationDate));
                $articles[$key]['web_title'] = $value->webTitle;
                $articles[$key]['web_url'] = $value->webUrl;
                $articles[$key]['api_url'] = $value->apiUrl;
                $articles[$key]['is_hosted'] = $value->isHosted;
                $articles[$key]['pillar_id'] = isset($value->pillarId) ? $value->pillarId : null;
                $articles[$key]['pillar_name'] = isset($value->pillarName) ? $value->pillarName : null;
            }
        }
        if(!empty($articles)){
            $this->guardianRepository->storeArticles($articles);
        }
    }
}
