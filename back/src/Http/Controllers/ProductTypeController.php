<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\ProductType;
use App\Http\Controllers\AuthController;

class ProductTypeController
{
    public AuthController $auth;

    public function __construct()
    {
        $this->auth = new AuthController();
    }

    public function index(): string
    {
        if(!$this->auth->auth(true)) {
            return false;
        } 

        try {
            $productTypes = ProductType::all();

            return json_encode(['productTypes' => $productTypes]);
        } catch (PDOException $e) {
            http_response_code(500);
            return json_encode(['status' => 401, 'message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            return json_encode(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function store(): string
    {
        if(!$this->auth->auth(true)) {
            return false;
        } 
        
        try {
            $json = file_get_contents('php://input');

            $data = json_decode($json, true);

            $productType = new ProductType();

            $productType->name = $data['name'];
            $productType->save();

            return json_encode($productType);
        } catch (PDOException $e) {
            http_response_code(500);
            return json_encode(['status' => 401, 'message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            return json_encode(['status' => 500, 'message' => $e->getMessage()]);
        }
        
    }
}