<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8

$data_hoje = date('Y-m-d');
$dia = date('d');
$mes = date('m');
$ano = date('Y');

$id = @$_GET['id'];

//Estancia dados de cadastro do usuário
$dadoss3 ="SELECT * FROM clientes WHERE id='$id'"; 
$executa3=$pdo->query( $dadoss3);
while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
  $cliente_nome=$dadoss3['nome'];
  $cliente_email=$dadoss3['email'];
  $cliente_user=$dadoss3['usuario'];

  $data_registro=$dadoss3['data_registro'];
  $data_registro=MostraDataCorretamenteHora($data_registro);

  $aceita_termos_uso=$dadoss3['aceita_termos_uso'];
  $conversa_no_email=$dadoss3['conversa_no_email'];
  $como_nos_conheceu=$dadoss3['como_nos_conheceu'];
  $data_nascimento=$dadoss3['data_nascimento'];
  $novidades=$dadoss3['receber_email'];
  
  $telefone=$dadoss3['telefone'];
  $cpf=$dadoss3['cpf'];
  $endereco=$dadoss3['endereco'];
  $numero=$dadoss3['numero'];
  $complemento=$dadoss3['complemento'];
  $cep=$dadoss3['cep'];
  $bairro=$dadoss3['bairro'];
  $cidade=$dadoss3['cidade'];
  $estado=$dadoss3['estado'];

  $telefoneW =  remover_caracter($telefone); 
  $telefoneW =  preg_replace("/_/", "", $telefoneW);
}
$data_nascimento = MostraDataCorretamente ($data_nascimento);

if ($conversa_no_email == '') {
  $conversa_no_email = "SIM";
}

//Verifica se cliente tem crédito
$sql_credito = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$id' AND status='PAGO' "); 
$cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
$valor = $cont["soma"];
if ($valor=="") {
  $valor = "0";
}
?>
<h3 class="text-success">Cliente</h3>
<hr>

<div class="row">
  <div class="col-md-6">
    <div class="card card-body" style="background:#fff; color:#383C3F;">
        <p class="mb-0">Registro: <strong><?php echo $data_registro; ?></strong></br>
        Nome do Cliente: <strong><?php echo $cliente_nome; ?></strong></br>
        Usuário: <strong><?php echo $cliente_user; ?></strong></br>
        E-mail: <strong><?php echo $cliente_email; ?></strong></br>
        Minutos Disponíveis: <strong><?php echo $valor; ?></strong></p>

        <form name="logar_cliente" id="logar_cliente"  action="" method="post" style="margin: 5px 0 5px 0;">
          <button class="btn btn-danger" name="logar_como_cliente" type="submit"><i class="fas fa-eye"></i> Logar Como Cliente</button>
        </form>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-body" style="background:#fff; color:#383C3F;">
      <p class="mb-0">Telefone: <strong><?php echo $telefone; ?></strong> - <a href="https://api.whatsapp.com/send?phone=55<?php echo $telefoneW; ?>&text=Oi <?php echo $nome; ?>, tudo bem? Sou a Patricia aqui do É Papo de Tarot, vi que é nova no site. Posso te ajudar a fazer sua consulta com nossos tarólogos?" target="_Blank"><i class="fab fa-whatsapp"></i>WhatsApp</a></br>
      CPF: <strong><?php echo $cpf; ?></strong></br>
      CEP: <strong><?php echo $cep; ?></strong></br>
      Endereco: <strong><?php echo $endereco; ?></strong></br>
      Numero: <strong><?php echo $numero; ?></strong></br>
      Complemento: <strong><?php echo $complemento; ?></strong></br>
      Bairro: <strong><?php echo $bairro; ?></strong></br>
      Cidade: <strong><?php echo $cidade; ?></strong></br>
      Estado: <strong><?php echo $estado; ?></strong></br>
      Aceita Termos de Uso: <strong><?php echo $aceita_termos_uso; ?></strong></br>
      Conversa no Email: <strong><?php echo $conversa_no_email; ?></strong></br>
      Como Nos Conheceu: <strong><?php echo $como_nos_conheceu; ?></strong></br>
      Data Nascimento: <strong><?php echo $data_nascimento; ?></strong></br>
      Novidades: <strong><?php echo $novidades; ?></strong></p>
    </div>
  </div>
</div>

