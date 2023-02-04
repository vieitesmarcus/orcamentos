<?php

// ROTAS NÃO AUTENTICADAS

use Source\Controller\Api\Receita\ReceitaApiController;
use Source\Controller\Api\Receita\ReceitaApiStoreController;

return [
    "GET|/receitas" => ReceitaApiController::class,
    "POST|/receitas" => ReceitaApiStoreController::class,
    "PUT|/receitas/{id}" => ReceitaApiStoreController::class,
];
