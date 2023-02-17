<?php

namespace Source\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\User;

class LoginController implements RequestHandlerInterface
{


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $post     = json_decode(file_get_contents("php://input"));
        $email    = filter_var($post->email ?? "", FILTER_SANITIZE_EMAIL);
        $password = filter_var($post->password ?? "", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$email) {
            return new Response(302, [
                'Location'     => "/login",
                "Content-Type" => "Application/json"
            ]);
        }
        if (!$password) {
            return new Response(302, [
                'Location'     => "/login",
                "Content-Type" => "Application/json"
            ]);
        }

        $obUser = (new User())->find('email = :email', "email=$email")->fetch();
        if (!password_verify($password, $obUser->data()->password)) {
            return new Response(302, [
                'Location'     => "/login",
                "Content-Type" => "Application/json"
            ]);
        }
        $obUser->setPassword($password);
        $obUser->setToken();
        $obUser->setExpires();
        $obUser->save();

        return new Response(200, ['Content-Type' => "Application/json"], json_encode([
            "token" => $obUser->getToken()
        ]));
    }
}
