$(document).ready(function(){
	setTimeout(function(){
		$('#association').removeClass('initShow');
	},500)
	var agelength=$('.selectAge span').length*155;
	$('.selectAge').css('width',agelength);
	$('.selectType span').on('click',function(){
		$('.selectType').find('.selected').removeClass('selected');
		$(this).addClass('selected'); 
		if($(this).html()=="知识"){
			window.location.href=dgurl("/app/community/index");
			// $('#knowledge').css('display','block');
			// $('#activity').css('display','none');
			// $('#topic').css('display','none');
		}else if($(this).html()=="活动"){
			window.location.href=dgurl("/app/community/index?type=2");
			// $('#knowledge').css('display','none');
			// $('#activity').css('display','block');
			// $('#topic').css('display','none');
		}else if($(this).html()=="话题"){
			window.location.href=dgurl("/app/community/index?type=1");
			// $('#knowledge').css('display','none');
			// $('#activity').css('display','none');
			// $('#topic').css('display','block');
		}
	});
	var url=window.location.href;
	var type=url.charAt(url.length -1);
	if(type=="1"){
		Inittopic(1);
		$('.selectType').find('.selected').removeClass('selected');
		$('.topic').addClass('selected');
		$('#knowledge').css('display','none');
		$('#activity').css('display','none');
		$('#topic').css('display','block');
	}else if(type=="2"){
		//Initactivity(1);
		$('.selectType').find('.selected').removeClass('selected');
		$('.activity').addClass('selected');
		$('#knowledge').css('display','none');
		$('#activity').css('display','block');
		$('#topic').css('display','none');
	}else{
		Initknowledge(1);
		$('.selectType').find('.selected').removeClass('selected');
		$('.knowledge').addClass('selected');
		$('#knowledge').css('display','block');
		$('#activity').css('display','none');
		$('#topic').css('display','none');
	}
	//切换年龄
	$('.selectAge span').on('click',function(){
		$('.selectAge').find('.ageOn').removeClass('ageOn');
		$(this).addClass('ageOn');
		$(".knowledgeLists").empty();
		Initknowledge(1);
	})
	//切换
	$('.footlist').on('click',function(){
		var name=$(this).children('.icon_name').html();
		if(name=='首页'){
			window.location.href=dgurl("/app/index");
		}else if(name=='产品'){
			window.location.href=dgurl("/app/product/index");
		}else if(name=='个人'){
			window.location.href=dgurl("/app/user/index");
		}else if(name=='社群'){
			window.location.href=dgurl("/app/community/index");
		}else{
			window.location.href=dgurl("/app/topic/index");
		}
	});

	//获取三大列表
	function Initknowledge(page){
		var page = 1;
        if (page == 1) {
            $('.knowledgelists .dropload-down').remove();
        }
        // dropload
        var dropload = $('.knowledgelists').dropload({
            scrollArea : window,
            domDown : {
                domClass : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadDownFn : function(me){
               // console.log(page);
                var category_id=$('.ageOn').attr('id');
                if(category_id==0){
                	$('.mainImg').show();
                }else{
                	$('.mainImg').hide();
                }
				$.ajax({
					url:dgurl('/app/knowledge/list'),
					data:{
						page:page,
						category:category_id
					},
					type:'GET',
					dataType:'json',
					success:function(data){
						page++;
						if(!data.status){
							if(data.data.length){
                        		// 为了测试，延迟1秒加载
	                            setTimeout(function(){
	                            	function processKnowledgeList(data) {
									    for (var i = 0; i < data.data.length; i++) {
									        var knowledge = data.data[i];
									        knowledge.main_img = dgPicUrl(knowledge.main_img);
									        //topic.head_img = dgPicUrl(topic.head_img);
									        knowledge.href = dgurl('/app/knowledge/info?article='+knowledge.id);
									    }
									}
									processKnowledgeList(data);
									var evalText = doT.template($("#knowledgetmpl").text());
									$(".knowledgeLists").append(evalText(data));
	                                // 每次数据加载完，必须重置
	                                me.resetload();
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $('.dropload-down').html('没有更多数据了')
		                            }
	                            },500);
                        	}else{
                        		me.resetload();
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $('.dropload-down').html('没有更多数据了')
		                            }
                        	}
							
						}else{
							// 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                            // return false;
                            $('.dropload-down').html('没有更多数据了');
						}	
					},
					error: function(xhr, type){
                        Message.showMessage('获取数据失败!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
				});
            },
            threshold : 50
        });
		
	}
	
	function Initactivity(page){
		var page = 1;
        if (page == 1) {
            $('#activity .dropload-down').remove();
        }
        // dropload
        var dropload = $('#activity').dropload({
            scrollArea : window,
            domDown : {
                domClass : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadDownFn : function(me){
                console.log(page);
				$.ajax({
					url:dgurl('/app/activity/list'),
					data:{
						page:page,
					},
					type:'GET',
					dataType:'json',
					success:function(data){
						page++;
						if(!data.status){
							if(data.data.length){
                        		// 为了测试，延迟1秒加载

	                            setTimeout(function(){
	                            	function processActivityList(data) {
	                            		
									    for (var i = 0; i < data.data.length; i++) {
									        var activity = data.data[i];									        
									        activity.main_images = dgPicUrl(activity.main_images[0])
									        //topic.head_img = dgPicUrl(topic.head_img);
									        activity.href = dgurl('/app/activity/info?activity='+activity.id);
									    }
									}
									processActivityList(data);
									console.log(data.data);
									var evalText = doT.template($("#activitytmpl").text());
									console.log(evalText(data));
									$(".activityLists").append(evalText(data));
	                                // 每次数据加载完，必须重置
	                                me.resetload();
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $('.dropload-down').html('没有更多数据了')
		                            }
	                            },500);
                        	}else{
                        		me.resetload();
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $('.dropload-down').html('没有更多数据了')
		                            }
                        	}
							
						}else{
							// 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                            // return false;
                            $('.dropload-down').html('没有更多数据了');
						}	
					},
					error: function(xhr, type){
                        Message.showMessage('获取数据失败!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
				});
            },
            threshold : 50
        });
	}
	
	function Inittopic(page){
		var page = 1;
        if (page == 1) {
            $('#topic .dropload-down').remove();
        }
        // dropload
        var dropload = $('#topic').dropload({
            scrollArea : window,
            domDown : {
                domClass : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadDownFn : function(me){
                console.log(page);
				$.ajax({
					url:dgurl('/app/topic/list'),
					data:{
						page:page,
					},
					type:'GET',
					dataType:'json',
					success:function(data){
						page++;
						if(!data.status){
							if(data.data.length){
                        		// 为了测试，延迟1秒加载
	                            setTimeout(function(){
	                            	function processTopicList(data) {
									    for (var i = 0; i < data.data.length; i++) {
									        var topic = data.data[i];
									        if(topic.main_img!=''){
									        	topic.main_img = dgPicUrl(topic.main_img);
									        }
									        
									        topic.head_img = dgPicUrl(topic.head_img);
									        topic.created_at = format(topic.created_at);
									        topic.href = dgurl('/app/topic/info?article='+topic.id);
									    }
									}
									processTopicList(data);
									var evalText = doT.template($("#topictmpl").text());
									$(".topicLists").append(evalText(data));
	                                // 每次数据加载完，必须重置
	                                me.resetload();
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $('.dropload-down').html('没有更多数据了')
		                            }
	                            },500);
                        	}else{
                        		me.resetload();
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $('.dropload-down').html('没有更多数据了')
		                            }
                        	}
							
						}else{
							// 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                            // return false;
                            $('.dropload-down').html('没有更多数据了');
						}	
					},
					error: function(xhr, type){
                        Message.showMessage('获取数据失败!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
				});
            },
            threshold : 50
        });
	}
	
	function format(date){
		var time = new Date(parseInt(date*1000));
		var y = time.getFullYear();
		var m = time.getMonth()+1;
		var d = time.getDate();
		var h = time.getHours() < 10 ? '0' + time.getHours() : time.getHours();
		var mm = time.getMinutes() <10 ? '0' + time.getMinutes() : time.getMinutes();
		var s = time.getSeconds() <10 ? '0' + time.getSeconds() : time.getSeconds();
		return h+':'+mm+':'+s;
	}
});