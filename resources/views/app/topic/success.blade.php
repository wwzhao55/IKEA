@extends('app.index')
@section('content')
<link rel="stylesheet" href="{{url('/css/newtopic.css')}}"> 
<div class="topic_title">
	<span class="img"><img src="{{url('/img/recommend/back.png')}}" id="back"><span>返回</span></span>
	<img src="{{url('/img/association/logo.png')}}" style="position: absolute;top: 0.28rem;
    left: 1.75rem;width: 0.95rem;">
	<span>发布内容</span>
</div>
<div class="topic_container" style="padding-top: 3.3rem;">
	<div style="width: 0.74rem;height: 0.74rem;margin-bottom: 0.32rem;"><img src="{{url('/img/recommend/success.png')}}" style="width: 100%;height: 100%;"></div>
	<div style="margin-bottom: 0.24rem;">恭喜你，发布成功</div>
	<div style="margin-bottom: 0.24rem;">审核成功后可查看</div>
	<button id="button">返回首页</button>
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
		window.location.href = '{{url('/app/index')}}';
	}
	//back回退
	var back = document.querySelector('#back');
	back.onclick = function(){
		window.history.back();
	}
</script>
@stop