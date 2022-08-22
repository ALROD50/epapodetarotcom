<?php
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
// echo 'Pesquisando... '.time().'</br>';

// Se ocorrer erro:
$ERRO     = @$_POST['ERRO'];
$ErroCod  = @$_POST['ErroCod'];
if (@$ERRO == "ERRONOPAGAMENTO") {
	$seuemail = "logs@novasystems.com.br";
    $assunto  = "Tarot de Hórus Erro Pagamento Payal";
    /*Configuramos os cabe?alhos do e-mail*/
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: contato@tarotdehorus.com.br \r\n";
    /*Configuramos o conte?do do e-mail*/
    $conteudo = "<b>Erro:</b> $ErroCod <br>";
    /*Enviando o e-mail...*/
    $enviando = mail($seuemail, $assunto, $conteudo, $headers);

} else {

    $usuario_id  = $_POST['usuario_id'];
    $ref         = $_POST['ref'];
    $minutos     = $_POST['minutos'];
    $valor_plano = $_POST['valor_plano'];
    $tipo        = $_POST['tipo'];
    $data_hoje   = date('Y-m-d H:i:s');
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h1><i class="fas fa-glass-cheers"></i> Pagamento Aprovado</h1>
        <hr>
        <?php
        //Atualiza a fatura para pago.
        if ($tipo=="padrao") {
            // consulta via chat
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO', metodo='Paypal' WHERE cod_pagamento='$ref'");
            echo "<script>document.location.href='https://www.tarotdehorus.com.br/tarologos/?msgs=Pagamento Aprovado<br>Escolha o taróloga abaixo e boa consulta!'</script>";

        } elseif ($tipo=="whatsapp") {
            // consulta via whatsapp
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO', metodo='Paypal' WHERE cod_pagamento='$ref'");
            ?>
            <p>Para realizar sua consulta via whatsapp, <a href='https://api.whatsapp.com/send?phone=5511941190306&text=Olá Tarot de Hórus, Gostaria de agendar minha consulta via WhatsApp!'>CLIQUE AQUI.</a></p>
            <?php
        } elseif ($tipo=="email") {
            // consulta via e-mail
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO', metodo='Paypal' WHERE cod_pagamento='$ref'");
            ?>
            <p>Para receber instruções da consulta via e-mail, <a href='https://api.whatsapp.com/send?phone=5511941190306&text=Olá Tarot de Hórus, Gostaria de receber instruções da consulta via e-mail!'>CLIQUE AQUI.</a></p>
            <?php
        } elseif ($tipo=="loja") {
            # produto da loja
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO', metodo='Paypal' WHERE cod_pagamento='$ref'");
            ?>
            <p>Estamos preparando o seu pedido, em breve você recebera mais informações no seu e-mail.</p>
            <?php
            $pdo->query("DELETE FROM loja_carrinho WHERE id_cliente='$usuario_id'"); 
        }
        ?>
    </div>
    <style>
        #menusite {
            display: block !important;
        }
    </style>
    <?php
}