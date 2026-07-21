<?php

require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(array('error' => 'Unauthorized'));
    exit;
}

// Get input data
$inputData = json_decode(file_get_contents('php://input'), true);

// Define routes
$routes = array(
    '/orders' => array('GET' => 'getOrders', 'POST' => 'createOrder'),
    '/orders/:id' => array('GET' => 'getOrder', 'PUT' => 'updateOrder', 'DELETE' => 'deleteOrder')
);

// Get route and method
$route = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Get route parameters
$parameters = array();
if (strpos($route, ':') !== false) {
    $parameters = explode('/', $route);
    $parameters = array_filter($parameters, function($param) {
        return strpos($param, ':') === 0;
    });
    $parameters = array_map(function($param) {
        return trim($param, ':');
    }, $parameters);
}

// Get route and method
$route = explode('/', $route);
$route = array_filter($route);
$route = array_map('trim', $route);

// Check if route and method exist
if (!isset($routes[$route[0]][$method])) {
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
    exit;
}

// Call route function
$func = $routes[$route[0]][$method];
$func($parameters);

function getOrders() {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM orders');
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($orders);
}

function getOrder($parameters) {
    global $pdo;
    if (count($parameters) !== 1) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }
    $id = $parameters[0];
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$order) {
        http_response_code(404);
        echo json_encode(array('error' => 'Order not found'));
        exit;
    }
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($order);
}

function createOrder() {
    global $pdo;
    // Validate input data
    if (!isset($inputData['customer_id']) || !isset($inputData['product_id']) || !isset($inputData['quantity'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }
    // Sanitize input data
    $customer_id = filter_var($inputData['customer_id'], FILTER_SANITIZE_NUMBER_INT);
    $product_id = filter_var($inputData['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_var($inputData['quantity'], FILTER_SANITIZE_NUMBER_INT);
    // Insert order
    $stmt = $pdo->prepare('INSERT INTO orders (customer_id, product_id, quantity) VALUES (:customer_id, :product_id, :quantity)');
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->execute();
    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Order created successfully'));
}

function updateOrder($parameters) {
    global $pdo;
    if (count($parameters) !== 1) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }
    $id = $parameters[0];
    // Validate input data
    if (!isset($inputData['customer_id']) || !isset($inputData['product_id']) || !isset($inputData['quantity'])) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }
    // Sanitize input data
    $customer_id = filter_var($inputData['customer_id'], FILTER_SANITIZE_NUMBER_INT);
    $product_id = filter_var($inputData['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_var($inputData['quantity'], FILTER_SANITIZE_NUMBER_INT);
    // Check if user is admin
    if ($_SESSION['user_role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
        exit;
    }
    // Update order
    $stmt = $pdo->prepare('UPDATE orders SET customer_id = :customer_id, product_id = :product_id, quantity = :quantity WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->execute();
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Order updated successfully'));
}

function deleteOrder($parameters) {
    global $pdo;
    if (count($parameters) !== 1) {
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid request'));
        exit;
    }
    $id = $parameters[0];
    // Check if user is admin
    if ($_SESSION['user_role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(array('error' => 'Forbidden'));
        exit;
    }
    // Delete order
    $stmt = $pdo->prepare('DELETE FROM orders WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Order deleted successfully'));
}

?>