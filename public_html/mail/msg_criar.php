<?php 
$DataPicker ="SIM";
$TinyMce    ="SIM";
$Mask       ="SIM";
?>
<!-- Correga os modelos de orçamentos dinamicamente -->
<script type="text/javascript">
  function carregaCampanha() {
    var tipo = document.getElementById('id_camp');
    // Testando a variavel tipo_servico
    //alert(tipo.value);
    $.post('https://www.epapodetarot.com.br/mail/msg_carrega_agendadas.php', {
      cod : tipo.value
    }, function(retorno) {
      $("#opcoes").html(retorno);
    });
  }
</script>

<script type="text/javascript">
  var qtdeCampos = 0;
  function addCampos() {
    //Criando o elemento DIV:
    var objPai = document.getElementById("campoPai");
    //Definindo atributos ao objFilho:
    var objFilho = document.createElement("div");
    //Inserindo o elemento no pai:
    objFilho.setAttribute("id","filho"+qtdeCampos);
    //Escrevendo algo no filho recém-criado:
    objPai.appendChild(objFilho);
    document.getElementById("filho"+qtdeCampos).innerHTML = "<input type='text' id='data"+qtdeCampos+"' name='data[]' value='' class='placeholder' style='margin-bottom:9px;'> <input type='button' onclick='removerCampo("+qtdeCampos+")' value='Apagar Data'> <br>";
    qtdeCampos++;
  }
  function removerCampo(id) {
    var objPai = document.getElementById("campoPai");
    var objFilho = document.getElementById("filho"+id);
    //Removendo o DIV com id específico do nó-pai:
    var removido = objPai.removeChild(objFilho);
  }
</script>

<h3 class="text-success">Autoresponder - Nova Mensagem</h3>

<p>Campanha PROGRESSIVA, se baseia na data de cadastro de um e-mail, enviando com base no ciclo da mensagem ser igual ao de cadastro do e-mail.</p>
<p>Campanha FIXA, se baseia na data da ultima mensagem enviada desta campanha, enviando com base no ciclo da mensagem ser igual ao da última mensagem enviada.</p>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-2"></div>
        <div id="meio" class="col-md-8">

          <form name="CriarMensagem" method="post" action="" style="font-size:16px;">

            <div class="form-group">
              <label for="">Campanha</label>
              <select name="id_camp" id="id_camp" class="input-mini form-control" onchange="carregaCampanha()">
                <option value="" selected="selected" required> - Selecione uma Campanha - </option>
                <?php 
                $sql = $pdo->query("SELECT * FROM mail_camp");
                $row = $sql->rowCount();
                if ($row == 0) {
                  echo '<option value="">Nenhum dado encontrado...</option>';
                } else { 
                  while ($id_camp = $sql->fetch(PDO::FETCH_ASSOC)){
                    echo '<option value="'.$id_camp['id'].'">'.$id_camp['nome'].' - '.$id_camp['fixo'].'</option>';
                  } 
                }
                ?>
              </select>
            </div>

    			  <div class="row">
    			    <div class="col-md-12">
    			      
  		          <div class="form-group">
  		            <label for="">Assunto</label>
  		            <input type="text" class="form-control" name="assunto" required value="<?php echo @$assunto; ?>" />
  		          </div>

    			    </div>  
    			  </div>

            <div class="row" id="opcoes"></div>

			      <div class="form-group">
            	<label for="">Mensagem</label>
				      <textarea name="msgmm" style="height:400px;" class="form-control"></textarea><br>
            </div>

            <div class="form-group">
              <label for=""></label>
              <input class="btn btn-success" type="submit" name="CriarMensagem" value="Criar Mensagem" />
            </div>

          </form>

          <?php
          if ( isset($_POST["CriarMensagem"]) ) {

            $id_camp       = $_POST['id_camp'];
            $assunto       = $_POST['assunto'];
            $enviar_dias   = $_POST['enviar_dias'];
            $msgmm         = addslashes($_POST['msgmm']);
            
            if ($_POST['data']) {
              $data          = $_POST['data'];
              $enviar_dias = implode( ';' , array_filter( $data ) );
            }

            $pdo->query("INSERT INTO mail_msg (
                id_camp,
                assunto,
                enviar_dias,
                msg
              ) VALUES (
                '$id_camp',
                '$assunto',
                '$enviar_dias',
                '$msgmm'
            )");

            $msgs = "Mensagem Criada Com Sucesso!<br>";
            echo "<script>document.location.href='minha-conta/?pg=mail/msg_listar.php&msgs=$msgs&id_camp=$id_camp'</script>";  
          }
          ?>

        </div>
      <div class="col-md-2"></div>
    </div>  
  </div>
</div>