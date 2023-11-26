<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewYorkTimes extends Model
{
    use HasFactory;

    protected $table = "new_york_times_articles";

    public function keywords(){
        return $this->hasMany("App\Models\NewYorkTimesArticleKeywords","article_id","id");
    }
}
