<?php
header('Content-Type: application/json');
require_once 'config.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        try {
            $stmt = $conn->query("SELECT * FROM students ORDER BY name");
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($students);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    case 'create':
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("INSERT INTO students (name, email, course, ra, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['course'],
                $data['ra'],
                $data['phone']
            ]);
            
            echo json_encode(['success' => true, 'id' => $conn->lastInsertId()]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    case 'update':
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ?, ra = ?, phone = ? WHERE id = ?");
            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['course'],
                $data['ra'],
                $data['phone'],
                $data['id']
            ]);
            
            echo json_encode(['success' => true]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    case 'delete':
        try {
            $id = $_GET['id'] ?? 0;
            
            $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?> 