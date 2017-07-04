@extends('admin.app')
@section('main')
<!-- 新增弹窗 -->
<div class="new-items">
	<span class="carousel_title">知识管理/编辑</span>
	<div class="layer_newline" id="new_line_title">
		<span class="span-size">标题：</span>
		<input type="text" class="input_content admin_pws" maxlength="20" id="title_text" placeholder="标题">
	</div>
	<div class="layer_newline">
		<span class="span-size">详情：</span><textarea class="textarea-size" id="content_text" placeholder="详情"></textarea>
	</div>
	<div class="layer_newline">
		<span class="span-size">年龄：</span><select id="age_select" class="select-size"></select>
	</div>	
	<div class="layer_newline" style="width:700px;height:130px;">
		<span class="span-size">头图：</span>
		<div class="pic_add" style="margin-top:10px;margin-left:20px;"><img src="" class="pic_add_src" alt=""></div>
	    <input type='file' style='display:none;' name='image' class='img_upload' onchange="changePic(this)">
	    <span style="margin-left:30px;">(推荐上传头图尺寸：224px×200px)</span>
	</div>
	<div class="layer_newline" style="width:450px;height:auto;" id="pic_more">
		<span class="span-size">图片：</span>
		<div class='input-file'>
			<img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:100px;">
	    	<input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg(this)'>
	    </div>
	    <div class="col-sm-8" id="add_pic">
	    	
	    </div>
	    <span style="margin-left:-150px;">(推荐上传图片尺寸：690px×690px)</span> 
	</div>
	<div class="layer_newline" style="width:450px;height:170px;margin-left:5px;">
	    <button class="btn_default btn_confirm" id="confirm_add" onclick="confirmEdit()">确定</button>
	</div>
</div>
<style type="text/css">
.pic_add_more {
    width: 100px;
    height: 100px;
    border: 1px solid #d1af94;
    margin-bottom: 10px;
    display: inline-block;
}
.pic_add_more:hover {
    cursor: pointer;
}
.pic_add_more img {
    width: 100px;
    height: 50px;
}
.input-file{
	position: relative;
}
.input-file input{
	height: 40px;
	position: absolute;
	top: 0;
	left: 20px; 
    opacity: 0;
}
#add_pic,#edit_pic{
	margin-left: 60px;
}
#add_pic img{
	width:100px;
	height: 50px;
}
#edit_pic img{
	width:100px;
	height: 50px;
}
.newdanger-file-img{
	cursor: pointer;
}
.knowledge-table-main-img img{
	width: 130px;
	height: 40px; 
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
	height:103px;
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
	margin-left: 70px;
}
</style>


@stop
@section('js')
<script type="text/javascript">
//获取id值-----------------------------------------------------
//获取当前网址
var nowUrl=window.location.href;
//截取id
    nowUrlId = nowUrl.substring(nowUrl.lastIndexOf("/"));
    nowUrlId = nowUrlId.substr(1);
//-------------------------------------------------------------
//获取知识管理列表的数据
$(function(){
	PassData(nowUrlId);
})
var editList;
var indexMore;
var images=[];
function 	PassData(page){
		$.ajax({
		    url: dgurl('/admin/knowledge/list/0'),
		    type: 'POST',
		    data:{id:page},
		    dataType:'json',
		    success:function(data){
		    	if(data.status==1){
		    		    editList=data.data;
			            $("#title_text").val(editList.title);
						$("#content_text").val(editList.content);
						$("#age_select").val(editList.category_id);
						singleImgPath=editList.main_img;
						//头图
						var imgp = dgPicUrl(editList.main_img);
						$('.pic_add_src').attr('src',imgp);
                        //多图
                        images=JSON.parse(editList.images);
                        indexMore=images.length+1;
					    for(var j=0; j<images.length;j++){
					    	var single = "<div class='input-file"+(j+1)+"'><img src=''></div>";      
               				$('#add_pic').append(single); 	
					    	var imgObj = dgPicUrl(images[j]);
					    	$(".input-file"+(j+1)+" img").attr('src',imgObj);
					    }
	        	}else{
	        		alert(data.message);
	        	}
			}
		})
}

//上传多张图片

function addImg(source){
	  var formData = new FormData();
	  var file = source.files[0];
	  formData.append('image', file);
	  formData.append('dir','knowledge');
      $.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	  images.push(data.data.key);   
			          if(window.FileReader) {
			            var fr = new FileReader();
			            fr.onloadend = function(e) {
		            	  	   var single = "<div class='input-file"+indexMore+"'><img src=''></div>";      
		                       $('#add_pic').append(single);  
		                       $(".input-file"+indexMore+" img").attr('src',e.target.result);
		            	  	   indexMore=indexMore+1;
			            };
			            fr.readAsDataURL(file);
			          }
			        }
	   });
}
	$('#admin-knowledge').addClass('active');

/*function deleteImages(index){
	var a = confirm("您确定删除这张图片吗？");
	if(a){
		$(".input-file"+index+" ").remove();	
		index=index-1;
		images.splice(index,1); 
		console.log(images);
	}

}*/
//单张图片预览及上传
    var singleImgPath
	$('.pic_add_src').click(function(){
		$('.img_upload').click();
	})
	function changePic(source){
		var file = source.files[0];
		if(window.FileReader) {
			var fr = new FileReader();
			fr.onloadend = function(e) {
			    $('.pic_add_src').attr('src',e.target.result);
			};
			fr.readAsDataURL(file);
		}
		//file传给后台，返回图片路径
		var formData = new FormData();
		var uploadimg = $('.img_upload')[0].files[0];
		formData.append('image', uploadimg);
		formData.append('dir','knowledge');
		if(uploadimg == undefined){
			alert('请选择上传图片！');
		}else{
			$.ajax({
		        url: dgurl('/admin/image'),
		        data: formData,
		        processData: false, // 不处理数据
		        contentType: false, // 不设置内容类型
		        type: 'POST',
		        dataType:'json',
		        success:function(data){
		        	if(data.status == 1){
		        	    singleImgPath = data.data.key;	        		
		        	}else{
		        		alert(data.message);
		        	}
		        }
			});
		}
	}

//获取年龄列表
function initAge(page) {
		$.ajax({
				    url: dgurl('/admin/config/category/list/'+page),
				    type: 'POST',
				    dataType:'json',
				    data:{
				    	type:"年龄",
                        all:1
				    },
				    success:function(data){
				    	//console.log(data.data);
				    	if (data.status==1) {
				    		var optionstring="";
				    	    	for(var j=0;j<data.data.length;j++){
				    	    		$("#age_select").append("<option value=\"" + data.data[j].id + "\" >" + data.data[j].name + "</option>");
				    	    	}
				    	}else{
				    		alert(data.message);
				    	}
				    }
				});
	};
	initAge(0)
//编辑
function confirmEdit(){
		var titleText=$('#title_text').val();
		var contentText=$('#content_text').val();
		var categoryId=$('#age_select').val();
        $.ajax({
		    url: dgurl('/admin/knowledge/edit'),
		    type: 'POST',
		    dataType:'json',
		    data:{
		    	id:nowUrlId,
		    	title:titleText,
		    	category_id:categoryId,
		    	main_img:singleImgPath,
		    	images:JSON.stringify(images),
		    	content:contentText
		    },
		    success:function(data){
		    	if (data.status==1) {
		    		alert("修改成功!");
		    		window.location.href=dgurl("/admin/knowledge");
		    	}else{
		    		alert(data.message);
		    	}
		    }
		});
}

</script>
@stop

