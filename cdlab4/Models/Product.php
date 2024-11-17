<?php

namespace app\Models;

include "app/Config/DatabaseConfiguration.php";


use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig
{
    public $conn;

    public function __construct()
    {
        $this -> conn = new mysqli ($this ->host, $this ->user, $this ->password, $this ->database_name, $this ->port);

        if ($this ->conn ->connect_error) {
            die("Connection Failed: " . $this ->conn ->connect_error);
    }
}

public function findAll()
{
    $sql = "SELECT * FROM product";
    $result = $this ->conn ->query($sql);
    $this->conn->close();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

public function findById($id)
{
    $sql = "SELECT * FROM products where id = ?";
    $stmt = $this ->conn ->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $this->conn->close();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

public function create($data)
{
    $productName = $data['productName'];
    $query = "INSERT INTO products (produc_tName) VALUES (?)";
    $stmt = $this ->conn ->prepare($query);
    $stmt -> bind_param("s", $productName);
    $stmt->execute();
    $this->conn->close();
    return $stmt;
}

public function update($id, $data)
{
    $productName = $data['productName'];
    $query = "UPDATE products SET product_name = ? WHERE id = ?";
    $stmt = $this ->conn ->prepare($query);
    $stmt -> bind_param("si", $productName, $id);
    $stmt->execute();
    $this->conn->close();

}

public function delete ($id)
{
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $this ->conn ->prepare($query);
    $stmt -> bind_param("i", $id);
    $stmt->execute();
    $this->conn->close();
}

}