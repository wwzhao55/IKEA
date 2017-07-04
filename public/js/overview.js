// document.onreadystatechange = function(e){
//   if(document.readyState=='complete'){
//     document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
//   } 
// }
document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
var slidey = $('.banner').unslider({
    speed: 500,               //  The speed to animate each slide (in milliseconds)
    delay: 3000,              //  The delay between slide animations (in milliseconds)
    complete: function() {},  //  A function that gets called after every slide animation
    keys: true,               //  Enable keyboard (left, right) arrow shortcuts
    dots: true,               //  Display dot navigation
    fluid: false              //  Support responsive design. May break non-responsive designs
});

var data = slidey.data('unslider');
var slides = $('.banner');
slides.swipe( {
//Generic swipe handler for all directions
    swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
        if(direction=='left'){
            data.next();
            data.start();
        }else if(direction=='right'){
            data.prev();
            data.start();
        }else{

        }
    }
});
//轮播
//清除空格，text元素
// function cleanWhitespace(element){   
//     for(var i=0; i<element.childNodes.length; i++)   {   
//         var node = element.childNodes[i];   
//         if(node.nodeType == 3 && !/\S/.test(node.nodeValue)){   
//             node.parentNode.removeChild(node);   
//         }   
//     } 
//     return element;  
// }
// //加头尾图片
// var wrap = cleanWhitespace(document.querySelector(".wrap"));
// var length = wrap.childNodes.length;
// console.log()
// var firstchild = wrap.firstChild.cloneNode(true);

// var lastchild = wrap.lastChild.cloneNode(true);
// wrap.appendChild(firstchild);
// wrap.insertBefore(lastchild,wrap.childNodes[0]);
// //设置图片以及容器
// wrap.style.width = length+2+'00%';
// var width = window.getComputedStyle(wrap, null).width;
// width = width.substr(0,width.length-2);
// var basic_percentage = 100/(length+2);
// var basic_width = parseFloat(width)/(length+2);
// wrap.style.left = '-'+basic_width+'px';
// for(var j=0;j<length+2;j++){
//   wrap.childNodes[j].style.width = basic_percentage+'%';
// }
// var temp = document.querySelector("#temp_img");
// temp.style.display = 'none';
// //灰点
// var point_container = cleanWhitespace(document.querySelector(".buttons"));
// for (var m = length-2; m >= 0; m--) {
//      var view_point = document.createElement('span');
//      point_container.appendChild(view_point);
// }
// //动态改变left
// function next_pic () {
//     index++;
//     current++;
//     if(index > length-1){
//         index = 0;
//     }
//     showCurrentDot();
//     var newLeft;
//     if(current == length + 1){
//         newLeft = -basic_width;
//         current = 1;
//     }else{
//         newLeft = -basic_width*current;
//     }
//     wrap.style.left = newLeft + "px";
// }
// var timer = null;
// function autoPlay () {
//     timer = setInterval(function () {
//         next_pic();
//     },2000);
// }
// autoPlay();

// var container = document.querySelector(".container");
// container.onmouseenter = function () {
//     clearInterval(timer);
// }
// container.onmouseleave = function () {
//     autoPlay();    
// }

// var index = 0,current =1;
// var dots = document.querySelector(".buttons").childNodes;
// for (var n = dots.length - 1; n >= 0; n--) {
//     var node = dots[n];   
//     if(node.nodeType == 3 && !/\S/.test(node.nodeValue)){   
//         node.parentNode.removeChild(node);   
//     }
// }
// function showCurrentDot () {
//     for(var i = 0, len = dots.length; i < len; i++){
//         dots[i].className = "";
//     }
//     dots[index].className = "on";
// }
//跳转
function activity(id){
    window.location.href=dgurl('/app/activity/info?activity='+id);
}

function chat(id){
    window.location.href=dgurl('/app/topic/info?article='+id);
}


