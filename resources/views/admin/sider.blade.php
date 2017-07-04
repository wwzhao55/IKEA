<div id="sider" >
	<div class="list-group">
		@if(app('session')->get('admin_id')['status']==1)
	  	<a href="{{url('/admin')}}" class="list-group-item" id="admin-list">管理员列表</a>
	  	@endif
	  	<a href="{{url('/admin/vip')}}" class="list-group-item" id="admin-vip">会员列表</a>
	  	<a href="{{url('/admin/knowledge')}}" class="list-group-item" id="admin-knowledge">知识管理</a>
	  	<a href="{{url('/admin/product')}}" class="list-group-item" id="admin-product">产品管理</a>
	  	<a href="{{url('/admin/activity')}}" class="list-group-item" id="admin-activity">活动管理</a>
	  	<a href="{{url('/admin/check/topic')}}" class="list-group-item" id="admin-examine-topic">话题审核</a>
	  	<a href="{{url('/admin/check/comment')}}" class="list-group-item" id="admin-examine-comment">评论审核</a>
	  	<a href="{{url('/admin/coupon')}}" class="list-group-item" id="admin-coupon">优惠券管理</a>
	  	<a href="{{url('/admin/data')}}" class="list-group-item" id="admin-data">数据统计</a>
	  	<div class="list-group-item">
	  		<a href="#" class="list-group-item" id="admin-config">配置中心</a>
	  		<ul id="config-list">
	  			<li><a href="{{url('/admin/config/carousel')}}" id="admin-carousel">轮播图片</a></li>
	  			<li><a href="{{url('/admin/config/picture')}}" id="admin-picture">知识图片</a></li>
	  			<li><a href="{{url('/admin/config/category')}}" id="admin-category">分类管理</a></li>
	  			<!-- <li><a href="{{url('/admin/config/sort')}}" id="admin-sort">排序设置</a></li> -->
	  		</ul>	  			  		
	  	</div>

	</div>
</div>
<script type="text/javascript">
	$('#sider').on('click','.list-group-item',function(){
		$(this).addClass('active');
		// $('#admin-config').css('background','#d1af94');
	});

	$('#config-list').hide();//初始不显示
	$('#admin-config').on('click',function(){
		// $('.list-group-item').removeClass('active');
		// $('#admin-config').addClass('active');
		$('#config-list').toggle();
	});
</script>