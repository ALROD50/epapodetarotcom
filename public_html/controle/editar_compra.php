<h3 class="text-success">Editar Compra</h3>
<?php
$id = @$_GET['id'];
$DataPicker ="SIM";
$executa66 = $pdo->query("SELECT * FROM controle WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
    $id_plano_cliente=$dadoss66['id'];
    $id_nome_cliente=$dadoss66['id_nome_cliente'];
    $ref=$dadoss66['ref'];
    $minutos=$dadoss66['minutos'];
    $valor=$dadoss66['valor'];
    $valor = str_replace(".",",",str_replace(",","",$valor)); // Formatando para gravar no banco.
    $minutos_dispo=$dadoss66['minutos_dispo'];
    $cod_pagamento=$dadoss66['cod_pagamento'];
    $status=$dadoss66['status'];
    $data=$dadoss66['data'];
    $metodo=$dadoss66['metodo'];
    $tipo=$dadoss66['tipo'];
    $demonstrativo=$dadoss66['demonstrativo'];
    $vencimento=$dadoss66['vencimento'];
    $vencimento=MostraDataCorretamenteHora($vencimento);
}
$sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
$rows = $sql22->rowCount();
if ($rows >= 1) {
	while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
  		$nome_cliente_compra=$dados22['nome'];
	}
} else {
	$nome_cliente_compra = "";
}

if ( isset($_POST["salva"]) ) {

    $id = $_POST['id']; 
    $cliente = $_POST['id_cliente']; 
    $minutos = $_POST['minutos'];
    $minutos_dispo = $_POST['minutos_dispo'];
    $metodo = $_POST['metodo'];
    $vencimento = $_POST['vencimento'];
    $vencimento=MudaDataGravarBanco($vencimento);
    $tipo = $_POST['tipo'];
    $demonstrativo = $_POST['demonstrativo'];
    $status = $_POST['status'];
    $valor = $_POST['valor'];
    $valor = str_replace(",",".",str_replace(".","",$valor)); // Formatando para gravar no banco.

    $query = $pdo->query( "UPDATE controle SET 
    	id_nome_cliente='$cliente',
        minutos='$minutos',
    	minutos_dispo='$minutos_dispo',
    	metodo='$metodo',
    	vencimento='$vencimento',
    	tipo='$tipo',
    	demonstrativo='$demonstrativo',
        valor='$valor',
    	status='$status'
    WHERE id='$id'");

    $msgs="Pagamento Atualizado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=controle/controle.php&msgs=$msgs'</script>";
}
?>

<form name="editarplano" id="editarplano" method="post" action="" class="form-inline" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div style="margin:10px;">
    ID:&nbsp;&nbsp;
    <?php echo $id_plano_cliente; ?>
</div>

<div style="margin:10px;">
    Data:&nbsp;&nbsp;
    <?php echo $data; ?>
</div>

<div style="margin:10px;">
    Nº de Referência:&nbsp;&nbsp;
    <?php echo $cod_pagamento; ?>
</div>

<div class="row form-group">
  <label for="id_cliente" class="col-sm-2 control-label">Cliente</label>
  <div class="col-sm-10">
    <select class="form-control" name="id_cliente">
    <option value="<?php echo $id_nome_cliente; ?>" selected="selected"> <?php echo $nome_cliente_compra; ?> </option>
      <?php 
        $sql = $pdo->query("SELECT * FROM clientes WHERE nivel = 'CLIENTE' AND status='ATIVO' ");
        if ($sql->rowCount() == 0) {
            echo '<option value="">Não encontramos nenhum cliente</option>';
        } else { 
            while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
                echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].'</option>';
            }
        }
      ?>
    </select>
  </div>
</div>

<div style="margin:10px;">
    Minutos Contratado:&nbsp;&nbsp;
    <input type="text" name="minutos" value="<?php echo $minutos; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
    Minutos disponíveis:&nbsp;&nbsp;
    <input type="text" name="minutos_dispo" value="<?php echo $minutos_dispo; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
  Valor R$:&nbsp;&nbsp;
  <input type="tel" name="valor" value="<?php echo $valor; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
    Método:&nbsp;&nbsp;
    <input type="text" name="metodo" value="<?php echo $metodo; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
    Vencimento:&nbsp;&nbsp;
    <input type="text" name="vencimento" id="datepicker" value="<?php echo $vencimento; ?>" class="form-control"/>
</div>

<div style="margin:10px; margin-bottom: 30px;">
    Tipo:&nbsp;&nbsp;
    <select name="tipo" class="form-control">
    <?php echo '<option value="'.@$tipo.'">'.@$tipo.'</option>'; ?>
    <option value="padrao">padrao</option>
    <option value="whatsapp">whatsapp</option>
    <option value="email">email</option>
    </select>
</div>

<div style="margin:10px; margin-bottom: 30px;">
    Demonstrativo:&nbsp;&nbsp;
    <input type="text" name="demonstrativo" value="<?php echo $demonstrativo; ?>" class="form-control"/>
</div>

<div style="margin:10px; margin-bottom: 30px;">
    Status:&nbsp;&nbsp;
    <select name="status" class="form-control">
    <?php echo '<option value="'.@$status.'">'.@$status.'</option>'; ?>
    <option value="PAGO">PAGO</option>
    <option value="Aguardando">Aguardando</option>
    <option value="Cancelada">Cancelada</option>
    <option value="Em análise">Em análise</option>
    <option value="Devolvida">Devolvida</option>
    </select>
</div>

<div class="row col-md-12">
    <input class="btn btn-success" type="submit" name="salva" value="Atualizar" />
</div>
</form>