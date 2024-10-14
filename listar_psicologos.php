<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'zenwork');

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter os psicólogos disponíveis
$result = $conn->query("SELECT id_psicologo, nome FROM psicologos");

// Exibir as opções de psicólogos
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id_psicologo']}'>{$row['nome']}</option>";
}

$conn->close();
