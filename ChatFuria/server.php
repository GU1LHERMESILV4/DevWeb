<?php
// Permitir CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Somente aceitar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

// Obter dados do POST
$input = json_decode(file_get_contents('php://input'), true);
$message = isset($input['message']) ? trim($input['message']) : '';

if (!$message) {
    http_response_code(400);
    echo json_encode(['error' => 'Mensagem não fornecida']);
    exit;
}

// Sua chave da OpenAI (coloque sua chave aqui ou use variável de ambiente)
$openai_api_key = getenv('OPENAI_API_KEY');
if (!$openai_api_key) {
    http_response_code(500);
    echo json_encode(['error' => 'Chave da OpenAI não configurada']);
    exit;
}

// Montar payload
$payload = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "user", "content" => $message]
    ]
];

// Fazer requisição para OpenAI
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $openai_api_key",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($response === false || $http_code !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao se comunicar com a OpenAI']);
    curl_close($ch);
    exit;
}
curl_close($ch);

$data = json_decode($response, true);
$chatResponse = $data['choices'][0]['message']['content'] ?? null;

if ($chatResponse) {
    echo json_encode(['response' => $chatResponse]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Resposta inválida da OpenAI']);
}
