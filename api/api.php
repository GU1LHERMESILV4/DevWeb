<?php
header('Content-Type: application/json');
require_once 'config.php';

// Get all characters
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM characters");
        $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($characters);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Create new character
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO characters (name, description, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['description'], $data['image_url']]);
        $data['id'] = $pdo->lastInsertId();
        echo json_encode($data);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Update character
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $stmt = $pdo->prepare("UPDATE characters SET name = ?, description = ?, image_url = ? WHERE id = ?");
        $stmt->execute([$data['name'], $data['description'], $data['image_url'], $data['id']]);
        echo json_encode($data);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Delete character
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM characters WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?> 