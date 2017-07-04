<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request,App\Repository\App\KnowledgeRepository,App\Repository\App\KnowledgeCommentRepository;
use Illuminate\Support\Facades\View,Validator;

class KnowledgeController extends BaseController {

	function __construct(KnowledgeRepository $knowledge, KnowledgeCommentRepository $comment){
		$this->knowledge = $knowledge;
		$this->comment = $comment;
		$this->middleware('app_auth',['except' => ['getInfo','getList']]);
	}

	#知识详情路由
	public function getInfo(Request $request){
		$validator = Validator::make($request->all(), [
	        'article' => 'required|exists:knowledge,id',
	    ]);
	    if($validator->fails()){
	    	return redirect('app/community/index');
	    }
	    $knowledge = $this->knowledge->detail($request->article);
		return View::make('app.community.knowledgedetail',compact('knowledge'));
	}

	#获取知识列表 分页
	public function getList(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->knowledge->getList($page, $request->input('category'));
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$result['data'],
                'category'=>$request->input('category'),
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	#点赞知识
	public function postLike(Request $request){
		$validator = Validator::make($request->all(), [
	        'article' => 'required|exists:knowledge,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }

	    $result = $this->knowledge->like($request->article);
	    if($result){
	    	return response()->json([
                'status'=>0,
                'msg'=>'成功',
                ]);
	    }else{
	    	return response()->json([
                'status'=>2,
                'msg'=>'失败',
                ]);
	    }
	}

	#收藏知识
	public function postCollect(Request $request){
		$validator = Validator::make($request->all(), [
	        'article' => 'required|exists:knowledge,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    
	    $result = $this->knowledge->collect($request->article);
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