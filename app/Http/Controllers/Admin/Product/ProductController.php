<?php
namespace App\Http\Controllers\Admin\Product;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\productRepository;

class ProductController extends BaseController
{
    function __construct(productRepository $product){
        $this->product = $product;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
                
        return view("admin.product.index");
    }

    public function postList($page=0,Request $request){
        $validator = $this->validate($request,[
            'id'=>'exists:products,id',
            ]);
        $id = $request->input('id');
        if($id){
            $lists = $this->product->find($id);
        }else{
            $lists = $this->product->info($page);
        }
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->product->count(),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'add fail',
                ));
        }
    }

    public function getEdit(){
        return view('admin.product.edit');
    }

    public function getAdd(){
        return view('admin.product.add');
    }

    public function postAdd(Request $request){
        $validator = $this->validate($request,[
            'name'=>'required',
            'age'=>'required|exists:category,id',
            'room'=>'required|exists:category,id',
            'price'=>'required|between:0,999999999',
            'main_img'=>'required|string',
            ]);

        $info = $request->all();

        $result = $this->product->add($info);
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
            'id'=>'required|exists:products,id',
            'age'=>'exists:category,id',
            'room'=>'exists:category,id',
            'price'=>'between:0,999999999',
            'main_img'=>'string',
            ]);
        $id = $request->input('id');
        $inputs = $request->except('id');
        $result = $this->product->update($id,$inputs);
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
            'id'=>'required|exists:products,id',
            ]);
        $id = $request->input('id');
        $result = $this->product->delete($id);
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