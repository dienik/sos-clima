<?php
include '../config/db.php'; 

try {
 
    $stmt = $pdo->prepare("SELECT id, nome, cidade FROM abrigos");
    $stmt->execute();

    
    $abrigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    header('Content-Type: application/json');
    echo json_encode($abrigos);
} catch (PDOException $e) {
    
    http_response_code(500); 
    echo json_encode(['error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}
?>
