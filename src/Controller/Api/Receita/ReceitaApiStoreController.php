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
     * @param ServerRequestInterface $request
     * @param integer|null $id
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, int $id=null): ResponseInterface
    {
        $obGenericoRequisicao = json_decode(file_get_contents("php://input"));
        $receita['descricao'] = filter_var($obGenericoRequisicao->descricao, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $receita['valor'] = filter_var($obGenericoRequisicao->valor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $receita['categoria'] = (int)filter_var($obGenericoRequisicao->categoria ?? 8, FILTER_SANITIZE_NUMBER_INT);
        if ($receita['categoria'] < 1 or $receita['categoria'] > 8) {
            $receita['categoria'] = 8;
        }

        
        if ($id) {
            $obReceita = (new Receita())->findById($id);
        } else {
            $obReceita = new Receita();
        }
        // $obReceita->bootstrap($id, $receita['descricao'], $receita['valor'], $receita['data']);
        $obReceita->setDescricao($receita['descricao']);
        $obReceita->setValor($receita['valor']);
        $obReceita->setCategoria($receita['categoria']);
        $obReceita->save();
        
        return new Response(201, ["Content-type" => "Application/json"]);
    }
}