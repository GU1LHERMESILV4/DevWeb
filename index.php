<?php
require 'db.php';

$alunoEdit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM alunos WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $alunoEdit = $stmt->fetch();
}

$stmt = $pdo->query("SELECT * FROM alunos ORDER BY id DESC");
$alunos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2><?= $alunoEdit ? "Editar Aluno" : "Novo Aluno" ?></h2>
    <form method="POST" action="<?= $alunoEdit ? 'update.php' : 'create.php' ?>">
        <?php if ($alunoEdit): ?>
            <input type="hidden" name="id" value="<?= $alunoEdit['id'] ?>">
        <?php endif; ?>
        <input type="text" name="nome" placeholder="Nome" required value="<?= $alunoEdit['nome'] ?? '' ?>">
        <input type="text" name="ra" placeholder="RA" required value="<?= $alunoEdit['ra'] ?? '' ?>">
        <input type="text" name="telefone" placeholder="Telefone" required value="<?= $alunoEdit['telefone'] ?? '' ?>">
        <input type="email" name="email" placeholder="Email" required value="<?= $alunoEdit['email'] ?? '' ?>">
        <input type="text" name="curso" placeholder="Curso" required value="<?= $alunoEdit['curso'] ?? '' ?>">
        <input type="submit" value="<?= $alunoEdit ? "Atualizar" : "Cadastrar" ?>">
    </form>

    <h2>Alunos Cadastrados</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>RA</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($alunos as $aluno): ?>
            <tr>
                <td><?= htmlspecialchars($aluno['nome']) ?></td>
                <td><?= htmlspecialchars($aluno['ra']) ?></td>
                <td><?= htmlspecialchars($aluno['telefone']) ?></td>
                <td><?= htmlspecialchars($aluno['email']) ?></td>
                <td><?= htmlspecialchars($aluno['curso']) ?></td>
                <td>
                    <a href="?edit=<?= $aluno['id'] ?>">Editar</a> |
                    <a href="delete.php?id=<?= $aluno['id'] ?>" onclick="return confirm('Deseja excluir este aluno?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
