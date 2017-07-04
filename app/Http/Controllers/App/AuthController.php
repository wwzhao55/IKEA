<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController, App\Repository\App\UserRepository;
use Illuminate\Http\Request, Carbon\Carbon, Cache, Validator;

class AuthController extends BaseController {

	public function __construct(UserRepository $user){
		$this->user = $user;
	}

	public function getLogin(){
		if(app('session')->has('user_id') && $this->user->detail()){
			return redirect('app/user/index');
		}
		return view('app.auth.login');
	}

	public function postLogin(Request $request){
		$validator = Validator::make($request->all(), [
	        'mobile' => array('required','regex:/^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17([0,1,3]|[6-8]))|(18[0-9]))+\d{8})$/'),
	        'code' => 'required'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    //验证码
	    $mobile = $request->mobile;
        $code = $request->code;
        if(!Cache::has($mobile) || Cache::get($mobile)['code'] != $code){
            return response()->json([
	    		'status' => 2,
	    		'msg' => '验证码错误',
	    	]);
        }
        //检查用户
	    $check = $this->user->login($mobile);

	    if($check){
	    	app('session')->put('user_id',$check->id);
	    	return response()->json([
	    		'status' => 0,
	    		'msg' => '登录成功',
	    	]);
	    }else{
	    	return response()->json([
	    		'status' => 3,
	    		'msg' => '登录异常',
	    	]);
	    }
	}

	public function getCode(Request $request){
		$validator = Validator::make($request->all(), [
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
	    $code = $this->generate_code();
		//发送短信

		$res = $this->sendCode($request->mobile,$code,config('app_config.code_minute'));
    	if(strstr($res,'success')){
    		$expiresAt = Carbon::now()->addMinutes(10);
    		Cache::put($request->mobile, ['code'=>$code], $expiresAt);
    		return response()->json(['status'=>0,'msg'=>'发送成功']);
    	}else{
    		return response()->json(['status' => 2,'msg' => '服务器忙，请稍后再试']);
    	}
	}

	public function getLogout(){
        if(app('session')->has('user_id')){
            app('session')->forget('user_id');
            return redirect('app/index');
        }
        return redirect('app/index');
    }

	private function generate_code($length = 6) {
	    return rand(pow(10,($length-1)), pow(10,$length)-1);
    }

    private function sendCode($mobile,$code,$time){
        $url = 'http://m.5c.com.cn/api/send/?';
        $username = 'dataguiding';     //用户账号
        $password = 'qwer1234';   //密码
        $apikey = 'b966f93d0035a4ec78b4d27118bc85b7';   //密码
        $content = '【宜家】您好，您的登录验证码为'.$code.'，有效期'.$time.'分钟，如果并非您本人操作，请忽略本条信息';        //内容
        $data = array
            (
            'username'=>$username,                  //用户账号
            'password'=>$password,              //密码
            'mobile'=>$mobile,                  //号码
            'content'=>$content,                //内容
            'apikey'=>$apikey,                  //apikey
            );
        $result= $this->curlSMS($url,$data);           //POST方式提交
        return $result;
    }
    
    private function curlSMS($url,$post_fields=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600); //60秒 
        curl_setopt($ch, CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_REFERER,'http://www.yourdomain.com');
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
        $data = curl_exec($ch);
        curl_close($ch);
        $res = explode("\r\n\r\n",$data);
        return $res[2]; 
    }
}