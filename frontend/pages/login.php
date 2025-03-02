<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 400px;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="card-title">Login</h4>
            </div>
            <div class="card-body">
                <form id="formLogin">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control form-control-sm" id="senha" name="senha" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-sm">Entrar</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#formLogin').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '../../backend/controllers/login.php', // Verifique esse caminho
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response === "success") {
                            window.location.href = 'dashboard.php'; // Verifique esse caminho
                        } else {
                            alert("E-mail ou senha incorretos.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro na requisição AJAX:", error);
                        alert("Erro ao tentar fazer login. Tente novamente.");
                    }
                });
            });
        });
    </script>
</body>
</html>