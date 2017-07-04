<!DOCTYPE html>
<html>
<head>
    <title>宜家家居</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1, minimum-scale=1, user-scalable=no">
    <script type="text/javascript" src="{{url('/myadmin/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('/plugin/dropload/dropload.css')}}">
    <link rel="stylesheet" href="{{url('/css/style.css')}}">
    <script type="text/javascript" src="{{url('/plugin/dot.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/plugin/alert.js')}}"></script>
    <script type="text/javascript" src="{{url('/plugin/dropload/dropload.min.js')}}"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
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
        };
        var picBaseUrl = "{{config('web.qiniu_domain')}}";
        var dgPicUrl = function(url){
            return picBaseUrl+url;
        };
        document.documentElement.addEventListener('touchstart', function (event) {
            if (event.touches.length > 1) {
                event.preventDefault();
            }
        }, false);

        var lastTouchEnd = 0;
        document.documentElement.addEventListener('touchend', function (event) {
            var now = Date.now();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    </script>
</head>
<body>
<script>
    $.ajaxSetup ({
        cache: false //关闭AJAX缓存
    });
    $.ajax({
        url: 'https://wxapi.dgdev.cn/getJssdk.php?url='+encodeURIComponent(window.location.href),
        success: function(data) {
            wx.config({
                debug: false,
                appId: data.appId,
                timestamp: data.timestamp,
                nonceStr: data.nonceStr,
                signature: data.signature,
                jsApiList: ['chooseImage','uploadImage', 'onMenuShareTimeline','onMenuShareAppMessage']
            });
        },
        dataType:'jsonp'
    });


    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: '宜家北京商场', // 分享标题
            link: 'http://h5.dataguiding.com/ikea', // 分享链接
            imgUrl: 'http://h5.dataguiding.com/ikea/img/share.jpg', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareAppMessage({
            title: '宜家北京商场', // 分享标题
            desc: '欢迎来到宜家线上儿童乐园', // 分享描述
            link: 'http://h5.dataguiding.com/ikea', // 分享链接
            imgUrl: 'http://h5.dataguiding.com/ikea/img/share.jpg', // 分享图标
            type: '', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });
</script>
@yield('content')
{{--添加CNZZ统计代码--}}
<div style="display:none">
    <script src="https://s19.cnzz.com/z_stat.php?id=1261969921&web_id=1261969921" language="JavaScript"></script>
</div>
</body>
</html>