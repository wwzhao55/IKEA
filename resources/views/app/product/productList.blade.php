<!-- auth:zww
     date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content') 
    <link rel="stylesheet" href="{{url('/css/product.css')}}"> 
    <div id="productpage">       
        <div id="page-top">
            <a href="javascript:" onclick="window.history.back();">
                    <img src="{{url('/img/product/back.png')}}" id="page-history">
                </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
            <h1>{{$category}}</h1>
        </div>
        <div id="product-list">
        </div>
    </div>
    <div id="copyRight">
        <img src="{{url('/img/overview/copyright.png')}}">
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
    <script id="ptoductListtmpl" type="text/x-dot-template">
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
                <div class="list-item-right-color">颜色 @{{=it.data[i].color}}</div>
                <div class="list-item-right-code">货号 @{{=it.data[i].item_num}}</div>
                <div class="list-item-right-size">尺寸 @{{=it.data[i].size}}</div>
            </div>
        </div>
        @{{ } }}
    </script>
    <script type="text/javascript" src="{{url('/js/productList.js')}}"></script>
@stop
