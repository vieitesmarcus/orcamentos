<?php

namespace Source\Model\Entity;

use CoffeeCode\DataLayer\DataLayer;
use DateTime;

class Categoria extends DataLayer
{
    public function __construct()
    {
        parent::__construct("categorias", [], "id", false);
    }
}