<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Abrigo</title>
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../css/cadastro_abrigo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="body-register-abrigo">

    <div class="logout-button">
        <span><a href="paginaHome.php"><i class="mdi mdi-home"></i>Home</a></span>
        <a href="?logout=true">
            <i class="mdi mdi-logout"></i> 
            <span>Sair</span>
        </a>
    </div>

    <div class="container-register-abrigo">
        <div class="form-container-register-abrigo">
            <h1>Registrar Novo Abrigo</h1>
            <form id="formCadastroAbrigo" action="../controllers/registrar_abrigo_process.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" required>

                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" required>

                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" required>

                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" required>

                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" required>

                <label for="capacidade_maxima">Capacidade Máxima:</label>
                <input type="number" id="capacidade_maxima" name="capacidade_maxima" required>

                <label for="sugestao_doacao">Sugestão de Doação (Opcional):</label>
                <input type="text" id="sugestao_doacao" name="sugestao_doacao">

                <button type="submit">Registrar Abrigo</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('formCadastroAbrigo').addEventListener('submit', function(event) {
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
                        window.location.href = '../views/paginaHome.php';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao registrar o abrigo.',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>
