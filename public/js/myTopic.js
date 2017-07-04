function mytopic(){
    var page = 1;
    if (page == 1) {
        $('#topic').empty();
        $('.dropload-down').remove();
    }
    // dropload
    var dropload = $('#my-topic').dropload({
        scrollArea : window,
        domDown : {
            domClass : 'dropload-down',
            domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
            domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
            domNoData : '<div class="dropload-noData">没有更多数据了</div>'
        },
        loadDownFn : function(me){
           $.ajax({
				url:dgurl('/app/user/topic-list'),
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
                            	processTopicList(data);
                            	var evalText = doT.template($("#topictmpl").text());
								$("#topic").append(evalText(data));
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
                            me.lock();
                            // 无数据
                            me.noData();
                            // return false;
                            $("dropload-down").html('没有更多数据了')
                            me.resetload();
                        } 
                    }else{
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                        // return false;
                        $('.dropload-down').html('没有更多数据了')
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
mytopic();
function processTopicList(data) {
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