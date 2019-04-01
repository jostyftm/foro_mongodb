<?php 
namespace App\Models;

use Carbon\Carbon;

/**
 * Clase Comentario
 * Representa los datos de un comnetario
 */
class Comment extends Model
{
    private $_id;

    private $_userId;

    private $_userName;

    private $_forumId;

    private $_body;

    private $_createdAt;

    // Nombre de la coleccion donde se guardan los registros
    private $_collectionName = 'comments';

    /**
     * Función que devuelve el id del commentario
     * @return \MongoDB\BSON\ObjectId
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Funcón que asigna el id del usuario que creo el comentario
     * @param \MongoDB\BSON\ObjectId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * Función que devuelve el id del usuario
     * @return \MongoDB\BSON\ObjectId
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Funcón que asigna el nombre del usuario quien comenta el foro
     * @param String
     */
    public function setUserName($name)
    {
        $this->_userName = $name;
    }

    /**
     * Funcón que devuelce el nombre del usuario quien comenta el foro
     * @return String
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * Funcón que asigna el id del foro
     * @param \MongoDB\BSON\ObjectId
     */
    public function setForumId($forumId)
    {
        $this->_forumId = $forumId;
    }

    /**
     * Función que devuelve el id del foro
     * @return \MongoDB\BSON\ObjectId
     */
    public function getForumId()
    {
        return $this->_forumId;
    }

    /**
     * Funcón que asigna el comentario
     * @param String
     */
    public function setBody($body)
    {
        $this->_body = $body;
    }

    /**
     * Funcón que devuelve el comentario
     * @param String
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Funcón que retorna la colección
     * @return \MongoDB\Client
     */
    public function getCollection()
    {
        return $this->getConexion()->{$this->_collectionName};
    }

    /**
     * Funcón que retorna todos los registros de la colección
     * @return Array
     */
    public function all()
    {
        // Inicializamos la variable que se va a retornar
        $forums = array();
        
        /** Obtenemos todos los registros de la coleción
         *  Esta función retorna un objeto MongoDB\Driver\Cursor para interactuar con los 
         *  registros
         */ 
        $cursor = $this->getCollection()->find();

        // Recorremos cada registro y lo almacenamos en la variable "$forums" 
        foreach($cursor as $key => $forum)
            array_push($forums, $forum);

        // Retornamos los datos
        return $forums;
    }
    
    /**
     * Función que busca commentarios de acuerdo a un campo y valor especificado
     * @param $field
     * @param $value
     * @return Array
     */
    public function find($field, $value)
    {
        $comments = array();

         // Llamamos a la función findOne y le pasamos los parametos
        $cursor = $this->getCollection()->find([$field => $value]);

        foreach($cursor as $key => $comment)
            array_push($comments, $comment);

        return $comments;
    }

    /**
     * Función que se encarga de guardar un registro en la coleción de comentarios
     * @param $_POST
     * @return Boolean
     */
    public function save()
    {

        // Llamamos a la collecion y ejecutamos el metodo "insertOne" para guardar y el resultado
        // se almacena en $result
        $result = $this->getCollection()->insertOne([
            'userId'        =>  $this->getUserId(),
            'userName'      =>  $this->getUserName(),
            'forumId'       =>  $this->getForumId(),
            'body'          =>  $this->getBody(),
            'created_at'    =>  Carbon::now()->setTimezone("America/Bogota")->toDateTimeString(),
        ]);
        
        // Si el registro se inserto retornamos "true" de lo contrario "false"
        if($result->getInsertedCount())
            return true;
        
        return false;
    }

    /**
     * Función que se encarga de eliminar un registro en la coleción de comentarios
     * @param String
     * @return Boolean
     */
    public function delete($commentId)
    {

        // Llamamos a la función "deleteOne" y le pasamos los parametos
        $result = $this->getCollection()->deleteOne([
            '_id' => new  \MongoDB\BSON\ObjectId($commentId)
        ]);
        
        // Si el registro se elimino retornamos "true" de lo contrario "false"
        if($result->getDeletedCount() > 0)
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
