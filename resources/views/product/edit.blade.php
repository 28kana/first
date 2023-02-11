@extends('layouts.app')

@section('content')
<div class="container small">
  <h1>編集</h1>
  <form action="{{ route('update') }}" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="{{ $product->id }}">
  @csrf
    <fieldset>
      <div class="form-group">
      <label for="product_name">{{ __('商品名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
      <input type="text" class="form-control" name="product_name" id="product_name" value="{{old('product_name') ?? $product->product_name}}" placeholder="商品名を入力してください">

            <label for="company_id">{{ __('企業名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <select name ="company_id" id ="company_id">
                <option value = "1" {{$product->company_id == '1'?'selected':''}}>リラクス</option>
                <option value = "2"{{$product->company_id == '2'?'selected':''}}>エリン</option>
                <option value = "3"{{$product->company_id == '3'?'selected':''}}>シティショップ</option>
            </select>

            <br>
            <label for="price">{{ __('価格') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="price" id="price" value="{{old('price')?? $product->price}}" placeholder="価格を入力してください">

            <label for="stock">{{ __('在庫数') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="stock" id="stock" value="{{old('stock')?? $product->stock}}" placeholder="在庫数を入力してください">

            <label for="comment">{{ __('コメント') }}</label>
            <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="コメントを入力してください" >{{$product->comment}}</textarea >
            
            <label for="imp_path">{{ __('商品画像') }}</label>
            <img src="{{ asset('storage/'.$product->img_path) }}"width="150" height="150">
            <input type="file" name="img_path" class="form-control" id = "img_path" value="{{old('img_path')?? $product->img_path }}">

      <div class="d-flex justify-content-between pt-3">
      <a href="{{ route('product.index') }}" class="btn btn-outline-secondary" role="button">
                <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('一覧画面へ戻る') }}
            </a>
        <button type="submit" class="btn btn-success">
            {{ __('更新') }}
        </button>
      </div>
    </fieldset>
  </form>
</div>
@endsection()