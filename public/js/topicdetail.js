var ModalHelper = (function(bodyCls) {
    var scrollTop;
    return {
        afterOpen: function() {
            scrollTop = document.scrollingElement.scrollTop||document.body.scrollTop;
            document.body.classList.add(bodyCls);
            document.body.style.top = -scrollTop + 'px';
            document.body.scrollTop = 0;
        },
        beforeClose: function() {
            document.body.classList.remove(bodyCls);
            // scrollTop lost after set position:fixed, restore it back.
            document.scrollingElement.scrollTop = scrollTop;
        }
    };
})('modal-open');
$(document).ready(function(){
    // $('.as_back').on('click',function(){
    //     window.location.href=dgurl("/app/community/index?type=1");
    // });

    //点赞知识
    $('.txt_zan').on('click',function(){
        var obj=$(this);
        var zan_num=obj.children('.txt_action_num').html();
        var is_like=$('.is_like').html();
        $.ajax({
            url:dgurl("/app/topic/like"),
            data:{
                article:$('.topic_id').html()
            },
            type:"POST",
            dataType:"json",
            success:function(data){
                if(!data.status){
                    if(is_like==1){
                        $('.is_like').html('0');
                        obj.children('img').attr('src',dgurl('/img/association/icon_praise_topic_details.png'));
                        obj.children('.txt_action_num').html(--zan_num);
                    }else{
                        $('.is_like').html('1');
                        obj.children('img').attr('src',dgurl('/img/association/icon_praise_topic_details1.png'));
                        obj.children('.txt_action_num').html(++zan_num);
                    }
                }else{
                    if(data.status==-1){
                    	if(is_like==1){
	                        $('.is_like').html('0');
	                        obj.children('img').attr('src',dgurl('/img/association/icon_praise_topic_details.png'));
	                        obj.children('.txt_action_num').html(--zan_num);
	                    }else{
	                        $('.is_like').html('1');
	                        obj.children('img').attr('src',dgurl('/img/association/icon_praise_topic_details1.png'));
	                        obj.children('.txt_action_num').html(++zan_num);
	                    }
                        // Message.showConfirm(data.msg, "确定", "关闭", function () {
                        //     window.location.href=dgurl("/app/auth/login?refer="+encodeURIComponent("app/topic/info?article="+topicId));

                        // });
                    }else{
                        Message.showMessage(data.msg);
                    }
                }
            }
        })

    });
    var topicId=$('.topic_id').html();
    //收藏
    $('.txt_like').on('click',function(){
        var obj=$(this);
        $.ajax({
            url:dgurl("/app/topic/collect"),
            data:{
                article:$('.topic_id').html()
            },
            type:"POST",
            dataType:"json",
            success:function(data){
                if(!data.status){
                    if(obj.children('.txt_action_num').html()=='收藏'){
                        obj.children('img').attr('src',dgurl('/img/association/icon_collect_activity_details1.png'));
                        obj.children('.txt_action_num').html('已收藏');
                    }else{
                        obj.children('img').attr('src',dgurl('/img/association/icon_collect_activity_details.png'));
                        obj.children('.txt_action_num').html('收藏');
                    }
                }else{
                    if(data.status==-1){
                        Message.showConfirm(data.msg, "确定", "关闭", function () {
                            window.location.href=dgurl("/app/auth/login?refer="+encodeURIComponent("app/topic/info?article="+topicId));
                        }, function () {

                        });
                    }else{
                        Message.showMessage(data.msg);
                    }
                }
            }
        })
    });
    //获取评论列表
    function Initcomment(page){
        var page = 1;
        if (page == 1) {
            $('.replylists .dropload-down').remove();
        }
        // dropload
        var dropload = $('.replylists').dropload({
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
                    url:dgurl('/app/comment/list'),
                    data:{
                        page:page,
                        article:$('.topic_id').html(),
                        type:"topic"
                    },
                    type:'GET',
                    dataType:'json',
                    success:function(data){
                        page++;
                        if(!data.status){
                            if(data.data.length){
                                // 为了测试，延迟1秒加载
                                setTimeout(function(){
                                    function processCommentList(data) {
                                        for (var i = 0; i < data.data.length; i++) {
                                            var topic = data.data[i];
                                            topic.head_img = dgPicUrl(topic.head_img);
                                            topic.created_at = format(topic.created_at);
                                            topic.zan_comment='onclick="reply_zan('+topic.id+',this)"';
                                        }
                                    }
                                    processCommentList(data);
                                    var evalText = doT.template($("#comment").text());
                                    $(".replyLists").append(evalText(data));
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
    Initcomment(1);
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
    //评论
    $('.comment_input').on('click',function(){
        $('.window_comment').css('display','block');
        $('.foot_comment').css('display','none');
        $('.cover').css('display','block');
        $('.window_write_comment').html("");
        $('.window_write_comment').focus();
        ModalHelper.afterOpen();
    });
    $('.txt_comment').on('click',function(){
		$('.comment_input').click();
	});
	// if (!flow) {
	//     $("body").unbind("touchmove");
	// }else{
	//     $("body").bind("touchmove",function(event){
	//         event.preventDefault();
	//     });
	// }
    $('.window_quit').on('click',function(){
        $('.window_comment').css('display','none');
        $('.foot_comment').css('display','block');
        $('.cover').css('display','none');
        $('.face').hide(0);
        lanren.cur =0;
        ModalHelper.beforeClose();
    });
    $('.window_write_comment').on('click',function(){
        $('.face').css('display','none');
    });

    var lanren = {
        face:function(_this){
            var target = $(_this).html();
            if(target.length < 5){
                $(_this).html('<img src="'+dgurl('/img/face/'+target+'.gif') +'"/>');
            }
        },
        faceimg:'',
        imgs:function(min,max){
            for(i=min;i<max;i++){  //通过循环创建60个表情，可扩展
                lanren.faceimg+='<li><a href="javascript:void(0)"><img src="'+dgurl('/img/face/'+(i+1)+'.gif')+'" face="<emt>'+(i+1)+'</emt>"/></a></li>';
            };
        },
        cur:0
    }

    $('.list li emt').each(function(){
        lanren.face(this);
    });
    $('.foot_comment img').on('click',function(){
        $('.window_comment').css('display','block');
        $('.foot_comment').css('display','none');
        $('.cover').css('display','block');
        $('.window_write_comment').html("");
        if(lanren.cur == 0){
            // $(this).addClass('on');
            lanren.cur =1;
            $('.face').show(0);
        }else if(lanren.cur == 1){
            //$(this).removeClass('on');
            $('.face').hide(0);
            lanren.cur =0;
        }
        ModalHelper.afterOpen();
        $(".face").css('overflow','auto');
    })
    $('.window_emoij img').on('click',function(){
        if(lanren.cur == 0){
            // $(this).addClass('on');
            lanren.cur =1;
            $('.face').show(0);
        }else if(lanren.cur == 1){
            //$(this).removeClass('on');
            $('.face').hide(0);
            lanren.cur =0;
            //$('.window_write_comment').focus();
        }
        $(".face").css('overflow','auto');
    })
    lanren.imgs(0,32);
    $('.face').append(lanren.faceimg);

    $('.face li img').on('click',function(){
        var target = $(this).attr('face');
        var num = target.replace(/[a-z,A-Z,/,~'!<>@#$%^&*()-+_=:]/g, "");
        var pre = $('.window_write_comment').html();//可以作为显示用
        var showimg = '<img src="'+dgurl('/img/face/'+num+'.gif')+'">';
        $('.window_write_comment').html(pre+showimg);//target对应showimg
        //$(this).parents('.face').hide(0);
        //$('.send .faces').removeClass('on');
        //lanren.cur =0;
        // lanren.face(this);
    });
    $('.window_confirm').on('click',function(){
        var a = $('.window_write_comment').html();
        //console.log(a);
        //a = a.replace(/<img src="\/img\/face\/(\d+?)\.gif">/g, "{:$1}")//要显示的
        //var b = a.replace(/\{\:(\d+?)}/g,'<img src="'+dgurl('\/img\/face\/$1\.gif')+'">');//要提交的
        a=a.replace(/(^s*)|(s*$)/g, "");
        if(!a){
            Message.showMessage('发布内容不能为空');
            //$('#content').focus();
            return false;
        }
       
        $.ajax({
            url:dgurl("/app/comment/send"),
            data:{
                article:$('.topic_id').html(),
                comment:a,
                type:"topic"
            },
            type:"POST",
            dataType:"json",
            success:function(data){
                $('.window_comment').css('display','none');
                $('.foot_comment').css('display','block');
                $('.cover').css('display','none');
                if(!data.status){
                    Message.showMessage('评论已发送,等待审核');
                }else{
                    if(data.status==-1){
                        Message.showConfirm(data.msg, "确定", "关闭", function () {
                            window.location.href=dgurl("/app/auth/login?refer="+encodeURIComponent("app/topic/info?article="+topicId));
                        }, function () {

                        });
                    }else{
                        Message.showMessage(data.msg);
                    }
                }
            }
        });
        ModalHelper.beforeClose();
    });

})
//点赞评论
function reply_zan(id,event){
    var obj=$(event);
    //console.log(obj);
    var topicId=$('.topic_id').html();
    var is_like=obj.parents('.replylist').find('.comment_is_like').html();
    var zan_num=obj.parents('.replylist').find('.reply_comment_icon').html();
    $.ajax({
        url:dgurl("/app/comment/like"),
        data:{
            article:$('.topic_id').html(),
            type:"topic",
            comment:id
        },
        type:"POST",
        dataType:"json",
        success:function(data){
            if(!data.status){
                if(is_like==0){
                    obj.parents('.replylist').find('.comment_is_like').html("1");
                    obj.attr('src',dgurl('/img/association/icon_praise_topic_details1.png'));
                    obj.parents('.replylist').find('.reply_comment_icon').html(++zan_num);
                }else{
                    obj.parents('.replylist').find('.comment_is_like').html("0");
                    obj.attr('src',dgurl('/img/association/icon_praise_topic_details.png'));
                    obj.parents('.replylist').find('.reply_comment_icon').html(--zan_num);
                }
            }else{
                if(data.status==-1){
                	if(is_like==0){
	                    obj.parents('.replylist').find('.comment_is_like').html("1");
	                    obj.attr('src',dgurl('/img/association/icon_praise_topic_details1.png'));
	                    obj.parents('.replylist').find('.reply_comment_icon').html(++zan_num);
	                }else{
	                    obj.parents('.replylist').find('.comment_is_like').html("0");
	                    obj.attr('src',dgurl('/img/association/icon_praise_topic_details.png'));
	                    obj.parents('.replylist').find('.reply_comment_icon').html(--zan_num);
	                }
                    // Message.showConfirm(data.msg, "确定", "关闭", function () {
                    //     window.location.href=dgurl("/app/auth/login?refer="+encodeURIComponent("app/topic/info?article="+topicId));
                    // }, function () {

                    // });
                }else{
                    Message.showMessage(data.msg);
                }
            }
        }
    })

};