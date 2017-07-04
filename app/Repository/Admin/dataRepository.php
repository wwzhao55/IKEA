<?php
namespace App\Repository\Admin;

use App\Model\App\TopicModel;
use App\Model\Admin\KnowledgeCommentModel;
use App\Model\Admin\TopicCommentModel;
use App\User;

class dataRepository
{
    /** @var User 注入的User model */

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(
        KnowledgeCommentModel $knowledgeComment,
        TopicModel $topic,
        User $user,
        TopicCommentModel $topicComment
        )
    {
        $this->knowledgeComment = $knowledgeComment;
        $this->topic = $topic;
        $this->topicComment = $topicComment;
        $this->user = $user;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */

    public function data($start,$end){
        $topic_array = [];
        $knowledgeComment_array = [];
        $topicComment_array = [];
        $user_array = [];

        $one_day_time = 24*60*60;
        $today_begin = $start;
        $today_end = $start+$one_day_time;

        while($today_begin<$end){
            $user_register_count = $this->user->whereBetween('created_at',[$today_begin,$today_end])->count();
            $topic_count = $this->topic->whereBetween('created_at',[$today_begin,$today_end])->count();
            $topic_comment_count = $this->topicComment->whereBetween('created_at',[$today_begin,$today_end])->count();
            $knowledge_comment_count = $this->knowledgeComment->whereBetween('created_at',[$today_begin,$today_end])->count();

            array_push($topic_array,['count'=>$topic_count,'time'=>$today_begin]);
            array_push($knowledgeComment_array,['count'=>$knowledge_comment_count,'time'=>$today_begin]);
            array_push($topicComment_array,['count'=>$topic_comment_count,'time'=>$today_begin]);
            array_push($user_array,['count'=>$user_register_count,'time'=>$today_begin]);

            $today_begin+=$one_day_time;
            $today_end+=$one_day_time;

        }

        return array(
                'user_array'=>$user_array,
                'knowledgeComment_array'=>$knowledgeComment_array,
                'topicComment_array'=>$topicComment_array,
                'topic_array'=>$topic_array
            );
    }

    public function get_the_first_user_register_time(){
        return $this->user->min('created_at');
    }
    
}