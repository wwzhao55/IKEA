@extends('admin.app')
@section('main')

<!-- 新增弹窗 -->
<div class="new-items">
    <span class="carousel_title">活动管理/编辑</span>
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
    <div class="layer_newline" style="width:500px;height:330px;margin-left:33px;" id="pic_more_circle">
        <span class="span-size">轮播图片:</span>
        <div class='input-file-circle'>
            <img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:135px;">
            <input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImgCircle(this)'>
        </div>
        <div class="col-sm-8" id="add_pic_circle">

        </div>
        <span style="margin-left:-200px;">(推荐上传图片尺寸：750px×334px)</span> 
    </div>
    <div class="layer_newline" style="width:500px;height:auto;margin-left:33px;" id="pic_more">
        <span class="span-size">产品图片:</span>
        <textarea class="textarea-size" id="content_text"></textarea>
        <div class='input-file'>
            <img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:222px;">
            <input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg(this)'>
        </div>
        <div class="col-sm-8" id="add_pic">

        </div>
        <div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
        <textarea class="textarea-size" id="content_text_1"></textarea>
        <div class='input-file'>
            <img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
            <input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg1(this)'>
        </div>
        <div class="col-sm-8" id="add_pic_1">
            
        </div>
        <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
    </div>
    <div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
        <textarea class="textarea-size" id="content_text_2"></textarea>
        <div class='input-file'>
            <img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
            <input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg2(this)'>
        </div>
        <div class="col-sm-8" id="add_pic_2">
            
        </div>
        <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
    </div>
    <div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
        <textarea class="textarea-size" id="content_text_3"></textarea>
        <div class='input-file'>
            <img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
            <input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg3(this)'>
        </div>
        <div class="col-sm-8" id="add_pic_3">
            
        </div>
        <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
    </div>
    <div class="layer_newline" style="width:400px;height:auto;margin-left:110px;">
        <textarea class="textarea-size" id="content_text_4"></textarea>
        <div class='input-file'>
            <img src="../../../img/product/add-work.png" style="width:40px;height:40px;margin-left:115px;">
            <input type="file" class='newdanger-file-img' accept="image/*"  onchange='addImg4(this)'>
        </div>
        <div class="col-sm-8" id="add_pic_4">
            
        </div>
        <!-- <span style="margin-left:-180px;">(推荐上传图片尺寸：690px×1071px)</span> -->  
    </div>
    </div>
    <div class="layer_newline" style="width:450px;height:170px;margin-left:158px;">
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
    #add_pic,#edit_pic{
        margin-left: 175px;
    }
    #add_pic_1,#add_pic_2,#add_pic_3,#add_pic_4{
        margin-left: 70px;
    }
    #add_pic_circle,#edit_pic_circle{
        margin-left: 90px;
    }
    #add_pic img,#add_pic_1 img,#add_pic_2 img,#add_pic_3 img,#add_pic_4 img{
        width:100px;
        height: 50px; 
    }
    #edit_pic img{
        width:100px;
        height: 50px;
    }
    #add_pic_circle img{
        width:100px;
        height: 50px;
    }
    #edit_pic_circle img{
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
    #content_text{
        margin-left: 40px;
    }
</style>
@stop
@section('js')
<script type="text/javascript">
    $('#admin-activity').addClass('active');
    //获取id值-----------------------------------------------------
    //获取当前网址
    var nowUrl=window.location.href;
    //截取id
    nowUrlId = nowUrl.substring(nowUrl.lastIndexOf("/"));
    nowUrlId = nowUrlId.substr(1);
    //-------------------------------------------------------------
    //时间戳转化为日期
    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    }
    function timeToDate(ts){
        var date=new Date(ts*1000);
        var year=date.getFullYear();
        var month=date.getMonth();
        month=month+1;
        var day=date.getDate();
        return year+"-"+month+"-"+day;
    }

    //初始化获取数据
    var editList;
    var images1 = [];
    var images2 = [];
    var images3 = [];
    var images4 = [];
    var images5 = [];
    var circleImages = [];
    var index, indexCircle,index2,index3,index4,index5;
    function init(page) {
        $.ajax({
            type:'POST',
            url:dgurl('/admin/activity/list/0'),
            data: {id: page},
            dataType:"json",
            success:function(data){
                if(data.status == 1){
                    editList=data.data;
                    $("#title_text").val(editList.name);
                    $("#address_text").val(editList.address);
                    $("#content_text").val(editList.content1);
                    $("#content_text_1").val(editList.content2);
                    $("#content_text_2").val(editList.content3);
                    $("#content_text_3").val(editList.content4);
                    $("#content_text_4").val(editList.content5);
                    $("#start_time_text").val(timeToDate(editList.start_time));
                    $("#end_time_text").val(timeToDate(editList.end_time));
                    //产品图片----------------------------------------------------------------
                    images1=JSON.parse(editList.images1);
                    index = images1.length + 1;
                    for(var j=0; j<images1.length;j++){
                        var single = "<div class='input-file"+(j+1)+"'><img src=''></div>";
                        $('#add_pic').append(single);
                        var imgObj = dgPicUrl(images1[j]);
                        $(".input-file"+(j+1)+" img").attr('src',imgObj);
                    }
                    images2=JSON.parse(editList.images2);
                    index2 = images2.length + 1;
                    for(var j=0; j<images2.length;j++){
                        var single = "<div class='input-file-1"+(j+1)+"'><img src=''></div>";
                        $('#add_pic_1').append(single);
                        var imgObj = dgPicUrl(images2[j]);
                        $(".input-file-1"+(j+1)+" img").attr('src',imgObj);
                    }
                    images3=JSON.parse(editList.images3);
                    index3 = images3.length + 1;
                    for(var j=0; j<images3.length;j++){
                        var single = "<div class='input-file-2"+(j+1)+"'><img src=''></div>";
                        $('#add_pic_2').append(single);
                        var imgObj = dgPicUrl(images3[j]);
                        $(".input-file-2"+(j+1)+" img").attr('src',imgObj);
                    }
                    images4=JSON.parse(editList.images4);
                    index4 = images4.length + 1;
                    for(var j=0; j<images4.length;j++){
                        var single = "<div class='input-file-3"+(j+1)+"'><img src=''></div>";
                        $('#add_pic_3').append(single);
                        var imgObj = dgPicUrl(images4[j]);
                        $(".input-file-3"+(j+1)+" img").attr('src',imgObj);
                    }
                    images5=JSON.parse(editList.images5);
                    index5 = images5.length + 1;
                    for(var j=0; j<images5.length;j++){
                        var single = "<div class='input-file-4"+(j+1)+"'><img src=''></div>";
                        $('#add_pic_4').append(single);
                        var imgObj = dgPicUrl(images5[j]);
                        $(".input-file-4"+(j+1)+" img").attr('src',imgObj);
                    }

                    //轮播图片--------------------------------------------------------------
                    circleImages=JSON.parse(editList.main_images);
                    indexCircle = circleImages.length + 1;
                    for(var j=0; j<circleImages.length;j++) {
                        var single = "<div class='input-file-circle" + (j + 1) + "'><img src='' ></div>";
                        $('#add_pic_circle').append(single);
                        var imgObjCircle = dgPicUrl(circleImages[j]);
                        $(".input-file-circle" + (j + 1) + " img").attr('src', imgObjCircle);
                    }
                    //----------------------------------------------------------------
                }else{
                    alert(data.message);
                }
            }
        });
    }
    init(nowUrlId);

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
                        var single = "<div class='input-file-circle" + indexCircle + "'><img src=''></div>";
                        $('#add_pic_circle').append(single);
                        $(".input-file-circle" + indexCircle + " img").attr('src', e.target.result);
                        indexCircle=indexCircle+1;
                    };
                    fr.readAsDataURL(file);
                }
            }
        });
    }

    //上传多张图片


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
                images1.push(data.data.key);
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
                //console.log(data);
                images2.push(data.data.key);
                if(window.FileReader) {
                    var fr = new FileReader();
                    fr.onloadend = function(e) {
                        //console.log(e.target.result);
                        var single = "<div class='input-file-1"+index2+"'><img src=''></div>";
                        $('#add_pic_1').append(single);
                        $(".input-file-1"+index2+" img").attr('src',e.target.result);
                        index2=index2+1;
                    };
                    fr.readAsDataURL(file);
                }
            }
        });
    }
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
                //console.log(data);
                images3.push(data.data.key);
                if(window.FileReader) {
                    var fr = new FileReader();
                    fr.onloadend = function(e) {
                        //console.log(e.target.result);
                        var single = "<div class='input-file-2"+index3+"'><img src=''></div>";
                        $('#add_pic_2').append(single);
                        $(".input-file-2"+index3+" img").attr('src',e.target.result);
                        index3=index3+1;
                    };
                    fr.readAsDataURL(file);
                }
            }
        });
    }
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
                //console.log(data);
                images4.push(data.data.key);
                if(window.FileReader) {
                    var fr = new FileReader();
                    fr.onloadend = function(e) {
                        //console.log(e.target.result);
                        var single = "<div class='input-file-3"+index4+"'><img src=''></div>";
                        $('#add_pic_3').append(single);
                        $(".input-file-3"+index4+" img").attr('src',e.target.result);
                        index4=index4+1;
                    };
                    fr.readAsDataURL(file);
                }
            }
        });
    }
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
                //console.log(data);
                images5.push(data.data.key);
                if(window.FileReader) {
                    var fr = new FileReader();
                    fr.onloadend = function(e) {
                        //console.log(e.target.result);
                        var single = "<div class='input-file-4"+index5+"'><img src=''></div>";
                        $('#add_pic_4').append(single);
                        $(".input-file-4"+index5+" img").attr('src',e.target.result);
                        index5=index5+1;
                    };
                    fr.readAsDataURL(file);
                }
            }
        });
    }

    //编辑
    function confirmAdd(){
        var titleText=$('#title_text').val();
        var addressText=$('#address_text').val();
        var content1=$('#content_text').val();
        var content2=$('#content_text_1').val();
        var content3=$('#content_text_2').val();
        var content4=$('#content_text_3').val();
        var content5=$('#content_text_4').val();
        var startTimeText=$('#start_time_text').val()
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
            url: dgurl('/admin/activity/edit'),
            type: 'POST',
            dataType:'json',
            data:{
                id:nowUrlId,
                name:titleText,
                address:addressText,
                start_time:timestampStart,
                end_time:timestampEnd,
                register_end_time:0,
                main_images:JSON.stringify(circleImages),
                content1:content1,
                images1:JSON.stringify(images1),
                content2:content2,
                images2:JSON.stringify(images2),
                content3:content3,
                images3:JSON.stringify(images3),
                content4:content4,
                images4:JSON.stringify(images4),
                content5:content5,
                images5:JSON.stringify(images5)
            },
            success:function(data){
                if (data.status==1) {
                    alert("修改成功!");
                    window.location.href=dgurl("/admin/activity");
                }else{
                    alert(data.message);
                }
            }
        });
    }

</script>
@stop