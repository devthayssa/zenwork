<?php
// Ativar exibição de erros para debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$servername = "localhost";  
$username = "root";  
$password = "";  
$dbname = "zenwork";  

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!<br>";
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Formulário enviado.<br>";
    // Obter dados do formulário
    $nome = isset($_POST['username']) ? $_POST['username'] : '';  
    $email = isset($_POST['email']) ? $_POST['email'] : ''; 
    $senha = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';  
    $data_nascimento = isset($_POST['birthdate']) ? $_POST['birthdate'] : NULL;  // Data de nascimento
    $profissao = isset($_POST['profession']) ? $_POST['profession'] : NULL;  // Profissão
    $empresa = isset($_POST['company']) ? $_POST['company'] : NULL;  // Empresa

    // Verificar se os campos obrigatórios não estão vazios
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        // Usar prepared statements para inserir os dados
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, data_nascimento, profissao, empresa) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $email, $senha, $data_nascimento, $profissao, $empresa);

        // Executar a query e verificar se houve sucesso
        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso! <a href='login.html'>Faça login aqui</a>";
        } else {
            echo "Erro ao inserir no banco de dados: " . $stmt->error;
        }

        // Fechar a statement
        $stmt->close();
    } else {
        echo "Erro: Todos os campos obrigatórios devem ser preenchidos.";
    }
}

// Fechar a conexão
$conn->close();
?>
