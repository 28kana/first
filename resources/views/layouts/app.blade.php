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
    <script src="{{ asset('js/product.js') }}" defer></script>

<script>
    $(function(){
  console.log('テスト');
    buttonclick();
    delete_data();
});

function buttonclick(){
    $('#getProduct').on('click', function() {
    console.log('テスト');
     let serch_keyword = $('#keyword').val();
     let serch_id = $('#company_id').val();
     console.log(serch_keyword);
     console.log(serch_id);
      if(!serch_keyword) {
         serch_keyword = null;
      
        }

        $.ajax({

        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         },
          url: '/search/' + serch_keyword + '/'+ serch_id,
          type: 'GET',
          data: {'keyword': serch_keyword,
                 'company_id': serch_id,
                 },
          dataType: 'json',
        })
  
       .done(function(data) {
        alert('成功');
        get_value(data);

        })
  
       .fail(function(jqXHR,textStatus,errorThorown) {
          alert('エラー');
        });
    })
};
//削除

function delete_data(){
  console.log('テスト');
    $('#deleteTarget').on('click', '[id=deteleTarget]',function() {
      let deleteConfirm = confirm('削除してよろしいでしょうか？');
      let clickEle;
      let data_id;
      if(deleteConfirm == true) {
         clickEle = $(this)
         data_id = clickEle.attr('data-id');
      }else{
        return false;
      }
  
        $.ajax({

        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
         },
          url: '/destroy/' + data_id,
          type: 'POST',
          data: {'id': data_id,
                 '_method': 'DELETE'},
        })
  
       .done(function(data) {
        console.log('成功');
        get_value(data);
        })
  
       .fail(function(jqXHR,textStatus,errorThorown) {
          alert('エラー');
        });
    })
};

function  get_value(data){
$('#table #product_tr').empty();
$.each(data[0],function (key,value){
  let id = value.id;
  let name =value.product_name;
  let company =value.company_id;

  $.each(date[1],function(key,value){
    if(company== value.id){
      company = value.company_name;

    }
  })
  let price = value.price;
  let stock = value.stock;
  let comment = value.comment;
  let img_path = value.img_path;
  if(comment == null){
    comment = "なし";
  }
  txt =
    <tr id="product_tr">
    <th scope="row">$(id)</th>
    <td>$(name)</td>
    <td>$(company)</td>
    <td>$(price)</td>
    <td>$(stock)</td>
    <td>$(comment)</td>

    if(img_path != null){
      txt +=
      <td id="img_path"><img src="storage/${img_path}" width="150" height="150" /></td>
    }else{
      txt +=
      <td id="img_path">画像なし</td>
    }
    txt +=
    
    <td><button type="button" class="btn btn-primary" onclick="location.href='product/{{ $product->id }}">詳細</button></td>
    <td><button type="button" class="btn btn-danger"  id="deleteTarget" data-id="$(id)">削除</button></td>
  
  </tr>
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
