<?php
ini_set ('default_charset', 'UTF8');
date_default_timezone_set('America/Sao_Paulo');
header('X-UA-Compatible: IE=edge');
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
error_reporting(E_ALL); // Força o PHP a mostrar os erros.
// phpinfo();
session_start();
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
require_once "/home/tarotdehoruscom/public_html/includes/functions.php";
$pdo = conexao();
if(@$_GET['novocliente']=='true'){
	include 'novocliente.php';
}
if(@$_GET['validasenha']=='true'){
	$usuario_id=$_GET['id'];
	$email=$_GET['email'];
    date_default_timezone_set("Brazil/East");
    #### Sistema de login com Cookies -----------------------------------
    setcookie("UsuarioID", $_GET['id'], time()+3600*24*30*12*5, "/", NULL);
    setcookie("UsuarioNome", $_GET['nome'], time()+3600*24*30*12*5, "/", NULL);
    setcookie("UsuarioNivel", $_GET['nivel'], time()+3600*24*30*12*5, "/", NULL);
    setcookie("UsuarioStatus", $_GET['status'], time()+3600*24*30*12*5, "/", NULL);
    @$usuario_id     = $_COOKIE["UsuarioID"];
    @$usuario_nome   = $_COOKIE["UsuarioNome"];
    @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
    @$usuario_status = $_COOKIE["UsuarioStatus"];
    #### Sistema de login com Cookies -----------------------------------
    //Registrar usuário como online
    $datacompleta2 = date("Y-m-d H:i:s");
    $query = $pdo->query("UPDATE clientes SET 
        online='online',
        time='$datacompleta2'
    WHERE email='$email'");
    $_SESSION['usuario_id'] = $usuario_id;
	// echo "<script>document.location.href='https://www.tarotdehorus.com.br/cartomantes/index.php?pg=page5.php&email=$email'</script>";
	$tarologo = $_SESSION['id_tarologo'];
	$nome = $_SESSION['nome'];
	echo "<script>document.location.href='https://www.tarotdehorus.com.br/comprar-consulta/$tarologo/chat/?msgs=Parabéns $nome, você foi registrado no site com sucesso!<br>%C3%93tima%20Escolha!,%20Vamos%20Realizar%20Sua%20Consulta!'</script>";
}
include "head.php";
?> 
<div class="container-fluid">
   	<div class="row">
   		<div class="col-md-12">
   			<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
   			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
   				<div class="row">
					<center><img src="https://www.tarotdehorus.com.br/images/Logo-Site.fw.webp" alt="Tarot de Hórus" title="Tarot de Hórus" style="max-width:80%;" /></center>
				</div>
				<div style="clear: both;"></div>
				<style>
					#chat-application {
					    display: none !important;
					}
				</style>
				<div class="row" style="border-top: 3px solid #f7b334; margin-left:0px; margin-right: 0px;">
					<?php
					require_once "/home/tarotdehoruscom/public_html/includes/msg.php";
					if (isset($_GET['pg']) ? $_GET['pg'] : '') {
					   include "".$_GET['pg'];
					} else {
					   include "page1.php";
					} 
					include "rodape.php";
					?>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 hidden-sm hidden-xs"></div>
        </div>	
	</div>
</div>