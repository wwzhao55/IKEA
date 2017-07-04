<?php
namespace App\Http\Controllers\Admin\Info;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\adminRepository;

class InfoController extends BaseController
{
    function __construct(adminRepository $admin){        
        $this->middleware('admin_auth');
        $this->middleware('superadmin_auth');
        $this->admin = $admin;
    }

    public function getIndex(){
                
    	return view("admin.info.index");
    }

    public function postList($page=0){
    	$lists = $this->admin->info($page);
    	if($lists){
    		return response()->json(array(
    			'status'=>1,
    			'message'=>'get lists success',
    			'data'=>$lists,
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
    		'account'=>'required|unique:admin',
    		'password'=>'required|min:6',
    		]);
    	if($validator){
    		return response()->json(array(
                'status'=>-1,
                'message'=>'验证失败',
                'data'=>$validator,
                ));
    	}

        $info = array(
            'account'=>$request->input('account'),
            'password'=>md5($request->input('password')),
            'status'=>0,
            );

    	$result = $this->admin->add($info);
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
    		'id'=>'required|exists:admin,id,status,0',
    		'account'=>'unique:admin,account,'.$request->input('id'),
    		'password'=>'min:6',
    		]);
    	if($validator){
    		return response()->json(array(
                'status'=>-1,
                'message'=>'验证失败',
                'data'=>$validator,
                ));
    	}
        $id = $request->input('id');
    	$inputs = $request->all('account','password');
        if(isset($inputs['password'])){
            $inputs['password'] = md5($inputs['password']);
        }
    	$result = $this->admin->update($id,$inputs);
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
    		'id'=>'required|exists:admin,id,status,0',
    		]);
    	if($validator){
    		return response()->json(array(
                'status'=>-1,
                'message'=>'验证失败',
                'data'=>$validator,
                ));
    	}
        $id = $request->input('id');
    	$result = $this->admin->delete($id);
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