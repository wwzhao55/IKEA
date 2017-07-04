@extends('admin.app')
@section('main')
    <div id='carousel-ontainer'>
		<div id='carousel-header'>
			<span class="carousel_title">知识图片设置</span>
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
		</div>
		<div id="pagnation"></div>
	</div>

@stop
@section('js')
<script type="text/javascript">
	$('#config-list').show();
	$('#admin-picture').css('background','#e1c5a5');

	//获取数据
	function init(page) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/config/picture/list/'+page),
	        datatype:"json",
	        success:function(data){
	            if(data.status==1){
	            	// console.log(result.data)
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
		            	var content = "<div class='picture_content'>"+"<div class='pic'>"+img+span+"</div>"+"<div class='pic_deal'>"+status+"<span class='btn_del start' onclick='change(\""+val.id+"\",\""+val.status+"\")'>切换状态</span>"+"<span class='btn_del' onclick='btnDel("+val.id+")'>删除</span>"+"</div>"+"</div>";
						$('.picture_container').append(content);
						
					});
					// if (data.count>10) {
					// 	$('#pagnation').bootpag({
					// 		    total: (data.count+10)/10,
					// 		    maxVisible: 6,
		   //              }).on("page", function (event, num) {
		                      		
		   //              });
		   //          }
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
		formData.append('dir', 'category');
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
		        		$.post(dgurl('/admin/config/picture/add'),{image:imgpath,link:link},function(result){
		        			if (result.status==1) {
		        				// alert('图片上传成功！');
    							// $("span").html(result);
    							// console.log(result)
    							window.location.reload();
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
	});

	function change(id,status) {
		if (status==0) {
			$.post(dgurl('/admin/config/picture/status'),{id:id,status:1},function(result){
				if (result.status==1) {
					window.location.reload();
					// init(0);
				} else{
					alert(result.message);
				}		        			
			});
		} else {
			$.post(dgurl('/admin/config/picture/status'),{id:id,status:0},function(result){
				if (result.status==1) {
					window.location.reload();
				} else{
					alert(result.message);
				}		        			
			});
		}
	}
	// function change2(id,status) {
	// 	$.post(dgurl('/admin/config/picture/status'),{id:id,status:0},function(result){
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
			$.post(dgurl('/admin/config/picture/delete'),{id:id},function(result){
				if (result.status==1) {
					window.location.reload();
				} else{
					alert(result.message);
				}		        			
			});
		}		
	}
</script>
@stop
<!-- <style type="text/css">
	.list span {
		display: inline-block;
		color: #d1af94;
		font-weight: normal;
		font-size:18px;
		margin-bottom: 16px;
	}
	.list .btn-sure {
	    width: 100px;
	    height: 40px;
	    margin-top: 20px;
	    display: inline-block;
	    background-color: #d1af94;
	    line-height: 40px;
	    color: #fff;
	    font-size: 20px;
	    border-radius: 5px;
	    cursor: pointer;
	    text-align: center;
	}
</style>
<div id='main-body'>
	<div class='category_title'>宜家/评论审核</div>
	<span class='comment_type comment_active'>活动</span>
	<span class='comment_type'>话题</span>
	<span class='comment_type'>知识</span>
	<div class='activity list'>
		<div class='list'>
			<input type="radio" class="first" value="1" name="sort" checked="checked">
			<span>发布时间倒序</span><br>
			<input type="radio" value="2" name="sort">
			<span>最后评论时间倒序</span><br>
			<input type="radio" value="3" name="sort">
			<span>收藏数正序</span><br>
			<input type="radio" value="4" name="sort">
			<span>评论数正序</span><br>
			<span class="btn-sure">确定</span>
		</div>
	</div>
	<div class='topic' style='display: none;'>
		<div class='list'>
			<input type="radio" class="first" value="1" name="sort1" checked="checked">
			<span>发布时间倒序</span><br>
			<input type="radio" value="2" name="sort1">
			<span>最后评论时间倒序</span><br>
			<input type="radio" value="3" name="sort1">
			<span>点赞数正序</span><br>
			<input type="radio" value="4" name="sort1">
			<span>评论数正序</span><br>
			<span class="btn-sure">确定</span>			
		</div>
	</div>
	<div class='knowledge' style='display: none;'>
		<div class='list'>
			<input type="radio" class="first" value="1" name="sort2" checked="checked">
			<span>发布时间倒序</span><br>
			<input type="radio" value="2" name="sort2">
			<span>最后评论时间倒序</span><br>
			<input type="radio" value="3" name="sort2">
			<span>点赞数正序</span><br>
			<input type="radio" value="4" name="sort2">
			<span>评论数正序</span><br>
			<span class="btn-sure">确定</span>
		</div>
	</div>
</div> -->
<!-- <script type="text/javascript">
	$('#config-list').show();
	$('#admin-sort').css('background','#e1c5a5');

	$('.comment_type').click(function(){
		$('.comment_type').removeClass('comment_active');
		$(this).addClass('comment_active');
		if($(this).html()=='活动') {
			$('.activity').show();
			$('.knowledge').hide();
			$('.topic').hide();
		} else if($(this).html()=='话题'){
			$('.activity').hide();
			$('.knowledge').hide();
			$('.topic').show();
		} else if ($(this).html()=='知识') {
			$('.activity').hide();
			$('.knowledge').show();
			$('.topic').hide();
		}
	});

	
	$('.btn-sure').click(function(){
		var $active = $('.comment_active').html();
		var checkval;
		if ($active == '活动') {
			checkval = $('input:radio[name="sort"]:checked').val();

		} else if ($active == '话题') {
			checkval = $('input:radio[name="sort1"]:checked').val();
		} else{
			checkval = $('input:radio[name="sort2"]:checked').val();
		}
	});

	function init() {
		if($('.comment_active').html()=='活动') {
			active_link = 'activity-status';
		} else if($('.comment_active').html()=='话题'){
			active_link = 'topic-status';
		} else if ($('.comment_active').html()=='知识') {
			active_link = 'knowledge-status';
		} else {
			active_link = 'product-status';
		}
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/comment/'+active_link),
	        data:{
	        	// id:id,
	        	// status:1
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	alert("设置排序方式成功！");
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}
</script> -->
