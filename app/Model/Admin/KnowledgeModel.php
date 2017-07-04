<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class KnowledgeModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'knowledge';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','category_id','main_img','images','content','status','collect_num','comment_num','like_num'];

    public function category_info()
    {
        return $this->belongsTo('App\Model\Admin\CategoryModel','category_id','id');
    }

}