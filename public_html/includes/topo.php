<?php
// verifica carrinho
$sql_produto = $pdo->query("SELECT * FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session' "); 
$rowQuantidade = $sql_produto->rowCount();
?>
<div id="header" class="row">

  <!-- somente pc -->
  <div class="row justify-content-center d-xl-block d-lg-block d-none">
    <div id="logo" class="d-xl-block d-lg-block d-none">
      <a href="https://www.epapodetarot.com.br/home" title="Site É Papo de Tarot" class="p-0 m-0">
        <center><img id="sizelogo" src="images/Logo-Site.fw.png" alt="Site É Papo de Tarot" title="Site É Papo de Tarot"></center>
      </a>
    </div>
  </div>

  <div class="col-md-12 pr-1 pl-1">
    <?php
    if($row_onlinex=="offline" OR $row_onlinex==""){
      //Não esta
      ?>
      <!-- somente pc -->
      <div class="d-xl-block d-lg-block d-none">
        <div id="usuariobox">
          <p><i class="fas fa-user-circle"></i> <a href="registre-se" class="link-padraoum" title="Cadastre-Se">Cadastre-Se</a> <i class="fas fa-sign-in-alt"></i> <a href="fazer-login" class="link-padraoum" title="Entrar/Login">Entrar</a> <i class="fas fa-home"></i> <a href="minha-conta" class="link-padraoum" title="Minha Conta">Minha Conta</a> <i class="fas fa-shopping-cart center"></i> <a href="carrinho-compras" class="link-padraoum" title="Meu Carrinho">Meu Carrinho</a> <span class="badge badge-pill corpadrao1 mt-0"><?php echo $rowQuantidade; ?></span></p>
          <p></p>
        </div>
      </div>
      
      <!-- somente cel -->
      <div class="d-xl-none d-lg-none pt-3 pl-2" style="font-size:17px;">
          <p class="mb-2"><i class="fas fa-home"></i> <a href="fazer-login" class="link-padraoum" title="Minha Conta">Entrar</a> <i class="fas fa-shopping-cart"></i> <a href="carrinho-compras" class="link-padraoum" title="Meu Carrinho">Carrinho</a> <span class="badge badge-pill corpadrao1 mt-0"><?php echo $rowQuantidade; ?></span></p>
      </div>
      <?php
    } else {
      ?>
      <div id="usuarioboxlogado">
        <?php
        // Re-verificação de atendimentos com duração incorreta
        include 'includes/verifica_consulta.php';
        // Verfica se o ultimo Chat esta em andamento ainda ou se realmente acabou.
        $asdsadsa = $pdo->query("SELECT * FROM chamada_consulta WHERE id_tarologo='$usuario_id' AND tarologo_entrou='TAROLOGOENTROU' AND acesso='NEGADO' OR id_cliente='$usuario_id' AND tarologo_entrou='TAROLOGOENTROU' AND acesso='NEGADO'");
        $nLinhas = $asdsadsa->rowCount();
        if ($nLinhas > 0) {
          // Pega o código dessa sala
          while ($dados=$asdsadsa->fetch(PDO::FETCH_ASSOC)) { 
            $cod_sala=$dados['id'];
            $n_verificacoes=$dados['n_verificacoes'];
            $videochat=$dados['videochat'];
          }
          // Verifica se esse atendimento ja foi registrado em atendimentos, se sim então apaga essa chamada_consulta, se não então manda de volta pro chat. 
          $assx = $pdo->query("SELECT * FROM atendimento WHERE cod_consulta='$cod_sala'");
          $nLinhasX = $assx->rowCount();
          if ($nLinhasX > 0) {
            $Delete=$pdo->prepare("DELETE FROM chamada_consulta WHERE id=:id")->execute(array(':id' => $cod_sala));
          } else {
            // atualiza o numero de verificações deste método
            $n_verificacoes ++;
            $query = $pdo->query("UPDATE chamada_consulta SET n_verificacoes='$n_verificacoes' WHERE id='$cod_sala'");
            if ($n_verificacoes > 10) {
              $Delete=$pdo->prepare("DELETE FROM chamada_consulta WHERE id=:id")->execute(array(':id' => $cod_sala));
            }
            // Este atendimento ainda não foi fechado... levando cliente de volta a sala
            if ($videochat=="SIM") {
              // Enviar para a videochamada
              echo "<script>document.location.href='https://www.epapodetarot.com.br/chat/chatvideo-index.php?room=$cod_sala'</script>";
              exit();

            } else {
              // Enviar para o chat
              echo "<script>document.location.href='https://www.epapodetarot.com.br/chat/chat-index.php?room=$cod_sala'</script>";
              exit();
            }
          }
        }
        // Esta logado.
        if ($usuario_nivel == 'CLIENTE') {
          // Atualiza status de compra em análise no pagseguro
          $executax = $pdo->query("SELECT * FROM controle WHERE status='Em Análise' AND metodo='PagSeguro' ");
          while ($dadossx= $executax->fetch(PDO::FETCH_ASSOC)) { 
            $reference=$dadossx['cod_pagamento'];
            $email = 'epapodetarot@gmail.com';
            $token = 'a6cd16a0-d451-41e7-8833-135eba83283393f726d44f12bb84fa9d253499f058b8d9a1-8336-4660-afe4-3b8faa3c4f44';
            $curl = 'https://ws.pagseguro.uol.com.br/v2/transactions?email='.$email.'&token='.$token.'&reference='.$reference;
            // load as string
            $xmlstr = file_get_contents($curl);
            $xmlcont = json_decode(json_encode(simplexml_load_string($xmlstr)));
            // print_r($xmlcont);
            //Retorno
            @$status = $xmlcont->transactions->transaction->status;
            if ($status == "") {
              @$status = $xmlcont->transactions->transaction[0]->status;
            }
            if ($status == 1) {
                $status = 'Em análise';
            } elseif ($status == 2) {
                $status = 'Em análise';
            } elseif ($status == 3) {
                $status = 'PAGO';
            } elseif ($status == 4) {
                $status = 'PAGO';
            } elseif ($status == 5) {
                $status = 'Em disputa';
            } elseif ($status == 6) {
                $status = 'Devolvida';
            } elseif ($status == 7) {
                $status = 'Cancelada';
            } elseif ($status == 8) {
                $status = 'Chargeback debitado';
            } elseif ($status == 9) {
                $status = 'Em contestação';
            } else {
                $status = 'Cancelada';
            }
            $executa = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' ");
            while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 
              $statusAtual=$dadoss['status'];
            }
            if ($statusAtual!='PAGO') {
              //Atualiza no banco o status do retorno
              $query = $pdo->query("UPDATE controle SET 
                status='$status',
                metodo='PagSeguro'
              WHERE cod_pagamento='$reference'");
              //Se o status da compra for PAGA, então atualiza na tela os créditos como disponíveis.
              if ($status == 'PAGO') {
                //Verifica quantos minutos o cliente comprou
                $executa = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$reference' ");
                while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)){ 
                  $minutos=$dadoss['minutos'];
                  $tipo=$dadoss['tipo'];
                }
                if ($tipo=="padrao") {
                  //Atualiza no banco os dados retornados.
                  $query = $pdo->query("UPDATE controle SET 
                    minutos_dispo='$minutos',
                    status='PAGO',
                    metodo='PagSeguro'
                  WHERE cod_pagamento='$reference'");
                  echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msgs=Parabéns, seu pagamento foi aprovado<br>Escolha o seu tarólogo abaixo:'</script>";
                }
              }
            }
          }
          // Verificando Pagamento PIX
          $executapix = $pdo->query("SELECT * FROM controle WHERE metodo='Pix' AND status!='PAGO'");
          $nLinhasPix = $executapix->rowCount();
          if ($nLinhasPix > 0) {
            // pega data da criação do pix e o id
            while ($dadosspix= $executapix->fetch(PDO::FETCH_ASSOC)) { 
              $refPixx=$dadosspix['refPix'];
              $dataCriado=$dadosspix['data'];
              $reference=$dadosspix['cod_pagamento'];
              $minutos=$dadosspix['minutos_dispo'];
              $tipo=$dadosspix['tipo'];
              // Verifica quando o pix foi gerado
              $resultadoHoraPix = datediff('h', $dataCriado, $data_hoje, false);
              // Verifica Status
              include __DIR__.'/../scripts/gerencianet_pix/consultar-qrcode-dinamico.php';
              $status_compra = $responsex["status"];
              // Atualiza
              if ($resultadoHoraPix == 0) {
                if ($status_compra == 'ATIVA') {
                // Ainda não foi paga não faz nada.
                } elseif ($status_compra == 'CONCLUIDA') {
                  // Atualiza a fatura para pago.
                  if ($tipo=="padrao") {
                      // consulta via chat
                      $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
                  } elseif ($tipo=="email") {
                      // consulta via e-mail
                      $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                  } elseif ($tipo=="loja") {
                      # produto da loja
                      $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                  }
                }
              }
              // Atualiza
              if ($resultadoHoraPix <= 1) {
                if ($status_compra == 'ATIVA') {
                // Ainda não foi paga não faz nada.
                } elseif ($status_compra == 'CONCLUIDA') {
                  // Atualiza a fatura para pago.
                  if ($tipo=="padrao") {
                      // consulta via chat
                      $query = $pdo->query("UPDATE controle SET data='$data_hoje', minutos_dispo='$minutos', status='PAGO' WHERE cod_pagamento='$reference'");
                  } elseif ($tipo=="email") {
                      // consulta via e-mail
                      $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                  } elseif ($tipo=="loja") {
                      # produto da loja
                      $query = $pdo->query("UPDATE controle SET data='$data_hoje', status='PAGO' WHERE cod_pagamento='$reference'");
                  }
                }
              }
              // Pix expirado
              if ($resultadoHoraPix > 1) {
                $query = $pdo->query("UPDATE controle SET status='Aguardando', metodo='' WHERE cod_pagamento='$reference'");
              }
  
            }
          }
          // Verifica se cliente tem crédito
          $sql_credito = $pdo->query("SELECT COALESCE(SUM(minutos_dispo), 0) as soma FROM controle WHERE id_nome_cliente='$usuario_id' AND status='PAGO' ");
          $cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
          $valor = $cont["soma"];
          if ($valor == 0) {
            $valor = 0;
          }
          ?>
          <!-- somente pc -->
          <div class="d-xl-block d-lg-block d-none pl-2">
            <?php 
            echo '<p style="margin-top: 11px;margin-bottom:0rem;}">Olá '.$usuario_nome.'</br>';
            echo 'Saldo: <span><i class="fas fa-dollar-sign"></i> '.$valor.' Minutos</span> | <i class="fas fa-home"></i> <a href="/minha-conta">MINHA CONTA</a></br>';
            echo '<i class="fas fa-shopping-cart"></i> <a href="/carrinho-compras"> <span class="badge badge-pill  corpadrao1">'.$rowQuantidade.'</span> CARRINHO</a></p>';
            ?>
          </div>
          
          <!-- somente cel -->
          <div class="d-xl-none d-lg-none pt-3 pr-2">
            <?php
            $usuario_nome=limita_caracteres($usuario_nome, '10', $quebra = true);
            echo '<p class="mb-2">Saldo: <span><i class="fas fa-dollar-sign"></i> '.$valor.' Minutos</span> <a href="/minha-conta"><i class="fas fa-user-circle"></i> Olá '.$usuario_nome.'</a>  <a href="/carrinho-compras"><i class="fas fa-shopping-cart ml-1"></i> <span class="badge badge-pill  corpadrao1">'.$rowQuantidade.'</span> </a></p>';
            ?>
          </div>
          <?php
          
          //Registrando que o cliente esta online
          $datacompleta2 = date("Y-m-d H:i:s");
          $query = $pdo->query("UPDATE clientes SET 
          online='online',
            time='$datacompleta2'
          WHERE id='$usuario_id'");
        } elseif ($usuario_nivel == 'TAROLOGO') {

          ?>
          <div class="pt-2" style="font-size:16px;">
            <?php 
            echo '<p class="mb-2"><div id="onlineVerificaion" class="" style="display: contents;"><i class="fas fa-plug"></i></div> Olá '.$usuario_nome.', <a href="login/logout.php">Sair</a> | <i class="fas fa-cogs"></i> <a href="/minha-conta">MINHA CONTA</a>';
            ?>
          </div>
          <?php

          // Mantendo Navegador do Tarólogo Ativo ---------------------------------------
          ?>
          <script type="text/javascript">
            // A cada 1h execulta a notificações
            setTimeout(function() {
              // Pergunta se o tarólogo ainda esta online
              var notification = new Notification('Você esta Online?', {
                icon: 'https://www.epapodetarot.com.br/images/Logo-SiteP.png',
                body: "Sim, estou online - Clique aqui!",
                // Se clicar em SIM, envia para página de atualização de status, dia e hora do online.
              });
              notification.onclick = function () {
                window.focus();
                document.location.href='https://www.epapodetarot.com.br/minha-conta/?tarologo_online=on';
              };
            }, 3500000);
          </script>
          <?php
          // Mantendo Navegador do Tarólogo Ativo ---------------------------------------
        } elseif ($usuario_nivel == 'ADMIN') {
          
          //Registrando que o admin esta online
          $datacompleta2 = date("Y-m-d H:i:s");
          $query = $pdo->query("UPDATE clientes SET 
            online='online',
            time='$datacompleta2'
          WHERE id='$usuario_id'");

          ?>
          <div class="pt-2" style="font-size:17px;">
            <?php 
            echo '<p class="mb-2"><div id="onlineVerificaion" class="" style="display: contents;"><i class="fas fa-plug"></i></div> Olá, <a href="login/logout.php">Sair</a> | <i class="fas fa-cogs"></i> <a href="/minha-conta">ADMINISTRAÇÃO</a>';
            ?>
          </div>
          <?php
        }
        ?>
      </div>
      <?php
    }
    ?>
  </div>
</div>
<?php 
// Quando o tarólogo clica em iniciar atendimento da chamada, cai aqui e pega os dados na URL e manda pra sala.
if($row_onlinex!="offline" OR $row_onlinex!="") {
  if ($usuario_nivel == 'TAROLOGO') {
    ?><script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script><?php
      // Verifica Chat ###########################################
      $cod_sala    = @$_GET['cod_sala'];
      $inicia_chat = @$_GET['inicia_chat'];
      // Verifica se o pedido do chat foi aceito
      if ($cod_sala != "" AND $inicia_chat == "true") {
        //Grava no banco que o tarólogo entrou.
        $query = $pdo->query("UPDATE chamada_consulta SET 
          tarologo_entrou='TAROLOGOENTROU'
        WHERE id='$cod_sala'");
        //Registrando que o tarologo esta ocupado
        $datacompleta2 = date("Y-m-d H:i:s");
        $sql_queryx = $pdo->query("UPDATE clientes SET 
          online='ocupado',
          time='$datacompleta2'
        WHERE id='$usuario_id'");
        //Abre o Chat
        echo "<script>document.location.href='https://www.epapodetarot.com.br/chat/index.php?cod_sala=".$cod_sala."&id_usuario=".$usuario_id."'</script>";
        exit();
      }
      // Verifica Chat ###########################################
      ?>
      <div id="verifica_chamada_cliente_tarologo"></div>
      <?php
      // Sim - Estou Online! ---------------------------------------------------------
      if(isset($_GET['tarologo_online'])) {
        //Registrando que o tarologo esta online
        $datacompleta2 = date("Y-m-d H:i:s");
        $query = $pdo->query("UPDATE clientes SET 
          online='online',
          time='$datacompleta2'
        WHERE id='$usuario_id'");
        ?>
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <h2>Eu Estou Online Agora :)</h2>
          <p>Bom trabalho! Este procedimento ajuda a fazer com que o navegador não deixe o seu login inativo, uma das causas do não recebimento de chamados para atendimento.</p>
          <p>Se você não receber a notificação do windows (Você esta Online?) basta clicar em Minha Conta no site, 1 vez pelo menos a cada hora.</p>
          <p>Continue atualizando seu estatus a cada hora!</p>
          <p>Última atualização em <b><?php echo $datacompleta2; ?></b></p>
        </div>
        <?php
      }
      // Sim - Estou Online! ---------------------------------------------------------
      // Volta o tarólogo automáticamente para a página de aguardando chamadas
      // Recarrega a página quando o tarólgo estiver fora da página minha-conta
      if ($URLSESSAO!='minha-conta') {
        ?>
        <script>
          setTimeout(function(){
            document.location.href="https://www.epapodetarot.com.br/minha-conta/?msgi=Você foi redirecionado automáticamente para a página principal onde deve aguardar os atendimentos.";
          }, 10000); // Executa depois 10 segundos
        </script>
        <?php
      }
      if ($URLSUBCATEGORIA!='resumo.php') {
        ?>
        <!-- <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <h2>Informação!</h2>
          <p>Não esqueça de voltar para a página <a href="minha-conta/?pg=area_tarologos/resumo.php"><b>Resumo</b></a> para aguardar atendimentos... Lá é o local correto para aguardar chamadas.</p>
        </div> -->
        <?php
      }
  }
}
?>