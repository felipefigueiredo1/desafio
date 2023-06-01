<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\ProductTypeTaxRate;
use App\Http\Controllers\AuthController;

class ProductTypeTaxRateController
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
            $productTypeTaxRates = ProductTypeTaxRate::all();

            return json_encode(['productTypeTaxRates' => $productTypeTaxRates]);
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
        try {
            $json = file_get_contents('php://input');

            $data = json_decode($json, true);

            $productTypeTaxRate = new ProductTypeTaxRate();
            
            $productTypeTaxRate->product_type_id = $data['product_type_id'];
            $productTypeTaxRate->tax_rate = $data['tax_rate'];
            $productTypeTaxRate->save();

            return json_encode($productTypeTaxRate);
        } catch (PDOException $e) {
            http_response_code(500);
            return json_encode(['status' => 401, 'message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            return json_encode(['status' => 500, 'message' => $e->getMessage()]);
        }
        
    }
}