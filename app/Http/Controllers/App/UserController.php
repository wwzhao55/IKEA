<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController, App\Repository\App\UserRepository, App\Repository\App\CouponRepository,App\Repository\App\TopicRepository, App\Api\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View,Validator;

class UserController extends BaseController {
	public function __construct(UserRepository $user, CouponRepository $coupon, TopicRepository $topic){
		$this->user = $user;
		$this->coupon = $coupon;
		$this->topic = $topic;
		$this->middleware('app_auth');
	}

	#个人中心路由
	public function getIndex(){
		$user = $this->user->detail();
		return View::make('app.user.index',array('headimg'=>$user->head_img,'mobile'=>$user->mobile));
	}

	#我的收藏路由
	public function getCollect(){
		return View::make('app.user.collect');
	}

	#我的优惠路由
	public function getCoupon(){
		return View::make('app.user.coupon');
	}

	#我的话题路由
	public function getTopic(){
		return View::make('app.user.topic');
	}

	#获取
	public function getCollectList(Request $request){
		$validator = Validator::make($request->all(), [
			'type' => 'required|in:topic,activity,product,knowledge',
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->user->getCollect($request->input('type'),$page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'type' => $request->type,
                'data'=>$result['data'],
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	public function getCouponList(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->coupon->myCoupon($page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$result['data'],
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	public function getTopicList(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->topic->myTopic($page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$result['data'],
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	#改变头像
	public function postHeadimg(Request $request){
		$validator = Validator::make($request->all(), [
			'headimg' => 'required',
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    $upload = new UploadImage();
	    if ($request->hasFile('headimg')) {
	    	if ($request->file('headimg')->isValid()) {
			    if(in_array( strtolower($request->file('headimg')->getClientOriginalExtension()),['jpeg','jpg','gif','gpeg','png','bmp'])){
			    	$result = $upload->uploadQiniu($request->file('headimg'), 'headimg');
			    }else{
			    	return response()->json([
			    		'status' => 1,
			    		'msg' => '图片格式错误'
			    	]);
			    }
			}else{
				return response()->json([
			    		'status' => 1,
			    		'msg' => '图片格式错误'
			    	]);
			}
		    
		}else{
	     	$result = $upload->DownloadFromWechat($request->headimg,'headimg');
	    }

	    if($result->getData()->status != 0){
	    	return response()->json([
			    		'status' => 2,
			    		'msg' => '更换失败'
			    	]);
	    }
	    $check = $this->user->changeHeadimg($result->getData()->data);
	    if($check){
	    	return response()->json([
			    		'status' => 0,
			    		'msg' => '更换成功'
			    	]);
	    }else{
	    	return response()->json([
			    		'status' => 2,
			    		'msg' => '更换失败'
			    	]);
	    }
	}
}