
$(function(){
  // console.log('テスト');
    buttonclick();
    delete_data();
});

function buttonclick(){
    $('#get_product').on('click', function() {
    // console.log('テスト');
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
  // console.log('テスト');
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
