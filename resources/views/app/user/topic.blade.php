<!-- auth:zww
	 date:2017.05.05 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
	<link rel="stylesheet" type="text/css" href="{{url('/css/my.css')}}">
	<div id="my-topic">
		<div id="page-top">
            <a href="javascript:" onclick="window.history.back();">
                <img src="{{url('/img/product/back.png')}}" id="page-history">
            </a>
            <img src="{{url('/img/association/logo.png')}}" class="logo">
			<h1>我的话题</h1>
		</div>
		<div id="my-collect">
			<div id="topic"></div>
		</div>
	</div>
	<div id="copyRight">
        <img src="{{url('/img/overview/copyright.png')}}">
    </div>
<script type="text/javascript" src="{{url('/js/myTopic.js')}}"></script>
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
				<span class="comment_number">@{{=it.data[i].comment_num}}</span>&nbsp;条评论
			</div>
			<div class="topic_zan">
				<span class="zan_number">@{{=it.data[i].like_num}}</span>&nbsp;个赞
			</div>
		</div>
	</div>
</a>
@{{ } }}
</script>
@stop