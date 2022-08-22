<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
error_reporting(E_ALL); // Força o PHP a mostrar os erros.
include "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
include "/home/epapodetarotcom/public_html/includes/functions.php";
include "/home/epapodetarotcom/public_html/scripts/PHPMailer-master5.2.22/class.phpmailer.php";
include "/home/epapodetarotcom/public_html/scripts/PHPMailer-master5.2.22/class.smtp.php";
$pdo = conexao();

$data = date('Y-m-d H:m:s');
$id_cliente_carrinho =  $_POST['id_cliente_carrinho'];
$totaldeitens =  $_POST['totaldeitens'];
$valorSUBTOTAL =  $_POST['valorSUBTOTAL'];
$valorSUBTOTAL = str_replace(",",".",str_replace(".","", $valorSUBTOTAL));
$valorFrete =  $_POST['valorFrete'];
$valorFrete = str_replace(",",".",str_replace(".","", $valorFrete));
$PrazoEntregaFrete =  $_POST['PrazoEntregaFrete'];
$valorTotal =  $_POST['valorTotal'];
$nome =  $_POST['nome'];
$telefone =  $_POST['telefone'];
$email =  $_POST['email'];
$endereco =  $_POST['endereco'];
$numero =  $_POST['numero'];
$cep =  $_POST['cep'];
$bairro =  $_POST['bairro'];
$cidade =  $_POST['cidade'];
$estado =  $_POST['estado'];
$complemento = $_POST['complemento'];
$usuario_id = $_POST['usuario_id'];
$demonstrativo = $_POST['demonstrativo'];

// Salva no Carrinho
$pdo->query("INSERT INTO loja_pedidos (
	id_cliente,
	data,
	status_entrega, 
	frete, 
	status_pagamento, 
	nome_destinatario, 
	endereco, 
	bairro,
	numero, 
	complemento, 
	estado, 
	cidade, 
	cep,
	valor, 
	telefone,
	email,
	formPag
) VALUES (
	'$usuario_id',
	'$data',
	'Preparando',
	'$valorFrete',
	'Aguardando',
	'$nome',
	'$endereco',
	'$bairro',
	'$numero',
	'$complemento',
	'$estado',
	'$cidade',
	'$cep',
	'$valorTotal',
	'$telefone',
	'$email',
	''
)");

// Código do ultimo registro
$id_do_pedido = $pdo->lastInsertId();

// Atualiza os produtos na tabela de pedidos
// Seleciona os produtos que estavam nos carrinhos
$sql_produto = $pdo->query("SELECT * FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho' ");
while ($dados = $sql_produto->fetch(PDO::FETCH_ASSOC)) { 
	$id_produto=$dados['id_produto'];
	$id_produto=$id_produto.',';
	$quantidadeselecionada=$dados['quantidade'];
	$quantidadeselecionada=$quantidadeselecionada.',';

	// Adicionando um a um
	$query = $pdo->query("UPDATE loja_pedidos SET 
	    id_produto=CONCAT(id_produto, '$id_produto'),
	    quantidade=CONCAT(quantidade, '$quantidadeselecionada')
	WHERE id='$id_do_pedido' ");
}

// Gera a cobrança
$data_hoje      = date('Y-m-d H:i:s');
$ref            = uniqid(NULL, true);
$vencimento     = date('d-m-Y', strtotime("+1 days"));
$cod            = Codificador::Codifica("$usuario_id, $ref");
$url            = 'https://www.epapodetarot.com.br/pagamentos/pagar.php?cod='.$cod;

// Transforma vencimento em dia util caso necessário
$vencimento = proximoDiaUtil($vencimento, $saida = 'Y-m-d');

$q = $pdo->query("INSERT INTO controle (
    id_nome_cliente,
    minutos,
    minutos_dispo,
    valor,
    cod_pagamento,
    status,
    data,
    metodo,
    tipo,
    vencimento,
    url,
    demonstrativo
) VALUES (
    '$usuario_id',
    '0',
    '0',
    '$valorTotal',
    '$ref', 
    'Aguardando', 
    '$data_hoje',
    '',
    'loja',
    '$vencimento',
    '$url',
	'$demonstrativo'
)");

###################### EMAIL ##############################
$memaildestinatario = $email;
$mnomedestinatario  = $nome;
$massunto           = "Nova Cobrança Gerada É Papo de Tarot";
$mmensagem          = "
	<p>Olá <b>$nome</b>, </p>
	<p>Estes são os dados para realizar sua consulta.</p>
	<strong>Demonstrativo:</strong>  $demonstrativo <br/>
	<strong>Valor:</strong> $valorTotal <br/>
	<strong>Código:</strong> $ref <br/>
	<strong>Data Vencimento:</strong> $vencimento <br/>
	<strong>Link para pagamento:</strong> <a href=".$url.">$url</a> <br/>
	<p>Caso não seja possível clicar no link da cobrança acima, tente copiar todo o endereço e colar na barra de navegação do seu navegador de internet.</p>
	<p>Conclua seu pagamento para realizar sua consulta.</p>
	<p>Para mais detalhes acesse sua conta em:</p>
	<p><b>Minha Conta:</b></p>
	<p><a href='https://www.epapodetarot.com.br/minha-conta/'>https://www.epapodetarot.com.br/minha-conta</a></p>
	<br/>
	<br/>
	<b>É Papo de Tarot</b> <br/>
	Departamento Financeiro <br/>
	contato@epapodetarot.com.br <br/>
	Site: www.epapodetarot.com.br <br/>
";
EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
###################### EMAIL ##############################

echo "<script>document.location.href='https://www.epapodetarot.com.br/pagamentos/pagar.php?cod=$cod'</script>";
?>