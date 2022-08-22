<?php
//conexão com o banco de dados
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "../../includes/conexaoPdo.php"; // se conecta ao banco de dados
$pdo = conexao();
session_start();

// Função Mostra Data Corretamente
function MostraDataCorretamenteHora ($data_correta_mostrar) {
  $new_data = date("d-m-Y H:i:s", strtotime("$data_correta_mostrar")); //Formatando para mostrar ao usuario.

  if ($new_data == "31-12-1969") {
    $new_data = "00-00-0000";
  } elseif ($new_data == "31-12-2069") {
    $new_data = "00-00-0000";
  } elseif ($new_data == "30-11--0001") {
    $new_data = "00-00-0000";
  }
  return $new_data;
}
function MostraValorDinheiroCorretamente ($valor_correto_mostrar) {
  $new_valor = 'R$ '. number_format($valor_correto_mostrar, 2, ',', '.'); //Formatando para mostrar ao usuario.
  return $new_valor;
}
function TransformaAlias($string) {
  $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
  $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
  $string = preg_replace("/ /", "-", $string);
  $string = strtolower($string);
  $string = preg_replace("/--/", "", $string);
  $string = str_replace("/", "", $string);
  $string = str_replace("ç", "c", $string);
  $string = str_replace("Ç", "c", $string);
  $string = stripslashes($string);
  return $string;
}

// Variaveis globais
// $home="../index.php";
// $title="Visa Check do Brasil - Boleto Bancário e Carnê Online é Aqui";
// $display="";
// $msg = "";
// $dataHora = date("d/m/Y h:i:s");
// $data_dia = date("d");
// $data_mes = date("m");
// $data_ano = date("Y");
//Variavéis de login
// $usuario_id     = $_SESSION['UsuarioID'];
// $usuario_nome   = $_SESSION['UsuarioNome'];
// $usuario_nivel  = $_SESSION['UsuarioNivel'];
// $usuario_status = $_SESSION['UsuarioStatus'];

// Variaveis do filtro Pesquisar
//$pesquisar_escolhido = $_SESSION['pesquisar'];

//Variaveis do filtro Ordem
//$ORDEM_escolhida= @$_SESSION['ordem_session'];

//Variaveis do filtro Periodo
//$periodo = @$_SESSION['periodo_session'];

//Variavel do filtro nome cliente
//$filtro_nome_cliente = @$_SESSION['nome_cliente_session'];

// Essa paginação é importante porque ela le essa código uma vez, e só da refresh se o usuário clicar em outra pagina ou função.
// Para esta paginação dar certo as mesmas variaveis do filtro que estão aqui devem ser iguais as da pagina Ler.php

// recebendo conteudo da página anterior, que vêm através do método post
$pagina = $_POST['pagina'];
$quant_resul = $_POST['quant_result'];
$paginas = $_POST['paginas'];

// calculando onde o limit deve começar no Select
$start = $pagina * $quant_resul; 
$pagina++;

// select com os limites definidos (inicio e quantidade de resultados)
$result = $pdo->query("SELECT * FROM loja_produtos ORDER BY titulo ASC LIMIT " . $start . " , " . $quant_resul);

//Consele paginação   
// echo "op-pagina: ".$pagina.'<br>';
// echo "op-quant_resul: ".$quant_resul.'<br>';
// echo "op-paginas: ".$paginas.'<br>';
// echo "op-start: ".$start.'<br>';

//impresão dos valores que serão trocados dentro da DIV dados
require_once "../resultado_busca.php";

//incluindo a página de índice ela é responsável por imprimir os valores das páginas e seus link's.
include "indice.php";
?>