<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento de Consulta</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/agendamento.css">
</head>

<body>
    <h2>Agendar Consulta</h2>
    <form action="agendar.php" method="POST">
        <div class="form-group">
            <label for="id_psicologo">Psicólogo:</label>
            <select name="id_psicologo" required>
                <?php
                // Conectar ao banco para listar psicólogos
                $conn = new mysqli('localhost', 'root', '', 'zenwork');
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT id_psicologo, nome FROM psicologos");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_psicologo']}'>{$row['nome']}</option>";
                }

                $conn->close();
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="data_sessao">Data e Hora:</label>
            <input type="datetime-local" name="data_sessao" required>
        </div>

        <div class="form-group">
            <label for="duracao_minutos">Duração (minutos):</label>
            <input type="number" name="duracao_minutos" required>
        </div>

        <button type="submit">Agendar</button>
    </form>

    <br>
    <a href="index.html">Voltar à Página Inicial</a>
</body>

</html>