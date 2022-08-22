
<?php
// Pega a última consulta
$executa=$pdo->query("SELECT * FROM atendimento WHERE cod_consulta!='0' ORDER BY id DESC LIMIT 1");
// $executa=$pdo->query("SELECT * FROM atendimento WHERE cod_consulta='4638' ORDER BY id DESC LIMIT 1");

// Pega a duração registrada
while ( $mostrar = $executa->fetch(PDO::FETCH_ASSOC) ) { 
  $cod_consulta=$mostrar['cod_consulta'];
  $id_cliente=$mostrar['id_cliente'];
  $duracao=$mostrar['duracao'];
  $cred_inicial=$mostrar['cred_inicial'];
  $cred_final=$mostrar['cred_final'];
  $pagina=$mostrar['pagina'];
  $tipo=$mostrar['tipo'];
}

if ($tipo=='Video') {
  
  // Se a consultar for do tipo video, não faz revisão.

} else {

  if ($pagina!='revisao') {
    // Pega a duração Revisada
    // Pega a o primeiro registro
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
    
    $Duracao_revisada = datediff('n', $horaInicio, $horaFim, false);
    
    // Crédito / Tempo Restante do Cliente Atualizado Após Atendimento
    $cred_final_revisado = $cred_inicial - $Duracao_revisada;
    
    if ($duracao=="") {
        $duracao='vazio';
    }
    
    if ($usuario_id == '1') { 
        // echo "Pré Correção...<br>"; 
    }
    
    // Se tiver diferente, atualiza com a duração revisada
    if ($duracao !== $Duracao_revisada) {
    
      if ($usuario_id == '1') { 
        // echo "Correção iniciada.<br>"; 
      }
    
      if ($Duracao_revisada == "") {
          $Duracao_revisada='0';
      }  
    
      if ($cred_final_revisado < 0) {
          $cred_final_revisado='0';
      }
    
      if ($Duracao_revisada > $cred_inicial) {
          $Duracao_revisada=$cred_inicial;
      }
    
      // Atualizar os minutos disponiveis do cliente
      $query = $pdo->query("UPDATE controle SET 
        minutos_dispo='0'
      WHERE id_nome_cliente='$id_cliente'");
    
      $query = $pdo->query("UPDATE controle SET 
        minutos_dispo='$cred_final_revisado'
      WHERE id_nome_cliente='$id_cliente' AND status='PAGO' ORDER BY id DESC LIMIT 1 ");
    
      $query = $pdo->query("UPDATE atendimento SET 
        duracao='$Duracao_revisada',
        cred_final='$cred_final_revisado', 
        pagina='revisao'
      WHERE cod_consulta='$cod_consulta'");
    
      if ($usuario_id == '1') {
        // echo 'Atualizado em: '.$dataHora."<br>";
      }
    }
  }
}

if ($usuario_id == '1') {
//   echo 'Código Consulta: '.$cod_consulta."<br>";
//   echo 'Crédito: '.$cred_inicial."<br>";
//   echo 'Duração: '.$duracao."<br>";
//   echo 'Crédito Revisado: '.$cred_final_revisado."<br>";
//   echo 'Duração Revisada: '.$Duracao_revisada."<br>";
}