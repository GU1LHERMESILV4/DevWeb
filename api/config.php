<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fiap_students');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($mensagem && strpos($mensagem, 'sucesso') !== false): ?>
    <div class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="this.parentElement.parentElement.style.display='none';">&times;</span>
            <h2>Sucesso!</h2>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
        </div>
    </div>
<?php endif; ?>
?> 