@extends('admin.app')
@section('main')
<div id='main-body'>
	<!-- <div class='category_title'>分类管理</div> -->
	<span class='category_type category_active'>生活空间</span>
	<span class='category_type'>话题</span>
	<span class='category_type'>年龄</span>
	<span class="btn_add_category">新增</span>
	<div class='life_space list'>
		<div id='life_space_table'>
			<table class="table_style">
				<thead>
					<tr>
						<th>序号</th>
						<th>图片</th>
						<th>名称</th>
						<!-- <th>状态</th> -->
						<th>操作</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div id="pagnation1" class='pagnation_style'></div>
	</div>
	<div class='topic_cnt list' style='display: none;'>
		<div id='topiv_table'>
			<table class="table_style">
				<thead>
					<tr>
						<th>序号</th>
						<th>图片</th>
						<th>名称</th>
						<!-- <th>状态</th> -->
						<th>操作</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div id="pagnation2" class='pagnation_style'></div>
	</div>
	<div class='age_cnt list' style='display: none;'>
		<div id='age_table'>
			<table class="table_style">
				<thead>
					<tr>
						<th>序号</th>
						<th>图片</th>
						<th>名称</th>
						<!-- <th>状态</th> -->
						<th>操作</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
		<div id="pagnation3" class='pagnation_style'></div>
	</div>
</div>
<!-- 新增弹窗 -->
<div id="basic_layer" hidden>
	<span>名称：</span>
	<input type="text" class="input_content admin_account" maxlength="20"><br>
	<input type="text" class="ca_type" hidden>
	<div class="pic_add_layer">
		<img src="" class="pic_add_src" alt="点击上传图片(推荐215px × 210px)">
		<input type='file' style='display:none;' name='image' class='img_upload' onchange="changePic(this)">
	</div>
		
	<button class="btn_default btn_confirm" onclick='add()'>确定</button>
	<button class="btn_default btn_return">取消</button>
</div>
<!-- 编辑弹窗 -->
<div id="basic_layer_edit" hidden>
	<input type="text" class="save_id" hidden>
	<input type="text" class="ca_type_edit" hidden>
	<span>名称：</span>
	<input type="text" class="input_content edit_account" maxlength="20"><br>
	<div class="pic_add_layer">
		<img src="" class="pic_add_src1" alt="点击上传图片">
		<input type='file' style='display:none;' name='image' class='img_upload1' onchange="changePic(this)">
	</div>

	<button class="btn_default btn_confirm" onclick='editSure()'>确定</button>
	<button class="btn_default btn_return">取消</button>
</div>
@stop
@section('js')
<script type="text/javascript">
	$('#config-list').show();
	$('#admin-category').css('background','#e1c5a5');
	$('.category_type').click(function(){
		$('tbody').empty();
		$('.category_type').removeClass('category_active');
		$(this).addClass('category_active');
		if($(this).html()=='生活空间') {
			$('.life_space').show();
			$('.age_cnt').hide();
			$('.topic_cnt').hide();
			init1(0,'生活空间');
		} else if($(this).html()=='话题'){
			$('.life_space').hide();
			$('.age_cnt').hide();
			$('.topic_cnt').show();
			init2(0,'话题');	
		} else{
			$('.life_space').hide();
			$('.age_cnt').show();
			$('.topic_cnt').hide();
			init3(0,'年龄');
		}
	});

	function init1(num,param) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/config/category/list/'+num),
	        data:{
	        	type:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	// $('tbody').empty();
					$.each(result.data,function(key,val){
						key=key+1;
						var imgp = dgPicUrl(val.image);
						var code='<td class="list_code">'+key+'</td>';
						var img="<td><img class='pic-src-display' src='"+imgp+ "'></td>";
		            	var name='<td class="list_name">'+val.name+'</td>';
		            	var status='<td class="list_status">'+val.status+'</td>';
		            	var span='<span  class="type_edit" onclick="edit(\''+val.id+'\',\''+val.name+'\',\''+val.image+'\')">编辑</span>';
		            	var content = '<tr>'+code+img+name+'<td>'+span+'</td>'+'</tr>';
						$('.table_style tbody').append(content);
					});

					//调整左侧高度与右侧一致
					var right = $("#right").height();
					$('#left').css('height',right);

					if (result.count>page) {
						$('#pagnation1').bootpag({
							    total: Math.ceil(result.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                    var nowpage = num-1;
		                    
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/config/category/list/'+nowpage),
						        data:{
						        	type:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('tbody').empty();
										$.each(result.data,function(key,val){
											key=key+1;
											var imgp = dgPicUrl(val.image);
											var code='<td class="list_code">'+key+'</td>';
											var img="<td><img class='pic-src-display' src='"+imgp+ "'></td>";
							            	var name='<td class="list_name">'+val.name+'</td>';
							            	var status='<td class="list_status">'+val.status+'</td>';
							            	var span='<span  class="type_edit" onclick="edit(\''+val.id+'\',\''+val.name+'\',\''+val.image+'\')">编辑</span>';
							            	var content = '<tr>'+code+img+name+'<td>'+span+'</td>'+'</tr>';
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
	                alert(result.message);
	            }
	        }              
    	});
	}
	init1(0,'生活空间');

	function init2(num,param) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/config/category/list/'+num),
	        data:{
	        	type:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	$('tbody').empty();
	            	var imgp;
					$.each(result.data,function(key,val){
						key=key+1;
						if (!!val.image) {							
							imgp = dgPicUrl(val.image);
						} else{
							imgp='';
						}
						var code='<td class="list_code">'+key+'</td>';
						var img="<td><img class='pic-src-display' alt='无图片' src='"+imgp+ "'></td>";
		            	var name='<td class="list_name">'+val.name+'</td>';
		            	var status='<td class="list_status">'+val.status+'</td>';
		            	var span='<span  class="type_edit" onclick="edit(\''+val.id+'\',\''+val.name+'\',\''+val.image+'\')">编辑</span>';
		            	var content = '<tr>'+code+img+name+'<td>'+span+'</td>'+'</tr>';
						$('.table_style tbody').append(content);
					});

					//调整左侧高度与右侧一致
					var right = $("#right").height();
					$('#left').css('height',right);

					if (result.count>page) {
						$('#pagnation2').bootpag({
							    total: Math.ceil(result.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                    var nowpage = num-1;
		                    
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/config/category/list/'+nowpage),
						        data:{
						        	type:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('tbody').empty();
										$.each(result.data,function(key,val){
											key=key+1;
											// var imgp = dgPicUrl(val.image);
											if (val.image) {
												imgp = dgPicUrl(val.image);
											} else{
												imgp='';
											}
											var code='<td class="list_code">'+key+'</td>';
											var img="<td><img alt='无图片' class='pic-src-display' src='"+imgp+ "'></td>";
							            	var name='<td class="list_name">'+val.name+'</td>';
							            	var status='<td class="list_status">'+val.status+'</td>';
							            	var span='<span  class="type_edit" onclick="edit(\''+val.id+'\',\''+val.name+'\',\''+val.image+'\')">编辑</span>';
							            	var content = '<tr>'+code+img+name+'<td>'+span+'</td>'+'</tr>';
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
	                alert(result.message);
	            }
	        }              
    	});
	}
	function init3(num,param) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/config/category/list/'+num),
	        data:{
	        	type:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	$('tbody').empty();
					$.each(result.data,function(key,val){
						key=key+1;
						var imgp = dgPicUrl(val.image);
						var code='<td class="list_code">'+key+'</td>';
						var img="<td><img class='pic-src-display' src='"+imgp+ "'></td>";
		            	var name='<td class="list_name">'+val.name+'</td>';
		            	var status='<td class="list_status">'+val.status+'</td>';
		            	var span='<span  class="type_edit" onclick="edit(\''+val.id+'\',\''+val.name+'\',\''+val.image+'\')">编辑</span>';
		            	var content = '<tr>'+code+img+name+'<td>'+span+'</td>'+'</tr>';
						$('.table_style tbody').append(content);
					});

					//调整左侧高度与右侧一致
					var right = $("#right").height();
					$('#left').css('height',right);

					if (result.count>page) {
						$('#pagnation3').bootpag({
							    total: Math.ceil(result.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                    var nowpage = num-1;
		                    
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/config/category/list/'+nowpage),
						        data:{
						        	type:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('tbody').empty();
										$.each(result.data,function(key,val){
											key=key+1;
											var imgp = dgPicUrl(val.image);
											var code='<td class="list_code">'+key+'</td>';
											var img="<td><img class='pic-src-display' src='"+imgp+ "'></td>";
							            	var name='<td class="list_name">'+val.name+'</td>';
							            	var status='<td class="list_status">'+val.status+'</td>';
							            	var span='<span  class="type_edit" onclick="edit(\''+val.id+'\',\''+val.name+'\',\''+val.image+'\')">编辑</span>';
							            	var content = '<tr>'+code+img+name+'<td>'+span+'</td>'+'</tr>';
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
	                alert(result.message);
	            }
	        }              
    	});
	}

	$('.btn_add_category').click(function(){
		$('.admin_account').val('');
		$('.pic_add_src').attr('src','');
		imgpath = '';
	    layer.open({
            type: 1,
            title: '新增',
            skin: 'layui-layer-demo', //样式类名
            closeBtn: 0, //不显示关闭按钮
            shift: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['400px', '300px'], 
            content: $('#basic_layer'),
        });
		if($('.category_active').html()=='生活空间') {
			$('.ca_type').val('生活空间');

		} else if($('.category_active').html()=='话题'){
			$('.ca_type').val('话题');
		} else{
			$('.ca_type').val('年龄');
		}
	});

	//图片预览及上传
	var imgpath;//图片地址
	$('.pic_add_src').click(function(){
		$('.img_upload').click();
	});
	$('.pic_add_src1').click(function(){
		$('.img_upload1').click();
	});
	function changePic(source){
		var file = source.files[0];
		// console.log(source);
		var formData = new FormData();
		formData.append('image', file);
		formData.append('dir', 'category');
		$.ajax({
	        url: dgurl('/admin/image'),
	        data: formData,
	        processData: false, // 不处理数据
	        contentType: false, // 不设置内容类型
	        type: 'POST',
	        dataType:'json',
	        success:function(data){
	        	if(data.status == 1){
	        		imgpath = data.data.key;//保存图片地址
				    if(window.FileReader) {
						var fr = new FileReader();
						fr.onloadend = function(e) {
						    // console.log(e.target);
						    $('.pic_add_src').attr('src',e.target.result);
						    $('.pic_add_src1').attr('src',e.target.result);
						};
						fr.readAsDataURL(file);
					}
	        	}else{
	        		alert(data.message);
	        	}
	        }
		});
	}

	$('.btn_return').on('click',function(){
		layer.closeAll();
	});

	function add(){
		var account = $('.admin_account').val();
		var type = $('.ca_type').val();
		var cate = $('.category_active').html();
		if (cate =='年龄'||cate =='生活空间') {
			if (imgpath=='') {
				alert('请填写名称和上传图片');
				return false;
			}
		}
		if (account) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/config/category/add'),
		        data:{
		        	name:account,
		        	type:type,
		        	image:imgpath
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	// console.log(result.data)
		            	$('tbody').empty();
		            	layer.closeAll();
		            	// init(0,type);
						if($('.category_active').html()=='生活空间') {
							init1(0,'生活空间');
						} else if($('.category_active').html()=='话题'){
							init2(0,'话题');	
						} else{
							init3(0,'年龄');
						}
		            	// window.location.reload();
		            }else{
		                alert(result.message)
		            }
		        }             
	    	});
		} else {
			alert('请填写名称');
		}	
	}

	function edit(id,name,image){
		imgpath = image;
		var imagep;
		if (!!image) {							
			imagep = dgPicUrl(image);			
		} else{
			imagep='';
		}
		$('#basic_layer_edit .pic_add_src1').attr('src',imagep);
		$('.save_id').val(id);
		$('.edit_account').val(name);
		layer.open({
            type: 1,
            title: '编辑',
            skin: 'layui-layer-demo', //样式类名
            closeBtn: 0, //不显示关闭按钮
            shift: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['400px', '300px'], 
            content: $('#basic_layer_edit')
        });

        if($('.category_active').html()=='生活空间') {
			$('.ca_type').val('生活空间');

		} else if($('.category_active').html()=='话题'){
			$('.ca_type').val('话题');
		} else{
			$('.ca_type').val('年龄');
		}
	}

	function editSure(){
		var id = $('.save_id').val();
		var name = $('.edit_account').val();
		var type = $('.ca_type').val();
		var cate = $('.category_active').html();
		if (cate =='年龄'||cate =='生活空间') {
			if (imgpath=='') {
				alert('请填写名称和上传图片');
				return false;
			}
		}
		if (name) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/config/category/edit'),
		        data:{
		        	id:id,
		        	name:name,
		        	type:type,
		        	image:imgpath
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	// console.log(result.data)
		            	$('tbody').empty();
		            	layer.closeAll();
		            	// init(0,type);
		            	if($('.category_active').html()=='生活空间') {
							init1(0,'生活空间');
						} else if($('.category_active').html()=='话题'){
							init2(0,'话题');	
						} else{
							init3(0,'年龄');
						}
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
			alert('请填写新的名称');
		}	
	}
</script>
@stop
