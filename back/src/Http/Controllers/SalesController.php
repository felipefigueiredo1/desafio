<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\ProductTypeTaxRate;
use App\Http\Controllers\AuthController;

class SalesController
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
            $productTypeTaxRates = ProductTypeTaxRate::all();

            echo json_encode(['productTypeTaxRates' => $productTypeTaxRates]);

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

    public function store(): bool
    {
        try {
            $json = file_get_contents('php://input');

            $data = json_decode($json, true);

            $productTypeTaxRate = new ProductTypeTaxRate();
            
            $productTypeTaxRate->product_type_id = $data['product_type_id'];
            $productTypeTaxRate->name = $data['name'];
            $productTypeTaxRate->save();

            echo json_encode($productTypeTaxRate);

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