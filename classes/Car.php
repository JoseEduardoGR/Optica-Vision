<?php
require_once 'config/database.php';

class Car {
    private $conn;
    private $table_name = "cars";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCars() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCarById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addCar($brand, $model, $year, $price, $color, $mileage, $fuel_type, $transmission, $description, $image_url) {
        $query = "INSERT INTO " . $this->table_name . " (brand, model, year, price, color, mileage, fuel_type, transmission, description, image_url) VALUES (:brand, :model, :year, :price, :color, :mileage, :fuel_type, :transmission, :description, :image_url)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':mileage', $mileage);
        $stmt->bindParam(':fuel_type', $fuel_type);
        $stmt->bindParam(':transmission', $transmission);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $image_url);

        return $stmt->execute();
    }

    public function updateCar($id, $brand, $model, $year, $price, $color, $mileage, $fuel_type, $transmission, $description) {
        $query = "UPDATE " . $this->table_name . " SET brand = :brand, model = :model, year = :year, price = :price, color = :color, mileage = :mileage, fuel_type = :fuel_type, transmission = :transmission, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':mileage', $mileage);
        $stmt->bindParam(':fuel_type', $fuel_type);
        $stmt->bindParam(':transmission', $transmission);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    public function deleteCar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
