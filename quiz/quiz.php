<?php
session_start();

// Perguntas do quiz
$questions = [
    [
        "q" => "Em que ano a FURIA Esports foi fundada?",
        "options" => ["2016", "2017", "2018", "2019"],
        "answer" => 1
    ],
    [
        "q" => "Qual é o país de origem da FURIA?",
        "options" => ["Estados Unidos", "Canadá", "Portugal", "Brasil"],
        "answer" => 3
    ],
    [
        "q" => "Qual destes jogadores é conhecido por ser o capitão e IGL no CS:GO/CS2 da FURIA?",
        "options" => ["saffee", "arT", "yuurih", "KSCERATO"],
        "answer" => 1
    ],
    [
        "q" => "Qual dessas modalidades a FURIA NÃO participou oficialmente até 2025?",
        "options" => ["Rainbow Six Siege", "League of Legends", "Counter-Strike", "Valorant"],
        "answer" => 0
    ],
    [
        "q" => "Em qual desses torneios a FURIA chegou às semifinais de um Major de CS:GO?",
        "options" => ["PGL Major Stockholm 2021", "IEM Katowice 2020", "IEM Rio Major 2022", "BLAST Premier Spring Final 2021"],
        "answer" => 2
    ],
    [
        "q" => "Qual é o apelido de Kaike Cerato, jogador da FURIA?",
        "options" => ["saffee", "drop", "chelo", "KSCERATO"],
        "answer" => 3
    ],
    [
        "q" => "Qual é o nome do projeto educacional da FURIA voltado para formação de novos talentos?",
        "options" => ["FURIA Academy", "FURIA Next", "FURIA Base", "FURIA Future"],
        "answer" => 0
    ],
    [
        "q" => "Em qual região do CBLOL a FURIA compete em League of Legends?",
        "options" => ["NA LCS", "LEC", "CBLOL", "LPL"],
        "answer" => 2
    ],
    [
        "q" => "Qual das frases abaixo representa o espírito da FURIA?",
        "options" => ["Força e Honra", "Avante com Garra", "Sangue nos olhos, fogo no coração", "Pelo Jogo, Pela Nação"],
        "answer" => 2
    ],
    [
        "q" => "Qual destes é um dos fundadores da FURIA?",
        "options" => ["Alexandre “Gaules” Borba", "André Akkari", "Gabriel “FalleN” Toledo", "Felipe “brTT” Gonçalves"],
        "answer" => 1
    ]
];

// Inicializa sessão do quiz
if (!isset($_SESSION['quiz'])) {
    $_SESSION['quiz'] = [
        'order' => array_keys($questions),
        'current' => 0,
        'score' => 0
    ];
    shuffle($_SESSION['quiz']['order']);
}

// Processa resposta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $current = $_SESSION['quiz']['current'];
    $order = $_SESSION['quiz']['order'];
    $qIdx = $order[$current];
    $selected = intval($_POST['answer']);
    if ($selected === $questions[$qIdx]['answer']) {
        $_SESSION['quiz']['score']++;
        $feedback = "<span style='color:green;font-weight:bold;'>Correta!</span>";
    } else {
        $feedback = "<span style='color:red;font-weight:bold;'>Errada!</span> Resposta correta: <b>" . $questions[$qIdx]['options'][$questions[$qIdx]['answer']] . "</b>";
    }
    $_SESSION['quiz']['current']++;
} else {
    $feedback = "";
}

// Exibe resultado final
if ($_SESSION['quiz']['current'] >= count($questions)) {
    $score = $_SESSION['quiz']['score'];
    $total = count($questions);
    echo "<h2>Você acertou $score de $total!</h2>";
    if ($score === $total) {
        echo "<div>PERFEITO! Você é FURIA raiz! 🐆🔥</div>";
    } elseif ($score >= $total * 0.7) {
        echo "<div>Mandou bem! Você conhece muito da FURIA!</div>";
    } elseif ($score >= $total * 0.4) {
        echo "<div>Legal! Mas dá pra saber mais sobre a FURIA!</div>";
    } else {
        echo "<div>Que tal acompanhar mais a FURIA? 😅</div>";
    }
    echo '<form method="post"><button type="submit" name="restart" value="1">Tentar novamente</button></form>';
    // Reinicia quiz se solicitado
    if (isset($_POST['restart'])) {
        session_destroy();
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    exit;
}

// Exibe pergunta atual
$current = $_SESSION['quiz']['current'];
$order = $_SESSION['quiz']['order'];
$qIdx = $order[$current];
$qObj = $questions[$qIdx];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Quiz FURIA</title>
    <style>
        body { font-family: Arial, sans-serif; background: #181818; color: #fff; text-align: center; }
        .quiz-box { background: #232323; padding: 24px; border-radius: 12px; display: inline-block; margin-top: 40px; }
        .question { font-size: 1.2em; margin-bottom: 18px; }
        .answer-btn { display: block; margin: 8px auto; padding: 10px 24px; border-radius: 6px; border: none; background: #222; color: #fff; font-size: 1em; cursor: pointer; transition: background 0.2s; }
        .answer-btn:hover { background: #4caf50; color: #fff; }
        .feedback { margin: 12px 0; font-size: 1.1em; }
        .btn-restart { margin-top: 18px; padding: 10px 24px; border-radius: 6px; border: none; background: #fff200; color: #181818; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="quiz-box">
        <div class="question"><?= htmlspecialchars($qObj['q']) ?></div>
        <form method="post">
            <?php foreach ($qObj['options'] as $idx => $opt): ?>
                <button class="answer-btn" type="submit" name="answer" value="<?= $idx ?>">
                    <?= chr(97 + $idx) ?>) <?= htmlspecialchars($opt) ?>
                </button>
            <?php endforeach; ?>
        </form>
        <?php if ($feedback): ?>
            <div class="feedback"><?= $feedback ?></div>
        <?php endif; ?>
        <div style="margin-top:10px;">Pergunta <?= $current+1 ?> de <?= count($questions) ?></div>
    </div>
</body>
</html>
