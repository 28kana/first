<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;


class Product extends Model
{
    public function user(){
        return $this->belongsTo('App\User');//リレーション

    }
    protected $table = 'products';


    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path'
        
    ];

    public function company(){
        return $this ->belongsTo('App\Models\Company');
    }
    // protected $primaryKey ='product_name';

    
    //全件取得
    public function findAllProducts(){
        return Product::all();
    }
    //レコード１件取得
    public function findProductkById($id)
    {
        return Product::find($id);
    }
    //登録
    // public function create($request)
    // {

    //         $inputs = new Product();
    //         $inputs->company_id =  $request->company_id;
    //         $inputs->product_name = $request->product_name;
    //         $inputs->price = $request->price;
    //         $inputs->stock = $request->stock;
    //         $inputs->comment = $request->comment;

    //         if($request->img_path){
    //             $path = $request->file('img_path')->store('public');
    //             $file_name = basename($path);
    //             $inputs->img_path = $file_name;
    //         }
    //     return $inputs;
    // }
    // public function create($inputs) {
    //     // 登録処理
        // DB::table('products')->insert([
        //     'company_id' => $inputs->company_id,
        //     'product_name' => $inputs->product_nanme,
        //     'price' => $inputs->price,
        //     'stock' => $inputs->stock,
        //     'comment' => $inputs->comment,

            
        // ]);

        // if($request->img_path){
        //     $path = $request->file('img_path')->store('public');
        //      $file_name = basename($path);
        //      $inputs->img_path = $file_name;
        //  };  
    // }

      //更新
    // public function Productupdate($request)
    // {
    //     $product = Product::find($request->id);
    //     if($request->img_path){
    //         $path = $request->file('img_path')->store('public');
    //         $file_name = basename($path);
    //         $product->fill(['img_path' => $file_name]);
    //     }
    //     $product->fill([
    //         'company_id' => $request->company_id,
    //         'product_name' => $request->product_name,
    //         'price'=>$request->price,
    //         'stock'=>$request->stock,
    //         'comment'=>$request->comment,
            
    //     ])->save();

    //     return $result;
    // }

    //削除処理
    public function deleteProductById($id)
    {
        return $this->destroy($id);
    }
}