<?php
if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
    //Todo resto do código iremos inserir aqui.

    //Produção
    $email = 'epapodetarot@gmail.com';
    $token = 'a6cd16a0-d451-41e7-8833-135eba83283393f726d44f12bb84fa9d253499f058b8d9a1-8336-4660-afe4-3b8faa3c4f44';
    $transactionCod = $_POST['notificationCode'];
    $url = 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications/' . $transactionCod . '?email=' . $email . '&token=' . $token;

    //Teste
    // $email = 'epapodetarot@gmail.com';
    // $token = 'F5D7DB75D6DD4D6C99D46B365D7E8C84';
    // $transactionCod = $_POST['notificationCode'];
    // $url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/' . $transactionCod . '?email=' . $email . '&token=' . $token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction = curl_exec($curl);
    curl_close($curl);

    if($transaction == 'Unauthorized'){
        //Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção
        exit();//Mantenha essa linha
    }

    $transaction = simplexml_load_string($transaction);

    //Retorno
    $reference = $transaction -> reference;
    $code   = $transaction -> code;
    $date   = $transaction -> date;
    $status = $transaction -> status;
    $email  = $transaction -> sender -> email;
    $nome   = $transaction -> sender -> name;

    if ($status == 1) {
        $status = 'Em análise';
    } elseif ($status == 2) {
        $status = 'Em análise';
    } elseif ($status == 3) {
        $status = 'PAGO';
    } elseif ($status == 4) {
        $status = 'PAGO';
        exit();
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
    }

    //Atualiza no banco de dados o status da compra
    require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
    $pdo = conexao();

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
        if ($status == 'PAGO') {
            //Verifica quantos minutos o cliente comprou
            $executa = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' "); 
            while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 
              $minutos=$dadoss['minutos'];
              $tipo=$dadoss['tipo'];
            }
            if ($tipo=="padrao") {
                //Atualiza no banco os dados retornados.
                $query = $pdo->query("UPDATE controle SET 
                    minutos_dispo='$minutos',
                    metodo='PagSeguro',
                    status='PAGO'
                WHERE cod_pagamento='$reference'");
            } else {
                $query = $pdo->query("UPDATE controle SET 
                    status='PAGO',
                    metodo='PagSeguro'
                WHERE cod_pagamento='$reference'");
            }
        }
    }
    
    //Manda e-mail para o cliente avisando do status da compra
    /*Configuramos o e-mail para o qual ser?o enviadas as informa??es*/
    $seuemail = $email;/*email de destino*/
    $assunto  = "É Papo de Tarot - Pagamentos";/*assunto padr?o do email(n?o o digitado pelo ?suario)*/
    /*Configuramos os cabe?alhos do e-mail*/
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";/*para o envio com formata??o HTML. Charset po ser utf-8 tamb?m*/
    $headers .= "From: epapodetarot@gmail.com \r\n";/*Para "seu email"*/
    // $headers .= "Bcc: logs@novasystems.com.br \r\n";
    /*Configuramos o conte?do do e-mail*/
    $conteudo  = "Olá $nome, o status da sua compra no site É Papo de Tarot foi atualizado.<br>";
    $conteudo .= "<b>Código de Pagamento:</b> $reference <br>";
    $conteudo .= "<b>Data da Compra:</b> $date <br>";
    $conteudo .= "<b>Status:</b> $status <br>";
    $conteudo .= "Pagamento via PagSeguro <br>";
    $conteudo .= "<br>";
    $conteudo .= "www.epapodetarot.com.br<br/>";
    /*Enviando o e-mail...*/
    $enviando = mail($seuemail, $assunto, $conteudo, $headers);
}