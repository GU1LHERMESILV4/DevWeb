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
    <title>Cadastro de Alunos - FIAP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #181818;
            color: #fff;
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background: #000;
            color: #e40c7e;
            padding: 24px 0 16px 0;
            text-align: center;
            box-shadow: 0 2px 8px #0002;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header img {
            height: 48px;
            vertical-align: middle;
            animation: pulse 2s infinite alternate;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                filter: brightness(1);
            }
            100% {
                transform: scale(1.12);
                filter: brightness(1.15);
            }
        }
        header .header-title {
            flex: 1;
            text-align: center;
        }
        header h1 {
            display: inline-block;
            margin: 0;
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: 2px;
            vertical-align: middle;
            color: #e40c7e;
            text-align: center;
        }
        .header-icon {
            height: 24px;
            opacity: 0.5;
        }
        .header-icon.left {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
        }
        .header-icon.right {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
        }
        main {
            max-width: 1000px; /* ainda maior para borda confortável */
            margin: 40px auto 0 auto;
            background: #222;
            border-radius: 12px;
            box-shadow: 0 4px 24px #0004;
            padding: 32px 40px 24px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box; /* garante que padding não cause overflow */
        }
        .form-card {
            width: 100%;
            max-width: 600px;
            background: #181818;
            border-radius: 12px;
            box-shadow: 0 2px 16px #0005;
            padding: 32px 28px 24px 28px;
            margin-bottom: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-card h2 {
            color: #e40c7e;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 18px;
            text-align: center;
            letter-spacing: 1px;
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
        }
        .form-row {
            display: flex;
            gap: 16px;
            width: 100%;
        }
        .form-row input {
            flex: 1;
        }
        form input[type="text"],
        form input[type="email"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e40c7e;
            border-radius: 8px;
            background: #222;
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: border 0.2s;
            box-sizing: border-box;
        }
        form input[type="text"]:focus,
        form input[type="email"]:focus {
            border-color: #fff;
        }
        form input[type="submit"] {
            background: #e40c7e;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 40px;
            font-size: 1.08rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
            align-self: center;
            box-shadow: 0 1px 6px #0003;
            letter-spacing: 1px;
        }
        form input[type="submit"]:hover {
            background: #b80a63;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #181818;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 12px;
            box-shadow: 0 4px 24px #0005;
            font-size: 1.04rem;
            transition: box-shadow 0.2s;
        }
        th, td {
            padding: 16px 12px;
            text-align: center;
            vertical-align: middle;
            min-height: 60px;
            border-bottom: 1px solid #292929;
            transition: background 0.2s, color 0.2s;
        }
        th {
            background: #e40c7e; /* cor sólida, sem degradê */
            color: #fff;
            font-weight: 700;
            border-bottom: 2px solid #fff2;
            font-size: 1.12rem;
            letter-spacing: 1px;
            text-shadow: 0 1px 2px #0008;
        }
        td {
            background: #232323;
            color: #fff;
            font-size: 1.01rem;
        }
        tr:nth-child(even) td {
            background: #181818;
        }
        /* Removido o hover */
        tr:last-child td {
            border-bottom: none;
        }
        .acoes {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            height: 100%;
        }
        .acoes a {
            margin: 0;
            padding: 7px 18px;
            border-radius: 6px;
            background: #e40c7e;
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px #0003;
            text-decoration: none;
            outline: none;
        }
        .acoes a:hover, .acoes a:focus {
            background: #fff;
            color: #e40c7e;
            box-shadow: 0 4px 16px #e40c7e44;
            text-decoration: none;
        }
        .tabela-wrapper {
            width: 100%;
            max-width: 940px; /* menor que o main para criar borda */
            margin-left: auto;;
            margin-right: auto;;
            background: none;
            border-radius: 12px;
            box-sizing: border-box;
            margin-bottom: 0;
            margin-top: 0;ckground 0.2s, color 0.2s;
            padding-bottom: 0;4px #0002;
            display: flex;
            flex-direction: column;
            align-items: center; /* centraliza o conteúdo interno */
        }   color: #e40c7e;
        .tabela-wrapper table {ne;
            margin-top: 0;
            width: 100%;{
            /* opcional: max-width: 100%; */
        }   max-width: 940px; /* menor que o main para criar borda */
        @media (max-width: 1000px) {
            main, .tabela-wrapper {
                max-width: 100%;
                padding-left: 0;
                padding-right: 0;x;
            }argin-bottom: 0;
            main {-top: 0;
                padding: 8px 2vw;
            }isplay: flex;
            .form-card {on: column;
                padding: 16px 6vw 12px 6vw;iza o conteúdo interno */
            }
            .form-row { table {
                flex-direction: column;
                gap: 10px;
            }* opcional: max-width: 100%; */
            form input[type="text"],
            form input[type="email"] {
                max-width: 100%;r {
            }   max-width: 100%;
            .tabela-wrapper { 0;
                max-width: 100%;;
                padding: 0;
            }ain {
        }       padding: 8px 2vw;
        footer {
            background: #111;
            color: #fff; 16px 6vw 12px 6vw;
            text-align: center;
            padding: 18px 0 10px 0;
            margin-top: 40px;n: column;
            font-size: 1rem;
            letter-spacing: 1px;
        }   form input[type="text"],
    </style>
</head>
<body>
    <header>
        <img src="images/FIAP_logo.jpg" alt="FIAP Logo" style="margin-left:24px;">
        <div class="header-title">
            <h1>Sistema de Cadastro de Alunos</h1>
        </div>
        <img src="images/FIAP_logo.jpg" alt="FIAP Logo" style="margin-right:24px;">
    </header>
    <main>
        <div class="form-card">
            <h2><?= $alunoEdit ? "Editar Aluno" : "Novo Aluno" ?></h2>
            <form method="POST" action="<?= $alunoEdit ? 'update.php' : 'create.php' ?>">
                <?php if ($alunoEdit): ?>
                    <input type="hidden" name="id" value="<?= $alunoEdit['id'] ?>">
                <?php endif; ?>
                <div class="form-row">
                    <input type="text" name="nome" placeholder="Nome" required value="<?= $alunoEdit['nome'] ?? '' ?>">
                    <input type="text" name="ra" placeholder="RA" required value="<?= $alunoEdit['ra'] ?? '' ?>">
                </div>
                <div class="form-row">
                    <input type="text" name="telefone" placeholder="Telefone" required value="<?= $alunoEdit['telefone'] ?? '' ?>">
                    <input type="email" name="email" placeholder="Email" required value="<?= $alunoEdit['email'] ?? '' ?>">
                </div>
                <input type="text" name="curso" placeholder="Curso" required value="<?= $alunoEdit['curso'] ?? '' ?>">
                <input type="submit" value="<?= $alunoEdit ? "Atualizar" : "Cadastrar" ?>">
            </form>
        </div>
        <div class="tabela-wrapper">
            <h2 style="margin-top:0; margin-bottom:12px; text-align:center;">Alunos Cadastrados</h2>
            <table border="0" cellpadding="8">
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
                        <td class="acoes">
                            <a href="?edit=<?= $aluno['id'] ?>">Editar</a>
                            <a href="#" 
                               onclick="openDeleteModal('<?= $aluno['id'] ?>', '<?= htmlspecialchars($aluno['nome'], ENT_QUOTES) ?>'); return false;">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
    <footer>
        &copy; <?= date('Y') ?> FIAP - Sistema de Cadastro de Alunos
    </footer>
    <div id="delete-modal" class="modal-bg" style="display:none;">
        <div class="modal-content">
            <h3>Excluir Aluno</h3>
            <p id="delete-msg"></p>
            <div class="modal-actions">
                <button onclick="closeDeleteModal()" class="btn-cancel">Cancelar</button>
                <a id="delete-confirm-btn" href="#" class="btn-delete">Excluir</a>
            </div>
        </div>
    </div>
    <style>
    .modal-bg {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.65);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeInBg 0.2s;
    }
    @keyframes fadeInBg {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .modal-content {
        background: #232323;
        border-radius: 14px;
        box-shadow: 0 8px 32px #000a;
        padding: 32px 28px 22px 28px;
        min-width: 320px;
        max-width: 90vw;
        color: #fff;
        text-align: center;
        animation: popIn 0.2s;
    }
    @keyframes popIn {
        from { transform: scale(0.92); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-content h3 {
        color: #e40c7e;
        margin-top: 0;
        margin-bottom: 14px;
        font-size: 1.3rem;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .modal-content p {
        margin-bottom: 24px;
        font-size: 1.08rem;
        color: #fff;
    }
    .modal-actions {
        display: flex;
        justify-content: center;
        gap: 18px;
    }
    .btn-cancel, .btn-delete {
        padding: 10px 28px;
        border-radius: 7px;
        border: none;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px #0003;
        outline: none;
    }
    .btn-cancel {
        background: #232323;
        color: #fff;
        border: 1.5px solid #e40c7e;
    }
    .btn-cancel:hover, .btn-cancel:focus {
        background: #181818;
        color: #e40c7e;
    }
    .btn-delete {
        background: #e40c7e;
        color: #fff;
        border: none;
    }
    .btn-delete:hover, .btn-delete:focus {
        background: #fff;
        color: #e40c7e;
        box-shadow: 0 4px 16px #e40c7e44;
    }
    </style>
    <script>
    function openDeleteModal(id, nome) {
        document.getElementById('delete-msg').innerHTML =
            `Tem certeza que deseja excluir o aluno:<br><strong style="color:#e40c7e">${nome}</strong><br><br><span style="font-size:0.97em;color:#ffb3d1;">Esta ação não poderá ser desfeita!</span>`;
        document.getElementById('delete-confirm-btn').href = 'delete.php?id=' + encodeURIComponent(id);
        document.getElementById('delete-modal').style.display = 'flex';
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').style.display = 'none';
    }
    // Fecha modal ao apertar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeDeleteModal();
    });
    </script>
</body>
</html>
