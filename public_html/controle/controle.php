<?php 
// Atualiza status de compra em análise no pagseguro
$executax = $pdo->query("SELECT * FROM controle WHERE status='Em análise' AND metodo='PagSeguro' "); 
while ($dadossx= $executax->fetch(PDO::FETCH_ASSOC)) { 
      
    $reference=$dadossx['cod_pagamento'];
    $email = 'epapodetarot@gmail.com';
    $token = 'a6cd16a0-d451-41e7-8833-135eba83283393f726d44f12bb84fa9d253499f058b8d9a1-8336-4660-afe4-3b8faa3c4f44';
    $reference = $reference;
    $curl = 'https://ws.pagseguro.uol.com.br/v2/transactions?email='.$email.'&token='.$token.'&reference='.$reference;

    // load as string
    $xmlstr  = file_get_contents($curl);
    $xmlcont = json_decode(json_encode(simplexml_load_string($xmlstr)));
    // print_r($xmlcont);

    //Retorno
    @$status = $xmlcont->transactions->transaction->status;
    if ($status == "") {
      @$status = $xmlcont->transactions->transaction[0]->status;
    }

    if ($status == 1) {
        $status = 'Em análise';
    } elseif ($status == 2) {
        $status = 'Em análise';
    } elseif ($status == 3) {
        $status = 'Paga';
    } elseif ($status == 4) {
        $status = 'Paga';
    } elseif ($status == 5) {
        $status = 'Em disputa';
    } elseif ($status == 6) {
        $status = 'Devolvida';
    } elseif ($status == 7) {
        $status = 'Cancelada';
    } elseif ($status == 8) {
        $status = 'Chargeback debitado';
    } elseif ($status == 9) {
        $status = 'Em contestação';
    } else {
        $status = 'Aguardando';
    }

    // ******* RETORNO
    ####################################################
    // $seuemail = "logs@novasystems.com.br";
    // $assunto  = "Log Compra - É Papo de Tarot";
    // /*Configuramos os cabeçalho do e-mail*/
    // $headers  = "MIME-Version: 1.0\r\n";
    // $headers .= "Content-type: text/html; charset=utf-8\r\n";
    // $headers .= "From: logs@novasystems.com.br \r\n";
    // Configuramos o conte?do do e-mail
    // $conteudo  = "Compra atualizada para - controle.php<br>";
    // $conteudo .= "<br>";
    // $conteudo .= "Referência $reference<br>";
    // $conteudo .= "<p>O Status foi atualizado no banco de dados para: $status</p>";
    // $conteudo .= "<br>";
    // $conteudo .= "<br>";
    // $conteudo .= "www.epapodetarot.com.br<br/>";
    /*Enviando o e-mail...*/
    // $enviando = mail($seuemail, $assunto, $conteudo, $headers);
    ####################################################

    $executa = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' ");
    while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 
      $statusAtual=$dadoss['status'];
    }
    if ($statusAtual!='PAGO') {

      //Atualiza no banco o status do retorno
      $query = $pdo->query("UPDATE controle SET 
          status='$status',
          metodo='PagSeguro'
      WHERE cod_pagamento='$reference'");

      //Se o status da compra for PAGA, então atualiza na tela os créditos como disponíveis.
      if ($status == 'Paga') {

          //Verifica quantos minutos o cliente comprou
          $executa = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' "); 
          while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 
            $minutos=$dadoss['minutos'];
          }
          //Atualiza no banco os dados retornados.
          $query = $pdo->query("UPDATE controle SET 
              minutos_dispo='$minutos',
              status='PAGO',
              metodo='PagSeguro'
          WHERE cod_pagamento='$reference'");
      }
    }
}

// Verificando Pagamento PIX
$executapix = $pdo->query("SELECT * FROM controle WHERE metodo='Pix' AND status!='PAGO'");
$nLinhasPix = $executapix->rowCount();
if ($nLinhasPix > 0) {
  // pega data da criação do pix e o id
  while ($dadosspix= $executapix->fetch(PDO::FETCH_ASSOC)) { 
    $refPixx=$dadosspix['refPix'];
    $dataCriado=$dadosspix['data'];
    $reference=$dadosspix['cod_pagamento'];
    $minutos=$dadosspix['minutos_dispo'];
    $tipo=$dadosspix['tipo'];
    
    if ($refPixx=="") {
      $query = $pdo->query("UPDATE controle SET metodo='', status='Aguardando' WHERE cod_pagamento='$reference'");
    } else {

      $resultadoHoraPix = datediff('d', $dataCriado, $data_hoje, false);
      if ($resultadoHoraPix > 1) {
        $query = $pdo->query("UPDATE controle SET metodo='', status='Aguardando' WHERE cod_pagamento='$reference'");
      } else {

        $status_compra = "";
        include __DIR__.'/../scripts/gerencianet_pix/consultar-qrcode-dinamico.php';
        $status_compra = @$responsex["status"];

        // echo "<pre>";
        // print_r($responsex);
        // echo 'refPixx: '.$refPixx.'<br>';
        // echo 'status_compra: '.$status_compra.'<br>';
        // echo 'resultadoHoraPix: '.$resultadoHoraPix.'<br>';
        // echo 'dataCriado: '.$dataCriado.'<br>';
        // echo 'data_hoje: '.$data_hoje.'<br>';
        // echo "</pre>"; //exit;
        // echo "<hr>";

        if ($status_compra == 'ATIVA') {
          // Ainda não foi paga não faz nada.
        } elseif ($status_compra == 'CONCLUIDA') {
          // Atualiza a fatura para pago.
          if ($tipo=="padrao") {
              // consulta via chat
              $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
          } elseif ($tipo=="email") {
              // consulta via e-mail
              $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
          } elseif ($tipo=="loja") {
              # produto da loja
              $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
          }
        } else {
          $query = $pdo->query("UPDATE controle SET metodo='', status='Aguardando' WHERE cod_pagamento='$reference'");
        }
      }
    }
  }
}
?>
<h3 class="text-success">Compras Planos de Consulta.</h3>

<ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size:12px">
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='01'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabJaneiro-tab" href="#tabJaneiro" data-toggle="tab" role="tab" aria-controls="tabJaneiro">Janeiro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='02'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabFevereiro-tab" href="#tabFevereiro" data-toggle="tab" role="tab" aria-controls="tabFevereiro">Fevereiro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='03'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabMarco-tab" href="#tabMarco" data-toggle="tab" role="tab" aria-controls="tabMarco">Março</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='04'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabAbril-tab" href="#tabAbril" data-toggle="tab" role="tab" aria-controls="tabAbril">Abril</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='05'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabMaio-tab" href="#tabMaio" data-toggle="tab" role="tab" aria-controls="tabMaio">Maio</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='06'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabJunho-tab" href="#tabJunho" data-toggle="tab" role="tab" aria-controls="tabJunho">Junho</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='07'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabJulho-tab" href="#tabJulho" data-toggle="tab" role="tab" aria-controls="tabJulho">Julho</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='08'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabAgosto-tab" href="#tabAgosto" data-toggle="tab" role="tab" aria-controls="tabAgosto">Agosto</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='09'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabSetembro-tab" href="#tabSetembro" data-toggle="tab" role="tab" aria-controls="tabSetembro">Setembro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='10'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabOutubro-tab" href="#tabOutubro" data-toggle="tab" role="tab" aria-controls="tabOutubro">Outubro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='11'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabNovembro-tab" href="#tabNovembro" data-toggle="tab" role="tab" aria-controls="tabNovembro">Novembro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a <?php if ($data_mes=='12'){ echo 'class="nav-link active" aria-selected="true"';}else{echo 'class="nav-link" aria-selected="false"';} ?> id="tabDezembro-tab" href="#tabDezembro" data-toggle="tab" role="tab" aria-controls="tabDezembro">Dezembro</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div <?php if ($data_mes == '01') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabJaneiro" role="tabpanel" aria-labelledby="tabJaneiro-tab">
    <?php $tab="01"; $mesatual="Janeiro"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '02') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabFevereiro" role="tabpanel" aria-labelledby="tabFevereiro-tab">
    <?php $tab="02"; $mesatual="Fevereiro"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '03') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabMarco" role="tabpanel" aria-labelledby="tabMarco-tab">
    <?php $tab="03"; $mesatual="Março"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '04') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabAbril" role="tabpanel" aria-labelledby="tabAbril-tab">
    <?php $tab="04"; $mesatual="Abril"; include "consulta.php";?>
  </div>
  <div <?php if ($data_mes == '05') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabMaio" role="tabpanel" aria-labelledby="tabMaio-tab">
    <?php $tab="05"; $mesatual="Maio"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '06') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabJunho" role="tabpanel" aria-labelledby="tabJunho-tab">
    <?php $tab="06"; $mesatual="Junho"; include "consulta.php";?>
  </div>
  <div <?php if ($data_mes == '07') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabJulho" role="tabpanel" aria-labelledby="tabJulho-tab">
    <?php $tab="07"; $mesatual="Julho"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '08') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabAgosto" role="tabpanel" aria-labelledby="tabAgosto-tab">
    <?php $tab="08"; $mesatual="Agosto"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '09') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabSetembro" role="tabpanel" aria-labelledby="tabSetembro-tab">
    <?php $tab="09"; $mesatual="Setembro"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '10') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabOutubro" role="tabpanel" aria-labelledby="tabOutubro-tab">
    <?php $tab="10"; $mesatual="Outubro"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '11') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabNovembro" role="tabpanel" aria-labelledby="tabNovembro-tab">
    <?php $tab="11"; $mesatual="Novembro"; include "consulta.php"; ?>
  </div>
  <div <?php if ($data_mes == '12') { echo 'class="tab-pane fade show active"';} else { echo 'class="tab-pane fade"'; } ?> id="tabDezembro" role="tabpanel" aria-labelledby="tabDezembro-tab">
    <?php $tab="12"; $mesatual="Dezembro"; include "consulta.php"; ?>
  </div>
</div>