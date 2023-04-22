@extends('layouts.app')

@section('content')

@if (session('err_msg'))
  <p class="text-danger">
   {{ session('err_msg') }}
  </p>
@endif

<h1>詳細</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>商品ID</th>
      <th>商品画像</th>
      <th>商品名</th>
      <th>企業名</th>
      <th>価格</th>
      <th>在庫数</th>
      <th>コメント</th>
      <th>編集</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ $product->id}}</td>
      <td><img src="{{ asset('storage/'.$product->img_path) }}" width="150" height="150"></td>
      <td>{{ $product->product_name }}</td>
      <td>{{ $product->company->company_name }}</td>
      <td>{{ $product->price }}</td>
      <td>{{ $product->stock }}</td>
      <td>{{ $product->comment }}</td> 
      @if (!Auth::guest())
      <td><a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">編集</a></td>
      <td><form action="{{ route('product.pay',$product->id) }}" method="POST" class="form-horizontal">
      {{ csrf_field() }}
      <button type="submit" name="pay">決済</button>
      </form>
      </td>
      @endif
      
     
      <div class="d-flex justify-content-between pt-3">
        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary" role="button">
            <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('戻る') }}
        </a>
    </tbody>
</table>
@endsection