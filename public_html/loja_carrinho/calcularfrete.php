<?php
// http://www2.correios.com.br/sistemas/precosPrazos/
// (-1) - ERP-013: Vlr declarado nao permitido, aceito entre R$ 20,50 e R$ 3000,00.
#
#
#
$cep_origem = "11250-261";     // Seu CEP , ou CEP da Loja
$cep_destino = $cep; // CEP do cliente, que irá vim via POST

/* DADOS DO PRODUTO A SER ENVIADO */
$peso          = $peso;
$valor         = $precobd;
$tipo_do_frete = '41106'; //Sedex: 40010   |  Pac: 41106
$altura        = $altura;
$largura       = $largura;
$comprimento   = $comprimento;

// console
// echo 'cep_origem: '.$cep_origem.'<br>';
// echo 'cep_destino: '.$cep_destino.'<br>';
// echo 'peso: '.$peso.'<br>';
// echo 'valor: '.$valor.'<br>';
// echo 'altura: '.$altura.'<br>';
// echo 'largura: '.$largura.'<br>';
// echo 'comprimento: '.$comprimento.'<br>';

$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
$url .= "nCdEmpresa=";
$url .= "&sDsSenha=";
$url .= "&sCepOrigem=" . $cep_origem;
$url .= "&sCepDestino=" . $cep_destino;
$url .= "&nVlPeso=" . $peso;
$url .= "&nVlLargura=" . $largura;
$url .= "&nVlAltura=" . $altura;
$url .= "&nCdFormato=1";
$url .= "&nVlComprimento=" . $comprimento;
$url .= "&sCdMaoProria=n";
// $url .= "&nVlValorDeclarado=" . $valor;
$url .= "&sCdAvisoRecebimento=n";
$url .= "&nCdServico=" . $tipo_do_frete;
$url .= "&nVlDiametro=0";
$url .= "&StrRetorno=xml";
$xml = simplexml_load_file($url);
$frete =  $xml->cServico;
// $xml->set_output("json");
// $xml = json_decode($xml, true);
// fre grátis produto digital
if ($altura == "0" AND $largura == "0" AND $comprimento == "0" AND $peso == "0") {

	$valorFrete = '0.00';
	$PrazoEntregaFrete = '1';

} else {

	// Frete normal
	if ($frete->Valor == '0,00' OR $frete->PrazoEntrega == '') {
		echo "<h4>Ops... Não foi possível calcular este frete.</h4>";
		$erroFrete = $frete->Erro;
		if ($erroFrete == '') {
			echo "<h4>Tente novamente mais tarde...</h4>";
		} else {
			echo "<h4>Erro: ". $frete->Erro."</h4>";
			echo "<h4>Você pode fazer um novo teste usando outro CEP.</h4>";
		}
	} else {
		$valorFrete = $frete->Valor;
		$valorFrete = str_replace(",",".",str_replace(".","",$valorFrete));
		$PrazoEntregaFrete = $frete->PrazoEntrega;
	}
}
// echo "<pre>";
// print_r(var_dump($xml));
// echo "</pre>";
?>