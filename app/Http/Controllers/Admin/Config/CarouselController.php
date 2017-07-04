<?php
namespace App\Http\Controllers\Admin\Config;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\carouselRepository;

class carouselController extends BaseController
{
    function __construct(carouselRepository $carousel){
        $this->carousel = $carousel;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
                
        return view("admin.config.carousel.index");

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
            $lists = $this->carousel->find($id);
        }else{
            $lists = $this->carousel->info($page,$search);
        }
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->carousel->count($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    public function postStatus(Request $request){
        $validator = $this->validate($request,[
            'id'=>'required|exists:carousel,id',
            'status'=>'required|in:0,1',
            ]);
        $id = $request->input('id');
        $status = $request->input('status');
        if($this->carousel->usedCount()>=config('web.carousel_count')){
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
        $result = $this->carousel->update($id,['status'=>$status]);
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

    public function postAdd(Request $request){
        $validator = $this->validate($request,[
            'image'=>'required|string',
            'link'=>'required|string',
            ]);

        $info = $request->all();

        $result = $this->carousel->add($info);

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


    public function postDelete(Request $request){
        $validator = $this->validate($request,[
            'id'=>'required|exists:carousel,id',
            ]);
        $id = $request->input('id');
        $result = $this->carousel->delete($id);
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