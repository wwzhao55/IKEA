@extends('admin.app')
@section('main')
<div id='detail-body' class="alllist">
	<div class='pagetitle' style=''>话题详情</div>
	<div class="detial-pic">
		<img src="" alt="无图片" class='detial-pic-src'>
	</div>
	<div class="detail-des">
		<div class="large-head"></div>
		<div class="detail-des-body"></div>
	</div>
	<div class='roll-pic'>
		<div class="banner" id="b04" style="min-width: 100%;">
		    <ul class='Carousel'></ul>
		</div>
	</div>
	<div class="detail-bottom">
		<button class='detail-button Pass' onclick="checkPass()">审核通过</button>
		<button class='detail-button Stop' onclick="checkNo()">审核不通过</button>
		<button class='detail-button Delete' onclick="del()">删除话题</button>
	</div>
</div>
<!-- pass弹窗 -->
<div class="pass-window" style="display: none;">
	<div class="window-tip">话题审核已通过</div>
	<div class="window-tip">已进行发布</div>
	<button class="btn-sure">确定</button>
</div>
<!-- del弹窗 -->
<div class="del-window" style="display: none;">
	<div class="window-tip">您确定删除话题</div>
	<div class="window-tip window-work-head">话题标题</div>
	<div style="display: none;" class='id detail-id'></div>
	<button class="btn-style btn-left">确定</button>
	<button class="btn-style btn-right">取消</button>
</div>
<div class="stop-window" style="display: none;">
	<div class="window-tip">请输入审核不通过的原因：</div>
	<textarea class='stop-reason' placeholder="请输入不通过原因..."></textarea>
	<button class="btn-style btn-stop">确定</button>
	<button class="btn-style btn-right">取消</button>
</div>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-examine-topic').css('background','#e1c5a5');

	var href = window.location.href;
	var index =  href.lastIndexOf("\/");  
	var id =  href.substring(index + 1, href.length);

	$.ajax({
        type:'POST',
        url:dgurl('/admin/check/topic/list/0'),
        data:{
        	id:id,
        	// status:0
        },
        datatype:"json",
        success:function(data){
            if(data.status==1){
            	var images = JSON.parse(data.data.images);
				console.log(images);
				var img_len = images.url.length;
				if (img_len) {
					imgpath1 = dgPicUrl(images.url[0]);
				} else{
					imgpath1 = '';
					$('.banner').empty();
				}
				if (data.data.status==0) {
					$('.detail-button').show();
				} else{
					$('.detail-button').hide();
				}
				$('.Delete').show();
            	$('.detial-pic-src').attr('src',imgpath1);
				$('#detail-body .large-head').html(data.data.title);
				// $('.window-work-head').html(data.data.title);
				$('.detail-des-body').html(data.data.content);
				var ele_li_first = $('<li class="first"></li>');
				// var ele_li_second =$( '<li class=second"></li>');
				$.each(images.url,function(key,val){
					var ele_img = $('<img src="'+dgPicUrl(images.url[key])+'" alt="无图片" width="260" height="200">');
					ele_li_first.append(ele_img);
				});
				$('.Carousel').append(ele_li_first);

				//调整左侧高度与右侧一致
				var right = $("#right").height();
				$('#left').css('height',right);
					
            }else{
                alert(data.message);
            }
        }              
    });

    function checkPass() {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/topic/status'),
	        data:{
	        	id:id,
	        	status:1
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	alert("审核通过！");
	                window.location.reload();
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}

	function checkNo() {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/topic/status'),
	        data:{
	        	id:id,
	        	status:-1
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	alert("审核不通过！");
	                window.location.reload();
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}

	function del() {
		var a = confirm('确认删除吗');
		if (a) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/check/topic/delete'),
		        data:{
		        	id:id
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
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