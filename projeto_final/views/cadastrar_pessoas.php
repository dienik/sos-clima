<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pessoas</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <style>
    
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="body-cadastro">

    <div class="home-button-cadastro">
        <a href="paginaHome.php">
            <i class="mdi mdi-home"></i>
            <span>Home</span>
        </a>
    </div>
    
    <div class="logout-button-cadastro">
        <a href="?logout=true">
            <i class="mdi mdi-logout"></i>
            <span>Sair</span>
        </a>
    </div>

    <div class="container-cadastro">
        <div class="card-cadastro">
            <h2>Cadastrar uma Pessoa</h2>
            <form id="formCadastrarPessoa" action="../controllers/register_pessoas.php" method="post">
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="text" name="sobrenome" placeholder="Sobrenome" required>
                <input type="text" name="cidade_origem" placeholder="Cidade de origem" required>
                <select name="abrigo" id="abrigo" required>
                    <option value="">Selecione um abrigo</option>
                </select>
                <button type="submit">Cadastrar</button>
            </form>
        </div>

        <div class="card-cadastro">
            <h2>Upload de CSV</h2>
            <form id="formUploadCSV" action="../controllers/register_pessoas.php" method="post" enctype="multipart/form-data">
                <input type="file" name="csv_file" accept=".csv" required>
                <button type="submit">Fazer Upload</button>
            </form>
            <div class="download-button">
                <a href="../controllers/download_csv.php">
                    <button>Baixar CSV Exemplo</button>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('../controllers/select_abrigo.php')
                .then(response => response.json())
                .then(data => {
                    const selectAbrigo = document.getElementById('abrigo');
                    data.forEach(abrigos => {
                        const option = document.createElement('option');
                        option.value = abrigos.nome; 
                        option.textContent = `${abrigos.nome} - ${abrigos.cidade}`;
                        selectAbrigo.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao carregar abrigos:', error));

            document.getElementById('formCadastrarPessoa').addEventListener('submit', handleFormSubmit);
            document.getElementById('formUploadCSV').addEventListener('submit', handleFormSubmit);
        });

        function handleFormSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Sucesso' : 'Erro',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao enviar o formulário.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
            });
        }
    </script>

</body>
</html>
