@extends('admin.app')
@section('main')
<div id='main-body'>
	<div class='pagetitle'>宜家/话题审核</div>
	<span class='choose-type topic_active'>待审核</span>
	<span class='choose-type'>未通过</span>
	<span class='choose-type'>已通过</span>
	<div class='no-exammine'>
		<div class='no-exammine-table alllist'>
		</div>
		<div id="pagnation1" class='pagnation_style'></div>
	</div>
	<div class='no-pass' style='display: none;'>
		<div class='pass-table alllist'>
		</div>
		<div id="pagnation2" class='pagnation_style'></div>
	</div>
	<div class='pass' style='display: none;'>
		<div class='pass-table alllist'>
		</div>
		<div id="pagnation3" class='pagnation_style'></div>
	</div>
</div>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-examine-topic').css('background','#e1c5a5');

	$('.choose-type').click(function(){
		$('.choose-type').removeClass('topic_active');
		$(this).addClass('topic_active');
		if($(this).html()=='待审核'){
			$('.no-pass').hide();
			$('.pass').hide();
			$('.no-exammine').show();
			noExamine(0);
		}else if($(this).html()=='未通过'){
			$('.no-pass').show();
			$('.pass').hide();
			$('.no-exammine').hide();
			noPass(0);				
		} else{
			$('.no-exammine').hide();
			$('.no-pass').hide();
			$('.pass').show();
			pass(0);
		}
	});

	function noExamine(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/topic/list/'+num),
	        data:{
	        	id:0,
	        	status:0
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	$('.alllist').empty();
	            	// console.log(result.data)
					$.each(result.data,function(key,val){
						var images = JSON.parse(val.images);
						console.log(images);
						if (images.url.length) {
							imgpath = dgPicUrl(images.url[0]);
						} else{
							imgpath = '';
						}
						var link = dgurl('/admin/check/topic/detail/'+val.id);
						var ele = '<div class="worklist">'+
									'<div class="work-pic"><img alt="无图片" src="'+imgpath+'" class="work-pic-src"></div>'+
									'<div class="work-head">'+
										'<div class="large-head">'+val.title+'</div>'+
										'<div class="small-head">'+val.content+'</div>'+
									'</div>'+
									'<div class="work-deal">'+
										'<span class="btn-deal Pass" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">通过</span>'+
										'<span class="btn-deal noPass" onclick="checkNo(\''+val.id+'\',\''+val.status+'\')">不通过</span>'+
										'<a href="'+link+'"><span class="btn-deal Detail"</span>详情</a>'+
										
										'<span style="display: none;" class="btn-deal id">'+val.id+'</span>'+
									'</div>'+
								'</div>';
						$('.alllist').append(ele);
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
						        url:dgurl('/admin/check/topic/list/'+nowpage),
						        data:{
						        	id:0,
						        	status:0
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('.alllist').empty();
						            	var imgp;
										$.each(result.data,function(key,val){
											var images = JSON.parse(val.images);
											console.log(images);
											if (images.url.length) {
												imgpath = dgPicUrl(images.url[0]);
											} else{
												imgpath = '';
											}
											var link = "{{url('/admin/check/topic/detail')}}";
											var ele = '<div class="worklist">'+
														'<div class="work-pic"><img alt="无图片" src="'+imgpath+'" class="work-pic-src"></div>'+
														'<div class="work-head">'+
															'<div class="large-head">'+val.title+'</div>'+
															'<div class="small-head">'+val.content+'</div>'+
														'</div>'+
														'<div class="work-deal">'+
															'<span class="btn-deal Pass" onclick="checkPass(\''+val.id+'\',\''+val.status+'\')">通过</span>'+
															'<span class="btn-deal noPass" onclick="checkNo(\''+val.id+'\',\''+val.status+'\')">不通过</span>'+
															'<a href="'+link+'"><span class="btn-deal Detail"</span>详情</a>'+
															'<span style="display: none;" class="btn-deal id">'+val.id+'</span>'+
														'</div>'+
													'</div>';
											$('.alllist').append(ele);
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

	function noPass(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/topic/list/'+num),
	        data:{
	        	id:0,
	        	status:-1
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	$('.alllist').empty();
	            	var images;
					$.each(result.data,function(key,val){
						images = JSON.parse(val.images);
						console.log(images);
						if (images.url.length) {
							imgpath = dgPicUrl(images.url[0]);
						} else{
							imgpath = '';
						}
						var link = dgurl('/admin/check/topic/detail/'+val.id);
						var ele = '<div class="worklist">'+
									'<div class="work-pic"><img alt="无图片" src="'+imgpath+'" class="work-pic-src"></div>'+
									'<div class="work-head">'+
										'<div class="large-head">'+val.title+'</div>'+
										'<div class="small-head">'+val.content+'</div>'+
									'</div>'+
									'<div class="work-deal">'+
										'<a href="'+link+'"><span class="btn-deal Detail"</span>详情</a>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span style="display: none;" class="btn-deal id">'+val.id+'</span>'+
									'</div>'+
								'</div>';
						$('.alllist').append(ele);
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
						        url:dgurl('/admin/check/topic/list/'+nowpage),
						        data:{
						        	id:0,
						        	status:-1
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('.alllist').empty();
						            	var images;
										$.each(result.data,function(key,val){
											images = JSON.parse(val.images);
											console.log(images);
											if (images.url.length) {
												imgpath = dgPicUrl(images.url[0]);
											} else{
												imgpath = '';
											}
											var link = "{{url('/admin/check/topic/detail')}}";
											var ele = '<div class="worklist">'+
														'<div class="work-pic"><img alt="无图片" src="'+imgpath+'" class="work-pic-src"></div>'+
														'<div class="work-head">'+
															'<div class="large-head">'+val.title+'</div>'+
															'<div class="small-head">'+val.content+'</div>'+
														'</div>'+
														'<div class="work-deal">'+
															'<a href="'+link+'"><span class="btn-deal Detail"</span>详情</a>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
														'</div>'+
													'</div>';
											$('.alllist').append(ele);
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

	function pass(num) {
		$.ajax({
	        type:'POST',
	        url:dgurl('/admin/check/topic/list/'+num),
	        data:{
	        	id:0,
	        	status:1
	        },
	        datatype:"json",
	        success:function(result){
	            if(result.status==1){
	            	$('.alllist').empty();
	            	var images;
					$.each(result.data,function(key,val){
						images = JSON.parse(val.images);
						console.log(images);
						if (images.url.length) {
							imgpath = dgPicUrl(images.url[0]);
						} else{
							imgpath = '';
						}
						var link = dgurl('/admin/check/topic/detail/'+val.id);
						var ele = '<div class="worklist">'+
									'<div class="work-pic"><img alt="无图片" src="'+imgpath+'" class="work-pic-src"></div>'+
									'<div class="work-head">'+
										'<div class="large-head">'+val.title+'</div>'+
										'<div class="small-head">'+val.content+'</div>'+
									'</div>'+
									'<div class="work-deal">'+
										'<a href="'+link+'"><span class="btn-deal Detail"</span>详情</a>'+
										'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
										'<span style="display: none;" class="btn-deal id">'+val.id+'</span>'+
									'</div>'+
								'</div>';
						$('.alllist').append(ele);
					});

					//调整左侧高度与右侧一致
					var right = $("#right").height();
					$('#left').css('height',right);
					
					if (result.count>10) {
						$('#pagnation3').bootpag({
							    total: Math.ceil(result.count/page),
							    maxVisible: 6,
		                }).on("page", function (event, num) {
		                	var nowpage = num-1;
							$.ajax({
						        type:'POST',
						        url:dgurl('/admin/check/topic/list/'+nowpage),
						        data:{
						        	id:0,
						        	status:1
						        },
						        datatype:"json",
						        success:function(result){
						            if(result.status==1){
						            	$('.alllist').empty();
						            	var images;
										$.each(result.data,function(key,val){
											images = JSON.parse(val.images);
											console.log(images);
											if (images.url.length) {
												imgpath = dgPicUrl(images.url[0]);
											} else{
												imgpath = '';
											}
											var link = "{{url('/admin/check/topic/detail')}}";
											var ele = '<div class="worklist">'+
														'<div class="work-pic"><img alt="无图片" src="'+imgpath+'" class="work-pic-src"></div>'+
														'<div class="work-head">'+
															'<div class="large-head">'+val.title+'</div>'+
															'<div class="small-head">'+val.content+'</div>'+
														'</div>'+
														'<div class="work-deal">'+
															'<a href="'+link+'"><span class="btn-deal Detail"</span>详情</a>'+
															'<span class="comment-btn DelBtn" onclick="del(\''+val.id+'\')">删除</span>'+
														'</div>'+
													'</div>';
											$('.alllist').append(ele);
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
	noExamine(0);

	function checkPass(id,status) {
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

	function checkNo(id,status) {
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

	function del(id) {
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