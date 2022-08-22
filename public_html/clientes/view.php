<?php
if ($usuario_nivel != 'ADMIN'){echo "<script>document.location.href='https://www.epapodetarot.com.br'</script>"; }
?>     
<?php
$id = $_GET['id']; 
if ($id !== '') {
$dadoss ="SELECT * FROM clientes WHERE id='$id'"; //acessa todos os dados do usuário $NOME da url
$executa=$pdo->query( $dadoss); //se conecta no banco e concatena os dados
while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) { 
  $nome=$dadoss['nome'];
  $email=$dadoss['email'];
  $status=$dadoss['status'];
  $usuario=$dadoss['usuario'];
}
?>

<h3># <?php echo $id.' '.$nome; ?></h3>

<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:15px;">
  <li class="nav-item" role="presentation">
    <a href="#tabGeral" class="nav-link active" aria-selected="true" id="tabGeral-tab" data-toggle="tab" role="tab" aria-controls="tabGeral">Geral</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabCadastro" class="nav-link" aria-selected="false" id="tabCadastro-tab" data-toggle="tab" role="tab" aria-controls="tabCadastro">Dados de Cadastro</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabCompras" class="nav-link" aria-selected="false" id="tabCompras-tab" data-toggle="tab" role="tab" aria-controls="tabCompras">Compras</a>
  </li>
  <li class="nav-item" role="presentation">
    <a href="#tabAtendimentos" class="nav-link" aria-selected="false" id="tabAtendimentos-tab" data-toggle="tab" role="tab" aria-controls="tabAtendimentos">Atendimentos</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent"> 
  <div class="tab-pane fade show active" id="tabGeral" role="tabpanel" aria-labelledby="tabGeral-tab">
    <?php include "geral.php"; ?>
  </div>

  <div class="tab-pane fade" id="tabCadastro" role="tabpanel" aria-labelledby="tabCadastro-tab">
    <?php include "editar.php"; ?>
  </div>

  <div class="tab-pane fade" id="tabCompras" role="tabpanel" aria-labelledby="tabCompras-tab">
    <?php include "compras.php"; ?>
  </div>

  <div class="tab-pane fade" id="tabAtendimentos" role="tabpanel" aria-labelledby="tabAtendimentos-tab">
    <?php include "atendimentos.php"; ?>
  </div>
</div>
<?php
} else {
  echo '<br/>';
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
}
?>