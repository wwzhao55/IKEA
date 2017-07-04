<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request, App\Repository\App\ProductRepository, App\Repository\App\CategoryRepository;
use Illuminate\Support\Facades\View, Validator,Illuminate\Validation\Rule;

class ProductController extends BaseController {

	function __construct(ProductRepository $product,CategoryRepository $category){
		$this->product = $product;
		$this->category = $category;
		$this->middleware('app_auth',['only' => ['postCollect']]);
	}

	#产品分类路由
	public function getIndex(){
		$age = $this->category->getAge();
		$room = $this->category->getRoom();
		return View::make('app.product.index',compact('age','room'));
	}

	#产品列表路由
	public function getList(Request $request){
		$validator = Validator::make($request->all(), [
	        'category_id' => ['required',Rule::exists('category','id')->where(function ($query) {
	            $query->whereIn('type', ['年龄','生活空间']);
	        })]
	    ]);
	    if($validator->fails()){
	    	return redirect('app/product/index');
	    }
	    $category = $this->category->getCategoryById($request->category_id);
		return View::make('app.product.productList',compact('category'));
	}

	#产品详情路由
	public function getInfo(Request $request){
		$validator = Validator::make($request->all(), [
	        'product' => 'required|exists:products,id'
	    ]);
		if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    $product = $this->product->detail($request->product);
		//return View::make('app.product.productDetail',compact('product'));
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$product,
                ]);
	}

	#获取产品列表
	public function getData(Request $request){
		$validator = Validator::make($request->all(), [
	        'category' => 'required|in:age,room',
	        'category_id' => 'required|exists:category,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->product->getList($page, $request->category, $request->category_id);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$result['data'],
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	#搜索产品
	public function getSearch(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$result = $this->product->search($request->input('keyword'),$page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$result['data'],
                'is_lastPage'=>$result['is_lastPage']
                ]);
	}

	#收藏产品
	public function postCollect(Request $request){
		$validator = Validator::make($request->all(), [
	        'product' => 'required|exists:products,id'
	    ]);
	    if($validator->fails()){
	    	$warnings = $validator->messages();
            $show_warning = $warnings->first();
	    	return response()->json([
	    		'status' => 1,
	    		'msg' => $show_warning
	    	]);
	    }
	    
	    $result = $this->product->collect($request->product);
	    switch($result){
	    	case 0:
	    		return response()->json([
                'status'=>0,
                'msg'=>'成功',
                ]);
            case 2:
            	return response()->json([
                'status'=>2,
                'msg'=>'失败',
                ]);
	    }
	}
}