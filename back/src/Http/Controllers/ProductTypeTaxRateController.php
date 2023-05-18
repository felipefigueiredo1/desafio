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
            echo "Error: {$e->getMessage()}";

            return false;
        } catch(Exception $e) {
            echo "Error: {$e->getMessage()}";

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
            echo "Error: {$e->getMessage()}";

            return false;
        } catch(Exception $e) {
            echo "Error: {$e->getMessage()}";

            return false;
        }
        
    }
}