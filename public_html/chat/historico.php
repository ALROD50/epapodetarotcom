<?php
//
// HISTÓRICO DA CONSULTA
//
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
// echo 'Pesquisando... '.time();
$cod_sala  = $_POST['cod_sala'];
$id_usuario_logado = $_POST['id_usuario_logado'];

// Verifica mensagens antigas neste chat
$executa = $pdo->query("SELECT * FROM chat WHERE cod_sala='$cod_sala' ORDER BY id ASC ");
$rows = $executa->rowCount();
if ($rows > 0) {
  while ( $mostra = $executa->fetch(PDO::FETCH_ASSOC) ) { 
    $nome=utf8_decode($mostra['nome']);
    $mensagem=utf8_decode($mostra['mensagem']);
    $escreveu=utf8_decode($mostra['escreveu']);
    if ($escreveu=="$id_usuario_logado") {
      $class="me";
    } else {
      $class="other";
    }
    echo "
      <div class='$class'>
        <div class='text'>
          <p>$nome: $mensagem</p>
        </div>
      </div>
    ";
  }
}
?>