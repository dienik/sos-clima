<?php
include '../config/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar entradas
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM pessoas WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            session_start();
            $_SESSION['user_id'] = $user['id']; // Armazenar o ID do usuário na sessão
            $_SESSION['user_name'] = $user['first_name']; // Opcional: armazenar o nome do usuário
            $_SESSION['is_admin'] = $user['isAdmin']; // Armazenar o status de admin na sessão
            
            header("Location: ../views/paginaHome.php");
            exit();
        } else {
            echo 'Email ou senha incorretos. Tente novamente.';
        }
    } catch (PDOException $e) {
        echo 'Erro ao verificar login: ' . $e->getMessage();
    }
}
?>
