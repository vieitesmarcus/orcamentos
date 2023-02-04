<?php

namespace Source\Model\Entity;

use DateTime;

class Despesa
{
    /** @var int */
    private int $id;

    /** @var string */
    private string $descricao;

    /** @var float */
    private float $valor;

    /** @var string */
    private string $date;

    public function bootstrap(int $id, string $descricao, float $valor, string $date): Despesa
    {
        $this->setId($id);
        $this->setDescricao($descricao);
        $this->setValor($valor);
        $this->setDate($date);
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Despesa
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $this->id = $id;
        return $this;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): Despesa
    {
        $descricao = filter_var($descricao, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->descricao = $descricao;
        return $this;
    }

   
    public function getValor(): float
    {
        return $this->valor;
    }

   
    public function setValor(float $valor): Despesa
    {
        $valor = filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT);
        $this->valor = $valor;

        return $this;
    }

    
    public function getDate(): string
    {
        return $this->date;
    }

     
    public function setDate(string $date): Despesa
    {
        $date = (new DateTime())->createFromFormat("d/m/Y", $date, new \DateTimeZone("America/Sao_Paulo"))->format("d-m-Y");
        $this->date = $date;
        return $this;
    }
}