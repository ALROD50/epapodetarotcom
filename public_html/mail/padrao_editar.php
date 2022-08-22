<h3 class="text-success">Editar Modelo de E-mail</h3>
<?php
$TinyMce="SIM";
$habilitareditor = 'completo';
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM mail_padrao_modelos WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
    $id=$dadoss66['id'];
    $tipo=$dadoss66['tipo'];
    $modelo=$dadoss66['modelo'];
}

if(isset($_POST['envia'])){
    $tipo = $_POST['tipo'];
    $modelo = $_POST['modelo'];
    $query = $pdo->query("UPDATE mail_padrao_modelos SET 
        tipo='$tipo',
        modelo='$modelo'
    WHERE id='$id'");
    $msgs="Modelo de E-mail Atualizado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=mail/padrao_listar.php&msgs=$msgs'</script>";
}

?>
<span class="small">(*) Preenchimento obrigatório.</span>

<form name="modelos" method="post" action="" class="form-horizontal" style="padding: 15px;">

    <div class="form-group">
        <label for="">Tipo:</label>
        <input type="text" class="form-control" name="tipo" value="<?php echo $tipo; ?>" required autofocus/>
    </div>

    <div class="form-group">
        <label for="">Modelo:</label>
        <textarea class="form-control" name="modelo" style="height:400px;" ><?php echo $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : $modelo; ?></textarea>
    </div>

    <input class="btn btn-primary" type="submit" name="envia" value="Atualiza Modelo"/>
    <input class="btn btn-light" type="button" name="Cancel" value="Cancelar" onclick="window.history.back();" /> 

</form>

<script>$('.voltar').click(function() {history.back()});</script>