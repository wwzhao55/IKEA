<?php
namespace App\Repository\App;

use App\Model\Admin\ActivityModel, App\Model\App\ActivityUserModel, App\User;

class ActivityRepository
{

    protected $activity;


    public function __construct(ActivityModel $activity, ActivityUserModel $register, User $user)
    {
        $this->activity = $activity;
        $this->register = $register;
        $this->user = $user;
    }

    public function getList($page){
        $is_lastPage = true;

        $skip = ($page - 1) * config('app_config.page');
        $result = $this->activity->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->select('id','name','main_images','start_time','end_time','register_end_time','status')->get();
        if($result->count() > config('app_config.page')){
            $result->pop();
            $is_lastPage = false;
        }
        foreach ($result as $key => $val) {
            $val->main_images = json_decode($val->main_images,true);
            //$val->images = json_decode($val->images,true);
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function detail($id){
        $activity = $this->activity->find($id);
        $activity->is_collect = $this->isCollect($id);
        $activity->main_images = json_decode($activity->main_images,true);
        $activity->images1 = json_decode($activity->images1,true);
        $activity->images2 = json_decode($activity->images2,true);
        $activity->images3 = json_decode($activity->images3,true);
        $activity->images4 = json_decode($activity->images4,true);
        $activity->images5 = json_decode($activity->images5,true);
        return $activity;
    }

    public function register($data){
        //检查活动状态
        $obj = $this->activity->find($data['activity']);
        if($obj->status == 1){
            return 1;
        }

        $obj->register_num += 1;
        $data['activity_id'] = $data['activity'];
        $this->register->fill($data)->save();
        return $obj->save();
    }

    public function collect($activity){
        $obj = $this->activity->find($activity);

        $user = $this->user->findUserById(app('session')->get('user_id'));
        $collect = json_decode($user->collect);
        $arr = $collect->activities;
        if(in_array($activity, $arr)){
            //已经收藏过，则取消收藏
            if( !is_null( ($key = array_search($activity,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->collect_num = $obj->collect_num<=0 ? 0: --$obj->collect_num;
        }else{
            array_push($arr, $activity);
            $obj->collect_num += 1;
        }
        $collect->activities = $arr;
        $user->collect = json_encode($collect);
        if($user->save() && $obj->save()){
            return 0;
        }else{
            return 2;
        }       
    }

    public function isCollect($id){
        if(app('session')->has('user_id') && $this->user->findUserById(app('session')->get('user_id'))){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $collect = json_decode($user->collect);
            $arr = $collect->activities;
            if(in_array($id, $arr)){
                //已经收藏过
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }    
    }

    public function latestActivity(){
        $result = $this->activity->where('status',0)->orderBy('start_time','asc')->take(config('app_config.recommend_count'))->select('id','name','main_images','status')->get();
        foreach ($result as $key => $val) {
            $val->main_images =  json_decode($val->main_images,true)[0];
        }
        return $result;
    }
}