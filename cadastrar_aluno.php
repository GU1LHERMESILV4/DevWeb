<?php
// Conexão com o banco de dados
$host = 'localhost';
$db   = 'fiap_students';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome   = $_POST['name'] ?? '';
    $email  = $_POST['email'] ?? '';
    $curso  = $_POST['course'] ?? '';
    $ra     = $_POST['ra'] ?? '';
    $fone   = $_POST['phone'] ?? '';

    if ($nome && $email && $curso && $ra && $fone) {
        $stmt = $conn->prepare("INSERT INTO students (name, email, course, ra, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $curso, $ra, $fone);
        if ($stmt->execute()) {
            $mensagem = "Aluno cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Aluno</title>
    <style>
        body { font-family: Arial, sans-serif; background: #111; color: #fff; }
        .container { max-width: 400px; margin: 40px auto; background: #222; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 12px #0008; }
        input, button { width: 100%; padding: 0.7rem; margin-bottom: 1rem; border-radius: 5px; border: none; }
        input { background: #fff; color: #111; }
        button { background: #ed145b; color: #fff; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        button:hover { background: #fff; color: #ed145b; }
        .msg { padding: 0.7rem; border-radius: 5px; margin-bottom: 1rem; text-align: center; }
        .msg.sucesso { background: #28a745; color: #fff; }
        .msg.erro { background: #c4124d; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Aluno</h1>
        <?php if ($mensagem): ?>
            <div class="msg <?php echo (strpos($mensagem, 'sucesso') !== false) ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="name" placeholder="Nome Completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="course" placeholder="Curso" required>
            <input type="text" name="ra" placeholder="RA" required>
            <input type="tel" name="phone" placeholder="Telefone" required>
            <button type="submit">Cadastrar Aluno</button>
        </form>
    </div>
</body>
</html> 