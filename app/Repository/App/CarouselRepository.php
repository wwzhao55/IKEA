<?php
namespace App\Repository\App;

use App\Model\Admin\CarouselModel;

class CarouselRepository
{
    /** @var User 注入的User model */
    protected $carousel;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(CarouselModel $carousel)
    {
        $this->carousel = $carousel;
    }

    public function  getList(){
        return $this->carousel->where('status',1)->select('id','link','image')->get();
    }

}