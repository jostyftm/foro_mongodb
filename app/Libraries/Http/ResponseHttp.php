<?php
namespace App\Libraries\Http;

/**
 * Clase que envias las respuestas http que vienen desde el servidor
 */
class ResponseHttp 
{

    /**
     * Función que envia los datos convertidos a json 
     */
    public function response($data = array(), $code = 200)
    {
        // Asignamos el estado de la respuesta
        http_response_code($code);

        // Agrega el header para json
        header('Content-Type: application/json');

        // Imprime la respuesta
        echo json_encode($data);
    }
}