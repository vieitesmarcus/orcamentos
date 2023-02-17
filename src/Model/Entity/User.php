<?php

namespace Source\Model\Entity;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer
{
    public function __construct()
    {
        parent::__construct("users", ["email", "password", "token", "expires", "permission"], "id");
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): ?User
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setToken(): ?User
    {
        $this->token = md5(uniqid());
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setExpires(): void
    {
        $expires = new \DateTime('now', new \DateTimeZone("America/Sao_Paulo"));
        $expires->add(new \DateInterval("P7D"));
        $this->expires = $expires->format("Y-m-d H:i:s");
    }

    public function getExpires(): \DateTime|string
    {
        return $this->expires;
    }

    public function setPermission(int $number): User
    {
        $this->permission = $number;
        return $this;
    }
}
