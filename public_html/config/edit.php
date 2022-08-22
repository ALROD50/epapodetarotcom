<h3 class="text-success">Configurações de Sistema</h3>

<?php
$executa66 = $pdo->query("SELECT * FROM config WHERE id='1' "); //se conecta no banco e concatena os dados

while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){

	$id= $dadoss66['id'];
	$paypal=$dadoss66['paypal'];
	$pagseguro=$dadoss66['pagseguro'];
  $transf_manual=$dadoss66['transf_manual'];
  $valor_minutos=$dadoss66['valor_minutos'];
  $porcentagem_tarologo=$dadoss66['porcentagem_tarologo'];
  $bonus_plano=$dadoss66['bonus_plano'];
  $preco_consulta_email=$dadoss66['preco_consulta_email'];
}
?>

<?php // SALVA ALTERAÇÃO
if ( isset($_POST["salva"]) ) {

	$paypal        = $_POST['paypal'];
	$pagseguro     = $_POST['pagseguro'];
  $transf_manual = $_POST['transf_manual'];
  $valor_minutos = $_POST['valor_minutos'];
  $porcentagem_tarologo = $_POST['porcentagem_tarologo'];
  $bonus_plano   = $_POST['bonus_plano'];
  $preco_consulta_email   = $_POST['preco_consulta_email'];

	$query = $pdo->query( "UPDATE config SET paypal='$paypal',
		pagseguro='$pagseguro',
    transf_manual='$transf_manual',
    valor_minutos='$valor_minutos',
    porcentagem_tarologo='$porcentagem_tarologo',
    bonus_plano='$bonus_plano',
    preco_consulta_email='$preco_consulta_email'
	WHERE id='$id' ");
	    
	$msgs = "Dados Atualizados Com Sucesso!";
	echo "<script>document.location.href='minha-conta/?pg=config/edit.php&msgs=$msgs'</script>";
	exit();          
}
?>

<form name="config" id="config" method="post" action=""  class="form-horizontal"  enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div class="form-group">
  <label for="pagseguro" class="control-label">Habilitar PagSeguro:</label>
  <div class="col-sm-5">
    <select name="pagseguro" class="form-control">&nbsp;&nbsp;
    	<option value="<?php echo $pagseguro; ?>"><?php echo $pagseguro; ?></option>
        <option value="SIM">SIM</option> 
        <option value="NAO">NÃO</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="paypal" class="control-label">Habilitar PayPal:</label>
  <div class="col-sm-5">
    <select name="paypal" class="form-control">&nbsp;&nbsp;
    	<option value="<?php echo $paypal; ?>" ><?php echo $paypal; ?></option>
        <option value="SIM">SIM</option> 
        <option value="NAO">NÃO</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="transf_manual" class="control-label">Habilitar Transferência Bancária Manual:</label>
  <div class="col-sm-5">
    <select name="transf_manual" class="form-control">&nbsp;&nbsp;
      <option value="<?php echo $transf_manual; ?>"><?php echo $transf_manual; ?></option>
        <option value="SIM">SIM</option> 
        <option value="NAO">NÃO</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="valor_minutos" class="control-label">Valor do Minuto: R$</label>
  <div class="col-sm-5">
    <input type="text" name="valor_minutos" class="form-control" value="<?php echo $valor_minutos; ?>">
  </div>
</div>

<div class="form-group">
  <label for="porcentagem_tarologo" class="control-label">Porcentagem Comissão do Tarólogo Em: %</label>
  <div class="col-sm-5">
    <input type="text" name="porcentagem_tarologo" class="form-control" value="<?php echo $porcentagem_tarologo; ?>">
  </div>
</div>

<div class="form-group">
  <label for="bonus_plano" class="control-label">Habilitar Bônus nos Planos:</label>
  <div class="col-sm-5">
    <select name="bonus_plano" class="form-control">&nbsp;&nbsp;
      <option value="<?php echo $bonus_plano; ?>"><?php echo $bonus_plano; ?></option>
        <option value="SIM">SIM</option> 
        <option value="NAO">NÃO</option>
    </select>
  </div>
</div>

<div class="form-group">
  <label for="preco_consulta_email" class="control-label">Preço Consulta por E-mail Em Minutos:</label>
  <div class="col-sm-5">
    <input type="text" name="preco_consulta_email" class="form-control" value="<?php echo $preco_consulta_email; ?>">
  </div>
</div>

<p>
  <input class="btn btn-success" type="submit" name="salva" value="Salvar Configurações" />
</p>
</form>