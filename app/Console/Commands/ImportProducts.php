<?php

namespace App\Console\Commands;

use App\Category;
use App\Product;
use App\Services\Contracts\CrawlerServiceContract;
use App\Services\CrawlerService;
use Illuminate\Console\Command;

class ImportProducts extends Command
{

    /**
     * @var CrawlerService
     */
    private $crawlerService;

    /**
     * @var array
     */
    private $categoriesUrls = [
        'audio'                => 'https://www.appliancesdelivered.ie/search/small-appliances/audio',
        'coffee-machines'      => 'https://www.appliancesdelivered.ie/search/small-appliances/coffee-machines',
        'dishwashers'          => 'https://www.appliancesdelivered.ie/search/dishwashers',
        'essentials'           => 'https://www.appliancesdelivered.ie/search/small-appliances/essentials',
        'food-preparation'     => 'https://www.appliancesdelivered.ie/search/small-appliances/food-preparation',
        'heating'              => 'https://www.appliancesdelivered.ie/search/small-appliances/heating',
        'irons'                => 'https://www.appliancesdelivered.ie/search/small-appliances/irons',
        'kettles-and-toasters' => 'https://www.appliancesdelivered.ie/search/small-appliances/kettles-and-toasters',
        'microwaves'           => 'https://www.appliancesdelivered.ie/search/small-appliances/microwaves',
        'personal-care'        => 'https://www.appliancesdelivered.ie/search/small-appliances/personal-care',
        'small-cooking'        => 'https://www.appliancesdelivered.ie/search/small-appliancess/small-cooking'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from www.appliancesdelivered.ie';

    /**
     * Create a new command instance.
     *
     * @param CrawlerServiceContract $crawlerService
     * @return void
     */
    public function __construct(CrawlerServiceContract $crawlerService)
    {
        $this->crawlerService = $crawlerService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bar = $this->output->createProgressBar(count($this->categoriesUrls));

        foreach ($this->categoriesUrls as $category => $url) {
            $this->info(' - Importing products from category ' . $category);

            $items = $this->crawlerService->fetch($url);

            $categoryId = Category::whereSlug($category)->first()->id;

            $categorizedItems = array_map(function($item) use ($categoryId){
                $item['category_id'] = $categoryId;
                return $item;
            }, $items);

            //Product::insert($categorizedItems);

            foreach ($categorizedItems as $item) {
                Product::updateOrCreate(
                    ['source_id' => $item['source_id']],
                    $item
                );
            }

                $bar->advance();
        }

        $this->info("\nImporting process has finished");

    }
}
