<?php
namespace App\Repository\Admin;

use App\Model\Admin\AdminModel;

class adminRepository
{
    /** @var User 注入的User model */
    protected $admin;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(AdminModel $admin)
    {
        $this->admin = $admin;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->admin->fill($info)->save();
    }

    public function update($id,$info){
        try{
            return $this->admin->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
        
    }

    public function delete($id){
        return $this->admin->where('id',$id)->delete();
    }

    public function info($page=0){
        return $this->admin->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
    }

    public function find($account){
        return $this->admin->where('account',$account)->first();
    }

    public function count(){
        return $this->admin->count();
    }

    public function updateSessionId($admin_id){
        $this->update($admin_id,['session_id'=>app('session')->getId()]);
    }
}