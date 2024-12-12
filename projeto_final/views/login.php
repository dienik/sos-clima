<?php

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="body-login">
    <div class="container-login">
        <div class="form-container-login">
            <h1>Login</h1>
            <form action="../controllers/login_process.php" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
