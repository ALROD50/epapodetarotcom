<?php
///////////////////////////////////////////
// // Gerencianet - Nova Systems         //
///////////////////////////////////////////
ini_set ('default_charset', 'UTF8');
date_default_timezone_set('America/Sao_Paulo');

include '/home/tarotdehoruscom/public_html/scripts/gerencianet2v/autoload.php'; // caminho relacionado a SDK
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
 
// Desenvolvimento 
// $clientId = 'Client_Id_6ca5ce19058a92a12c19b3ad2ae5e5343d7ce550'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
// $clientSecret = 'Client_Secret_12e32f9bda34e80d29ea3deed40fede3e38c0ee5'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)

// Produção
$clientId = 'Client_Id_a47c179803948a92acdd1e50b8720365aef784f4';
$clientSecret = 'Client_Secret_f651dc0222289653f83970c4bc435895dff671ab';

$options = [
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
];

require_once('/home/tarotdehoruscom/public_html/includes/functions.php');
require_once('/home/tarotdehoruscom/public_html/scripts/PHPMailer-master5.2.22/class.phpmailer.php');
require_once('/home/tarotdehoruscom/public_html/scripts/PHPMailer-master5.2.22/class.smtp.php');
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();

/*
* Este token será recebido em sua variável que representa os parâmetros do POST
* Ex.: $_POST['notification']
*/

$token = $_POST["notification"];
$params = [
  'token' => $token
];
  
try {
    
    $api = new Gerencianet($options);
    $chargeNotification = $api->getNotification($params, []);
  	// Para identificar o status atual da sua transação você deverá contar o número de situações contidas no array, pois a última posição guarda sempre o último status. Veja no modelo de respostas na seção "Exemplos de respostas" abaixo.
  	// Veja abaixo como acessar o ID e a String referente ao último status da transação.
    // Conta o tamanho do array data (que armazena o resultado)
    $i = count($chargeNotification["data"]);
    // Pega o último Object chargeStatus
    $ultimoStatus = $chargeNotification["data"][$i-1];
    // Acessando o array Status
    $status = $ultimoStatus["status"];
    // Acessando o id customizado (id do banco de dados do sistema)
    $id_cobranca = $ultimoStatus["custom_id"];
    // Obtendo o ID da transação    
    $charge_id = $ultimoStatus["identifiers"]["charge_id"];
    // Obtendo o Valor Pago   
    $valor_pago_gn = $ultimoStatus["value"];
    //convertendo o formato padrão da GN (1035) para (10.35) reais
    $valor_pago_gn = number_format($valor_pago_gn / 100, 2, '.', ''); 
    // Obtendo a String do status atual
    $statusAtual = $status["current"];
    // Com estas informações, você poderá consultar sua base de dados e atualizar o status da transação especifica, uma vez que você possui o "charge_id" e a String do STATUS
    //echo "O id da transação é: ".$charge_id." seu novo status é: ".$statusAtual . " O id customizado é: ". $id_cobranca . " ";
    //print_r($chargeNotification);

} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);
} catch (Exception $e) {
    print_r($e->getMessage());
}

$status_compra = $statusAtual;
$data_hoje = date('Y-m-d');

if ($status_compra == "new") {
    $statusDois = 'Em análise';
} elseif ($status_compra == "waiting") {
    $statusDois = 'Em análise';
} elseif ($status_compra == "paid") {
    $statusDois = 'PAGO';
} elseif ($status_compra == "settled") {
    $statusDois = 'PAGO';
} elseif ($status_compra == "contested") {
    $statusDois = 'Em disputa';
} elseif ($status_compra == "refunded") {
    $statusDois = 'Devolvida';
} elseif ($status_compra == "canceled" ) {
    $statusDois = 'CANCELADO';
} elseif ($status_compra == "unpaid") {
    $statusDois = 'PENDENTE';
} elseif ($status_compra == "contested" ) {
    $statusDois = 'Em contestação';
} else {
    $statusDois = 'falhou';
}

//Estanciar dados da fatura.
$executa3 = $pdo->query("SELECT * FROM controle WHERE id='$id_cobranca'");
while ($dadoss3 = $executa3->fetch(PDO::FETCH_ASSOC)){
    $id_nome_cliente=$dadoss3['id_nome_cliente'];
    $demonstrativo=$dadoss3['minutos'];
    $data_vencimento=$dadoss3['data'];
    $status_atual_da_cobranca=$dadoss3['status'];
    $valor=$dadoss3['valor'];
    $numero_cobranca=$dadoss3['cod_pagamento'];
    $minutos=$dadoss3['minutos'];
    $tipo=$dadoss3['tipo'];
}

//Estacia dados de cadastro do cliente.
$executa3=$pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente'");
while ($dadoss3 = $executa3->fetch(PDO::FETCH_ASSOC)){
    $cliente_nome=$dadoss3['nome'];
    $cliente_email=$dadoss3['email'];
    $cliente_usuario=$dadoss3['usuario'];
}

//Se a cobrança já esta paga, não faz nada.
if ($status_atual_da_cobranca == "PAGO") {

    exit();
    
} elseif ($statusDois != "falhou") {

    //Se a cobrança não estiver paga, então continua normal

    //Atualiza a fatura.
    $query = $pdo->query("UPDATE controle SET status='$statusDois' WHERE id='$id_cobranca'");

    //Se a fatura não estiver vencida e PAGA então coloca o status como aguardando
    $data_de_hoje = date('Y-m-d');
    $vencimento = date("Y-m-d", strtotime($data_vencimento));
    if ($data_de_hoje < $vencimento AND $statusDois != "PAGO") {
        $query_dois = $pdo->query("UPDATE controle SET
            status='Em análise',
            valor=''
        WHERE id='$id_cobranca'");
        $statusDois = 'Em análise';
    }

    if ($statusDois == 'PAGO') {

        //Atualiza a fatura para pago.
        if ($tipo=="padrao") {
            // consulta via chat
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', valor='$valor', minutos_dispo='$minutos', status='PAGO' WHERE id='$id_cobranca'");
        } elseif ($tipo=="whatsapp") {
            // consulta via whatsapp
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', valor='$valor', status='PAGO' WHERE id='$id_cobranca'");
            $consultawhatsapp="Para realizar sua consulta via whatsapp, <a href=\'https://api.whatsapp.com/send?phone=5511941190306&text=Olá Tarot de Hórus, Gostaria de agendar minha consulta via WhatsApp!'>CLIQUE AQUI.</a>";
        } elseif ($tipo=="email") {
            // consulta via e-mail
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', valor='$valor', status='PAGO' WHERE id='$id_cobranca'");
            $consultaEmail="Responda essa mensagem para realizar sua consulta via e-mail.";
        } elseif ($tipo=="loja") {
            # produto da loja
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', valor='$valor', status='PAGO' WHERE id='$id_cobranca'");
            $produtoLoja="Estamos preparando o seu pedido, em breve você recebera mais informações.";
        }

        ###################### EMAIL ##############################
        $memaildestinatario = $cliente_email;
        $mnomedestinatario = $cliente_nome;
        $massunto = 'Comprovante de pagamento';
        $mmensagem = '
        Parabéns! '.$cliente_nome.', <br/>
        Este é um recibo comprovante de pagamento da sua fatura no site Tarot de Hórus.<br/>
        <br/>
        <b>Seu E-mail de Cadastro:</b> '. $cliente_email .'<br/>
        <b>Demonstrativo:</b> '. $demonstrativo .'<br/>
        <b>Nº Fatura:</b> '. $id_cobranca .'<br/>
        <b>Data da Identificação do Pagamento:</b> '. $data_hoje.'<br/>
        <b>Valor Pago:</b> R$ '. $valor .'<br/>
        <b>Situação:</b> Pago <br/>
        <p>'. $consultawhatsapp.'<p/>
        <p>'. $consultaEmail.'<p/>
        <p>'. $produtoLoja.'<p/>
        <br/>
        <p>Volte ao Site:</p>
        <p><a href=\'https://www.tarotdehorus.com.br/tarologos/\'>https://www.tarotdehorus.com.br/tarologos</a></p>
        <br/>
        Departamento Financeiro<br/>
        Tarot de Hórus<br/>
        <a href=\'https://www.tarotdehorus.com.br/\'>www.tarotdehorus.com.br</a>
        ';
        EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
        ###################### EMAIL ##############################
    }

    ###################################################################
    $seuemail = "logs@novasystems.com.br";
    $assunto  = "Retorno Gerencianet Tarot de Hórus";
    /*Configuramos os cabe?alhos do e-mail*/
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: logs@novasystems.com.br \r\n";
    /*Configuramos o conte?do do e-mail*/
    $conteudo = "Status na Gerencianet: <b>$status_compra</b><br>";
    $conteudo .= "Pagamento atualizado para: <b>$statusDois</b><br>";
    $conteudo .= "ID Cobrança: <b>$id_cobranca</b><br>";
    $conteudo .= "Valor Pago Gerencianet - <b>$valor_pago_gn</b><br>";
    $conteudo .= "$cliente_nome - $cliente_email<br>";
    $conteudo .= "<br>";
    $conteudo .= "Tarot de Hórus<br>";
    /*Enviando o e-mail...*/
    $enviando = mail($seuemail, $assunto, $conteudo, $headers);
    ###################################################################
}

echo "Ok";
?>