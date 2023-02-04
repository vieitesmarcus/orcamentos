<?php

namespace Source\Model\Dao;


class Model extends Conexao
{

    public function __construct(string $entity="", array $fixed=[], array $required=[])
    {
        parent::__construct();
    }
}
