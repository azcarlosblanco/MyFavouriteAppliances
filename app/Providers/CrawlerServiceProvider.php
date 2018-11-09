<?php

namespace App\Providers;

use App\Services\Contracts\CrawlerServiceContract;
use App\Services\CrawlerService;
use Illuminate\Support\ServiceProvider;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;

class CrawlerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CrawlerServiceContract::class, function() {
            $goutteClient = new GoutteClient();
            $guzzleClient = new GuzzleClient();

            return new CrawlerService($goutteClient, $guzzleClient);
        });
    }
}
