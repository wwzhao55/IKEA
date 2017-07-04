var choose = document.getElementById('topic_choose');
var box = document.querySelector('.choose_container');
var back = document.querySelector('#back');
back.onclick = function(){
	window.history.back();
}
choose.addEventListener('touchstart',function() {
	box.style.display= 'block';
 	box.setAttribute("class", "move choose_container");
 	$('#cover').show();
})
var finish = document.querySelector('.choose_tip');
var choosen_topic = document.querySelector('.choosen_topic');
finish.addEventListener('touchstart',function(ev) {
	var event = ev||window.event;
	var target = event.target||event.srcElement;
	if(target.className =='cancel'){
		box.setAttribute("class", "choose_container");
		box.style.display= 'none';
		$('#cover').hide();
	}
})
//话题选择
var id = 'id';
var serverId=[];//存放图片
var topic_chontainer = document.querySelector('.choosic');
topic_chontainer.addEventListener('click',function(ev){
    var event = ev||window.event;
    var target = event.target||event.srcElement;
    if (target.className.toLowerCase()=='chooseid') {
      id = target.getAttribute ('data-id');
      var content = target.innerHTML;
      choosen_topic.innerHTML = content;
      $('.express').hide();
    }
})
//是否是微信浏览器
function is_weixn(){  
    var ua = navigator.userAgent.toLowerCase();  
    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
        return true;  
    } else {  
        return false;  
    }  
}
var weixin = is_weixn();
var choose_img = document.querySelector('#choose_img');
var toupload_length = 0;
if (weixin) {
	choose_img.onclick=function(){
		$('#pic_container').show();
		$('.character_body').css('height','2rem');
	};
	$('#add_icon').click(function(){
		if (toupload_length==0) {
		    wx.chooseImage({
		        count: 9, // 默认9
		        sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
		        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
		        success: function (res) {
		            var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
		            toupload_length = toupload_length + localIds.length;
		            syncUpload(localIds);
            	    if(toupload_length==9){
						$('#add_icon').hide();
						choose.style.display='none';
					}
		        }
		    });
	    }else if(toupload_length<9){
	    	wx.chooseImage({
	            count: 9 - toupload_length, // 默认9
	            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
	            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
	            success: function (res) {
	                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
	                toupload_length = toupload_length + localIds.length;
	                syncUpload(localIds);
	                if (toupload_length>=9) {
	                    choose.style.display='none';
	                }
            	    if(toupload_length==9){
						$('#add_icon').hide();
						choose.style.display='none';
					}
	            }
	        });
	    }else{
	    	Message.showMessage('最多选择九张图');
	    }

	});
	var syncUpload = function(localIds){
	    var localId = localIds.pop();
	    wx.uploadImage({
	        localId: localId,
	        isShowProgressTips: 0,
	        success: function (res) {
				 // 返回图片的服务器端ID 
			      $.ajax({
			          url: dgurl('/app/topic/upload-img'),
			          data: {
			          	img:res.serverId
			          },
			          type: 'POST',
			          dataType:'json',
			          success:function(data){
			          	if (data.status==-1) {
			          		window.location.href = dgurl('/app/auth/login');
			          	}else{
			          		serverId.push(data.data);
			          		showImg(data.data);
			          	}
			          }
			       });
	            if(localIds.length > 0){
	                syncUpload(localIds);
	            }
	        }
	    });
	};

}else{
	choose_img.onclick = function(){
		$('#choose_img').attr('disabled',true);
		$('.character_body').css('height','2rem');
		$('#pic_container').show();
    }
    $('#add_icon').click(function(){
		if (toupload_length <10) {
	      document.getElementById("input"+toupload_length).click(); 
          $('#choose_img').attr('disabled',true);
		}else if(toupload_length == 10){
		  $('#add_icon').hide();
		}
    });
    function fileSelected() {
      toupload_length ++;
      var formData = new FormData($('#img_form')[0]);
      $.ajax({
          url: dgurl('/app/topic/upload-img'),
          data: formData,
          processData: false,
          contentType: false,
          type: 'POST',
          dataType:'json',
          success:function(data){
            if(!data.status){
              showImg(data.data);
              serverId.push(data.data);
              $("#img_form").empty();
              $("#img_form").append( "<input type='file' name='img'  onchange='fileSelected()' id='input"+toupload_length+"'>" );
              $('#choose_img').attr('disabled',false);
            }else{
              window.location.href = dgurl('/app/auth/login');
            }
          }
       });
    }
}
var publish = document.getElementById('to_publish');
publish.onclick = function(){
	$('#to_publish').attr('disabled',true);
	var title=document.getElementsByName("title")[0].value;
	var content=document.getElementsByName("content")[0].value;
	if (id=='id') {
		Message.showMessage('请选择话题');
		//Message.showMessage("郏高阳");
		return
	}
	if (title.length==0) {
		Message.showMessage('请填写标题');
		return
	}
	if (content.length==0) {
		Message.showMessage('请填写内容');
		return
	}
	var datatopost = {};
	datatopost.title = title;
	datatopost.content = content;
	datatopost.images = serverId.join(',');
	datatopost.category_id = id;
	var url =  dgurl('/app/topic/new-topic');
	post(url,datatopost );
}
function post(url, datatopost) {
	console.log(datatopost);
	 $.ajax({
          url: url,
          data: datatopost,
          type: 'POST',
          dataType:'json',
          success:function(data){
            if(data.status == 0){
	          	window.location.href = dgurl('/app/topic/success');
	          }else{
	          	Message.showMessage(data.msg);
	          }
	       }
       });
}
//右下角数字改变
var number = document.getElementsByName("content")[0];
number.onchange = function(){
	var length = number.value.length;
	//console.log(length);
	var container = document.getElementById('number');
	container.innerHTML= length;
}
function showImg(url){
	url = dgPicUrl(url);
	var img ="<img src='"+url+"'>";
	if (toupload_length<10) {
		//console.log(1);
		$('#pic_container').prepend(img);
	}else{
		$('#add_icon').hide();
	}
}
