<?php 
namespace App\Controllers;

use App\Models\Forum;
use App\Models\User;
use App\Models\Comment;

class ForumController extends BaseController
{
    private $forum;

    public function __construct()
    {
        parent::__construct();
        
        $this->forum = new Forum();

    }
    public function index()
    {
        $forums = $this->forum->all();

        echo json_encode($forums);
    }

    public function create()
    {
        return $this->renderView('forum/new.twig', []);
    }

    public function store()
    {
        $this->forum->setTitle($_POST['title']);
        $this->forum->setSlug($this->slug($_POST['title']));
        $this->forum->setDescription($_POST['description']);
        $this->forum->setUserId($this->user->getId());
        $this->forum->setIsOpen(true);

        if($this->forum->save())
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

    public function show($forum)
    {
        $this->forum->find('_id' , new \MongoDB\BSON\ObjectId($forum));
        
        // $bson = \MongoDB\BSON\fromPHP($this->forum);
        // echo \MongoDB\BSON\toJSON($bson), "\n"; 
        
        // 
        $user = new User();
        $user->find('_id', $this->forum->getUserId());

        // 
        $comment = new Comment();
        $comments = $comment->all();

        return $this->renderView('forum/show.twig', [
            'forum'     => $this->forum,
            'userForum' =>  $user,
            'comments'  =>  $comments
        ]);
    }

    public function getComments($forum)
    {
        $comment = new Comment();

        $data = $comment->all();

        echo json_encode($data);
    }
}
