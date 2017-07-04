<?php

namespace App;

use App\Model\BaseModel;

class User extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'head_img', ',mobile', 'collect', 'like', 'like_comment', 'coupon', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function findUserById($id){
        $self = new Self;
        return $self->where('id',$id)->first();
    }
}
