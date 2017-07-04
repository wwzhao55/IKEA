<?php
namespace App\Repository\App;

use App\Model\Admin\KnowledgeModel,App\User;

class KnowledgeRepository
{
    /** @var Knowledge 注入的knowledge model */
    protected $knowledge;

    /**
     * KnowledgeRepository constructor.
     * @param Knowledge $knowledge
     */
    public function __construct(KnowledgeModel $knowledge, User $user)
    {
        $this->knowledge = $knowledge;
        $this->user = $user;
    }

    public function getList($page,$type=0){
        $is_lastPage = true;
        if($type == 0){
            //精选
            $result = $this->knowledge->orderBy('like_num','desc')->orderBy('created_at','desc')->take(config('app_config.page'))->select('id','category_id','title','main_img','content','like_num','comment_num','created_at')->get();
        }else{
            $skip = ($page - 1) * config('app_config.page');
            $result = $this->knowledge->where('category_id',$type)->orderBy('like_num','desc')->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->select('id','category_id','title','main_img','content','like_num','comment_num','created_at')->get();
            if($result->count() > config('app_config.page')){
                $result->pop();
                $is_lastPage = false;
            }
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);
    }

    public function detail($id){
        $knowledge = $this->knowledge->find($id);
        $knowledge->images = json_decode($knowledge->images,true);
        $knowledge->is_like = $this->isLike($id);
        $knowledge->is_collect = $this->isCollect($id);
        return $knowledge;
    }

    public function like($knowledge){
        $obj = $this->knowledge->find($knowledge);
        $user = $this->user->findUserById(app('session')->get('user_id'));
        $like = json_decode($user->like);
        $arr = $like->knowledge;
        if(in_array($knowledge, $arr)){
            //已经点赞过，则取消点赞
            if( !is_null( ($key = array_search($knowledge,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->like_num = $obj->like_num<=0 ? 0: --$obj->like_num;
        }else{
            array_push($arr, $knowledge);
            $obj->like_num += 1;
        }
        $like->knowledge = $arr;
        $user->like = json_encode($like);
        return $user->save() && $obj->save();       
    }

    public function isLike($id){
        if(app('session')->has('user_id') && $this->user->findUserById(app('session')->get('user_id'))){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $like = json_decode($user->like);
            $arr = $like->knowledge;
            if(in_array($id, $arr)){
                //已经点赞过
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function isCollect($id){
        if(app('session')->has('user_id') && $this->user->findUserById(app('session')->get('user_id'))){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $collect = json_decode($user->collect);
            $arr = $collect->knowledge;
            if(in_array($id, $arr)){
                //已经点赞过
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function collect($knowledge){
        $obj = $this->knowledge->find($knowledge);

        $user = $this->user->findUserById(app('session')->get('user_id'));
        $collect = json_decode($user->collect);
        $arr = $collect->knowledge;
        if(in_array($knowledge, $arr)){
            //已经收藏过，则取消收藏
            if( !is_null( ($key = array_search($knowledge,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->collect_num = $obj->collect_num<=0 ? 0: --$obj->collect_num;
        }else{
            array_push($arr, $knowledge);
            $obj->collect_num += 1;
        }
        $collect->knowledge = $arr;
        $user->collect = json_encode($collect);
        if($user->save() && $obj->save()){
            return 0;
        }else{
            return 2;
        }       
    }
}