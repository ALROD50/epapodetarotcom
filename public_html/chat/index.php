<?php
@$usuario_id = $_COOKIE["UsuarioID"];
session_start();
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
ini_set('display_errors',0); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',0); // Força o PHP a mostrar os erros.
//error_reporting(E_ALL); // Força o PHP a mostrar os erros.
if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
if(isset($_SESSION['id_usuario_logado'])) {  unset($_SESSION['id_usuario_logado']); } else { unset($_SESSION['id_usuario_logado']); }
if(isset($_SESSION['user_nivel'])) {  unset($_SESSION['user_nivel']); } else { unset($_SESSION['user_nivel']); }
if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
if(isset($_SESSION['id_tarologo'])) {  unset($_SESSION['id_tarologo']); } else { unset($_SESSION['id_tarologo']); }
if(isset($_SESSION['id_cliente'])) {  unset($_SESSION['id_cliente']); } else { unset($_SESSION['id_cliente']); }
if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
if($_SERVER['REQUEST_METHOD'] == 'GET'){

	//Pega os dados do get
	$cod_sala = $_GET['cod_sala'];
	$id_usuario = $_GET['id_usuario'];

	//Registrando que o tarologo esta ocupado
    $datacompleta2 = date("Y-m-d H:i:s");
    $sql_queryx = $pdo->query("UPDATE clientes SET 
		online='ocupado',
		time='$datacompleta2'
	WHERE id='$id_usuario'");

	//Cria a sessão ID da sala
	$_SESSION['cod_sala'] = $cod_sala;

	//Verifica se o usuário é tarólogo ou cliente
	$sql = $pdo->query("SELECT * FROM clientes WHERE id='$id_usuario' LIMIT 1 ");
	while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 

		$nivel=$mostrar['nivel'];
		$id_usuario_logado=$mostrar['id'];
		$usuario_nome=$mostrar['nome'];

		// Cria sessão Nome do usuário
		$_SESSION['nome'] = $usuario_nome;	  

		// Cria sessão ID do usuário
		$_SESSION['id_usuario_logado'] = $id_usuario_logado;

		// Cria sessão do Nível do usuário
		$_SESSION['user_nivel'] = $nivel;
	}

	// Criando Sessões da Sala
	$sql = $pdo->query("SELECT * FROM chamada_consulta WHERE id='$cod_sala'");
	while ($row = $sql->fetch(PDO::FETCH_ASSOC)){

		$id_chamada        = $row["id"];
		$tarologo_entrou   = $row["tarologo_entrou"];
		$cliente_chamando  = $row["cliente_chamando"];
		$credito           = $row["tempo"]; //Em segundos...
		$id_tarologo       = $row["id_tarologo"];
		$id_cliente        = $row["id_cliente"];
		$videochat         = $row["videochat"];

		// Cria sessão ID do Crédito
		$_SESSION['credito'] = $credito;

		// Cria sessão do ID Tarólogo
		$_SESSION['id_tarologo'] = $id_tarologo;

		// Cria sessão do ID Cliente
		$_SESSION['id_cliente'] = $id_cliente;
	}

	$id_tarologo = $_SESSION['id_tarologo'];
	$id_cliente = $_SESSION['id_cliente'];

	//Verifica nome do tarólogo
	$sql7 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo' LIMIT 1 ");
	while ($mostrar7 = $sql7->fetch(PDO::FETCH_ASSOC)) { 

	  $nome_tarologo=$mostrar7['nome'];
	  $tarologo_online=$mostrar7['online'];
	  $videochamada=$mostrar7['videochamada'];
	  // Cria sessão Nome do tarólogo
	  $_SESSION['nome_tarologo'] = $nome_tarologo;	  
	}

	//Verifica nome do cliente	
	$sql77 = $pdo->query("SELECT * FROM clientes WHERE id='$id_cliente' LIMIT 1 ");
	while ($mostrar77 = $sql77->fetch(PDO::FETCH_ASSOC)) { 

	  $nome_cliente=$mostrar77['nome'];
	  $cliente_online=$mostrar77['online'];
	  // Cria sessão Nome do cliente
	  $_SESSION['nome_cliente'] = $nome_cliente;	  
	}

	//Loog
	// echo 'Cod da sala: '.$cod_sala.'</br>';
	// echo $_SESSION['cod_sala'].'</br>';
	// echo $_SESSION['id_usuario_logado'].'</br>';
	// echo $_SESSION['user_nivel'].'</br>';
	// echo $_SESSION['credito'].'</br>';
	// echo $_SESSION['id_tarologo'].'</br>';
	// echo $_SESSION['id_cliente'].'</br>';
	// echo $tarologo_entrou.'</br>';
	// echo $cliente_chamando.'</br>';
	// echo 'Tarologo Online: '.$tarologo_online.'</br>';
	// echo 'Cliente Online: '.$cliente_online.'</br>'; 
	// exit();

	//Cria sessão do chat.
	if($tarologo_entrou == "TAROLOGOENTROU" AND $cliente_chamando == "cliente_chamando"){

		// Verifica se tarólogo permite videochat
		if ($videochamada=="SIM") {
			$videochat=="SIM";
		} else {
			$videochat=="NAO";
		}

		if ($videochat=="SIM") {
			// Enviar para a videochamada
			header("location:chatvideo-index.php?room=$cod_sala");
			exit();

		} else {
			// Enviar para o chat
			header("location:chat-index.php?room=$cod_sala");
			exit();
		}
	
	} else {

		session_start();
		if(isset($_SESSION['cod_sala'])) {  unset($_SESSION['cod_sala']); } else { unset($_SESSION['cod_sala']); }
		if(isset($_SESSION['nome'])) {  unset($_SESSION['nome']); } else { unset($_SESSION['nome']); }
		if(isset($_SESSION['id_usuario_logado'])) {  unset($_SESSION['id_usuario_logado']); } else { unset($_SESSION['id_usuario_logado']); }
		if(isset($_SESSION['user_nivel'])) {  unset($_SESSION['user_nivel']); } else { unset($_SESSION['user_nivel']); }
		if(isset($_SESSION['credito'])) {  unset($_SESSION['credito']); } else { unset($_SESSION['credito']); }
		if(isset($_SESSION['id_tarologo'])) {  unset($_SESSION['id_tarologo']); } else { unset($_SESSION['id_tarologo']); }
		if(isset($_SESSION['id_cliente'])) {  unset($_SESSION['id_cliente']); } else { unset($_SESSION['id_cliente']); }
		if(isset($_SESSION['nome_tarologo'])) {  unset($_SESSION['nome_tarologo']); } else { unset($_SESSION['nome_tarologo']); }
		if(isset($_SESSION['nome_cliente'])) {  unset($_SESSION['nome_cliente']); } else { unset($_SESSION['nome_cliente']); }
	    $datacompleta2 = date("Y-m-d H:i:s");
	    $sql_queryx = $pdo->query("UPDATE clientes SET 
			online='online',
			time='$datacompleta2'
		WHERE id='$id_usuario'");
		@$pdo->query("DELETE FROM chamada_consulta WHERE id_cliente='$usuario_id'");
		@$pdo->query("DELETE FROM chamada_consulta WHERE id_tarologo='$usuario_id'");
		@$pdo->query("DELETE FROM chat WHERE cod_sala='$cod_sala'");

		if ($nivel=="CLIENTE") {
			echo "<script>alert('Desculpe, seu tarólogo esta ocupado... Por gentileza escolha outro consultor, vamos te mostrar as opções a seguir...')</script>";
		} else {
			echo "<script>alert('Desculpe, este cliente deixou a sala há alguns segundos atrás... vamos te levar de volta para o site, pois o cliente pode tentar de novo. ')</script>";
		}

		echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos'</script>";
	}

} else {

	//Se não existir get, sair do chat.
	echo "<script>document.location.href='https://www.epapodetarot.com.br/'</script>";
}
?>
