<?php 
namespace App\Models;

use Carbon\Carbon;

/**
 * Clase user
 * clase que representa los datos de un usuario
 */
class User extends Model
{
    private $_id;

    private $_name;
    
    private $_email;

    private $_password;

    // Nombre de la coleccion donde se guardan los registros
    protected $_collectionName = 'users';

    /**
     * Función que devuelve el id del usuario
     * @return \MongoDB\BSON\ObjectId
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Funcón que asigna un nombre a la clase
     * @param String
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Funcón que asigna un email a la clase
     * @param String
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Funcón que asigna una contraseña a la clase
     * @param String
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Funcón que retorna el nombre de la clase
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Funcón que retorna el email de la clase
     * @return String
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Funcón que retorna la contraseña de la clase
     * @return String
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Funcón que retorna la colección
     * @return \MongoDB\Client
     */
    private function getCollection()
    {
        return $this->getConexion()->{$this->_collectionName};
    }

    /**
     * Función que busca un usuario de acuerdo a un campo y valor especificado
     * @param $field
     * @param $value
     * @return App\Models\User
     */
    public function find($field, $value)
    {
        // Llamamos a la función findOne y le pasamos los parametos
        $result = $this->getCollection()->findOne([$field => $value]);

        // Si hay resultados asignamos los valores a los atributos de la clase
        if($result)
        {
            $this->_id = $result->_id;
            $this->_name = $result->name;
            $this->_email = $result->email;
            $this->_password = $result->password;
        }

        // Retornamos la clase
        return $this;
    }

    /**
     * Función que se encarga de guardar un registro en la coleción de usuarios
     * @param $_POST
     * @return Boolean
     */
    public function save()
    {
        // Llamamos a la collecion y ejecutamos el metodo "insertOne" para guardar y el resultado
        // se almacena en $result
        $result = $this->getCollection()->insertOne([
            'name'      =>  $_POST['name'],
            'email'     =>  $_POST['email'],
            'password'  =>  password_hash($_POST['password'], PASSWORD_DEFAULT),
            'created_at'=>  Carbon::now()->setTimezone("America/Bogota")->toDateTimeString(),
        ]);

        // Si el registro se inserto retornamos "true" de lo contrario "false"
        if($result->getInsertedCount())
            return true;
        
        return false;
    }
}
