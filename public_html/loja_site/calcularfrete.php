<?php
// http://www2.correios.com.br/sistemas/precosPrazos/
// (-1) - ERP-013: Vlr declarado nao permitido, aceito entre R$ 20,50 e R$ 3000,00.
#
#
#
$cep_origem = "11250-261";     // Seu CEP , ou CEP da Loja
$cep_destino = $_POST['cep']; // CEP do cliente, que irá vim via POST
$altura = $_POST['altura'];
$largura = $_POST['largura'];
$comprimento = $_POST['comprimento'];
$peso = $_POST['peso'];
$valor = $_POST['valor'];

/* DADOS DO PRODUTO A SER ENVIADO */
$peso          = $peso;
$valor         = $valor;
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

echo '<br>';
echo '<div class="card card-body" style="background: #fff;">';
	
	// Verifica Frete Grátis
	if ($altura > 100 OR $largura > 100 OR $comprimento > 100) {
		echo "<h4><span style='color:#3dd344'>Frete Grátis!</span></h4>";
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
			echo "<h4>Valor do Frete: R$ <span style='color:#3dd344'>".$frete->Valor."</span><br />Prazo: <span style='color:#3dd344'>".$frete->PrazoEntrega." dias</span></h4>";
		}
	}
echo '</div>';
// echo "<pre>";
// print_r(var_dump($xml));
// echo "</pre>";
?>