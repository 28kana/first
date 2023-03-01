@extends('layouts.app')

@section('content')

@if (session('err_msg'))
  <p class="text-danger">
   {{ session('err_msg') }}
  </p>
@endif

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('product.create') }}" class="btn btn-outline-secondary" role="button">
                <i class="fa fa-reply mr-1 " aria-hidden="true"></i>{{ __('新規登録') }}</a>
  </div>

<h1>商品情報一覧</h1>

<br>
<div>
  <form action="{{ route('product.index') }}" method="GET">
  <label for="company_id">{{ __('商品名') }}<span class="badge badge-danger ml-2"></span></label>
    <input type="text" name="keyword" value="{{ $keyword }}">
    <input type="submit" value="検索">
  </form>
</div>

<div>
 <form action="{{ route('product.index') }}" method="GET">
  <label for="company_id">{{ __('企業名') }}<span class="badge badge-danger ml-2"></span></label>
            <select name ="company_id" id ="company_id">
                <option value = "">選択してください</option>
                <option value = "1">リラクス</option>
                <option value = "2">エリン</option>
                <option value = "3">シティショップ</option>
            </select>
    <input type="submit" value="検索">
 </form>
</div>

 <table class ="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>企業名</th>
            <th>詳細</th>
            <th>削除</th>
         </tr>
        </thead>
        <tbody>
        @foreach( $products as $product )
            
            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset('storage/'.$product->img_path) }}" width="150" height="150"></td>
                <td>{{ $product->product_name}}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company->company_name }}</td>
                <td><a href="{{ route('product.show', $product) }}" class="btn btn-primary">詳細</a></td>
                <td> 
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <input type="submit" value="削除" class="btn btn-danger" onclick='return confirm("削除しますか？");'>
                 </form>
                </td> 
            

            </tr>

        @endforeach
      </tbody>
    </table> 
@endsection
 
