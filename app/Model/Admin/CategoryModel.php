<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class CategoryModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','type','image','status'];

}