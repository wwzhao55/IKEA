<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class CouponModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coupons';
    protected $primaryKey = 'code';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','value','is_get'];

}