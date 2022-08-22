<?php
// Selecionando a última conversa do cliente.
$executa=$pdo->query("SELECT * FROM chat WHERE id_cliente='$usuario_id' ORDER BY id DESC LIMIT 1 ");
$row = $executa->rowCount();
while ($mostrar = $executa->fetch(PDO::FETCH_ASSOC)){ 
  $cod_sala=$mostrar['cod_sala'];
  $id_tarologo=$mostrar['id_tarologo'];
  $id_cliente=$mostrar['id_cliente'];
  $datahora=$mostrar['datahora'];
}

// Se existir conversa no chat, passa para a próxima etapa
if ($row > 0){

  // Verificar se o cod_sala da ultima conversa existe na tabela Atendimento.
  $executa23=$pdo->query("SELECT * FROM atendimento WHERE cod_consulta='$cod_sala' ");
  $row23 = $executa23->rowCount();

  // Se não existe este chat no atendimento, e o cliente estiver presente no chat, então fecha o atendimento.
  if ($row23 == 0 AND $id_cliente != ""){

    //Fechando consulta
    //Pega a o primeiro registro
    $dadoss ="SELECT * FROM chat WHERE cod_sala='$cod_sala' ORDER BY id DESC "; //acessa todos os dados do usuário $NOME da url
    $executa=$pdo->query( $dadoss); //se conecta no banco e concatena os dados
    while ( $mostrartempo = $executa->fetch(PDO::FETCH_ASSOC) ) { 
      $horaInicio=$mostrartempo['datahora'];
    }

    // Pega o último registro.
    $dadoss1 ="SELECT * FROM chat WHERE cod_sala='$cod_sala' ORDER BY id ASC "; //acessa todos os dados do usuário $NOME da url
    $executa1=$pdo->query( $dadoss1); //se conecta no banco e concatena os dados
    while ( $mostrartempo1 = $executa1->fetch(PDO::FETCH_ASSOC) ) { 
      $horaFim=$mostrartempo1['datahora'];
    }

    $resultado = datediff('n', $horaInicio, $horaFim, false);

    // Descobrir o ultimo id de controle dele.ORDER BY id ASC
    $sql_credito = $pdo->query("SELECT COALESCE(SUM(minutos_dispo), 0) as soma FROM controle WHERE id_nome_cliente='$id_cliente' AND status='PAGO' ");
    $cont = $sql_credito->fetch(PDO::FETCH_ASSOC);
    $minutos = $cont["soma"];
    $executa1=$pdo->query("SELECT * FROM controle WHERE id_nome_cliente='$id_cliente' ORDER BY id ASC ");
    while ( $mostrartempo1 = $executa1->fetch(PDO::FETCH_ASSOC) ) { 
      $id=$mostrartempo1['id'];
    }

    // Crédito / Tempo Restante do Cliente Atualizado Após Atendimento
    $tempo_restante = $minutos - $resultado;

    // Atualizar os minutos disponiveis do cliente
    $query = $pdo->query("UPDATE controle SET 
      minutos_dispo='0'
    WHERE id_nome_cliente='$id_cliente'");

    $query = $pdo->query("UPDATE controle SET 
      minutos_dispo='$tempo_restante'
    WHERE id_nome_cliente='$id_cliente' AND status='PAGO' ORDER BY id DESC LIMIT 1 "); 

    // Registrar Atendimento no banco do cliente.
    $pdo->query( "INSERT INTO atendimento (
       id_cliente,
       id_tarologo,
       cod_consulta,
       data,
       duracao,
       cred_inicial,
       cred_final,
       registrou,
       pagina
    ) VALUES (
       '$id_cliente',
       '$id_tarologo',
       '$cod_sala',
       '$datahora',
       '$resultado',
       '$minutos',
       '$tempo_restante',
       'Cliente',
       'verifica_ult_consulta cliente.php'
    )");
    
  } elseif ($row23 <= 0 AND $id_cliente == "") {
    // Se não existir o chat no atendimento, e o cliente no chat estiver vazio, então apaga no chat e no chama consulta.
    $pdo->query("DELETE FROM chat WHERE cod_sala='$cod_sala'");
    $pdo->query("DELETE FROM chamada_consulta WHERE id='$cod_sala'");
  }
}
?>