<?php  

namespace app\Controller;
include "app/Traits/ApiResponseFormatter.php";
include "app/Models/Product.php";

use app\Models\Product;
use app\Traits\ApiResponseFormatter;

class ProductController
{
    use ApiResponseFormatter;

    public function index()
    {
        $product = new Product();
        $response = $product->findAll();
        return $this->formatApiResponse(200, "success", $response);

    }

    public function getById($id)
    {
        $productModel = new Product();
        $response = $productModel->findById($id);
        return $this->formatApiResponse(200, "success", $response);
    }

    public function insert()
    {

        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);
        if (json_last_error()){
            return $this->formatApiResponse(400,"Error invalid input", null);
        }
        $productModel = new Product();
        $response = $productModel->create([
            "productName" => $inputData['productName']
         ]);

        return $this->formatApiResponse(200, "success", $response);
    }

    public function update($id)
    {

        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);
        if (json_last_error()){
        return $this->formatApiResponse(400,"Error invalid input", null);
        }

        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData['product_name']
         ], $id);
         return $this->formatApiResponse(200, "success", $response);
    }

public function delete($id)
    {
    $productModel = new Product();
    $response = $productModel->delete($id);
    return $this->formatApiResponse(200, "success", $response);
    }

}