<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $uploadOk = 1;

    // Verifica se o arquivo foi enviado corretamente
    if (isset($_FILES["videoFile"]) && $_FILES["videoFile"]["error"] == 0) {
        $target_file = $target_dir . basename($_FILES["videoFile"]["name"]);
        $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verifica se o arquivo é um vídeo
        $check = mime_content_type($_FILES["videoFile"]["tmp_name"]);
        if ($check && strpos($check, "video") !== false) {
            echo "O arquivo é um vídeo - " . $check . ".";
            $uploadOk = 1;
        } else {
            echo "O arquivo não é um vídeo.";
            $uploadOk = 0;
        }

        // Verifica se o arquivo já existe
        if (file_exists($target_file)) {
            echo "Desculpe, o arquivo já existe.";
            $uploadOk = 0;
        }

        // Verifica o tamanho do arquivo
        if ($_FILES["videoFile"]["size"] > 50000000) { // 50MB
            echo "Desculpe, seu arquivo é muito grande.";
            $uploadOk = 0;
        }

        // Permite certos formatos de arquivo
        $allowedFormats = ["mp4", "avi", "mov", "3gp", "mpeg"];
        if (!in_array($videoFileType, $allowedFormats)) {
            echo "Desculpe, apenas arquivos MP4, AVI, MOV, 3GP e MPEG são permitidos.";
            $uploadOk = 0;
        }

        // Verifica se $uploadOk está definido como 0 por um erro
        if ($uploadOk == 0) {
            echo "Desculpe, seu arquivo não foi enviado.";
            // Se tudo estiver ok, tenta fazer o upload do arquivo
        } else {
            if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $target_file)) {
                echo "O arquivo " . htmlspecialchars(basename($_FILES["videoFile"]["name"])) . " foi enviado.";

                // Comprime o vídeo usando FFmpeg
                $compressed_file = $target_dir . "compressed_" . basename($_FILES["videoFile"]["name"]);
                $command = "ffmpeg -i " . escapeshellarg($target_file) . " -vcodec libx265 -crf 28 " . escapeshellarg($compressed_file);
                exec($command, $output, $return_var);

                if ($return_var == 0) {
                    echo "O arquivo foi comprimido com sucesso.";
                } else {
                    echo "Desculpe, houve um erro ao comprimir seu arquivo.";
                }
            } else {
                echo "Desculpe, houve um erro ao enviar seu arquivo.";
            }
        }
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}
