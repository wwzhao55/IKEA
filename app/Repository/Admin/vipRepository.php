<?php
namespace App\Repository\Admin;

use App\User;

class vipRepository
{
    /** @var User 注入的User model */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */

    public function info($page=0){
        
        return $this->user->orderBy('created_at','DESC')->select('mobile','created_at')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        
    }

    public function getExportUser(){
        $users = $this->user->select('mobile','created_at')->get()->toArray();
        foreach ($users as &$user) {
            $user['created_at'] = date('Y-m-d h:i:s',$user['created_at']);
        }
        $title = array(
            array('手机','注册时间')
            );
        return array_merge($title,$users);
    }

    public function count(){

        return $this->user->count();

    }
}