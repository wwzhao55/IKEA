<?php
namespace App\Repository\Admin;

use App\Model\Admin\KnowledgePicModel;

class knowledgePicRepository
{
    /** @var User 注入的User model */
    protected $knowledgePic;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(knowledgePicModel $knowledgePic)
    {
        $this->knowledgePic = $knowledgePic;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->knowledgePic->fill($info)->save();
    }

    public function update($id,$info){        
        try{
            return $this->knowledgePic->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
    }

    public function delete($id){
        return $this->knowledgePic->where('id',$id)->delete();
    }

    public function info($page=0,$search=null){
        if($search==null){
            return $this->knowledgePic->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->knowledgePic->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
    }

    public function find($id){
        return $this->knowledgePic->where('id',$id)->first();
    }

    public function setAllForbid(){
        return $this->knowledgePic->where('status','!=',0)->update(['status'=>0]);
    }

    public function getUsingCount(){
        return $this->knowledgePic->where('status',1)->count();
    }

    public function count($search){
        if($search==null){
            return $this->knowledgePic->count();
        }else{
            return $this->knowledgePic->where($search)->count();
        }
    }

}