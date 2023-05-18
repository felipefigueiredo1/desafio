<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\Product;
use App\Http\Controllers\AuthController;

class ProductController
{
    public AuthController $auth;

    public function __construct()
    {
        $this->auth = new AuthController();
    }

    public function index(): bool
    {
            // if(!$this->auth->auth(true)) {
            //     return false;
            // } 

        try {
            $products = Product::all();

            echo json_encode(['products' => $products]);

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

            $product = new Product();

            $product->product_type_id = $data['product_type_id'];
            $product->name = $data['name'];
            $product->save();

            echo json_encode($product);

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