<?php

// ROTAS NÃO AUTENTICADAS

use Source\Controller\Api\Despesa\{DespesaApiController, DespesaApiDestroyController, DespesaApiStoreController};
use Source\Controller\Api\Receita\{ReceitaApiController, ReceitaApiStoreController, ReceitaApiDestroyController};
    
return [
    //rotas de Receitas                                                                   
                                                                       
    "GET|/receitas"                   => ReceitaApiController::class,          //traz todas as receitas armazenadas
    "GET|/receitas/{id}"              => ReceitaApiController::class,          // traz em detalhes 
    "GET|/receitas/{ano}/{mes}"       => ReceitaApiController::class,          //traz em detalhes tudo do ano e mes
    "GET|/receitas/{ano}/{mes}/{dia}" => ReceitaApiController::class,          //traz em detalhes tudo do ano e mes
    "POST|/receitas"                  => ReceitaApiStoreController::class,     //insere uma nova receita
    "PUT|/receitas/{id}"              => ReceitaApiStoreController::class,     //modifica a receita
    "DELETE|/receitas/{id}"           => ReceitaApiDestroyController::class,   // exclui uma receita

                                                                     //Rotas de Despesas                                                             
    "GET|/despesas"                   => DespesaApiController::class,          //traz todas as despesas armazenadas
    "GET|/despesas/{id}"              => DespesaApiController::class,
    "GET|/despesas/{ano}/{mes}"       => DespesaApiController::class,          //traz em detalhes tudo do ano e mes
    "GET|/despesas/{ano}/{mes}/{dia}" => DespesaApiController::class,          // traz em detalhes 
    "POST|/despesas"                  => DespesaApiStoreController::class,     //insere uma nova Despesa
    "PUT|/despesas/{id}"              => DespesaApiStoreController::class,     //modifica a Despesa
    "DELETE|/despesas/{id}"           => DespesaApiDestroyController::class,   // exclui uma Despesa

];
