<?php
namespace App\Api;
use Qiniu\Auth;  
use Qiniu\Storage\UploadManager, Qiniu\Storage\BucketManager;

class UploadImage 
{

    public function uploadQiniu($file, $path, $isFile = true, $name=''){
        if(!$file){
            return response()->json(array(
                'status'=>1,
                'message'=>'no file'
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
        
        // 上传到七牛后保存的文件名
        $date = time();
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        if($isFile){
            // 要上传文件的本地路径
            $filePath = $file->getRealPath();
            $key = $path.'/'.$date.'.'.$file->getClientOriginalExtension();
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        }else{
            $key = $path.'/'.$name;
            list($ret, $err) = $uploadMgr->put($token, $key, $file);
        }

        if (!is_null($err)) {
            return response()->json([
                'status'=>2,
                'msg'=>'图片上传失败'
                ]);
        } else {
            return response()->json([
                'status'=>0,
                'msg'=>'图片上传成功',
                'data'=>$ret['key']  ,
                ]);
        }
    }

    public function deleteQiniu($key){
        $accessKey = config('web.QINIU_ACCESSKEY');
        $secretKey = config('web.QINIU_SECRETKEY');
        //初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);
        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);
        //你要测试的空间， 并且这个key在你空间中存在
        $bucket = config('web.QINIU_BUCKET');

        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        if (is_null($err)) {
          return true;
        } else {
          return false;
        }
    }

    public function DownloadFromWechat($serveId, $path){
        $json_access_token_info = $this->httpGet('wxapi.dgdev.cn/getAccessToken.php');
        $array_access_token_info = json_decode($json_access_token_info);
        if($array_access_token_info->status == 'success'){
            $access_token = $array_access_token_info->access_token;
        }else{
            return response()->json(array(
                'status'=>2,
                'message'=>'图片上传失败！',
                ));
        }
    
        //$down_url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=c-zr8eBGY9rb5_-t1qmPxWaLJgfYAyA-HW0rcQf1fqZKkEzWaTg5Sw0w4d-Hj_E3cac96lnhvLTWfXxprQ9XUX-6DSaWl5iDD9XYcGaVVgkXRSbAFAAUV&media_id=ACuVP9XrJOu2FZbDV9hBAXD8YQVAoa-o9JlAdfRrcN_E6EOdB-j2QC1oUhJm5zqw";
        $down_url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$serveId;
        $front_img_info = $this->downloadWeixinFile($down_url);

        if(!$this->checkDownload($front_img_info) ){
            return response()->json(array(
                'status'=>2,
                'message'=>'图片上传失败！',
                ));
        }
        $ext = str_replace('image/', '', $front_img_info['header']['content_type']);
        $front_img_name =time().'.'.$ext;
        $result = $this->uploadQiniu($front_img_info['body'], 'topics', false, $front_img_name);

        return $result;
    }

     private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function downloadWeixinFile($url)  {  
        $ch = curl_init($url);  
        curl_setopt($ch, CURLOPT_HEADER, 0);      
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        $package = curl_exec($ch);  
        $httpinfo = curl_getinfo($ch);  
        curl_close($ch);  
        $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));   
        return $imageAll;  
    }  

    private function checkDownload($download){
        $body_json = $download['body'];
        return  is_null(json_decode($body_json));
    }  
}
