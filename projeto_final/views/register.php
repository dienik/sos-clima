<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="body-register">
    
    <div class="container-register">
        <div class="form-container-register">
            <h1>Cadastro</h1>
            <form id="formCadastro" action="../controllers/register_process.php" method="post">
                <label for="first-name">Nome:</label>
                <input type="text" id="first-name" name="first_name" required>

                <label for="last-name">Sobrenome:</label>
                <input type="text" id="last-name" name="last_name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>

                <label for="phone">Número de Telefone:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm-password">Repita a Senha:</label>
                <input type="password" id="confirm-password" name="confirm_password" required>

                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('formCadastro').addEventListener('submit', function(event) {
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
                        window.location.href = '../views/login.php';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao enviar o formulário.',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>
