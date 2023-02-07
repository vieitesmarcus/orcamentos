<?php

namespace Source\Controller\Api\Receita;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\Receita;

class ReceitaApiController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request, $id = null): ResponseInterface
    {
        if ($id) {
            $receitas = (new Receita())->findById($id);

            $jsonReceitas = $receitas !== null ? ["descricao" => $receitas->data->descricao, "valor" => $receitas->data->valor, "date" => $receitas->data->date] : "Sem retorno";
        } else {
            $receitas = (new Receita())->find()->limit(10)->fetch(true);
            $jsonReceitas = [];
            foreach ($receitas as $receita) {
                array_push($jsonReceitas, $receita->data);
            }
        }



        $body = json_encode($jsonReceitas);
        return new Response(201, ["Content-type" => "Application/json"], $body);
    }
}