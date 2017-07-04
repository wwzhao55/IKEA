@extends('app.index')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('/plugin/unslider.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('/plugin/unslider-dots.css')}}">	
<script type="text/javascript" src="{{url('/plugin/unslider.min.js')}}"></script>
<script type="text/javascript" src="{{url('/plugin/jquery.touchSwipe.min.js')}}"></script>
<link rel="stylesheet" href="{{url('/css/overview.css')}}">
<div class="top_title" style="position: relative;">
    <img src="{{url('/img/association/logo.png')}}" style="position: absolute;top: 0.28rem;
    left: 0.7rem;width: 0.95rem;">
	<span>和孩子一起生活</span>
</div>
<div class="container">
	<div class="banner" style="height:3.34rem;">
		<ul class="slider_content">
	        @foreach($carousel as $list)
			<li><a href='{{$list->link}}'><img src="{{dgPicUrl($list->image)}}"></a></li>
			@endforeach
	    </ul>
	</div> 
</div>
<div class="overview_container" id="chat_container">
	<div class="container_title">
		<div class="title_name">大家都在聊</div>
		<div class="title_view"><span style="margin-right: 20px"><a href="{{url('/app/community/index?type=1')}}">查看全部</a></span><span>></span></div>
		<div class="clearfix"></div>
	</div>
	<div class="container_content">
	@foreach($topic as $list)
		<div class="topic_item" onclick="chat({{$list->id}})">
		 	@if($list->main_img)
 			<img src="{{dgPicUrl($list->main_img)}}-690c" class="topic_img">
 			@endif
			<!-- <img src="{{dgPicUrl($list->main_img)}}-690c" class="topic_img"> -->
			<div class="topic_title">
				<span style="float: left;">{{$list->title}}</span>
				<span style="float: right;color: #ccc;">{{$list->create_at}}</span>
			</div>
			<div class="topic_disc">{{$list->content}}</div>
			<div class="topic_user">
				<div class="topic_info">
					<img src="{{dgPicUrl($list->head_img)}}">
					<span class="user_name">{{$list->username}}</span>
				</div>
				<div class="topic_count">
					<span><span>{{$list->like_num}}</span>个赞</span>
					<span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
					<span><span>{{$list->comment_num}}</span>条评论</span>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	@endforeach
	</div>
</div>
<div class="overview_container">
	<div class="container_title">
		<div class="title_name">优惠活动</div>
		<div class="title_view"><span style="margin-right: 20px"><a href="{{url('/app/community/index?type=2')}}">查看全部</a></span><span>></span></div>
		<div class="clearfix"></div>
	</div>
	<div class="container_content">
	{{-- @foreach($activity as $list)
		<div class="activity_topic" style="background: url('{{dgPicUrl($list->main_images)}}');background-size:100% 100%; " onclick="activity({{$list->id}})">

		</div>
	@endforeach
	--}}
	    <div class="activity_topic" style="background: url('{{url('img/arrange.png')}}');background-size:100% 100%; " onclick="window.location.href=dgurl('/app/arrange');">

		</div>
	</div>
</div>
<div style="height: 0.2rem;text-align: center;margin-bottom: 0.76rem">
	<img src="{{url('/img/overview/copyright.png')}}" style="height: 100%;vertical-align: top;">
</div>
<div class="index_foot">
  <a href="{{url('/app/index')}}">
    <div class="footlist">
      <img src="{{url('/img/association/icon_home_click.png')}}"  class="index-pic">
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
      <img src="{{url('/img/association/icon_mine_unclicked_tab.png')}}" class="user-pic">
      <div class="icon_name">个人</div>
    </div>
  </a>
</div>

<script type="text/javascript" src="{{url('/js/overview.js')}}"></script>		
@stop	
