<?php


namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
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
        // dd($request);
        $products = Product::all();
        $keyword = $request->input('keyword');
        $products = Product::newsearchProduct($products,$request);
        $products = Product::sortable()->get();
        // dd($request);
        return view('product.index',compact('products','keyword'));
        // return view('product.index',compact('products'));


    }

    //検索
    public function search(Request $request){
        // dd($request);
        $products = Product::searchProduct($products,$request);
        $keyword = $request->input('keyword');
        $json[] = $products;
        $products = Company::all();
        $json[] = $companirs;
        return response()->json($json);
        return view('product.index')->with('product',$product);

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
    
        return redirect(route('product.index'));


       
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
        $product = Product::find($id);
        $product->delete();
        try{
            $product = Product::destroy($id);
        } catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg',config('message.Products.DELETE_MSG'));
        return redirect()->route('product.index',config('product','delete'));

        $products = Product::all();
        $json[] = $products;
        $companies = Company::all();
        $json[] = $companies;
        return response()->json($json);
        
    }
    //決済
    // public function pay(Request $request){

    //     try
    //     {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));

    //         $customer = Customer::create(array(
    //             'email' => $request->stripeEmail,
    //             'source' => $request->stripeToken
    //         ));

    //         $charge = Charge::create(array(
    //             'customer' => $product->id,
    //             'amount' => 1000,
    //             'currency' => 'jpy'
    //         ));

    //         return redirect(route('product.show',['id' => $product->id]));
    //     }
    //     catch(Exception $e)
    //     {
    //      \Session::flash('err_msg',config('message.Products.STOCK_MSG'));
    //     }
    // }
    

    public function pay($id){

        $product = Product::find($id);
        if($product->stock > 0){
            // Stripe::setApiKey(env('STRIPE_SECRET'));//シークレットキー
    
        //   $charge = Charge::create(array(
        //        'amount' => $product->price,
        //        'currency' => 'jpy',
        //        'source'=> request()->stripeToken,
        //    ));
        //      $charge = Charge::create(array(
        //           'amount' => 100,
        //           'currency' => 'jpy',
        //           'source'=> request()->stripeToken,
        // ));

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

