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
    <title>Listar Abrigados</title>
    <link rel="stylesheet" href="../css/listar_abrigados.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
</head>
<body class="body-listar-abrigados">

<div class="logout-button">
        <span><a href="paginaHome.php"><i class="mdi mdi-home"></i>Home</a></span>
        <a href="?logout=true">
            <i class="mdi mdi-logout"></i>
            <span>Sair</span>
        </a>
    </div>
    <div class="container-listar-abrigados">
        <div class="search-container">
            <input type="text" id="nome" placeholder="Nome">
            <input type="text" id="sobrenome" placeholder="Sobrenome">
            <button id="search-button"><i class="mdi mdi-magnify"></i> Buscar</button>
        </div>

        <div class="table-container">
            <h1>Lista de Abrigados</h1>
            <table id="abrigados-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Cidade de Origem</th>
                        <th>Nome do Abrigo</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function carregarAbrigados(nome = '', sobrenome = '') {
            fetch(`../controllers/get_abrigados.php?nome=${encodeURIComponent(nome)}&sobrenome=${encodeURIComponent(sobrenome)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#abrigados-table tbody');
                    tableBody.innerHTML = '';

                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="4">Nenhum abrigado encontrado.</td></tr>';
                    } else {
                        data.forEach(abrigado => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td data-label="Nome">${abrigado.nome}</td>
                                <td data-label="Sobrenome">${abrigado.sobrenome}</td>
                                <td data-label="Cidade de Origem">${abrigado.cidade_origem}</td>
                                <td data-label="Nome do Abrigo">${abrigado.nome_abrigo}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar os dados:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Carregar todos os abrigados ao iniciar
            carregarAbrigados();

            const searchButton = document.getElementById('search-button');

            searchButton.addEventListener('click', () => {
                const nome = document.getElementById('nome').value.trim();
                const sobrenome = document.getElementById('sobrenome').value.trim();

                carregarAbrigados(nome, sobrenome);
            });
        });
    </script>
</body>
</html>
