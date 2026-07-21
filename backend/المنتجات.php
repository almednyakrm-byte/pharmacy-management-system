<?php
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(array('error' => 'Unauthorized'));
    exit;
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Define routes
$routes = array(
    '/products' => array('GET', 'POST'),
    '/products/:id' => array('GET', 'PUT', 'DELETE')
);

// Get route and method
$route = explode('/', $_SERVER['REQUEST_URI']);
$method = $_SERVER['REQUEST_METHOD'];

// Validate route and method
if (!isset($routes[$route[1]])) {
    http_response_code(404);
    echo json_encode(array('error' => 'Not Found'));
    exit;
}

if (!in_array($method, $routes[$route[1]])) {
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
    exit;
}

// Validate and sanitize input data
if ($method == 'POST' || $method == 'PUT') {
    $requiredFields = array('name', 'price', 'description');
    foreach ($requiredFields as $field) {
        if (!isset($input[$field])) {
            http_response_code(400);
            echo json_encode(array('error' => 'Invalid request'));
            exit;
        }
        $input[$field] = trim($input[$field]);
    }
}

// Connect to database
$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle GET request
if ($method == 'GET') {
    if ($route[1] == 'products') {
        // Get all products
        $stmt = $db->prepare('SELECT * FROM products');
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    } elseif ($route[1] == 'products' && isset($route[2])) {
        // Get product by ID
        $stmt = $db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->bindParam(':id', $route[2]);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            http_response_code(404);
            echo json_encode(array('error' => 'Not Found'));
            exit;
        }
        echo json_encode($product);
    }
}

// Handle POST request
if ($method == 'POST') {
    // Insert new product
    $stmt = $db->prepare('INSERT INTO products (name, price, description) VALUES (:name, :price, :description)');
    $stmt->bindParam(':name', $input['name']);
    $stmt->bindParam(':price', $input['price']);
    $stmt->bindParam(':description', $input['description']);
    $stmt->execute();
    http_response_code(201);
    echo json_encode(array('message' => 'Product created successfully'));
}

// Handle PUT request
if ($method == 'PUT') {
    // Update product
    $stmt = $db->prepare('UPDATE products SET name = :name, price = :price, description = :description WHERE id = :id');
    $stmt->bindParam(':id', $route[2]);
    $stmt->bindParam(':name', $input['name']);
    $stmt->bindParam(':price', $input['price']);
    $stmt->bindParam(':description', $input['description']);
    $stmt->execute();
    http_response_code(200);
    echo json_encode(array('message' => 'Product updated successfully'));
}

// Handle DELETE request
if ($method == 'DELETE') {
    // Delete product
    $stmt = $db->prepare('DELETE FROM products WHERE id = :id');
    $stmt->bindParam(':id', $route[2]);
    $stmt->execute();
    http_response_code(204);
    echo json_encode(array('message' => 'Product deleted successfully'));
}

// Close database connection
$db = null;