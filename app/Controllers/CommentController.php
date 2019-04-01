<?php 
namespace App\Controllers;

use App\Models\Comment;


class CommentController extends BaseController
{
    private $comment;

    public function __construct()
    {
        parent::__construct();
        
        $this->comment = new Comment();
    }
    
    public function index()
    {

    }

    public function store()
    {
        $this->comment->setBody($_POST['comment']);
        $this->comment->setForumId(
            new \MongoDB\BSON\ObjectId($_POST['forum_id'])
        );
        $this->comment->setUserId($this->user->getId());
        $this->comment->setUserName($this->user->getName());

        if($this->comment->save()){
            return $this->sendResponse()([
                'success'   =>  true,
                'message'   =>  'Registro exitoso'
            ], 200);
        }else{
            return $this->sendResponse([
                'success'   =>  false,
                'message'     =>  'Los sentimos ocurrio un error vuelve a intertarlo'  
            ], 400);
        }
    }

    public function delete($comment)
    {
        if($this->comment->delete($comment)){
            return $this->sendResponse([], 204);
        }
        else{
            return $this->sendResponse([
                'message' => 'Ocurio un error'
            ], 400);
        }
    }
}
