<?php

namespace Source\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CadastroFormController implements RequestHandlerInterface
{
    
    public function handle(ServerRequestInterface $request): Response
    {
        $file = file_get_contents(__DIR__ . '/../View/pages/Cadastro.php');
        // var_dump($file);exit();
        return new Response(200,[], $file);
    }
}