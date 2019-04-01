<?php
namespace App\Libraries\Http;

/**
 * Clase que envias las respuestas http que vienen desde el servidor
 */
class ResponseHttp 
{

    public function response($data = array(), $code = 200)
    {
        http_response_code($code);

        echo json_encode($data);
    }
}