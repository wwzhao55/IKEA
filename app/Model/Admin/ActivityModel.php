<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class ActivityModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','address','start_time','end_time','register_end_time','main_images','images1','content1','images2','content2','images3','content3','images4','content4','images5','content5','status','register_num','collect_num','comment_num'];

}