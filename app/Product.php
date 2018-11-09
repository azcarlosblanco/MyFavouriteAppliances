<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $guarded = [];


    protected $appends = ["thumbs"];

    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'product_name'
            ]
        ];
    }

    protected $casts = [
        'product_price' => 'float',
    ];

    public function categories()
    {
        return $this->belongsTo('App\Category','category_id','id');
    }

    public function getThumbsAttribute()
    {
        return '<img src="' . $this->image_url .'" class="img-thumbnail" width="100" />';
    }
}
