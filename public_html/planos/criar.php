<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "includes/conexaoPdo.php";
$pdo = conexao();
?>
<h3 class="text-success">Cadastrar Novo Plano de Minutos</h3>

<?php
if(isset($_POST['envia'])){

    $minutos = $_POST['minutos'];
    $bonus = $_POST['bonus'];

    $ref = $minutos;
    $valor = $config_valor_minutos * $minutos;
     
    $q = $pdo->query("INSERT INTO planos_consulta (
        ref,
        minutos,
        valor,
        bonus
        ) VALUES (
        '$ref',
        '$minutos',
        '$valor',
        '$bonus'
        )");
       $msgs="Registro Criado Com Sucesso!";
       echo "<script>document.location.href='minha-conta/?pg=planos/planos.php&msgs=$msgs'</script>";
}

?>

<form name="tarologos" method="post" action="" class="form-inline" enctype="multipart/form-data">

<!-- <div style="margin:10px; display:inline-block;">
    Nº de Referência:&nbsp;&nbsp;
    <input type="text" name="ref" value="<?php //echo @$ref; ?>" class="form-control"/>
</div> -->

<div style="margin:10px; display:inline-block;">
    Minutos:&nbsp;&nbsp;
    <input type="text" name="minutos" value="<?php echo @$minutos; ?>" class="form-control"/>
</div>

<!-- <div style="margin:10px; display:inline-block;">
    Valor R$:&nbsp;&nbsp;
    <input type="text" name="valor" value="<?php //echo @$valor; ?>" class="form-control"/>
</div> -->

<div style="margin:10px; display:inline-block;">
    Bônus em minutos ao comprar esse plano:&nbsp;&nbsp;
    <input type="text" name="bonus" value="<?php echo @$bonus; ?>" class="form-control"/>
</div>

<input class="btn btn-primary" type="submit" name="envia" value="Criar Plano de Consulta"/>

</form>