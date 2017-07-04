@extends('admin.app')
@section('main')
<div class="admin_default">
	<div class='carousel-header'>
		<span class="carousel_title">管理员信息列表</span>
		<span class="btn_add_admin">新增</span>
	</div>
	<table class="table_style">
		<thead>
			<tr>
				<th>序号</th>
				<th>名称</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<div id="pagnation" style=""></div>
</div>
<!-- 新增弹窗 -->
<div id="basic_layer" hidden>
	<span>账户：</span>
	<input type="text" class="input_content admin_account" maxlength="20"><br>
	<span>密码：</span><input type="password" class="input_content admin_pws" maxlength="30">
	<br>	
	<button class="btn_default btn_confirm" onclick='add()'>确定</button>
	<button class="btn_default btn_return">取消</button>
</div>
<!-- 编辑弹窗 -->
<div id="basic_layer_edit" hidden>
	<input type="text" class="save_id" hidden>
	<span>账户：</span>
	<input type="text" class="input_content edit_account" maxlength="20"><br>
	<span>密码：</span><input type="password" class="input_content edit_pws" maxlength="30">
	<br>	
	<button class="btn_default btn_confirm" onclick='editSure()'>确定</button>
	<button class="btn_default btn_return">取消</button>
</div>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-list').addClass('active');
	function init(page) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/list/'+page),
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	// $('tbody').empty();
					$.each(result.data,function(key,val){
						key=key+1;
						var code='<td class="list_code">'+key+'</td>';
		            	var name='<td class="list_name">'+val.account+'</td>';
		            	var status='<td class="list_status">'+val.status+'</td>';
		            	var span='<span  class="list_edit"  onclick="edit(\''+val.id+'\',\''+val.account+'\',\''+val.password+'\')">编辑</span>';
		            	span+='<span  class="list_del"  onclick="del(\''+val.id+'\')">删除</span>';
		            	var content = '<tr>'+code+name+status+'<td>'+span+'</td>'+'</tr>';
						$('.table_style tbody').append(content);
					});
					// if (result.count>10) {
					// 	$('#pagnation').bootpag({
					// 		    total: (result.count+10)/10,
					// 		    maxVisible: 6,
		   //              }).on("page", function (event, num) {
		                      		
		   //              });
		   //          }
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}
	init(0);

	$('.btn_add_admin').on('click',function(){
		$('.admin_account').val('');
		$('.admin_pws').val('');
	    layer.open({
            type: 1,
            title: '新增',
            skin: 'layui-layer-demo', //样式类名
            closeBtn: 0, //不显示关闭按钮
            shift: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['400px', '230px'], 
            content: $('#basic_layer'),
        });
	});
	$('.btn_return').on('click',function(){
		layer.closeAll();
	});

	function add(){
		var account = $('.admin_account').val();
		var pws = $('.admin_pws').val();
		if (account&&pws.length>5) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/add'),
		        data:{
		        	account:account,
		        	password:pws
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	// console.log(result.data)
		            	$('tbody').empty();
		            	layer.closeAll();
		            	init(0);
		            	// window.location.reload();
		            }else{
		                alert(result.message)
		            }
		        },
		        error: function(XMLHttpRequest,errorThrown) {
		         	alert("请检查网络后重试！");
		        }               
	    	});
		} else {
			alert('请填写账户和6位及以上密码');
		}	
	}

	function edit(id,name,pws){
		$('.save_id').val(id);
		$('.edit_account').val(name);
		$('.edit_pws').val('');
		// $('.edit_pws').val(pws);
		layer.open({
            type: 1,
            title: '编辑',
            skin: 'layui-layer-demo', //样式类名
            closeBtn: 0, //不显示关闭按钮
            shift: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['400px', '230px'], 
            content: $('#basic_layer_edit')
        });
	}

	function editSure(){
		var id = $('.save_id').val();
		var account = $('.edit_account').val();
		var pws = $('.edit_pws').val();
		if (account&&pws.length>5) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/edit'),
		        data:{
		        	id:id,
		        	account:account,
		        	password:pws
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	// console.log(result.data)
		            	$('tbody').empty();
		            	layer.closeAll();
		            	init(0);
		            	// window.location.reload();
		            }else{
		                alert(result.message)
		            }
		        },
		        error: function(XMLHttpRequest,errorThrown) {
		         	alert("请检查网络后重试！");
		        }               
	    	});
		} else{
			alert('请填写新的账户和6位及以上密码');
		}	
	}

	function del(id){
		var a = confirm("您确定删除吗？");
		if (a) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/delete'),
		        data:{
		        	id:id
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	// console.log(result.data)
		            	$('tbody').empty();
		            	layer.closeAll();
		            	init(0);
		            }else{
		                alert(result.message)
		            }
		        }             
	    	});
		}	
	}
</script>
@stop
