<?php
namespace App\Repository\App;

use App\Model\Admin\KnowledgePicModel;

class KnowledgePicRepository
{
    /** @var User 注入的User model */
    protected $knowledgePic;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(KnowledgePicModel $knowledgePic)
    {
        $this->knowledgePic = $knowledgePic;
    }

    public function getPic(){
        return $this->knowledgePic->where('status',1)->select('id','image','link')->get();
    }

}