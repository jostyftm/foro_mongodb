<?php 
namespace App\Models;

use Carbon\Carbon;



class Comment extends Model
{
    private $_id;

    private $_userId;

    private $_forumId;

    private $_body;

    private $_createdAt;

    private $_collectionName = 'comments';

    public function getId()
    {
        return $this->_id;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setForumId($forumId)
    {
        $this->_forumId = $forumId;
    }

    public function getForumId()
    {
        return $this->_forumId;
    }

    public function setBody($body)
    {
        $this->_body = $body;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function getCollection()
    {
        return $this->getConexion()->{$this->_collectionName};
    }

    public function all()
    {
        $forums = array();
        
        $cursor = $this->getCollection()->find();

        foreach($cursor as $key => $forum)
            array_push($forums, $forum);

        return $forums;
    }
    
    public function find($field, $value)
    {
        $result = $this->getCollection()->findOne([$field => $value]);

        if($result)
        {
            $this->_id = $result->_id;
            $this->_userId = $result->userId;
            $this->_forumId = $result->forumId;
            $this->_body = $result->body;
            $this->_createdAt = $result->created_at;
        }

        return $this;
    }

    public function save()
    {

        $result = $this->getCollection()->insertOne([
            'userId'        =>  $this->getUserId(),
            'forumId'       =>  $this->getForumId(),
            'body'          =>  $this->getBody(),
            'created_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        if($result->getInsertedCount())
            return true;
        
        return false;
    }

    public function bsonSerialize()
    {
        return [
            'userId'        =>  $this->getUserId(),
            'forumId'       =>  $this->getForumId(),
            'body'          =>  $this->getBody(),
            'created_at'    =>  Carbon::now(),
        ];
    }
}
