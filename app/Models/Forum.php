<?php 
namespace App\Models;

use Carbon\Carbon;

/**
 * Clase Foro
 * representa los datos de un foro
 */
class Forum extends Model
{
    private $_id;

    private $_title;

    private $_description;

    private $_userId;

    private $_isOpen;

    private $_createdAt;

    // Nombre de la coleccion donde se guardan los registros
    private $_collectionName = 'forums';

    /**
     * Función que devuelve el id del foro
     * @return \MongoDB\BSON\ObjectId
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Funcón que asigna un titulo al foro
     * @param String
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function getTitle()
    {
        return $this->_title;
    }


    /**
     * Funcón que asigna la descripción del foro
     * @param String
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Funcón que asigna el id del usuario que creo el foro
     * @param \MongoDB\BSON\ObjectId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * Función que devuelve el id del usuario que creo el foro
     * @return \MongoDB\BSON\ObjectId
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Funcón que asigna si el foro esta abierto no
     * @param Boolean
     */
    public function setIsOpen($value)
    {
        $this->_isOpen = $value;
    }

    public function getIsOpen()
    {
        return $this->_isOpen;
    }

    /**
     * Funcón que asigna la fecha de creación del foro
     * @param String
     */
    public function setIsCreatedAt($date)
    {
        $this->_createdAt = $date;
    }

    public function getCreatedAt()
    {
        return $this->_createdAt;
    }

    /**
     * Funcón que retorna la colección
     * @return \MongoDB\Client
     */
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
    
    /**
     * Función que busca un foro de acuerdo a un campo y valor especificado
     * @param $field
     * @param $value
     * @return App\Models\Forum
     */
    public function find($field, $value)
    {
        $result = null;
        
        if($field === '_id'){
            $result = $this->getCollection()->findOne([
                $field => new \MongoDB\BSON\ObjectId($value)
            ]);
        }else{

            // Llamamos a la función findOne y le pasamos los parametos
            $result = $this->getCollection()->findOne([$field => $value]);
        }

        // Si hay resultados asignamos los valores a los atributos de la clase
        if($result)
        {
            $this->_id = $result->_id;
            $this->_title = $result->title;
            $this->_description = $result->description;
            $this->_userId = $result->user_id;
            $this->_isOpen = $result->is_open;
            $this->_createdAt = $result->created_at;
        }

        // Retornamos la clase
        return $this;
    }

    /**
     * Función que se encarga de guardar un registro en la coleción de foros
     * @param $_POST
     * @return Boolean
     */
    public function save()
    {

        // Llamamos a la collecion y ejecutamos el metodo "insertOne" para guardar y el resultado
        // se almacena en $result
        $result = $this->getCollection()->insertOne([
            'title'         =>  $this->getTitle(),
            'description'   =>  $this->getDescription(),
            'user_id'       =>  $this->getUserId(),
            'is_open'       =>  $this->getIsOpen(),
            'created_at'    =>  Carbon::now()->setTimezone("America/Bogota")->toDateTimeString(),
        ]);
        
        // Si el registro se inserto retornamos "true" de lo contrario "false"
        if($result->getInsertedCount())
            return true;
        
        return false;
    }

    /**
     * Función que se encarga de actualizar un registro en la coleción de foros
     * @return Boolean
     */
    public function update()
    {
        $result = $this->getCollection()->updateOne(
            ['_id' => $this->getId()],
            [ '$set' => [ 
                'title'         =>  $this->getTitle(),
                'description'   =>  $this->getDescription(),
                'user_id'       =>  $this->getUserId(),
                'is_open'       =>  $this->getIsOpen(),
                ]
            ]
        );
        
        // Si el registro se inserto retornamos "true" de lo contrario "false"
        if($result->getModifiedCount())
            return true;
        
        return false;
    }


    public function bsonSerialize()
    {
        return [
            'id'            =>  $this->getId(),
            'title'         =>  $this->getTitle(),
            'description'   =>  $this->getDescription(),
            'user_id'       =>  $this->getUserId(),
            'is_open'       =>  $this->getIsOpen(),
            'created_at'    =>  $this->getCreatedAt(),
        ];
    }
}
