<?php

namespace Source\Controller\Api\Receita;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\Receita;

class ReceitaApiDestroyController implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param integer|null $id
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, int $id=null): ResponseInterface
    {
        if ($id) {
            $obReceita = (new Receita())->findById($id);
            if($obReceita){
                $obReceita->destroy();
            }else {
                $message = json_encode(["Error"=> "id inválido para deletar"]);
            }
        } 
        // $obReceita->bootstrap($id, $receita['descricao'], $receita['valor'], $receita['data']);
        
        return new Response(201, ["Content-type" => "Application/json"], $message??"");
    }
}