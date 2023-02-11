@extends('layouts.app')

@section('content')
<div class="container small">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <h1>新規登録</h1>
  <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" >
  @csrf
    <fieldset>
        <div class="form-group">
            <label for="product_name">{{ __('商品名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="product_name" id="product_name" value="{{old('product_name')}}" placeholder="商品名を入力してください">
        
            <label for="company_id">{{ __('企業名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <select name ="company_id" id ="company_id" value="{{old('company_id')}}">
                <option value = "">選択してください</option>
                <option value = "1">リラクス</option>
                <option value = "2">エリン</option>
                <option value = "3">シティショップ</option>
            </select>
            
            <br>
            <label for="price">{{ __('価格') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="price" id="price" value="{{old('price')}}" placeholder="価格を入力してください">
            </br>
            <label for="stock">{{ __('在庫数') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="stock" id="stock" value="{{old('stock')}}" placeholder="在庫数を入力してください">

            <label for="comment">{{ __('コメント') }}</label>
            <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="コメントを入力してください" ></textarea >

            <label for="img_path">{{ __('商品画像') }}</label>
            <input type="file" name="img_path" class="form-control" id = "img_path">
            
        <div class="d-flex justify-content-between pt-3">
            <a href="{{ route('product.index') }}" class="btn btn-outline-secondary" role="button">
                <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('戻る') }}
            </a>
            <button type="submit" class="btn btn-success">
                {{ __('登録') }}
            </button>
        </div>
    </fieldset>
  </form>
</div>
@endsection