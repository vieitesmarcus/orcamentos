<?php

namespace Source\Controller\Api\Despesa;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\Despesa;

class DespesaApiStoreController implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param integer|null $id
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, int $id = null): ResponseInterface
    {
        $obGenericoRequisicao = json_decode(file_get_contents("php://input"));
        $despesa['descricao'] = filter_var($obGenericoRequisicao->descricao, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $despesa['valor'] = filter_var($obGenericoRequisicao->valor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $despesa['categoria'] = (int)filter_var($obGenericoRequisicao->categoria ?? 8, FILTER_SANITIZE_NUMBER_INT);
        if ($despesa['categoria'] < 1 or $despesa['categoria'] > 8) {
            $despesa['categoria'] = 8;
        }

<<<<<<< HEAD

=======
        
>>>>>>> e376918bfa4f856814f4e39e375be865e258083a
        if ($id) {
            $obDespesa = (new Despesa())->findById($id);
        } else {
            $obDespesa = new Despesa();
        }
<<<<<<< HEAD
=======
        // $obDespesa->bootstrap($id, $despesa['descricao'], $despesa['valor'], $despesa['data']);
>>>>>>> e376918bfa4f856814f4e39e375be865e258083a
        $obDespesa->setDescricao($despesa['descricao']);
        $obDespesa->setValor($despesa['valor']);
        $obDespesa->setCategoria($despesa['categoria']);
        $obDespesa->save();
<<<<<<< HEAD

=======
        
>>>>>>> e376918bfa4f856814f4e39e375be865e258083a
        return new Response(201, ["Content-type" => "Application/json"]);
    }
}
