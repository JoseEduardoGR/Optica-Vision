-- Create database
CREATE DATABASE IF NOT EXISTS optical_shop;
USE optical_shop;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create products table (optical products)
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    color VARCHAR(30) NOT NULL,
    mileage INT DEFAULT 0,
    fuel_type ENUM('Prescription', 'Sunglasses', 'Reading', 'Computer') DEFAULT 'Prescription',
    transmission ENUM('Unisex', 'Men', 'Women', 'Kids') DEFAULT 'Unisex',
    description TEXT,
    image_url VARCHAR(255),
    status ENUM('Available', 'Sold', 'Reserved') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, phone) VALUES 
('admin', 'admin@opticavision.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador Óptica', '+1234567890');

-- Insert sample optical products
INSERT INTO cars (brand, model, year, price, color, mileage, fuel_type, transmission, description, image_url) VALUES 
('Ray-Ban', 'Aviator Classic', 2024, 189.99, 'Gold', 0, 'Sunglasses', 'Unisex', 'Lentes de sol clásicos con protección UV400', '/placeholder.svg?height=300&width=400'),
('Oakley', 'Holbrook', 2024, 156.00, 'Black', 0, 'Sunglasses', 'Men', 'Lentes deportivos con tecnología Prizm', '/placeholder.svg?height=300&width=400'),
('Gucci', 'GG0061S', 2024, 320.00, 'Brown', 0, 'Sunglasses', 'Women', 'Lentes de lujo con diseño elegante', '/placeholder.svg?height=300&width=400'),
('Persol', 'PO3019S', 2024, 245.00, 'Tortoise', 0, 'Prescription', 'Unisex', 'Monturas para graduación con estilo italiano', '/placeholder.svg?height=300&width=400'),
('Tom Ford', 'FT5401', 2024, 380.00, 'Blue', 0, 'Computer', 'Unisex', 'Lentes con filtro de luz azul para computadora', '/placeholder.svg?height=300&width=400');
