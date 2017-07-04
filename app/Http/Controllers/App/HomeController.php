<?php
namespace App\Http\Controllers\App;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request, App\Repository\App\ProductRepository, App\Repository\App\CarouselRepository, App\Repository\App\TopicRepository, App\Repository\App\ActivityRepository, App\Repository\App\CategoryRepository, App\Repository\App\KnowledgePicRepository;
use Illuminate\Support\Facades\View;

class HomeController extends BaseController {
	function __construct(ProductRepository $product, CarouselRepository $carousel, TopicRepository $topic, ActivityRepository $activity, CategoryRepository $category, KnowledgePicRepository $knowledge_pic){
		$this->product = $product;
		$this->carousel = $carousel;
		$this->topic = $topic;
		$this->activity = $activity;
		$this->category = $category;
		$this->knowledge_pic = $knowledge_pic;
	}

	public function getIndex(){
		$carousel = $this->carousel->getList();
		$carousel_first = $carousel->first();
		$recommend = $this->product->latestRecommend();
		$topic = $this->topic->latestTopic();
		$activity = $this->activity->latestActivity();
		return View::make('app.home.index',compact('carousel','carousel_first','recommend','topic','activity'));
	}

	public function getArrange(){
		return View::make('app.home.arrange');
	}

	public function getRecommend(){
		return View::make('app.home.recommend');
	}

	public function getRecommendList(Request $request){
		$page = $request->has('page') ? $request->input('page') : 1;
		$recommend = $this->product->getRecommend($page);
		return response()->json([
                'status'=>0,
                'msg'=>'获取成功',
                'data'=>$recommend['data'],
                'is_lastPage'=>$recommend['is_lastPage']
                ]);
	}

	public function getCommunity(){
		$type = $this->category->getAge();
		$knowledge_pic = $this->knowledge_pic->getPic();
		return View::make('app.community.index',array('age' => $type,'knowledge_pic'=>$knowledge_pic));
	}
}