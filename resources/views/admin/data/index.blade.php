@extends('admin.app')
@section('main')
<div id="canvasDiv"></div>
@stop
@section('js')
<link href="//cdn.bootcss.com/c3/0.4.11/c3.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/d3/3.5.17/d3.min.js"></script>
<script src="//cdn.bootcss.com/c3/0.4.11/c3.min.js"></script>
<script type="text/javascript">
$('#admin-data').addClass('active');
	function init() {
		$.ajax({
	        type:'GET',
	        url:dgurl('/admin/data/info'),
	        datatype:"json",
	        success:function(data){
	        	if(data.status==1){
	        		var aname = ['knowledgeComment_array', 'topicComment_array', 'topic_array', 'user_array'];
					var yname = ['知识评论数', '话题评论数', '话题数', '用户数'];
					for (var i = 0; i < aname.length; i++) {
						x = [], y0 = [];y1 = [];y2 = [];y3 = [];
						x.push('x');
						y0.push(yname[0]);
						y1.push(yname[1]);
						y2.push(yname[2]);
						y3.push(yname[3]);
					}
					for(var j = 0; j < data.data[aname[0]].length; j++) {
						var valx = data.data[aname[0]][j];
						x.push(valx.time*1000);
						var val = data.data[aname[0]][j];
						y0.push(val.count);
					}
					for(var j = 0; j < data.data[aname[1]].length; j++) {
						var val = data.data[aname[2]][j];
						y1.push(val.count);
					}
					for(var j = 0; j < data.data[aname[2]].length; j++) {
						var val = data.data[aname[2]][j];
						y2.push(val.count);
					}
					for(var j = 0; j < data.data[aname[3]].length; j++) {
						var val = data.data[aname[3]][j];
						y3.push(val.count);
					}
					var chart = c3.generate({
				        bindto: '#canvasDiv',
				        data: {
				        	x: 'x',
				            columns: [
				                x,y0,y1,y2,y3
				            ]
				        },
				        axis: {
					        x: {
					        	type: 'timeseries',
					            tick: {
					            	format: '%m-%d'
					            }
					        }
					    }
				    });
	        	}else{
	        		alert(data.message);
	        	}

	        }
	    });
	}
	init();
</script>
@stop