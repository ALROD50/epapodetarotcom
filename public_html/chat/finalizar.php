<?php
//
// Finaliza sessão de consulta - versão 2.0
//
session_start();
ini_set('display_errors',0); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',0); // Força o PHP a mostrar os erros.
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
// Recuperando informações da sessão
$data = date('Y-m-d H:i:s');
$id_usuario_logado= $_SESSION["id_usuario_logado"];
$id_tarologo = $_SESSION["id_tarologo"];
$id_cliente = $_SESSION["id_cliente"];
$cod_sala = $_SESSION["cod_sala"];
$nome = $_SESSION["nome"];
$nivel = $_SESSION["user_nivel"];
$credito = $_SESSION["credito"]; //Em segundos
$tempo_gasto = $_GET['tempo'];
// echo "
// data $data <br>
// id_usuario_logado $id_usuario_logado <br>
// id_tarologo $id_tarologo <br>
// id_cliente $id_cliente <br>
// cod_sala $cod_sala <br>
// nome $nome <br>
// nivel $nivel <br>
// credito $credito <br>
// tempo_gasto $tempo_gasto <br>
// ";
// exit();

// Verificando quantas mensagens do cliente existe neste atendimento.
$dadoss1="SELECT COUNT(*) QUANTIDADE FROM chat WHERE cod_sala='$cod_sala' AND escreveu='$id_cliente' ";
$executa1= $pdo->query($dadoss1);
while ( $mostrartempo1 = $executa1->fetch(PDO::FETCH_ASSOC) ) { 
    $quantidade=$mostrartempo1['QUANTIDADE'];
}
// Se a quantidade de mensagens do cliente for menor ou igual a 2, então o tempo gasto será 0
if ($quantidade <= 2) {
   $tempo_gasto = null;
}
// Verificando quantas mensagens do tarólogo existe neste atendimento.
$dadoss2="SELECT COUNT(*) QUANTIDADE FROM chat WHERE cod_sala='$cod_sala' AND escreveu='$id_tarologo' ";
$executa2= $pdo->query($dadoss2);
while ( $mostrartempo2 = $executa2->fetch(PDO::FETCH_ASSOC) ) { 
    $quantidade2=$mostrartempo2['QUANTIDADE'];
}
// Se a quantidade de mensagens do tarólogo for menor ou igual a 2, então o tempo gasto será 0
if ($quantidade2 <= 2) {
   $tempo_gasto = null;
}

//Registrando que o usuário esta online
$datacompleta2 = date("Y-m-d H:i:s");
$query2 = $pdo->query("UPDATE clientes SET 
    online='online',
    time='$datacompleta2'
WHERE id='$id_tarologo'");

$query2x = $pdo->query("UPDATE clientes SET 
    online='online',
    time='$datacompleta2'
WHERE id='$id_cliente'");
//Console
// echo 'Data: '.$data.'<br>';
// echo 'ID Usuário: '.$id_usuario_logado.'<br>';
// echo 'ID Cliente: '.$id_cliente.'<br>';
// echo 'ID Tarólogo: '.$id_tarologo.'<br>';
// echo 'Cod Sala: '.$cod_sala.'<br>';
// echo 'Nome: '.$nome.'<br>';
// echo 'Nível: '.$nivel.'<br>';
// echo 'Crédito em segundos: '.$credito.'<br>';
// echo 'Tempo Gasto: '.$tempo_gasto.'<br>';
// echo 'Quantidade msg cliente: '.$quantidade.'<br>';
// echo 'Quantidade msg tarólogo: '.$quantidade2.'<br>';
// exit();

if (!empty($_SESSION["cod_sala"])){

    // Verificar se o cod_sala da ultima conversa existe na tabela Atendimento.
    $sql23="SELECT * FROM atendimento WHERE cod_consulta='$cod_sala' "; 
    //$executa23=$pdo->query($sql23);
    $executa23= $pdo->query($sql23);
    $row23 = $executa23->rowCount();

    // Registrando o chat em Atendimentos...
    if ($row23 <= 0) {

        // data e hora da última mensagem enviada do atendimento
        $executa = $pdo->query("SELECT * FROM chat WHERE cod_sala='$cod_sala' ORDER BY id DESC LIMIT 1 ");
        while ($mostrar = $executa->fetch(PDO::FETCH_ASSOC)){ 
          $data=$mostrar['datahora'];
        }

        if ($nivel == 'CLIENTE') {

            // Atualizar os minutos disponiveis do cliente
            $query = $pdo->query("UPDATE controle SET 
                minutos_dispo='0'
            WHERE id_nome_cliente='$id_cliente'");

            // Senão existir tempo na URL de finalização, então a consulta durou todo o tempo de credito do cliente, então a duração vai ser igual ao crédito anterior dele.
            if ($tempo_gasto == "total") { 

                $credito_anterior = $credito / 60;
                $duracao = $credito_anterior;
                $tempo_restante = "0";
                $pagina='revisao';
                
            } else {

                // Atualiza o credito menos com o que foi gasto.
                $credito_anterior = $credito / 60;
                $tempo_restante = $credito_anterior - $tempo_gasto;

                $duracao = $tempo_gasto;

                $query = $pdo->query("UPDATE controle SET 
                    minutos_dispo='$tempo_restante'
                WHERE id_nome_cliente='$id_cliente' AND status='PAGO' ORDER BY id DESC LIMIT 1 ");

                $pagina="finalizar.php $tempo_gasto";
            }

            // Registrar Atendimento no banco do cliente.
            $pdo->query("INSERT INTO atendimento (
               id_cliente,
               id_tarologo,
               cod_consulta,
               data,
               duracao,
               cred_inicial,
               cred_final,
               registrou,
               pagina,
               tipo
            ) VALUES (
               '$id_cliente',
               '$id_tarologo',
               '$cod_sala',
               '$data',
               '$duracao',
               '$credito_anterior',
               '$tempo_restante',
               'Cliente',
               '$pagina',
               'Chat'
            )");

            // Deleta a chamada para entrar no chat
            $pdo->query("DELETE FROM chamada_consulta WHERE id_cliente='$id_cliente'");

            // DELETANDO O COOKIE E A SESSION
            if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
            if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
            if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
            if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
            if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
            if(isset($_SESSION['inicia_chat3'])) {  unset($_SESSION['inicia_chat3']); } else { unset($_SESSION['inicia_chat3']); }
            if(isset($_SESSION['tempo_inicial3'])) {  unset($_SESSION['tempo_inicial3']); } else { unset($_SESSION['tempo_inicial3']); }
            // Manda para a página de depoimentos.
            echo "<script>document.location.href='depoimentos.php'</script>";
        
        } elseif ($nivel == 'TAROLOGO') {

            // Atualizar os minutos disponiveis do cliente
            $query = $pdo->query("UPDATE controle SET 
                minutos_dispo='0'
            WHERE id_nome_cliente='$id_cliente'");

            // Senão existir tempo na URL de finalização, então a consulta durou todo o tempo de credito do cliente, então a duração vai ser igual ao crédito anterior dele.
            if ($tempo_gasto == "total") { 

                $credito_anterior = $credito / 60;
                $duracao = $credito_anterior;
                $tempo_restante = "0";
                $pagina='revisao';
                
            } else {

                // Atualiza o credito menos com o que foi gasto.
                $credito_anterior = $credito / 60;
                $tempo_restante = $credito_anterior - $tempo_gasto;

                $duracao = $tempo_gasto;

                $query = $pdo->query("UPDATE controle SET 
                    minutos_dispo='$tempo_restante'
                WHERE id_nome_cliente='$id_cliente' AND status='PAGO' ORDER BY id DESC LIMIT 1 ");

                $pagina="finalizar.php $tempo_gasto";
            }

            // Registrar Atendimento no banco do cliente.
            $pdo->query("INSERT INTO atendimento (
               id_cliente,
               id_tarologo,
               cod_consulta,
               data,
               duracao,
               cred_inicial,
               cred_final,
               registrou,
               pagina,
               tipo
            ) VALUES (
               '$id_cliente',
               '$id_tarologo',
               '$cod_sala',
               '$data',
               '$duracao',
               '$credito_anterior',
               '$tempo_restante',
               'Tarologo',
               '$pagina',
               'Chat'
            )");

            // deleta a chamada e a conversa se não tiver atendimento com cliente no chat.
            if ($id_cliente == "") {
                $pdo->query("DELETE FROM chamada_consulta WHERE id_tarologo='$id_tarologo'");
                $pdo->query("DELETE FROM chat WHERE cod_sala='$cod_sala'");
            }

            // Deleta a chamada para entrar no chat
            $pdo->query("DELETE FROM chamada_consulta WHERE id_tarologo='$id_tarologo'");

            // DELETANDO O COOKIE E A SESSION
            if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
            if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
            if(isset($_SESSION['id_usuario_logado'])) {  unset($_SESSION['id_usuario_logado']); } else { unset($_SESSION['id_usuario_logado']); }
            if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
            if(isset($_SESSION['id_cliente'])) {  unset($_SESSION['id_cliente']); } else { unset($_SESSION['id_cliente']); }
            if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
            if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
            if(isset($_SESSION['inicia_chat3'])) {  unset($_SESSION['inicia_chat3']); } else { unset($_SESSION['inicia_chat3']); }
            if(isset($_SESSION['tempo_inicial3'])) {  unset($_SESSION['tempo_inicial3']); } else { unset($_SESSION['tempo_inicial3']); }
            echo "<script>document.location.href='https://www.tarotdehorus.com.br/minha-conta'</script>";
        }
        
    } else {

        // DELETANDO O COOKIE E A SESSION
        if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
        if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
        if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
        if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
        if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
        if(isset($_SESSION['inicia_chat3'])) {  unset($_SESSION['inicia_chat3']); } else { unset($_SESSION['inicia_chat3']); }
        if(isset($_SESSION['tempo_inicial3'])) {  unset($_SESSION['tempo_inicial3']); } else { unset($_SESSION['tempo_inicial3']); }

        if ($nivel == 'CLIENTE') {
            echo "<script>document.location.href='depoimentos.php'</script>";
        } elseif ($nivel == 'TAROLOGO') {
            echo "<script>document.location.href='https://www.tarotdehorus.com.br/minha-conta'</script>";
        }
    }

} else {

  echo "<script>document.location.href='https://www.tarotdehorus.com.br/index.php'</script>";
}