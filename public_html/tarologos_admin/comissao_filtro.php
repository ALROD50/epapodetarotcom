<form action="" method="post" style="margin: 10px 0 10px 0;" class="form-inline">

<b>Filtro</b>&nbsp;

Periodo, Dia:&nbsp;

<input class="form-control" name="datainicial" type="text" id="datepicker5" value="" autocomplete="off" />&nbsp;

Até o Dia:&nbsp;

<input class="form-control" name="datafinal" type="text" id="datepicker6" value="" autocomplete="off" />&nbsp;&nbsp;

<input type="submit" name="filtros" value="ok" class="btn btn-sm btn-primary form-control"/>
</form>
<?php

$datainicialPOST = @$_POST['datainicial'];
$datainicial = date("Y-m-d H:i:s", strtotime("$datainicialPOST"));
$datainicial = str_replace ("69-12-31", "", $datainicial);

$datafinalPOST = @$_POST['datafinal'];
$datafinal = date("Y-m-d H:i:s", strtotime("$datafinalPOST"));
$datafinal = str_replace ("69-12-31", "", $datafinal);

$periodo = "WHERE";

if(!empty($datainicial) && !empty($datafinal) ) {	
	unset($_SESSION['ordem_session']);
	$periodo = "WHERE data BETWEEN '$datainicial' AND '$datafinal' AND ";
	$_SESSION['periodo_session'] = $periodo;

} else { 
	unset($_SESSION['periodo_session']); 
}

// Console de teste do filtro
// echo "ler-status ".$status_escolhido.'<br>';
// echo "ler-ordemv ".$ordemv_escolhida.'<br>';
// echo "ler-nome ".$filtro_nome_cliente_escolhido.'<br>';
// echo "ler-id ".$filtro_id_escolhido.'<br>';                 
// echo "ler-periodo = ".$periodo.'<br>'; 

if(!empty($datainicialPOST) && !empty($datafinalPOST) ) {	

	echo 'Período Selecionado: '.$datainicialPOST. ' Até '.$datafinalPOST.'<br>';

	// comissão
	$sql4 = $pdo->query("SELECT SUM(duracao) as soma6 FROM atendimento WHERE data BETWEEN '$datainicial' AND '$datafinal' ");
	$cont4 = $sql4->fetch(PDO::FETCH_ASSOC);
	$valor44x = $cont4["soma6"]; // Minutos Totais
	$valor = $valor44x * $config_valor_minutos; // Valor em dinheiro
	$comissao_realumaotrinta = CalculaComissao($valor44x, $config_valor_minutos, $config_porcentagem_tarologo);
	echo 'Comissão Total: '.$comissao_realumaotrinta;

} else {

	?>
	<p>Selecione um periodo nos dois campos do filtro, para gerar o relatório de fechamento.</p>
	<?php
}
?>