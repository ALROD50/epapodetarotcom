<?php
//
// PARA CLIENTES
//
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
// echo '<div style="position:absolute; font-size:42px;">';
// echo 'Pesquisando... '.time().'</br>';
// echo '</div>';
$id_tarologo = $_POST['id_tarologo'];
$id_cliente  = $_POST['id_cliente'];
$cod_sala    = $_POST['cod_sala'];

//Verificar no banco "chamada_consulta" na tabela "cod_sala" e na tabela "tarologo_entrou" se existe o "TAROLOGOENTROU"
$sql = $pdo->query("SELECT * FROM chamada_consulta WHERE id='$cod_sala'"); 

while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
	$tarologo_entrou = $row["tarologo_entrou"];
	$acesso          = $row["acesso"];
}

if ($tarologo_entrou == "TAROLOGOENTROU" AND $acesso == "") {
	//Tarólogo Entrou!

	// Negando acesso deste atendimento para outros clientes
	$query = $pdo->query("UPDATE chamada_consulta SET 
    	acesso='NEGADO'
  	WHERE id='$cod_sala' ");
    
	//Abrir o Chat Automaticamente
  	echo "<script>document.location.href='https://www.epapodetarot.com.br/chat/index.php?cod_sala=".$cod_sala."&id_usuario=".$id_cliente."'</script>";

}
?>