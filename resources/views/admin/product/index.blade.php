@extends('admin.app')
@section('main')
<div class="admin_default">
	<div class='carousel-header'>
		<span class="carousel_title">宜家/产品管理</span>
		<span><a class="btn_add_admin" href="{{url('/admin/product/add')}}" style="text-decoration:none;color:white;">新增</a></span>
	</div>
	<table class="table_style">
		<thead>
			<tr>	
				<th>头图</th>
				<th>产品名称</th>
				<th>年龄段</th>
				<th>场景</th>
				<th>价格</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<div id="pagnation" class='pagnation_style'></div>
</div>
<style type="text/css">
.knowledge-table-main-img img{
	width: 50px;
	height: 50px; 
}
a{
	text-decoration:none;
}
</style>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-product').addClass('active');
//初始化获取数据
function init(page) {
	$.ajax({
        type:'POST',
        url:dgurl('/admin/product/list/'+page),
        datatype:"json",
        success:function(data){
        	if(data.status==1){
        		$.each(data.data,function(key,val){
				    var link=dgurl('/admin/product/edit/'+val.id);
					var imgp = dgPicUrl(val.main_img);
	            	var imgAdd = "<td class='knowledge-table-main-img'><img class='pic-src' src='"+imgp+ "'></td>"
	            	var nameAdd ='<td class="list_code">'+val.name+'</td>';
	            	//var contentAdd='<td class="list_code">'+val.content+'</td>';
					var ageAdd ='<td class="list_code">'+val.age_name+'</td>';
	            	var roomAdd ='<td class="list_name">'+val.romm_name+'</td>';
	            	var priceAdd ='<td class="list_name">'+val.price+'</td>';
	            	//var item_numAdd ='<td class="list_name">'+val.item_num+'</td>';
	            	// var status='<td class="list_status">'+val.status+'</td>';
	            	var span='<a  class="list_edit"  href="'+link+'")">编辑</a>';
	            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
	            	var content = '<tr>'+imgAdd+nameAdd+ageAdd+roomAdd+priceAdd+'<td>'+span+'</td>'+'</tr>';
					$('.table_style tbody').append(content);
				});
                if (data.count>10) {
					$('#pagnation').bootpag({
						    total: Math.ceil(data.count/10),
						    maxVisible: 6,
	                }).on("page", function (event, num) {
	                    var nowpage = num-1; 
						$.ajax({
					        type:'POST',
					        url:dgurl('/admin/product/list/'+nowpage),
					        datatype:"json",
					        success:function(data){
					            if(data.status==1){
					            	$('tbody').empty();
									$.each(data.data,function(key,val){
									    var link=dgurl('/admin/product/edit/'+val.id);
										var imgp = dgPicUrl(val.main_img);
						            	var imgAdd = "<td class='knowledge-table-main-img'><img class='pic-src' src='"+imgp+ "'></td>"
						            	var nameAdd ='<td class="list_code">'+val.name+'</td>';
						            	//var contentAdd='<td class="list_code">'+val.content+'</td>';
										var ageAdd ='<td class="list_code">'+val.age_name+'</td>';
						            	var roomAdd ='<td class="list_name">'+val.romm_name+'</td>';
						            	var priceAdd ='<td class="list_name">'+val.price+'</td>';
						            	//var item_numAdd ='<td class="list_name">'+val.item_num+'</td>';
						            	// var status='<td class="list_status">'+val.status+'</td>';
						            	var span='<a  class="list_edit"  href="'+link+'")">编辑</a>';
						            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
						            	var content = '<tr>'+imgAdd+nameAdd+ageAdd+roomAdd+priceAdd+'<td>'+span+'</td>'+'</tr>';
										$('.table_style tbody').append(content);
									});
					            }else{
					                alert(data.message)
					            }
					        }              
				    	});	
	                });
	            }

        	}else{
        		alert(data.message);
        	}
        }
    });
}
init(0);
//删除
function del(id){
	var a = confirm("您确定删除吗？");
	if (a) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/product/delete'),
	        data:{
	        	id:id
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	window.location.reload();   
	            }else{
	                alert(result.message);
	            }
	        }             
    	});
	}	
}
</script>
@stop

