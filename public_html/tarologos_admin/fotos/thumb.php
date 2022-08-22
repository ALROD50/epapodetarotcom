<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
if (isset($_GET['img'])) {
    // recebendo a url da imagem
    $filename = $_GET['img'];
    // Cabeçalho que ira definir a saida da pagina
    header('Content-type: image/webp');
    // pegando as dimensoes reais da imagem, largura e altura
    list($width, $height) = getimagesize($filename);
    //setando a largura da miniatura
    $new_width = 140;
    //setando a altura da miniatura
    $new_height = 140;
    //gerando a a miniatura da imagem
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromwebp($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    //o 3º argumento é a qualidade da imagem de 0 a 100
    imagepalettetotruecolor($image_p);
    imagealphablending($image_p, true);
    imagesavealpha($image_p, true);
    imagewebp($image_p, null, 60);
    imagedestroy($image_p);
}                       