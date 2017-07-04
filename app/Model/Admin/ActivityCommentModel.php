<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class ActivityCommentModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comment_activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['article_id','user_id','content','like_num','status'];

}