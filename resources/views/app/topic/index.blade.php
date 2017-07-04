@extends('app.index')
@section('content')
<link rel="stylesheet" href="{{url('/css/newtopic.css')}}"> 
<div class="topic_title">
	<span class="img" id="back"><img src="{{url('/img/recommend/back.png')}}"><span>返回</span></span>
	<img src="{{url('/img/association/logo.png')}}" style="position: absolute;top: 0.28rem;
    left: 1.75rem;width: 0.95rem;">
	<span>话题须知</span>
</div>
<div class="topic_container">
	<div>Hi,你终于来了</div>
	<div>在这你可以通过发布自己的话题活动，</div>
	<div>召集趣味相投之人</div>
	<div>一起玩、一起疯、一起畅聊人生！</div>
	<div>成功发布话题五条，赠送宜家优惠券一张</div>
	<div>赶快来参与吧</div>
	<button id="button">发表话题</button>
</div>
<div style="height: 0.2rem;width:100%;text-align: center;position: fixed;bottom: 0.05rem;left: 0rem">
	<img src="{{url('/img/overview/copyright.png')}}" style="height: 100%;vertical-align: top;">
</div>
<script type="text/javascript">
	document.onreadystatechange = function(e){
	  if(document.readyState=='complete'){
	    document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
	  } 
	}
	var button = document.getElementById('button');
	button.onclick = function(){
		window.location.href = dgurl('/app/topic/new-topic');
	}
	//back回退
	var back = document.querySelector('#back');
	back.onclick = function(){
		window.history.back();
	}
</script>
@stop