<?php

namespace Source\Model\Entity;

use DateTime;
use DateTimeZone;

class Receita
{
    /** @var int */
    private ?int $id;

    /** @var string */
    private string $descricao;

    /** @var float */
    private float $valor;

    /** @var string */
    private string $date;

    public function bootstrap(int $id = null, string $descricao, float $valor, string $date): Receita
    {
        if ($id) {
            $this->setId($id);
        }
        $this->setDescricao($descricao);
        $this->setValor($valor);
        $this->setDate($date);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Receita
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $this->id = $id;
        return $this;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): Receita
    {
        $descricao = filter_var($descricao, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get the value of valor
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */
    public function setValor(float $valor): Receita
    {
        $valor = number_format(filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT), 2, ",", ".");
        $this->valor = (float)$valor;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate(string $date): Receita
    {
        $date = (new DateTime())->createFromFormat("d/m/Y", $date, new DateTimeZone("America/Sao_Paulo"))->format("d-m-Y");
        $this->date = $date;
        return $this;
    }
}
