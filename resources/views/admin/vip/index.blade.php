@extends('admin.app')
@section('main')
<div class="admin_default">
	<div class='carousel-header'>
		<span class="carousel_title">会员列表</span>
		<span><a class="btn_add_admin" href="{{url('/admin/vip/export')}}" style="text-decoration:none;color:white;">导出Excel</a></span>
	</div>
	<table class="table_style">
		<thead>
			<tr>
			    <th>序号</th>	
				<th>电话</th>
				<th>注册时间</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<div id="pagnation" class='pagnation_style'></div>
</div>

@stop
@section('js')
<script type="text/javascript">
	$('#admin-vip').addClass('active');


function format(date){
    var time = new Date(parseInt(date*1000));
    var y = time.getFullYear();
    var m = time.getMonth()+1;
    var d = time.getDate();
    var h = time.getHours() < 10 ? '0' + time.getHours() : time.getHours();
    var mm = time.getMinutes() <10 ? '0' + time.getMinutes() : time.getMinutes();
    var s = time.getSeconds() <10 ? '0' + time.getSeconds() : time.getSeconds();
    return y+'-'+m+'-'+d+'  '+h+':'+mm+':'+s;
  }
//初始化获取数据
function init(page) {
	$.ajax({
        type:'POST',
        url:dgurl('/admin/vip/list/'+page),
        datatype:"json",
        success:function(data){
        	console.log(data.data);
        	if(data.status==1){
        		$.each(data.data,function(key,val){
        			key=key+1;
        			var createdDate = format(val.created_at);
        			var num='<td class="list_code">'+key+'</td>';
					var vipMobile ='<td class="list_code">'+val.mobile+'</td>';
					var createdAt ='<td class="list_code">'+createdDate+'</td>';
	            	var content = '<tr>'+num+vipMobile+createdAt+'</tr>';
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
					        url:dgurl('/admin/vip/list/'+nowpage),
					        datatype:"json",
					        success:function(data){
					            if(data.status==1){
					            	$('tbody').empty();
									$.each(data.data,function(key,val){
										key=key+1;
									    var createdDate = format(val.created_at);
									    var num='<td class="list_code">'+key+'</td>';
										var vipMobile ='<td class="list_code">'+val.mobile+'</td>';
										var createdAt ='<td class="list_code">'+createdDate+'</td>';
						            	var content = '<tr>'+num+vipMobile+createdAt+'</tr>';
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
</script>
@stop
