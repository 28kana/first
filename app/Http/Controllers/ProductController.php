<?php


namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller

{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    //一覧
    public function index(Request $request) {

        $products = Product::all();

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

        return view('product.index',compact('products','keyword','company_id'));
      
      

    }

    //新規登録
    public function create(Request $request){
        return view('product.create');
    }

    //登録処理
    public function store(ProductRequest $request){

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
            };  
        
        \DB::beginTransaction();
        try{
            $inputs->save();
            \DB::commit();
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg',config('message.Products.REGISTRATION_MSG'));
    
        return redirect(route('product.index'))->with('success','新規登録完了');


       
    }



    //詳細
    public function show(Product $product)
    {

        return view('product.show', compact('product'));
    }

    //編集
    public function edit($id)
    {
        $product = Product::find($id);
        // if (auth()->user()->id != $product->user_id) {
        //     return redirect(route('product.show'))->with('error', '許可されていない操作です');
        // }
        return view('Product.edit', compact('product'));

    }

    //更新
    public function update(ProductRequest $request)
    {
        $product = Product::find($request->id);

        // if (auth()->user()->id != $product->user_id) {
        //     return redirect(route('product.show'))->with('error', '許可されていない操作です');
        // }
        $product->company_id =  $request->company_id;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->comment = $request->comment;

        if($product->img_path){
            $path = $request->file('img_path')->store('public');
            $file_name = basename($path);
            $product->img_path = $file_name;
        };  
        
        \DB::beginTransaction();
        try{
            $product->save();
            \DB::commit();
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg',config('message.Products.REGISTRATION_MSG'));


            return redirect(route('product.index'))->with('success','更新しました');
        }

    

    //削除
    public function destroy($id)
    {   
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', '削除しました');
        ;
    }

   
}
