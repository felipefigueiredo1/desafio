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

    public function index(): bool
    {
        if(!$this->auth->auth(true)) {
            return false;
        } 

        try {
            $sales = Sale::all();
            $products = Product::whereHas('sales')->get();
            echo json_encode(['sales' => $sales, 'products' => $products]);

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

            echo json_encode(['status' => 200, 'message' => 'success']);

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