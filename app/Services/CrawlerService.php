<?php

namespace App\Services;

use App\Services\Contracts\CrawlerServiceContract;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class CrawlerService implements CrawlerServiceContract
{
    /**
     * @var GoutteClient
     */
    private $goutteClient;
    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * Crawler constructor.
     * @param GoutteClient $goutteClient
     * @param GuzzleClient $guzzleClient
     * @param Recipe $recipe
     */
    public function __construct(GoutteClient $goutteClient, GuzzleClient $guzzleClient)
    {
        $this->goutteClient = $goutteClient;
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $url
     * @return array
     */
    public function fetch(String $url)
    {
        $request = $this->goutteClient->request('GET', $url);

        $items = $this->extract($request);

        while ($this->hasMorePages($request)) {
            $nextPageLink = $request->selectLink('next')->link();

            $request = $this->goutteClient->request('GET', $nextPageLink->getUri());

            $items = array_merge($this->extract($request), $items);
        }

        return $items;
    }

    /**
     * @param DomCrawler $crawler
     * @return array
     */
    protected function extract(DomCrawler $crawler)
    {
        return $crawler->filter('.search-results-product')->each(function (DomCrawler $crawler) {

            $url = $crawler->filter('h4 a')->first()->attr('href');
            $urlPieces = explode('/', $url);
            $name = $crawler->filter('h4 a')->first()->html();
            $price = $crawler->filter('.section-title')->first()->html();
            $imageUrl = $crawler->filter('.product-image img')->first()->attr('src');

            return array(
                'source_id' => array_pop($urlPieces),
                'product_name' => $name,
                'image_url' => $imageUrl,
                'product_price' => (float) str_replace(array('$','€','£'),'', $price)
            );
        });
    }

    /**
     * @param DomCrawler $crawler
     * @return bool
     */
    protected function hasMorePages(DomCrawler $crawler)
    {
        try {
            return $crawler->filterXPath("//a[text()='next']")->first()->html() === 'next';
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }
}