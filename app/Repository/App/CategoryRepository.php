<?php
namespace App\Repository\App;

use App\Model\Admin\CategoryModel;

class CategoryRepository
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
    public function getAge(){
        return $this->category->where('type','年龄')->select('id','name','image')->get();
    }

    public function getRoom(){
        return $this->category->where('type','生活空间')->select('id','name','image')->get();
    }

    public function getTopic(){
        return $this->category->where('type','话题')->select('id','name')->get();
    }

    public function getCategoryById($id){
        return $this->category->find($id)->name;
    }
}