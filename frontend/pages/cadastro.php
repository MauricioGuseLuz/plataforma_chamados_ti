<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/styles.css" rel="stylesheet"> <!-- Link para o seu arquivo CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg" style="width: 350px;"> <!-- Reduzi o tamanho do card -->
            <div class="card-header bg-primary text-white text-center">
                <h4 class="card-title">Cadastro</h4>
            </div>
            <div class="card-body">
                <!-- Área para exibir mensagens -->
                <div id="mensagem"></div>

                <form id="formCadastro">
                    <div class="mb-2"> <!-- Reduzi o espaçamento entre os campos -->
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control form-control-sm" id="nome" name="nome" required>
                    </div>
                    <div class="mb-2">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control form-control-sm" id="data_nascimento" name="data_nascimento" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                        <div id="emailErro" class="text-danger"></div>
                    </div>
                    <div class="mb-2">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control form-control-sm" id="telefone" name="telefone" required>
                    </div>
                    <div class="mb-2">
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" class="form-control form-control-sm" id="whatsapp" name="whatsapp" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control form-control-sm" id="senha" name="senha" required>
                    </div>
                    <div class="mb-2">
                        <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control form-control-sm" id="confirmar_senha" name="confirmar_senha" required>
                    </div>
                    <div class="mb-2">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control form-control-sm" id="estado" name="estado" required>
                            <option value="">Selecione</option>
                            <option value="SP">São Paulo</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <!-- Adicione mais estados -->
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="cidade" class="form-label">Cidade</label>
                        <select class="form-control form-control-sm" id="cidade" name="cidade" required>
                            <option value="">Selecione o estado primeiro</option>
                        </select>
                    </div>
                    <div class="d-grid gap-1"> <!-- Reduzi o espaçamento entre os botões -->
                        <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                        <a href="login.php" class="btn btn-secondary btn-sm">Voltar para o Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#estado').change(function() {
                var estado = $(this).val();
                $.ajax({
                    url: '../../backend/controllers/get_cidades.php',
                    method: 'POST',
                    data: { estado: estado },
                    success: function(response) {
                        $('#cidade').html(response);
                    }
                });
            });

            // Máscaras de telefone e WhatsApp
            $('#telefone, #whatsapp').mask('(00) 00000-0000');

            $('#formCadastro').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '../../backend/controllers/cadastro.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log("Resposta do backend:", response);
                        if (response.status === "success") {
                            $("#mensagem").html('<div class="alert alert-success">' + response.message + '</div>');
                            setTimeout(function() {
                                window.location.href = 'login.php';
                            }, 5000);
                        } else {
                            $("#mensagem").html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro na requisição:", xhr.responseText);
                        console.error("Código de status HTTP:", xhr.status);
                        $("#mensagem").html('<div class="alert alert-danger">Erro na requisição.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>