<?php
require_once 'db.php';

// Get the input data from the request body
$input = json_decode(file_get_contents('php://input'), true);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        // Prepare the SQL query
        $stmt = $pdo->prepare('SELECT * FROM الطاقم');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode($data);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate the input data
        if (!isset($input['name']) || !isset($input['position']) || !isset($input['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }

        // Sanitize the input data
        $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $position = filter_var($input['position'], FILTER_SANITIZE_STRING);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        // Prepare the SQL query
        $stmt = $pdo->prepare('INSERT INTO الطاقم (name, position, email) VALUES (:name, :position, :email)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Team member added successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        // Validate the input data
        if (!isset($input['id']) || !isset($input['name']) || !isset($input['position']) || !isset($input['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }

        // Sanitize the input data
        $id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $position = filter_var($input['position'], FILTER_SANITIZE_STRING);
        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        // Prepare the SQL query
        $stmt = $pdo->prepare('UPDATE الطاقم SET name = :name, position = :position, email = :email WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Team member updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        // Validate the input data
        if (!isset($input['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }

        // Sanitize the input data
        $id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the SQL query
        $stmt = $pdo->prepare('DELETE FROM الطاقم WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Team member deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}