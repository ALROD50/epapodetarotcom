<form action="" method="post" style="margin: 10px 0 10px 0;" class="form-inline">
	Filtro&nbsp;
	<!-- Ano -->
	<?php 
	$ano_atual = date('Y'); 
	$ano_passado = $ano_atual - 1; 
	?>
	<select name="ano" id="ano" class="input-medium form-control">
		<option value="<?php echo $ano_atual ?>" selected="selected">--Ano <?php echo $ano_atual ?>--</option>
		<option value="<?php echo $ano_passado ?>" >--Ano <?php echo $ano_passado ?>--</option>
	</select>&nbsp;&nbsp;

	<input type="submit" name="filtros" value="ok" class="btn btn-sm btn-primary"/>
</form>
<?php

//Ano
$ano = @$_POST['ano']; 
$ano_escolhido = $ano_atual;

//Ano escolhid0
if (!empty($ano) )
{ 
  $ano_escolhido = "$ano";
}
// Console de teste do filtro
// echo "ler-status ".$status_escolhido.'<br>';
// echo "ler-ordemv ".$ordemv_escolhida.'<br>';
// echo "ler-nome ".$filtro_nome_cliente_escolhido.'<br>';
// echo "ler-id ".$filtro_id_escolhido.'<br>';                 
// echo "ler-lixeira = ".$lixeirav_escolhida.'<br>';  
?>