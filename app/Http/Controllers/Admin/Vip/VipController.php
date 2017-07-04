<?php
namespace App\Http\Controllers\Admin\Vip;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as Excels;
use App\Repository\Admin\vipRepository;

class VipController extends BaseController
{

    function __construct(vipRepository $vip){
        $this->middleware('admin_auth');
        $this->vip = $vip;
    }

    public function getIndex(){
        return view('admin.vip.index');
    }

    public function postList($page=0,Request $request){
        $lists = $this->vip->info($page);
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->vip->count(),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    public function getExport(Request $request){
        $name = "用户列表";
        $data = $this->vip->getExportUser();
        Excels::create($name,function($excel) use ($data){

            $excel->sheet('sheet1', function($sheet) use ($data){
                $sheet->rows($data);
                // Set width for multiple cells
                $sheet->setWidth(array(
                    'A'     =>  20,
                    'B'     =>  20,
                    'C'     =>  20,
                    'D'     =>  20,
                    'E'     =>  20,
                    'F'     =>  20,
                    'G'     =>  20,
                    'H'     =>  20,
                    'I'     =>  20,
                    'J'     =>  20,
                    'K'     =>  20,
                    'L'     =>  20,
                    'M'     =>  20,
                    'N'     =>  20,
                ));
            });
        })->export('xls');
    }
}
