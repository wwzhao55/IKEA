<?php
namespace App\Http\Controllers\Admin;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Qiniu\Auth;  
use Qiniu\Storage\UploadManager;
class ImageController extends BaseController
{

    function __construct(){
        $this->middleware('admin_auth');
    }

    public function postUpload(Request $request){
        $dir = $request->input('dir');
        $this->validate($request,[
            'dir'=>'required|in:topic,knowledge,product,activity,category,carousel,index'
            ]);
        $file = $request->file('image');
        if(!$file){
            return response()->json(array(
            	'status'=>-1,
            	'message'=>'no file'
            	)) ;
        }
        if(!$file->isValid()){
            return response()->json(array(
            	'status'=>-1,
            	'message'=>'not valid'
            	)) ;
        }

         // 需要填写你的 Access Key 和 Secret Key
        $accessKey = config('web.QINIU_ACCESSKEY');
        $secretKey = config('web.QINIU_SECRETKEY');
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 要上传的空间
        $bucket = config('web.QINIU_BUCKET');

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $file->getRealPath();
        // 上传到七牛后保存的文件名
        $date = time();
        $key = $dir."/".$date.'.'.$file->getClientOriginalExtension();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return response()->json([
            	'status'=>0,
            	'message'=>'图片上传失败',
            	]);
        } else {
            return response()->json([
            	'status'=>1,
            	'message'=>'图片上传成功',
            	'data'=>$ret,
            	]);
        }
    }
}
