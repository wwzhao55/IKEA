<?php 
namespace App\Model\App;
use App\Model\BaseModel;
/**
* 
*/
class ActivityUserModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['activity_id','username','mobile'];

}