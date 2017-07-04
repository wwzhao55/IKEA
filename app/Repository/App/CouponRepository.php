<?php
namespace App\Repository\App;

use App\Model\Admin\CouponModel, App\User;

class CouponRepository
{

    protected $coupon;

    public function __construct(CouponModel $coupon, User $user)
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }

    public function myCoupon($page){
    	$is_lastPage = true;

    	$user = $this->user->findUserById(app('session')->get('user_id'));
        $coupon = json_decode($user->coupon);
    	$data = $coupon->code;
        $rawData = json_encode($data);
        foreach ($data as $key => $val) {
            $val->is_read = true;
        }
        $coupon->code = $data;
        $user->coupon = json_encode($coupon);
        $user->save();
    	
        $data = json_decode($rawData);
    	return compact('data','is_lastPage');
    }
}