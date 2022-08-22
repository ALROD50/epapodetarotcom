<?php
//
// Adicionar Créditos
//
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
$DataPicker ="SIM";
$Mask       ="SIM";
if (isset($_GET['cliente']) ){ 
  $cliente=$_GET['cliente'];
  $demonstrativo="Consulta via chat xx Minutos";
  $vencimento     = date('d-m-Y', strtotime("+1 days"));
  $vencimento = proximoDiaUtil($vencimento, $saida = 'd-m-Y');
  $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$cliente' LIMIT 1"); 
  while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)) {
    $nome_cliente_compra=$dados22['nome'];
  }
} else {
  $nome_cliente_compra='--  Cliente  --';
  $cliente=null;
  $demonstrativo=null;
  $vencimento=null;
}
?>
<h3 class="text-success">Adicionar Crédito</h3>
<hr>

<p>10 Minutos = R$ 15,00 / 20 Minutos = R$ 30,00 / 30 Minutos = R$ 45,00 / 40 Minutos = R$ 60,00</p>

<form name="" method="post" action="" class="form-inline">

  <div style="margin:10px; display:inline-block;">
    Nome:&nbsp;&nbsp;
    <select name="nome" class="input-medium form-control">
    <option value="<?php echo $cliente; ?>" selected="selected"> <?php echo $nome_cliente_compra; ?> </option>
    <?php 
      $sql = $pdo->query("SELECT * FROM clientes WHERE nivel = 'CLIENTE' AND status='ATIVO' OR nivel = 'CLIENTE' AND status='SUSPENSO' ORDER BY nome ASC");
      if ($sql->rowCount() == 0) {
          echo '<option value="">Não encontramos nenhum cliente</option>';
      } else { 
        while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)){
        echo '<option value="'.$nomes_encontrados['id'].'">'.$nomes_encontrados['nome'].' - '.$nomes_encontrados['email'].'</option>';
        } }
    ?>
    </select>
  </div>

  <div style="margin:10px; display:inline-block;">
      Minutos:&nbsp;&nbsp;
      <input type="tel" name="minuto" value="" placeholder="00" data-mask="000" class="form-control"/>
  </div>

  <div style="margin:10px; display:inline-block;">
      Valor R$:&nbsp;&nbsp;
      <input type="tel" name="valor" value="" placeholder="00,00" class="form-control"/>
  </div>

  <div style="margin:10px; display:inline-block;">
    Parcelas&nbsp;&nbsp;
    <select required name="parcelas" class="form-control">
      <option value="">--Selecione--</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
      <option value="23">23</option>
      <option value="24">24</option>
    </select>
  </div>

  <div style="margin:10px; display:inline-block;">
      Método:&nbsp;&nbsp;
      <select name="metodo" class="form-control">
        <option value=""></option>
        <option value="Bônus">Bônus</option>
        <option value="PagSeguro">PagSeguro</option>
        <option value="Paypal">Paypal</option>
        <option value="Boleto">Boleto</option>
        <option value="MercadoPago">MercadoPago</option>
        <option value="Bradesco">Bradesco</option>
        <option value="Itaú">Itaú</option>
        <option value="Gerencianet">Gerencianet</option>
        <option value="Nubank">Nubank</option>
        <option value="Pix">Pix</option>
      </select>
  </div>

  <div style="margin:10px; display:inline-block;">
      Vencimento:&nbsp;&nbsp;
      <input type="text" name="vencimento" id="datepicker" value="<?php echo $vencimento; ?>" class="form-control"/>
  </div>

  <div style="margin:10px; margin-bottom: 30px; display:inline-block;">
      Tipo:&nbsp;&nbsp;
      <select name="tipo" class="form-control">
      <option value="padrao">padrao</option>
      <option value="whatsapp">whatsapp</option>
      <option value="email">email</option>
      </select>
  </div>

  <div style="margin:10px; margin-bottom: 30px; display:inline-block;">
      Demonstrativo:&nbsp;&nbsp;
      <input type="text" name="demonstrativo" value="<?php echo $demonstrativo; ?>" class="form-control"/>
  </div>

  <div style="margin:10px; margin-bottom: 30px; display:inline-block;">
      Status:&nbsp;&nbsp;
      <select name="status" class="form-control">
        <option value="Aguardando">Aguardando</option>
        <option value="PAGO">PAGO</option>
        <option value="Cancelada">Cancelada</option>
        <option value="Em análise">Em análise</option>
        <option value="Devolvida">Devolvida</option>
      </select>
  </div>

  <div class="row col-md-12">
    <input class="btn btn-success" type="submit" name="envia" value="Adicionar Crédito"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input class="btn btn-info" type="button" name="Cancel" value="Cancelar" onclick="window.location='minha-conta/?pg=controle/controle.php'" /> 
  </div>
</form>

<?php
if(isset($_POST['envia'])) {

  $id_nome_cliente = $_POST['nome'];
  $valor = $_POST['valor'];
  $valor = str_replace(",",".",str_replace(".","",$valor)); // Formatando para gravar no banco.
  $minuto = $_POST['minuto'];
  $status = $_POST['status'];
  $reference = uniqid(NULL, true);
  $data = date('Y-m-d H:i:s');
  $metodo = $_POST['metodo'];
  $vencimento = $_POST['vencimento'];
  $tipo = $_POST['tipo'];
  $demonstrativo = $_POST['demonstrativo'];
  $parcelas      = trim($_POST['parcelas']);

  $dia_venc_orig  = Data_Mostra_Dia ($vencimento);

  for ($i = 0; $i < $parcelas; $i++) {

    $reference      = uniqid(NULL, true);
    $cod            = Codificador::Codifica("$id_nome_cliente, $reference");
    $url            = 'https://www.tarotdehorus.com.br/pagamentos/pagar.php?cod='.$cod;

    if($i > 0) {
      // Adiciona mais 1 mês na data de vencimento conforme a quantidade de parcelas do loop
      $vencimento = date("d-m-Y", strtotime("+1 month",strtotime($dia_venc_orig.'-'.$mes_vencimento.'-'.$ano_vencimento)));
      // Transforma vencimento em dia util caso necessário
      $vencimento = proximoDiaUtil($vencimento, $saida = 'd-m-Y');
      // Atualiza URL's
      $cod        = Codificador::Codifica("$id_nome_cliente, $reference");
      $url        = 'https://www.tarotdehorus.com.br/pagamentos/pagar.php?cod='.$cod;
    }

    //dia, mes e ano de vencimento novo separados
    $dia_vencimento = Data_Mostra_Dia ($vencimento);
    $mes_vencimento = Data_Mostra_Mes ($vencimento);
    $ano_vencimento = Data_Mostra_Ano ($vencimento);

    $pdo->query( "INSERT INTO controle (
      id_nome_cliente,
      minutos,
      minutos_dispo,
      valor,
      cod_pagamento,
      status,
      data,
      vencimento,
      metodo,
      tipo,
      demonstrativo,
      url
    ) VALUES (
      '$id_nome_cliente',
      '$minuto',
      '$minuto',
      '$valor',
      '$reference', 
      '$status', 
      '$data',
      '$ano_vencimento-$mes_vencimento-$dia_vencimento', 
      '$metodo',
      '$tipo',
      '$demonstrativo',
      '$url'
    )");
  }

  $msgs="Cobrança Gerada Com Sucesso!";
  echo "<script>document.location.href='minha-conta/?pg=controle/controle.php&msgs=$msgs'</script>";
}
?>