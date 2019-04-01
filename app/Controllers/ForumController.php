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
        
        // 
        $user = new User();
        $user->find('_id', $this->forum->getUserId());

        // 
        $comment = new Comment();
        $comments = $comment->find('forumId', $this->forum->getId());


        return $this->renderView('forum/show.twig', [
            'forum'     => $this->forum,
            'userForum' =>  $user,
            'comments'  =>  $comments
        ]);
    }

    public function edit($forum)
    {
        $this->forum->find('_id' , new \MongoDB\BSON\ObjectId($forum));

        return $this->renderView('forum/edit.twig', [
            'forum' =>  $this->forum
        ]);
    }

    public function update($forum)
    {

        $this->forum->find('_id' , new \MongoDB\BSON\ObjectId($forum));

        $forumOpen = ($_POST['isOpen'] == 'true') ? true : false;

        $this->forum->setTitle($_POST['title']);
        $this->forum->setSlug($this->slug($_POST['title']));
        $this->forum->setDescription($_POST['description']);
        $this->forum->setIsOpen($forumOpen);

        if($this->forum->update())
        {
            http_response_code(200);

            return json_encode([
                'success'   =>  true,
                'message'   =>  'Registro exitoso'
            ]);
        }else{

            http_response_code(500);

            return json_encode([
                'success'     =>  false,
                'message'     =>  'Los sentimos ocurrio un error vuelve a intertarlo'  
            ]);
        }
    }
}
