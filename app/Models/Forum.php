<?php 
namespace App\Models;

use Carbon\Carbon;


class Forum extends Model
{
    private $_id;

    private $_title;

    private $_slug;

    private $_description;

    private $_userId;

    private $_isOpen;

    private $_createdAt;

    private $_collectionName = 'forums';

    public function getId()
    {
        return $this->_id;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setSlug($slug)
    {
        $this->_slug = $slug;
    }

    public function getSlug()
    {
        return $this->_slug;
    }

    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setIsOpen($value)
    {
        $this->_isOpen = $value;
    }

    public function getIsOpen()
    {
        return $this->_isOpen;
    }

    public function setIsCreatedAt($date)
    {
        $this->_createdAt = $date;
    }

    public function getCreatedAt()
    {
        return $this->_createdAt;
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
            $this->_title = $result->title;
            $this->_slug = $result->slug;
            $this->_description = $result->description;
            $this->_userId = $result->user_id;
            $this->_isOpen = $result->is_open;
            $this->_createdAt = $result->created_at;
        }

        return $this;
    }

    public function save()
    {

        $result = $this->getCollection()->insertOne([
            'title'         =>  $this->getTitle(),
            'slug'          =>  $this->getSlug(),
            'description'   =>  $this->getDescription(),
            'user_id'       =>  $this->getUserId(),
            'is_open'       =>  $this->getIsOpen(),
            'created_at'    =>  Carbon::now()->toDateTimeString(),
        ]);

        if($result->getInsertedCount())
            return true;
        
        return false;
    }

    public function bsonSerialize()
    {
        return [
            'title'         =>  $this->getTitle(),
            'slug'          =>  $this->getSlug(),
            'description'   =>  $this->getDescription(),
            'user_id'       =>  $this->getUserId(),
            'is_open'       =>  $this->getIsOpen(),
            'created_at'    =>  $this->getCreatedAt(),
        ];
    }
}
