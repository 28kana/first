<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Kyslik\ColumnSortable\Sortable;
use DB;

class Product extends Model
{
    use Sortable;
    public $sortable = ['id','product_name','price','stock','company_id'];


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
     public static function newsearchProduct($products,$request){
       
        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');
        $upper = $request->input('upper'); //最大値
        $lower = $request->input('lower'); //最小値
        $high = $request->input('high'); //最大値
        $low = $request->input('low'); 
        $query = DB::table('products')->join('companies','companies.id','products.company_id');

        if(!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
               
        }

        if(!empty($company_id)) {
            $query->where('company_id', 'LIKE', $company_id);
        }

        if(!empty($upper)) {
            $query->where('price', '>=', $upper);
        }

        if(!empty($lower)) {
            $query->where('price', '<=', $lower);
        }

        if(!empty($high)) {
            $query->where('stock', '>=', $high);
        }

        if(!empty($low)) {
            $query->where('stock', '<=', $low);
        }


        $products = $query->get();

        return $products;
    }

}