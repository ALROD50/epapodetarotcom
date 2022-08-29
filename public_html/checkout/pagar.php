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
require 'processa.php';
?>
<!-- Formulário e Resumo -->
<div id="conteudo">
    <!-- Formulário -->
    <div class="tabbable" style="padding: 15px; background:#ffffffa3;">
        
        <img src="checkout/img/topleft.png" alt="Compra Segura!" title="Compra Segura!" style="max-width: 20px; top: -15px; left: -15px; position: relative;"> <span style="position: relative; bottom: 12px;"><small><?php echo $nome; ?> este é um pagamento seguro.</small></span>

        <div class="card bg-light mb-3 shadow">
    		<div class="card-header"><h4 class="mb-0"><i class="fas fa-credit-card"></i> Resumo da Compra:</h4></div>
    		<div class="card-body">
            	<p><?php echo $demonstrativo;?><br>
            	<b>Total</b>: R$ <?php echo $valor; ?></p>
            </div>
        </div>

        <!-- Cupom de Desconto -->
        <div class="card bg-light mb-3 shadow d-none">
            <div class="card-header"><h4 class="mb-0"><i class="fas fa-cocktail"></i> Você tem um Cupom de desconto?</h4></div>
            <div class="card-body">
                <form class="form-inline" name="Formcupom" action="" method="POST">
                    <input type="hidden" name="valorCupom" value="<?php echo $valor; ?>">
                    <div class="input-group mr-2">
                        <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-gift"></i></div></div>
                        <input type="text" name="cupom" id="cupom" value="" class="form-control" placeholder="Cupom de desconto"/>
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-primary" id="buttoncupom" name="buttoncupom">OK</button>
                        </div>
                    </div>
                    
                </form>
                <p><small>Digite seu cupom na caixa acima, e clique em ok.</small></p>
            </div>
        </div>

        <form id="FormCheckout" action="" method="POST" autocomplete="off" onpaste="return false;" accept-charset="ISO-8859-1">
            <input type="hidden" name="brand">
            <input type="hidden" name="token">
            <input type="hidden" name="senderHash">
            <input type="hidden" name="amount" value="<?php echo $valor; ?>">
            <input type="hidden" name="shippingCoast" value="<?php echo $shippingCoast; ?>">
            <input type="hidden" name="itemDescription1" value="<?php echo $itemDescription1; ?>">
            <input type="hidden" name="reference" value="<?php echo $ref; ?>">
            <input type="hidden" name="idclientesite" value="<?php echo $idclientesite; ?>">
            <input type="hidden" name="emaildocliente" value="<?php echo $email; ?>">
            <input type="hidden" name="Cartao">
            <input type="hidden" name="Boleto">
            <input type="hidden" name="Deposito">
            <input type="hidden" name="Debito">
            <input type="hidden" name="tokenGE">
            <input type="hidden" name="CartaoGE">
            <input type="hidden" name="Pix">

            <!-- Email -->
            <div id="BoxEmail" class="form-group">
                <div class="col-md-12">
                    <hr style="border-top: 3px solid #eee;">
                    <h2>Identificação:</h2>
                    <label id="senderEmailL" class="">E-mail</label>
                    <div class="col-md-6" style="padding-left: 0px;">
                        <div class="input-group">
                            <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-envelope"></i></div></div>
                            <input type="text" name="senderEmail" id="senderEmail" required="required" value="<?php echo $email; ?>" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id); PreenchimentoEmail();" onblur="validacaoEmail(senderEmail);" maxlength="60"/>
                        </div>
                    </div>
                    <p><small>Você receberá o comprovante de pagamento neste e-mail</small></p>
                    <div id="ErrosenderEmail" style="display: none;">
                        <img src="checkout/img/error-icon.png" alt=""> Por favor, informe o seu e-mail corretamente.
                    </div>
                </div>
            </div>

            <!-- CEP -->
            <div id="BoxCEP" class="form-group">
                <div class="col-md-12">                        
                    <hr style="border-top: 3px solid #eee;">
                    <h2>Informe o endereço:</h2>
                    <label id="PostalCodeL">CEP</label>
                    <div class="col-md-6" style="padding-left:0px;">
                        <div class="input-group">
                            <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div></div>
                            <input type="tel" name="PostalCode" id="PostalCode" required value="<?php echo $cep; ?>" class="form-control input-lg cep" onkeyup="pesquisacep(this.value); LimpaBordaVermelha(this.id);" placeholder="00000-000" />
                        </div>
                    </div>
                    <div id="informeocep" class="row">
                        <p><i class="fas fa-map-marked-alt"></i> Informe o CEP do seu endereço para continuar&nbsp;&nbsp;<div class="spinner-grow" role="status" style="width:0.5rem;height:0.5rem;vertical-align: middle;margin-top:16px;"><span class="sr-only"></span></div><div class="spinner-grow" role="status" style="width:0.5rem;height:0.5rem;vertical-align: middle;margin-top:16px;"><span class="sr-only"></span></div><div class="spinner-grow" role="status" style="width:0.5rem;height:0.5rem;vertical-align: middle;margin-top:16px;"><span class="sr-only"></span></div></p>
                    </div>
                    <div id="ErroPostalCode" style="display: none; clear: both;">
                        <img src="checkout/img/error-icon.png" alt=""> Informe o CEP corretamente, apenas números.
                    </div>
                    <div id="NaoEncontrado" style="display: none; clear: both;">
                        <img src="checkout/img/error-icon.png" alt=""> Endereço não encontrado...
                    </div>
                </div>
            </div>

            <!-- Endereço -->
            <div id="CamposEndereco">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="StreetL">Endereço</label>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <input type="text" name="Street" id="Street" required value="<?php echo $endereco; ?>" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);"/>
                            </div>
                            <div id="ErroStreet" style="display: none; clear: both;">
                                <img src="checkout/img/error-icon.png" alt=""> Informe o endereço corretamente.
                            </div>
                        </div>

                        <div class="form-group">
                            <label id="NumberL">Número</label>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <input type="text" name="numBer" id="numBer" required value="<?php echo $numero; ?>" class="form-control input-lg" oninput="validacaoNumber(this.value);" autocomplete="off"/>
                                <p><small>Ex.: 1384</small></p>
                            </div>
                            <div id="ErronumBer" style="display: none; clear: both; color: #ff0000;">
                                <img src="checkout/img/error-icon.png" alt=""> Informe o Número
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Complemento <small>(Opcional)</small></label>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <input type="text" name="complemento" id="complemento" value="<?php echo $complemento; ?>" class="form-control input-lg" />
                                <p><small>Ex.: apartamento 73</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="DistrictL">Bairro</label>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <input type="text" name="District" id="District" required value="<?php echo $bairro; ?>" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);"/>
                            </div>
                            <div id="ErroDistrict" style="display: none; clear: both;">
                                <img src="checkout/img/error-icon.png" alt=""> Informe o bairro corretamente.
                            </div>
                        </div>

                        <div class="form-group">
                            <label id="CityL">Cidade</label>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <input type="text" name="City" id="City" placeholder="Cidade" required value="<?php echo $cidade; ?>" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);"/>
                            </div>
                            <div id="ErroCity" style="display: none; clear: both;">
                                <img src="checkout/img/error-icon.png" alt=""> Informe a cidade corretamente.
                            </div>
                        </div>

                        <div class="form-group">
                            <label id="StateL">Estado</label>
                            <div class="col-md-12" style="padding-left: 0px;">
                                <select name="State" id="State" class="form-control input-lg" onchange="LimpaBordaVermelha(this.id);">
                                    <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option> 
                                    <option value="AC">Acre</option> 
                                    <option value="AL">Alagoas</option> 
                                    <option value="AM">Amazonas</option> 
                                    <option value="AP">Amapá</option> 
                                    <option value="BA">Bahia</option> 
                                    <option value="CE">Ceará</option> 
                                    <option value="DF">Distrito Federal</option> 
                                    <option value="ES">Espírito Santo</option> 
                                    <option value="GO">Goiás</option> 
                                    <option value="MA">Maranhão</option> 
                                    <option value="MT">Mato Grosso</option> 
                                    <option value="MS">Mato Grosso do Sul</option> 
                                    <option value="MG">Minas Gerais</option> 
                                    <option value="PA">Pará</option> 
                                    <option value="PB">Paraíba</option> 
                                    <option value="PR">Paraná</option> 
                                    <option value="PE">Pernambuco</option> 
                                    <option value="PI">Piauí</option> 
                                    <option value="RJ">Rio de Janeiro</option> 
                                    <option value="RN">Rio Grande do Norte</option> 
                                    <option value="RO">Rondônia</option> 
                                    <option value="RS">Rio Grande do Sul</option> 
                                    <option value="RR">Roraima</option> 
                                    <option value="SC">Santa Catarina</option> 
                                    <option value="SE">Sergipe</option> 
                                    <option value="SP">São Paulo</option> 
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                            <div id="ErroState" style="display: none; clear: both;">
                                <img src="checkout/img/error-icon.png" alt=""> Informe o estado corretamente.
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div id="opcoesdepagamento">
                
                <hr style="border-top: 3px solid #eee;">
                <h3><i class="fas fa-th-list"></i> Escolha uma das formas de pagamentos disponíveis:</h3>

                <?php 
                // Mensagem de erro do Paypal
                if(isset($_GET['msgpaypalerro'])) {
                  $msg = $_GET['msgpaypalerro'];
                  ?>
                  <a href="#" id="paypalerro"></a>
                  <div id="paypalerro" class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h2 class="text-danger">Paypal - Compra É Papo de Tarot!</h2>
                    <p>Erro no processamento, a compra não foi realizada :(</p>
                    <p><b>Geralmente este erro é causado por:</b></p>
                    <ul style="margin-left: 50px;">
                      <li>O endereço de cobrança associado ao meio de pagamento escolhido no paypal não pôde ser confirmado.</li>
                      <li>A transação excede o limite do cartão.</li>
                      <li>A transação foi negada pelo emissor do cartão.</li>
                      <li>Cartão, endereços, dados em nome de pessoas diferentes.</li>
                    </ul>
                    <p>Você pode tentar novamente alterando no Paypal o endereço, cartão ou meio de pagamento, certifique-se de que tudo esta correto...</p>
                    <hr>
                    <h3>Tente Novamente Abaixo:</h3>
                    <br>
                  </div>
                  <?php
                }
                ?>
            	
                <ul class="nav nav-tabs flex-column flex-sm-row shadow mb-2 mt-4" id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                    	<a href="#tabCredito" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link active shadow" id="tabCredito-tab" role="tab" aria-controls="tabCredito" aria-selected="true"><i class="far fa-credit-card"></i> Cartão de Crédito</a>
                    </li>

                    <li class="nav-item" role="presentation">
                    	<a href="#tabPaypal" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link shadow" id="tabPaypal-tab" role="tab" aria-controls="tabPaypal" aria-selected="false"><i class="fab fa-cc-paypal"></i> Paypal</a>
                    </li>
                              
                    <li class="nav-item" role="presentation">
                    	<a href="#tabBoleto" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link shadow" id="tabBoleto-tab" role="tab" aria-controls="tabBoleto" aria-selected="false"><i class="fas fa-barcode"></i> Boleto</a>
                    </li>
                   
                    <li class="nav-item d-none" role="presentation">
                    	<a href="#tabDeposito" data-toggle="tab" class="flex-sm-fill text-sm-center nav-link shadow" id="tabDeposito-tab" role="tab" aria-controls="tabDeposito" aria-selected="false"><i class="fas fa-university"></i> Transferência</a>
                    </li>
                </ul>

                <div class="card tab-content p-3 mb-4 shadow mt-2" id="myTabContent" style="border:none; margin-top: -0.5rem !important;">

                    <!-- Cartão de Crédito PagSeguro -->
                    <div class="tab-pane fade show active mb-2" id="tabCredito" role="tabpanel" aria-labelledby="tabCredito-tab">
                    
		                <h2 class="mb-4">Dados do Cartão de Crédito:</h2>
                        
                        <!-- Bandeiras -->
                        <div class="form-group">
                            
                            <label id="creditCardBrandML">Selecione a Bandeira:</label>
                            
                            <label id="bandeirasselect" class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="visa"><img src="checkout/img/visa_cartao.jpg" border="0" align="absmiddle">
                            </label>
                            <label class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="master" ><img src="checkout/img/master_cartao.jpg" border="0" align="absmiddle">
                            </label>
                            <label class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="elo" ><img src="checkout/img/elo_cartao.jpg" border="0" align="absmiddle"> 
                            </label>
                            <label class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="diners" ><img src="checkout/img/diners_cartao.jpg" border="0" align="absmiddle">
                            </label>
                            <label class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="amex" ><img src="checkout/img/amex_cartao.jpg" border="0" align="absmiddle">
                            </label>
                            <label class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="hipercard" ><img src="checkout/img/hipercard_cartao.jpg" border="0" align="absmiddle">
                            </label>
                            <label class="checkbox-inline" onclick="OpPagCard()">
                                <input type="radio" name="creditCardBrand" value="aura"><img src="checkout/img/aura_cartao.jpg" border="0" align="absmiddle">
                            </label>
                            <div id="ErrocreditCardBrand" style="display: none; clear: both;">
                                <img src="checkout/img/error-icon.png" alt=""> Por favor, seleciona uma bandeira.
                            </div>
                        </div>

                        <!-- dados do cartão de crédito -->
                        <div id="OpPagCard" style="display:none;">
                            
                            <hr style="border-top: 3px solid #eee;">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="cardNumberL">Número do cartão</label>
                                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="input-group">
                                                <input type="tel" name="cardNumber" id="cardNumber" placeholder="0000 0000 0000 0000" required value="" class="form-control input-lg cardNumber" autocomplete="off" onkeyup="LimpaBordaVermelha(this.id);"/>
                                                <div class="input-group-prepend"><i class="fas fa-credit-card input-group-text"></i></div>
                                            </div>
                                        </div>
                                        <div id="ErrocardNumber" style="display: none; clear: both;">
                                            <img src="checkout/img/error-icon.png" alt=""> Por favor, informe o número completo do seu cartão de crédito.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <label id="cardExpiryML">Data de validade</label>
                                    <div class="form-row">

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="input-group">
                                                <input type="tel" name="cardExpiryM" id="cardExpiryM" placeholder="Mês" required value="" class="form-control input-lg cardExpiryM" onkeyup="LimpaBordaVermelha(this.id);"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="input-group">
                                                <input type="tel" name="cardExpiryY" id="cardExpiryY" placeholder="Ano" required value="" class="form-control input-lg cardExpiryY" onkeyup="LimpaBordaVermelha(this.id);" />
                                                <div class="input-group-prepend"><i class="fas fa-calendar-alt input-group-text"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                    <p><small>Apenas números</small></p>

                                    <div id="ErrocardExpiryM" style="display: none; clear: both;">
                                        <img src="checkout/img/error-icon.png" alt=""> O mês de validade deve ter 2 digitos.
                                    </div>
                                    <div id="ErrocardExpiryY" style="display: none; clear: both;">
                                        <img src="checkout/img/error-icon.png" alt=""> Informe o ano de validade corretamente.
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="creditCardHolderNameL">Nome do dono do cartão</label>
                                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="input-group">
                                                <input type="text" name="creditCardHolderName" id="creditCardHolderName" placeholder="Nome Como Aparece no Cartão" required value="" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);" />
                                                <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-user"></i></div></div>
                                            </div>
                                            <p><small>Ex.: CARLOS A F DE OLIVEIRA</small></p>
                                        </div>
                                        <div id="ErrocreditCardHolderName" style="display: none; clear: both;">
                                            <img src="checkout/img/error-icon.png" alt=""> Informe o nome e sobrenome do dono como aparece no cartão.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="cardCVCL">Código de segurança <small><a class="btn btn-primary btn-xs" title="Localizando Código de Segurança" role="button" data-toggle="collapse" href="#collapseCodSegu" aria-expanded="false" aria-controls="collapseCodSegu">?</a></small></label>
                                        <div class="col-md-5 col-xs-12" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="input-group">
                                                <input type="tel" name="cardCVC" id="cardCVC" placeholder="000" value="" maxlength="5"  class="form-control input-lg cardCVC" onkeyup="LimpaBordaVermelha(this.id);"/>
                                                <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-key"></i></div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <p><small>Geralmente localizado no verso do cartão.</small></p>
                                    <div id="ErrocardCVC" style="display: none; clear: both;">
                                        <img src="checkout/img/error-icon.png" alt=""> Informe o código de segurança do seu cartão corretamente.
                                    </div>
                                    <div class="collapse panel panel-success" id="collapseCodSegu">
                                        <div class="panel-heading">
                                            <h2>Código de segurança</h2>
                                        </div>
                                        <div class="panel-body">
                                            <p>Para sua segurança, solicitamos que informe alguns números do seu cartão de crédito.</p>
                                            <p><h5><b>Onde encontrar?</b></h5></p>
                                            <p>Informe os <b>três últimos números localizados</b> no verso do cartão.</p>
                                            <img src="checkout/img/default_cart.png" alt="Localizando Código de Segurança" title="Localizando Código de Segurança">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr style="border-top: 3px solid #eee;">

                            <h2>Parcelamento:</h2>

                            <div id="installmentsWrapper" class="field form-group" style="margin-top: 20px;">
                                <label id="select-installmentsL">Pague em até <b>2 Vezes sem juros</b></label>
                                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                    <select name="installments" id="select-installments" class="form-control input-lg" onchange="LimpaBordaVermelha(this.id);" required disabled>
                                        <option selected> Selecione... </option>
                                    </select>
                                    <input type="hidden" name="installmentValue">
                                    <p><small>*O valor mínimo da parcela é R$ 5,00</small></p>
                                </div>
                                <div id="Erroselect-installments" style="display: none; clear: both;">
                                    <img src="checkout/img/error-icon.png" alt=""> Selecione em quantas vezes você deseja parcelar.
                                </div>
                            </div>

                            <hr style="border-top: 3px solid #eee;">

                            <h2>Dados do dono do cartão:</h2>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="creditCardHolderCPFL">CPF do dono do cartão</label>
                                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="input-group">
                                                <input type="tel" name="creditCardHolderCPF" id="creditCardHolderCPF" required value="<?php echo $cpf; ?>" class="form-control input-lg cpf" onkeyup="LimpaBordaVermelha(this.id);"/>
                                                <div class="input-group-prepend"><i class="fas fa-address-card input-group-text"></i></div>
                                            </div>
                                        </div>
                                        <div id="ErrocreditCardHolderCPF" style="display: none; clear: both;">
                                            <img src="checkout/img/error-icon.png" alt=""> Por favor, insira um CPF válido.
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="creditCardHolderPhoneL">Celular do dono do cartão</label>
                                        <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="col-md-3 col-xs-4" style="padding-left: 0px; padding-right: 10px;">
                                                <div class="input-group">
                                                    <input type="tel" name="creditCardHolderAreaCode" id="creditCardHolderAreaCode" placeholder="DDD" required value="<?php echo $ddd; ?>" class="form-control input-lg area" onkeyup="LimpaBordaVermelha(this.id);" />
                                                </div>
                                            </div>

                                            <div class="col-md-9" style="padding-left: 0px; padding-right: 0px; padding-bottom: 15px;">
                                                <div class="input-group">
                                                    <input type="tel" name="creditCardHolderPhone" id="creditCardHolderPhone" required value="<?php echo $numerocel; ?>" class="form-control input-lg phone" onkeyup="LimpaBordaVermelha(this.id);" />
                                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-phone"></i></div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ErrocreditCardHolderAreaCode" style="display: none; clear: both;">
                                            <img src="checkout/img/error-icon.png" alt=""> Informe o código de área válido.
                                        </div>
                                        <div id="ErrocreditCardHolderPhone" style="display: none; clear: both;">
                                            <img src="checkout/img/error-icon.png" alt=""> Informe uma número de celular válido.
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label id="creditCardHolderBirthDateL">Data Nascimento</label>
                                        <div class="col-md-10" style="padding-left: 0px; padding-right: 0px;">
                                            <div class="input-group">
                                                <input type="tel" name="creditCardHolderBirthDate" id="creditCardHolderBirthDate" placeholder="Dia/Mês/Ano" required value="<?php echo $datanascimento; ?>" class="form-control input-lg data-mask" onkeyup="LimpaBordaVermelha(this.id);" />
                                                <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-calendar-alt"></i></div></div>
                                            </div>
                                            <p><small>Ex.: 20/05/1980</small></p>
                                        </div>
                                        <div id="ErrocreditCardHolderBirthDate" style="display: none; clear: both;">
                                            <img src="checkout/img/error-icon.png" alt=""> Por favor, confira se a data de nascimento informada está correta. Exemplo: 20/05/1990.
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="checkadress" class="text-center mt-3" style="display: none;">
                              <div class="spinner-border" role="status" aria-hidden="true"></div>
                              <span>Informe os dados acima para continuar...</span>
                            </div>

                            <hr style="border-top: 3px solid #eee;">

		                    <h2>Endereço da fatura do cartão:</h2>

		                    <div class="row">
		                        <div class="col-md-12">
		                            <div class="col-md-6">
		                                <div class="form-group">
		                                    <label onclick="OpenEndCard()">
		                                        <input type="radio" name="UsarMesmoEndCard" value="sim" onclick="OpenEndCard()" checked> O mesmo informado acima
		                                    </label>
		                                    <div id="EndCardUm" style="margin-top: 10px; display: block; font-size:15px;">
		                                        <input type="text" name="billingAddressStreet" id="billingAddressStreet" value="<?php echo $endereco ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px; min-height: 10px; width:100%;"/>
		                                        <input type="text" name="billingAddressNumber" id="billingAddressNumber" value="<?php echo $numero ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px;min-height: 10px;"/>
		                                        <input type="text" name="billingAddressComplement" id="billingAddressComplement" value="<?php echo $complemento ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px;min-height: 10px;"/>
		                                        <input type="text" name="billingAddressDistrict" id="billingAddressDistrict" value="<?php echo $bairro ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px; min-height: 10px;"/>
		                                        <input type="text" name="billingAddressPostalCode" id="billingAddressPostalCode" value="<?php echo $cep ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px; min-height: 10px;"/>
		                                        <input type="text" name="billingAddressCity" id="billingAddressCity" value="<?php echo $cidade ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px; min-height: 10px;"/>
		                                        <input type="text" name="billingAddressState" id="billingAddressState" value="<?php echo $estado ?>" disabled style="border: none; background: none; color:#000; padding: 0px 0px 0px 5px; min-height: 10px;"/>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="col-md-6">
		                                <div class="form-group">
		                                    <label onclick="CloseEndCard()">
		                                        <input type="radio" name="UsarMesmoEndCard" value="nao" onclick="CloseEndCard()"> Outro endereço
		                                    </label>
		                                    <div id="EndCardDois" style="margin-top: 10px; display: none;">
		                                        <label for="">CEP</label>
		                                        <input type="tel" name="billingAddressPostalCode" id="billingAddressPostalCodex" class="form-control input-lg cep" onkeyup="pesquisacepDois(this.value); LimpaBordaVermelha(this.id);"/>
		                                        <div id="EbillingAddressPostalCode" style="display: none; clear: both;">
		                                            <img src="checkout/img/error-icon.png" alt=""> Informe o CEP corretamente.
		                                        </div>
		                                        <div id="NaoEncontrado" style="display: none; clear: both;">
		                                            <img src="checkout/img/error-icon.png" alt=""> Endereço não encontrado...
		                                        </div>
		                                        <div id="EndDois" style="display: none;">
		                                            <label for="">Rua</label>
		                                            <input type="text" name="billingAddressStreet" id="billingAddressStreetx" value="" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);" />
		                                            <div id="EbillingAddressStreet" style="display: none; clear: both;">
		                                                <img src="checkout/img/error-icon.png" alt=""> Informe a Rua corretamente.
		                                            </div>
		                                            <label for="">Número</label>
		                                            <input type="text" name="billingAddressNumber" id="billingAddressNumberx" value="" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);" />
		                                            <div id="EbillingAddressNumber" style="display: none; clear: both;">
		                                                <img src="checkout/img/error-icon.png" alt=""> Informe o Número corretamente.
		                                            </div>
		                                            <label for="">Complemento</label>
		                                            <input type="text" name="billingAddressComplement" id="billingAddressComplementx" value="" class="form-control input-lg"/>
		                                            <label for="">Bairro</label>
		                                            <input type="text" name="billingAddressDistrict" id="billingAddressDistrictx" value="" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);"/>
		                                            <div id="EbillingAddressDistrict" style="display: none; clear: both;">
		                                                <img src="checkout/img/error-icon.png" alt=""> Informe o Bairro corretamente.
		                                            </div>
		                                            <label for="">Cidade</label>
		                                            <input type="text" name="billingAddressCity" id="billingAddressCityx" value="" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);"/>
		                                            <div id="EbillingAddressCity" style="display: none; clear: both;">
		                                                <img src="checkout/img/error-icon.png" alt=""> Informe a Cidade corretamente.
		                                            </div>
		                                            <label for="">Estado</label>
		                                            <select name="billingAddressState" id="billingAddressStatex" class="form-control input-lg" onchange="LimpaBordaVermelha(this.id);">
		                                                <option value=""></option> 
		                                                <option value="AC">Acre</option>
		                                                <option value="AL">Alagoas</option> 
		                                                <option value="AM">Amazonas</option> 
		                                                <option value="AP">Amapá</option> 
		                                                <option value="BA">Bahia</option> 
		                                                <option value="CE">Ceará</option> 
		                                                <option value="DF">Distrito Federal</option> 
		                                                <option value="ES">Espírito Santo</option> 
		                                                <option value="GO">Goiás</option> 
		                                                <option value="MA">Maranhão</option> 
		                                                <option value="MT">Mato Grosso</option> 
		                                                <option value="MS">Mato Grosso do Sul</option> 
		                                                <option value="MG">Minas Gerais</option> 
		                                                <option value="PA">Pará</option> 
		                                                <option value="PB">Paraíba</option> 
		                                                <option value="PR">Paraná</option> 
		                                                <option value="PE">Pernambuco</option> 
		                                                <option value="PI">Piauí</option> 
		                                                <option value="RJ">Rio de Janeiro</option> 
		                                                <option value="RN">Rio Grande do Norte</option> 
		                                                <option value="RO">Rondônia</option> 
		                                                <option value="RS">Rio Grande do Sul</option> 
		                                                <option value="RR">Roraima</option> 
		                                                <option value="SC">Santa Catarina</option> 
		                                                <option value="SE">Sergipe</option> 
		                                                <option value="SP">São Paulo</option> 
		                                                <option value="TO">Tocantins</option>
		                                            </select>
		                                            <div id="EbillingAddressState" style="display: none; clear: both;">
		                                                <img src="checkout/img/error-icon.png" alt=""> Informe o Estado corretamente.
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>  
		                    </div>

		                    <hr style="border-top: 3px solid #eee;">

		                    <h2>Informe seus dados pessoais:</h2>

		                    <div class="row">
	                            <div class="form-group">
	                            	<div class="row">
		                                <label class="checkbox-horizontal" onclick="CloseDadosPessoaisDois()">
		                                    <input type="radio" name="DadosPessoaisDoisChek" value="sim" onclick="CloseDadosPessoaisDois()" checked> Usar os mesmos dados informados para o cartão
		                                </label>
	                                </div>
									<div class="row">
		                                <label class="checkbox-horizontal" onclick="OpenDadosPessoaisDois()">
		                                    <input type="radio" name="DadosPessoaisDoisChek" value="nao" onclick="OpenDadosPessoaisDois()"> Informar outros dados
		                                </label>
	                                </div>
	                             </div>
	                            <div id="DadosPessoaisDois" style="display: none;">
	                                <!-- Nome e cpf -->
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="">Nome Completo</label>
	                                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
	                                                <div class="input-group">
	                                                    <input type="text" name="senderNamexx" id="senderNamexx" required value="" class="form-control input-lg" onkeyup="LimpaBordaVermelha(this.id);" />
	                                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-user"></i></div></div>
	                                                </div>
	                                            </div>
	                                            <div id="EsenderNamexx" style="display: none; clear: both;">
	                                                <img src="checkout/img/error-icon.png" alt=""> Informe o Nome e Sobrenome Completo corretamente.
	                                            </div>
	                                        </div>
	                                    </div>

	                                    <div class="col-md-6">
	                                        <div class="form-group">
	                                            <label for="">CPF</label>
	                                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
	                                                <div class="input-group">
	                                                    <input type="tel" name="senderCPFxx" id="senderCPFxx" required value="" class="form-control input-lg cpf" onkeyup="LimpaBordaVermelha(this.id);" />
	                                                    <div class="input-group-prepend"><i class="fas fa-address-card input-group-text"></i></div>
	                                                </div>
	                                            </div>
	                                            <div id="EsenderCPFxx" style="display: none; clear: both;">
	                                                <img src="checkout/img/error-icon.png" alt=""> Por favor, insira um CPF válido.
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <!-- Telefone -->
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <label for="">Celular</label>
	                                        <div class="row" style="padding-left: 0px; padding-right: 0px;">
	                                            <div class="col-md-3 col-xs-4" style="padding-left: 0px; padding-right: 10px;">
	                                                <div class="input-group">
	                                                    <input type="tel" name="senderAreaCodexx" id="senderAreaCodexx" placeholder="DDD" required value="" class="form-control input-lg area" onkeyup="LimpaBordaVermelha(this.id);" />
	                                                </div>
	                                            </div>  
	                                            <div class="col-md-9" style="padding-left: 0px; padding-right: 0px;">
	                                                <div class="input-group">
	                                                    <input type="tel" name="senderPhonexx" id="senderPhonexx" required value="" class="form-control input-lg phone" onkeyup="LimpaBordaVermelha(this.id);" />
	                                                    <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-phone"></i></div></div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div id="EsenderAreaCodexx" style="display: none; clear: both;">
	                                            <img src="checkout/img/error-icon.png" alt=""> Informe um DDD válido.
	                                        </div>
	                                        <div id="EsenderPhonexx" style="display: none; clear: both;">
	                                            <img src="checkout/img/error-icon.png" alt=""> Informe um número de celular válido.
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
		                    </div>

		                    <hr style="border-top: 3px solid #eee;">
		                
		                    <div class="row">
		                        <div class="col-md-2"></div>
		                        <div class="col-md-8" style="padding: 0px;">
		                            <center>
		                                <br>
		                                <button id="enviarCartao" name="enviarCartao" class="btn btn-success btn-lg btn-block" type="button" data-loading-text="Aguarde..."><i class="fas fa-check-double"></i> PAGAR</button>
		                                <p><small>Confirmar Pagamento</small></p>
                                        <div id="carregandoPagSeguro" class="text-center mt-3" style="display:none;">
                                          <div class="spinner-border" role="status" aria-hidden="true"></div>
                                          Carregando...
                                        </div>
		                            </center>
		                        </div>
		                        <div class="col-md-2"></div>
		                    </div>

                        </div>
                    </div>

                    <!-- Paypal -->
                    <div class="tab-pane fade show" id="tabPaypal" role="tabpanel" aria-labelledby="tabPaypal-tab">

                        <h2 class="mb-4">Paypal</h2>

                        <p>Faça seu pagamento com cartão de crédito via <b>Paypal</b>.</p>

                        <div id="retorno_sucesso_paypal"></div>

                        <div class="row mb-3">                                            
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <center>
                                    <!-- Paypal -->
                                    <div id="botao_do_paypal" class="text-center">
                                        <img src="images/paypal.png" alt="Pagar com Paypal" title="Pagar com Paypal" style="max-width: 100%;" />
                                        <p>PAGAR COM CARTÃO DE CRÉDITO VIA PAYPAL<br> <b>Clique no botão abaixo:</b>.</p>
                                    </div>
                                    <div id="paypal-button-containerx"></div>
                                </center>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

                    <!-- Boleto -->
                    <div class="tab-pane fade show" id="tabBoleto" role="tabpanel" aria-labelledby="tabBoleto-tab">

                        <h2 class="mb-4">Boleto</h2>
                        <p><small>Atenção! - A compensão pode levar 2 dias úteis.</small></p>

                        <p>Por gentileza complete os dados abaixo para pagar com boleto bancário:</p>

                        <!-- Nome e cpf -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nome Completo</label>
                                    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                        <div class="input-group">
                                            <input type="text" name="senderName" id="senderName" required  value="<?php echo $nome; ?>" class="form-control" onkeyup="LimpaBordaVermelha(this.id);" />
                                            <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-user"></i></div></div>
                                        </div>
                                    </div>
                                    <div id="EsenderName" style="display: none; clear: both;">
                                        <img src="img/error-icon.png" alt=""> Informe o Nome e Sobrenome corretamente.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">CPF</label>
                                    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                        <div class="input-group">
                                            <input type="tel" name="senderCPF" id="senderCPF" required  value="<?php echo $cpf; ?>" class="form-control cpf" onkeyup="LimpaBordaVermelha(this.id);" />
                                            <div class="input-group-prepend"><i class="fas fa-address-card input-group-text"></i></div>
                                        </div>
                                    </div>
                                    <div id="EsenderCPF" style="display: none; clear: both;">
                                        <img src="img/error-icon.png" alt=""> Por favor, insira um CPF válido.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Telefone -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Celular</label>
                                <div class="row" style="padding-left: 0px; padding-right: 0px;">
                                    <div class="col-md-3 col-xs-4" style="padding-left: 0px; padding-right: 10px;">
                                        <div class="input-group">
                                            <input type="tel" name="senderAreaCode" id="senderAreaCode" placeholder="DDD" required  value="<?php echo $ddd; ?>" class="form-control area" onkeyup="LimpaBordaVermelha(this.id);" />
                                        </div>
                                    </div>  
                                    <div class="col-md-9" style="padding-left: 0px; padding-right: 0px;">
                                        <div class="input-group">
                                            <input type="tel" name="telefone" id="telefone" required  value="<?php echo $numerocel; ?>" class="form-control phone" onkeyup="LimpaBordaVermelha(this.id);" />
                                            <div class="input-group-prepend"><div class="input-group-text"><i class="fas fa-phone"></i></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="EsenderAreaCode" style="display: none; clear: both;">
                                    <img src="img/error-icon.png" alt=""> Informe um DDD válido.
                                </div>
                                <div id="Etelefone" style="display: none; clear: both;">
                                    <img src="img/error-icon.png" alt=""> Informe um número de Celular válido.
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 15px;">
                            <label>Pague com Boleto Bancário</label>
                            <label class="checkbox-inline">
                                <input type="radio" name="boleto" id="boleto" value="boleto" checked> <i class="fas fa-barcode"></i>
                            </label> 
                        </div>

                        <div class="row">
	                        <div class="col-md-2"></div>
	                        <div class="col-md-8" style="padding: 0px;">
	                            <center>
	                                <br>
	                                <button id="enviarBoleto" name="enviarBoleto" class="btn btn-success btn-lg btn-block" type="button" data-loading-text="Aguarde..."><i class="fas fa-check-double"></i> PAGAR</button>
	                                <p><small>Confirmar Pagamento</small></p>
                                    <div id="carregandoBoleto" class="text-center mt-3" style="display:none;">
                                      <div class="spinner-border" role="status" aria-hidden="true"></div>
                                      Carregando...
                                    </div>
	                            </center>
	                        </div>
	                        <div class="col-md-2"></div>
	                    </div>

                    </div>

                    <!-- Depósito -->
                    <div class="tab-pane fade show d-none" id="tabDeposito" role="tabpanel" aria-labelledby="tabDeposito-tab">

                        <h2 class="mb-4">Transferência</h2>

                        <p>Faça seu pagamento via depósito bancário ou transferência online.</p>

                        <h3>Como funciona?</h3>

                        <ul style="word-wrap: break-word; /* quebra texto para baixo */">
                            <p>1.  Escolha o banco no qual deseja fazer a transferência ou depósito, no formulário abaixo. </p>
                            <p>2.  Anote os dados da conta que você escolheu. </p>
                            <p>3.  Clique no botão <b>Pagar</b>. </p>
                            <p>4.  Faça a transferência via internet ou indo até uma agência bancária, caso opte pelo depósito.</p>
                            <p>5.  Guarde seu comprovante. </p>
                            <p>6.  Envie o comprovante no email <b><a href="mailto:epapodetarot@gmail.com">epapodetarot@gmail.com</a></b>.</p>
                            <p>7.  Pronto! Suas informações serão analisadas!</p>
                        </ul>

                        <hr>

                        <div class="form-group" >
                            <p><input type="radio" name="banco" value="Pix" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/pix.png"> <span id="bancozeroL">Pague com o PIX = Use a Chave: <b>341.190.728-27</b></span></p>
                            <p>É rápido e fácil! Transfira de qualquer banco, dia e hora sem pagar taxa.</p>

                            <hr>

                            <p><input type="radio" name="banco" value="Bradesco" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/bradesco.jpg"> <span id="bancoumL">Banco: Bradesco | Agência: 0108-2 | Conta Corrente: 0002379-5 | Favorecido: Alexandre Rodrigues | CPF: 341.190.728-27</span></p>

                            <hr>

                            <p><input type="radio" name="banco" value="Itaú" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/itau.jpg"> <span id="bancodoisL">Banco: Itaú | Agência: 0081 | Conta Corrente: 07668-9 | Favorecido: Alexandre Rodrigues | CPF: 341.190.728-27</span></p>

                            <hr>

                            <p><input type="radio" name="banco" value="Gerencianet" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/Gerencianet.jpg"> <span id="bancotresL">Banco: Gerencianet | AG: 0001 | CC: 252339-6 | Favorecido: Alexandre Rodrigues | CPF: 341.190.728-27</span></p>

                            <hr>

                            <p><input type="radio" name="banco" value="Nubank" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/Nubank.jpg"> <span id="bancoquatroL">Banco: Nubank (0260) | AG: 0001 | CC: 38180229-9 | Favorecido: Alexandre Rodrigues | CPF: 341.190.728-27</span></p>

                            <hr>

                            <p><input type="radio" name="banco" value="Pagseguro" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/PagSeguro.jpg"> <span id="bancocincoL">Banco: PagSeguro | Banco: 290 | Agência: 0001 | Conta: 02408848-6 | Favorecido: Alexandre Rodrigues | CPF: 341.190.728-27</span></p>

                            <hr>

                            <p><input type="radio" name="banco" value="Mercado Pago" onchange="LimpaBordaVermelha(this.id);" /> <img src="images/bancos/mercadopago.jpg"> <span id="bancoseisL">Banco: Mercado Pago | Banco: 323 | Agência: 0001 | Conta: 4533735909-3 | Favorecido: Alexandre Rodrigues | CPF: 341.190.728-27</span></p>
                        </div>

                        <hr style="border-top: 3px solid #eee;">

                        <div id="Errobanco" style="display: none; clear: both;">
                            <img src="img/error-icon.png" alt=""> Selecione um banco para fazer o depósito ou transferência.
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <center>
                                    <br>
                                    <button id="enviarDeposito" name="enviarDeposito" class="btn btn-success btn-lg btn-block" type="button" data-loading-text="Aguarde..."><i class="fas fa-check-double"></i> PAGAR</button>
                                    <p><small>Confirmar Pagamento</small></p>
                                    <div id="carregandoDeposito" class="text-center mt-3" style="display:none;">
                                      <div class="spinner-border" role="status" aria-hidden="true"></div>
                                      Carregando...
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

                    <center><p style="font-size:65%;"><i class="fas fa-hands-helping"></i><a href="https://www.epapodetarot.com.br/politica-de-privacidade-e-termos-de-uso" target="_blank"> Eu <?php echo $nome; ?> li e aceito os termos de uso do É Papo de Tarot.</a></p></center>

                </div>
            </div>
        </form>
    </div> 
</div>