<?php
namespace App\Http\Controllers\Admin\Data;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\dataRepository;

class DataController extends BaseController
{

    function __construct(dataRepository $data){
        $this->middleware('admin_auth');
        $this->data = $data;
    }

    public function getIndex(){
        return view('admin.data.index');
    }

    public function getInfo(Request $request){
        $start = $request->input('start')?$request->input('start'):$this->data->get_the_first_user_register_time();
        $end = $request->input('end')?$request->input('end'):time();
        $lists = $this->data->data($start,$end);
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    
}
