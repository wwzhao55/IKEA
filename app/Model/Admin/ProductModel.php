<?php namespace App\Model\Admin;
use App\Model\BaseModel;
/**
* 
*/
class ProductModel extends BaseModel
{
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','room','age','price','item_num','main_img','color','size','status','collect_num','comment_num'];

    public function age_info()
    {
        return $this->belongsTo('App\Model\Admin\CategoryModel','age','id');
    }

    public function room_info()
    {
        return $this->belongsTo('App\Model\Admin\CategoryModel','room','id');
    }

}