<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO alunos (nome, ra, telefone, email, curso) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nome'],
        $_POST['ra'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['curso']
    ]);
    header("Location: index.php");
    exit;
}
?>
