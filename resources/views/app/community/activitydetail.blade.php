<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
		<meta charset="utf-8" name="viewport" content="width=750, user-scalable=no">
		<meta http-equiv="cache-control" content="no-cache">
		<link rel="stylesheet" type="text/css" href="{{url('/plugin/unslider.css')}}">
		<link rel="stylesheet" type="text/css" href="{{url('/plugin/unslider-dots.css')}}">	
		<!-- <link rel="stylesheet" type="text/css" href="{{url('/plugin/site.css')}}"> -->	
		<link rel="stylesheet" type="text/css" href="{{url('/css/association.css')}}">
		<script type="text/javascript" src="{{url('/plugin/unslider.min.js')}}"></script>
		<script type="text/javascript" src="{{url('/plugin/jquery.touchSwipe.min.js')}}"></script>
		<script type="text/javascript" src="{{url('/js/activitydetail.js')}}"></script>
		<div class="activity_id" hidden>{{$activity->id}}</div>
		<div id="activitydetail">
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" class="as_back">
            </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
			<div class="selectType">活动详情</div>
			<div class="banner" style="height:334px;">
				<ul class="slider_content">
			        @foreach($activity->main_images as $list)
					<li><img class="activity_mainImg" src="{{dgPicUrl($list)}}"></li>
					@endforeach
			    </ul>
			</div> 
			
			<div class="activity_message">
				<div class="timeStart" hidden>{{$activity->start_time}}</div>
				<div class="registertimeEnd" hidden>{{$activity->register_end_time}}</div>
				<div class="activity_title">
					活动名称：<span class="activity_name">{{$activity->name}}</span>
				</div>
				<div class="activity_address">
					活动商城：<span class="activity_address_name">{{$activity->address}}</span>
				</div>
				<div class="activity_start_time">					
					活动开始时间：<span class="start_time">{{date("Y-m-d h:i:s",$activity->start_time)}}</span>
				</div>
				<div class="activity_end_time">
					活动结束时间：<span class="end_time">{{date("Y-m-d h:i:s",$activity->end_time)}}</span>
				</div>
			</div>
			<div class="activity_theme">
				<div class="theme_img">
					@if($activity->content1)
						<div>{{$activity->content1}}</div>
					@endif
					@if($activity->images1)
						@foreach($activity->images1 as $list)
							<img src="{{dgPicUrl($list)}}">
						@endforeach
					@endif
						@if($activity->content2)
							<div>{{$activity->content2}}</div>
						@endif
						@if($activity->images2)
							@foreach($activity->images2 as $list)
								<img src="{{dgPicUrl($list)}}">
							@endforeach
						@endif
						@if($activity->content3)
							<div>{{$activity->content3}}</div>
						@endif
						@if($activity->images3)
							@foreach($activity->images3 as $list)
								<img src="{{dgPicUrl($list)}}">
							@endforeach
						@endif
						@if($activity->content4)
							<div>{{$activity->content4}}</div>
						@endif
						@if($activity->images4)
							@foreach($activity->images4 as $list)
								<img src="{{dgPicUrl($list)}}">
							@endforeach
						@endif
						@if($activity->content5)
							<div>{{$activity->content5}}</div>
						@endif
						@if($activity->images5)
							@foreach($activity->images5 as $list)
								<img src="{{dgPicUrl($list)}}">
							@endforeach
						@endif
				</div>
			</div>
			<div class="copyright"><img src="{{url('/img/association/copyright.png')}}"></div>
			<div class="activity_foot">
			@if(!$activity->status)
				<div class="activity_like">
				@if($activity->is_collect)
					<img src="{{url('/img/association/icon_collect_activity_details1.png')}}">
					<div class="foot_name">已收藏</div>
				@else
					<img src="{{url('/img/association/icon_collect_activity_details.png')}}">
					<div class="foot_name">收藏</div>
				@endif
				</div>
				<div class="activity_join">
					<img src="{{url('/img/association/icon_signup_activity_details.png')}}">
					<div class="foot_name">报名</div>
				</div>
			@else
				<div class="activity_comment">
					<img src="{{url('/img/association/icon_comment_topic_details.png')}}">
					<div class="foot_name">评价</div>
				</div>
			@endif
			</div>

		</div>
		<div id="signup">
			<img src="{{url('/img/association/back.png')}}" class="as_back1">
			<img src="{{url('/img/association/logo.png')}}" class="logo">
			<div class="selectType">报名</div>
			<div class="signuplist">
				<span class="signtitle">姓名</span>
				<input type="text" class="sign_name" placeholder="请输入您的姓名">
			</div>
			<div class="signuplist">
				<span class="signtitle">手机号</span>
				<input type="phone" class="sign_phone" placeholder="请输入手机号">
			</div>	
			<button class="btn_sign">报名</button>
			<div class="copyright"><img src="{{url('/img/association/copyright.png')}}"></div>	
		</div>
		<div id="comment_window">
			<div class="cover"></div>
			<img src="{{url('/img/association/back.png')}}" class="as_back1">
			<img src="{{url('/img/association/logo.png')}}" class="logo">
			<div class="selectType">活动评价</div>
			<div class="commentlists">
				<div class="commentLists"></div>				
			</div>
			<div class="copyright"><img src="{{url('/img/association/copyright.png')}}"></div>
			<div class="foot_comment">
				<div class="comment_input"></div>
				<img src="{{url('/img/association/icon_releasesuccess.png')}}">
			</div>
			<div class="window_comment">
				<div class="window_title">
					<span class="window_quit">取消</span>
					<span class="window_title_name">发布评论</span>
					<span class="window_confirm">发表</span>
				</div>
				<div class="window_write_comment"  cols="30" rows="5" contenteditable="true"></div>
				<div class="window_emoij">
					<img src="{{url('/img/association/icon_releasesuccess.png')}}">
				</div>
				<div class="face"></div>
			</div>
		</div>
<script id="comment" type="text/x-dot-template">
@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
	<div class="replylist">
		<div class="comment_id" hidden>@{{=it.data[i].id}}</div>
		<span class="reply_head">
			<img src="@{{=it.data[i].head_img}}">
		</span>
		<div class="reply_content">
			<div class="person_reply">
				<div class="reply_message1">
					<span class="reply_area">@{{=it.data[i].username}}</span>
					<!-- <span class="reply_phone">13903485555</span> -->
				</div>
				<div class="reply_comment_icon">@{{=it.data[i].like_num}}</div>
				@{{ if(it.data[i].is_like) { }}
				<img class="reply_zan_icon" src="{{url('/img/association/icon_praise_topic_details1.png')}}" @{{=it.data[i].zan_comment}}>
				<div class="comment_is_like" hidden>1</div>
				@{{ } else { }}	
				<img class="reply_zan_icon" src="{{url('/img/association/icon_praise_topic_details.png')}}" @{{=it.data[i].zan_comment}}>
				<div class="comment_is_like" hidden>0</div>	
				@{{ } }}
				<div class="reply_txt">@{{=it.data[i].content}}</div>
				<div class="reply_time">@{{=it.data[i].created_at}}</div>	
			</div>
		</div>
	</div>
@{{ } }}
@stop