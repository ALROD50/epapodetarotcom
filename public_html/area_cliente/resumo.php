<?php
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
//Estancia dados de cadastro do usuário
$dadoss3 ="SELECT * FROM clientes WHERE id='$usuario_id'"; 
$executa3=$pdo->query($dadoss3);
while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
  $cliente_nome=$dadoss3['nome'];
  $cliente_email=$dadoss3['email'];
  $cliente_user=$dadoss3['usuario'];
  $endereco=$dadoss3['endereco'];
  $nome=$dadoss3['nome'];
  $email=$dadoss3['email'];
  $usuario=$dadoss3['usuario'];
  $telefone=$dadoss3['telefone'];
  $cidade=$dadoss3['cidade'];
  $estado=$dadoss3['estado'];
  $numero=$dadoss3['numero'];
  $cep=$dadoss3['cep'];
  $complemento=$dadoss3['complemento'];
  $bairro=$dadoss3['bairro'];
  $cpf=$dadoss3['cpf'];
  $data_nascimento=$dadoss3['data_nascimento'];
  $data_nascimento = date("d-m-Y", strtotime("$data_nascimento"));
  if ($data_nascimento == "30-11--0001") {
    $data_nascimento = "";
  }
}

// ########################## DETECTA BROWSER, SEO, VERSION, PLATAFORM
// $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
// $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
// $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
// $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
// $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
// $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
// $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
// function getBrowser() { 
//   $u_agent = $_SERVER['HTTP_USER_AGENT']; 
//   $bname = 'Unknown';
//   $platform = 'Unknown';
//   $version= "";
//   //First get the platform?
//   if(preg_match('/linux/i', $u_agent)) {
//       $platform = 'Linux';
//   }
//   elseif(preg_match('/macintosh|mac os x/i', $u_agent)) {
//       $platform = 'Mac';
//   }
//   elseif(preg_match('/Windows NT 10.0/i', $u_agent)) {
//       $platform = 'Windows 10';
//   }
//   elseif(preg_match('/windows|win32/i', $u_agent)) {
//       $platform = 'Windows';
//   }

//   //should I add support for 128 bit?? :D
//   if(preg_match('/WOW64/i', $u_agent)) {
//       $bit = '64';
//   }
//   else {
//       $bit = '32';
//   }
      
//   // Next get the name of the useragent yes seperately and for good reason
//   if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
//   { 
//       $bname = 'Internet Explorer'; 
//       $ub = "MSIE"; 
//   }
//   elseif(preg_match('/Edge/i',$u_agent)) 
//   { 
//       $bname = 'Microsoft Edge'; 
//       $ub = "Edge"; 
//   } 
//   elseif(preg_match('/Firefox/i',$u_agent)) 
//   { 
//       $bname = 'Mozilla Firefox'; 
//       $ub = "Firefox"; 
//   } 
//   elseif(preg_match('/Chrome/i',$u_agent)) 
//   { 
//       $bname = 'Google Chrome'; 
//       $ub = "Chrome"; 
//   } 
//   elseif(preg_match('/Safari/i',$u_agent)) 
//   { 
//       $bname = 'Apple Safari'; 
//       $ub = "Safari"; 
//   } 
//   elseif(preg_match('/Opera/i',$u_agent)) 
//   { 
//       $bname = 'Opera'; 
//       $ub = "Opera"; 
//   } 
//   elseif(preg_match('/Netscape/i',$u_agent)) 
//   { 
//       $bname = 'Netscape'; 
//       $ub = "Netscape"; 
//   }
//   // finally get the correct version number
//   $known = array('Version', $ub, 'other');
//   $pattern = '#(?<browser>' . join('|', $known) .
//   ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
//   if (!preg_match_all($pattern, $u_agent, $matches)) {
//       // we have no matching number just continue
//   }
  
//   // see how many we have
//   $i = count($matches['browser']);
//   if ($i != 1) {
//       //we will have two since we are not using 'other' argument yet
//       //see if version is before or after the name
//       if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
//           $version= $matches['version'][0];
//       }
//       else {
//           $version= $matches['version'][1];
//       }
//   }
//   else {
//       $version= $matches['version'][0];
//   }
  
//   // check if we have a number
//   if ($version==null || $version=="") {$version="?";}
  
//   return array(
//       'userAgent' => $u_agent,
//       'name'      => $bname,
//       'version'   => $version,
//       'platform'  => $platform,
//       'pattern'    => $pattern,
//   'bit'    => $bit
//   );
// }
// // now try it
// $ua=getBrowser();
// $yourbrowser= $ua['name'];
// $version= $ua['version'];
// $platform= $ua['platform'];
// $dataHora = date("d/m/Y H:i:s");
// if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true): 
//   // Se este dispositivo for portátil, faça/escreva o seguinte
//   $texto = $dataHora." | Cliente | Celular | $cliente_nome | $yourbrowser | $version | $platform\n\n";
//   $fp = fopen('/home/epapodetarotcom/public_html/area_cliente/logs.txt', "a"); 
//   $escreve = fwrite($fp, $texto);
//   fclose($fp);
// else : 
//   // Caso contrário, faça/escreva o seguinte
//   $texto = $dataHora." | Cliente | COMPUTADOR | $cliente_nome | $yourbrowser | $version | $platform\n\n";
//   $fp = fopen('/home/epapodetarotcom/public_html/area_cliente/logs.txt', "a"); 
//   $escreve = fwrite($fp, $texto);
//   fclose($fp);
// endif;
// ########################## DETECTA BROWSER, SEO, VERSION, PLATAFORM 

include 'verifica_ult_consulta.php';

// Excluir chamadas
$pdo->query("DELETE FROM chamada_consulta WHERE id_cliente='$usuario_id'");
  
//Verifica se cliente tem crédito
$sql_credito = $pdo->query("SELECT SUM(minutos_dispo) as soma FROM controle WHERE id_nome_cliente='$usuario_id' AND status='PAGO' "); 
$cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
$valor = $cont["soma"];
if ($valor=="") {
  $valor = "0";
}

//Função que mostra os erros da validação
$erros = null;
function ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <h4>Erro</h4>
          <p><?php echo $nomev; ?></p>
          <p><?php echo $emailv; ?></p>
          <p><?php echo $emailv2; ?></p>
          <p><?php echo $usuariov; ?></p>
          <p><?php echo $emailv3; ?></p>
          <p><?php echo $usuariov2; ?></p>
    </div> 
<?php  }
?>
<?php // SALVA ALTERAÇÃO
if ( isset($_POST["salva"]) ) {

  $id                 = $_POST['id'];
  $nome               = trim(addslashes($_POST['nome']));
  $email              = trim(addslashes($_POST['email']));
  $usuario            = trim(addslashes($_POST['usuario']));
  $senha_post         = md5(trim($_POST['senha']));
  $telefone           = trim(addslashes($_POST['telefone']));
  @$data_nascimento   = $_POST['data_nascimento'];
  @$data_nascimento   = date("Y-m-d", strtotime("$data_nascimento"));
  $endereco       = trim(addslashes($_POST['endereco']));
  $cidade         = trim(addslashes($_POST['cidade']));
  $estado         = trim(addslashes($_POST['estado']));
  $como_nos_conheceu = trim(addslashes($_POST['como_nos_conheceu']));
  $numero = trim(addslashes($_POST['numero']));
  $cep = trim(addslashes($_POST['cep']));
  $complemento = trim(addslashes($_POST['complemento']));
  $bairro = trim(addslashes($_POST['bairro']));
  $cpf = trim(addslashes($_POST['cpf']));

  // Verifica se e-mail ja existe no sistema
  if (!empty($_POST['email']) ) { // se o campo e-mail estiver vazio não faz verificação
      $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email ='$email' && id != '$id' ");
      if ($sqlmail->rowCount() >= 1){
          $erros++;
          $emailv3="E-mail <b>$email</b> ja existe no sistema!";
      } else { $emailv3 = null; }
  } else { $emailv3 = null; }

  // Verifica se usuario ja existe no sistema
  if (!empty($_POST['usuario']) ) { 
      $sqlusuario = $pdo->query("SELECT * FROM clientes WHERE usuario ='$usuario' && id != '$id' ");
      if ($sqlusuario->rowCount() >= 1){
          $erros++;
          $usuariov2="Usuário <b>$usuario</b> ja existe no sistema!";
      } else { $usuariov2 = null; }
  } else { $usuariov2 = null; }

  // validação dos campos vazios 
  if (empty($_POST['nome'])) { 
      $erros++;
      $nomev="Nome vazio, por favor preencha o nome corretamente."; 
  } else { $nomev = null; }

  if (empty($_POST['email'])) { 
      $erros++;
      $emailv="E-mail vazio, por favor preencha o e-mail corretamente."; 
  } else { $emailv = null; }

  if (empty($_POST['usuario'])) { 
      $erros++;
      $usuariov="Usuário vazio, por favor preencha o usuário corretamente."; 
  } else { $usuariov = null; }

  /*verifica email, se digitado incorretamente*/
  $email = str_replace (" ", "", $email);
  $email = str_replace ("/", "", $email);
  $email = str_replace ("@.", "@", $email);
  $email = str_replace (".@", "@", $email);
  $email = str_replace (",", ".", $email);
  $email = str_replace (";", ".", $email);

  if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0) {
    $erros++;
    $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
  } else { $emailv2 = null; }

  // Se tiver mais de um erro mostra a mensagem de erro
  if($erros >= 1) {
    ErrosCadastro($nomev, $emailv, $emailv2, $emailv3, $usuariov, $usuariov2);
  } else {

  $query = $pdo->query( "UPDATE clientes SET 
    nome='$nome',
    email='$email',
    usuario='$usuario',
    telefone='$telefone',
    endereco='$endereco',
    cidade='$cidade',
    estado='$estado',
    como_nos_conheceu='$como_nos_conheceu',
    data_nascimento='$data_nascimento',
    numero='$numero',
    cep='$cep',
    complemento='$complemento',
    bairro='$bairro',
    cpf='$cpf'
  WHERE id='$id'");

  if ( !empty($_POST['senha']) ) {
      
    $query = $pdo->query( "UPDATE clientes SET 
      senha='$senha_post'
    WHERE id='$id'");
  }
      
  $msgs = "Dados Atualizados com sucesso";
  echo "<script>document.location.href='minha-conta/?pg=area_cliente/resumo.php&msgs=$msgs'</script>";
  exit();
  }
}

// Forçando cliente a atualizar seus dados de cadastro
if ($endereco == "") {
  ?>
  <style>#blocoum {display: none;}</style>
  <div class="alert alert-danger" role="alert">
    <h3><i class="fas fa-exclamation-triangle"></i> Atualize seus dados de cadastro antes de continuar, abaixo:</h3>
  </div>

  <div class="card card-body">
    <form name="clientes" method="post" action="" enctype="multipart/form-data" style="color:#505254;" class="form-inline">

      <input type="hidden" name="id" value="<?php echo $usuario_id; ?>"/>

      <div style="margin:10px; display:inline-block;">
          Seu Nome Completo:&nbsp;&nbsp;
          <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Seu Melhor Email:&nbsp;&nbsp;
          <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" required/>
      </div>

      <div style="margin:10px; display:inline-block;">
          Sua Data de Nascimento:&nbsp;&nbsp;
          <input type="text" name="data_nascimento" class="form-control" data-mask="00-00-0000" placeholder="00-00-0000" value="<?php echo $data_nascimento; ?>" required autocomplete="off" />
      </div>

      <div style="margin:10px; display:inline-block;">
        CPF:&nbsp;&nbsp;
        <input type="text" class="form-control cpf"  name="cpf" value="<?php echo $cpf; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Telefone com DDD:&nbsp;&nbsp;
          <input type="text" name="telefone" class="form-control cel_with_ddd" value="<?php echo $telefone; ?>" required/>
      </div>

      <div style="margin:10px; display:inline-block;">
        CEP:&nbsp;&nbsp;
        <input type="text" class="form-control cep" name="cep" id="cep" value="<?php echo $cep; ?>" required  />
      </div>

      <div style="margin:10px; display:inline-block;">
          Endereço:&nbsp;&nbsp;
          <input type="text" class="form-control"  name="endereco" value="<?php echo $endereco; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Número:&nbsp;&nbsp;
          <input type="text" class="form-control"  name="numero" value="<?php echo $numero; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Complemento:&nbsp;&nbsp;
          <input type="text" class="form-control"  name="complemento" value="<?php echo $complemento; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Bairro:&nbsp;&nbsp;
          <input type="text" class="form-control"  name="bairro" value="<?php echo $bairro; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Cidade:&nbsp;&nbsp;
          <input type="text" class="form-control"  name="cidade" value="<?php echo $cidade; ?>" required />
      </div>

      <div style="margin:10px; display:inline-block;">
          Estado:&nbsp;&nbsp;
          <select name="estado" class="form-control"> <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
              <option value="AC">Acre</option> 
              <option value="AL">Alagoas</option> 
              <option value="AM">Amazonas</option> 
              <option value="AP">Amapá</option> 
              <option value="BA">Bahia</option> 
              <option value="CE">Ceará</option> 
              <option value="DF">Distrito Federal</option> 
              <option value="ES">Espírito Santo</option> 
              <option value="GO">Goiás</option> 
              <option value="MA">Maranhão</option> 
              <option value="MT">Mato Grosso</option> 
              <option value="MS">Mato Grosso do Sul</option> 
              <option value="MG">Minas Gerais</option> 
              <option value="PA">Pará</option> 
              <option value="PB">Paraíba</option> 
              <option value="PR">Paraná</option> 
              <option value="PE">Pernambuco</option> 
              <option value="PI">Piauí</option> 
              <option value="RJ">Rio de Janeiro</option> 
              <option value="RN">Rio Grande do Norte</option> 
              <option value="RO">Rondônia</option> 
              <option value="RS">Rio Grande do Sul</option> 
              <option value="RR">Roraima</option> 
              <option value="SC">Santa Catarina</option> 
              <option value="SE">Sergipe</option> 
              <option value="SP">São Paulo</option> 
              <option value="TO">Tocantins</option>
          </select>
      </div>

      <div style="margin:10px; display:inline-block;">
          Como nos conheceu?&nbsp;&nbsp;
          <select name="como_nos_conheceu" class="form-control" required> <option value="<?php echo @$como_nos_conheceu; ?>"><?php echo @$como_nos_conheceu; ?></option>
              <option value="Anúncios Google">Anúncios Google</option>
              <option value="Anúncios Facebook">Anúncios Facebook</option>
              <option value="Instagram">Instagram</option>
              <option value="Google">Google</option>
              <option value="Youtube">Youtube</option>
              <option value="E-mail">E-mail</option>
              <option value="Indicação">Indicação</option>
              <option value="Outro">Outro</option>
          </select>
      </div>

      <div style="clear:both;"></div>

      <div class="panel panel-default">
        <div class="panel-body">
          <p>Dados de Login do usuário:</p>
          <div style="float:left; margin-right:10px;">
              *Usuário:&nbsp;&nbsp;
              <input type="text" name="usuario" value="<?php echo $cliente_user; ?>" class="form-control"/>&nbsp;&nbsp;
          </div>

          <div style="float:left; margin-right:10px;">
              *Senha:&nbsp;&nbsp;
              <input type="password" name="senha" value="" class="form-control"/>&nbsp;&nbsp;
          </div>
       </div>
      </div>

      <div class="row col-md-12 mt-3">
          <input class="btn btn-success" type="submit" name="salva" value="Atualizar" />
      </div>
    </form>
  </div>

  <?php
}
?>

<div id="blocoum">
  <h3 class="text-success">Você esta Online! - Minha Conta</h3>
  <div class="row">
    <div class="col-md-6">
      <div class="card card-body mb-3" style="background:#fff; color:#383C3F;">
          <p style="margin-bottom:0px;"><strong><?php echo '#'.$usuario_id.' '.$cliente_nome; ?></strong></br>
          Usuário: <strong><?php echo $cliente_user; ?></strong></br>
          E-mail: <strong><?php echo $cliente_email; ?></strong></br>
          Minutos Disponíveis: <strong><?php echo $valor; ?></strong></p>
      </div>
    </div>
  </div>

  <h5 style="color:#0873bb;">Últimas Compras</h5>
  
  <div class="row">
    <?php
      $ano = date('Y');
      $sql = $pdo->query("SELECT * FROM controle WHERE id_nome_cliente ='$usuario_id' ORDER BY id DESC LIMIT 2");
      $row = $sql->rowCount();
      if ($row > 0){
    ?>
    <div class="table-responsive">
    <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:13px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th>ID</th>
        <th> Cliente</th>
        <th> Plano</th>
        <th> Valor</th>
        <th> Status</th>
        <!-- <th> M. Dispo.</th> -->
        <th> Cod Pagto.</th>
        <th> Data.</th>
      </tr>
    </thead>
    <tbody>
      <?php  while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
        $id=$mostrar['id'];
        $id_nome_cliente=$mostrar['id_nome_cliente'];
        $ref=$mostrar['ref'];
        $minutos=$mostrar['minutos'];
        $valor=$mostrar['valor'];
        $minutos_dispo=$mostrar['minutos_dispo'];
        $cod_pagamento=$mostrar['cod_pagamento'];
        $status=$mostrar['status'];
        $data=$mostrar['data'];
        $data=MostraDataCorretamenteHora ($data);

        $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
        while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)){
        $nome_cliente_compra=$dados22['nome'];
        }
      ?>
      <tr>
        <form name="check" id="check" action="" method="post">
          <td style="width:7px;"><?php echo $id; ?></td>
          <td><?php echo $nome_cliente_compra; ?></td>
          <td><?php echo $minutos.' Minutos'; ?></td>
          <td><?php echo $valor; ?></td>
          <td>
            <?php 
              if ($status == 'Aguardando') {
                  $estiloStatusPagExtra = 'label label-default';
                } elseif ($status == 'PAGO') {
                  $estiloStatusPagExtra = 'label label-success';
                } else {
                  $estiloStatusPagExtra = 'label label-default';
                }
                echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
             ?>
           </td>
          <!-- <td><?php //echo $minutos_dispo; ?></td> -->
          <td><?php echo $cod_pagamento; ?></td>
          <td><?php echo $data; ?></td>
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
      ?>
    </form>
  </div>

  <h5 style="color:#0873bb;">Últimos Atendimentos</h5>
  
  <div class="row">

    <?php 
      $sql = $pdo->query("SELECT * FROM atendimento WHERE id_cliente='$usuario_id' ORDER BY id DESC LIMIT 2"); 
      $row = $sql->rowCount();
      if ($row > 0){
    ?>
    <div class="table-responsive">
    <table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
        <thead>
          <tr style="background:#265A88; color:#fff;">
            <th>ID</th>
            <th> Cliente</th>
            <th> Tarólogo</th>
            <th> Código Consulta</th>
            <th> Data</th>
            <th> Duração (Minutos)</th>
          </tr>
        </thead>
        <tbody>
        <?php  
            while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
              $id=$mostrar['id'];
              $id_cliente=$mostrar['id_cliente'];
              $id_tarologo=$mostrar['id_tarologo'];
              $cod_consulta=$mostrar['cod_consulta'];
              $data=$mostrar['data'];
              $data=MostraDataCorretamenteHora ($data);
              $duracao=$mostrar['duracao'];

              //Estancia dados do tarólogo
              $dadoss4 ="SELECT * FROM clientes WHERE id='$id_tarologo'"; 
              $executa4=$pdo->query($dadoss4);
              $row = $executa4->rowCount();
              if($row > 0) {
              while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
                $tarologo_id=$dadoss4['id'];
                $tarologo_nome=$dadoss4['nome'];
              }
            }
              
              if ($row == 0) { $tarologo_nome=""; }

              //Estancia dados do cliente
              $dadoss3 ="SELECT * FROM clientes WHERE id='$id_cliente'"; 
              $executa3=$pdo->query($dadoss3);
                while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
                $cliente_id=$dadoss3['id'];
                $cliente_nome=$dadoss3['nome'];
              }
              ?>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $cliente_nome; ?></td>
              <td><?php echo $tarologo_nome; ?></td>
              <td><?php echo $cod_consulta; ?></td>
              <td><?php echo $data; ?></td>
              <td><?php echo $duracao; ?></td>
              </tr>
     <?php } ?>
        </tbody>
      </table>
      </div>     
    <?php
      
    }else{
      $msge="Nenhum resultado encontrado...";
      MsgErro ($msge);
      }
    ?>

  </div>
</div>