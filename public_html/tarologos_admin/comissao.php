<h3 class="text-success">Fechamento de Comissões.</h3>
<hr>
<?php
$DataPicker="SIM";
//Inclui o filtro
include "comissao_filtro.php";
$sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' ORDER BY usuario ASC ");
$row = $sql->rowCount();
if ($row > 0){
?>
<div class="table-responsive">
  <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th> ID</th>
        <th> Nome</th>
        <th> Email</th>
        <th> Valor do Minuto</th>
        <th> % Tarólogo</th>
        <th> Minutos</th>
        <th> Valor em Reais</th>
        <th> Comissão</th>
      </tr>
    </thead>
    <tbody>
    <?php
      // Dado de cadastro dos tarólogos
      while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){ 
      $id=$mostrar['id'];
      $nome=$mostrar['nome'];
      $email=$mostrar['email'];

      // soma minutos atendidos 
      $sql4 = $pdo->query("SELECT SUM(duracao) as soma4 FROM atendimento $periodo id_tarologo='$id' ");
      $cont4 = $sql4->fetch(PDO::FETCH_ASSOC);
      $valor44 = $cont4["soma4"]; // Minutos Totais
      $valor = $valor44 * $config_valor_minutos; // Valor em dinheiro
      $comissao_real = CalculaComissao($valor44, $config_valor_minutos, $config_porcentagem_tarologo); // Comissão
    ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo "<a href='minha-conta/?pg=tarologos_admin/view.php&id=$id' data-toggle='tooltip' title='$nome'>$nome</a>"; ?></td>
        <td><?php echo $email; ?></td>
        <td>R$ <?php echo $config_valor_minutos; ?></td>
        <td><?php echo $config_porcentagem_tarologo; ?> %</td>
        <td><?php echo $valor44; ?></td>
        <td><?php echo 'R$ '.$valor; ?></td>
        <td><?php echo 'R$ '.$comissao_real; ?></td>
<?php } ?>
      </tr>
    </tbody>
  </table>
</div>
<?php
}else{
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
}