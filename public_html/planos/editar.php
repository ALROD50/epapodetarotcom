<h3 class="text-success">Editar Plano de Consulta</h3>
<hr>
<?php
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM planos_consulta WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
    $minutos=$dadoss66['minutos'];
    $bonus=$dadoss66['bonus'];
}
if ( isset($_POST["salva"]) ) {
    $minutos = $_POST['minutos'];
    $bonus = $_POST['bonus'];
    $ref = $minutos;
    $valor = $config_valor_minutos * $minutos;
    $query = $pdo->query("UPDATE planos_consulta SET 
        ref='$ref',
        minutos='$minutos',
        valor='$valor',
        bonus='$bonus'
    WHERE id='$id'");
    $msgs = "Dados Atualizados com sucesso";
    echo "<script>document.location.href='minha-conta/?pg=planos/planos.php&id=$id&msgs=$msgs'</script>";
    exit();
}
?>
<form name="editarplano" id="editarplano" method="post" action=""  class="form-inline"  enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>

    <!-- <div style="margin:10px; display:inline-block;">
        Nº de Referência:&nbsp;&nbsp;
        <input type="text" name="ref" value="<?php //echo $ref; ?>" class="form-control"/>
    </div> -->

    <div style="margin:10px; display:inline-block;">
        Minutos:&nbsp;&nbsp;
        <input type="text" name="minutos" value="<?php echo $minutos; ?>" class="form-control"/>
    </div>

    <!-- <div style="margin:10px; display:inline-block;">
        Valor R$:&nbsp;&nbsp;
        <input type="text" name="valor" value="<?php //echo $valor; ?>" class="form-control"/>
    </div> -->

    <div style="margin:10px; display:inline-block;">
        Bônus em minutos ao comprar esse plano:&nbsp;&nbsp;
        <input type="text" name="bonus" value="<?php echo @$bonus; ?>" class="form-control"/>
    </div>

	<div class="row col-12 my-3">
        <input class="btn btn-success" type="submit" name="salva" value="Salvar Edição" />
    </div>
</form>