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
    <title>Ajuda Emergencial</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
</head>

<body class="body-home">
    <div class="container-home">
        <div class="header-home">
            <h1>Ajuda Emergencial</h1>
            <p>Apoie as vítimas de desastres naturais. Sua ajuda faz a diferença.</p>
        </div>
        <div class="cards-home">
            <div class="card">
                <h2>Cadastrar Pessoas</h2>
                <p>Registre informações de pessoas que precisam de ajuda.</p>
                <button><a href="cadastrar_pessoas.php">Cadastrar</a></button>
            </div>
            <div class="card">
                <h2>Encontrar Pessoas</h2>
                <p>Busque por pessoas desaparecidas ou localize familiares.</p>
                <button><a href="listar_abrigados.php">Buscar</a></button>
            </div>
            <div class="card">
                <h2>Cadastrar Abrigos</h2>
                <p>Informe a localização e detalhes de novos abrigos disponíveis.</p>
                <button><a href="register_abrigo.php">Cadastrar</a></button>
            </div>
            <div class="card">
                <h2>Encontrar Abrigos</h2>
                <p>Encontre abrigos próximos para se abrigar em segurança.</p>
                <button><a href="listar_abrigos.php">Buscar</a></button>
            </div>
        </div>
    </div>
    
    <div class="admin-button">
        <a href="listar_pessoas.php">
            <i class="mdi mdi-account-cog-outline"></i>
            <span>Administração</span>
        </a>
    </div>
    
    <div class="logout-button">
        <a href="?logout=true">
            <i class="mdi mdi-logout"></i>
            <span>Sair</span>
        </a>
    </div>

    <script>
        
        // Verificar se a variável PHP está definida e tem o valor correto
        <?php if (isset($_SESSION['is_admin'])): ?>
            const isAdmin = <?php echo json_encode($_SESSION['is_admin'])  ?>;
            const admin = isAdmin == 1 ? true : false;
           
            localStorage.setItem('isAdmin', admin)
        <?php endif; ?>
        document.addEventListener('DOMContentLoaded', () => {
            const isAdmin = localStorage.getItem('isAdmin') === 'true';
            
            if (isAdmin) {
                document.querySelector('.admin-button').style.display = 'block';
            } else {
                document.querySelector('.admin-button').style.display = 'none';
            }
        });
    </script>
</body>
</html>
