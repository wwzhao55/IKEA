<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request, App\Repository\App\TopicCommentRepository, App\Repository\App\KnowledgeCommentRepository, App\Repository\App\ActivityCommentRepository;
use Validator;

class CommentController extends BaseController {

	function __construct(KnowledgeCommentRepository $knowledgeC,TopicCommentRepository $topicC, ActivityCommentRepository $activityC){
		$this->knowledgeC = $knowledgeC;
		$this->topicC = $topicC;
		$this->activityC = $activityC;
		$this->middleware('app_auth',['except' => 'getList']);
	}

	#获取评论列表
	public function getList(Request $request){
		$validator = Validator::make($request->all(), [
			'type' => 'required|in:topic,activity,knowledge',
	        'article' => 'required'
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
		switch($request->type){
			case 'topic':
				$comments = $this->topicC->getComments($request->article, $page);
				break;
			case 'activity':
				$comments = $this->knowledgeC->getComments($request->article, $page);
				break;
			// case 'product':
			// 	$comments = $this->productC->getComments($request->article, $page);
			// 	break;
			case 'knowledge':
				$comments = $this->knowledgeC->getComments($request->article, $page);
				break;
		}
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$comments['data'],
                'is_lastPage'=>$comments['is_lastPage']
                ]);
	}

	#发布评论
	public function postSend(Request $request){
		$validator = Validator::make($request->all(), [
			'type' => 'required|in:topic,activity,knowledge',
	        'comment' => 'required',
	        'article' => 'required'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    $data = $request->all();
	    $data['comment'] = strip_tags($data['comment']);
	    switch($request->type){
			case 'topic':
				$result = $this->topicC->sendComment($data);
				break;
			case 'activity':
				$result = $this->activityC->sendComment($data);
				break;
			// case 'product':
			// 	$result = $this->productC->sendComment($data);
			// 	break;
			case 'knowledge':
				$result = $this->knowledgeC->sendComment($data);
				break;
		}
	    if($result == 0){
	    	return response()->json([
                'status'=>0,
                'msg'=>'发布成功',
                ]);
	    }else if($result == 2){
	    	return response()->json([
                'status'=>2,
                'msg'=>'发布失败',
                ]);
	    }else{
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => '文章内容不存在'
	    	]);
	    }
	}

	#点赞/取消 评论
	public function postLike(Request $request){
		$validator = Validator::make($request->all(), [
	        'type' => 'required|in:topic,activity,knowledge',
	        'comment' => 'required',
	        'article' => 'required'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    
	    switch($request->type){
			case 'topic':
				$result = $this->topicC->likeComment($request->article,$request->comment);
				break;
			case 'activity':
				$result = $this->activityC->likeComment($request->article,$request->comment);
				break;
			// case 'product':
			// 	$result = $this->productC->likeComment($request->article,$request->comment);
			// 	break;
			case 'knowledge':
				$result = $this->knowledgeC->likeComment($request->article,$request->comment);
				break;
		}
	    if($result == 0){
	    	return response()->json([
                'status'=>0,
                'msg'=>'成功',
                ]);
	    }else if($result == 2){
	    	return response()->json([
                'status'=>2,
                'msg'=>'失败',
                ]);
	    }else{
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => '内容不存在'
	    	]);
	    }
	}
}