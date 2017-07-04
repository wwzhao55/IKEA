function getQueryString(name) { 
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
    var r = window.location.search.substr(1).match(reg); 
    if (r != null) return unescape(r[2]); return null; 
}
var category = getQueryString('category');
var category_id = getQueryString('category_id');

var ProductData = function() {
    this.data = {};
};
ProductData.prototype.push = function(product) {
    if (this.hasOwnProperty(product.id)) {
        throw Error('Product id duplicate');
        return;
    }
    this.data[product.id] = product;
}
ProductData.prototype.getProductById = function(productId) {
    if (this.data.hasOwnProperty(productId)) {
        return this.data[productId];
    }
    return null;
}
var productData = new ProductData();
function productPage(){
    var page = 1;
    if (page == 1) {
        $("#product-list").empty();
        $(".dropload-down").remove();
    }
    // dropload
    var dropload = $("#productpage").dropload({
        scrollArea : window,
        domDown : {
            domClass : "dropload-down",
            domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
            domLoad : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
            domNoData : '<div class="dropload-noData">没有更多数据了</div>'
        },
        loadDownFn : function(me){
            $.ajax({
                url: dgurl('/app/product/data'),
                async: false,
                type: 'GET',
                data:{
                    category:category,
                    page:page,
                    category_id:category_id
                },
                success:function(data){
                    page++;
                    if(!data.status){
                        if(data.data.length){
                            // 为了测试，延迟1秒加载
                            processproductList(data);
                            setTimeout(function(){   
                                var evalText = doT.template($("#ptoductListtmpl").text());
                                $("#product-list").append(evalText(data));
                                if (data.is_lastPage) {
                                    // 锁定
                                    me.lock();
                                    // 无数据
                                    me.noData();
                                    // return false;
                                    $("#productpage .dropload-down").html('没有更多数据了')
                                }
                                // 每次数据加载完，必须重置
                                me.resetload();
                            },500);
                        }else{
                                me.lock();
                                // 无数据
                                me.noData();
                                // return false;
                                $("dropload-down").html('没有搜到匹配的数据')
                                me.resetload();
                            }  
                    }else{
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                        // return false;
                        $("dropload-down").html('没有更多数据了')
                    }
                },
                error: function(xhr, type){
                    Message.showMessage('获取数据失败!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        },
        threshold : 50
    });    
}
productPage();

function processproductList(data) {
    for (var i = 0; i < data.data.length; i++) {
        var product = data.data[i];
        product.main_img = dgPicUrl(product.main_img);
        product.detail = 'onclick="DetailInfo('+product.id+')"';
        product.canClick = true;
        productData.push(product);
    }
}
var flow = true; 
function DetailInfo(item){
    var product = productData.getProductById(item);
    if (product) {
        $('#detailimg').attr('src', product.main_img)
        $('#product-name').html(product.name);
        $('#product-price').html(product.price);
        $('#product-size').html(product.size);
        $('#product-color').html(product.color);
        $('#product-code').html(product.item_num);
        $('#productInfo-back').show();
        $('#productInfo').show();
    } 
    flow = false;
    document.body.scrollTop = document.documentElement.scrollTop = 0;
    $('body').css('overflow','hidden');
    if (!flow) {
        $("body").bind("touchmove",function(event){
            event.preventDefault();
        });
    }
}
$('#productInfo-back').click(function(){
    $('#productInfo-back').hide();
    $('#productInfo').hide();
    $('body').css('overflow','auto');
    flow = true;
    $("body").unbind("touchmove");
})
if (flow) {
    $("body").unbind("touchmove");
}else{
    $("body").bind("touchmove",function(event){
        event.preventDefault();
    });
}
function toogleCollect(id,event){
    var collect = dgurl('/img/product/collect.png');
    var noCollect = dgurl('/img/product/collect_icon.png');
    var product = productData.getProductById(id);
    if (product) {
        if (!product.canClick) return;
        if (product.isCollect) {
            $(event).attr('src',noCollect);
        }else{
            $(event).attr('src',collect);
        }
        product.canClick = false;
        $.ajax({
            url: dgurl('/app/product/collect'),
            type: 'POST',
            data:{
                product:id
            },
            success:function(data){
                if(!data.status){
                    product.isCollect =!product.isCollect;
                }else{
                    $(event).attr('src',noCollect);
                    if(data.status ==-1){
                        Message.showConfirm(data.msg, "确定", "关闭", function () {
                            window.location.href = dgurl("/app/auth/login?refer="+encodeURIComponent("app/product/list?category_id="+category_id+"&category="+category));
                        }, function () {

                        }); 
                    }else{
                        Message.showMessage(data.msg)
                    }
                } 
                product.canClick = true;
            }
        })     
    }
}
