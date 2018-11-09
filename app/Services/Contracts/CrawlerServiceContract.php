<?php

namespace App\Services\Contracts;


interface CrawlerServiceContract
{
    public function fetch(string $url);
}