<?php

namespace Source\Model\Dao;

use Source\Utils\Enviroment;
use Error;
use PDO;
use PDOException;

abstract class Conexao
{
    protected PDO $conexao;
    
    public function __construct()
    {
        try{
            $this->conexao = new PDO(
                "mysql:host=".CONF_DB_HOST.";dbname=".CONF_DB_DBNAME,
                CONF_DB_USERNAME,
                CONF_DB_PASSWORD,
               [
                   PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                   PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                   PDO::ATTR_CASE => PDO::CASE_NATURAL
               ]
            );
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $error){
            echo "ERRO => " . $error->getMessage();
            header('Location: /login',true, 302);
        }catch(Error $error){
            echo "Cai no segundo catch " . $error->getMessage();
        }
    }
}