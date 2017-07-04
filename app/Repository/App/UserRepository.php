<?php
namespace App\Repository\App;

use App\User, App\Model\Admin\ActivityModel, App\Model\Admin\KnowledgeModel, App\Model\Admin\ProductModel, App\Model\App\TopicModel, App\Model\Admin\CouponModel;

class UserRepository
{
    /** @var User 注入的User model */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user, ActivityModel $activity, KnowledgeModel $knowledge, ProductModel $product, TopicModel $topic, CouponModel $coupon)
    {
        $this->user = $user;
        $this->activity = $activity;
        $this->knowledge = $knowledge;
        $this->product = $product;
        $this->topic = $topic;
        $this->coupon = $coupon;
    }

    public function login($mobile){
        
        $check = $this->findUserByMobile( $mobile );
        if(!$check){
            /*$coupon = $this->coupon->where('is_get',0)->first();
            if($coupon){
                $code = array(array('code'=>$coupon->code,'value'=>$coupon->value,'is_read'=>false));
                $coupon->is_get = 1;
                $coupon->save();
            }else{
                $code = [];
            }*/
            $code = [];
            $check = new User;
            $check->mobile = $mobile;
            $check->head_img = 'img/default_head.png'; 
            $check->like = json_encode(array("topics"=>[], "knowledge"=>[]));
            $check->collect = json_encode(array("topics"=>[], "knowledge"=>[], 'products'=>[],'activities'=>[]));
            $check->like_comment = json_encode(array("topics"=>[], "knowledge"=>[], 'products'=>[],'activities'=>[]));
            $check->coupon = json_encode(array("code"=>$code));
            $check->save();
        }
        return $check;
    }

    public function getCollect($type,$page){
        $is_lastPage = true;

        $offset = $page==1 ? 0 : ($page - 1) * config('app_config.page')-1;
        $obj = $this->user->findUserById(app('session')->get('user_id'));
        if(!$obj){
            return 1;
        }
        $collect = json_decode($obj->collect);

        switch($type){
            case 'topic':
                $skip = ($page - 1) * config('app_config.page');
                $data = $this->topic->has('user')->where('status',1)->whereIn('id',$collect->topics)->skip($skip)->take(config('app_config.page')+1)->get();
                if($data->count() > config('app_config.page')){
                    $data->pop();
                    $is_lastPage = false;
                }

                foreach ($data as $key => $list) {
                    $images = json_decode($list->images)->url;
                    $list->main_img = count($images) ? $images[0] : "";
                    $list->username = $list->user->name ? $list->user->name : preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $list->user->mobile);
                    $list->head_img = $list->user->head_img;
                    unset($list->images);
                    unset($list->user);
                }
                break;
            case 'activity':
                if (count($collect->activities) > $page*config('app_config.page')) {
                    $is_lastPage = false;
                }
                $arr = array_slice($collect->activities,$offset,config('app_config.page'));

                $data = $this->activity->whereIn('id',$arr)->select('id','name','main_images','start_time','end_time','register_end_time')->get();
                
                break;
            case 'product':
                if (count($collect->products) > $page*config('app_config.page')) {
                    $is_lastPage = false;
                }
                $arr = array_slice($collect->products,$offset,config('app_config.page'));
                $data = $this->product->whereIn('id',$arr)->select('id','name','age','room','comment_num','main_img','price')->get();
                break;
            case 'knowledge':
                if (count($collect->knowledge) > $page*config('app_config.page')) {
                    $is_lastPage = false;
                }
                $arr = array_slice($collect->knowledge,$offset,config('app_config.page'));
                $data = $this->knowledge->whereIn('id',$arr)->select('id','category_id','title','main_img','content','like_num','comment_num','created_at')->get();
                break;
        }
        return compact('data','is_lastPage');
    }

    public function findUserByMobile($mobile){
        return $this->user->where('mobile',$mobile)->first();
    }

    public function changeHeadimg($url){
        $user = $this->user->findUserById(app('session')->get('user_id'));
        $user->head_img = $url;
        return $user->save();
    }

    public function detail(){
        $user = $this->user->findUserById(app('session')->get('user_id'));
        return $user;
    }
}