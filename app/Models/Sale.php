<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table ='sales';

    protected $fillable =[
        'product_id'
    ];

    public static function newSale($id){
        $sale = new Sale();
        $sale->product_id = $id;
        $sale->save();
    }
}
