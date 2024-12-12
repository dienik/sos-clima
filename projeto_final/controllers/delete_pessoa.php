<?php
include '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $userId = $data['id'];

    try {
        // Preparar e executar a exclusão
        $stmt = $pdo->prepare("DELETE FROM pessoas WHERE id = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Verificar se a exclusão foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            echo json_encode(array("message" => "Usuário excluído com sucesso."));
        } else {
            echo json_encode(array("error" => "Usuário não encontrado."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => "Erro ao excluir usuário: " . $e->getMessage()));
    }
} else {
    echo json_encode(array("error" => "ID do usuário não fornecido."));
}
?>
