<!DOCTYPE html>
<html>
<head>
	<title>宜家后台管理</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{url('/myadmin/plugin/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/myadmin/css/common.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('/myadmin/css/admin.css')}}">
	<script>
		var domains = ['dataguiding', 'dgdev'];
		var domain, remote = false;
		for (var i = 0; i < domains.length; i++) {
			if (window.location.href.indexOf(domains[i]) >= 0) {
				remote = true;
				break;
			}
		}
		if (remote) domain = '/ikea';
		else domain = '';
		var dgurl = function (url) {
			return domain + url;
		}
		var picBaseUrl = "{{config('web.qiniu_domain')}}";
		var dgPicUrl = function(url){			
			return picBaseUrl+url;
		}

		var page = "{{config('page.page_count')}}";
		
	</script>
	<script src="{{url('/myadmin/js/jquery.min.js')}}"></script>
	<script src="{{url('/myadmin/plugin/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{url('/myadmin/plugin/layer/layer.js')}}"></script>
	<script src="{{url('/myadmin/plugin/laydate/laydate.js')}}"></script>
	<script src="{{url('/myadmin/js/jquery.bootpag.min.js')}}"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<nav class="navbar navbar-default" role="navigation">
			    <div class="container-fluid">
			        <div class="navbar-header">
			            <!-- <span class="navbar-brand">后台管理系统</span> -->
			        </div>
			        <div class="collapse navbar-collapse">    
			        	<ul class="nav navbar-nav navbar-right">
			                <!-- <li class='modify'></li> -->
			                <li class='logOut'><a href="{{url('/admin/logout')}}">退出
			                <!-- <img src='../images/cms/loginout.png' alt="退出"> -->
			                </a></li>
			            </ul>
			        </div>
			    </div>
			</nav>
		</div>
		<div id="left" style="width: 15%;float: left;">
			@include('admin.sider')
		</div>
		<div id="right" style="width:85%; float: left;">			
			<div id="main" style="margin:50px">
				@yield('main')
			</div>			
		</div>
	</div>
@yield('js')
<script type="text/javascript">
function getHeight() { 
	var rightHeight = document.getElementById("right").offsetHeight;
	var offsetHeight = window.screen.height;
	// console.log(offsetHeight);
	$('#left').css('height',rightHeight);
	// $('#left').css('min-height',offsetHeight);	
}
window.onload = function() {
	getHeight();
}	
</script>
</body>
</html>
