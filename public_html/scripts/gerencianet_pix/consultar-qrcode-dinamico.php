<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/config-pix.php';

use \App\Pix\Api;
use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//INSTANCIA DA API PIX
$obApiPixx = new Api(API_PIX_URL,
                    API_PIX_CLIENT_ID,
                    API_PIX_CLIENT_SECRET,
                    API_PIX_CERTIFICATE);

//RESPOSTA DA REQUISIÇÃO DE CRIAÇÃO
$responsex = $obApiPixx->consultCob($refPixx);

//VERIFICA A EXISTÊNCIA DO ITEM 'LOCATION'
if(!isset($responsex['location'])){
  // echo 'Problemas ao consultar resultado Pix dinâmico';
  if ($URLSESSAO=="pagamentos") {
    echo "<script>document.location.href='https://www.tarotdehorus.com.br/pagamentos/pagar.php?cod=$cod&repix=true'</script>";
  }
  // echo "<pre>";
  // print_r($responsex);
  // echo "</pre>"; //exit;
  // echo 'refPixx: '.$refPixx;
}

//DEBUG DOS DADOS DO RETORNO
// echo "<pre>";
// print_r($response);
// echo "</pre>"; 

// valido
// 00020101021226880014br.gov.bcb.pix2566qrcodes-pix.gerencianet.com.br/v2/835a4113fb664ceca6974f3b1a938177520400005303986540515.005802BR5912TarotdeHorus6008SAOPAULO62070503***63045508  

// 00020101021226880014br.gov.bcb.pix2566qrcodes-pix.gerencianet.com.br/v2/fab135589ccc4438ae53deb3c6116052520400005303986540530.005802BR5912TarotdeHorus6008SAOPAULO62070503***63047C37

// invalido
// 00020101021226880014br.gov.bcb.pix2566qrcodes-pix.gerencianet.com.br/v2/23c2e883c327416bb142875a774975d9520400005303986540530.005802BR5912TarotdeHorus6008SAOPAULO62070503***6304CAC

