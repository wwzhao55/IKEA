<?php 
namespace App\Model\App;
use App\Model\BaseModel;
/**
* 
*/
class TopicModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','user_id','category_id','images','content','status','collect_num','like_num','comment_num'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function category_info()
    {
        return $this->belongsTo('App\Model\Admin\CategoryModel','category_id','id');
    }

}