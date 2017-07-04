<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>登录</title>
	<script src="{{url('/myadmin/js/jquery.min.js')}}"></script>
</head>
<body>
	<div id='loginPage'>
				<form>
					<div class='login-title'>登录</div>
					<div class='item'>
						<span>账号：</span><input type="text" name="account" id="account" class='input-style'>
					</div>
					<div class='item'>
						<span>密码：</span><input type="password" name="password" id="password" class='input-style'>
					</div>
					<button type="button" id="submit">登陆</button>
				</form>
	</div>
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

	$('#submit').click(function(){
        var account = $("#account").val();
        var password = $("#password").val();
		$.post(dgurl('/admin/login'),{
			account:account,
			password:password
		},function(data){
			if(data.status == 1){
				window.location.href = dgurl('/admin/vip');
			}else{
				alert(data.message);
			}
		});
	});
	
</script>
<style type="text/css">
body{
	background-color: #fbf0ee;
	margin:0;
	padding: 0;
	font-family: 'Microsoft YaHei';
}
#loginPage {
    width: 560px;
    height: 560px;
    background-color: #fff;
    border-radius: 21px;
    margin: 200px auto 0 auto;
}
.login-title {
    color: #d1af94;
    text-align: center;
    font-size: 30px;
    line-height: 30px;
    padding-top: 118px;
    padding-bottom: 60px;
}
input#account {
    width: 278px;
    height: 36px;
}
input#password {
    width: 278px;
    height: 36px;
}
input.input-style {
    width: 300px;
    height: 40px;
    border: 1px solid #d1af94;
    border-radius: 10px;
    padding-left: 20px;
}
.item {
    text-align: center;
    margin-bottom: 30px;
    font-size: 18px;
}
#submit {
    float: right;
    width: 300px;
    background-color: #d1af94;
    height: 50px;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 24px;
    margin-top: 10px;
    margin-right: 90px;
    cursor: pointer;
}
.item span {
    width: 58px;
    display: inline-block;
    margin-right: 20px;
}
</style>
</body>
</html>