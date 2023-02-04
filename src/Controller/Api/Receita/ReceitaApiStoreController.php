<?php

namespace Source\Controller\Api\Receita;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\Receita;

class ReceitaApiStoreController implements RequestHandlerInterface
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request
     * @param integer|null $id
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, int $id=null): ResponseInterface
    {
        if($id){
            echo $id;
        }
        $obGenericoRequisicao = json_decode(file_get_contents("php://input"));
        $receita['descricao'] = filter_var($obGenericoRequisicao->descricao,  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $receita['valor'] = filter_var($obGenericoRequisicao->valor,  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $receita['data'] = filter_var($obGenericoRequisicao->data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $obReceita = new Receita();
        $obReceita->bootstrap($id=null ,$receita['descricao'], $receita['valor'], $receita['data']);
        echo '<pre>';
        var_dump($obReceita);
        echo '</pre>';
        exit();

        $body = json_encode($receita);
        return new Response(201, ["Content-type" => "Application/json"], $body);
    }
}
