<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- <script src="{{ asset('js/product.js') }}" defer></script> -->

<script>
// 画面ロード時に読み込まれる。
$(function() {
    console.log('test');
    $(document).ready(function() {
    // #getProductを押下するとイベント発火
    $('#getProduct').on('click', function() {
    console.log('テスト');
        let search_keyword = $('#keyword').val();
        let search_id = $('#company_id').val();
        let search_upper = $('#upper').val();
        let search_lower = $('#lower').val();
        let search_higt = $('#higt').val();
        let search_low = $('#low').val();

        console.log(search_keyword);
        console.log(search_id);
        console.log(search_upper);
        console.log(search_lower);
        console.log(search_higt);
        console.log(search_low);

        if (!search_keyword) {
         search_keyword = null;
      
    }
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    $.ajax({

    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
    },
        url: '/search',
        type: 'GET',
        data: {'keyword': search_keyword,
                'company_id': search_id,
                'upper': search_upper,
                'lower': search_lower,
                'higt': search_higt,
                'low': search_low,
                },
    })

    .done(function(data) {
        console.log("OK");
        get_value(data);

    })

    .fail(function(jqXHR,textStatus,errorThorown) {
        alert('エラー');
    });
    })
        
    })
});
//削除
    $(function() {
    console.log('テスト');
    $(document).ready(function() {
    // .deleteTargeを押下するとイベント発火
    $('.deleteTarget').on('click', function() {
        console.log('きた！'); 
      let deleteConfirm = confirm('削除してよろしいでしょうか？');
      let clickEle;
      let data_id;
      if(deleteConfirm == true) {
         clickEle = $(this)
         data_id = clickEle.attr('data-id');
      }else{
        return false;
      }
    console.log(clickEle);
    console.log(data_id);
    
        $.ajax({

        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         },
          url: '/destroy/' + data_id,
          type: 'GET',
          data: {'id': data_id,
                 '_method': 'DELETE'},
        })
  
       .done(function(data) {
        console.log('成功');
        //削除の行を削除する
        clickEle.parents('tr').remove();
        
        })
  
       .fail(function(jqXHR,textStatus,errorThorown) {
          alert('エラー');
        });
    })
})
});


function get_value(data){
console.log('飛んでる！');
$('#table #product_tr').empty();
console.log(data);
$.each(data[0],function (key,value){
  console.log(key);  
  let id = value.id;
  let name =value.product_name;
  let company_name =value.company_name;
  let price = value.price;
  let stock = value.stock;
  let img_path = value.img_path;

  txt =`
    <tr id="product_tr">
    <th>${id}</th>
    <td id="img_path"><img src="storage/${img_path}" width="150" height="150" /></td>
    <td>${name}</td>
    <td>${price}</td>
    <td>${stock}</td>
    <td>${company_name}</td>
    `

    txt +=`
    <td><button type="button" class="btn btn-primary" onclick="location.href='product/${id}'">詳細</button></td>
    <td><button type="button" class="btn btn-danger"  id="deleteTarget" data-id="${id}">削除</button></td>
  
  </tr>`
  $('#table').append(txt);
})
}
</script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
        <div class="container">
                @include('inc.msg')
            </div>
            @yield('content')
        </main>
    </div>
</body>
</html>
