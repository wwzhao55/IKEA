<?php
namespace App\Http\Controllers\Admin\Config;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\categoryRepository;

class CategoryController extends BaseController
{
    function __construct(categoryRepository $category){
        $this->category = $category;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
                
    	return view("admin.config.category.index");
    }

    public function postList($page=0,Request $request){
        $type = $request->input('type')?$request->input('type'):'话题';
        $all = $request->input('all')?$request->input('all'):0;
    	$lists = $this->category->info($type,$page,$all);
    	if($lists){
    		return response()->json(array(
    			'status'=>1,
    			'message'=>'get lists success',
    			'data'=>$lists,
                'count'=>$this->category->count($type)
    		));
    	}else{
    		return response()->json(array(
	    		'status'=>0,
	    		'message'=>'get fail',
	    		));
    	}
    }

    public function postAdd(Request $request){
    	$validator = $this->validate($request,[
    		'name'=>'required',
    		'type'=>'required|in:年龄,生活空间,话题',
            'image'=>'required_if:type,年龄,生活空间|string',
    		]);
    	if($validator){
    		return response()->json(array(
                'status'=>-1,
                'message'=>'验证失败',
                'data'=>$validator,
                ));
    	}

        $has_name = $this->category->hasName($request->input('type'),$request->input('name'));
        if($has_name>1){
            return response()->json(array(
                'status'=>-1,
                'message'=>'already has this name',
                'data'=>[
                    'name'=>'already has this name'
                ]
                )); 
        }

        $info = array(
            'name'=>$request->input('name'),
            'type'=>$request->input('type'),
            'image'=>$request->input('image'),
            'status'=>1,
            );

    	$result = $this->category->add($info);
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

    public function postEdit(Request $request){
    	$validator = $this->validate($request,[
    		'id'=>'required|exists:category',
    		]);
    	if($validator){
    		return response()->json(array(
                'status'=>-1,
                'message'=>'验证失败',
                'data'=>$validator,
                ));
    	}

        $id = $request->input('id');
        $update_info = array();
        $name = $request->input('name');
        $image = $request->input('image');
        if($name){
            $type = $this->category->getType($id);
            $has_name = $this->category->hasName($type,$name);
            if($has_name>1){
                return response()->json(array(
                    'status'=>-1,
                    'message'=>'already has this name',
                    'data'=>[
                        'name'=>'already has this name'
                    ]
                    )); 
            }else{
                $update_info['name'] = $name;
            }
        }
        if($image){
            $update_info['image'] = $image;
        }
               
    	$result = $this->category->update($id,$update_info);
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

    /*public function postDelete(Request $request){
    	$validator = $this->validate($request,[
    		'id'=>'required|exists:category',
    		]);
    	if($validator){
    		return response()->json(array(
                'status'=>-1,
                'message'=>'验证失败',
                'data'=>$validator,
                ));
    	}
        $id = $request->input('id');
    	$result = $this->category->delete($id);
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
    }*/
}