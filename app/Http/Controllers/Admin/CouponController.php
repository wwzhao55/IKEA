<?php
namespace App\Http\Controllers\Admin;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as Excel;
use App\Repository\Admin\couponRepository;

class CouponController extends BaseController
{

    function __construct(couponRepository $coupon){
        $this->coupon = $coupon;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
        return view('admin.coupon.index',array(
                'download_url'=>config('web.qiniu_domain').config('web.coupon_model_name')
            ));
    }

    public function postList($page=0,Request $request){
        $is_get = $request->input('is_get');
        if($is_get){
            $search = array('is_get'=>$is_get);
        }else{
            $search = null;
        }
        $lists = $this->coupon->info($page,$search);
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->coupon->count($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    public function postUpload(Request $request){
        $file = $request->file('coupon');
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
        $des = dirname($_SERVER['SCRIPT_FILENAME']);
        $file_name = 'coupon.xlsx';
        if(file_exists($des.'/'.$file_name)){
            unlink($des.'/'.$file_name);
        }
        $file->move($des,$file_name);

        $excel_data = Excel::load($des.'/'.$file_name)->get()->toArray();
        //$excel_data = Excel::load($des.'/'.$file_name)->get()->toArray();
        $excel_handle_data = array();
        foreach ($excel_data as $lists) {
            $item = array();
            foreach ($lists as $value) {
                array_push($item,$value);
            }
            array_push($excel_handle_data,array(
                'code'=>$item[0],
                'value'=>$item[1],
                ));
        }

        $result = $this->coupon->multiAdd($excel_handle_data);
        if($result){
            return response()->json(array(
                'status'=>1,
                'message'=>'add lists success',            
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'add fail',
                ));
        }
    }
}
