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

        if($this->comment->save())
        {
            return json_encode([
                'success'   =>  true,
                'message'   =>  'Registro exitoso'
            ]);
        }else{
            return json_encode([
                'success'   =>  false,
                'message'     =>  'Los sentimos ocurrio un error vuelve a intertarlo'  
            ]);
        }
    }
}
