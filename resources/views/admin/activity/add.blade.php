@extends('admin.app')
@section('main')

<!-- 新增弹窗 -->
<div class="new-items">
	<span class="carousel_title">活动管理/新增</span>
	<div class="layer_newline" id="new_line_title" style="margin-left:35px;">
		<span class="span-size">活动名称:</span>
		<input type="text" class="input_content admin_pws" maxlength="20" id="title_text">
	</div>
	<div class="layer_newline" style="margin-left:35px;">
		<span class="span-size">活动商城:</span>
		<input type="text" class="input_content admin_pws" maxlength="20" id="address_text">
	</div>
	<div class="layer_newline">
		<span class="span-size">活动开始时间:</span>
		<input type="text" class="input_content admin_pws" maxlength="20" id="start_time_text">
	</div>
	<script type="text/javascript">
            laydate({
                elem: '#start_time_text',
                min:laydate.now()
            });
    </script>
	<div class="layer_newline">
		<span class="span-size">活动结束时间:</span>
		<input type="text" class="input_content admin_pws" maxlength="20" id="end_time_text">
	</div>
	<script type="text/javascript">
            laydate({
                elem: '#end_time_text',
                min:laydate.now()
            });
    </script>
    <div class="layer_newline" style="width:450px;height:330px;margin-left:33px;" id="pic_more_circle">
		<span class="span-size">轮播图片:</span>
		<div class='input-file-circle'>
			<img src="../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImgCircle(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic_circle">
	    	
	    </div>
	    <span style="margin-left:-150px;">(推荐上传图片尺寸：750px×334px)</span> 
	</div>	
	<div class="layer_newline" style="width:500px;height:auto;margin-left:33px;" id="pic_more">
		<span class="span-size">产品图片:</span>
		<textarea class="textarea-size" id="content_text"></textarea>
		<div class='input-file'>
			<img src="../../img/product/add-work.png" style="width:40px;height:40px;margin-left:190px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic">
	    	
	    </div>
	    <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
	</div>
	<div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
		<textarea class="textarea-size" id="content_text_1"></textarea>
		<div class='input-file'>
			<img src="../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg1(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic_1">
	    	
	    </div>
	    <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
	</div>
	<div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
		<textarea class="textarea-size" id="content_text_2"></textarea>
		<div class='input-file'>
			<img src="../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg2(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic_2">
	    	
	    </div>
	    <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
	</div>
	<div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
		<textarea class="textarea-size" id="content_text_3"></textarea>
		<div class='input-file'>
			<img src="../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg3(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic_3">
	    	
	    </div>
	    <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
	</div>
	<div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
		<textarea class="textarea-size" id="content_text_4"></textarea>
		<div class='input-file'>
			<img src="../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg4(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic_4">
	    	
	    </div>
	    <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
	</div>
	<div class="layer_newline" style="width:450px;height:170px;margin-left:48px;">
	    <button class="btn_default btn_confirm" onclick='confirmAdd()'>确定</button>
	</div>
</div>
<style type="text/css">
.input-file{
	position: relative;
}
.input-file-circle{
	position: relative;
}
.input-file input{
	position: absolute;
	top: 0;
	left: 20px;
	height: 40px;
    opacity: 0;
}
.input-file-circle input{
	position: absolute;
	top: 0;
	left: 20px;
	height: 40px;
    opacity: 0;
}
#add_pic{
	margin-left: 145px;
}
#add_pic_1,#add_pic_2,#add_pic_3,#add_pic_4{
	margin-left: 70px;
}
#add_pic_circle{
	margin-left: 70px;
}
#add_pic img,#add_pic_1 img,#add_pic_2 img,#add_pic_3 img,#add_pic_4 img{
	width:100px;
	height: 50px; 
}
#add_pic_circle img{
	width:100px;
	height: 50px;
}
.newdanger-file-img{
	cursor: pointer;
}
/* 新增样式 */
.new-items{
	margin-left: 50px;
}
.span-size{
	font-size: 17px;
}
.input_content{
	width: 250px;
	height: 30px;
}
.textarea-size{
	width:250px;
	height:80px;
	resize:none;
	vertical-align:top;
	margin-bottom:20px;
	margin-left: 5px;
}
.select-size{
	width: 250px;
	height: 30px;
	margin-left: 5px;
	margin-bottom: 10px;
}
.btn_confirm{
	margin-left: 147px;
}
</style>
@stop
@section('js')
<script type="text/javascript">
	$('#admin-activity').addClass('active');

//轮播图片预览及上传

var circleImages=[];
var indexCircle=1;
function addImgCircle(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  //console.log(file);
	  formData.append('image', file);
	  formData.append('dir','activity');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  //console.log(data);
		        	  circleImages.push(data.data.key);   
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
			            	  //console.log(e.target.result);
			            	  var single = "<div class='input-file-circle"+indexCircle+"'><img src=''></div>";      
			                  $('#add_pic_circle').append(single);   
			            	  $(".input-file-circle"+indexCircle+" img").attr('src',e.target.result);
			            	  indexCircle=indexCircle+1;   
			              
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}


//上传多张图片
var images = [];
var index=1;
function addImg(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  //console.log(file);
	  formData.append('image', file);
	  formData.append('dir','activity');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  //console.log(data);
		        	  images.push(data.data.key); 
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
			            	  //console.log(e.target.result);
			            	  var single = "<div class='input-file"+index+"'><img src=''></div>";      
			                  $('#add_pic').append(single);   
			            	  $(".input-file"+index+" img").attr('src',e.target.result);
			            	  index=index+1;   
			              
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}
var images_1 = [];
var index1=1;
function addImg1(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  //console.log(file);
	  formData.append('image', file);
	  formData.append('dir','activity');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  images_1.push(data.data.key); 
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
			            	  var single = "<div class='input-file-1"+index1+"'><img src=''></div>";      
			                  $('#add_pic_1').append(single);   
			            	  $(".input-file-1"+index1+" img").attr('src',e.target.result);
			            	  index1=index1+1;   
			              
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}
var images_2 = [];
var index2=1;
function addImg2(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  //console.log(file);
	  formData.append('image', file);
	  formData.append('dir','activity');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  images_2.push(data.data.key); 
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
			            	  var single = "<div class='input-file-2"+index2+"'><img src=''></div>";      
			                  $('#add_pic_2').append(single);   
			            	  $(".input-file-2"+index2+" img").attr('src',e.target.result);
			            	  index2=index2+1;   
			              
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}
var images_3 = [];
var index3=1;
function addImg3(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  //console.log(file);
	  formData.append('image', file);
	  formData.append('dir','activity');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  images_3.push(data.data.key); 
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
			            	  var single = "<div class='input-file-3"+index3+"'><img src=''></div>";      
			                  $('#add_pic_3').append(single);   
			            	  $(".input-file-3"+index3+" img").attr('src',e.target.result);
			            	  index3=index3+1;   
			              
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}
var images_4 = [];
var index4=1;
function addImg4(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  //console.log(file);
	  formData.append('image', file);
	  formData.append('dir','activity');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  images_4.push(data.data.key); 
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
			            	  var single = "<div class='input-file-4"+index4+"'><img src=''></div>";      
			                  $('#add_pic_4').append(single);   
			            	  $(".input-file-4"+index4+" img").attr('src',e.target.result);
			            	  index4=index4+1;   
			              
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}

//新增
function confirmAdd(){
		var titleText=$('#title_text').val();
		var addressText=$('#address_text').val();
		var content1=$('#content_text').val();
		var content2=$('#content_text_1').val();
		var content3=$('#content_text_2').val();
		var content4=$('#content_text_3').val();
		var content5=$('#content_text_4').val();
		var startTimeText=$('#start_time_text').val();
		var timestampStart = Date.parse(new Date(startTimeText));
            timestampStart = timestampStart / 1000;
		var endTimeText=$('#end_time_text').val();
		var timestampEnd = Date.parse(new Date(endTimeText));
            timestampEnd = timestampEnd / 1000;
        if(titleText==''){
			alert('请输入活动名称');
			return false; 
		}
		if(addressText==''){
			alert('请输入活动地址');
			return false; 
		}
		if(timestampEnd<timestampStart){
			alert('活动结束时间必须大于活动开始时间');
			return false;
		}
		
        $.ajax({
		    url: dgurl('/admin/activity/add'),
		    type: 'POST',
		    dataType:'json',
		    data:{
		    	name:titleText,
		    	address:addressText,
		    	start_time:timestampStart,
		    	end_time:timestampEnd,
		    	register_end_time:0,
		    	main_images:JSON.stringify(circleImages),
		    	content1:content1,
		    	images1:JSON.stringify(images),
		    	content2:content2,
		    	images2:JSON.stringify(images_1),
		    	content3:content3,
		    	images3:JSON.stringify(images_2),
		    	content4:content4,
		    	images4:JSON.stringify(images_3),
		    	content5:content5,
		    	images5:JSON.stringify(images_4)
		    },
		    success:function(data){
		    	if (data.status==1) {
		    		alert("新增成功!");
		    		window.location.href=dgurl("/admin/activity");
		    	}else{
		    		alert(data.message);
		    	}
		    }
		});
}
	
</script>
@stop
