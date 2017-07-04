<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class TopicCommentModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comment_topic';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['article_id','user_id','content','like_num','status'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    

}