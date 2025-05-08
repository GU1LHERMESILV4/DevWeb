<?php
require_once 'config.php';

// Create
function createCharacter($name, $description, $image_url) {
    global $pdo;
    $sql = "INSERT INTO characters (name, description, image_url) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$name, $description, $image_url]);
}

// Read
function getAllCharacters() {
    global $pdo;
    $sql = "SELECT * FROM characters";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCharacter($id) {
    global $pdo;
    $sql = "SELECT * FROM characters WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update
function updateCharacter($id, $name, $description, $image_url) {
    global $pdo;
    $sql = "UPDATE characters SET name = ?, description = ?, image_url = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$name, $description, $image_url, $id]);
}

// Delete
function deleteCharacter($id) {
    global $pdo;
    $sql = "DELETE FROM characters WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                createCharacter($_POST['name'], $_POST['description'], $_POST['image_url']);
                break;
            case 'update':
                updateCharacter($_POST['id'], $_POST['name'], $_POST['description'], $_POST['image_url']);
                break;
            case 'delete':
                deleteCharacter($_POST['id']);
                break;
        }
        header('Location: index.php');
        exit();
    }
}
?> 