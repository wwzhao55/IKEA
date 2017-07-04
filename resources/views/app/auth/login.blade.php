<!-- auth:zww
	 date:2017.05.04 
-->
<!-- 继承的模板 -->
@extends('app.index')
<!-- 内容 -->
@section('content')	
	
	<link rel="stylesheet" type="text/css" href="{{url('/css/auth.css')}}">
	<div id='regisiter'>
		<h1>账号登陆</h1>
		<div class='input_list'>
			<span class='input_lable'><img src="{{url('/img/auth/phone.png')}}" id="phone-pic"></span>
			<input class='input_box' type='number' id='phone' placeholder="输入手机号">
			<button id="sendbtn" onclick="sendMessage(this)">获取验证码</button>
		</div>
		<div class='input_list'>
			<span class='input_lable'><img src="{{url('/img/auth/password.png')}}" id="password-pic"></span>
			<input class='input_box' type='text' id='code' placeholder="输入手机验证码">
		</div>
		<button id="submit" onclick="submit()">登陆</button>
	</div>
	<div id="copyRight">
        <img src="{{url('/img/overview/copyright.png')}}">
    </div>
	<script type="text/javascript" src="{{url('/js/auth.js')}}"></script>
@stop