<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'zenwork');

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitiza o email
    $senha = $_POST['password'];

    // Consulta para verificar o usuário
    $stmt = $conn->prepare("SELECT id_usuario, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o usuário existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $senha_hash);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $senha_hash)) {
            // Login bem-sucedido, salvar ID do usuário na sessão
            $_SESSION['id_usuario'] = $id_usuario;
            header("Location: agendamento.php"); // Redireciona para a página de agendamento
            exit();
        } else {
            echo "Usuário ou senha incorretos."; // Mensagem genérica
        }
    } else {
        echo "Usuário ou senha incorretos."; // Mensagem genérica
    }

    $stmt->close();
}

$conn->close();
