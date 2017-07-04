document.onreadystatechange = function(e){
  if(document.readyState=='complete'){
    document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
  } 
}
//ajax
var ajax={
  get: function (url,fn){
      var obj;  // XMLHttpRequest对象用于在后台与服务器交换数据 
      obj=new XMLHttpRequest();         
      obj.open('GET',url,true);
      obj.onreadystatechange=function(){
          if (obj.readyState == 4 && obj.status == 200 || obj.status == 304) { // readyState==4说明请求已完成
              fn.call(this, obj.responseText);  //从服务器获得数据
          }
      };
     obj.send(null);
 },
 post: function (url, data, fn) {
     var obj = new XMLHttpRequest();
     obj.open("POST", url, true);
     obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // 发送信息至服务器时内容编码类型
     obj.onreadystatechange = function () {
         if (obj.readyState == 4 && (obj.status == 200 || obj.status == 304)) {  // 304未修改
             fn.call(this, obj.responseText);
         }
     };
     obj.send(data);
 }
}
//获取滚动条位置
function getScrollTop() { 
	var scrollTop = 0; 
	if (document.documentElement && document.documentElement.scrollTop) { 
		scrollTop = document.documentElement.scrollTop; 
	}else if(document.body) { 
		scrollTop = document.body.scrollTop; 
	} 
	return scrollTop; 
} 
//获取当前可视范围的高度 
function getClientHeight() { 
	var clientHeight = 0; 
	// if (document.body.clientHeight && document.documentElement.clientHeight) { 
	// 	clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight); 
	// }else { 
	// 	clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight); 
	// } 
	clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight); 
	return clientHeight; 
} 
//获取文档完整的高度 
function getScrollHeight() { 
    return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight); 
} 
function dealData(data){
    data = JSON.parse(data);
    for(list in data.data){
    	var img = "<img src='"+ dgPicUrl(data.data[list].main_img)+"'>";
    	//var img = '<img src="../../img/recommend/image.png">';
    	var name = '<div class="item_name">'+data.data[list].name+'</div>';
    	var count = '<div class="item_count">'+data.data[list].collect_num+'人推荐</div>';
    	var node=document.createElement("a");
        node.setAttribute("href",dgurl("/app/product/info?product="+data.data[list].id));
    	var inner = "<div class='content_item'>"+img+name+count+"</div>";
    	node.innerHTML=inner;
    	container.appendChild(node);
    }
}
function loadData() { 
    if (getScrollTop() + getClientHeight() +10>= getScrollHeight()){
		getData();
    }
}
var container = document.querySelector('.recommend_container');
function getData(){
	var url = dgurl('/app/recommend/list');
	ajax.get(url,dealData);
}
 
document.addEventListener('touchmove',loadData);
getData();
//back回退
var back = document.querySelector('#back');
back.onclick = function(){
	window.history.back();
}



