<?php
namespace App\Http\Controllers\Admin\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\adminRepository;



class AuthController extends BaseController
{
    function __construct(adminRepository $admin){
        $this->admin = $admin;
        $this->middleware('admin_auth',['only'=>'getLogout']);
    }
    public function getLogin(){
        
    	return view("auth.login");

    }

    public function postLogin(Request $request){
        $validator = $this->validate($request,[
            'account' => 'required|string',
            'password' => 'required|string|min:6'
        ]);
        $inputs = $request->all(); 
        $admin = $this->admin->find($inputs['account']);
        if($admin){
            if($admin->password == md5($inputs['password'])){
                header("Cache-Control: no-store, no-cache, must-revalidate");
                app('session')->put('admin_id',array(
                    'id'=>$admin->id,
                    'account'=>$admin->account,
                    'status'=>$admin->status,
                    ));
                $this->admin->updateSessionId($admin->id);
                return response()->json(array(
                    'status'=>1,
                    'message'=>'login success',
                    ));
            }else{
                return response()->json(array(
                    'status'=>0,
                    'message'=>'your password is wrong',
                    ));
            }
        }else{
            return response()->json(array(
                'status'=>'fail',
                'message'=>'there is no such user',
                ));
        }



    }

    public function getLogout(){
        if(app('session')->has('admin_id')){
            header("Cache-Control: no-store, no-cache, must-revalidate");
            app('session')->forget('admin_id');
            return redirect('admin/login');
        }
        return redirect('admin/login');
    }
}
