<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Config;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;


class ProductController extends Controller

{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    //一覧
    public function index(Request $request) {

        $products = Product::all();
        $companies = Company::all();
        $keyword = $request->input('keyword');
        $products = Product::sortable()->get();
        
        return view('product.index',compact('products','keyword'));


    }

    //検索
    public function search(Request $request){
        $products = Product::all();
        $keyword = $request->input('keyword');
        $products = Product::newsearchProduct($products,$request);

        $json[] = $products;

        return response()->json($json);

    }

    //新規登録
    public function create(Request $request){
        return view('product.create');
    }

    //登録処理
    public function store(ProductRequest $request){
        
        $inputs = Product::newProduct($request);
        \DB::beginTransaction();
        try{
            $inputs->save();
            \DB::commit();
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg',config('message.Products.REGISTRATION_MSG'));
    
        return redirect(route('product'));


       
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
        
        return view('Product.edit', compact('product'));

    }

    //更新
    public function update(ProductRequest $request)
    {
        
        $product = Product::updateProduct($request);
        \DB::beginTransaction();
        try{
            $product->save();
            \DB::commit();
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg',config('message.Products.UPDATE_MSG'));

            return redirect(route('product.index'));

        }

    

    //削除
    public function destroy($id)
    {   
    
        try{
            $product = Product::destroy($id);
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg',config('message.Products.DELETE_MSG'));
        return response()->json(['result' => '成功']);
        
    }
    //決済
    public function pay($id){

        $product = Product::find($id);
        if($product->stock > 0){
    
           $product->stock--;
           $product->save();

           Sale::newSale($product->id);
           \DB::commit();
           
        }else{
            \Session::flash('err_msg',config('message.Products.STOCK_MSG'));
        }
        
        \Session::flash('err_msg',config('message.Products.PAY_MSG'));
        return redirect(route('product.show',$product->id));
        }
    }

