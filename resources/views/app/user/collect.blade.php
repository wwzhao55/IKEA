<!-- auth:zww
	 date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
	<link rel="stylesheet" type="text/css" href="{{url('/css/my.css')}}">
	<div id="my-collect">
		<div id="page-top">
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" id="page-history">
            </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
			<h1>我的收藏</h1>
		</div>
		<div id="collect-title">
			<span class="title-name">产品</span>
			<span class="title-name">知识</span>
			<span class="title-name">活动</span>
			<span class="title-name">话题</span>
		</div>
		<div class="tab-content myproduct">
			<div id="product-tag">
			</div>
		</div>
		<div class="tab-content myknowledge">
			<!-- 知识 -->
			<div class="knowledgelists" id="knowledge-tag"></div>
		</div>
		<div class="tab-content myactivity">
			<!-- 活动 -->
			<div id="activity-tag"></div>
		</div>
		<div class="tab-content mytopic">
			<!-- 话题 -->
			<div id="topic-tag"></div>
		</div>
		<div id="copyRight">
            <img src="{{url('/img/overview/copyright.png')}}">
        </div>
	</div>
<script id="producttmpl" type="text/x-dot-template">
	@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
        <div class="list-item" >
            <img src="@{{=it.data[i].main_img}}" class="list-item-left">
            <div class="list-item-right">
                <div class="list-item-right-name">@{{=it.data[i].name}}</div>
                <div class="list-item-right-comment">￥@{{=it.data[i].price}}</div>
            </div>
        </div>
	@{{ } }}
</script>
<script id="knowledgetmpl" type="text/x-dot-template">
	@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
	<a href="@{{=it.data[i].href}}">
		<div class="knowledgelist">
			<div class="knowledgeImage">
				<img src="@{{=it.data[i].main_img}}">
			</div>
			<div class="knowledgecontent">
				<div class="knowledgetitle">@{{=it.data[i].title}}</div>
				<div class="knowledgetxt">@{{=it.data[i].content}}</div>
			</div>
			<div class="knowledgecomment">
				<div class="knowledge_like">
					<span class="like_number">@{{=it.data[i].like_num}}</span>&nbsp个点赞
				</div>
				<div class="knowledge_zan">
					<span class="zan_number">@{{=it.data[i].comment_num}}</span>&nbsp个评论
				</div>
				
			</div>
		</div>
	</a>
	@{{ } }}
</script>
<script id="activitytmpl" type="text/x-dot-template">
	@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
	<a href="@{{=it.data[i].href}}">
		<div class="activitylist">
			<img class="activity_img" src="@{{=it.data[i].main_img}}">
			@{{ if (it.data[i].end_time>it.data[i].nowTime) { }}
				<div class="activity-title">@{{=it.data[i].name}}</div>
			@{{ } else { }}	
				<img src="{{url('/img/association/end_activity.png')}}" class="activity_over">
			@{{ } }}
		</div>
	</a>
	@{{ } }}
</script>
<script id="topictmpl" type="text/x-dot-template">
	@{{ for (var i = 0, l = it.data.length; i < l; i++) { }}
	<a href="@{{=it.data[i].href}}">
		<div class="topiclist">
			<div class="topicImg">
				<img src="@{{=it.data[i].main_img}}">
			</div>
			<div class="topictxt">
				<div class="topictitle">@{{=it.data[i].title}}</div>
				<div class="topictime">@{{=it.data[i].time}}</div>
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
					<span class="zan_number">@{{=it.data[i].like_num}}</span>&nbsp个赞
				</div>
			</div>
		</div>
	</a>
	@{{ } }}
</script>
<script type="text/javascript" src="{{url('/js/myCollect.js')}}"></script>
@stop
