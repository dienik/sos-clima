<?php
include '../config/db.php'; // Inclua o arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array("success" => false, "message" => "");

    if (isset($_FILES['csv_file'])) {
      
        $file = $_FILES['csv_file']['tmp_name'];

       

        if (($handle = fopen($file, "r")) !== FALSE) {
          
            fgetcsv($handle, 1000, ",");

         
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $nome = $data[0];
                $sobrenome = $data[1];
                $cidade_origem = $data[2];
                $abrigo_nome = $data[3];

                try {
                  
                    $stmt = $pdo->prepare("SELECT id FROM abrigos WHERE nome = :nome");
                    $stmt->bindParam(':nome', $abrigo_nome);
                    $stmt->execute();
                    $abrigo = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($abrigo) {
                        $abrigo_id = $abrigo['id'];

                       
                        $stmt = $pdo->prepare("INSERT INTO abrigado (nome, sobrenome, cidade_origem, abrigo_id) VALUES (:nome, :sobrenome, :cidade_origem, :abrigo_id)");
                        $stmt->bindParam(':nome', $nome);
                        $stmt->bindParam(':sobrenome', $sobrenome);
                        $stmt->bindParam(':cidade_origem', $cidade_origem);
                        $stmt->bindParam(':abrigo_id', $abrigo_id);
                        $stmt->execute();
                    } else {
                        $response["message"] = "Abrigo não encontrado para o abrigo: $abrigo_nome";
                    }
                } catch (PDOException $e) {
                    $response["message"] = "Erro ao cadastrar pessoa: " . $e->getMessage();
                }
            }
            fclose($handle);
            $response["success"] = true;
            $response["message"] = "Upload e inserção do CSV concluídos!";
        } else {
            $response["message"] = "Erro ao abrir o arquivo.";
        }
    } else {
        
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $cidade_origem = $_POST['cidade_origem'];
        $abrigo_nome = $_POST['abrigo'];

        try {
            
            $stmt = $pdo->prepare("SELECT id FROM abrigos WHERE nome = :nome");
            $stmt->bindParam(':nome', $abrigo_nome);
            $stmt->execute();
            $abrigo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($abrigo) {
                $abrigo_id = $abrigo['id'];

               
                $stmt = $pdo->prepare("INSERT INTO abrigado (nome, sobrenome, cidade_origem, abrigo_id) VALUES (:nome, :sobrenome, :cidade_origem, :abrigo_id)");
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':sobrenome', $sobrenome);
                $stmt->bindParam(':cidade_origem', $cidade_origem);
                $stmt->bindParam(':abrigo_id', $abrigo_id);
                $stmt->execute();

                $response["success"] = true;
                $response["message"] = "Cadastro realizado com sucesso!";
            } else {
                $response["message"] = "Abrigo não encontrado.";
            }
        } catch (PDOException $e) {
            $response["message"] = "Erro ao cadastrar pessoa: " . $e->getMessage();
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    http_response_code(405); 
    echo json_encode(array("success" => false, "message" => "Método não permitido"));
    exit;
}
?>
