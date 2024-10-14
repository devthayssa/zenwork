<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenwork";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consultar dados
$sql = "SELECT nome, especialidade, bio, foto FROM psicologos";
$result = $conn->query($sql);

// Início do HTML
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psicólogos</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link para o arquivo CSS -->
    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #2b2c30;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        .profile-container {
            background-color: rgba(43, 44, 48, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
            display: flex;
            align-items: center; /* Alinha a imagem e o texto */
        }

        .profile-pic {
            border-radius: 50%; /* Torna a imagem circular */
            width: 80px; /* Tamanho da imagem */
            height: 80px; /* Tamanho da imagem */
            margin-right: 20px; /* Espaçamento entre a imagem e o texto */
        }

        h3 {
            color: #e3d31b; /* Cor do nome */
            margin-bottom: 5px; /* Espaçamento abaixo do nome */
        }

        p {
            margin: 5px 0; /* Margens acima e abaixo do parágrafo */
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #e3d31b;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline; /* Sublinhado ao passar o mouse */
        }
    </style>
</head>
<body>
    <h2>Lista de Psicólogos</h2>
    
    <?php
    // Exibir dados
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='profile-container'>";
            if (!empty($row["foto"])) {
                echo "<img src='uploads/" . htmlspecialchars($row["foto"]) . "' alt='Foto de " . htmlspecialchars($row["nome"]) . "' class='profile-pic'>";
            } else {
                echo "<img src='uploads/default.jpg' alt='Foto padrão' class='profile-pic'>";
            }
            echo "<div>";
            echo "<h3>" . htmlspecialchars($row["nome"]) . "</h3>";
            echo "<p>Especialidade: " . htmlspecialchars($row["especialidade"]) . "</p>";
            echo "<p>Biografia: " . htmlspecialchars($row["bio"]) . "</p>";
            echo "</div>"; // Fechar div
            echo "</div>"; // Fechar div.profile-container
        }
    } else {
        echo "<p>Nenhum psicólogo encontrado.</p>";
    }
    echo '<br><a href="index.html">Voltar</a>'; 
    $conn->close();
    ?>
</body>
</html>
