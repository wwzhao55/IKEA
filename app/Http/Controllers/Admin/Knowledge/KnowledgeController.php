<?php
namespace App\Http\Controllers\Admin\Knowledge;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\knowledgeRepository;

class KnowledgeController extends BaseController
{
    function __construct(knowledgeRepository $knowledge){
        $this->knowledge = $knowledge;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
                
    	return view("admin.knowledge.index");
        
    }

    public function postList($page=0,Request $request){
        $validator = $this->validate($request,[
            'id'=>'exists:knowledge,id',
            ]);
        $id = $request->input('id');

        if($id){
            $lists = $this->knowledge->find($id);
        }else{
            $lists = $this->knowledge->info($page);
        }
    	
    	if($lists){
    		return response()->json(array(
    			'status'=>1,
    			'message'=>'get lists success',
    			'data'=>$lists,
                'count'=>$this->knowledge->count(),
    		));
    	}else{
    		return response()->json(array(
	    		'status'=>0,
	    		'message'=>'add fail',
	    		));
    	}
    }

    public function postAdd(Request $request){
    	$validator = $this->validate($request,[
    		'title'=>'required',
            'category_id'=>'required|exists:category,id',
            'main_img'=>'required|string',
            'images'=>'string',
            'content'=>'required|string',
    		]);

        $info = $request->all();

    	$result = $this->knowledge->add($info);
    	if($result){
    		return response()->json(array(
    			'status'=>1,
    			'message'=>'add success',
    		));
    	}else{
    		return response()->json(array(
	    		'status'=>0,
	    		'message'=>'add fail',
	    		));
    	}    	
    }
    public function getAdd(){
        return view('admin.knowledge.add');
    }
    public function getEdit(){
        return view('admin.knowledge.edit');
    }

    public function postEdit(Request $request){
    	$validator = $this->validate($request,[
    		'id'=>'required|exists:knowledge,id',
    		'title'=>'required',
            'category_id'=>'exists:category,id',
            'main_img'=>'string',
            'images'=>'string',
            'content'=>'string',
    		]);
        $id = $request->input('id');
    	$inputs = $request->except('id');
    	$result = $this->knowledge->update($id,$inputs);
    	if($result){
    		return response()->json(array(
    			'status'=>1,
    			'message'=>'edit success',
    		));
    	}else{
    		return response()->json(array(
	    		'status'=>0,
	    		'message'=>'edit fail',
	    		));
    	}
    }

    public function postDelete(Request $request){
    	$validator = $this->validate($request,[
    		'id'=>'required|exists:knowledge,id',
    		]);
        $id = $request->input('id');
    	$result = $this->knowledge->delete($id);
    	if($result){
    		return response()->json(array(
    			'status'=>1,
    			'message'=>'delete success',
    		));
    	}else{
    		return response()->json(array(
	    		'status'=>0,
	    		'message'=>'delete fail',
	    		));
    	}
    }
}