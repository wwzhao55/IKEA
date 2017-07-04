function mycoupon(page){
           $.ajax({
    			url:dgurl('/app/user/coupon-list'),
    			data:{
    				page:page,
    			},
    			type:'GET',
    			dataType:'json',
    			success:function(data){
                    if(!data.status){
                    	if(data.data.length){
                            $('#non-coupon').hide();
                            $('#has-coupon').show();
                            var evalText = doT.template($("#coupontmpl").text());
                            $("#has-coupon").append(evalText(data));
                    	}else{
                            $('#non-coupon').show();
                            $('#has-coupon').hide();
                        } 
                    }else{
                        Message.showMessage(data.msg)
                    }
                }
            });
}
mycoupon(1);