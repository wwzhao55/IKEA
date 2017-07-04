@extends('admin.app')
@section('main')
	<div id='carousel-ontainer'>
		<div id='carousel-header'>
			<span class="carousel_title">首页轮播图片设置</span>
		</div>
		<div class='picture_container'>
			<div>
				<div class="pic_add"><img src="" class="pic_add_src" alt=""></div>
				<input type='file' style='display:none;' name='image' class='img_upload' onchange="changePic(this)">
				<span class='warning-tip'>
					<input type="text" style="background:#e1c5a5;" class="pic_link" placeholder="图片链接地址(必填)">
					提示：点击区域选择图片(推荐750px × 340px)，点击新增上传！
				</span>
				<span class="btn_add_pic">新增</span>
			</div>
			<!-- <div class="picture_content">
				<div class="pic"><img src="" class="pic-src"></div>
				<div class="pic_deal">
					<span class="btn_edit">更新</span>
					<span class="btn_del">删除</span>					
				</div>
			</div> -->
		</div>
		<div id="pagnation" class="pagnation_style"></div>
	</div>
@stop
@section('js')
<script type="text/javascript">
	$('#config-list').show();
	$('#admin-carousel').css('background','#e1c5a5');
	//获取数据
	function init(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/config/carousel/list/'+num),
	        datatype:"json",
	        success:function(data){
	            if(data.status==1){
	            	// console.log(result.data)
	            	var nowstatus;
	            	// $('.picture_content').html('');
	            	$.each(data.data,function(key,val){
		            	// var imgp = picBaseUrl+val.image;
		            	if (val.status==0) {
		            		nowstatus = '禁用';
		            	} else{
		            		nowstatus = '启用';
		            	}
		            	var imgp = dgPicUrl(val.image);
		            	var img = "<img class='pic-src' src='"+imgp+ "'>"
		            	var span = '<span class="pic_link">'+val.link+'</span>';
		            	var status = '<span>状态：'+nowstatus+'</span>';
		            	var content = "<div class='picture_content'>"+"<div class='pic'>"+img+span+"</div>"+"<div class='pic_deal'>"+status+"<span class='btn_del start' onclick='changeStatus(\""+val.id+"\",\""+val.status+"\")'>切换状态</span>"+"<span class='btn_del' onclick='btnDel("+val.id+")'>删除</span>"+"</div>"+"</div>";
						$('.picture_container').append(content);
						
					});
					//调整左侧高度与右侧一致
					var right = $("#right").height();
					$('#left').css('height',right);
					
					if (data.count>page) {
						$('#pagnation').bootpag({
							    total: Math.ceil(data.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                	var nowpage = num-1;
		                	$('.picture_content').remove();
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/config/carousel/list/'+nowpage),
						        datatype:"json",
						        success:function(data){
						            if(data.status==1){
						            	var nowstatus;
						            	$.each(data.data,function(key,val){
							            	if (val.status==0) {
							            		nowstatus = '禁用';
							            	} else{
							            		nowstatus = '启用';
							            	}
							            	var imgp = dgPicUrl(val.image);
							            	var img = "<img class='pic-src' src='"+imgp+ "'>"
							            	var span = '<span class="pic_link">'+val.link+'</span>';
							            	var status = '<span>状态：'+nowstatus+'</span>';
							            	var content = "<div class='picture_content'>"+"<div class='pic'>"+img+span+"</div>"+"<div class='pic_deal'>"+status+"<span class='btn_del start' onclick='change1(\""+val.id+"\",\""+val.status+"\")'>启用</span>"+"<span class='btn_del end' onclick='change2(\""+val.id+"\",\""+val.status+"\")'>禁用</span>"+"<span class='btn_del' onclick='btnDel("+val.id+")'>删除</span>"+"</div>"+"</div>";
											$('.picture_container').append(content);

										});
						            }else{
						                alert(data.message)
						            }
						        }              
					    	});		
		                });
		            }
	            }else{
	                alert(data.message)
	            }
	        }              
    	});

	}
	init(0);

	
	//图片预览及上传
	$('.pic_add_src').click(function(){
		$('.img_upload').click();
	})
	function changePic(source){
		var file = source.files[0];
		// console.log(source);
		if(window.FileReader) {
			var fr = new FileReader();
			fr.onloadend = function(e) {
			    // console.log(e.target);
			    $('.pic_add_src').attr('src',e.target.result);
			};
			fr.readAsDataURL(file);
		}
	}
	$('.btn_add_pic').click(function(){
		var formData = new FormData();
		var uploadimg = $('.img_upload')[0].files[0];
		formData.append('image', uploadimg);
		formData.append('dir', 'index');
		// console.log($('.img_upload')[0].files[0])
		var link = $('.pic_link').val();
		if (uploadimg == undefined||link==''||link==undefined) {
			alert('请选择上传图片并填写图片链接地址！');
		} else{
			$.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	if(data.status == 1){
		        		var imgpath = data.data.key;
		        		$.post(dgurl('/admin/config/carousel/add'),{image:imgpath,link:link},function(result){
		        			if (result.status==1) {
		        				window.location.reload();
		        				// init(0);
		        				// alert('图片上传成功！');
    							// console.log(result)
		        			} else{
		        				alert(result.message);
		        			}		        			
  						});
		       		        		
		        	}else{
		        		alert(data.message);
		        	}
		        }
			});
		}
	})

	function changeStatus(id,status) {
		if (status==0) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/config/carousel/status'),
		        data:{
		        	id:id,
		        	status:1
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	window.location.reload();
		            }else{
		                alert(result.message)
		            }
		        }, 
		        error: function(XMLHttpRequest,errorThrown,textStatus) {
		        	if (XMLHttpRequest.status==422) {
		        		alert(XMLHttpRequest.responseText);
		        	} else{
		        		alert('请检查网络后重试');
		        	}		         	
		        }              
	    	});			
		} else{
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/config/carousel/status'),
		        data:{
		        	id:id,
		        	status:0
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	window.location.reload();
		            }else{
		                alert(result.message)
		            }
		        }, 
		        error: function(XMLHttpRequest,errorThrown,textStatus) {
		         	if (XMLHttpRequest.status==422) {
		        		alert(XMLHttpRequest.responseText);
		        	} else{
		        		alert('请检查网络后重试');
		        	}
		        }              
	    	});
		}
	}


	// function change1(id) {
	// 	$.post(dgurl('/admin/config/picture/status'),{id:id,status:1},function(result){
	// 		if (result.status==1) {
	// 			window.location.reload();
	// 			// init(0);
	// 		} else{
	// 			alert(result.message);
	// 		}		        			
	// 	});		
	// }

	function btnDel(id) {
		var a = confirm("您确定删除吗？");
		if (a) {
			$.post(dgurl('/admin/config/carousel/delete'),{id:id},function(result){
				if (result.status==1) {
					window.location.reload();
					// init(0);
				} else{
					alert(result.message);
				}		        			
			});
		}		
	}
	
</script>
@stop
