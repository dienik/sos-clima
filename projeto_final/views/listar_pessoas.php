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
    <title>Listar Pessoas</title>
    <link rel="stylesheet" href="../css/listar_pessoas.css"> <!-- Seu CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
   
</head>
<body class="body-listar-pessoas">
<div class="logout-button">
        <span><a href="paginaHome.php"><i class="mdi mdi-home"></i>Home</a></span>
        <a href="?logout=true">
            <i class="mdi mdi-logout"></i>
            <span>Sair</span>
        </a>
    </div>
    <div class="container-listar-pessoas">
        <h1>Lista de Pessoas</h1>
        <table id="pessoas-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Admin</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
              
            </tbody>
        </table>
    </div>

   
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <p>Você tem certeza que deseja excluir este usuário?</p>
            <button id="confirm-delete">Sim</button>
            <button id="cancel-delete">Não</button>
        </div>
    </div>
 
    <script>
         document.addEventListener('DOMContentLoaded', () => {
        fetch('../controllers/get_pessoas.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#pessoas-table tbody');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6">Nenhuma pessoa encontrada.</td></tr>';
                } else {
                    data.forEach(pessoa => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${pessoa.first_name}</td>
                            <td>${pessoa.last_name}</td>
                            <td>${pessoa.email}</td>
                            <td>${pessoa.cpf}</td>
                            <td>${pessoa.phone}</td>
                            <td>${pessoa.isAdmin == 0 ? "Não" : "Sim"}</td>
                               
                            <td class="action-buttons">
                                <a href="#" class="delete" data-id="${pessoa.id}"><i class="mdi mdi-delete"></i> Excluir</a>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });

                    
                    document.querySelectorAll('.delete').forEach(button => {
                        button.addEventListener('click', (event) => {
                            event.preventDefault();
                            pessoaIdToDelete = button.getAttribute('data-id');
                            document.getElementById('confirmation-modal').style.display = 'flex';
                        });
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao buscar os dados:', error);
            });

        // Função para confirmar a exclusão
        document.getElementById('confirm-delete').addEventListener('click', () => {
            if (pessoaIdToDelete) {
                fetch('../controllers/delete_pessoa.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: pessoaIdToDelete })
                })
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    document.getElementById('confirmation-modal').style.display = 'none';
                    location.reload();
                })
                .catch(error => {
                    console.error('Erro ao excluir o registro:', error);
                });
            }
        });

        // Função para cancelar a exclusão
        document.getElementById('cancel-delete').addEventListener('click', () => {
            document.getElementById('confirmation-modal').style.display = 'none';
        });

        // Fechar o modal ao clicar no "x"
        document.querySelector('.close-modal').addEventListener('click', () => {
            document.getElementById('confirmation-modal').style.display = 'none';
        });
    });
    </script>
</body>
</html>
