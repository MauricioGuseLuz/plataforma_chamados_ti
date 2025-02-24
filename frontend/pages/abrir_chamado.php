<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Chamado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Plataforma de Chamados</a>
            <div class="navbar-nav">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="http://localhost/chamados_ti/backend/controllers/logout.php">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Abrir Chamado</h2>
        <form id="formChamado">
            <div class="mb-3">
                <label for="tipo_incidente" class="form-label">Tipo de Incidente</label>
                <select class="form-control" id="tipo_incidente" name="tipo_incidente" required>
                    <option value="">Selecione</option>
                    <option value="Problema de Hardware">Problema de Hardware</option>
                    <option value="Problema de Software">Problema de Software</option>
                    <option value="Problema de Rede">Problema de Rede</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição do Problema</label>
                <textarea id="descricao" name="descricao" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="anexos" class="form-label">Anexos</label>
                <input type="file" class="form-control" id="anexos" name="anexos[]" multiple>
            </div>
            <div class="mb-3">
                <label for="contatos" class="form-label">Contatos</label>
                <div id="contatos">
                    <div class="contato mb-2">
                        <input type="text" class="form-control mb-2" name="contato_nome[]" placeholder="Nome" required>
                        <input type="text" class="form-control mb-2" name="contato_telefone[]" placeholder="Telefone" required>
                        <input type="text" class="form-control" name="contato_observacao[]" placeholder="Observação">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="adicionarContato">Adicionar Contato</button>
            </div>
            <button type="submit" class="btn btn-primary">Abrir Chamado</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Inicializa o Summernote
            $('#descricao').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol']],
                ]
            });

            // Adiciona mais campos de contato
            $('#adicionarContato').click(function() {
                $('#contatos').append(`
                    <div class="contato mb-2">
                        <input type="text" class="form-control mb-2" name="contato_nome[]" placeholder="Nome" required>
                        <input type="text" class="form-control mb-2" name="contato_telefone[]" placeholder="Telefone" required>
                        <input type="text" class="form-control" name="contato_observacao[]" placeholder="Observação">
                    </div>
                `);
            });

            // Submissão do formulário
            $('#formChamado').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: '../../backend/controllers/abrir_chamado.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response);
                        window.location.href = 'dashboard.php';
                    }
                });
            });
        });
    </script>
</body>
</html>