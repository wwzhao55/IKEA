<?php
namespace App\Repository\Admin;

use App\Model\Admin\KnowledgeModel;

class knowledgeRepository
{
    /** @var User 注入的User model */
    protected $knowledge;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(KnowledgeModel $knowledge)
    {
        $this->knowledge = $knowledge;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->knowledge->fill($info)->save();
    }

    public function update($id,$info){
        try{
            return $this->knowledge->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
        
    }

    public function delete($id){
        return $this->knowledge->where('id',$id)->delete();
    }

    public function info($page=0){
        $infos = $this->knowledge->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        foreach ($infos as $info) {
            $info->category_name = $info->category_info->name;
        }
        
        return $infos;
    }

    public function find($id){
        $info = $this->knowledge->where('id',$id)->first();
        $info->category_name = $info->category_info->name;
        return $info;
    }

    public function count(){
        return $this->knowledge->count();
    }

}