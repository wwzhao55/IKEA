$(document).ready(function(){
	var collect = document.getElementById('collect-title');
	var tab_content = document.querySelectorAll('.tab-content');
	var label = document.querySelectorAll('.title-name');
	tab_content[0].style.display = "block";
	label[0].className = 'title-name active';
	var tagName = 'product';
	function iteratorFactory(i){
	    var onclick = function(e){
	    	e = e || window.event; 　//IE window.event
	  		var t = e.target || e.srcElement; //目标对象
	  		switch(i){
				case 0:
					tagName = 'product';
					break;
				case 1:
				  	tagName = 'knowledge';
					break;
				case 2:
					tagName = 'activity';
					break;
				case 3:
					tagName = 'topic';
					break;
				default:
				  Message.showMessage('参数错误')
			}
	  		myCollect(tagName,1);
	    	label[i].className = 'title-name active';
	        tab_content[i].style.display = "block";
	        for (var j = 0; j < label.length; j++){
	        	if(j!=i){
	        		label[j].className = "title-name";
	        		tab_content[j].style.display = "none";
	        	}
	        }
	    }
	    return onclick; //闭包搞定
	}
	for (var i = 0; i < label.length; i++){
	    label[i].onclick = iteratorFactory(i)
	}
	myCollect('product',1);

	function myCollect(tagName,page){
		var page = 1;
        if (page == 1) {
            $("#"+tagName+"-tag").empty();
            $(".my"+tagName+" .dropload-down").remove();
        }
        // dropload
        var dropload = $(".my"+tagName+"").dropload({
            scrollArea : window,
            domDown : {
                domClass : "dropload-down",
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadDownFn : function(me){
                $.ajax({
					url:dgurl('/app/user/collect-list'),
					data:{
						type:tagName,
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
	                            	switch(tagName){
										case 'product':
											processproductList(data)
											break;
										case 'knowledge':
										  	processknowledgeList(data)
											break;
										case 'activity':
											processactivityList(data)
											break;
										case 'topic':
											processtopicList(data)
											break;
										default:
										  Message.showMessage('参数错误')
									}
	                            	var evalText = doT.template($("#"+tagName+"tmpl").text());
									$("#"+tagName+"-tag").append(evalText(data));
	                                
	                                if (data.is_lastPage) {
		                            	// 锁定
			                            me.lock();
			                            // 无数据
			                            me.noData();
			                            // return false;
			                            $(".my"+tagName+" .dropload-down").html('没有更多数据了')
		                            }
		                            // 每次数据加载完，必须重置
	                                me.resetload();
	                            },500);
                        	}else{
                        		// 锁定
	                            me.lock();
	                            // 无数据
	                            me.noData();
	                            // return false;
	                            $(".my"+tagName+" .dropload-down").html('没有更多数据了')
	                            me.resetload();
                        	}
                        }else{
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                            // return false;
                            $("dropload-down").html('没有更多数据了')
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

    function processproductList(data) {
		for (var i = 0; i < data.data.length; i++) {
			var product = data.data[i];
			product.main_img = dgPicUrl(product.main_img);
			product.head_img = dgPicUrl(product.head_img);
			product.href = dgurl('/app/product/info?product='+product.id);
		}
	}
	function processknowledgeList(data) {
		for (var i = 0; i < data.data.length; i++) {
			var knowledge = data.data[i];
			knowledge.main_img = dgPicUrl(knowledge.main_img);
			//knowledge.head_img = dgPicUrl(knowledge.head_img);
			knowledge.href = dgurl('/app/knowledge/info?article='+knowledge.id);
		}
	}
	function processactivityList(data) {
		for (var i = 0; i < data.data.length; i++) {
			var activity = data.data[i];
			activity.main_img = dgPicUrl(JSON.parse(activity.main_images)[0]);
			//activity.head_img = dgPicUrl(activity.head_img);
			activity.href = dgurl('/app/activity/info?activity='+activity.id);
			activity.nowTime = Date.parse(new Date())/1000;
			console.log(activity.main_img)
		}
	}
	function processtopicList(data) {
		for (var i = 0; i < data.data.length; i++) {
			var topic = data.data[i];
			topic.main_img = dgPicUrl(topic.main_img);
			topic.head_img = dgPicUrl(topic.head_img);
			topic.href = dgurl('/app/topic/info?article='+topic.id);
			topic.time = format(topic.updated_at);
		}
	}
	function add0(m){return m<10?'0'+m:m }
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
})