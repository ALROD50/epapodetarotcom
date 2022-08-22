<!-- Correga os modelos de orçamentos dinamicamente -->
<script type="text/javascript">
  function carregaServico() {
    var tipo = document.getElementById('tipo');
    // Testando a variavel tipo_servico
    // alert(servico.value);
    $.post('https://www.tarotdehorus.com.br/mail/padrao_carrega_modelo.php', {
      cod : tipo.value
    }, function(retorno) {
      $("#servicodois").html(retorno);
    });
  }
</script>
<?php 
$TinyMce="SIM";
$habilitareditor = 'completo';
?>
<h3 class="text-success"><i class="fas fa-envelope"></i> Autoresponder - Enviar Nova Mensagem Padrão</h3>
<hr>
<a class="btn btn-light" href="minha-conta/?pg=mail/autoresponder.php"><i class="fas fa-home"></i> Voltar as Campanhas</a>
<a class="btn btn-light" href="minha-conta/?pg=mail/padrao_listar.php"><i class="fas fa-arrow-circle-left"></i> Voltar</a>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-2"></div>
        <div id="meio">

          <form name="CriarMensagem" method="post" action="" style="font-size:16px;">

            <div class="form-group">
              <label for="">Tipo da Mensagem</label>
              <select name="tipo" id="tipo" class="input-mini form-control" onchange="carregaServico()">
                <option value="" selected="selected" required> - Selecione um Modelo - </option>
                <?php 
                $sql = $pdo->query("SELECT * FROM mail_padrao_modelos");
                $row = $sql->rowCount();
                if ($row == 0) {
                  echo '<option value="">Nenhum dado encontrado...</option>';
                } else { 
                  while ($id_camp = $sql->fetch(PDO::FETCH_ASSOC)){
                    echo '<option value="'.$id_camp['tipo'].'">'.$id_camp['tipo'].'</option>';
                  } 
                }
                ?>
              </select>
            </div>

      			<div class="row">
      				<div class="col-md-12">
    				    <div class="form-group">
    						<label for="">Clientes </label>
    						<select multiple name="destinatario[]" id="destinatario" class="input-mini form-control" style="height: 200px;">
    							<option value="" required> - Selecione os Destinatários - </option>
    							<?php 
    							$sql = $pdo->query("SELECT * FROM clientes where nivel='CLIENTE' AND status!='CANCELADO' ORDER by nome ASC ");
                  $row = $sql->rowCount();
    							if ($row == 0) {
    								echo '<option value="">Nenhum dado encontrado...</option>';
    							} else { 
    								while ($id_camp = $sql->fetch(PDO::FETCH_ASSOC)) {
    									echo '<option value="'.$id_camp['email'].'">'.$id_camp['nome'].' - '.$id_camp['empresa'].'</option>';
    								}
    							}
    							?>
    						</select>
    				    </div>
      				</div>  
      			</div>

      			<div class="form-group">
              <label for="">Mensagem</label>
      				<div id="servicodois"></div>
      				<br>
            </div>

            <div class="form-group">
              <label for=""></label>
              <input class="btn btn-success" type="submit" name="CriarMensagem" value="Enviar Mensagem" />
            </div>

          </form>

          <?php
          if (isset($_POST["CriarMensagem"])) {

            $assunto      = $_POST['tipo'];
            $mensagem     = $_POST['modelo'];
            $destinatario = $_POST['destinatario'];
            $destinatarios = implode( '; ' , array_filter( $destinatario ) );

            // Contando a quantidade de e-mails selecionados
            for($q_d_s=0;$q_d_s<count($_POST['destinatario']);$q_d_s++) { 
      			}

      			foreach ($_POST['destinatario'] as $email) {

      				//Verifica o nome da ultima mensagem enviada para este e-mail
      				$executa778 = $pdo->query("SELECT * FROM clientes WHERE email='$email'");
      				while ($dados778 = $executa778->fetch(PDO::FETCH_ASSOC)) { 
      					$nome=$dados778['nome'];
      				}

    	        	###################### EMAIL ##############################
  	            $memaildestinatario = $email;
  	            $mnomedestinatario = $nome;
  	            $massunto = $assunto;
  	            $mmensagem = $mensagem;
  	            EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
  	            ###################### EMAIL ##############################
      			}

            $msgs = "E-mail enviado com sucesso para: $destinatarios <br>";
            echo "<script>document.location.href='minha-conta/?pg=mail/padrao_listar.php&msgs=$msgs'</script>";  
          }
          ?>

        </div>
      <div class="col-md-2"></div>
    </div>  
  </div>
</div>