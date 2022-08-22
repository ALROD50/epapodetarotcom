<?php
///////////////////////////////////////////
//    Gerencianet PIX - Nova Systems     //
///////////////////////////////////////////
ini_set ('default_charset', 'UTF8');
date_default_timezone_set('America/Sao_Paulo');

require_once('/home/tarotdehoruscom/public_html/includes/functions.php');
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();

$cod       = $_POST["cod"];
$URLSESSAO = $_POST["URLSESSAO"];
$ref       = $_POST["ref"];
$data_hoje = date('Y-m-d H:i:s');
// echo $ref.'</br>';
// echo 'Pesquisando... '.time().'</br>';

// Verificando Pagamento PIX
$executapix = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$ref'");
$nLinhasPix = $executapix->rowCount();
if ($nLinhasPix > 0) {
    // pega data da criação do pix e o id
    while ($dadosspix= $executapix->fetch(PDO::FETCH_ASSOC)) { 
        $refPixx=$dadosspix['refPix'];
        $dataCriado=$dadosspix['data'];
        $reference=$dadosspix['cod_pagamento'];
        $minutos=$dadosspix['minutos_dispo'];
        $tipo=$dadosspix['tipo'];
        // Verifica quando o pix foi gerado
        $resultadoHoraPix = datediff('h', $dataCriado, $data_hoje, false);
        // Verifica Status
        require '/home/tarotdehoruscom/public_html/scripts/gerencianet_pix/consultar-qrcode-dinamico.php';
        $status_compra = $responsex["status"];
        // Atualiza
        if ($resultadoHoraPix == 0) {
            if ($status_compra == 'ATIVA') {
                // Ainda não foi paga não faz nada.
            } elseif ($status_compra == 'CONCLUIDA') {
                // Atualiza a fatura para pago.
                if ($tipo=="padrao") {
                    // consulta via chat
                    $query = $pdo->query("UPDATE controle SET metodo='Pix', data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
                } elseif ($tipo=="email") {
                    // consulta via e-mail
                    $query = $pdo->query("UPDATE controle SET metodo='Pix', data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                } elseif ($tipo=="loja") {
                    # produto da loja
                    $query = $pdo->query("UPDATE controle SET metodo='Pix', data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                }
                echo "<script>document.location.href='https://www.tarotdehorus.com.br/tarologos/?msgs=<b>Seu Pagamento Foi Localizado Com Sucesso!</b><br> Escolha o tarólogo abaixo e clique no botão Consultar Agora.<br> Se o tarólogo não estiver online, tente novamente mais tarde.'</script>";
            }
        }
        // Atualiza
        if ($resultadoHoraPix <= 1) {
            if ($status_compra == 'ATIVA') {
                // Ainda não foi paga não faz nada.
            } elseif ($status_compra == 'CONCLUIDA') {
                // Atualiza a fatura para pago.
                if ($tipo=="padrao") {
                    // consulta via chat
                    $query = $pdo->query("UPDATE controle SET metodo='Pix', data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
                } elseif ($tipo=="email") {
                    // consulta via e-mail
                    $query = $pdo->query("UPDATE controle SET metodo='Pix', data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                } elseif ($tipo=="loja") {
                    # produto da loja
                    $query = $pdo->query("UPDATE controle SET metodo='Pix', data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                }
                echo "<script>document.location.href='https://www.tarotdehorus.com.br/tarologos/?msgs=<b>Seu Pagamento Foi Localizado Com Sucesso!</b><br> Escolha o tarólogo abaixo e clique no botão Consultar Agora.<br> Se o tarólogo não estiver online, tente novamente mais tarde.'</script>";
            }
        }
        // Pix expirado
        if ($resultadoHoraPix > 1) {
            $query = $pdo->query("UPDATE controle SET status='Aguardando', metodo='' WHERE cod_pagamento='$reference'");
        }
    }
}
?>