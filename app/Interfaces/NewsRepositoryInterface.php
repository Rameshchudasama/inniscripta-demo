<?php

namespace App\Interfaces;

interface NewsRepositoryInterface 
{
    public function storeArticles(array $articleDetails);

    public function searchArticles(array $filterOptions);
}