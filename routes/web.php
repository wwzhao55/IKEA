<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->get('/',function(){
	return redirect('app/index');
});

//后台管理
$app->group(['prefix'=>'admin','namespace' => 'Admin'], function () use ($app) {

	//后台统一图片上传
	$app->post('image','ImageController@postUpload');

	//后台登录
	$app->group(['namespace' => 'Auth'], function () use ($app) {
		//登录页面
		$app->get('login','AuthController@getLogin');
		//登录
		$app->post('login','AuthController@postLogin');
		//登出
		$app->get('logout','AuthController@getLogout');
	});

	//管理员增删查改
	$app->group(['namespace' => 'Info'], function () use ($app) {
		//获取管理员信息
		$app->get('/','InfoController@getIndex');
		$app->post('list/{page}','InfoController@postList');

		$app->post('add','InfoController@postAdd');

		$app->post('edit','InfoController@postEdit');
		//删除
		$app->post('delete','InfoController@postDelete');
	});

	//管理员增删查改
	$app->group(['prefix'=>'vip','namespace' => 'Vip'], function () use ($app) {
		//获取管理员信息
		$app->get('/','VipController@getIndex');
		$app->post('list/{page}','VipController@postList');

		$app->get('export','VipController@getExport');

		
	});

	//统计中心
	$app->group(['prefix'=>'data','namespace' => 'Data'], function () use ($app) {
		$app->get('/','DataController@getIndex');
		$app->get('info','DataController@getInfo');
	});

	//审核中心
	$app->group(['prefix'=>'check','namespace' => 'Check'], function () use ($app) {
		$app->group(['prefix'=>'comment'],function () use ($app){
			$app->get('/','CommentCheckController@getIndex');
			$app->post('topic/{page}','CommentCheckController@postTopic');
			$app->post('topic-status','CommentCheckController@postTopicStatus');
			$app->post('topic-delete','CommentCheckController@postTopicDelete');

			$app->post('activity/{page}','CommentCheckController@postActivity');
			$app->post('activity-status','CommentCheckController@postActivityStatus');
			$app->post('activity-delete','CommentCheckController@postActivityDelete');

			/*$app->post('product/{page}','CommentCheckController@postProduct');
			$app->post('product-status','CommentCheckController@postProductStatus');
			$app->post('product-delete','CommentCheckController@postProductDelete');*/

			$app->post('knowledge/{page}','CommentCheckController@postKnowledge');
			$app->post('knowledge-status','CommentCheckController@postKnowledgeStatus');
			$app->post('knowledge-delete','CommentCheckController@postKnowledgeDelete');
		});

		$app->group(['prefix'=>'topic'],function () use ($app){
			//审核列表
			$app->get('/','TopicCheckController@getIndex');
			$app->get('detail/{id}','TopicCheckController@getDetail');
			//审核
			$app->post('status','TopicCheckController@postStatus');
			$app->post('delete','TopicCheckController@postDelete');
			$app->post('list/{page}','TopicCheckController@postList');
		});
		

	});

	//产品中心
	$app->group(['prefix'=>'product','namespace' => 'Product'], function () use ($app) {
		//产品列表
		$app->get('/','ProductController@getIndex');
		$app->post('list/{page}','ProductController@postList');
		//详情页面
		$app->get('edit/{id}','ProductController@getEdit');
		//新增
		$app->get('add','ProductController@getAdd');
		$app->post('add','ProductController@postAdd');
		//修改
		$app->post('edit','ProductController@postEdit');
		//删除
		$app->post('delete','ProductController@postDelete');

	});

	//知识中心
	$app->group(['prefix'=>'knowledge','namespace' => 'Knowledge'], function () use ($app) {
		//知识列表
		$app->get('/','KnowledgeController@getIndex');
		$app->post('list/{page}','KnowledgeController@postList');
		//详情页面
		$app->get('edit/{id}','KnowledgeController@getEdit');
		//新增
		$app->get('add','KnowledgeController@getAdd');
		$app->post('add','KnowledgeController@postAdd');
		//修改
		$app->post('edit','KnowledgeController@postEdit');
		//删除
		$app->post('delete','KnowledgeController@postDelete');

	});

	//活动中心
	$app->group(['prefix'=>'activity','namespace' => 'Activity'], function () use ($app) {
		//活动列表
		$app->get('/','ActivityController@getIndex');
		$app->post('list/{page}','ActivityController@postList');
		//详情页面
		$app->get('edit/{id}','ActivityController@getEdit');
		//新增
		$app->get('add','ActivityController@getAdd');
		$app->post('add','ActivityController@postAdd');
		//修改
		$app->post('edit','ActivityController@postEdit');
		//删除
		$app->post('delete','ActivityController@postDelete');

	});

	//系统配置
	$app->group(['prefix'=>'config','namespace' => 'Config'], function () use ($app) {
		$app->group(['prefix'=>'picture'], function () use ($app) {
			//知识图片列表
			$app->get('/','KnowledgePicController@getIndex');
			$app->post('list/{page}','KnowledgePicController@postList');
			//新增
			$app->post('add','KnowledgePicController@postAdd');
			$app->post('status','KnowledgePicController@postStatus');
			//删除
			$app->post('delete','KnowledgePicController@postDelete');
		});

		$app->group(['prefix'=>'carousel'], function () use ($app) {
			//首页轮播图片列表
			$app->get('/','CarouselController@getIndex');

			$app->post('list/{page}','CarouselController@postList');
			//添加
			$app->post('add','CarouselController@postAdd');
			$app->post('status','CarouselController@postStatus');
			//删除
			$app->post('delete','CarouselController@postDelete');
		});

		$app->group(['prefix'=>'category'], function () use ($app) {
			//分类列表
			$app->get('/','CategoryController@getIndex');
			$app->post('list/{page}','CategoryController@postList');
			//新增
			$app->post('add','CategoryController@postAdd');
			//修改
			$app->post('edit','CategoryController@postEdit');
		});
	});

	//优惠券管理
	$app->group(['prefix'=>'coupon'], function () use ($app) {
			
		$app->get('/','CouponController@getIndex');

		$app->post('list/{page}','CouponController@postList');
		
		$app->post('upload','CouponController@postUpload');

	});

	// LogViewer
	$app->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($app) {
		$app->get('/log/dglog/ikea/viewer', 'LogViewerController@index');
	});
});

$app->group(['prefix'=>'app','namespace'=>'App'],function() use($app){
	//登录
	$app->group(['prefix' => 'auth'], function () use ($app) {
		//登录页面
		$app->get('login','AuthController@getLogin');
		//登录
		$app->post('login','AuthController@postLogin');
		//获取验证码
		$app->get('code','AuthController@getCode');

		$app->get('logout','AuthController@getLogout');
	});

	//首页路由
	$app->get('/',function(){
		return redirect('app/index');
	});
	$app->get('index','HomeController@getIndex');
	$app->get('arrange', 'HomeController@getArrange');
	//热门推荐
	$app->get('recommend/index','HomeController@getRecommend');
	$app->get('recommend/list','HomeController@getRecommendList');

	//社群
	$app->get('community',function(){
		return redirect('app/community/index');
	});
	$app->get('community/index','HomeController@getCommunity');

	//产品
	$app->group(['prefix'=>'product'], function () use ($app) {
		//分类页
		$app->get('/',function(){
			return redirect('app/product/index');
		});
		$app->get('index','ProductController@getIndex');
		//产品列表
		$app->get('list','ProductController@getList');
		$app->get('data','ProductController@getData');
		//搜索
		$app->get('search','ProductController@getSearch');
		//产品详情页
		$app->get('info','ProductController@getInfo');
		//收藏
		$app->post('collect','ProductController@postCollect');
	});
	//话题
	$app->group(['prefix'=>'topic'], function () use ($app) {
		//话题须知
		$app->get('/',function(){
			return redirect('app/topic/index');
		});
		$app->get('index','TopicController@getIndex');
		//发布话题
		$app->get('new-topic','TopicController@getNewTopic');
		$app->get('success','TopicController@getSuccess');
		$app->post('new-topic','TopicController@postNewTopic');
		$app->post('upload-img','TopicController@postUploadImg');
		$app->post('delete-img','TopicController@postDeleteImg');
		//列表
		$app->get('list','TopicController@getList');
		$app->get('info','TopicController@getInfo');
		//点赞
		$app->post('like','TopicController@postLike');
		//收藏
		$app->post('collect','TopicController@postCollect');
	});
	//知识
	$app->group(['prefix'=>'knowledge'], function () use ($app) {
		//列表
		$app->get('list','KnowledgeController@getList');
		$app->get('info','KnowledgeController@getInfo');
		//点赞
		$app->post('like','KnowledgeController@postLike');
		//收藏
		$app->post('collect','KnowledgeController@postCollect');
	});
	//活动
	$app->group(['prefix'=>'activity'], function () use ($app) {
		//列表
		$app->get('list','ActivityController@getList');
		$app->get('info','ActivityController@getInfo');
		//报名
		$app->get('register','ActivityController@getRegister');
		$app->post('register','ActivityController@postRegister');
		//收藏
		$app->post('collect','ActivityController@postCollect');
	});
	//用户
	$app->group(['prefix'=>'user'], function () use ($app) {
		$app->get('index','UserController@getIndex');
		$app->get('my-collect','UserController@getCollect');
		$app->get('my-topic','UserController@getTopic');
		$app->get('my-coupon','UserController@getCoupon');
		$app->get('collect-list','UserController@getCollectList');
		$app->get('coupon-list','UserController@getCouponList');
		$app->get('topic-list','UserController@getTopicList');
		$app->post('change-headimg','UserController@postHeadimg');
	});

	//评论
	$app->group(['prefix'=>'comment'], function () use ($app) {
		$app->get('list','CommentController@getList');
		$app->post('send','CommentController@postSend');
		$app->post('like','CommentController@postLike');
	});
});
