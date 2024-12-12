<?php
include '../config/db.php';
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

try {
    // Prepare a consulta SQL para excluir o usuário atual
    $stmt = $pdo->prepare("SELECT id, first_name, last_name, email, cpf, phone, isAdmin FROM pessoas WHERE id != :user_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($pessoas);
} catch (PDOException $e) {
    echo json_encode(array("error" => "Erro ao buscar dados: " . $e->getMessage()));
}
?>
