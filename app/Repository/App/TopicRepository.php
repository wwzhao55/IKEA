<?php
namespace App\Repository\App;

use App\Model\App\TopicModel, App\User;

class TopicRepository
{
    /** @var topic 注入的Topic model */
    protected $topic;

    /**
     * TopicRepository constructor.
     * @param Topic $topic
     */
    public function __construct(TopicModel $topic, User $user)
    {
        $this->topic = $topic;
        $this->user = $user;
    }

    public function add($data){
        $data['content'] = strip_tags($data['content']);
        $data['user_id'] = app('session')->get('user_id');
        $data['status'] = 0;
        $url = $data['images']=="" ? [] : explode(',', $data['images']);
        $data['images'] = json_encode(array('url' => $url )) ;
        return $this->topic->fill($data)->save();
    }

    public function getList($page){
        $skip = ($page - 1) * config('app_config.page');
        $result = $this->topic->has('user')->where('status',1)->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->get();

        if($result->count() > config('app_config.page')){
            $result->pop();
            $is_lastPage = false;
        }else{
            $is_lastPage = true;
        }

        foreach ($result as $key => $list) {
            $images = json_decode($list->images)->url;
            $list->main_img = count($images) ? $images[0] : "";
            $list->username = $list->user->name ? $list->user->name : preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $list->user->mobile);
            $list->head_img = $list->user->head_img;
            unset($list->images);
            unset($list->user);
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function detail($id){
        $topic = $this->topic->find($id);
        $topic->images = json_decode($topic->images)->url;
        $topic->username = $topic->user?($topic->user->name ? $topic->user->name : preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $topic->user->mobile)):'未知';
        $topic->head_img = $topic->user? $topic->user->head_img : 'img/default_head.png';
        $topic->is_like = $this->isLike($id);
        $topic->is_collect = $this->isCollect($id);
        unset($topic->user);
        return $topic;
    }

    public function like($topic){
        $obj = $this->topic->find($topic);
        $user = $this->user->findUserById(app('session')->get('user_id'));
        $like = json_decode($user->like);
        $arr = $like->topics;
        if(in_array($topic, $arr)){
            //已经点赞过，则取消点赞
            if( !is_null( ($key = array_search($topic,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->like_num = $obj->like_num<=0 ? 0: --$obj->like_num;
        }else{
            array_push($arr, $topic);
            $obj->like_num += 1;
        }
        $like->topics = $arr;
        $user->like = json_encode($like);
        return $user->save() && $obj->save();       
    }

    public function isLike($topic){
        if(app('session')->has('user_id') && $this->user->findUserById(app('session')->get('user_id'))){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $like = json_decode($user->like);
            $arr = $like->topics;
            if(in_array($topic, $arr)){
                //已经点赞过
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function isCollect($topic){
        if(app('session')->has('user_id')){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $collect = json_decode($user->collect);
            $arr = $collect->topics;
            if(in_array($topic, $arr)){
                //已经收藏过
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function collect($topic){
        $obj = $this->topic->find($topic);
        if($obj->user_id == app('session')->get('user_id')){
            return 3;
        }
        $user = $this->user->findUserById(app('session')->get('user_id'));
        $collect = json_decode($user->collect);
        $arr = $collect->topics;
        if(in_array($topic, $arr)){
            //已经收藏过，则取消收藏
            if( !is_null( ($key = array_search($topic,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->collect_num = $obj->collect_num<=0 ? 0: --$obj->collect_num;
        }else{
            array_push($arr, $topic);
            $obj->collect_num += 1;
        }
        $collect->topics = $arr;
        $user->collect = json_encode($collect);
        if($user->save() && $obj->save()){
            return 0;
        }else{
            return 2;
        }       
    }

    public function myTopic($page){
        $skip = ($page - 1) * config('app_config.page');
        $result = $this->topic->where('status','>=',0)->where('user_id',app('session')->get('user_id'))->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->get();

        if($result->count() > config('app_config.page')){
            $result->pop();
            $is_lastPage = false;
        }else{
            $is_lastPage = true;
        }

        foreach ($result as $key => $list) {
            $images = json_decode($list->images)->url;
            $list->main_img = count($images) ? $images[0] : "";
            $list->username = $list->user?($list->user->name ? $list->user->name : preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $list->user->mobile)):'未知';
            $list->head_img = $list->user?$list->user->head_img:'img/default_head.png';
            unset($list->images);
            unset($list->user);
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function latestTopic(){
        $result = $this->topic->has('user')->where('status',1)->orderBy('created_at','desc')->take(config('app_config.recommend_count'))->get();

        foreach ($result as $key => $list) {
            $images = json_decode($list->images)->url;
            $list->main_img = count($images) ? $images[0] : "";
            $list->username = $list->user->name ? $list->user->name : preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $list->user->mobile);
            $list->head_img = $list->user->head_img;
            unset($list->images);
        }
        return $result;
    }
}