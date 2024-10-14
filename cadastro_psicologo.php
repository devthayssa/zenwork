<?php
// Conexão com o banco de dados 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenwork"; // Nome correto do banco

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão 
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $registro_profissional = $_POST['registro_profissional'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $bio = $_POST['bio'];

    // Upload da foto
    $foto = $_FILES['foto'];
    $foto_nome = uniqid() . '_' . basename($foto['name']);
    $foto_temp = $foto['tmp_name'];
    $foto_pasta = 'uploads/' . $foto_nome;

    // Verifica se a pasta 'uploads' existe, se não, cria a pasta
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true); // Cria a pasta com permissões
    }

    // Verifica se o registro profissional já existe
    $check_sql = "SELECT * FROM psicologos WHERE registro_profissional = '$registro_profissional'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Registro profissional já existe.";
    } else {
        // Move o arquivo de foto para a pasta
        if (move_uploaded_file($foto_temp, $foto_pasta)) {
            // Insere os dados no banco de dados
            $sql = "INSERT INTO psicologos (nome, especialidade, registro_profissional, email, telefone, bio, foto) 
                    VALUES ('$nome', '$especialidade', '$registro_profissional', '$email', '$telefone', '$bio', '$foto_nome')";

            if ($conn->query($sql) === TRUE) {
                echo "Cadastro realizado com sucesso!";
            } else {
                echo "Erro: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Erro no upload da foto.";
        }
    }
}

$conn->close();
