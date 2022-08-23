<!-- /////////////////////////
// PAGAMENTO - NOVA SYSTEMS //
////////////////////////////// -->
<?php
ini_set ('default_charset', 'UTF-8');
date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
?>
<link rel="stylesheet" type="text/css" href="checkout/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<?php
// VARIAVEIS
$Mask       = "SIM";
$Checkout   = "SIM";
$AMPimage   = "SIM";
// Compra
$cod_codificado    =   $_GET['cod'];
$cod_decodificado  =   Codificador::Decodifica($cod_codificado);
$compra            =   array_filter(explode(',',$cod_decodificado));
$idclientesite     =   trim($compra[0]);
$ref               =   str_replace (" ", "", $compra[1]);
$shippingCoast     =   '0.00';
// Pagseguro
require_once "checkout/config.php";
require_once "checkout/utils.php";
$params = array(
    'email' => $PAGSEGURO_EMAIL,
    'token' => $PAGSEGURO_TOKEN
);
$header      = array();
$response    = curlExec($PAGSEGURO_API_URL."/sessions", $params, $header);
$json        = json_decode(json_encode(simplexml_load_string($response)));
$sessionCode = $json->id;
if ($sessionCode=="") {
    echo "<script>document.location.href='https://www.epapodetarot.com.br/pagamentos/pagar.php?cod=$cod_codificado'</script>";
    exit();
}
// Pix
// require __DIR__.'/../scripts/gerencianet_pix/vendor/autoload.php';
// require __DIR__.'/../scripts/gerencianet_pix/config-pix.php';
// use \App\Pix\Api;
// use \App\Pix\Payload;
// use Mpdf\QrCode\QrCode;
// use Mpdf\QrCode\Output;
// Cupom de Desconto
if (@$_POST['cupom']) {
    $cupom = trim($_POST["cupom"]);
    $valorCupom = $_POST["valorCupom"];
    if ($cupom=="TAROTHORUS30") {
        if ($cupomUsado=="") {
            $valor = CupomDesconto($valorCupom, 30);
            $data_hoje_pix = date('Y-m-d H:i:s');
            $query = $pdo->query( "UPDATE controle SET 
                valor='$valor',
                cupom='$cupom',
                data='$data_hoje_pix',
                QRCODEPIX=''
            WHERE cod_pagamento='$ref'");
            echo "<script>document.location.href='https://www.epapodetarot.com.br/pagamentos/pagar.php?cod=".$cod_codificado."&msgs=Cupom de desconto adicionado com sucesso!'</script>";
        } else {
            echo "<script>document.location.href='https://www.epapodetarot.com.br/pagamentos/pagar.php?cod=".$cod_codificado."&msge=Desculpe, você já adicionou um cumpom de desconto nessa compra!'</script>";
        }
    } else {
        echo "<script>document.location.href='https://www.epapodetarot.com.br/pagamentos/pagar.php?cod=".$cod_codificado."&msge=Desculpe, este cupom não é valido!'</script>";
    }
}
// Dados da compra
$executa666 = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$ref'");
if ($executa666->rowCount() != 1){
    echo "<script>document.location.href='https://www.epapodetarot.com.br/'</script>";
    exit();
}
while ($dadoss666 = $executa666->fetch(PDO::FETCH_ASSOC)) { 
    $id_id_cobranca=$dadoss666['id'];
    $demonstrativo=$dadoss666['demonstrativo'];
    $vencimento=$dadoss666['vencimento'];
    $tipo=$dadoss666['tipo'];
    $valor=$dadoss666['valor'];
    $status=$dadoss666['status'];
    $minutos=$dadoss666['minutos'];
    $urldacopra=$dadoss666['url'];
    $cupomUsado=$dadoss666['cupom'];
    $data=$dadoss666['data'];
    $refPixBanco=$dadoss666['refPix'];
    $QRCODEPIX=$dadoss666['QRCODEPIX'];
}
// Detalhes da compra
$itemDescription1  =   $demonstrativo;
$valor             =   $valor;
$shippingCoast     =   '0.00';
// Cliente
$executa66 = $pdo->query("SELECT * FROM clientes WHERE id='$idclientesite'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
    $nome=$dadoss66['nome'];
    $email=$dadoss66['email'];
    $usuario=$dadoss66['usuario'];
    $nivel=$dadoss66['nivel'];
    $data_registro=$dadoss66['data_registro'];
    $endereco=$dadoss66['endereco'];
    $numero=$dadoss66['numero'];
    $complemento=$dadoss66['complemento'];
    $bairro=$dadoss66['bairro'];
    $cep=$dadoss66['cep'];
    $cidade=$dadoss66['cidade'];
    $estado=$dadoss66['estado'];
    $cpf=$dadoss66['cpf'];
    $datanascimentoUm=$dadoss66['data_nascimento'];
    $datanascimento=date("d/m/Y", strtotime("$datanascimentoUm"));
    if ($datanascimento=="30/11/-0001") {
        $datanascimento="";
    }
    $telefone=$dadoss66['telefone'];
    $telefone=preg_replace("/\D/","", $telefone);
    // recuperando o ddd
    $ddd = substr($telefone, 0, 2);
    // recuperando o numero
    $numerocel = substr($telefone, -9);
}
if($nivel == "TAROLOGO"){
    echo "<script>document.location.href='https://www.epapodetarot.com.br/'</script>";
    exit();
}
if($status == "PAGO"){
	echo "<script>alert(\"Esta cobrança já foi paga!\");</script>";
    echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos'</script>";
    exit();
}
//require 'processa.php';
?>
<!-- Formulário e Resumo -->
