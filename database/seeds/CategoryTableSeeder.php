<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = array(
            array("category_name" => "Audio", "slug" => "audio"),
            array("category_name" => "Coffee Machines", "slug" => "coffee-machines"),
            array("category_name" => "Dishwashers", "slug" => "dishwashers"),
            array("category_name" => "Essentials", "slug" => "essentials"),
            array("category_name" => "Food Preparation", "slug" => "food-preparation"),
            array("category_name" => "Heating", "slug" => "heating"),
            array("category_name" => "Irons", "slug" => "irons"),
            array("category_name" => "Kettles And Toasters", "slug" => "kettles-and-toasters"),
            array("category_name" => "Microwaves", "slug" => "microwaves"),
            array("category_name" => "Personal Care", "slug" => "personal-care"),
            array("category_name" => "Small Cooking", "slug" => "small-cooking"),
        );

        foreach ($categories as $category)
        {
            Category::create($category);
        }
    }
}
