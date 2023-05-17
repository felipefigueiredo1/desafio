<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class AuthController
{
    public User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Faz o login e retorna um token e um refresh token
     * $jwt  = auth token
     * $rjwt = refresth token
     * 
     * @echo void
     */

    public function login(): void
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $password = $data['password'];

        $userFound = $this->user->where('email', $email)->first();

        if (!$userFound || $password != $userFound->password) {
            http_response_code(401);
            echo json_encode(['message' => 'Incorrect email\password']);
        }

        $payload = [
            "exp" => time() + 10,
            "iat" => time(),
            "email" => $email,
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');
        
        // 30 days
        $r_payload  = [
            "exp" => time() + 2592000,
            "iat" => time(),
            "email" => $email,
        ];

        $r_encode = JWT::encode($r_payload, $_ENV['KEY'], 'HS256');

        echo json_encode(['jwt' => $encode, 'rjwt' => $r_encode, 'user' => $userFound->name]);
    }

    /**
     * Verifica se o token é valido
     *
     * @echo void
     */
    public function auth(): void
    {
        $token = str_replace("Bearer ", "", $_SERVER["HTTP_AUTHORIZATION"]);

        try {
            $decode = JWT::decode($token,  new Key($_ENV['KEY'], 'HS256'));
            echo json_encode($decode);
        }catch (\Firebase\JWT\ExpiredException $e) {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => $e->getMessage()]);
        }
         catch (\Throwable $th) {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => $th->getMessage()]);
        }

        echo json_encode(['jwt' => $token]);
    }

    /**
     * Cria um token novo a partir do refresh token, chamadno o método createNewToken
     *
     * @echo void
     */
    public function refreshToken(): void
    {
        $token = str_replace("Bearer ", "", $_SERVER["HTTP_AUTHORIZATION"]);
        
        try {
            $decode = JWT::decode($token,  new Key($_ENV['KEY'], 'HS256'));
            echo $this->createNewToken($decode->email);
        } catch (\Throwable $th) {
            http_response_code(401);
            echo json_encode(['status' => 401, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Retorna um novo token
     *
     * @param [string] $email
     * @echo void
     */
    public function createNewToken(string $email): string
    {
        $payload = [
            "exp" => time() + 10,   
            "iat" => time(),
            "email" => $email,
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

        return json_encode(['jwt' => $encode]);
    }
}
