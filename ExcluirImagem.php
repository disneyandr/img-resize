<?php

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['nomeDaImagem'])) {
        http_response_code(400);
        echo 'Favor fornecer o nome da imagem';
        exit();
    }
    $nomeDaImagem = $_DELETE['nomeDaImagem'];
    $caminhoImagem = $nomeDaImagem;
    if (file_exists($caminhoImagem)) {
        if (unlink($caminhoImagem)) {
            http_response_code(200);
            echo 'Imagem excluída.';
        } else {
            http_response_code(500);
            echo 'Erro ao excluir imagem';
        }
    } else {
        http_response_code(404);
        echo 'Não foi encontrada a imagem';
    }
} else {
    http_response_code(405);
    echo 'Método não permitido';
}
