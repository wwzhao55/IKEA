<!-- auth:zww
	 date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
	<link rel="stylesheet" type="text/css" href="{{url('/css/my.css')}}">
	<div id="my-coupon">
		<div id="page-top">
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" id="page-history">
            </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
			<h1>我的优惠券</h1>
		</div>
		<div id="non-coupon" hidden>
			<img src="{{url('img/user/noncoupon.png')}}" id="noncoupon-pic">
			<p ic="non-coupon-tip">您还没有优惠券</p>	
		</div>

		<div id="has-coupon" hidden>
		</div>
		<div id="copyRight" style="position: fixed;width: 100%;bottom: 0;background-color: #f6f6f6;padding: 0.2rem;margin:0;">
            <img src="{{url('/img/overview/copyright.png')}}">
        </div>
	</div>
	<script type="text/javascript" src="{{url('/js/myCoupon.js')}}"></script>
	<script id="coupontmpl" type="text/x-dot-template">
	@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
		<div class="coupon-item" style="background-image: url({{url('/img/user/coupon-background.png')}});">
			<div class="coupon-item-left">
				<p class="coupon-item-left-money">@{{=it.data[i].value}}</p>
				<p class="coupon-item-left-name">优惠券</p>
			</div>
			<div class="coupon-item-right">
				<p class="coupon-item-left-code">兑换码：@{{=it.data[i].code}}</p>
				<p class="coupon-item-left-describe">兑换说明：优惠券可在线下门店进行使用</p>
			</div>
		</div>
	@{{ } }}
</script>
@stop