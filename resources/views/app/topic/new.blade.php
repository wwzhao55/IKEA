@extends('app.index')
@section('content')
<link rel="stylesheet" href="{{url('/css/newtopic.css')}}"> 
<div class="topic_title" style="margin-bottom: 0rem;">
	<span class="img" id="back"><img src="{{url('/img/recommend/back.png')}}"></span>
	<img src="{{url('/img/association/logo.png')}}" style="position: absolute;top: 0.28rem;
    left: 1.4rem;width: 0.95rem;">
	<span>发布内容</span>
	<button id="to_publish">发布</button>
</div>
<div class="topic_choice">
	<div>
	  <span class="choosen_topic"></span>
	  <span class="express">(您可以选择我们本期的任意话题发布内容)</span>
	  <div class="clearfix"></div>
	</div>
	<img src="{{url('/img/recommend/topic_choose.png')}}" id="topic_choose">
	<div class="clearfix"></div>
</div>
<div class="character">
	<input type="" name="title" placeholder="标题" class="character_title">
	<textarea  name="content" placeholder="正文" class="character_body" maxlength="1000"></textarea>
</div>
<div id="pic_container">
	<img src="{{url('/img/recommend/add_picture.png')}}" id="add_icon">
</div>
<div class="choose_pic">
	<div style="float: left;margin-top: 0.2rem;margin-left: 0.3rem" class="cancel"><img src="{{url('/img/recommend/choose.png')}}" style="width: 0.4rem;height: 0.36rem;" id="choose_img"></div>
	<div style="float: right;margin-top: 0.2rem;margin-right: 0.3rem" class="cancel"><span id="number">0</span>/1000</div>
	<div class="clearfix"></div>
</div>
<form id="img_form">
	<input type="file" name="img"  id="input0" onchange='fileSelected()'>
</form>

<div id='cover'></div>
<div class="choose_container">
	<div class="choose_tip">
		<div style="float: left;margin-top: 0.2rem;" class="cancel">取消</div>
		<div style="float: right;margin-top: 0.2rem;" class="cancel">完成</div>
		<div class="clearfix"></div>
	</div>
	<div class="choosic">
	    @foreach($type as $list)
	        <div data-id ='{{$list->id}}' class="chooseid">{{$list->name}}</div>
	    @endforeach
	</div>
</div>
<script type="text/javascript" src="{{url('/js/newtopic.js')}}"></script>
@stop