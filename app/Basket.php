<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Basket extends Model
{
    protected $table = "baskets";

    protected $guarded = [];

    public function basket_products()
    {
        return $this->hasMany('App\BasketProduct');
    }

    public function basket_product_qty()
    {
        return DB::table('basket_products')->where('basket_id', $this->id)->sum('quantity');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
