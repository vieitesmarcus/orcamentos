<?php

namespace Source\Controller\Api\Despesa;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\Despesa;

class DespesaApiController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request, $id = null): ResponseInterface
    {

        if ($id) {
            $obDespesa = (new Despesa())->findById($id, "categoria, descricao, date");
            if ($obDespesa) {
                $body = html_entity_decode(json_encode([
                    "categoria" => $obDespesa->getCategoria(),
                    "descricao" => $obDespesa->getDescricao(),
                    "date" => $obDespesa->getDate()
                ]));
                return new Response(200, ["Content-type" => "Application/json"], $body);
            }
            $body = json_encode(["Error" => "Id inválido"]);
            return new Response(200, ["Content-type" => "Application/json"], $body);
        }


        $jsonDespesas = [];





        if (isset($request->getQueryParams()['descricao'])) {
            $descricao = filter_var($request->getQueryParams()['descricao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $params = http_build_query(["desc" => "%$descricao%"]);
            $despesas = (new Despesa())->find("descricao LIKE :desc", $params)->limit(10)->fetch(true);
        } else if (isset($request->getQueryParams()['ano']) and isset($request->getQueryParams()['mes'])) {
            $ano = filter_var($request->getQueryParams()['ano'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $mes = filter_var($request->getQueryParams()['mes'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dia = filter_var($request->getQueryParams()['dia'] ?? "", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $params = http_build_query(["date" => "%$ano%-%$mes%-%$dia%"]);
            $despesas = (new Despesa())->find("date LIKE :date ", $params)->limit(10)->fetch(true);
        } else {
            $despesas = (new Despesa())->find()->limit(10)->fetch(true);
        }


        if (!$despesas) {
            array_push($jsonDespesas, ["Error" => "nenhum dado retornado"]);
            $body = html_entity_decode(json_encode($jsonDespesas));
            return new Response(201, ["Content-type" => "Application/json"], $body);
        }


        foreach ($despesas as $despesa) {
            array_push($jsonDespesas, [
                "id" => $despesa->getId(),
                "descricao" => $despesa->getDescricao(),
                "categoria" => $despesa->getCategoria(),
                "data" => $despesa->getDate()
            ]);
        }


        $body = html_entity_decode(json_encode($jsonDespesas));
        return new Response(201, ["Content-type" => "Application/json"], $body);
    }
}
