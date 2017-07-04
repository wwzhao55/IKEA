<?php
namespace App\Http\Controllers\Admin\Activity;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\activityRepository;

class ActivityController extends BaseController
{
    function __construct(activityRepository $activity){
        $this->activity = $activity;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
                
        return view("admin.activity.index");

    }
    public function getEdit(){
        return view('admin.activity.edit');
    }

    public function getAdd(){
        return view('admin.activity.add');
    }
    
    public function postList($page=0,Request $request){
        $validator = $this->validate($request,[
            'id'=>'exists:activities,id',
            ]);
        $id = $request->input('id');
        if($id){
            $lists = $this->activity->find($id);
        }else{
            $lists = $this->activity->info($page);
        }
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->activity->count(),
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
            'address'=>'required|string',
            'start_time'=>'required|integer',            
            'register_end_time'=>'required|integer|max:'.$request->input('end_time'),
            'end_time'=>'required|integer|min:'.$request->input('start_time'),
            'main_images'=>'required|string',
            ]);

        $info = $request->all();

        $result = $this->activity->add($info);

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
            'id'=>'required|exists:activities,id',
            'name'=>'string',
            'address'=>'string',
            'start_time'=>'integer',            
            'register_end_time'=>'integer|max:'.$request->input('end_time'),
            'end_time'=>'integer|min:'.$request->input('start_time'),
            'main_images'=>'string',
            'status'=>'in:0,1'
            ]);
        $id = $request->input('id');
        $inputs = $request->except('id');
        $result = $this->activity->update($id,$inputs);
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
            'id'=>'required|exists:activities,id',
            ]);
        $id = $request->input('id');
        $result = $this->activity->delete($id);
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