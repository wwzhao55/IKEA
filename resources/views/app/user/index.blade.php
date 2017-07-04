<!-- auth:zww
	 date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')
	<link rel="stylesheet" type="text/css" href="{{url('/css/my.css')}}">
	<div id='userPage'>
		<div id="page-top">
			<img src="{{url('/img/association/logo.png')}}" class="logo">
			<h1>个人中心</h1>
		</div>
		<div class="user-info-head">
			<img src="{{dgPicUrl($headimg)}}" id="head">
			<form id="form-head">
				<input id="head-input" type="file"  name="headimg" onchange="fileSelected(this)" style="display: none;">
			</form>
			
			<h1 id="user-info-phone">{{$mobile}}</h1>
		</div>
		<div class="user-info-body">
			<a href="{{url('/app/user/my-collect')}}">
				<div class="info-item">
					<span class="info-item-logo"><img src="{{url('/img/user/collect.png')}}" class="collect-pic"></span>
					<span class="info-item-word">我的收藏</span>
					<span class="info-item-arrow"><img src="{{url('/img/user/arrow.png')}}"></span>
				</div>
			</a>
			<a href="{{url('/app/user/my-topic')}}">
				<div class="info-item">
					<span class="info-item-logo"><img src="{{url('/img/user/topic.png')}}" class="topic-pic"></span>
					<span class="info-item-word">我的话题</span>
					<span class="info-item-arrow"><img src="{{url('/img/user/arrow.png')}}"></span>
				</div>
			</a>
			<a href="{{url('/app/user/my-coupon')}}">
				<div class="info-item" style="border: none;" id="userPage-coupon">
					<span class="info-item-logo"><img src="{{url('/img/user/coupon.png')}}" class="coupon-pic"></span>
					<span class="info-item-word">我的优惠券</span>
					<span class="info-item-arrow"><img src="{{url('/img/user/arrow.png')}}"></span>
				</div>
			</a>
		</div>
	</div>
	<div id="get-coupon">
		<!-- <div class="get-coupon-body" style="background-image: url({{url('/img/user/coupons_get.png')}})">
			<div class="get-coupon-money">
				￥<span id="coupon-value"></span>
			</div>
			<div class="get-coupon-condition">
				仅限线下使用
			</div>
			<div class="get-coupon-button">
				<a href="{{url('/app/user/my-coupon')}}">
					<span class="coupon-btn pull-left">去查看</span>
				</a>
				<span class="coupon-btn pull-right" id="coupon-btn-cancle">取消</span>
			</div>
		</div> -->
	</div>
	<div id="copyRight" style="position: absolute;bottom: 1rem;width: 100%;left: 0;">
            <img src="{{url('/img/overview/copyright.png')}}">
        </div>
	<div class="index_foot">
			<a href="{{url('/app/index')}}">
				<div class="footlist">
					<img src="{{url('/img/association/icon_home_unclicked_tab.png')}}"  class="index-pic">
					<div class="icon_name">首页</div>
				</div>
			</a>
			<a href="{{url('/app/product/index')}}">	
				<div class="footlist">
					<img src="{{url('/img/association/icon_product_unclicked_tab.png')}}" class="product-pic">
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
				<div class="footlist  footOn">
					<img src="{{url('/img/association/mine_clicked.png')}}" class="user-pic">
					<div class="icon_name">个人</div>
				</div>
			</a>
	</div>
	<script type="text/javascript" src="{{url('/js/my.js')}}"></script>
@stop