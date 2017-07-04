<?php
namespace App\Repository\Admin;

use App\Model\Admin\ActivityCommentModel;
use App\Model\Admin\KnowledgeCommentModel;
use App\Model\Admin\ProductCommentModel;
use App\Model\Admin\TopicCommentModel;
use App\Model\Admin\ActivityModel;
use App\Model\Admin\KnowledgeModel;
use App\Model\Admin\ProductModel;
use App\Model\App\TopicModel;
use App\User;


class checkRepository
{

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(
        ActivityCommentModel $activityComment,
        KnowledgeCommentModel $knowledgeComment,
        ProductCommentModel $productComment,
        TopicCommentModel $topicComment,
        ActivityModel $activity,
        KnowledgeModel $knowledge,
        ProductModel $product,
        TopicModel $topic,
        User $user
        )
    {
        $this->activityComment = $activityComment;
        $this->knowledgeComment = $knowledgeComment;
        $this->productComment = $productComment;
        $this->topicComment = $topicComment;
        $this->activity = $activity;
        $this->knowledge = $knowledge;
        $this->product = $product;
        $this->topic = $topic;
        $this->user = $user;
    }

    public function topicList($page=0,$search=null){
        if($search==null){
            $infos = $this->topic->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
            foreach ($infos as $info) {
                $info->category_name = $info->category_info->name;
            }
            return $infos;
        }else{
            $infos = $this->topic->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
            foreach ($infos as $info) {
                $info->category_name = $info->category_info->name;
            }
            return $infos;
        }
    }

    public function topicCount($search=null){
        if($search==null){
            return $this->topic->count();
        }else{
            return $this->topic->where($search)->count();
        }
    }

    public function checkTopic($id,$status){
        return $this->topic->where('id',$id)->update(['status'=>$status]);
    }

    public function getTopicUserId($topic_id){
        return $this->topic->where('id',$topic_id)->pluck('user_id');
    }

    public function shouldGetTopicCoupon($user_id){
        if(config('web.should_get_coupon_topic')===false){
            return false;
        }
        $count = $this->topic->where('status',1)->count();
        return $count===config('web.get_coupon_topic_count')?true:false;
    }

    public function topicFind($id){
        $info = $this->topic->where('id',$id)->first();
        $info->category_name = $info->category_info->name;
        return $info;
    }

    public function knowledgeComment($page=0,$search=null){
        if($search==null){
            return $this->knowledgeComment->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->knowledgeComment->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
    }

    public function activityComment($page=0,$search=null){
        if($search==null){
            return $this->activityComment->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->activityComment->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
    }

    public function productComment($page=0,$search=null){
        if($search==null){
            return $this->productComment->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->productComment->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
    }

    public function topicComment($page=0,$search=null){
        if($search==null){
            return $this->topicComment->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->topicComment->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
    }

    public function knowledgeCommentCount($search=null){
        if($search==null){
            return $this->knowledgeComment->count();
        }else{
            return $this->knowledgeComment->where($search)->count();
        }
    }

    public function activityCommentCount($search=null){
        if($search==null){
            return $this->activityComment->count();
        }else{
            return $this->activityComment->where($search)->count();
        }
    }

    public function productCommentCount($search=null){
        if($search==null){
            return $this->productComment->count();
        }else{
            return $this->productComment->where($search)->count();
        }
    }

    public function topicCommentCount($search=null){
        if($search==null){
            return $this->topicComment->count();
        }else{
            return $this->topicComment->where($search)->count();
        }
    }

    public function getTopicIdByComment($comment_id){
        return $this->topicComment->where('id',$comment_id)->pluck('article_id');
    }

    public function getProductIdByComment($comment_id){
        return $this->productComment->where('id',$comment_id)->pluck('article_id');
    }

    public function getActivityIdByComment($comment_id){
        return $this->activityComment->where('id',$comment_id)->pluck('article_id');
    }

    public function getKnowledgeIdByComment($comment_id){
        return $this->knowledgeComment->where('id',$comment_id)->pluck('article_id');
    }

    public function addTopicCommentCount($id,$count=1){
        return $this->topic->where('id',$id)->increment('comment_num',$count);
    }
    public function addProductCommentCount($id,$count=1){
        return $this->product->where('id',$id)->increment('comment_num',$count);
    }
    public function addActivityCommentCount($id,$count=1){
        return $this->activity->where('id',$id)->increment('comment_num',$count);
    }
    public function addKnowledgeCommentCount($id,$count=1){
        return $this->knowledge->where('id',$id)->increment('comment_num',$count);
    }

    public function decreaseTopicCommentCount($id){
        return $this->topic->where('id',$id)->decrement('comment_num');
    }
    public function decreaseProductCommentCount($id){
        return $this->product->where('id',$id)->decrement('comment_num');
    }
    public function decreaseActivityCommentCount($id){
        return $this->activity->where('id',$id)->decrement('comment_num');
    }
    public function decreaseKnowledgeCommentCount($id){
        return $this->knowledge->where('id',$id)->decrement('comment_num');
    }

    public function getTopicCommentStatus($id){
        return $this->topicComment->where('id',$id)->first()->status;
    }
    public function getProductCommentStatus($id){
        return $this->productComment->where('id',$id)->first()->status;
    }
    public function getActivityCommentStatus($id){
        return $this->activityComment->where('id',$id)->first()->status;
    }
    public function getKnowledgeCommentStatus($id){
        return $this->knowledgeComment->where('id',$id)->first()->status;
    }

    public function checkKnowledgeComment($id,$status){
        return $this->knowledgeComment->where('id',$id)->update(['status'=>$status]);
    }

    public function checkActivityComment($id,$status){
        return $this->activityComment->where('id',$id)->update(['status'=>$status]);
    }

    public function checkProductComment($id,$status){
        return $this->productComment->where('id',$id)->update(['status'=>$status]);
    }

    public function checkTopicComment($id,$status){
        return $this->topicComment->where('id',$id)->update(['status'=>$status]);
    }

    public function deleteActivityComment($id){
        return $this->activityComment->where('id',$id)->delete();
    }

    public function deleteProductComment($id){
        return $this->productComment->where('id',$id)->delete();
    }

    public function deleteKnowledgeComment($id){
        return $this->knowledgeComment->where('id',$id)->delete();
    }

    public function deleteTopicComment($id){
        return $this->topicComment->where('id',$id)->delete();
    }

}