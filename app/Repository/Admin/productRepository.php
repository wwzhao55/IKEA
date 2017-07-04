<?php
namespace App\Repository\Admin;

use App\Model\Admin\ProductModel;

class productRepository
{
    /** @var User 注入的User model */
    protected $product;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(ProductModel $product)
    {
        $this->product = $product;
    }

    /**
     * 
     * @param integer $age
     * @return Collection
     */
    public function add($info){
       return $this->product->fill($info)->save();
    }

    public function update($id,$info){
        try{
            return $this->product->where('id',$id)->update($info);
        }catch(\Exception $e){
            return false;
        }
       
    }

    public function delete($id){
        return $this->product->where('id',$id)->delete();
    }

    public function info($page=0){
        $infos = $this->product->orderBy('created_at','DESC')->skip(config('page.page_count')*$page)->take(config('page.page_count'))->get();
        foreach ($infos as $info) {
            $info->age_name = $info->age_info->name;
            $info->romm_name = $info->room_info->name;
        }
        return $infos;
    }

    public function find($id){
        $info = $this->product->where('id',$id)->first();
        $info->age_name = $info->age_info->name;
        $info->romm_name = $info->room_info->name;
        return $info;
    }
    
    public function count(){
        return $this->product->count();
    }
}