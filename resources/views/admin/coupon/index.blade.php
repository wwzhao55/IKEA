@extends('admin.app')
@section('main')
    <div class="admin_default">
	<div class='carousel-header'>
		<span class="carousel_title">优惠券管理</span>
		<span class="btn_add_admin upload" style="margin-left:10px;">上传</span>
		<input type='file' style='display:none;' name='file' class='file_upload' onchange="change(this)">
		<a href="{{$download_url}}" class="btn_add_admin template">下载模板</a>
	</div>
	<!-- <span class='choose-type topic_active'>未领取</span>
	<span class='choose-type'>已领取</span> -->
	<div class="coupon_list1" >
		<table class="table_style">
			<thead>
				<tr>
					<th>序号</th>
					<th>优惠券码</th>
					<th>价值</th>
					<th>领取状态</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		<div id="pagnation1" class="pagnation_style"></div>
	</div>
	<div class="coupon_list2" style="display:none">
		<table class="table_style">
			<thead>
				<tr>
					<th>序号</th>
					<th>优惠券码</th>
					<th>价值</th>
					<th>领取状态</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		<div id="pagnation2" class="pagnation_style"></div>
	</div>	
</div>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-coupon').css('background','#e1c5a5');
	/*$('.choose-type').click(function(){
		$('tbody').empty();
		$('.choose-type').removeClass('topic_active');
		$(this).addClass('topic_active');
		if($(this).html()=='未领取'){
			$('.coupon_list1').show();
			$('.coupon_list2').hide();
			init1(0,0);
		}else {
			$('.coupon_list2').show();
			$('.coupon_list1').hide();
			init2(0,1);				
		}
	});*/

	function init(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/coupon/list/'+num),
	        data:{
	        	id:0,
	        	status:status
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	$('tbody').empty();
	            	var getstatus;
					$.each(result.data,function(key,val){
						key=key+1;
						if (val.is_get == 0) {
							getstatus = '未领取';
						} else{
							getstatus = '已领取';
						}
						var num='<td class="list_code">'+key+'</td>';
		            	var name='<td class="list_name">'+val.code+'</td>';
		            	var value='<td class="list_value">'+val.value+'</td>';
		            	var status='<td class="list_status">'+getstatus+'</td>';
		            	var content = '<tr>'+num+name+value+status+'</tr>';
						$('.table_style tbody').append(content);
					});
					if (result.count>page) {
						$('#pagnation1').bootpag({
							    total: Math.ceil(result.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                	var nownum = num-1;
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/coupon/list/'+nownum),
						        data:{
						        	id:0,
						        	status:0
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('tbody').empty();
						            	var getstatus;
										$.each(result.data,function(key,val){
											key=key+1;
											if (val.is_get == 0) {
												getstatus = '未领取';
											} else{
												getstatus = '已领取';
											}
											var num='<td class="list_code">'+key+'</td>';
							            	var name='<td class="list_name">'+val.code+'</td>';
							            	var value='<td class="list_value">'+val.value+'</td>';
							            	var status='<td class="list_status">'+getstatus+'</td>';
							            	var content = '<tr>'+num+name+value+status+'</tr>';
											$('.table_style tbody').append(content);
										});
						            }else{
						                alert(result.message)
						            }
						        }              
					    	});		
		                });
		            }
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}
	init(0);

	/*function init2(num,status) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/coupon/list/'+num),
	        data:{
	        	id:0,
	        	status:status
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	$('tbody').empty();
	            	var getstatus;
					$.each(result.data,function(key,val){
						key=key+1;
						if (val.is_get == 0) {
							getstatus = '未领取';
						} else{
							getstatus = '已领取';
						}
						var num='<td class="list_code">'+key+'</td>';
		            	var name='<td class="list_name">'+val.code+'</td>';
		            	var value='<td class="list_value">'+val.value+'</td>';
		            	var status='<td class="list_status">'+getstatus+'</td>';
		            	var content = '<tr>'+num+name+value+status+'</tr>';
						$('.table_style tbody').append(content);
					});
					if (result.count>page) {
						$('#pagnation1').bootpag({
							    total: Math.ceil(result.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                	var nownum = num-1;
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/coupon/list/'+nownum),
						        data:{
						        	id:0,
						        	status:1
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('tbody').empty();
						            	var getstatus;
										$.each(result.data,function(key,val){
											key=key+1;
											if (val.is_get == 0) {
												getstatus = '未领取';
											} else{
												getstatus = '已领取';
											}
											var num='<td class="list_code">'+key+'</td>';
							            	var name='<td class="list_name">'+val.code+'</td>';
							            	var value='<td class="list_value">'+val.value+'</td>';
							            	var status='<td class="list_status">'+getstatus+'</td>';
							            	var content = '<tr>'+num+name+value+status+'</tr>';
											$('.table_style tbody').append(content);
										});
						            }else{
						                alert(result.message)
						            }
						        }              
					    	});		
		                });
		            }
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}*/

	$('.upload').click(function(){
		$('.file_upload').click();
	});
	function change(source){
		var file = source.files[0];
		var formData = new FormData();
		formData.append('coupon', file);
		if (file == undefined) {
			alert('请选择上传文件！');
		} else{
			$.ajax({
		        url:dgurl('/admin/coupon/upload'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	if(data.status == 1){
		       		    // alert('上传成功');
		       		    window.location.reload();   		
		        	}else{
		        		alert(data.message);
		        	}
		        }
			});
		}
	}

	// function upload() {
	// 	$.ajax({
	//         type:'POST',
	//         url:dgurl('/admin/coupon/upload'),
	//         data:{
	//         	// coupon:0	        	
	//         },
	//         datatype:"json",
	//         success:function(result){
	//             if(result.status==1){
	            	
	//             }else{
	//                 alert(result.message)
	//             }
	//         }              
 //    	});
	// }

</script>
@stop