<?php
// Antes de usar o simulador verifique se esta logado 
// https://developer.paypal.com/developer/webhooksSimulator
// https://github.com/paypal/PayPal-PHP-SDK/wiki/Webhook-Validation/e1249b7d27672d4680c07de3103872127ffa4a1f
// https://jsonformatter.curiousconcept.com/#
// https://developer.paypal.com/demo/checkout-v4/#/pattern/vertical
/**
 * This is one way to receive the entire body that you received from PayPal webhook. This is one of the way to retrieve that information. It could be different based on different frameworks you might be using.
 * Just uncomment the below line to read the data from actual request.
 */
// /** @var String $bodyReceived */
$bodyReceived = file_get_contents('php://input');
// return file_put_contents('retorno_paypal.txt', $bodyReceived);

// Grava todo o resultado limpo e um arquivo novo.
$nome    = uniqid();
$arquivo = fopen("$nome.txt","w");
$escreve = fwrite($arquivo, $bodyReceived);

// Recupernado variáveis
//Converte o resultado em array
$data = json_decode($bodyReceived, true);
// Pega as variáveis
$parent_payment = $data['resource']['parent_payment'];
$invoice_number = $data['resource']['invoice_number'];
$status         = $data['resource']['state'];
// Cria o nome do arquivo
// $nome    = uniqid();
// Cria o arquivo e seta para apenas escrita, coloca o ponteiro do arquivo no começo do arquivo e diminui (trunca) o tamanho do arquivo para zero. Se o arquivo não existe, tenta criá-lo. 
// $arquivo = fopen("$nome.txt","w");
// junta as informações em uma unica variável
// $exemplo = 'parent_payment: '.$parent_payment.' - invoice_number: '.$invoice_number.' - invoice_number: '.$status;
// Escreve o no arquivo
// $escreve = fwrite($arquivo, $exemplo);

// Atualiza no Banco
if ($status == 'completed') {
    include '/home/epapodetarotcom/public_html/includes/conexao.php';
    $pdo = conexao();
    $ref = $invoice_number;
    // Verificando Pagamento
    $executapix = $pdo->query("SELECT * FROM controle WHERE numero_cobranca='$ref'");
    $nLinhasPix = $executapix->rowCount();
    if ($nLinhasPix !== 0) {
        while ($dadosspix=$executapix->fetch(PDO::FETCH_ASSOC)) { 
            $statusSite=$dadosspix['status'];
            $reference=$dadosspix['numero_cobranca'];
            if($statusSite!='PAGO'){
                // Atualiza a fatura para pago.
                $query = $pdo->query("UPDATE controle SET status='PAGO' WHERE numero_cobranca='$reference'");
            }
        }
    }
}

// fclose($fp);

// ### Validate Received Event Method
// Call the validateReceivedEvent() method with provided body, and apiContext object to validate
// try {
//     /** @var \PayPal\Api\WebhookEvent $output */
//     $output = \PayPal\Api\WebhookEvent::validateAndGetReceivedEvent($bodyReceived, $apiContext);

//     // $output would be of type WebhookEvent
//     echo $output->toJSON();
// } catch (\InvalidArgumentException $ex) {
//     // This catch is based on the bug fix required for proper validation for PHP. Please read the note below for more details.
//     // If you receive an InvalidArgumentException, please return back with HTTP 503, to resend the webhooks. Returning HTTP Status code [is shown here](http://php.net/manual/en/function.http-response-code.php). However, for most application, the below code should work just fine.
//     http_response_code(503);
// } catch (Exception $ex) {
//     echo $ex->getMessage();
//     exit(1);
// }