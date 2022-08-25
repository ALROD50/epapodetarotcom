<?php
// Converte imagem em WEBP, a partir de um diretório, ou arquivo especifico
$execulta="sim";
$especifico="nao";
$webpPARAjpg="sim";
if ($execulta=="sim") {
    if ($especifico=="sim") {
        // Arquivo Especifico
        $dir = '/home/epapodetarotcom/public_html/images/';
        $name = 'whatsapp.webp';
        $newName = 'whatsapp.webp';
        $img = imagecreatefrompng($dir . $name);
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        imagewebp($img, $dir . $newName, 80); //qualidade
        imagedestroy($img);
        // imagecreatefrompng
        // imagecreatefromgif
        // imagecreatefrombmp
    } else {
        /* Diretorio que deve ser lido */
        $path = '/home/epapodetarotcom/public_html/images/';
        /* Abre o diretório */
        
        // webp PARA jpg ?
        $pasta=opendir($path);
        
        if ($webpPARAjpg=="sim") {
            /* Loop para ler os arquivos do diretorio */
            while ($arquivo = readdir($pasta)) {
                /* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
                @$ext = strtolower(end(explode(".", $arquivo)));
                if ($arquivo != '.' && $arquivo != '..' && $ext != 'zip' && $ext != 'php' && $ext != 'html' && $arquivo != 'error_log') {
                    // Convertendo .WEBP para .JPG
                    $dir = $path;
                    $name = $arquivo;
                    // Garante que a imagem é do tipo .WEBP
                    if (!file_exists($name)) {
                        // File does not exists
                    } elseif (exif_imagetype($name) === IMAGETYPE_WEBP) {
                        @$newName = strtolower(reset(explode(".", $arquivo)));
                        @$newName = $newName.'.png';
                        $img = imagecreatefromwebp($dir . $name);
                        imagejpeg($img, $dir . $newName, 80); //qualidade
                        imagedestroy($img);
                        // deleta a imagem anterior
                        $filepath = $dir.$arquivo;
                        @unlink ($filepath);
                    }
                }
            }
        } else {        
            /* Loop para ler os arquivos do diretorio */
            while ($arquivo = readdir($pasta)) {
                /* Verificacao para exibir apenas os arquivos e nao os caminhos para diretorios superiores */
                @$ext = strtolower(end(explode(".", $arquivo)));
                if ($arquivo != '.' && $arquivo != '..' && $ext != 'zip' && $ext != 'php' && $ext != 'html' && $arquivo != 'error_log') {
                    // Se for imagem
                    if ($ext == 'jpg' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'gif' OR $ext == 'bmp') {
                        // Convertendo imagem em .WEBP
                        if ($ext == 'jpg') {
                            $dir = $path;
                            $name = $arquivo;
                            @$newName = strtolower(reset(explode(".", $arquivo)));
                            @$newName = $newName.'.webp';
                            $img = imagecreatefromjpeg($dir . $name);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            imagewebp($img, $dir . $newName, 80); //qualidade
                            imagedestroy($img);
                            // deleta a imagem anterior
                            $filepath = $dir.$arquivo;
                            @unlink ($filepath);
                        } elseif ($ext == 'jpeg') {
                            $dir = $path;
                            $name = $arquivo;
                            @$newName = strtolower(reset(explode(".", $arquivo)));
                            @$newName = $newName.'.webp';
                            $img = imagecreatefromjpeg($dir . $name);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            imagewebp($img, $dir . $newName, 80); //qualidade
                            imagedestroy($img);
                            // deleta a imagem anterior
                            $filepath = $dir.$arquivo;
                            @unlink ($filepath);
                        } elseif ($ext == 'png') {
                            $dir = $path;
                            $name = $arquivo;
                            @$newName = strtolower(reset(explode(".", $arquivo)));
                            @$newName = $newName.'.webp';
                            $img = imagecreatefrompng($dir . $name);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            imagewebp($img, $dir . $newName, 80); //qualidade
                            imagedestroy($img);
                            // deleta a imagem anterior
                            $filepath = $dir.$arquivo;
                            @unlink ($filepath);
                        } elseif ($ext == 'gif') {
                            $dir = $path;
                            $name = $arquivo;
                            @$newName = strtolower(reset(explode(".", $arquivo)));
                            @$newName = $newName.'.webp';
                            $img = imagecreatefromgif($dir . $name);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            imagewebp($img, $dir . $newName, 80); //qualidade
                            imagedestroy($img);
                            // deleta a imagem anterior
                            $filepath = $dir.$arquivo;
                            @unlink ($filepath);
                        } elseif ($ext == 'bmp') {
                            $dir = $path;
                            $name = $arquivo;
                            @$newName = strtolower(reset(explode(".", $arquivo)));
                            @$newName = $newName.'.webp';
                            $img = imagecreatefrombmp($dir . $name);
                            imagepalettetotruecolor($img);
                            imagealphablending($img, true);
                            imagesavealpha($img, true);
                            imagewebp($img, $dir . $newName, 80); //qualidade
                            imagedestroy($img);
                            // deleta a imagem anterior
                            $filepath = $dir.$arquivo;
                            @unlink ($filepath);
                        }
                    }
                }
            }
        }
    }
}
?>
