<?php
namespace App\Repository\Admin;

use App\Model\Admin\CarouselModel;

class carouselRepository
{
    /** @var User 注入的User model */
    protected $carousel;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(carouselModel $carousel)
    {
        $this->carousel = $carousel;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->carousel->fill($info)->save();
    }

    public function update($id,$info){       
        try{
            return $this->carousel->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
    }

    public function delete($id){
        return $this->carousel->where('id',$id)->delete();
    }

    public function info($page=0,$search=null){
        if($search==null){
            return $this->carousel->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }else{
            return $this->carousel->where($search)->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        }
    }

    public function find($id){
        return $this->carousel->where('id',$id)->first();
    }

    public function usedCount(){
        return $this->carousel->where('status',1)->count();
    }

    public function count($search){
        if($search==null){
            return $this->carousel->count();
        }else{
            return $this->carousel->where($search)->count();
        }
    }

}