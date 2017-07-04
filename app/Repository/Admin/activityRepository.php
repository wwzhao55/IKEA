<?php
namespace App\Repository\Admin;

use App\Model\Admin\ActivityModel;

class activityRepository
{
    /** @var User 注入的User model */
    protected $activity;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(ActivityModel $activity)
    {
        $this->activity = $activity;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->activity->fill($info)->save();
    }

    public function update($id,$info){
        try{
            return $this->activity->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
        
    }

    public function delete($id){
        return $this->activity->where('id',$id)->delete();
    }

    public function info($page=0){
        return $this->activity->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
    }

    public function find($id){
        return $this->activity->where('id',$id)->first();
    }

    public function count(){
        return $this->activity->count();
    }
}