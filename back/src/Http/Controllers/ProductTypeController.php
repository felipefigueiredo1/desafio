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

    public function index(): bool
    {
        if(!$this->auth->auth(true)) {
            return false;
        } 

        try {
            $productTypes = ProductType::all();

            echo json_encode(['productTypes' => $productTypes]);

            return true;
        } catch (PDOException $e) {
            echo "Error: {$e->getMessage()}";

            return false;
        } catch(Exception $e) {
            echo "Error: {$e->getMessage()}";

            return false;
        }
    }

    public function store(): bool
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

            echo json_encode($productType);

            return true;
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 401, 'message' => $e->getMessage()]);
            return false;
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 500, 'message' => $e->getMessage()]);
            return false;
        }
        
    }
}