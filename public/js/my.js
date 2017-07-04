$(document).ready(function(){
    // userIndex
    var couponPop = document.getElementById('get-coupon');
    var couponValue = document.getElementById('coupon-value');
    var couponBlock = function(showCoupon) {
        if(showCoupon && showCoupon.length){
            var show = false;
            for(var i=0;i<showCoupon.length;i++){
                if(!showCoupon[i].is_read){
                    show = true;
                    var couponBody = "<div class=\"get-coupon-body couponbody"+i+"\" style=\"background-image: url("+dgurl('/img/user/coupons_get.png')+")\"><div class=\"get-coupon-money\">￥<span class=\"coupon-value\">"+parseInt(showCoupon[i].value)+"</span></div><div class=\"get-coupon-condition\">仅限线下使用</div><div class=\"get-coupon-button\"><a href=\""+dgurl('/app/user/my-coupon')+"\"><span class=\"coupon-btn pull-left\">去查看</span></a><span class=\"coupon-btn pull-right\" onclick=\"couponCancle(this,"+i+")\">取消</span></div></div>";
                    $('#get-coupon').append(couponBody); 
                }
            }
            if(show) couponPop.style.display = 'block'; 
        }
    }
    $.ajax({
        url:dgurl('/app/user/coupon-list'),
        type:'GET',
        dataType:'json',
        success:function(data){
            if(!data.status){
                if(data.data.length){
                    couponBlock(data.data);
                }
            }
        }
    });
    
    function is_weixn(){  
        var ua = navigator.userAgent.toLowerCase();
        return "micromessenger" === ua.match(/MicroMessenger/i);
    }
    var weixin = is_weixn();
    var choose = document.querySelector('#head');
    var serverId=[];//存放图片
    if (weixin) {
        choose.onclick=function(){
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                    $('#head').attr('src',localIds);
                    syncUpload(localIds);
                }
            });
        };
        var syncUpload = function(localIds){
            var localId = localIds.pop();
            wx.uploadImage({
                localId: localId,
                isShowProgressTips: 0,
                success: function (res) {
                    serverId.push(res.serverId); // 返回图片的服务器端ID 
                    $.ajax({
                            url: dgurl('/app/user/change-headimg'),
                            data: {
                                headimg: res.serverId
                            },
                            type: 'POST',
                            dataType:'json',
                            success:function(data){
                                if(!data.status){
                                    Message.showMessage('上传成功')
                                }else{
                                    Message.showMessage(data.msg);
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
        choose.onclick = function(){
            document.getElementById("head-input").click(); 
        }
    }
	
    //localStorage保存数据  
    function saveCoupons(coupons){
        var newCoupon = [];
        var localCoupons = JSON.parse(localStorage.getItem('coupons'));
        if (localCoupons === null) {
            localCoupons = coupons;
            newCoupon = coupons;
        } else {
            for (var i = 0; i < coupons.length; i ++) {
                var code = coupons[i]['code'];
                // Code in locaCoupons
                var exist = false;
                for (var i = 0; i < localCoupons.length; i++) {
                    if (localCoupons[i].hasOwnProperty('code')) {
                        if (code == localCoupons[i]['code'] && localCoupons[i].is_read) {
                            exist = true;
                            break;
                        }    
                    } else {
                        throw Error('Error')
                    }
                }
                if (!exist) {
                    localCoupons.push(coupons[i]);
                    newCoupon.push(coupons[i]);
                }
            }
        }
        localStorage.setItem('coupons', JSON.stringify(localCoupons));
        return newCoupon;
    }
})
function fileSelected(source) {
        var file = source.files[0];
        if(window.FileReader) {
        var fr = new FileReader();
            fr.onloadend = function(e) {
                console.log(e.target.result);
                $('#head').attr('src',e.target.result);
            };
            fr.readAsDataURL(file);
        }
        // 文件选择后触发次函数
        var formData = new FormData($('#form-head')[0]);
            $.ajax({
                url: dgurl('/app/user/change-headimg'),
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'json',
                success:function(data){
                    if(!data.status){
                        Message.showMessage('上传成功')
                    }else{
                        Message.showMessage(data.msg);
                    }
                }
        });
}
function couponCancle(obj,order){
    var event = $(obj);
    event.parents().find(".couponbody"+order+"").remove();
    getCouponLong();
}
function getCouponLong(){
    var len = $("#get-coupon .get-coupon-body").length;
    if(!len){
       $('#get-coupon').hide();
    }
}