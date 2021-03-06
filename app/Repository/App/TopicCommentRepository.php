<?php
namespace App\Repository\App;

use App\Model\Admin\TopicCommentModel, App\Model\App\TopicModel, App\User;

class TopicCommentRepository
{

    protected $comment;

    public function __construct(TopicCommentModel $comment, TopicModel $topic, User $user)
    {
        $this->comment = $comment;
        $this->topic = $topic;
        $this->user = $user;
    }

    public function getComments($topic_id, $page){
    	$skip = ($page - 1) * config('app_config.page');
    	$result = $this->comment->has('user')->where('article_id',$topic_id)->where('status',1)->orderBy('created_at','desc')->skip($skip)->take(config('app_config.page')+1)->get();
    	if($result->count() > config('app_config.page')){
            $result->pop();
            $is_lastPage = false;
        }else{
            $is_lastPage = true;
        }     

        foreach ($result as $key => $list) {
        	$list->username = $list->user->name ? $list->user->name : preg_replace('/(\d{3})\d{5}(\d{3})/', '$1*****$2', $list->user->mobile);
        	$list->head_img = $list->user->head_img;
            $list->is_like = $this->isLike($list->id); 
            unset($list->user);
        }
        return array('data'=>$result,'is_lastPage'=>$is_lastPage);       
    }

    public function sendComment($request){
        $topic = $this->topic->find($request['article']);
        if(!$topic){
            return 1;
        }
    	$data['user_id'] = app('session')->get('user_id');
    	$data['article_id'] = $request['article'];
    	$data['content'] = $request['comment'];
    	
        if($this->comment->fill($data)->save()){
            return 0;
        }else{
            return 2;
        }
    }

    public function likeComment($topic, $comment){
        $obj = $this->comment->find($comment);
        if(!$obj){
            return 1;
        }
        $user = $this->user->findUserById(app('session')->get('user_id'));
        $like = json_decode($user->like_comment);
        $arr = $like->topics;
        if(in_array($comment, $arr)){
            //已经点赞过，则取消点赞
            if( !is_null( ($key = array_search($comment,$arr)) ) ){
                array_splice($arr, $key,1);
            }
            $obj->like_num = $obj->like_num<=0 ? 0: --$obj->like_num;
        }else{
            array_push($arr, $comment);
            $obj->like_num += 1;
        }
        $like->topics = $arr;
        $user->like_comment = json_encode($like);
        if($user->save() && $obj->save()){
            return 0;
        }else{
            return 2;
        }       
    }

    public function isLike($id){
        if(app('session')->has('user_id') && $this->user->findUserById(app('session')->get('user_id')) ){
            $user = $this->user->findUserById(app('session')->get('user_id'));
            $like = json_decode($user->like_comment);
            $arr = $like->topics;
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
}