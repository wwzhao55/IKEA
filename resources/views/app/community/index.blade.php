<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
		<style type="text/css">
			.initShow{
				display: none;
			}
		</style>
		<meta charset="utf-8" name="viewport" content="width=750, user-scalable=no">
		<meta http-equiv="cache-control" content="no-cache">
		<link rel="stylesheet" type="text/css" href="{{url('/css/association.css')}}">
		<script type="text/javascript" src="{{url('/js/association.js')}}"></script>

		<div id="association">
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" class="as_back">
            </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
			<div class="selectType">				
				<span class="knowledge">知识</span><span class="activity">活动</span><span class="topic">话题</span>
			</div>
			<div id="knowledge" class="initShow">
				<div class="selectAgeBox">
					<div class="selectAge">
						<span class="ageOn" id="0">精选</span>
						@foreach($age as $list)
						<span id="{{$list->id}}">{{$list->name}}</span>
						@endforeach
					</div>
				</div>
				<div class="mainImg">
					<a href='{{$knowledge_pic[0]->link}}'><img src="{{dgPicUrl($knowledge_pic[0]->image)}}"></a>
				</div>
				<div class="knowledgelists">
					<div class="knowledgeLists"></div>
				</div>
			</div>
			<div id="activity" class="initShow">
				<div class="activityLists">
					<a href="{{url('/app/arrange')}}">
						<div class="activitylist">
							<img class="activity_img" src="{{url('/img/arrange.png')}}">		
						</div>
					</a>
				</div>		
			</div>
			<div id="topic" class="initShow">
				<div class="topicLists"></div>
			</div>
			<div class="copyright"><img src="{{url('/img/association/copyright.png')}}"></div>
			<div class="index_foot">
				<div class="footlist">
					<img src="{{url('/img/association/icon_home_unclicked_tab.png')}}">
					<div class="icon_name">首页</div>
				</div>
				<div class="footlist">
					<img src="{{url('/img/association/icon_product_unclicked_tab.png')}}">
					<div class="icon_name">产品</div>
				</div>
				<div class="footlist">
					<img src="{{url('/img/association/icon_release_tab.png')}}">
				</div>
				<div class="footlist footOn">
					<img src="{{url('/img/association/icon_community_click_tab.png')}}">
					<div class="icon_name">社群</div>
				</div>
				<div class="footlist">
					<img src="{{url('/img/association/icon_mine_unclicked_tab.png')}}">
					<div class="icon_name">个人</div>
				</div>
			</div>
		</div>
<script id="knowledgetmpl" type="text/x-dot-template">
@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
<!-- @{{=it.data[i].name}} -->
<a href="@{{=it.data[i].href}}">
	<div class="knowledgelist">
		<div class="knowledgeImage">
			<img src="@{{=it.data[i].main_img}}-224c">
		</div>
		<div class="knowledgecontent">
			<div class="knowledgetitle">@{{=it.data[i].title}}</div>
			<div class="knowledgetxt">@{{=it.data[i].content}}</div>
		</div>
		<div class="knowledgecomment">
			<div class="knowledge_like">
				<span class="like_number">@{{=it.data[i].like_num}}</span>&nbsp;人喜欢
			</div>
			<div class="knowledge_zan">
				<span class="zan_number">@{{=it.data[i].comment_num}}</span>&nbsp;人评论
			</div>
							
		</div>
	</div>
</a>
@{{ } }}
</script>
<script id="activitytmpl" type="text/x-dot-template">
@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
<!-- @{{=it.data[i].name}} -->
<a href="@{{=it.data[i].href}}">
	<div class="activitylist">
		@{{ if (it.data[i].status==1) { }}
		<div style="position: relative;">
			<img class="activity_img" src="@{{=it.data[i].main_images}}">
			<div style="position: absolute;left: 0;top: 0; background-color: gray;opacity:0.4;filter:alpha(opacity=40);width: 100%;height: 100%">
				
			</div>
			<img src="{{url('/img/association/end_activity.png')}}" style="position: absolute;left: 50%;top: 50%;transform: translate(-50%,-50%);">
		</div>
		
		@{{ } }}

		@{{ else if (it.data[i].status==0) { }}
		<img class="activity_img" src="@{{=it.data[i].main_images}}">		
		@{{ } }}
	</div>
</a>
@{{ } }}
</script>
<script id="topictmpl" type="text/x-dot-template">
@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
<!-- @{{=it.data[i].name}} -->
<a href="@{{=it.data[i].href}}">
	<div class="topiclist">
		@{{ if(it.data[i].main_img!="") { }}
		<div class="topicImg">
			<img src="@{{=it.data[i].main_img}}-690c">
		</div>
		@{{ } }}
		<div class="topictxt">
			<div class="topictitle">@{{=it.data[i].title}}</div>
			<div class="topictime">@{{=it.data[i].created_at}}</div>
			<div class="topiccontent">@{{=it.data[i].content}}</div>
		</div>
		<div class="topicauthor">
			<div class="topichead">
				<img src="@{{=it.data[i].head_img}}"><span class="topicname">@{{=it.data[i].username}}</span>
			</div>		
			<div class="topic_comment">
				<span class="comment_number">@{{=it.data[i].comment_num}}</span>&nbsp条评论
			</div>
			<div class="topic_zan">
				<span class="zan_number">@{{=it.data[i].like_num}}</span>&nbsp人赞
			</div>
		</div>
	</div>
</a>
@{{ } }}
</script>
@stop
