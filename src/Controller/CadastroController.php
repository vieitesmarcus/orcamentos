<?php

namespace Source\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Source\Model\Entity\User;

class CadastroController implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): Response
    {
        $post = json_decode(file_get_contents("php://input"));
        $email           = filter_var($post->email ?? "", FILTER_SANITIZE_EMAIL);
        $password        = filter_var($post->password ?? "", FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword = filter_var($post->confirm_paswd ?? "", FILTER_SANITIZE_SPECIAL_CHARS);
        if ((!$email || !$password || !$confirmPassword) OR ($confirmPassword !== $password) OR (mb_strlen($password) < 8)) {
            unset($post);
            $dados =  json_encode(["Obs"=> "todos os campos devem ser preenchidos! Senhas devem ser iguais e ter mais de 8 caracteres"]);
            echo $dados;
            // return new Response(200, ["Content-type"=>"Application/json"], $dados);
            return new Response(302, ["Location"=> "/cadastro"]);
        }
        
        $obUser = new User();
        $obUser->setEmail($email);
        $obUser->setPassword($password);
        $obUser->setPermission(1);
        $obUser->save();
        if($obUser->fail()){

            return new Response(302, ["Location"=>'/cadastro']);
        }

        return new Response(302, ["Location"=> '/login']);
    }
}
