<?php
namespace App\Http\Controllers\Admin\Check;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\checkRepository;
use App\Repository\Admin\couponRepository;
use Illuminate\Support\Facades\DB;

class TopicCheckController extends BaseController
{
    function __construct(checkRepository $check,couponRepository $coupon){
        $this->check = $check;
        $this->coupon = $coupon;
        //$this->middleware('admin_auth');
    }

    public function getIndex(){
                
        return view("admin.check.topic.index");

    }


    public function postList($page=0,Request $request){
        $id = $request->input('id');
        $has_status = $request->has('status');
        if($has_status){
            $search = array('status'=>$request->input('status'));
        }else{
            $search = null;
        }
        if($id){
            $lists = $this->check->topicFind($id);
        }else{
            $lists = $this->check->topicList($page,$search);
        }
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->check->topicCount($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function getDetail(){
        return view('admin.check.topic.detail');
    }

    public function postStatus(Request $request){
        $validator = $this->validate($request,[
            'id'=>'required|exists:user_topics,id',
            'status'=>'required|in:-1,1',
            ]);
        $id = $request->input('id');
        $status = $request->input('status');
        $result = $this->check->checkTopic($id,$status);
        if($result){
            if($status==1){
                $user_id = $this->check->getTopicUserId($id);
                $should_get_topic_coupon = $this->check->shouldGetTopicCoupon($user_id);
                if($should_get_topic_coupon){
                    $coupon = $this->coupon->getOneUnUsed();
                    if(!$coupon){
                        return response()->json(array(
                            'status'=>2,
                            'message'=>'no coupon can use',
                        ));
                    }else{
                        $this->coupon->getUserCoupon($user_id,$coupon);
                    }
                }
            }
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postDelete(Request $request){
        $validator = $this->validate($request,[
            'id'=>'required|exists:user_topics,id',
            ]);
        $id = $request->input('id');
        $result = $this->check->checkTopic($id,-2);
        if($result){
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

   
}