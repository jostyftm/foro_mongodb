<?php 
namespace App\Models;

/**
 * Clase Model
 * Esta clase contiene los datos de las conexion a la base de datos
 * Ademas esta clase implemenmta la interfaz \MongoDB\BSON\Serializable para serializar datos
 */
class Model implements \MongoDB\BSON\Serializable
{
    
    private $dbName = 'foro';

    private $clientDB;

    /**
     * Constructor
     * Aqui se inicializa el objeto cliente para la conexion a la base de datos
     */
    public function __construct()
    {
        $this->clientDB = new \MongoDB\Client("mongodb://localhost:27017");   
    }

    /**
     * Función que devuelve la conexion
     * @return \MongoDB\Client
     */
    public function getConexion()
    {
        return $this->clientDB->{$this->dbName};
    }
    
    public function bsonSerialize()
    {

    }
}
