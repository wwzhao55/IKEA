<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
		<meta charset="utf-8" name="viewport" content="width=750, user-scalable=no">
		<meta http-equiv="cache-control" content="no-cache">
		<link rel="stylesheet" type="text/css" href="{{url('/css/association.css')}}">
		<script type="text/javascript" src="{{url('/js/topicdetail.js')}}"></script>
		<div class="topic_id" hidden>{{$topic->id}}</div>
		<div id="topicdetail">
			<div class="cover"></div>
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" class="as_back">
            </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
			<div class="selectType">话题详情</div>
			<div class="topic_author">
				<img src="{{dgPicUrl($topic->head_img)}}">
				<div class="topic_author_message">
					<div class="topic_author_name">{{$topic->username}}</div>
					<div class="topic_time">{{$topic->created_at}}</div>
				</div>
			</div>
			<div class="knowledge_head">{{$topic->title}}</div>
			<div class="knowledge_content">
				<div class="knowledge_img">
				@foreach($topic->images as $list)
					<img src="{{dgPicUrl($list)}}">
				@endforeach
				</div>
				<div class="knowledge_txt">
					{{$topic->content}}
				</div>
			</div>
			<div class="txt_action">
				<div class="txt_zan">					
					@if($topic->is_like)
					<img src="{{url('/img/association/icon_praise_topic_details1.png')}}">
					<div class="is_like" hidden>1</div>
					@else
					<img src="{{url('/img/association/icon_praise_topic_details.png')}}">
					<div class="is_like" hidden>0</div>
					@endif
					<div class="txt_action_num">{{$topic->like_num}}</div>
				</div>
				<div class="txt_like">
					@if($topic->is_collect)
					<img src="{{url('/img/association/icon_collect_activity_details1.png')}}">
					<div class="txt_action_num">已收藏</div>
					@else
					<img src="{{url('/img/association/icon_collect_activity_details.png')}}">
					<div class="txt_action_num">收藏</div>
					@endif
				</div>
				<div class="txt_comment">
					<img src="{{url('/img/association/icon_comment_topic_details.png')}}">
					<div class="txt_action_num">{{$topic->comment_num}}</div>
				</div>
			</div>
			<div class="reply">
				<div class="reply_title">全部回复</div>
				<div class="replylists">
					<div class="replyLists"></div>
				</div>
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