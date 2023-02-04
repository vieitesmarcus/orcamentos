<?php

namespace Source\Controller;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Controller implements RequestHandlerInterface
{
    /** @var \League\Plates\Engine */
    protected Engine $view;

    /**
     * Summary of __construct
     * @param string $template
     */
    public function __construct(string $template = __DIR__ . "/../View/pages/")
    {
        $this->view = new Engine($template, "php");
    }
    /**
     * Summary of handle
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    abstract public function handle(ServerRequestInterface $request): ResponseInterface;

}