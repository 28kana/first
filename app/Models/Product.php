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
        public static function newProduct($request){
        $inputs = new Product();
        $inputs->company_id =  $request->company_id;
        $inputs->product_name = $request->product_name;
        $inputs->price = $request->price;
        $inputs->stock = $request->stock;
        $inputs->comment = $request->comment;
        

         if($request->img_path){
                $path = $request->file('img_path')->store('public');
                $file_name = basename($path);
                $inputs->img_path = $file_name;
            }
         return $inputs;
         }

         public static function updateProduct($request){
            $product = Product::find($request->id);
            if($request->img_path){
                $path = $request->file('img_path')->store('public');
                $file_name = basename($path);
                $product->fill(['img_path' => $file_name]);
            }  
            $product->fill([
            'company_id' =>  $request->company_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment
            ]);
           
             return $product;
              }
     
    //削除処理
    public function deleteProductById($id)
    {
        return $this->destroy($id);
    }

    //検索
    public static function serchProduct($products,$request){

        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');

        $query = Product::query();

        if(!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
               
        }

        if(!empty($company_id)) {
            $query->where('company_id', 'LIKE', $company_id);
        }

        $products = $query->get();

        return $products;
    }
}