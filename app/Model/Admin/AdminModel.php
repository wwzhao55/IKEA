<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class AdminModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account','password','status'];

}