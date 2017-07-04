<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request, App\Repository\App\TopicRepository, App\Repository\App\TopicCommentRepository, App\Api\UploadImage, App\Repository\App\CategoryRepository;
use Illuminate\Support\Facades\View, Validator, Illuminate\Validation\Rule;

class TopicController extends BaseController {

	function __construct(TopicRepository $topic, TopicCommentRepository $comment, CategoryRepository $category){
		$this->topic = $topic;
		$this->comment = $comment;
		$this->category = $category;
		$this->middleware('app_auth',['except' => ['getList','getInfo']]);
	}

	#话题须知路由
	public function getIndex(){
		return View::make('app.topic.index');
	}

	#发布话题路由
	public function getNewTopic(){
		$type = $this->category->getTopic();
		return View::make('app.topic.new',array('type' => $type));
	}

	#发布成功
	public function getSuccess(){
		return View::make('app.topic.success');
	}

	#获取话题列表
	public function getList(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$topics = $this->topic->getList($page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$topics['data'],
                'is_lastPage'=>$topics['is_lastPage']
                ]);
	}

	#话题详情路由
	public function getInfo(Request $request){
		$validator = Validator::make($request->all(), [
	        'article' => 'required|exists:user_topics,id',
	    ]);
	    if($validator->fails()){
	    	return redirect('app/community/index');
	    }
	    $topic = $this->topic->detail($request->article);
		return View::make('app.community.topicdetail',array('topic'=>$topic));
	}

	#发布话题
	public function postNewTopic(Request $request){
		$validator = Validator::make($request->all(), [
	        'title' => 'required',
	        'category_id' => ['required',Rule::exists('category','id')->where(function ($query) {
	            $query->where('type', '话题');
	        })],
	        //'images' => 'required',
	        'content' => 'required'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }

	    $result = $this->topic->add($request->all());
	    if($result){
	    	return response()->json([
	    		'status' => 0,
	    		'msg' => '发布成功'
	    	]);
	    }else{
	    	return response()->json([
	    		'status' => 2,
	    		'msg' => '发布失败'
	    	]);
	    }
	}

	#上传图片
	public function postUploadImg(Request $request){
		$validator = Validator::make($request->all(), [
	        'img' => 'required',
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
	    if ($request->hasFile('img')) {
	    	if ($request->file('img')->isValid()) {
			    if(in_array( strtolower($request->file('img')->getClientOriginalExtension()),['jpeg','jpg','gif','gpeg','png','bmp'])){
			    	$result = $upload->uploadQiniu($request->file('img'), 'topics');
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
	     	$result = $upload->DownloadFromWechat($request->img,'topics');
	     }
	     return $result;
	}

	#删除图片
	public function postDeleteImg(Request $request){
		$validator = Validator::make($request->all(), [
	        'img' => 'required',
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
     	$result = $upload->deleteQiniu($request->img);
     	if ($result) {
            return response()->json([
                'status'=>0,
                'msg'=>'图片删除成功'
                ]);
        } else {
            return response()->json([
                'status'=>2,
                'msg'=>'图片删除失败',
                ]);
        }
	}
	
	#点赞话题
	public function postLike(Request $request){
		$validator = Validator::make($request->all(), [
	        'article' => 'required|exists:user_topics,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }

	    $result = $this->topic->like($request->article);
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

	#收藏话题
	public function postCollect(Request $request){
		$validator = Validator::make($request->all(), [
	        'article' => 'required|exists:user_topics,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    
	    $result = $this->topic->collect($request->article);
	    switch($result){
	    	case 0:
	    		return response()->json([
                'status'=>0,
                'msg'=>'成功',
                ]);
            case 3:
            	return response()->json([
                'status'=>3,
                'msg'=>'不能收藏自己发布的话题',
                ]);
            case 2:
            	return response()->json([
                'status'=>2,
                'msg'=>'失败',
                ]);
	    }
	}
}