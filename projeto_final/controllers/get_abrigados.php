<?php
include '../config/db.php';

$nome = isset($_GET['nome']) ? $_GET['nome'] : '';
$sobrenome = isset($_GET['sobrenome']) ? $_GET['sobrenome'] : '';

try {
    // Usar JOIN para buscar o nome do abrigo a partir do ID
    $stmt = $pdo->prepare("
        SELECT 
            a.nome, 
            a.sobrenome, 
            a.cidade_origem, 
            b.nome AS nome_abrigo
        FROM 
            abrigado a
        JOIN 
            abrigos b ON a.abrigo_id = b.id
        WHERE 
            a.nome LIKE :nome 
            AND a.sobrenome LIKE :sobrenome
    ");
    $stmt->bindValue(':nome', "%$nome%");
    $stmt->bindValue(':sobrenome', "%$sobrenome%");
    $stmt->execute();
    $abrigados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($abrigados);
} catch (PDOException $e) {
    echo json_encode(array("error" => "Erro ao buscar dados: " . $e->getMessage()));
}
?>