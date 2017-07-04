<?php
namespace App\Http\Controllers\Admin\Check;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repository\Admin\checkRepository;

class CommentCheckController extends BaseController
{
    private $check;
    function __construct(checkRepository $check){
        $this->check = $check;
        $this->middleware('admin_auth');
    }

    public function getIndex(){
                
        return view("admin.check.comment.index");

    }

    public function postProduct($page=0,Request $request){
        $has_status = $request->has('status');
        if($has_status){
            $search = array('status'=>$request->input('status'));
        }else{
            $search = null;
        }
        $lists = $this->check->productComment($page,$search);
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->check->productCommentCount($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    public function postProductStatus(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_product,id',
            'status'=>'required|in:-1,1',
            ]);
        $id = $request->input('id');
        $status = $request->input('status');
        $old_status = $this->check->getProductCommentStatus($id);
        $result = $this->check->checkProductComment($id,$status);

        if($result){
            if($status>0){
                $artical_id = $this->check->getProductIdByComment($id);
                if($old_status<=0){
                    $this->check->addProductCommentCount($artical_id,1);
                }               
            }            
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postTopic($page=0,Request $request){
        $has_status = $request->has('status');
        if($has_status){
            $search = array('status'=>$request->input('status'));
        }else{
            $search = null;
        }
        $lists = $this->check->topicComment($page,$search);
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->check->topicCommentCount($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    public function postTopicStatus(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_topic,id',
            'status'=>'required|in:-1,1',
            ]);
        $id = $request->input('id');
        $status = $request->input('status');
        $old_status = $this->check->getTopicCommentStatus($id);
        $result = $this->check->checkTopicComment($id,$status);
        if($result){
            if($status>0){
                $artical_id = $this->check->getTopicIdByComment($id);   
                if($old_status<=0){
                    $this->check->addTopicCommentCount($artical_id,1); 
                }             
                               
            } 
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postKnowledge($page=0,Request $request){
        $has_status = $request->has('status');
        if($has_status){
            $search = array('status'=>$request->input('status'));
        }else{
            $search = null;
        }
        $lists = $this->check->knowledgeComment($page,$search);
        if($lists){

            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->check->knowledgeCommentCount($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'get fail',
                ));
        }
    }

    public function postKnowledgeStatus(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_knowledge,id',
            'status'=>'required|in:-1,1',
            ]);
        $id = $request->input('id');
        $status = $request->input('status');
        $old_status = $this->check->getKnowledgeCommentStatus($id);
        $result = $this->check->checkKnowledgeComment($id,$status);
        if($result){
            if($status>0){
                $artical_id = $this->check->getKnowledgeIdByComment($id);
                if($old_status<=0){
                    $this->check->addKnowledgeCommentCount($artical_id,1);
                }                
            } 
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postActivity($page=0,Request $request){
        $has_status = $request->has('status');
        if($has_status){
            $search = array('status'=>$request->input('status'));
        }else{
            $search = null;
        }
        $lists = $this->check->activityComment($page,$search);
        if($lists){
            return response()->json(array(
                'status'=>1,
                'message'=>'get lists success',
                'data'=>$lists,
                'count'=>$this->check->activityCommentCount($search),
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>' fail',
                ));
        }
    }

    public function postActivityStatus(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_activity,id',
            'status'=>'required|in:-1,1',
            ]);
        $id = $request->input('id');
        $old_status = $this->check->getActivityCommentStatus($id);
        $status = $request->input('status');
        $result = $this->check->checkActivityComment($id,$status);
        if($result){
            if($status>0){
                $artical_id = $this->check->getActivityIdByComment($id);
                if($old_status<=0){
                    $this->check->addActivityCommentCount($artical_id,1);
                }
            } 
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postProductDelete(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_product,id',
            ]);
        $id = $request->input('id');
        $old_status = $this->check->getProductCommentStatus($id);
        $artical_id = $this->check->getProductIdByComment($id);
        $result = $this->check->deleteProductComment($id);
        if($result){
            if($old_status==1){
                
                $this->check->decreaseProductCommentCount($artical_id);
            }
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postKnowledgeDelete(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_knowledge,id',
            ]);
        $id = $request->input('id');
        $old_status = $this->check->getKnowledgeCommentStatus($id);
        $artical_id = $this->check->getKnowledgeIdByComment($id);
        $result = $this->check->deleteKnowledgeComment($id);
        if($result){
            if($old_status==1){
                
                $this->check->decreaseKnowledgeCommentCount($artical_id);
            }
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postTopicDelete(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_topic,id',
            ]);
        $id = $request->input('id');
        $old_status = $this->check->getTopicCommentStatus($id);
        $artical_id = $this->check->getTopicIdByComment($id);
        $result = $this->check->deleteTopicComment($id);
        if($result){
            if($old_status==1){
                
                $this->check->decreaseTopicCommentCount($artical_id);
            }
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

    public function postActivityDelete(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:comment_activity,id',
            ]);
        $id = $request->input('id');
        $old_status = $this->check->getActivityCommentStatus($id);
        $artical_id = $this->check->getActivityIdByComment($id);
        $result = $this->check->deleteActivityComment($id);
        if($result){
            if($old_status==1){
                
                $this->check->decreaseActivityCommentCount($artical_id);
            }
            return response()->json(array(
                'status'=>1,
                'message'=>'success',
            ));
        }else{
            return response()->json(array(
                'status'=>0,
                'message'=>'fail',
                ));
        }
    }

   
}