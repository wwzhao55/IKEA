<!-- auth:zww
	 date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
	<link rel="stylesheet" href="{{url('/css/product.css')}}"> 
	<div id="product-index">
		<div id="page-top">
			<a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" id="page-history">
            </a>
			<span id="search-title">
                <img src="{{url('/img/association/logo.png')}}" class="logo">
    			<h1>产品分类</h1>
    			<img src="{{url('/img/product/search.png')}}" id="page-search">
    		</span>
			<div id="search-top" hidden>
    			<img src="{{url('/img/product/search-input.png')}}" class="search-img">
    			<input type="search" placeholder="搜索您喜爱的产品" id="input-search" onchange="Search(event)">
    			<button class="search-cancle">取消</button>
    		</div>
		</div>
		<div id="page-body">
			<div class="productType age">
				<div class="type-name">年龄</div>
				<div class="container">
                    @foreach($age as $list)
                    <a href='{{url("/app/product/list?category_id=$list->id&category=age")}}'>
                        <div class="type-content">
                            <div class="content-item">
                                <img src="{{dgPicUrl($list->image)}}" class="main-img">
                                <span class="main-describe">{{$list->name}}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    <br clear="both"/>
				</div>
			</div>

			<div class="productType life">
				<div class="type-name">生活空间</div>
				<div class="container">
                @foreach($room as $list)
                <a href='{{url("/app/product/list?category_id=$list->id&category=room")}}'>
    				<div class="type-content">
    					<div class="content-item">
    						<img src="{{dgPicUrl($list->image)}}" class="main-img">
    						<span class="main-describe">{{$list->name}}</span>
    					</div>
    				</div>
                </a>
                @endforeach 
                <br clear="both"/>
    			</div>
			</div>
            <div id="copyRight">
                <img src="{{url('/img/overview/copyright.png')}}">
            </div>
		</div>
		<div id="product-list" style="display: none;">
            <div id="searchContainer"> </div>
        </div>
        <div id="productInfo-back"></div>
        <div id="productInfo">
            <div class="list-item">
                <img src="{{url('/img/product/product-list.png')}}" class="list-item-left" id="detailimg">
                <div class="list-item-right"> 
                    <div class="list-item-right-name" id="product-name"></div>
                    <div class="list-item-right-comment">￥<span id="product-price"></span></div>
                    <div class="list-item-right-color">颜色 <span id="product-color"></span></div>
                    <div class="list-item-right-code">货号 <span id="product-code"></span></div>
                    <div class="list-item-right-size">尺寸 <span id="product-size"></span></div>
                </div>
            </div>
        </div>
        <div class="index_foot">
            <a href="{{url('/app/index')}}">
                <div class="footlist">
                    <img src="{{url('/img/association/icon_home_unclicked_tab.png')}}"  class="index-pic">
                    <div class="icon_name">首页</div>
                </div>
            </a>
            <a href="{{url('/app/product/index')}}">    
                <div class="footlist   footOn">
                    <img src="{{url('/img/association/product_click.png')}}" class="product-pic">
                    <div class="icon_name">产品</div>
                </div>
            </a>
            <a href="{{url('app/topic/index')}}">
                <div class="footlist">
                    <img src="{{url('/img/association/icon_release_tab.png')}}" class="home-pic">
                </div>
            </a>
            <a href="{{url('/app/community/index')}}">  
                <div class="footlist">
                    <img src="{{url('/img/association/community_unclicked_tab.png')}}" class="community-pic">
                    <div class="icon_name">社群</div>
                </div>
            </a>
            <a href="{{url('/app/user/index')}}">   
                <div class="footlist">
                    <img src="{{url('/img/association/icon_mine_unclicked_tab.png')}}" class="user-pic">
                    <div class="icon_name">个人</div>
                </div>
            </a>
        </div>
	</div>
    <script id="searchtmpl" type="text/x-dot-template">
        @{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
        <div class="list-item" >
            <img src="@{{=it.data[i].main_img}}" class="list-item-left" @{{=it.data[i].detail}}>
            <div class="list-item-right">
                @{{? it.data[i].isCollect }}
                    <img src="{{url('img/product/collect.png')}}" class="list-item-right-collect" onclick="toogleCollect(@{{=it.data[i].id}},this)"> 
                @{{??}}
                    <img src="{{url('img/product/collect_icon.png')}}" class="list-item-right-collect" onclick="toogleCollect(@{{=it.data[i].id}},this)"> 
                @{{?}}
                <div class="list-item-right-name">@{{=it.data[i].name}}</div>
                <div class="list-item-right-comment">￥@{{=it.data[i].price}}</div>
            </div>
        </div>
        @{{ } }}
    </script>
    <script type="text/javascript" src="{{url('/js/productIndex.js')}}"></script>
    <script type="text/javascript">
        var flow = true; 
        function Search(event){
            var keyword = $('#input-search').val();
            var page = 1;
            if (page == 1) {
                $("#searchContainer").empty();
                $(".dropload-down").remove();
            }
            // dropload
            var dropload = $("#product-list").dropload({
                scrollArea : window,
                domDown : {
                    domClass : "dropload-down",
                    domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                    domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                    domNoData : '<div class="dropload-noData">没有更多数据了</div>'
                },
                loadDownFn : function(me){
                    $.ajax({
                        url: dgurl('/app/product/search'),
                        async: false,
                        type: 'GET',
                        data:{
                            page:page,
                            keyword:keyword
                        },
                        success:function(data){
                            page++;
                            if(!data.status){
                                if(data.data.length){
                                    // 为了测试，延迟1秒加载
                                    processproductList(data);
                                    setTimeout(function(){   
                                        var evalText = doT.template($("#searchtmpl").text());
                                        $("#searchContainer").append(evalText(data));
                                        if (data.is_lastPage) {
                                            // 锁定
                                            me.lock();
                                            // 无数据
                                            me.noData();
                                            // return false;
                                            $(".dropload-down").html('没有更多数据了')
                                        }
                                        // 每次数据加载完，必须重置
                                        me.resetload();
                                    },500);
                                }else{
                                    me.lock();
                                    // 无数据
                                    me.noData();
                                    // return false;
                                    $("dropload-down").html('没有搜到匹配的数据')
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
                            //alert('获取数据失败!');
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
                product.collect = 'onclick="Collect('+product.id+')"';
                product.detail = 'onclick="DetailInfo('+product.id+')"';
                product.canClick = true;
                productData.push(product);
            }
        }
        var ProductData = function() {
            this.data = {};
        };
        ProductData.prototype.push = function(product) {
            if (this.hasOwnProperty(product.id)) {
                throw Error('Product id duplicate');
                return;
            }
            this.data[product.id] = product;
        }
        ProductData.prototype.getProductById = function(productId) {
            if (this.data.hasOwnProperty(productId)) {
                return this.data[productId];
            }
            return null;
        }
        var productData = new ProductData();
        function DetailInfo(item){
            var product = productData.getProductById(item);
            if (product) {
                $('#detailimg').attr('src', product.main_img)
                $('#product-name').html(product.name);
                $('#product-price').html(product.price);
                $('#product-size').html(product.size);
                $('#product-color').html(product.color);
                $('#product-code').html(product.item_num);
                $('#productInfo-back').show();
                $('#productInfo').show();
            } 
            flow = false;
            document.body.scrollTop = document.documentElement.scrollTop = 0;
            $('body').css('overflow','hidden');
            if (!flow) {
                $("body").bind("touchmove",function(event){
                    event.preventDefault();
                });
            }
        }
        $('#productInfo-back').click(function(){
            $('#productInfo-back').hide();
            $('#productInfo').hide();
            $('body').css('overflow','auto');
            flow = true;
            $("body").unbind("touchmove");
        })
        if (flow) {
            $("body").unbind("touchmove");
        }else{
            $("body").bind("touchmove",function(event){
                event.preventDefault();
            });
        }
        function toogleCollect(id,event){
            var collect = dgurl('/img/product/collect.png');
            var noCollect = dgurl('/img/product/collect_icon.png');
            var product = productData.getProductById(id);
            if (product) {
                if (!product.canClick) return;
                if (product.isCollect) {
                    $(event).attr('src',noCollect);
                }else{
                    $(event).attr('src',collect);
                }
                product.canClick = false;
                $.ajax({
                    url: dgurl('/app/product/collect'),
                    type: 'POST',
                    data:{
                        product:id
                    },
                    success:function(data){
                        if(!data.status){
                            product.isCollect =!product.isCollect;
                        }else{
                            $(event).attr('src',noCollect);
                            if(data.status ==-1){
                                Message.showConfirm(data.msg, "确定", "关闭", function () {
                                    window.location.href = dgurl("/app/auth/login?refer="+encodeURIComponent("app/product/index"));
                                }, function () {

                                }); 
                            }else{
                                Message.showMessage(data.msg)
                            }
                        } 
                        product.canClick = true;
                    }
                })     
            }
        }
    </script>
@stop