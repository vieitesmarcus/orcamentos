<?php

// ROTAS NÃO AUTENTICADAS

use Source\Controller\CadastroController;
use Source\Controller\CadastroFormController;
use Source\Controller\LoginController;

return [
    //rotas de Receitas                                                                   

    "GET|/cadastro" => CadastroFormController::class,   
    "POST|/cadastrar" => CadastroController::class,  
    "POST|/login" => LoginController::class,   

];
