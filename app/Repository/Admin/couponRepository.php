<?php
namespace App\Repository\Admin;

use App\Model\Admin\CouponModel;
use App\User;

class couponRepository
{
    /** @var User 注入的User model */
    protected $coupon;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(CouponModel $coupon,User $user)
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function getUserCoupon($user_id,CouponModel $coupon){
        $user = $this->user->where('id',$user_id)->first();
        $coupon_array =  json_decode($user->coupon);
        array_push($coupon_array->code,['code'=>$coupon->code,'value'=>$coupon->value]);
        $user->coupon = json_encode($coupon_array);
        $user->save();
        $coupon->is_get = 1;
        $coupon->save();
    }

    public function getOneUnUsed(){
        return $this->coupon->where('is_get',0)->first();
    }

    public function add($info){
       return $this->coupon->fill($info)->save();
    }

    public function multiAdd($array){
        try{
            return $this->coupon->insert($array);
        }catch(\Exception $e){
            return false;
        }        
    }

    public function info($page=0,$search=null){
        if($search){
            return $this->coupon->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->coupon->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
        
    }

    public function count($search){
        if($search){
            return $this->coupon->where($search)->count();
        }else{
            return $this->coupon->count();
        }
    }
}