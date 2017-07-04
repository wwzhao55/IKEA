@extends('admin.app')
@section('main')
<div class="admin_default">
	<div class='carousel-header'>
		<span class="carousel_title">宜家/活动管理</span>
		<span><a class="btn_add_admin" href="{{url('/admin/activity/add')}}" style="text-decoration:none;color:white;">新增</a></span>
	</div>
	<table class="table_style">
		<thead>
			<tr>
				<th>活动名称</th>
				<th>活动商城</th>
				<th>活动开始时间</th>
				<th>活动结束时间</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<div id="pagnation" class='pagnation_style'></div>
</div>
<style type="text/css">
a{
	text-decoration:none;
}	
</style>

@stop
@section('js')
<script type="text/javascript">
	$('#admin-activity').addClass('active');
//时间戳转化为日期
function getLocalTime(nS) {     
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/[年月]/g, "-").replace(/日/g, " ");
   } 
function timeToDate(ts){
	var date=new Date(ts*1000);
	var year=date.getFullYear();
	var month=date.getMonth();
	    month=month+1;
	var day=date.getDate();
	return year+"-"+month+"-"+day;
}
//初始化获取数据
function init(page) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/activity/list/'+page),
	        datatype:"json",
	        success:function(data){
	        	if(data.status===1){
	        		$.each(data.data,function(key,val){
	        			var link=dgurl('/admin/activity/edit/'+val.id);
	        			var date_start=timeToDate(val.start_time);
	        			var date_end=timeToDate(val.end_time);
		            	var nameAdd ='<td class="list_code">'+val.name+'</td>';
		            	var addressAdd='<td class="list_code">'+val.address+'</td>';
						var startAdd ='<td class="list_code">'+date_start+'</td>';
		            	var endAdd ='<td class="list_name">'+date_end+'</td>';
		            	// var status='<td class="list_status">'+val.status+'</td>';
                        var span;
                        if (val.status === 1) {
                            span = '<span class=\"list_end\">活动已结束</span>';
                        } else {
                            span = '<span  class=\"list_del\"  onclick=\"end(\'' + val.id + '\')\">结束活动</span>';
                        }
		            	span+='<a  class="list_edit"  href="'+link+'">编辑</a>';
		            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
		            	var content = '<tr>'+nameAdd+addressAdd+startAdd+endAdd+'<td>'+span+'</td>'+'</tr>';
						$('.table_style tbody').append(content);
					});
                    //document.cookie="childPage="+0;
                    if (data.count>10) {
						$('#pagnation').bootpag({
							    total: Math.ceil(data.count/10),
							    maxVisible: 6
		                }).on("page", function (event, num) {
		                    var nowpage = num-1;
		                    //document.cookie="childPage="+nowpage;  
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/activity/list/'+nowpage),
						        datatype:"json",
						        success:function(data){
						            if(data.status===1){
						            	$('tbody').empty();
										$.each(data.data,function(key,val){
											var link=dgurl('/admin/activity/edit/'+val.id);
						        			var date_start=timeToDate(val.start_time);
						        			var date_end=timeToDate(val.end_time);
						        			var date_r_end=timeToDate(val.register_end_time);
							            	var nameAdd ='<td class="list_code">'+val.name+'</td>';
							            	var addressAdd='<td class="list_code">'+val.address+'</td>';
											var startAdd ='<td class="list_code">'+date_start+'</td>';
							            	var endAdd ='<td class="list_name">'+date_end+'</td>';
							            	var rEndAdd ='<td class="list_name">'+date_r_end+'</td>';
							            	// var status='<td class="list_status">'+val.status+'</td>';
							            	var span='<a  class="list_edit"  href="'+link+'">编辑</a>';
							            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
							            	var content = '<tr>'+nameAdd+addressAdd+startAdd+endAdd+rEndAdd+'<td>'+span+'</td>'+'</tr>';
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
		        url:dgurl('/admin/activity/delete'),
		        data:{
		        	id:id
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status===1){
		            	// console.log(result.data)
		            	window.location.reload();   
		            }else{
		                alert(result.message)
		            }
		        }             
	    	});
		}	
	}
    function end(id){
        var a = confirm("您确定结束活动吗？");
        if (a) {
            $.ajax({
                type:'POST',
                url:dgurl('/admin/activity/edit'),
                data:{
                    id:id,
                    status: 1
                },
                datatype:"json",
                success:function(result){
                    if(result.status===1){
                        // console.log(result.data)
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
