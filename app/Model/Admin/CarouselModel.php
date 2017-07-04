<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class CarouselModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'carousel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image','link','status'];

}