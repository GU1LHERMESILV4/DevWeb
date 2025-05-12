<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $sql = "UPDATE alunos SET nome=?, ra=?, telefone=?, email=?, curso=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nome'],
        $_POST['ra'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['curso'],
        $_POST['id']
    ]);
    header("Location: index.php");
    exit;
}
?>
