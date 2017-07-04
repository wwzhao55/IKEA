@extends('admin.app')
@section('main')
<div class="admin_default">
	<div class='carousel-header'>
		<span class="carousel_title">宜家/知识管理</span>
		<span><a class="btn_add_admin" href="{{url('/admin/knowledge/add')}}" style="text-decoration:none;color:white;">新增</a></span>
	</div>
	<table class="table_style">
		<thead>
			<tr>
				<th>头图</th>
				<th>标题</th>
				<th>年龄段</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<div id="pagnation" class='pagnation_style'></div>
</div>

<style type="text/css">
.pic_add_more {
    width: 100px;
    height: 100px;
    border: 1px solid #d1af94;
    margin-bottom: 10px;
    display: inline-block;
}
.pic_add_more:hover {
    cursor: pointer;
}
.pic_add_more img {
    width: 100px;
    height: 50px;
}

.input-file input{
	height: 40px;
	position: absolute;
	top: 185px;
	left: 80px; 
    opacity: 0;
}
#add_pic{
	margin-left: 90px;
}
#add_pic img{
	width:100px;
	height: 50px; 
}
.newdanger-file-img{
	cursor: pointer;
}
.knowledge-table-main-img img{
	width: 90px;
	height: 40px; 
}
a{
	text-decoration:none;
}
</style>


@stop
@section('js')
<script type="text/javascript">
	$('#admin-knowledge').addClass('active');
//初始化获取数据
$(function(){
	PassData(0);
})
function 	PassData(page){
		$.ajax({
		    url: dgurl('/admin/knowledge/list/'+page),
		    type: 'POST',
		    dataType:'json',
		    success:function(data){
		    	if(data.status==1){
	        		$.each(data.data,function(key,val){
					    //------------------------------------
					    var link=dgurl('/admin/knowledge/edit/'+val.id);
						var imgp = dgPicUrl(val.main_img);
		            	var imgAdd = "<td class='knowledge-table-main-img'><img class='pic-src' src='"+imgp+ "'></td>"
		            	var titleAdd='<td class="list_code">'+val.title+'</td>';
		            	var categoryIdAdd='<td class="list_name">'+val.category_name+'</td>';
		            	var span='<a  class="list_edit"  href="'+link+'")">编辑</a>';
		            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
		            	var content = '<tr>'+imgAdd+titleAdd+categoryIdAdd+'<td>'+span+'</td>'+'</tr>';
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
						        url:dgurl('/admin/knowledge/list/'+nowpage),
						        datatype:"json",
						        success:function(data){
						            if(data.status==1){
						            	$('tbody').empty();
										$.each(data.data,function(key,val){
										    var link=dgurl('/admin/knowledge/edit/'+val.id);
											var imgp = dgPicUrl(val.main_img);
							            	var imgAdd = "<td class='knowledge-table-main-img'><img class='pic-src' src='"+imgp+ "'></td>"
							            	var titleAdd='<td class="list_code">'+val.title+'</td>';
											var contentAdd='<td class="list_code">'+val.content+'</td>';
							            	var categoryIdAdd='<td class="list_name">'+val.category_name+'</td>';
							            	var span='<a  class="list_edit"  href="'+link+'")">编辑</a>';
							            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
							            	var content = '<tr>'+imgAdd+titleAdd+contentAdd+categoryIdAdd+'<td>'+span+'</td>'+'</tr>';
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
		})
	}
//删除
function del(id){
		var a = confirm("您确定删除吗？");
		if (a) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/knowledge/delete'),
		        data:{
		        	id:id
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	window.location.reload();   
		            }else{
		                alert(result.message)
		            }
		        }             
	    	});
		}	
	}
</script>
@stop

