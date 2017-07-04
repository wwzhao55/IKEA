<!-- auth:zww
     date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content') 

    <script type="text/javascript" src="{{url('/myadmin/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('/css/product.css')}}">       
	<div id="product-detail">
		<div id="page-top">
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" id="page-history">
            </a>
			<h1>产品详情</h1>
		</div>
        <div class="detail-main-image">
            <img src="{{url('/img/product/main.png')}}">
        </div>
        <div class="detail-content">
            <div class="detail-name">
                <div class="detail-product-name">宝宝摇摇马</div>
                <div class="detail-price">
                    <span class="detail-price-unit">￥</span>
                    <span class="detail-price-count">168</span>
                </div>
            </div>
            <div class="detail-number">
                <span class="detail-product-title">产品货号：</span>
                <span class="detail-product-number">#11231215#</span>
            </div>
            <div class="detail-describe">
                <span class="detail-product-alt">产品描述:</span>
                <span class="detail-product-describe">平衡发展对宝宝至关重要，宝宝骑上摇马，通过四肢腰腹力量使马前后摇晃，促进大脑平衡系统发育，锻炼宝宝的平衡力，做感舒适，预防</span>
            </div>
            <div class="detail-other-img">
                <img src="{{url('/img/product/other.png')}}" class="orther-imgage">
            </div>
        </div>  
    </div>
    <div id="detail-bottom">
        <div class="bottom-button pull-left">
            <img src="{{url('/img/product/collect.png')}}" class="button-image">
            <span>已收藏</span>
        </div>
        <div class="bottom-button pull-right">
            <img src="{{url('/img/product/comment.png')}}" class="button-image">
            <span>222</span>
            <span>条评论</span>
        </div>
    </div>
    <!-- 评论弹窗页 -->
    <div id="product-comment">
        <div id="page-top">
            <a href="javascript:" onclick="self.location=document.referrer;">
                <img src="{{url('/img/product/back.png')}}" id="page-history">
            </a>
            <h1>商品评价</h1>
        </div>
        <!-- 无评价 -->
        <div class="no-comment">
            <img src="{{url('/img/product/no-comment.png')}}" class="no-comment-pic">
            <div class="no-comment-word">此商品当前无任何评价</div>
        </div>
        <!-- 有评价 -->
        <div class="yes-comment">
            <div class="comment-list">
                <div class="comment-list-head">
                    <img src="{{url('/img/product/main_age.png')}}">
                </div>
                
                <div class="comment-list-content">
                    <span class="comment-list-address">北京</span>
                    <span class="comment-list-phone">131****8768</span>
                    <span class="comment-list-date">2017-04-13</span>
                </div>
                <div class="comment-content">
                    就看看看破i哦交流空间婆家婆婆机票接肯定没法理解开发破额看fold飓风龙卷风
                </div>
            </div>
            <div class="comment-list">
                <div class="comment-list-head">
                    <img src="{{url('/img/product/main_age.png')}}">
                </div>
                
                <div class="comment-list-content">
                    <span class="comment-list-address">北京</span>
                    <span class="comment-list-phone">131****8768</span>
                    <span class="comment-list-date">2017-04-13</span>
                </div>
                <div class="comment-content">
                    就看看看破i哦交流空间婆家婆婆机票接肯定没法理解开发破额看fold飓风龙卷风
                </div>
            </div>
            <div class="comment-list">
                <div class="comment-list-head">
                    <img src="{{url('/img/product/main_age.png')}}">
                </div>
                
                <div class="comment-list-content">
                    <span class="comment-list-address">北京</span>
                    <span class="comment-list-phone">131****8768</span>
                    <span class="comment-list-date">2017-04-13</span>
                </div>
                <div class="comment-content">
                    就看看看破i哦交流空间婆家婆婆机票接肯定没法理解开发破额看fold飓风龙卷风
                </div>
            </div>
        </div>
        <!-- 评论输入框 -->
        <div class="input-comment">
            <input type="text" name="" id="input-comment-click">
            <img src="{{url('/img/product/comment-input.png')}}" class="click-pic">
        </div>
        <div id="comment-pop">
            <div class="pop-title">
                <span class="pop-title-left">取消</span>
                <span class="pop-title-middle">发布评论</span>
                <span class="pop-title-right">发表</span>
            </div>
            <div id="comment-textarea" contenteditable="true" placeholder="说一说您对该商品的评价吧。"></div>
            <div class="pop-bottom">
                <img src="{{url('/img/product/comment-textarea.png')}}" class="face-pic">
            </div>
            <div class="face"></div>
        </div>
    </div>
    <script type="text/javascript">
        var index_button = document.querySelector(".pull-right");
        var info = document.getElementById('product-detail');
        var bottom = document.getElementById('detail-bottom');
        var comment = document.getElementById('product-comment');
        index_button.onclick = function(){
            info.style.display = 'none';
            bottom.style.display = 'none';
            comment.style.display = 'block';
        };
        $('#input-comment-click').bind({
            focus:function(){ 
                $('.input-comment').hide();
                $('#comment-pop').css('display','block');
                $('#comment-textarea').focus();
            }, 
            blur:function(){ 
                if (this.value == ""){ 
                this.value = this.defaultValue; 
                } 
            } 
        });
        $('.face-pic').click(function(){
            // $('.face').show(0);
            $('.face').toggle();
        });
        var lanren = {
            face:function(_this){
                var target = $(_this).html();
                if(target.length < 5){
                    var url = dgurl('/img/product/image/face/'+target+'.gif');
                    $(_this).html("<img src='"+url+"'/>");
                }
            },
            faceimg:'',
            imgs:function(min,max){
                for(i=min;i<max;i++){  //通过循环创建60个表情，可扩展
                    var url = dgurl('/img/product/image/face/'+(i+1)+'.gif');
                    lanren.faceimg+='<li><a href="javascript:void(0)"><img src="'+url+'" face="<emt>'+(i+1)+'</emt>"/></a></li>';
                };
            },
            cur:0
        };
        lanren.imgs(0,32);
        $('.face').append(lanren.faceimg);

        $('.face li img').on('click',function(){
            var target = $(this).attr('face');
            var num = target.replace(/[a-z,A-Z,/,~'!<>@#$%^&*()-+_=:]/g, "");
            var pre = $('#comment-textarea').html();//可以作为显示用
            var url = dgurl('/img/product/image/face/'+num+'.gif');
            var showimg = '<img src="'+url+'">';
            $('#comment-textarea').html(pre+showimg);//target对应showimg
            $('.face').hide(0);
        })
        $('.pop-title-right').click(function(){
            var a = $('#comment-textarea').html();
            a = a.replace(/<img src="\/img\/product\/image\/face\/(\d+?)\.gif">/g, "{:$1}")//要提交的
            var b = a.replace(/\{\:(\d+?)}/g,"<img src='\/img\/product\/image\/face\/$1\.gif'>");//要显示的
            if(!a){
                alert('发布内容不能为空');
                $('#comment-textarea').focus();
                return false;
            }else{
                $('#comment-textarea').html('');
                // post操作
            }
        });
        $('.pop-title-left').click(function(){
            $('.input-comment').show();
            $('#comment-pop').css('display','none');
            $('.face').hide(0);
        })
    </script>
@stop