<?php 

namespace App\Models;

use Carbon\Carbon;


class User extends Model
{
    private $_id;

    private $_name;
    
    private $_email;

    private $_password;

    protected $_collectionName = 'users';

    public function getId()
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    private function getCollection()
    {
        return $this->getConexion()->{$this->_collectionName};
    }

    public function find($field, $value)
    {
        $result = $this->getCollection()->findOne([$field => $value]);

        if($result)
        {
            $this->_id = $result->_id;
            $this->_name = $result->name;
            $this->_email = $result->email;
            $this->_password = $result->password;
        }

        return $this;
    }

    public function save()
    {
        $result = $this->getCollection()->insertOne([
            'name'      =>  $_POST['name'],
            'email'     =>  $_POST['email'],
            'password'  =>  password_hash($_POST['password'], PASSWORD_DEFAULT),
            'creatad_ar'=>  Carbon::now()->toDateTimeString(),
        ]);

        if($result->getInsertedCount())
            return true;
        
        return false;
    }
}
