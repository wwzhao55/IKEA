<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class KnowledgePicModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'knowledge_pic';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image','link','status'];

    

}