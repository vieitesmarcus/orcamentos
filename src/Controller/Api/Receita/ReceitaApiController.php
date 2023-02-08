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
            $obReceita = (new Receita())->findById($id, "categoria, descricao, date");
            if ($obReceita) {
                $body = html_entity_decode(json_encode([
                    "categoria" => $obReceita->getCategoria(),
                    "descricao" => $obReceita->getDescricao(),
                    "date" => $obReceita->getDate()
                ]));
                return new Response(200, ["Content-type" => "Application/json"], $body);
            }
            $body = json_encode(["Error" => "Id inválido"]);
            return new Response(200, ["Content-type" => "Application/json"], $body);
        }


        $jsonReceitas = [];

        if (isset($request->getQueryParams()['descricao'])) {
            $descricao = filter_var($request->getQueryParams()['descricao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $params = http_build_query(["desc" => "%$descricao%"]);
            $receitas = (new Receita())->find("descricao LIKE :desc", $params)->limit(10)->fetch(true);
        } else if (isset($request->getQueryParams()['ano']) and isset($request->getQueryParams()['mes'])) {
            $ano = filter_var($request->getQueryParams()['ano'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mes = filter_var($request->getQueryParams()['mes'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dia = filter_var($request->getQueryParams()['dia'] ?? "", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $params = http_build_query(["date" => "%$ano%-%$mes%-%$dia%"]);
            $receitas = (new Receita())->find("date LIKE :date ", $params)->limit(10)->fetch(true);

        } else {
            $receitas = (new Receita())->find()->limit(10)->fetch(true);
        }


        if (!$receitas) {
            array_push($jsonReceitas, ["Error" => "nenhum dado retornado"]);
            $body = html_entity_decode(json_encode($jsonReceitas));
            return new Response(201, ["Content-type" => "Application/json"], $body);
        }


        foreach ($receitas as $receita) {
            array_push($jsonReceitas, [

                "id" => $receita->getId(),

                "descricao" => $receita->getDescricao(),
                "categoria" => $receita->getCategoria(),
                "data" => $receita->getDate()
            ]);
        }


        $body = html_entity_decode(json_encode($jsonReceitas));
        return new Response(201, ["Content-type" => "Application/json"], $body);
    }
}