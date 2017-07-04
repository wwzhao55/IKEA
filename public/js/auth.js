localStorage.removeItem('coupons');
//获取验证码
var InterValObj; //timer变量，控制时间  
var count = 60; //间隔函数，1秒执行  
var curCount;//当前剩余秒数  
var code = ""; //验证码 
function sendMessage() { 
	var myreg = /^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17([0,1,3]|[6-8]))|(18[0-9]))+\d{8})$/;
	curCount = count;  
    var phone=$("#phone").val();//手机号码  
    if(myreg.test(phone)){    
        //设置button效果，开始计时  
        $('#sendbtn').addClass('disabled');
        $("#sendbtn").attr("disabled", "true");  
        $("#sendbtn").html("重新获取("+curCount + "秒)");  
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次  
    	//向后台发送处理数据  
    	$.ajax({
    		type:'get',
    		url:dgurl('/app/auth/code'),
    		data:{
    			mobile:phone
    		},
    		dataType:'json',
    		success:function(data){
    			if(data.status=='success'){
    				Message.showMessage('验证码发送成功，请注意查收')
    			}else{
    				Message.showMessage(data.msg)
    			}

    		},
    	});  
    }else{  
    	Message.showMessage("手机号码格式不正确！");  
    }  
}  
//timer处理函数  
function SetRemainTime() {  
	if (curCount == 0) {                  
        window.clearInterval(InterValObj);//停止计时器  
        $("#sendbtn").removeAttr("disabled");//启用按钮  
        $('#sendbtn').removeClass('disabled');
        $("#sendbtn").html("获取验证码");  
        code = ""; //清除验证码。如果不清除，过时间后，输入收到的验证码依然有效      
    }  
    else {  
    	curCount--;  
    	$("#sendbtn").html("重新获取("+curCount + "秒)");  
    }  
}
function getQueryString(name) { 
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
    var r = window.location.search.substr(1).match(reg); 
    if (r != null) return unescape(r[2]); return null; 
}
var url = getQueryString('refer');

function submit(){
	var phone=$("#phone").val();
	var code=$("#code").val();  
	if(!phone.length){
		Message.showMessage('请输入手机号')
	}else if(!code.length){
		Message.showMessage('请输入手机验证码')
	}else{
		$.ajax({
    		type:'POST',
    		url:dgurl('/app/auth/login'),
    		data:{
    			mobile:phone,
    			code:code
    		},
    		dataType:'json',
    		success:function(data){
    			if(!data.status){
                    if (!url) {
                        window.location.href =  dgurl('/app/user/index');
                    } else{
                        window.location.href =  dgurl('/'+decodeURIComponent(url));
                    }
    			}else{
    				Message.showMessage(data.msg)
    			}
    		},
    	});  
	}
}