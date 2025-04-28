<?php 
$username = $_SESSION['username'] ?? '';
$isAdmin = $_SESSION['role'] === 'admin' ? 'true' : 'false';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <div class="chat-container">
        <header>
            <h1>Пользователь: <?= htmlspecialchars($username) ?></h1>
            <a href="/logout" class="logout-btn">Logout</a>
        </header>
        
        <div class="messages" id="messages">

        </div>
        
        <div class="message-form">
            <input type="text" id="message-input" placeholder="Type your message...">
            <button id="send-btn">Отправить</button>
        </div>
    </div>
    <script>
        const currentUser = {
            username: '<?= $username ?>',
            isAdmin: <?= $isAdmin ?>
        };
    </script>
    <script src="/assets/chat.js"></script>
</body>
</html>