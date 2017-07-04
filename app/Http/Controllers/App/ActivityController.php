<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request, App\Repository\App\ActivityRepository;
use Illuminate\Support\Facades\View, Validator;

class ActivityController extends BaseController {

	function __construct(ActivityRepository $activity){
		$this->activity = $activity;
		$this->middleware('app_auth',['only' => ['postCollect']]);
	}

	#活动详情路由
	public function getInfo(Request $request){
		$validator = Validator::make($request->all(), [
	        'activity' => 'required|exists:activities,id',
	    ]);
	    if($validator->fails()){
	    	return redirect('app/community/index');
	    }
	    $activity = $this->activity->detail($request->activity);
		return View::make('app.community.activitydetail',compact('activity'));
	}

	#报名路由
	public function getRegister(){
		return View::make('app.activity.register');
	}

	#获取活动列表
	public function getList(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->activity->getList($page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$result['data'],
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	#活动报名
	public function postRegister(Request $request){
		$validator = Validator::make($request->all(), [
			'activity' => 'required|exists:activities,id',
	        'username' => 'required',
	        'mobile' => array('required','regex:/^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17([0,1,3]|[6-8]))|(18[0-9]))+\d{8})$/')
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    $result = $this->activity->register($request->all());
	    if($result === 1){
	    	return response()->json([
	    		'status' => 3,
	    		'msg' => '活动报名已截止'
	    	]);
	    }else if($result){
	    	return response()->json([
	    		'status' => 0,
	    		'msg' => '报名成功'
	    	]);
	    }else{
	    	return response()->json([
	    		'status' => 2,
	    		'msg' => '报名失败'
	    	]);
	    }
	}

	#收藏/取消收藏活动
	public function postCollect(Request $request){
		$validator = Validator::make($request->all(), [
	        'activity' => 'required|exists:activities,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    
	    $result = $this->activity->collect($request->activity);
	    switch($result){
	    	case 0:
	    		return response()->json([
                'status'=>0,
                'msg'=>'成功',
                ]);
            case 2:
            	return response()->json([
                'status'=>2,
                'msg'=>'失败',
                ]);
	    }
	}
}