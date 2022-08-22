<?php
$TinyMce="SIM";
$habilitareditor = 'completo';
if(isset($_POST['envia'])){

    $tipo = $_POST['tipo'];
    $modelo = $_POST['modelo'];
     
    $pdo->query("INSERT INTO mail_padrao_modelos (
        tipo,
        modelo
    ) VALUES (
        '$tipo',
        '$modelo'
    )");

    $msgs="Modelo de E-mail Criado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=mail/padrao_listar.php&msgs=$msgs'</script>";
}
?>

<h3 class="text-success">Criar Novo Modelo de E-mail</h3>
<hr>

<form name="modelos" method="post" action="" class="form-horizontal" style="padding: 15px;">

    <div class="form-group">
        <label for="">Tipo:</label>
        <input type="text" class="form-control" name="tipo" value="" required autofocus>
    </div>

    <div class="form-group">
        <label for="">Modelo:</label>
        <textarea class="form-control" name="modelo" style="height:400px;" ></textarea>
    </div>

    <input class="btn btn-primary" type="submit" name="envia" value="Criar Modelo"/>
    <input class="btn btn-light" type="button" name="Cancel" value="Cancelar" onclick="window.history.back();" /> 

</form>

<script>$('.voltar').click(function() {history.back()});</script>