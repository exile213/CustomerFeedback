<?php
require_once 'dbconnect.php';

class InventoryController {
    private $conn;
    private $products_table = "products";
    private $changelog_table = "change_log";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getInventory() {
        $query = "SELECT * FROM " . $this->products_table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        return [
            'Short / Pants',
            'Sandals',
            'Shirts',
            'Accessories',
            'Perfumes / Cosmetics'
        ];
    }

    public function addProduct($data) {
        $query = "INSERT INTO " . $this->products_table . " 
                  SET name=:name, category=:category, quantity=:quantity, price=:price, reorder_level=:reorder_level";
        
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":quantity", $data['quantity']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":reorder_level", $data['reorder_level']);
    
        try {
            if($stmt->execute()) {
                $this->logChange("Added", "New product added: " . $data['name']);
                return true;
            } else {
                // Get error info
                $errorInfo = $stmt->errorInfo();
                // Log or return the error
                error_log("Database Error: " . $errorInfo[2]);
                return false;
            }
        } catch (PDOException $e) {
            // Log or return the exception message
            error_log("PDO Exception: " . $e->getMessage());
            return false;
        }
    }

    public function updateProduct($id, $data) {
        $query = "UPDATE " . $this->products_table . " 
                  SET name=:name, category=:category, quantity=:quantity, price=:price, reorder_level=:reorder_level 
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":quantity", $data['quantity']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":reorder_level", $data['reorder_level']);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()) {
            $this->logChange("Updated", "Product updated: " . $data['name']);
            return true;
        }
        return false;
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM " . $this->products_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        if($stmt->execute()) {
            $this->logChange("Deleted", "Product deleted with ID: " . $id);
            return true;
        }
        return false;
    }

    public function exportData() {
        $query = "SELECT * FROM " . $this->products_table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $csv = "Name,Category,Quantity,Price,Reorder Level\n";
        foreach($products as $product) {
            $csv .= "{$product['name']},{$product['category']},{$product['quantity']},{$product['price']},{$product['reorder_level']}\n";
        }
        
        return $csv;
    }

    public function getChangeLog() {
        $query = "SELECT * FROM " . $this->changelog_table . " ORDER BY timestamp DESC LIMIT 10";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function logChange($action, $details) {
        $query = "INSERT INTO " . $this->changelog_table . " (action, details) VALUES (:action, :details)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":action", $action);
        $stmt->bindParam(":details", $details);
        $stmt->execute();
    }

    public function logout() {
        session_start();
        $_SESSION = array();
        session_destroy();
    }
}

