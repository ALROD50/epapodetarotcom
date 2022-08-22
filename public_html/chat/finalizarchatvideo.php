<?php
//
// Finaliza sessão de consulta de videochamada - versão 1.0
//
session_start();
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
include "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
?>
<center>
    <h1>Aguarde um momento...</h1>
</center>
<?php
// Recuperando informações da sessão
$data = date('Y-m-d H:i:s');
// $id_tarologo = $_POST["id_tarologo"];
// $id_cliente = $_SESSION["id_cliente"];
// $cod_sala = $_POST["cod_sala"];
// $nome = $_SESSION["nome"];
// $nivel = $_SESSION["user_nivel"];
// $credito = $_SESSION["credito"];
// $tempo_gasto = $_POST['duracao'];
$id_tarologo = $_POST["id_tarologo"];
$id_cliente = $_POST["id_cliente"];
$cod_sala = $_POST["cod_sala"];
$credito = $_POST["credito"];
$tempo_gasto = $_POST['duracao'];
// echo "
// id_tarologo $id_tarologo <br>
// id_cliente $id_cliente <br>
// cod_sala $cod_sala <br>
// credito $credito <br>
// tempo_gasto $tempo_gasto <br> 
// ";
// exit();

// Registrando que o usuário esta online
$datacompleta2 = date("Y-m-d H:i:s");
$UPDATE_query = $pdo->query("UPDATE clientes SET 
    online='online',
    time='$datacompleta2'
WHERE id='$id_tarologo'");

$UPDATE_query2 = $pdo->query("UPDATE clientes SET 
    online='online',
    time='$datacompleta2'
WHERE id='$id_cliente'");

?>
<!-- Avisa cliente que videochamada acbou para direcionalo aos depoimentos -->
<script type="text/javascript">
    var cod_sala = "<?php echo $cod_sala; ?>";
    function CreateSocketWrapper(){
        var conn = new WebSocket('wss://tarotdehorus.com.br/wss2/wss2/NNN');
        // Abre Conexão
        conn.onopen = function(e) {
            console.log("Connection established!!");
            // Mensagem
            var msg = {
                'tipo': 'finalizavideochat',
                'id_sala': cod_sala
            };
            msg = JSON.stringify(msg);
            // Envia
            conn.send(msg);
            console.log(msg);
        };
        // Fecha Conexão
        conn.onclose = function(e) {
            console.log("Connection close!!");
            setTimeout(function(){CreateSocketWrapper()}, 1000); // 1 segundos
        };
    }
    var socket = CreateSocketWrapper();
</script>
<?php

// Aguarda o envio da mensagem do websocket antes de continuar
sleep(1);

// Verificar se o cod_sala da ultima conversa existe na tabela Atendimento.
$executa23 = $pdo->query("SELECT * FROM chamada_consulta WHERE id='$cod_sala' ");
$row23 = $executa23->rowCount();

// Registrando o atendimento
if ($row23 > 0) {

    // Atualizar os minutos disponiveis do cliente
    $query = $pdo->query("UPDATE controle SET 
        minutos_dispo='0'
    WHERE id_nome_cliente='$id_cliente'");

    // Atualiza o credito menos com o que foi gasto.
    $credito_anterior = $credito;
    $tempo_restante = $credito_anterior - $tempo_gasto;
    $duracao = $tempo_gasto;

    $query2 = $pdo->query("UPDATE controle SET 
        minutos_dispo='$tempo_restante'
    WHERE id_nome_cliente='$id_cliente' AND status='PAGO' ORDER BY id DESC LIMIT 1 ");

    $pagina="finalizarchatvideo.php $tempo_gasto";

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
        'Video'
    )");

    // Deleta a chamada para entrar no chat 
    $Delete=$pdo->prepare("DELETE FROM chamada_consulta WHERE id=:id")->execute(array(':id' => $cod_sala));

    // DELETANDO O COOKIE E A SESSION
    if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
    if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
    if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
    if(isset($_SESSION['id_cliente'])) {  unset($_SESSION['id_cliente']); } else { unset($_SESSION['id_cliente']); }
    if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
    if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
    if(isset($_SESSION['inicia_chat3'])) {  unset($_SESSION['inicia_chat3']); } else { unset($_SESSION['inicia_chat3']); }
    if(isset($_SESSION['tempo_inicial3'])) {  unset($_SESSION['tempo_inicial3']); } else { unset($_SESSION['tempo_inicial3']); }

    // Redireciona tarólogo
    // echo "<script>alert('Passo 1');</script>";
    echo "<script>document.location.href='https://www.tarotdehorus.com.br/minha-conta'</script>";
    
} else {

    // DELETANDO O COOKIE E A SESSION
    if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
    if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
    if(isset($_SESSION['user_nivel'])) {  unset($_SESSION['user_nivel']); } else { unset($_SESSION['user_nivel']); }
    if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
    if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
    if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
    if(isset($_SESSION['inicia_chat3'])) {  unset($_SESSION['inicia_chat3']); } else { unset($_SESSION['inicia_chat3']); }
    if(isset($_SESSION['tempo_inicial3'])) {  unset($_SESSION['tempo_inicial3']); } else { unset($_SESSION['tempo_inicial3']); }

    // Redireciona tarólogo
    // echo "<script>alert('Passo 2');</script>";
    echo "<script>document.location.href='https://www.tarotdehorus.com.br'</script>";
}

// Testando Sessões
// echo 'id_tarologo: '.$_POST["id_tarologo"].'<br>';
// echo 'cod_sala: '.$_POST["cod_sala"].'<br>';
// echo 'duracao: '.$_POST['duracao'].'<br>';
// Verifica de chamada foi deletada
// $asdsadsa = $pdo->query("SELECT * FROM chamada_consulta WHERE id='$cod_sala'");
// $nLinhas = $asdsadsa->rowCount();
// if ($nLinhas > 0) {
//     echo "chamada_consulta Não foi deletado.<br>";
// } else {
//     echo "chamada_consulta Foi deletado com sucesso.<br>";
// }
// Verifica status do tarólogo
// $ssswewew = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo'");
// while ($mostrarxa = $ssswewew->fetch(PDO::FETCH_ASSOC)){ 
//     $online=$mostrarxa['online'];
// }
// echo 'Status: '.$online.'<br>';