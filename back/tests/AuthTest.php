<?php

use App\Http\Controllers\AuthController;
use PHPUnit\Framework\TestCase;

require('conf/bootstrap.php');

class AuthTest extends TestCase
{
    public AuthController $authController;

    public function setUp(): void
    {
        parent::setUp();
        $this->authController = new AuthController();
    }

    public function test_if_return_jwt_token()
    {
        $data = $this->authController->login(json_encode(['email' => 'felipe@email.com', 'password' => '123456']));
        $arr = json_decode($data, true);
        $keys = ['jwt', 'rjwt', 'user'];
        
        for($i = 0; $i < count($keys); $i++) {
            $this->assertArrayHasKey($keys[$i], $arr);
        }
    }
}