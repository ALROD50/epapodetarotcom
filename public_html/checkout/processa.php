<?php   
ini_set ('default_charset', 'UTF-8');
date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors',0);
ini_set('display_startup_erros',0);

###########################################################################################
// Gerencianet - É Papo de Tarot
// require '/home/epapodetarotcom/public_html/scripts/gerencianet2v/autoload.php'; // caminho relacionado a SDK
// use Gerencianet\Exception\GerencianetException;
// use Gerencianet\Gerencianet;
###########################################################################################

// PROCESSA PAGAMENTOS - CARTÃO DE CRÉDITO - PAGSEGURO
if (@$_POST['Cartao'] == 'enviarCartao'){

    $pdo->query("DELETE FROM loja_carrinho WHERE id_cliente='$usuario_id'"); 

    $creditCardToken = htmlspecialchars($_POST["token"]);
    $senderHash = htmlspecialchars($_POST["senderHash"]);
    // Valor do Pagamento
    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    $installmentValue = number_format($_POST["installmentValue"], 2, '.', '');
    $installmentsQty = $_POST["installments"];
    // Dados do Cartão de Crédito
    $creditCardHolderName = $_POST["creditCardHolderName"];
    $creditCardHolderCPF = $_POST['creditCardHolderCPF'];
    $creditCardHolderCPF = str_replace (".", "", $creditCardHolderCPF);
    $creditCardHolderCPF = str_replace ("-", "", $creditCardHolderCPF);
    $creditCardHolderCPF = trim($creditCardHolderCPF);
    $creditCardHolderBirthDate = $_POST["creditCardHolderBirthDate"];
    $creditCardHolderAreaCode = $_POST["creditCardHolderAreaCode"];
    $creditCardHolderPhone = $_POST["creditCardHolderPhone"];
    $creditCardHolderPhone = str_replace ("-", "", $creditCardHolderPhone);
    $creditCardHolderPhone = trim($creditCardHolderPhone);
    // Pedido
    $itemDescription1 = $_POST["itemDescription1"];
    $reference = $_POST["reference"];
    // Dados do cliente - Se o cliente quiser usar os mesmos dados do cartão, então os dados pessoais serão iguais aos dos cartão.
    $DadosPessoaisDoisChek = $_POST["DadosPessoaisDoisChek"];
    if ($DadosPessoaisDoisChek=='sim') {
        $senderName = $creditCardHolderName;
        $senderCPF = $creditCardHolderCPF;
        $senderAreaCode = $creditCardHolderAreaCode;
        $senderPhone = $creditCardHolderPhone;
        $senderEmail = $_POST["emaildocliente"];
        # code...
    } elseif ($DadosPessoaisDoisChek=='nao') {
        $senderName = $_POST["senderNamexx"];
        $senderCPF = $_POST['senderCPFxx'];
        $senderCPF = str_replace (".", "", $senderCPF);
        $senderCPF = str_replace ("-", "", $senderCPF);
        $senderCPF = trim($senderCPF);
        $senderAreaCode = $_POST["senderAreaCodexx"];
        $senderPhone = $_POST["senderPhonexx"];
        $senderPhone = str_replace ("-", "", $senderPhone);
        $senderPhone = trim($senderPhone);
        $senderEmail = $_POST["emaildocliente"];
    }
    // Endereço de envio
    $shippingAddressStreet = $_POST["Street"];
    $shippingAddressNumber = $_POST["numBer"];
    $shippingAddressComplement = $_POST["complemento"];
    $shippingAddressDistrict = $_POST["District"];
    $shippingAddressPostalCode = $_POST["PostalCode"];
    $shippingAddressCity = $_POST["City"];
    $shippingAddressState = $_POST["State"];
    // Endereço da Fatura do Cartão - Se o cliente quiser usar os mesmos dados de endereço para a fatura do cartão, então copia do end principal.
    $UsarMesmoEndCard = $_POST["UsarMesmoEndCard"];
    if ($UsarMesmoEndCard=='sim') {
        $billingAddressStreet = $shippingAddressStreet;
        $billingAddressNumber = $shippingAddressNumber;
        $billingAddressComplement = $shippingAddressComplement;
        $billingAddressDistrict = $shippingAddressDistrict;
        $billingAddressPostalCode = $shippingAddressPostalCode;
        $billingAddressCity = $shippingAddressCity;
        $billingAddressState = $shippingAddressState;
        $billingAddressCountry = 'BRA';
    } elseif ($UsarMesmoEndCard=='nao') {
        $billingAddressStreet = $_POST["billingAddressStreet"];
        $billingAddressNumber = $_POST["billingAddressNumber"];
        $billingAddressComplement = $_POST["billingAddressComplement"];
        $billingAddressDistrict = $_POST["billingAddressDistrict"];
        $billingAddressPostalCode = $_POST["billingAddressPostalCode"];
        $billingAddressCity = $_POST["billingAddressCity"];
        $billingAddressState = $_POST["billingAddressState"];
        $billingAddressCountry = 'BRA';
    }

    // Limite caracteres do demonstrativo, limite 100 caracteres
    $itemDescription1 = strip_tags(limita_caracteres($itemDescription1, 95, true));

    $idclientesite = $_POST["idclientesite"];
    $params = array(
        'email'                     => $PAGSEGURO_EMAIL,  
        'token'                     => $PAGSEGURO_TOKEN,
        'creditCardToken'           => $creditCardToken,
        'senderHash'                => $senderHash,
        'receiverEmail'             => $PAGSEGURO_EMAIL,
        'paymentMode'               => 'default', 
        'paymentMethod'             => 'creditCard', 
        'currency'                  => 'BRL',

        // Dados da Compra, Pedido
        // 'extraAmount'            => '1.00',
        'itemId1'                   => '0001',
        'itemDescription1'          => $itemDescription1,  
        'itemAmount1'               => $itemAmount,  
        'itemQuantity1'             => 1,
        'reference'                 => $reference,

        // Dados do cliente
        'senderName'                => $senderName,
        'senderCPF'                 => $senderCPF,
        'senderAreaCode'            => $senderAreaCode,
        'senderPhone'               => $senderPhone,
        'senderEmail'               => $senderEmail,

        // Endereço de envio e Valor do Frete
        'shippingAddressStreet'     => $shippingAddressStreet,
        'shippingAddressNumber'     => $shippingAddressNumber,
        'shippingAddressDistrict'   => $shippingAddressDistrict,
        'shippingAddressPostalCode' => $shippingAddressPostalCode,
        'shippingAddressCity'       => $shippingAddressCity,
        'shippingAddressState'      => $shippingAddressState,
        'shippingAddressCountry'    => 'BRA',
        'shippingType'              => 1,
        'shippingCost'              => $shippingCoast,
        'shippingAddressComplement' => $shippingAddressComplement,

        // Parcelamento do cartão de crédito
        // Os parâmetros noInterestInstallmentQuantity e maxInstallmentNoInterest aceitam somente valores acima de 2. Se a compra não for parcelada, você não deve enviar estes parâmetros. 
        //Lembrando que sempre que enviar o parâmetro maxInstallmentNoInterest no método getInstallments, deve ser enviado o mesmo valor no parâmetro noInterestInstallmentQuantity na chamada.
        'maxInstallmentNoInterest'      => 2, 
        'noInterestInstallmentQuantity' => 2,
        'installmentQuantity'       => $installmentsQty,
        'installmentValue'          => $installmentValue,

        // Dados do Cartão de Crédito
        'creditCardHolderName'      => $creditCardHolderName,
        'creditCardHolderCPF'       => $creditCardHolderCPF,
        'creditCardHolderBirthDate' => $creditCardHolderBirthDate,
        'creditCardHolderAreaCode'  => $creditCardHolderAreaCode,
        'creditCardHolderPhone'     => $creditCardHolderPhone,

        // Endereço de Cobrança
        'billingAddressStreet'     => $billingAddressStreet,
        'billingAddressNumber'     => $billingAddressNumber,
        'billingAddressDistrict'   => $billingAddressDistrict,
        'billingAddressPostalCode' => $billingAddressPostalCode,
        'billingAddressCity'       => $billingAddressCity,
        'billingAddressState'      => $billingAddressState,
        'billingAddressCountry'    => 'BRA'
    );

    // ####### Não execulta duas vezes o mesmo pedido.
    $verificaDuploRegistro = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' AND status='PAGO' ");
    $row = $verificaDuploRegistro->rowCount();
    if ($row > 0){

        // Compra ja registrada
        echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta'</script>";

    } else {
    // ####### Não execulta duas vezes o mesmo pedido.

        $header = array('Content-Type' => 'application/json; charset=UTF-8;');
        $response = curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
        $json = json_decode(json_encode(simplexml_load_string($response)));
        // var_dump($json);
        $code = $json->code;
        $status_compra = $json->status;

        // ******* REGISTRA NO BANCO DE DADOS
        // Grava no banco de dados o pedido do cliente
        $data_hoje = date('Y-m-d H:i:s');
        
        if ($status_compra == 1) {
            $statusDois = 'Em análise';
        } elseif ($status_compra == 2) {
            $statusDois = 'Em análise';
        } elseif ($status_compra == 3) {
            $statusDois = 'PAGO';
        } elseif ($status_compra == 4) {
            $statusDois = 'PAGO';
        } elseif ($status_compra == 5) {
            $statusDois = 'Em disputa';
        } elseif ($status_compra == 6) {
            $statusDois = 'Devolvida';
        } elseif ($status_compra == 7) {
            $statusDois = 'Cancelada';
        } elseif ($status_compra == 8) {
            $statusDois = 'Chargeback debitado';
        } elseif ($status_compra == 9) {
            $statusDois = 'Em contestação';
        } else {
            $statusDois = 'falhou';
        }

        // Atualização basica
        $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='$statusDois', metodo='PagSeguro' WHERE cod_pagamento='$reference'");

        // ******* ATUALIZA DADOS DE CADASTRO DO CLIENTE
        $creditCardHolderBirthDate = date("Y-m-d", strtotime("$creditCardHolderBirthDate"));
        $query = $pdo->query("UPDATE clientes SET
            telefone='$senderAreaCode $senderPhone',
            endereco='$shippingAddressStreet',
            cidade='$shippingAddressCity',
            estado='$shippingAddressState',
            numero='$shippingAddressNumber',
            cep='$shippingAddressPostalCode',
            complemento='$shippingAddressComplement',
            bairro='$shippingAddressDistrict',
            cpf='$senderCPF',
            data_nascimento='$creditCardHolderBirthDate'
        WHERE id='$idclientesite'");
        // ******* ATUALIZA DADOS DE CADASTRO DO CLIENTE

        // 1 = Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
        // 2 = Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
        if ($status_compra == '1' OR $status_compra == '2') {

            ?>
            <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1><i class="fas fa-hourglass-half"></i> Seu Pagamento esta em <b>Análise</b>!</h1>
                <h3>Status: <b>Em Análise</b></h3>
                <hr>
                <p style="font-size:22px;"><a href="https://www.epapodetarot.com.br/minha-conta">Clique Aqui, para acompanhar sua compra e ver o status atualizado!</a></p>
                <hr>
            </div>
            <style>
                #menusite {
                    display: block !important;
                }
            </style>
            <?php

        // 3 = Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
        // 4 = Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
        } elseif ($status_compra == '3' OR $status_compra == '4') {

            //Atualiza a fatura para pago.
            if ($tipo=="padrao") {
                // consulta via chat
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO', metodo='PagSeguro' WHERE cod_pagamento='$reference'");
            } elseif ($tipo=="whatsapp") {
                // consulta via whatsapp
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO', meteodo='PagSeguro' WHERE cod_pagamento='$reference'");
                $consultawhatsapp="Para realizar sua consulta via whatsapp, <a href='https://api.whatsapp.com/send?phone=55&text=Olá É Papo de Tarot, Gostaria de agendar minha consulta via WhatsApp!' target='_blank'>CLIQUE AQUI.</a>";
            } elseif ($tipo=="email") {
                // consulta via e-mail
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO', metodo='PagSeguro' WHERE cod_pagamento='$reference'");
                $consultaEmail="Responda essa mensagem para realizar sua consulta via e-mail.";
            } elseif ($tipo=="loja") {
                # produto da loja
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO', metodo='PagSeguro' WHERE cod_pagamento='$reference'");
                $produtoLoja="Estamos preparando o seu pedido, em breve você recebera mais informações.";
            }

            //Verifica Saldo do Cliente
            $sql_credito = $pdo->query("SELECT COALESCE(SUM(minutos_dispo), 0) as soma FROM controle WHERE id_nome_cliente='$idclientesite' AND status='PAGO' ");
            $cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
            $valor = $cont["soma"];
            if ($valor <= 0) {
                $valor = 0;
            }
            ?>
            <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1><i class="fas fa-glass-cheers"></i> Pagamento Aprovado</h1>
                <hr>
                <?php
                if ($tipo=="padrao") {
                    // consulta via chat
                    ?>
                    <p><?php echo 'Seu saldo atual é de: '.$valor.' Minutos'; ?></p>
                    <p><a href="https://www.epapodetarot.com.br/tarologos">Clique aqui para escolher um tarólogo</a></p>
                    <?php
                } elseif ($tipo=="whatsapp") {
                    // consulta via whatsapp
                    ?>
                    <p><?php echo $consultawhatsapp; ?></p>
                    <?php
                } elseif ($tipo=="email") {
                    // consulta via e-mail
                    ?>
                    <p><?php echo $consultaEmail; ?></p>
                    <?php
                } elseif ($tipo=="loja") {
                    # produto da loja
                    ?>
                    <p><?php echo $produtoLoja; ?></p>
                    <?php
                } 
                ?>
                <hr>
            </div>
            <?php

        // 5 = Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
        } elseif ($status_compra == '5') {

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1>Pagamento Em disputa</h1>
                <p>O comprador, dentro do prazo de liberação da transação, abriu uma disputa.</p>
            </div>
            <?php

        // 6 = Devolvida: o valor da transação foi devolvido para o comprador.
        } elseif ($status_compra == '6') {

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1>Pagamento Devolvido</h1>
                <p>O valor da transação foi devolvido para o comprador.</p>
            </div>
            <?php

        // 7 = Cancelada: a transação foi cancelada sem ter sido finalizada.
        } elseif ($status_compra == '7') {

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1>Pagamento Negado</h1>
                <p>O pagamento foi negado pela empresa de cartão de crédito.</p>
                <p>Ligue para o número impresso no verso do seu cartão para entender o motivo.</p>
                <p>Se preferir utilize outro meio de pagamento, ou tente novamente.</p>
                <br>
                <p><b>Geralmente este erro é causado por:</b></p>
                <ul style="margin-left: 50px;">
                  <li>O endereço de cobrança associado ao meio de pagamento escolhido no paypal não pôde ser confirmado.</li>
                  <li>A transação excede o limite do cartão.</li>
                  <li>A transação foi negada pelo emissor do cartão.</li>
                  <li>Cartão, endereços, dados em nome de pessoas diferentes.</li>
                </ul>
                <p style="font-size: 30px;"><a href="<?php echo $urldacopra; ?>">Ok, Quero tentar fazer o pagamento novamente!</a></p>
            </div>
            <?php

        // 8 = Debitado: o valor da transação foi devolvido para o comprador.
        } elseif ($status_compra == '8') {

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1>Pagamento Debitado</h1>
                <p>O valor da transação foi devolvido para o comprador.</p>
            </div>
            <?php

        // 9 = Retenção temporária: o comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.
        } elseif ($status_compra == '9') {

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1>Pagamento - Retenção temporária</h1>
                <p>O comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.</p>
            </div>
            <?php

        } else {
            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h3>Erro - Desculpe o processamento do seu pagamento falhou.</h3>
                <p>Você pode fazer uma nova tentativa, <a href="<?php echo $urldacopra; ?>">Clique Aqui.</a></p>
            </div>
            <?php
        }

        ###################### EMAIL ##############################
        $memaildestinatario = $senderEmail;
        $mnomedestinatario = $senderName;
        $massunto  = 'Pagamento';
        $mmensagem = '
        Olá '.$senderName.', <br/>
        Este é um recibo comprovante de pagamento da sua fatura no site É Papo de Tarot.<br/>
        <br/>
        <b>Seu E-mail de Cadastro:</b> '. $senderEmail .'<br/>
        <b>Demonstrativo:</b> '. $demonstrativo .'<br/>
        <b>Nº Fatura:</b> '. $reference .'<br/>
        <b>Data:</b> '. $data_hoje.'<br/>
        <b>Valor:</b> R$ '. $valor .'<br/>
        <b>Situação:</b> '. $statusDois .'<br/>
        <p>'.@$consultawhatsapp.'<p/>
        <p>'.@$consultaEmail.'<p/>
        <p>'.@$produtoLoja.'<p/>
        <br/>
        <p>Volte ao Site:</p>
        <p><a href=\'https://www.epapodetarot.com.br/tarologos/\'>https://www.epapodetarot.com.br/tarologos</a></p>
        <br/>
        Departamento Financeiro<br/>
        É Papo de Tarot<br/>
        <a href=\'https://www.epapodetarot.com.br/\'>www.epapodetarot.com.br</a>
        ';
        EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
        ###################### EMAIL ##############################

    // ####### Não execulta duas vezes o mesmo pedido.
    }
    // ####### Não execulta duas vezes o mesmo pedido.
    ?>
    <style>
        #conteudo {
            display: none;
        }
    </style>
<?php
}
// PROCESSA PAGAMENTOS - DÉBITO - PAGSEGURO
if (@$_POST['Debito'] == 'enviarDebito'){

    ?><div class="card card-body" style="background: #fff;"><?php

    $idclientesite = $_POST["idclientesite"];
    $senderHash = htmlspecialchars($_POST["senderHash"]);
    // Valor do Pagamento
    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    // Pedido
    $itemDescription1 = $_POST["itemDescription1"];
    $reference = $_POST["reference"];
    // Dados do cliente
    $senderName = $_POST["senderNameD"];
    $senderCPF = $_POST['senderCPFD'];
    $senderCPF = str_replace (".", "", $senderCPF);
    $senderCPF = str_replace ("-", "", $senderCPF);
    $senderCPF = trim($senderCPF);

    $senderAreaCode = $_POST["senderAreaCodeD"];
    $senderPhone = $_POST["telefoneD"];
    $senderPhone = str_replace ("-", "", $senderPhone);
    $senderPhone = trim($senderPhone);

    $senderEmail = $_POST["emaildocliente"];
    // Endereço de envio e Valor do Frete
    $shippingAddressStreet = $_POST["Street"];
    $shippingAddressNumber = $_POST["numBer"];
    $shippingAddressDistrict = $_POST["District"];
    $shippingAddressPostalCode = $_POST["PostalCode"];
    $shippingAddressCity = $_POST["City"];
    $shippingAddressState = $_POST["State"];
    $shippingAddressComplement = $_POST["complemento"];

    $params = array(
        'email'                     => $PAGSEGURO_EMAIL,  
        'token'                     => $PAGSEGURO_TOKEN,
        'senderHash'                => $senderHash,
        'receiverEmail'             => $PAGSEGURO_EMAIL,
        'paymentMode'               => 'default', 
        'paymentMethod'             => 'eft', 
        'bankName'                  => $_POST["bankName"],
        'currency'                  => 'BRL',

        // Dados da Compra, Pedido
        // 'extraAmount'               => '1.00',
        'itemId1'                   => '0001',
        'itemDescription1'          => $itemDescription1,  
        'itemAmount1'               => $itemAmount,  
        'itemQuantity1'             => 1,
        'reference'                 => $reference,

        // Dados do cliente
        'senderName'                => $senderName,
        'senderCPF'                 => $senderCPF,
        'senderAreaCode'            => $senderAreaCode,
        'senderPhone'               => $senderPhone,
        'senderEmail'               => $senderEmail,

        // Endereço de envio e Valor do Frete
        'shippingAddressStreet'     => $shippingAddressStreet,
        'shippingAddressNumber'     => $shippingAddressNumber,
        'shippingAddressDistrict'   => $shippingAddressDistrict,
        'shippingAddressPostalCode' => $shippingAddressPostalCode,
        'shippingAddressCity'       => $shippingAddressCity,
        'shippingAddressState'      => $shippingAddressState,
        'shippingAddressCountry'    => 'BRA',
        'shippingType'              => 1,
        'shippingCost'              => $shippingCoast,
        'shippingAddressComplement' => $shippingAddressComplement
    );

    // ####### Não execulta duas vezes o mesmo pedido.
    $verificaDuploRegistro = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' AND status='PAGO' ");
    $row = $verificaDuploRegistro->rowCount();
    if ($row > 0){

        // Compra ja registrada
        echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta'</script>";

    } else {
    // ####### Não execulta duas vezes o mesmo pedido.

        $header = array('Content-Type' => 'application/json; charset=UTF-8;');
        $response = curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
        $json = json_decode(json_encode(simplexml_load_string($response)));
        $code = $json->code;
        $status_compra = $json->status;

        $data_hoje = date('Y-m-d H:i:s');

        // Atualização basica
        $query = $pdo->query("UPDATE controle SET data='$data_hoje', metodo='Débito' WHERE cod_pagamento='$reference'");

        // ******* ATUALIZA DADOS DE CADASTRO DO CLIENTE
        $query = $pdo->query("UPDATE clientes SET
            telefone='$senderAreaCode $senderPhone',
            endereco='$shippingAddressStreet',
            cidade='$shippingAddressCity',
            estado='$shippingAddressState',
            numero='$shippingAddressNumber',
            cep='$shippingAddressPostalCode',
            complemento='$shippingAddressComplement',
            bairro='$shippingAddressDistrict',
            cpf='$senderCPF'
        WHERE id='$idclientesite'");
        // ******* ATUALIZA DADOS DE CADASTRO DO CLIENTE
        ?>

        <h1><i class="fas fa-credit-card"></i>Débito Bancário Online</h1>

        <?php
        if ($status_compra == '1') {

            ?>
            <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                
                <h3>Clique no botão abaixo para finalizar</h3>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <center>
                            <br>
                            <a button href="<?php echo $json->paymentLink;?>" class="btn btn-success btn-lg btn-block" target='_blank'><i class="fas fa-arrow-right"></i> Pagar Agora</button></a>
                        </center>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            <?php
            
        } elseif ($status_compra == "") { 

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                
                <h3>Erro</h3>

                <p>Desculpe, o Débito Bancário Online para este banco esta indisponível neste momento.</p>
                <p>Você pode tentar novamente usando outro banco, ou pode escolher outro meio de pagamento como boleto ou cartão de crédito.</p>

                <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <center>
                <br>
                    <?php  
                    $server = $_SERVER['SERVER_NAME'];
                    $endereco = $_SERVER ['REQUEST_URI'];
                    $endereco_atual = "https://" . $server . $endereco;
                    echo "<p style='font-size:16px;'><a href=".$endereco_atual.">Tentar novamente.</a></p>";
                    ?>
                </center>
                </div>
                <div class="col-md-4"></div> 
                </div>
            </div>
            <?php
            
        } else {

            echo"<br><br><br><p style='font-size:19px;'>Desculpe, ocorreu um erro com este pagamento...</p>";
            echo "Código do Erro:";
            echo "<br>";
            echo "<p>$response</p>";

            // Enviando erro para a administração
            ###################### EMAIL ##############################
            $memaildestinatario = 'logs@novasystems.com.br';
            $mnomedestinatario = 'Suporte';
            $massunto = "Erro Débito Bancário Online É Papo de Tarot";
            $mmensagem = "
            Cliente $senderName <br/>
            <p>Erro no pagamento com Débito Bancário Online</b>, </p>
            <p>status: $status_compra</p>
            <br/>
            <p>$response</p>
            <br/>
            <br/>
            <b>É Papo de Tarot</b> <br/>
            Site: www.epapodetarot.com.br <br/>
            ";
            EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
            ###################### EMAIL ##############################
        }
        ?>
    <?php
    // ####### Não execulta duas vezes o mesmo pedido.
    }
    // ####### Não execulta duas vezes o mesmo pedido.
    ?>
    </div>
    <style>
        #conteudo {
            display: none;
        }
    </style>
<?php
}
// PROCESSA PAGAMENTOS - BOLETO - PAGSEGURO
if (@$_POST['Boleto'] == 'enviarBoleto'){

    ?>
    <div id="preloadboleto" class="text-center mt-3">
      <div class="spinner-border" role="status" aria-hidden="true"></div>
      <span><h1>Carregando...</h1></span>
    </div>
    <?php

    $pdo->query("DELETE FROM loja_carrinho WHERE id_cliente='$usuario_id'"); 

    $senderHash = htmlspecialchars($_POST["senderHash"]);
    // Valor do Pagamento
    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    // Pedido
    $itemDescription1 = $_POST["itemDescription1"];
    $reference = $_POST["reference"];
    // Dados do cliente
    $senderName = $_POST["senderName"];
    $senderCPF = $_POST['senderCPF'];
    $senderCPF = str_replace (".", "", $senderCPF);
    $senderCPF = str_replace ("-", "", $senderCPF);
    $senderCPF = trim($senderCPF);

    $senderAreaCode = $_POST["senderAreaCode"];
    $senderPhone = $_POST["telefone"];
    $senderPhone = str_replace ("-", "", $senderPhone);
    $senderPhone = trim($senderPhone);

    $senderEmail = $_POST["emaildocliente"];
    
    // Endereço de envio e Valor do Frete
    $shippingAddressStreet = $_POST["Street"];
    $shippingAddressNumber = $_POST["numBer"];
    $shippingAddressDistrict = $_POST["District"];
    $shippingAddressPostalCode = $_POST["PostalCode"];
    $shippingAddressCity = $_POST["City"];
    $shippingAddressState = $_POST["State"];
    $shippingAddressComplement = $_POST["complemento"];

    // ####################################################
    $data_hoje = date('d-m-Y H:i:s');
    $texto = "Data: $data_hoje\nReferencia: $reference\nForma de pagamento: Boleto\n$senderName\nCPF: $senderCPF\n$senderAreaCode $senderPhone\n$senderEmail\n$shippingAddressStreet\n$shippingAddressNumber\n$shippingAddressDistrict\nCEP: $shippingAddressPostalCode\n$shippingAddressCity\n$shippingAddressState\nComplemento: $shippingAddressComplement\n$itemDescription1\n $itemAmount\n\n\n\n";
    // Cria txt e salva no servidor
    // $caminho = "/home/fresh931/public_html/compras/";
    // $caminho = $caminho.$data_hoje.".txt";
    // Abre ou cria o arquivo bloco1.txt
    // o “w” quer dizer write, que o arquivo pode ser escrito. Vai ser criado um arquivo para cada gravação. o 'a' grava no mesmo
    // $fp = fopen($caminho, "w"); 
    // $fp = fopen('/home/epapodetarotcom/public_html/admin/site_planos/pagseguro/vendas.txt', "a");
    // Escreve "exemplo de escrita" no bloco1.txt
    // $escreve = fwrite($fp, $texto);
    // Fecha o arquivo
    // fclose($fp);
    // ####################################################

    $params = array(
        'email'                     => $PAGSEGURO_EMAIL,  
        'token'                     => $PAGSEGURO_TOKEN,
        'senderHash'                => $senderHash,
        'receiverEmail'             => $PAGSEGURO_EMAIL,
        'paymentMode'               => 'default', 
        'paymentMethod'             => 'boleto', 
        'currency'                  => 'BRL',

        // Dados da Compra, Pedido
        'extraAmount'               => '0.00',
        'itemId1'                   => '0001',
        'itemDescription1'          => $itemDescription1,  
        'itemAmount1'               => $itemAmount,  
        'itemQuantity1'             => 1,
        'reference'                 => $reference,

        // Dados do cliente
        'senderName'                => $senderName,
        'senderCPF'                 => $senderCPF,
        'senderAreaCode'            => $senderAreaCode,
        'senderPhone'               => $senderPhone,
        'senderEmail'               => $senderEmail,

        // Endereço de envio e Valor do Frete
        'shippingAddressStreet'     => $shippingAddressStreet,
        'shippingAddressNumber'     => $shippingAddressNumber,
        'shippingAddressDistrict'   => $shippingAddressDistrict,
        'shippingAddressPostalCode' => $shippingAddressPostalCode,
        'shippingAddressCity'       => $shippingAddressCity,
        'shippingAddressState'      => $shippingAddressState,
        'shippingAddressCountry'    => 'BRA',
        'shippingType'              => 1,
        'shippingCost'              => $shippingCoast,
        'shippingAddressComplement' => $shippingAddressComplement
    );

    $header = array('Content-Type' => 'application/json; charset=UTF-8;');
    $response = curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
    $json = json_decode(json_encode(simplexml_load_string($response)));
    $code = $json->code;
    $status_compra = $json->status;
    ?>

    <h1>Boleto Bancário</h1>

    <?php
    if ($status_compra == '1') {

        ?>
        <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
            
            <h3>Clique no botão abaixo para pagar o seu boleto</h3>

            <div class="row">
            <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <center>
            <br>
                <a button href="<?php echo $json->paymentLink;?>" class="btn btn-success btn-lg btn-block" target='_blank'><i class="glyphicon glyphicon-ok"></i> Visualizar Boleto</button></a>
            </center>
            </div>
            <div class="col-md-4"></div>
            </div>  
            </div>
        </div>
        <?php

    } else {
        ?>
        <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <h3>Erro ao gerar o boleto, envie o código abaixo ao suporte técnico do site.</h3>
            <p>Response: <?php print_r($json);  ?></p>
        </div>
        <?php
    }
    ?>
    <style>
        #conteudo, #preloadboleto {
            display: none;
        }
    </style>
<?php
}
// PROCESSA PAGAMENTOS - DEPÓSITO / TRANSFERÊNCIA BANCÁRIA
if (@$_POST['Deposito'] == 'enviarDeposito'){

    $pdo->query("DELETE FROM loja_carrinho WHERE id_cliente='$usuario_id'"); 

    $idclientesite = $_POST["idclientesite"];
    $banco = utf8_encode($_POST["banco"]);
    // Valor do Pagamento
    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    // Pedido
    $reference = $_POST["reference"];
    ?>

    <h1>Depósito / Transferência Bancária</h1>

    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h1>Aguardando Pagamento!</h1>
        <p style="font-size:22px; color:#000;">Você iniciou este pagamento com depósito/transferência no <b><?php echo $banco.' | Valor R$ '.$itemAmount; ?></b></p>
        <p style="font-size:18px;">Realize o depósito, guarde o comprovante, e envie os dados do comprovante no email: <b><a href="mailto:epapodetarot@gmail.com">epapodetarot@gmail.com</a></b> para completar seu pagamento.</p>
        <p style="font-size:18px;">Após enviar o seu comprovante, suas informações serão analisadas, se o pagamento for entre bancos iguais, identificaremos na hora, se for DOC, ou depósito, identificaremos no dia útil seguinte, você será avisado por e-mail sobre a identificação do pagamento.</p>
        <p style="font-size:18px;">Obrigado!</p>
    </div>

    <?php
    $data_hoje = date('Y-m-d H:i:s');

    if ($tipo=="padrao") {
        // consulta via chat
        $query = $pdo->query( "UPDATE controle SET 
            metodo='$banco',
            data='$data_hoje',
            status='Aguardando'
        WHERE cod_pagamento='$reference'");
    } elseif ($tipo=="whatsapp") {
        // consulta via whatsapp
        $query = $pdo->query( "UPDATE controle SET 
            metodo='$banco',
            data='$data_hoje',
            status='Aguardando'
        WHERE cod_pagamento='$reference'");
    } elseif ($tipo=="email") {
        // consulta via e-mail
        $query = $pdo->query( "UPDATE controle SET 
            metodo='$banco',
            data='$data_hoje',
            status='Aguardando'
        WHERE cod_pagamento='$reference'");
    } elseif ($tipo=="loja") {
        # produto da loja
        $query = $pdo->query( "UPDATE controle SET 
            metodo='$banco',
            data='$data_hoje',
            status='Aguardando'
        WHERE cod_pagamento='$reference'");
    }
    ?>

    <div class="row mt-4 mb-4">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <center>
                <a href="home" class="btn btn-dark btn-lg btn-block" type="button"><i class="fas fa-arrow-circle-left"></i> VOLTAR AO SITE</a>
            </center>
        </div>
        <div class="col-md-2"></div>
    </div>

    <style>
        #conteudo {
            display: none;
        }
        #menusite {
            display: block !important;
        }
    </style>
<?php
}
// PROCESSA PAGAMENTOS - CARTÃO DE CRÉDITO - GERENCIANET
if (@$_POST['CartaoGE'] == 'enviarCartaoGE'){

    $pdo->query("DELETE FROM loja_carrinho WHERE id_cliente='$usuario_id'"); 

    $creditCardToken = htmlspecialchars($_POST["tokenGE"]);
    // Valor do Pagamento
    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    // Dados do Cartão de Crédito
    $creditCardHolderName = $_POST["creditCardHolderNameGE"];
    $creditCardHolderCPF = $_POST['creditCardHolderCPFGE'];
    $creditCardHolderCPF = str_replace (".", "", $creditCardHolderCPF);
    $creditCardHolderCPF = str_replace ("-", "", $creditCardHolderCPF);
    $creditCardHolderCPF = trim($creditCardHolderCPF);
    $creditCardHolderBirthDate = $_POST["creditCardHolderBirthDateGE"];
    $creditCardHolderAreaCode = $_POST["creditCardHolderAreaCodeGE"];
    $creditCardHolderPhone = $_POST["creditCardHolderPhoneGE"];
    $creditCardHolderPhone = str_replace ("-", "", $creditCardHolderPhone);
    $creditCardHolderPhone = trim($creditCardHolderPhone);
    // Pedido
    $itemDescription1 = $_POST["itemDescription1"];
    $itemDescription1 = utf8_encode($itemDescription1);
    $reference = $_POST["reference"];
    // Dados do cliente - Se o cliente quiser usar os mesmos dados do cartão, então os dados pessoais serão iguais aos dos cartão.
    $DadosPessoaisDoisChek = $_POST["DadosPessoaisDoisChekGE"];
    if ($DadosPessoaisDoisChek=='sim') {
        $senderName = $creditCardHolderName;
        $senderCPF = $creditCardHolderCPF;
        $senderAreaCode = $creditCardHolderAreaCode;
        $senderPhone = $creditCardHolderPhone;
        $senderEmail = $_POST["emaildocliente"];
        # code...
    } elseif ($DadosPessoaisDoisChek=='nao') {
        $senderName = $_POST["senderNamexxGE"];
        $senderCPF = $_POST['senderCPFxxGE'];
        $senderCPF = str_replace (".", "", $senderCPF);
        $senderCPF = str_replace ("-", "", $senderCPF);
        $senderCPF = trim($senderCPF);
        $senderAreaCode = $_POST["senderAreaCodexxGE"];
        $senderPhone = $_POST["senderPhonexxGE"];
        $senderPhone = str_replace ("-", "", $senderPhone);
        $senderPhone = trim($senderPhone);
        $senderEmail = $_POST["emaildocliente"];
    }
    // Endereço de envio
    $shippingAddressStreet = $_POST["Street"];
    $shippingAddressNumber = $_POST["numBer"];
    $shippingAddressComplement = $_POST["complemento"];
    $shippingAddressDistrict = $_POST["District"];
    $shippingAddressPostalCode = trim($_POST["PostalCode"]);
    $shippingAddressCity = $_POST["City"];
    $shippingAddressState = $_POST["State"];
    // Endereço da Fatura do Cartão - Se o cliente quiser usar os mesmos dados de endereço para a fatura do cartão, então copia do end principal.
    $UsarMesmoEndCard = $_POST["UsarMesmoEndCardGE"];
    if ($UsarMesmoEndCard=='sim') {
        $billingAddressStreet = $shippingAddressStreet;
        $billingAddressNumber = $shippingAddressNumber;
        $billingAddressComplement = $shippingAddressComplement;
        $billingAddressDistrict = $shippingAddressDistrict;
        $billingAddressPostalCode = $shippingAddressPostalCode;
        $billingAddressCity = $shippingAddressCity;
        $billingAddressState = $shippingAddressState;
        $billingAddressCountry = 'BRA';
    } elseif ($UsarMesmoEndCard=='nao') {
        $billingAddressStreet = $_POST["billingAddressStreetGE"];
        $billingAddressNumber = $_POST["billingAddressNumberGE"];
        $billingAddressComplement = $_POST["billingAddressComplementGE"];
        $billingAddressDistrict = $_POST["billingAddressDistrictGE"];
        $billingAddressPostalCode = $_POST["billingAddressPostalCodeGE"];
        $billingAddressCity = $_POST["billingAddressCityGE"];
        $billingAddressState = $_POST["billingAddressStateGE"];
        $billingAddressCountry = 'BRA';
    }

    $idclientesite = $_POST["idclientesite"];
    $itemAmount2 = intval(number_format($itemAmount, 2, '', ''));
    $prefixo = strval($senderAreaCode);
    $telefone = strval($senderPhone); // telefone do cliente
    $datanascimento=date("Y-d-m", strtotime("$creditCardHolderBirthDate"));
    $shippingAddressPostalCode = str_replace ("-", "", $shippingAddressPostalCode);

    // echo $itemDescription1;
    // exit();

    // ####### Não execulta duas vezes o mesmo pedido.
    $verificaDuploRegistro = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' AND status='PAGO' ");
    $row = $verificaDuploRegistro->rowCount();
    if ($row > 0){

        // Compra ja registrada
        echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta'</script>";

    } else {
    // ####### Não execulta duas vezes o mesmo pedido

        // Atualização basica
        $data_hoje = date('Y-m-d H:i:s');
        $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='Em análise', metodo='Cartão' WHERE cod_pagamento='$reference'");

        // ******* ATUALIZA DADOS DE CADASTRO DO CLIENTE
        $query = $pdo->query("UPDATE clientes SET
            telefone='$senderAreaCode $senderPhone',
            endereco='$shippingAddressStreet',
            cidade='$shippingAddressCity',
            estado='$shippingAddressState',
            numero='$shippingAddressNumber',
            cep='$shippingAddressPostalCode',
            complemento='$shippingAddressComplement',
            bairro='$shippingAddressDistrict',
            cpf='$senderCPF',
            data_nascimento='$datanascimento'
        WHERE id='$idclientesite'");
        // ******* ATUALIZA DADOS DE CADASTRO DO CLIENTE

        // ********** PAGAMENTO VIA GERENCIANET - CARTÃO DE CRÉDITO
        // IDS Produção
        $clientId = 'Client_Id_a47c179803948a92acdd1e50b8720365aef784f4'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
        $clientSecret = 'Client_Secret_f651dc0222289653f83970c4bc435895dff671ab'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
        // IDS Sandbox
        //$clientId = 'Client_Id_4692490c71fec56d5d78d36affecdfd292b3d82f'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
        //$clientSecret = 'Client_Secret_097b2e1eba040a3d1329e42480b8b4446d90bd98'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
        $options = [
          'client_id' => $clientId,
          'client_secret' => $clientSecret,
          'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = producao)
        ];
        $item_1 = [
           'name' => $itemDescription1, // nome do item, produto ou serviço
           'amount' => (int) 1, // quantidade
           'value' => (int) $itemAmount2 // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
        ];
        $items = [
           $item_1
        ];
        $metadata = array('notification_url'=>'https://www.epapodetarot.com.br/checkout/retorno_gn.php', 'custom_id' => $id_id_cobranca);
        $body = [
            'metadata' =>$metadata,
            'items' => $items
        ];
        $api = new Gerencianet($options);
        $charge = $api->createCharge([], $body);
        // var_dump($charge);die();
        if ($charge["code"] == 200) {

            $params = ['id' => $charge["data"]["charge_id"]];
            $customer = [
               'name' => $senderName, // nome do cliente
               'cpf'  => $senderCPF, // cpf do cliente
               'phone_number' => $prefixo . $telefone, // telefone do cliente
               'email' => $senderEmail, // endereço de email do cliente
               'birth' => $datanascimento // data de nascimento do cliente
            ];
            $paymentToken = $creditCardToken; // payment_token obtido na 1ª etapa (através do Javascript único por conta Gerencianet)
            $billingAddress = [
              'street' => $shippingAddressStreet,
              'number' => $shippingAddressNumber,
              'neighborhood' => $shippingAddressDistrict,
              'zipcode' => $shippingAddressPostalCode,
              'city' => $shippingAddressCity,
              'state' => $shippingAddressState
            ];
            $credit_card = [
              'installments' => (int) 1, // número de parcelas em que o pagamento deve ser dividido
              'billing_address' => $billingAddress,
              'payment_token' => $paymentToken,
              'customer' => $customer
            ];
            $payment = [
               'credit_card' => $credit_card // forma de pagamento (credit_card = cartão)
            ];
            $body = [
               'payment' => $payment
            ];
            try {
                $api = new Gerencianet($options);
                $charge = $api->payCharge($params, $body);
                // echo '<pre>';
                // print_r($charge);
                // echo '<pre>';
            } catch (GerencianetException $e) {
                // Erros de API do Gerencianet virão aqui
                print_r($e->code);
                print_r($e->error);
                print_r($e->errorDescription);
            } catch (Exception $e) {
                // Outros erros viram aqui
                print_r($e->getMessage());
            }
        }

        $status_compra = $charge["data"]["status"];

        if ($status_compra == 'waiting' OR $status_compra == 'new') {

            ?>
            <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1><i class="fas fa-hourglass-half"></i> Seu Pagamento esta em <b>Análise</b>!</h1>
                <h3>Status: <b>Em Análise</b></h3>
                <hr>
                <p style="font-size:22px;"><a href="https://www.epapodetarot.com.br/minha-conta">Clique Aqui, para acompanhar sua compra e ver o status atualizado!</a></p>
                <hr>
            </div>
            <?php

        } elseif ($status_compra == 'paid' OR $status_compra == 'settled') {

            //Atualiza a fatura para pago.
            if ($tipo=="padrao") {
                // consulta via chat
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
            } elseif ($tipo=="whatsapp") {
                // consulta via whatsapp
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                $consultawhatsapp="Para realizar sua consulta via whatsapp, <a href='https://api.whatsapp.com/send?phone=55&text=Olá É Papo de Tarot, Gostaria de agendar minha consulta via WhatsApp!' target='_blank'>CLIQUE AQUI.</a>";
            } elseif ($tipo=="email") {
                // consulta via e-mail
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                $consultaEmail="Responda essa mensagem para realizar sua consulta via e-mail.";
            } elseif ($tipo=="loja") {
                # produto da loja
                $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                $produtoLoja="Estamos preparando o seu pedido, em breve você recebera mais informações.";
            }

            //Verifica Saldo do Cliente
            $sql_credito = $pdo->query("SELECT COALESCE(SUM(minutos_dispo), 0) as soma FROM controle WHERE id_nome_cliente='$idclientesite' AND status='PAGO' ");
            $cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
            $valor = $cont["soma"];
            if ($valor <= 0) {
                $valor = 0;
            }
            ?>
            <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1><i class="fas fa-glass-cheers"></i> Pagamento Aprovado</h1>
                <hr>
                <?php
                if ($tipo=="padrao") {
                    // consulta via chat
                    ?>
                    <p><?php echo 'Seu saldo atual é de: '.$valor.' Minutos'; ?></p>
                    <p><a href="https://www.epapodetarot.com.br/tarologos">Clique aqui para escolher um tarólogo</a></p>
                    <?php
                } elseif ($tipo=="whatsapp") {
                    // consulta via whatsapp
                    ?>
                    <p><?php echo $consultawhatsapp; ?></p>
                    <?php
                } elseif ($tipo=="email") {
                    // consulta via e-mail
                    ?>
                    <p><?php echo $consultaEmail; ?></p>
                    <?php
                } elseif ($tipo=="loja") {
                    # produto da loja
                    ?>
                    <p><?php echo $produtoLoja; ?></p>
                    <?php
                } 
                ?>
                <hr>
            </div>
            <?php

        } elseif ($status_compra == 'canceled') {

            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h1>Pagamento Negado</h1>
                <p>O pagamento foi negado pela empresa de cartão de crédito.</p>
                <p>Ligue para o número impresso no verso do seu cartão para entender o motivo.</p>
                <p>Se preferir utilize outro meio de pagamento, ou tente novamente.</p>
                <br>
                <p><b>Geralmente este erro é causado por:</b></p>
                <ul style="margin-left: 50px;">
                  <li>O endereço de cobrança associado ao meio de pagamento escolhido no paypal não pôde ser confirmado.</li>
                  <li>A transação excede o limite do cartão.</li>
                  <li>A transação foi negada pelo emissor do cartão.</li>
                  <li>Cartão, endereços, dados em nome de pessoas diferentes.</li>
                </ul>
                <p style="font-size: 30px;"><a href="<?php echo $urldacopra; ?>">Ok, Quero tentar fazer o pagamento novamente!</a></p>
            </div>
            <?php

        } else {
            
            ?>
            <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <h3>Erro - Desculpe o processamento do seu pagamento falhou.</h3>
                <p>Você pode fazer uma nova tentativa, <a href="<?php echo $urldacopra; ?>">Clique Aqui.</a></p>
            </div>
            <?php
        }

        ###################################################################
        $seuemail = "logs@novasystems.com.br";
        $assunto  = "Novo Pagamento - É Papo de Tarot ";
        /*Configuramos os cabe?alhos do e-mail*/
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: logs@novasystems.com.br \r\n";
        /*Configuramos o conte?do do e-mail*/
        $conteudo  = "Status na Gerencianet Cartão: <b>$status_compra</b><br>";
        $conteudo .= "ID Cobrança: <b>$reference</b><br>";
        $conteudo .= "Valor Atualizado - <b>$valor</b><br>";
        $conteudo .= "$senderName - $senderEmail<br>";
        $conteudo .= "<br>";
        $conteudo .= @"<p>$e->errorDescription</p>";
        $conteudo .= "<br>";
        $conteudo .= "É Papo de Tarot<br>";
        /*Enviando o e-mail...*/
        $enviando = mail($seuemail, $assunto, $conteudo, $headers);
        ###################################################################

    // ####### Não execulta duas vezes o mesmo pedido.
    }
    // ####### Não execulta duas vezes o mesmo pedido.
    ?>
    <style>
        #conteudo {
            display: none;
        }
    </style>
<?php
}
// PROCESSA PAGAMENTOS - PIX
if (@$_POST['Pix'] == 'enviarPix'){

    $pdo->query("DELETE FROM loja_carrinho WHERE id_cliente='$usuario_id'"); 

    $idclientesite = $_POST["idclientesite"];
    $refPixx = $refPixBanco;
    $data_hoje = date('Y-m-d H:i:s');
    // Valor do Pagamento
    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    // Pedido
    $reference = $_POST["reference"];
    ?>

    <h1><img src="images/bancos/pix.png"> Pagamento via Pix</h1>

    <?php
    // echo 'QRCODEPIX: '.$QRCODEPIX.'<br>';
    // echo 'refPix: '.$refPixBanco.'<br>';
    // echo 'refPixBanco: '.$refPixBanco.'<br>';
    // echo 'refPixx: '.$refPixx.'<br>';
    // Muda o status
    $query = $pdo->query("UPDATE controle SET metodo='Pix', status='Em Análise' WHERE cod_pagamento='$reference'");
    // Faz a consulta para ver se foi pago
    include __DIR__.'/../scripts/gerencianet_pix/consultar-qrcode-dinamico.php';
    $status_compra = $responsex["status"];

    if ($status_compra == 'ATIVA') {

        ?>
        <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <h1><i class="fas fa-hourglass-half"></i> Seu Pagamento esta em <b>Análise</b>!</h1>
            <h3>Status: <b>Em Análise</b></h3>
            <p>Se você já fez o pagamento corretamente usando o QR Code ou o Código do Pix na tela anterior, basta aguardar mais alguns segundos para que nosso sistema localize o seu pedido.</p>
            <hr>
            <p style="font-size:22px;"><a href="https://www.epapodetarot.com.br/minha-conta">Clique Aqui, para acompanhar sua compra e ver o status atualizado!</a></p>
            <hr>
        </div>
        <?php

    } elseif ($status_compra == 'CONCLUIDA') {

        //Atualiza a fatura para pago.
        if ($tipo=="padrao") {
            // consulta via chat
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
        } elseif ($tipo=="whatsapp") {
            // consulta via whatsapp
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
            $consultawhatsapp="Para realizar sua consulta via whatsapp, <a href='https://api.whatsapp.com/send?phone=55&text=Olá É Papo de Tarot, Gostaria de agendar minha consulta via WhatsApp!' target='_blank'>CLIQUE AQUI.</a>";
        } elseif ($tipo=="email") {
            // consulta via e-mail
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
            $consultaEmail="Responda essa mensagem para realizar sua consulta via e-mail.";
        } elseif ($tipo=="loja") {
            # produto da loja
            $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
            $produtoLoja="Estamos preparando o seu pedido, em breve você recebera mais informações.";
        }

        //Verifica Saldo do Cliente
        $sql_credito = $pdo->query("SELECT COALESCE(SUM(minutos_dispo), 0) as soma FROM controle WHERE id_nome_cliente='$idclientesite' AND status='PAGO' ");
        $cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
        $valor = $cont["soma"];
        if ($valor <= 0) {
            $valor = 0;
        }
        ?>
        <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <h1><i class="fas fa-glass-cheers"></i> Pagamento Aprovado</h1>
            <hr>
            <?php
            if ($tipo=="padrao") {
                // consulta via chat
                ?>
                <p><?php echo 'Seu saldo atual é de: '.$valor.' Minutos'; ?></p>
                <p><a href="https://www.epapodetarot.com.br/tarologos">Clique aqui para escolher um tarólogo</a></p>
                <?php
            } elseif ($tipo=="whatsapp") {
                // consulta via whatsapp
                ?>
                <p><?php echo $consultawhatsapp; ?></p>
                <?php
            } elseif ($tipo=="email") {
                // consulta via e-mail
                ?>
                <p><?php echo $consultaEmail; ?></p>
                <?php
            } elseif ($tipo=="loja") {
                # produto da loja
                ?>
                <p><?php echo $produtoLoja; ?></p>
                <?php
            } 
            ?>
            <hr>
        </div>
        <?php

    } elseif ($status_compra == 'REMOVIDO_PELO_PSP') {

        ?>
        <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <h1>Pagamento Negado</h1>
            <p>O pagamento foi negado pelo PIX.</p>
            <p style="font-size: 30px;"><a href="<?php echo $urldacopra; ?>">Ok, Quero tentar fazer o pagamento novamente!</a></p>
        </div>
        <?php

    } else {
        
        ?>
        <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <h3>Erro - Desculpe o processamento do seu pagamento falhou.</h3>
            <p>Você pode fazer uma nova tentativa, <a href="<?php echo $urldacopra; ?>">Clique Aqui.</a></p>
        </div>
        <?php
    }
    ?>

    <div class="row mt-4 mb-4">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <center>
                <a href="home" class="btn btn-dark btn-lg btn-block" type="button"><i class="fas fa-arrow-circle-left"></i> VOLTAR AO SITE</a>
            </center>
        </div>
        <div class="col-md-2"></div>
    </div>

    <style>
        #conteudo {
            display: none;
        }
        #menusite {
            display: block !important;
        }
    </style>
<?php
}