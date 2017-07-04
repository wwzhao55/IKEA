@extends('admin.app')
@section('main')
<div id='main-body'>
	<div class='category_title' style=''>宜家/评论审核</div>
	<span class='comment_type comment_active'>活动</span>
	<span class='comment_type'>话题</span>
	<span class='comment_type'>知识</span>
	<!-- <span class='comment_type'>产品</span> -->
	<!-- <span class="btn_add_category">新增</span> -->
	<div class='activity list'>
		<div class='activity_table list'>

		</div>
		<div style="clear:both"></div>
		<div id="pagnation1" class='pagnation_style'></div>
	</div>
	<div class='topic' style='display: none;'>
		<div class='topic_table list'>
			
		</div>
		<div style="clear:both"></div>
		<div id="pagnation2" class='pagnation_style'></div>
	</div>
	<div class='knowledge' style='display: none;'>
		<div class='knowledge_table list'>
			
		</div>
		<div style="clear:both"></div>
		<div id="pagnation3" class='pagnation_style'></div>
	</div>
	<div class='product' style='display: none;'>
		<div class='product_table list'>
			
		</div>
		<div style="clear:both"></div>
		<div id="pagnation4" class='pagnation_style'></div>
	</div>
</div>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-examine-comment').css('background','#e1c5a5');

	$('.comment_type').click(function(){
		$('.list').empty();
		$('.comment_type').removeClass('comment_active');
		$(this).addClass('comment_active');
		if($(this).html()=='活动') {
			$('.activity').show();
			$('.knowledge').hide();
			$('.topic').hide();
			$('.product').hide();
			init1(0);
		} else if($(this).html()=='话题'){
			$('.activity').hide();
			$('.knowledge').hide();
			$('.product').hide();
			$('.topic').show();
			init2(0);	
		} else if ($(this).html()=='知识') {
			$('.activity').hide();
			$('.knowledge').show();
			$('.topic').hide();
			$('.product').hide();
			init3(0);
		} else {
			$('.activity').hide();
			$('.knowledge').hide();
			$('.topic').hide();
			$('.product').show();
			init4(0);
		}
	});

	function init1(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/comment/activity/'+num),
	        data:{
	        	// status:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	var nowstatus;
	            	$('.list').empty();
					$.each(result.data,function(key,val){
						if (val.status==0) {
							nowstatus = '待审核';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
							$('.noBtn').css('display','none');		            		
		            	} else {
		            		nowstatus = '审核通过';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
		            	} 
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
		                    $('.list').empty();
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/check/comment/activity/'+nowpage),
						        data:{
						        	// status:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	// console.log(result.data)
						            	var nowstatus;
						            	$('.list').empty();
										$.each(result.data,function(key,val){
											if (val.status==0) {
												nowstatus = '待审核';
							            		var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="status_hide" hidden>'+val.status+'</span>'+
															'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
												$('.list').append(ele);
												$('.noBtn').css('display','none');		            		
							            	} else {
							            		nowstatus = '审核通过';
							            		var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="status_hide" hidden>'+val.status+'</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
												$('.list').append(ele);
							            	} 
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

	function init2(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/comment/topic/'+num),
	        data:{
	        	// status:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	var nowstatus;
	            	$('.list').empty();
					$.each(result.data,function(key,val){
						if (val.status==0) {
							nowstatus = '待审核';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
							$('.noBtn').css('display','none');		            		
		            	} else {
		            		nowstatus = '审核通过';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
		            	} 
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
						        url:dgurl('/admin/check/comment/topic/'+nowpage),
						        data:{
						        	// status:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	// console.log(result.data)
						            	var nowstatus;
						            	$('.list').empty();
										$.each(result.data,function(key,val){
											if (val.status==0) {
												nowstatus = '待审核';
							            		var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="status_hide" hidden>'+val.status+'</span>'+
															'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
												$('.list').append(ele);
												$('.noBtn').css('display','none');		            		
							            	} else {
							            		nowstatus = '审核通过';
							            		var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="status_hide" hidden>'+val.status+'</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
												$('.list').append(ele);
							            	} 
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

	function init3(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/comment/knowledge/'+num),
	        data:{
	        	// status:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	var nowstatus;
	            	$('.list').empty();
					$.each(result.data,function(key,val){
						if (val.status==0) {
							nowstatus = '待审核';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
							$('.noBtn').css('display','none');		            		
		            	} else {
		            		nowstatus = '审核通过';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
		            	} 						
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
						        url:dgurl('/admin/check/comment/knowledge/'+nowpage),
						        data:{
						        	// status:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	// console.log(result.data)
						            	var nowstatus;
						            	$('.list').empty();
										$.each(result.data,function(key,val){
											if (val.status==0) {
												nowstatus = '待审核';
							            		var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="status_hide" hidden>'+val.status+'</span>'+
															'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
												$('.list').append(ele);
												$('.noBtn').css('display','none');		            		
							            	} else {
							            		nowstatus = '审核通过';
							            		var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="status_hide" hidden>'+val.status+'</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
												$('.list').append(ele);
							            	} 
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

	function init4(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/comment/product/'+num),
	        data:{
	        	// status:param
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	var nowstatus;
	            	$('.list').empty();
					$.each(result.data,function(key,val){
						if (val.status==0) {
							nowstatus = '待审核';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
							$('.noBtn').css('display','none');		            		
		            	} else {
		            		nowstatus = '审核未通过';
		            		var ele = '<div class="commentitem">'+
									'<div class="div_middle">'+val.content+'</div>'+
									'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
									'<div class="div_right">'+
										'<span class="status_hide" hidden>'+val.status+'</span>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span class="commentId" hidden>'+val.id+'</span>'+
									'</div>'+
								'</div>';
							$('.list').append(ele);
		            	} 
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
						        url:dgurl('/admin/check/comment/product/'+nowpage),
						        data:{
						        	// status:param
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	// console.log(result.data)
						            	var nowstatus;
										$.each(result.data,function(key,val){
											if (val.status==-1) {
							            		nowstatus = '审核未通过';
							            	} else if (val.status==1) {
							            		nowstatus = '审核通过';
							            	} else{
							            		nowstatus = '待审核';
							            	}
											var ele = '<div class="commentitem">'+
														'<div class="div_middle">'+val.content+'</div>'+
														'<a href="#"><div class="div_left">审核状态：'+nowstatus+'</div></a>'+
														'<div class="div_right">'+
															'<span class="comment-btn PassBtn" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">审核通过</span>'+
															'<span class="comment-btn noBtn" onclick="checkNo(\''+val.id+'\',\''+val.status+'\')">审核不通过</span>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
															'<span class="commentId" hidden>'+val.id+'</span>'+
														'</div>'+
													'</div>';
											$('.list').append(ele);
											$('.noBtn').css('display','none');
											if (val.status==-1) {
							            		$('.div_right').css('display','none');
							            	} else if (val.status==1) {
							            		$('.div_right').css('display','none');
							            	} 
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

	init1(0);

	// $(".list").on('click','.PassBtn',function () {
	// 	var commentId=parseInt($(this).siblings('.commentId').html());
	// 	var _this=$(this);
	// 	checkPass();
	// });
	// $(".list").on('click','.DelBtn',function () {
	// 	var commentId=parseInt($(this).siblings('.commentId').html());
	// 	var _this=$(this);
	// 	checkNo();
	// });
	// 
	var active_link;//当前类别
	function checkPass(id,status) {
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
	        	id:id,
	        	status:1
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	// console.log(result.data)
	            	// Message.showMessage("审核通过！");
	            	alert("审核通过！");
	                window.location.reload();
	            }else{
	                alert(result.message)
	            }
	        }              
    	});
	}

	function checkNo(id,status) {
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

	var del_link;
	function del(id) {
		if($('.comment_active').html()=='活动') {
			del_link = 'activity-delete';
		} else if($('.comment_active').html()=='话题'){
			del_link = 'topic-delete';
		} else if ($('.comment_active').html()=='知识') {
			del_link = 'knowledge-delete';
		} else {
			del_link = 'product-delete';
		}
		var a = confirm('确认删除吗');
		if (a) {
			$.ajax({
		        type:'POST',
		        url:dgurl('/admin/check/comment/'+del_link),
		        data:{
		        	id:id
		        },
		        datatype:"json",
		        success:function(result){
		            if(result.status==1){
		            	// console.log(result.data)
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