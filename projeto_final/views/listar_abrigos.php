<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Abrigos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../css/listar_abrigos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: black; 
            margin: 0;
            padding: 0;
        }
        .container-listar-abrigos {
            display: flex;
            flex-direction: column; 
            align-items: center; 
            padding: 20px;
        }
        .title {
            margin-bottom: 20px;
        }
        #abrigos-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 1200px; 
            margin: 0 auto;
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: black; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 250px;
            transition: transform 0.2s;
            position: relative; 
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h2 {
            font-size: 20px;
            margin: 0;
        }
        .card p {
            margin: 5px 0;
        }
        .status-indicator {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block; 
            margin-left: 5px;
            vertical-align: middle; 
        }
        .status-green {
            background-color: green;
        }
        .status-red {
            background-color: red;
        }
        .logout-button {
            margin: 20px;
        }
    </style>
</head>
<body class="body-listar-abrigos">

    <div class="logout-button">
        <span><a href="paginaHome.php"><i class="mdi mdi-home"></i>Home</a></span>
        <a href="?logout=true">
            <i class="mdi mdi-logout"></i>
            <span>Sair</span>
        </a>
    </div>

    <div class="container-listar-abrigos">
        <h1 class="title">Lista de Abrigos Cadastrados</h1>
        <div id="abrigos-cards">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('../controllers/get_abrigos.php')
                .then(response => response.json())
                .then(data => {
                    const cardsContainer = document.querySelector('#abrigos-cards');
                    cardsContainer.innerHTML = '';
                    
                    if (data.length === 0) {
                        cardsContainer.innerHTML = '<p>Nenhum abrigo cadastrado.</p>';
                    } else {
                        data.forEach(abrigos => {
                            const card = document.createElement('div');
                            card.className = 'card';

                            const statusClass = (abrigos.capacidade_maxima <= abrigos.abrigados_count) ? 'status-red' : 'status-green';

                            card.innerHTML = `
                                <h2>${abrigos.nome}</h2>
                                <p><strong>Estado:</strong> ${abrigos.estado}</p>
                                <p><strong>Cidade:</strong> ${abrigos.cidade}</p>
                                <p><strong>Bairro:</strong> ${abrigos.bairro}</p>
                                <p><strong>Rua:</strong> ${abrigos.rua}</p>
                                <p><strong>Número:</strong> ${abrigos.numero}</p>
                                <p><strong>Capacidade Máxima:</strong> ${abrigos.capacidade_maxima} <span class="status-indicator ${statusClass}"></span></p>
                                <p><strong>Sugestão de Doação:</strong> ${abrigos.sugestao_doacao}</p>
                                <p><strong>Abrigados:</strong> ${abrigos.abrigados_count || 0}</p>
                            `;
                            cardsContainer.appendChild(card);
                        });
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar os dados:', error);
                });
        });
    </script>
</body>
</html>
