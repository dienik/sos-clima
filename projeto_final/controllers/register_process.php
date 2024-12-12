<?php
include '../config/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = ["success" => false, "message" => ""];

    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password']; 

    if ($password !== $confirm_password) {
        $response["message"] = 'As senhas não correspondem. Tente novamente.';
        echo json_encode($response);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO pessoas (first_name, last_name, email, cpf, phone, senha) VALUES (:first_name, :last_name, :email, :cpf, :phone, :senha)");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':senha', $hashed_password); 

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Cadastro realizado com sucesso!";
        } else {
            $response["message"] = "Erro ao cadastrar.";
        }
    } catch (PDOException $e) {
        $response["message"] = 'Erro ao inserir,: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}
?>
