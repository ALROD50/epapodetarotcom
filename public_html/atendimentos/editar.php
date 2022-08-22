<h3 class="text-success">Editar Atendimento</h3>
<?php
$id = @$_GET['id'];
$sql = $pdo->query("SELECT * FROM atendimento WHERE id='$id'");
while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) {  
    $id=$mostrar['id'];
    $id_cliente=$mostrar['id_cliente'];
    $id_tarologo=$mostrar['id_tarologo'];
    $cod_consulta=$mostrar['cod_consulta'];
    $data=$mostrar['data'];
    $data=MostraDataCorretamenteHora($data);
    $duracao=$mostrar['duracao'];
    $cred_inicial=$mostrar['cred_inicial'];
    $cred_final=$mostrar['cred_final'];
    $registroux=$mostrar['registrou'];
    $paginax=$mostrar['pagina'];

    //Estancia dados do tarólogo
    $dadoss4 = "SELECT * FROM clientes WHERE id='$id_tarologo'"; 
    $executa4=$pdo->query( $dadoss4);
      while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
      $tarologo_id=$dadoss4['id'];
      $tarologo_nome=$dadoss4['nome'];
    }
    $row = $executa4->rowCount();
    if ($row == 0) { $tarologo_nome=""; }

    //Estancia dados do cliente
    $dadoss3 = "SELECT * FROM clientes WHERE id='$id_cliente'"; 
    $executa3=$pdo->query( $dadoss3);
      while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
      $cliente_id=$dadoss3['id'];
      $cliente_nome=$dadoss3['nome'];
    }
    $row = $executa3->rowCount();
    if ($row == 0) { $cliente_nome=""; }

    // Revisa o tempo da consulta
    //Pega a o primeiro registro
    $dadoss ="SELECT * FROM chat WHERE cod_sala='$cod_consulta' ORDER BY id DESC "; //acessa todos os dados do usuário $NOME da url
    $executa=$pdo->query( $dadoss); //se conecta no banco e concatena os dados
    while ( $mostrartempo = $executa->fetch(PDO::FETCH_ASSOC) ) { 
      $horaInicio=$mostrartempo['datahora'];
    }
    // Pega o último registro.
    $dadoss1 ="SELECT * FROM chat WHERE cod_sala='$cod_consulta' ORDER BY id ASC "; //acessa todos os dados do usuário $NOME da url
    $executa1=$pdo->query( $dadoss1); //se conecta no banco e concatena os dados
    while ( $mostrartempo1 = $executa1->fetch(PDO::FETCH_ASSOC) ) { 
      $horaFim=$mostrartempo1['datahora'];
    }
    $resultado = datediff('n', $horaInicio, $horaFim, false);

    // Crédito / Tempo Restante do Cliente Atualizado Após Atendimento
    $tempo_restante = $cred_inicial - $resultado;
}

if ( isset($_POST["salva"]) ) {

    $id = $_POST['id']; 
    $duracao = $_POST['duracao']; 
    $cred_inicial = $_POST['cred_inicial'];
    $cred_final = $_POST['cred_final'];

    $query = $pdo->query( "UPDATE atendimento SET 
    	duracao='$duracao',
        cred_inicial='$cred_inicial',
    	cred_final='$cred_final'
    WHERE id='$id'");

    $msgs="Atendimento Atualizado Com Sucesso!";
    echo "<script>document.location.href='minha-conta/?pg=atendimentos/atendimento_meses.php&msgs=$msgs'</script>";
}
?>

<form name="editarplano" id="editarplano" method="post" action="" class="form-inline" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<div style="margin:10px;">
    <b>ID:</b>&nbsp;&nbsp;
    <?php echo $id; ?>
</div>

<div style="margin:10px;">
    <b>Cod Consulta:</b>&nbsp;&nbsp;
    <?php echo $cod_consulta; ?>
</div>

<div style="margin:10px;">
    <b>Registrou:</b>&nbsp;&nbsp;
    <?php echo $registroux; ?>
</div>

<div style="margin:10px;">
    <b>Página:</b>&nbsp;&nbsp;
    <?php echo $paginax; ?>
</div>

<div style="margin:10px;">
    <b>Tarologo:</b>&nbsp;&nbsp;
    <?php echo $tarologo_nome; ?>
</div>

<div style="margin:10px;">
    <b>Cliente:</b>&nbsp;&nbsp;
    <?php echo $cliente_nome; ?>
</div>

<div style="margin:10px;">
    <b>Data:</b>&nbsp;&nbsp;
    <?php echo $data; ?>
</div>

<div style="margin:10px;">
    <b>Duração Revisada:</b>&nbsp;&nbsp;
    <?php echo $resultado; ?>
</div>

<div style="margin:10px;">
    <b>Duração:</b>&nbsp;&nbsp;
    <input type="text" name="duracao" value="<?php echo $duracao; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
    <b>Credito inicial:</b>&nbsp;&nbsp;
    <input type="text" name="cred_inicial" value="<?php echo $cred_inicial; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
  <b>Credito final:</b>&nbsp;&nbsp;
  <input type="text" name="cred_final" value="<?php echo $cred_final; ?>" class="form-control"/>
</div>

<div style="margin:10px;">
    <b>Credito final revisado:</b>&nbsp;&nbsp;
    <?php echo $tempo_restante; ?>
</div>

<div class="row col-md-12">
    <input class="btn btn-success mb-3" type="submit" name="salva" value="Atualizar" />
</div>
</form>

<div class="card card-body">
    <?php
    $executa=$pdo->query("SELECT * FROM chat WHERE cod_sala='$cod_consulta' ORDER BY id ASC");
    while ($mostrartempo=$executa->fetch(PDO::FETCH_ASSOC)) {
        $nome=$mostrartempo['nome'];
        $mensagem=$mostrartempo['mensagem'];
        $datahora=$mostrartempo['datahora'];
        $id_cliente=$mostrartempo['id_cliente'];
        $id_tarologo=$mostrartempo['id_tarologo'];
        $datahora = date("d-m-Y H:i:s", strtotime("$datahora"));
        if ($id_cliente == $usuario_id OR $usuario_nivel == 'ADMIN') {
            echo '<p>'.$datahora.' <b>'.utf8_decode($nome).':</b> '.utf8_decode($mensagem).'</p>';
        }
    }
    ?>
</div>