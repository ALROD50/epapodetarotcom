<?php 
require_once "/home/tarotdehoruscom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
$usuario_id = @$_POST['usuario_id'];
$Delete=$pdo->prepare("DELETE FROM chamada_consulta WHERE id_cliente=:id_cliente")->execute(array(':id_cliente' => $usuario_id));
?>