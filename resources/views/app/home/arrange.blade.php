@extends('app.index')
@section('content')
<style>
	.topic_title{
	position: relative;
	height: 0.62rem;
	border-bottom: 1px solid #eee;
	font-size: 0.36rem;
	color: #292929;
	text-align: center;
	vertical-align: middle;
	padding-top: 0.26rem;
}
.topic_title .img{
	position: absolute;
	top: 0.26rem;
	height: 0.36rem;
	left: 0.3rem;
}
.topic_title .img img{
	height: 100%;
	margin-right: 0.1rem;
}
.topic_title .img span{
	margin-top: -0.03rem;
	display: inline-block;
}
</style>
<div class="topic_title">
	<span class="img" id="back"><img src="{{url('/img/recommend/back.png')}}"><span>返回</span></span>
	<span>活动安排</span>
</div>
<img src="{{ url('img/arrange_main.png') }}" style="width: 100%; display: block;" />
<script type="text/javascript">
	document.onreadystatechange = function(e){
	  if(document.readyState=='complete'){
	    document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
	  } 
	}
	//back回退
	var back = document.querySelector('#back');
	back.onclick = function(){
		window.history.back();
	}
</script>
@stop