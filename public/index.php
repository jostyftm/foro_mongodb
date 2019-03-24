<?php

// Iniciamos la sesión
session_start();

// Inicializamos las variables para mostrar los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

// importamos el autoload para la carga de clases automaticas
require_once '../vendor/autoload.php';

// Configuramos la zona horaria para la libreria que manerajá la hora
date_default_timezone_set("America/Bogota");
\Carbon\Carbon::setLocale('es');

// Obtenemos la base url del proyecto
$baseUrl = '';
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = "http://{$_SERVER['HTTP_HOST']}{$baseDir}";

// Definimos una constante con el nombre de la base URL
define('BASE_URL', $baseUrl);

// importamos el archivos que contiene las rutas
require_once '../config/rutas.php';