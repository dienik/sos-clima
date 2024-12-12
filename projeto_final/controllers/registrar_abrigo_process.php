<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ajuda_emergencial"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $capacidade_maxima = $_POST['capacidade_maxima'];
    $sugestao_doacao = $_POST['sugestao_doacao'];

    $sql = "INSERT INTO abrigos (nome, estado, cidade, bairro, rua, numero, capacidade_maxima, sugestao_doacao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssis", $nome, $estado, $cidade, $bairro, $rua, $numero, $capacidade_maxima, $sugestao_doacao);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Abrigo registrado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
