<?php
session_start();

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

// PEGA OS DADOS DA URL
$url = $_SERVER["REQUEST_URI"];
$method = $_SERVER['REQUEST_METHOD'] ?? "GET";
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
require_once __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../routes/routes.php';

$urlArray = explode("/", $url);
array_shift($urlArray);


if(isset($urlArray[1]) and $urlArray[1]){
    $id = filter_var($urlArray[1], FILTER_SANITIZE_NUMBER_INT);
    $urlArray[1] = "{id}";
    $url = "/".implode("/", $urlArray);
}
if($get){
    $url = explode("?", $url);
    $url = $url[0];
}




// VERIFICA SE A ROTA EXISTE COM A URL QUE VEM 
if (!array_key_exists("$method|$url", $routes)) {
    header("Content-type:Application/json", true, 404);
    exit();
    // if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
    //     header('Location:/mypets');
    //     exit();
    // }
    // header('Location:/login');
    // exit();
}


$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

$controller = $routes["$method|$url"];

$page = new $controller();

$response = $page->handle($serverRequest, $id??null);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
