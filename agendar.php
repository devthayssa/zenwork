<?php
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    die("Você precisa estar logado para agendar uma consulta.");
}

$id_usuario = $_SESSION['id_usuario']; // Obtendo ID do usuário logado

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'zenwork');

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_psicologo = $_POST['id_psicologo'];
    $data_sessao = $_POST['data_sessao'];
    $duracao_minutos = $_POST['duracao_minutos'];

    // Inserir no banco de dados
    $stmt = $conn->prepare("INSERT INTO sessao_atendimento (id_psicologo, id_usuario, data_sessao, duracao_minutos) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $id_psicologo, $id_usuario, $data_sessao, $duracao_minutos);

    if ($stmt->execute()) {
        echo "Consulta agendada com sucesso!";
    } else {
        echo "Erro ao agendar: " . $stmt->error;
    }

    $stmt->close();
}

// Adicionando a opção de voltar
echo '<br><a href="exibir_psicologos.php">Voltar</a>'; // Altere para o nome da página anterior

$conn->close();
?>
