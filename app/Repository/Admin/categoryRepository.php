<?php
namespace App\Repository\Admin;

use App\Model\Admin\CategoryModel;

class categoryRepository
{
    /** @var User 注入的User model */
    protected $category;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(CategoryModel $category)
    {
        $this->category = $category;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->category->fill($info)->save();
    }

    public function update($id,$info){
        try{
            return $this->category->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
        
    }

    public function delete($id){
        return $this->category->where('id',$id)->delete();
    }

    public function info($type,$page=0,$all=0){
        if($all==0){
            return $this->category->where('type',$type)->orderBy('id')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
         }else{
            return $this->category->where('type',$type)->orderBy('id')->get();
         }
       
    }

    public function hasName($type,$name){
        return $this->category->where('type',$type)->where('name',$name)->count();
    }

    public function getType($id){
        return $this->category->where('id',$id)->pluck('type');
    }

    public function find($type){
        return $this->category->where('type',$type)->get();
    }

    public function count($type){
        return $this->category->where('type',$type)->count();
    }
}