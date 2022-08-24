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

    include '/home/epapodetarotcom/public_html/includes/functions.php';
    include '/home/epapodetarotcom/public_html/includes/conexao.php';
    $pdo = conexao();
    $ref = $invoice_number;
    $data_hoje = date('Y-m-d H:i:s');
    // Verificando Pagamento
    $executapix = $pdo->query("SELECT * FROM controle WHERE numero_cobranca='$ref'");
    $nLinhasPix = $executapix->rowCount();
    if ($nLinhasPix !== 0) {
        while ($dadosspix=$executapix->fetch(PDO::FETCH_ASSOC)) { 
            $id_nome_cliente=$dadosspix['id_nome_cliente'];
            $demonstrativo=$dadosspix['demonstrativo'];
            $mes=$dadosspix['mes'];
            $statusSite=$dadosspix['status'];
            $reference=$dadosspix['numero_cobranca'];
            $valor=$dadosspix['valor_atualizado'];
            $controle_mes_nome = MostraNomeDoMes($mes);
            if($statusSite!='PAGO'){
                // Atualiza a fatura para pago.
                $query = $pdo->query("UPDATE controle SET forma_pag='Paypal', data_pag='$data_hoje', valor_pago='$valor', status='PAGO' WHERE numero_cobranca='$reference'");
                // E-mail
                include '/home/epapodetarotcom/public_html/PHPMailer5.2.22/class.phpmailer.php';
                include '/home/epapodetarotcom/public_html/PHPMailer5.2.22/class.smtp.php';
                //Estacia dados de cadastro do cliente.
                $executa3=$pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente'");
                while ($dadoss3=$executa3->fetch(PDO::FETCH_ASSOC)) {
                    $cliente_nome=$dadoss3['nome'];
                    $cliente_empresa=$dadoss3['empresa'];
                    $cliente_email=$dadoss3['email'];
                    $cliente_usuario=$dadoss3['usuario'];
                }
                ###################### EMAIL ##############################
                    $memaildestinatario = $cliente_email;
                    $mnomedestinatario = $cliente_nome;
                    $massunto = 'Comprovante de pagamento '.$controle_mes_nome.'';
                    $mmensagem = '
                    Prezado(a) '.$cliente_nome.' '.$cliente_empresa.', <br/>
                    Este é um recibo comprovante de pagamento oficial da sua fatura de <strong>'.$controle_mes_nome.'</strong> nº '.$reference.'. <br/>
                    <br/>
                    <b>Seu E-mail de Cadastro:</b> '. $cliente_email .'<br/>
                    <b>Demonstrativo:</b> '. $demonstrativo .'<br/>
                    <b>Data da Identificação do Pagamento:</b> '. $data_hoje.'<br/>
                    <b>Valor Pago:</b> R$ '. $valor .'<br/>
                    <b>Situação:</b> Pago <br/>
                    <br/>
                    <p>Para mais detalhes sobre o histórico de pagamentos, solicitar atualizações, alterar dados de cadastro, ver serviços contratados ou fazer pedidos de suporte, acesse o <b>Painel do Cliente</b>.</p>
                    <p><b>Acesso ao Painel do Cliente:</b></p>
                    <p><a href=\'https://www.novasystems.com.br/admin/\'>https://www.novasystems.com.br/admin</a></p>
                    <strong>Seu Nome de Usuário:</strong> '.$cliente_usuario.' | <strong>Seu E-mail de Cadastro:</strong> '.$cliente_email.' | Para lembrar sua senha acesse: <a href=\'https://www.novasystems.com.br/index.php/minha-conta/lembrar-senha\'>Esqueci minha Senha</a> <br/>
                    <br/>
                    Departamento Financeiro<br/>
                    Agência Nova Systems - Marketing Digital<br/>
                    <a href=\'https://www.novasystems.com.br/\'>www.novasystems.com.br</a>
                    ';
                    EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
                ###################### EMAIL ##############################
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