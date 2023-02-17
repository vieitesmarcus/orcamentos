<?php

declare(strict_types=1);
session_start();

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Source\Model\Entity\User;

// PEGA OS DADOS DA URL

$url       = $_SERVER["REQUEST_URI"];
$method    = $_SERVER['REQUEST_METHOD'] ?? "GET";
$getInputs = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

require_once __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../routes/routes.php';

//VERIFICA AUTENTICAÇÃO E VERIFICA SE EXISTE UM USUARIO
if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $authorization = filter_input(INPUT_SERVER, "HTTP_AUTHORIZATION", FILTER_SANITIZE_SPECIAL_CHARS);
    $authorization = str_replace("Bearer ", "", $authorization);
    $user          = (new User())->find(" token = :token", "token=$authorization")->fetch();
    if ($user) {
        // unset($user->data()->password);
        $routes = require __DIR__ . '/../routes/routesAutenticadas.php';

        //verifica se a o token já expirou
        $hourNow     = new DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $hourExpires = new DateTime($user->expires, new \DateTimeZone('America/Sao_Paulo'));

        if ($hourNow->diff($hourExpires)->invert == 1) {
            echo "refaça o login";
            var_dump($user->data);
            $user->setToken();
            $user->save();
            var_dump($user);exit();
            header('Location:/login', true, 302);
            return;
        }
        $_SESSION['user'] = $user->data();
    }
}



$urlArray = explode("/", $url);
array_shift($urlArray);

$qtdUrl = count($urlArray);
if ($qtdUrl == 2) {
    $id          = filter_var($urlArray[1], FILTER_SANITIZE_NUMBER_INT);
    $urlArray[1] = "{id}";
} else if ($qtdUrl >= 3) {
    $ano         = filter_var($urlArray[1] ?? "", FILTER_SANITIZE_NUMBER_INT);
    $mes         = filter_var($urlArray[2] ?? "", FILTER_SANITIZE_NUMBER_INT);
    $dia         = filter_var($urlArray[3] ?? "", FILTER_SANITIZE_NUMBER_INT);
    $urlArray[1] = "{ano}";
    $urlArray[2] = "{mes}";
    $urlArray[3] = "{dia}";
    $get['ano']  = $ano;
    $get['mes']  = $mes;
    $get['dia']  = $dia;
    $_GET = $get;
}
$url         = "/" . implode("/", $urlArray);


if ($_GET[] = (isset($getInputs) ? $getInputs : [])) {
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

$controller    = $routes["$method|$url"];
$page          = new $controller();
$response      = $page->handle($serverRequest, $id ?? null);



foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
