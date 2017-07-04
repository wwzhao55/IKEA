<?php
namespace App\Repository\App;

use App\Model\Admin\ProductModel, App\User;

class ProductRepository
{
    /** @var Product 注入的product model */
    protected $product;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(ProductModel $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function getList($page,$type,$category_id){
        $is_lastPage = true;

        $skip = ($page - 1) * config('app_config.page');
        if($type == 'age'){
            $result = $this->product->where('age',$category_id)->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->select('id','name','age','room','comment_num','main_img','price','color','size','item_num')->get();
        }else if($type == 'room'){
            $result = $this->product->where('room',$category_id)->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->select('id','name','age','room','comment_num','main_img','price','color','size','item_num')->get();
        }

        if($result->count() > config('app_config.page')){
            $result->pop();
            $is_lastPage = false;
        }
        foreach ($result as $key => $value) {
            $value->isCollect = $this->isCollect($value->id);
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function detail($id){
        $product = $this->product->find($id);
        $product->isCollect = $this->isCollect($id);
        return $product;
    }

    public function search($keyword,$page){
        $is_lastPage = true;
        $skip = ($page - 1) * config('app_config.page');
        if($keyword){
            //搜索需要优化
            $result = $this->product->where(function($query) use($keyword){
                $query->where('name','like','%'.$keyword.'%');
            })->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->select('id','name','age','room','comment_num','main_img','price','color','size','item_num')->get();
        }else{
            $result = $this->product->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->select('id','name','age','room','comment_num','main_img','price','color','size','item_num')->get();
        }
        if($result->count() > config('app_config.page')){
            $result->pop();
            $is_lastPage = false;
        }
        foreach ($result as $key => $value) {
            $value->isCollect = $this->isCollect($value->id);
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function latestRecommend(){
        return $this->product->orderBy('created_at','desc')->take(config('app_config.recommend_count'))->select('id','name','collect_num','main_img','price','color','size','item_num')->get();
    }

    public function getRecommend($page){
        $is_lastPage = true;
        $skip = ($page - 1) * config('app_config.page');
        $result = $this->product->orderBy('created_at','desc')->skip($skip)->take(config('app_config.recommend_page')+1)->select('id','name','collect_num','main_img','price','color','size','item_num')->get();
        if($result->count() > config('app_config.recommend_page') || $page >= 10){
            $result->pop();
            $is_lastPage = false;
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function isCollect($product){
        if(app('session')->has('user_id') && $this->user->findUserById(app('session')->get('user_id'))){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $collect = json_decode($user->collect);
            $arr = $collect->products;
            if(in_array($product, $arr)){
                //已经收藏过
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function collect($product){
        $obj = $this->product->find($product);
        if($obj->user_id == app('session')->get('user_id')){
            return 3;
        }
        $user = $this->user->findUserById(app('session')->get('user_id'));
        $collect = json_decode($user->collect);
        $arr = $collect->products;
        if(in_array($product, $arr)){
            //已经收藏过，则取消收藏
            if( !is_null( ($key = array_search($product,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->collect_num = $obj->collect_num<=0 ? 0: --$obj->collect_num;
        }else{
            array_push($arr, $product);
            $obj->collect_num += 1;
        }
        $collect->products = $arr;
        $user->collect = json_encode($collect);
        if($user->save() && $obj->save()){
            return 0;
        }else{
            return 2;
        }       
    }
}