<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
ini_set('display_errors',0);
ini_set('display_startup_erros',0);
session_start();
include "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo=conexao();
ob_start();

#### Recupera Cookies -----------------------------------
@$usuario_id     = $_COOKIE["UsuarioID"];
@$usuario_nome   = $_COOKIE["UsuarioNome"];
@$usuario_nivel  = $_COOKIE["UsuarioNivel"];
@$usuario_status = $_COOKIE["UsuarioStatus"];
#### Recupera Cookies -----------------------------------

//Deixa usuário Offline
$query = $pdo->query("UPDATE clientes SET 
	online='offline',
	time=''
WHERE id='$usuario_id'");

// DESTRÓI SESSOES
unset($_SESSION[cod_sala]);
unset($_SESSION[nome]);
unset($_SESSION[id_usuario_logado]);
unset($_SESSION[user_nivel]);
unset($_SESSION[credito]);
unset($_SESSION[id_tarologo]);
unset($_SESSION[id_cliente]);
unset($_SESSION[nome_tarologo]);
unset($_SESSION[nome_cliente]);
unset($_SESSION[face_access_token]);
unset($_SESSION[inicia_chat3]);
unset($_SESSION[tempo_inicial3]);

// DESTRÓI COOKIE
setcookie('UsuarioID', null, -1, '/');
setcookie('UsuarioNome', null, -1, '/');
setcookie('UsuarioNivel', null, -1, '/');
setcookie('UsuarioStatus', null, -1, '/');

//REDIRECIONA PARA A TELA DE LOGIN
header("Location: https://www.tarotdehorus.com.br/");