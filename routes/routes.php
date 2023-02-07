<?php

// ROTAS NÃO AUTENTICADAS

use Source\Controller\Api\Receita\ReceitaApiController;
use Source\Controller\Api\Receita\ReceitaApiStoreController;
use Source\Controller\Api\Receita\ReceitaApiDestroyController;

return [
    //rotas de Receitas
    "GET|/receitas" => ReceitaApiController::class,//traz todas as receitas armazenadas
    "GET|/receitas/{id}" => ReceitaApiController::class,// traz em detalhes 
    "POST|/receitas" => ReceitaApiStoreController::class,//insere uma nova receita
    "PUT|/receitas/{id}" => ReceitaApiStoreController::class,//modifica a receita
    "DELETE|/receitas/{id}" =>ReceitaApiDestroyController::class// exclui uma receita
];
