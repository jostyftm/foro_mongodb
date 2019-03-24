<?php 

namespace App\Models;





class Model implements \MongoDB\BSON\Serializable
{
    
    private $dbName = 'foro';

    private $clientDB;

    public function __construct()
    {
        $this->clientDB = new \MongoDB\Client("mongodb://localhost:27017");   
    }

    public function getConexion()
    {
        return $this->clientDB->{$this->dbName};
    }
    
    public function bsonSerialize()
    {

    }
}
