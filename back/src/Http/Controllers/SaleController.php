<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\Sale;
use App\Models\Product;
use App\Http\Controllers\AuthController;

class SaleController
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
            $sales = Sale::all();
            $products = Product::whereHas('sales')->get();
            return json_encode(['sales' => $sales, 'products' => $products]);
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
            

            foreach($data['itens'] as $d) {
                $productType = new Sale();
                $productType->product_id = $d['id'];
                $productType->quantity = $d['qty'];
                $productType->save();
            }

            return json_encode(['status' => 200, 'message' => 'success']);
        } catch (PDOException $e) {
            http_response_code(500);
            return json_encode(['status' => 401, 'message' => $e->getMessage()]);
        } catch(Exception $e) {
            http_response_code(500);
            return json_encode(['status' => 500, 'message' => $e->getMessage()]);
        }
        
    }
}