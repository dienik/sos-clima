<?php
include '../config/db.php'; 

try {
    // Consulta para obter abrigos e a contagem de abrigados
    $stmt = $pdo->prepare("
        SELECT 
            a.*, 
            COUNT(b.id) AS abrigados_count 
        FROM 
            abrigos a 
        LEFT JOIN 
            abrigado b ON a.id = b.abrigo_id 
        GROUP BY 
            a.id
    ");
    $stmt->execute();

    // Fetch dos resultados
    $abrigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Envio da resposta em formato JSON
    header('Content-Type: application/json');
    echo json_encode($abrigos);
} catch (PDOException $e) {
    // Tratamento de erro
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}
?>
