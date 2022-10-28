<?php 
// Data de nascimento
$nascimento = "07-08-1986";
$nascimento   = date("Y-m-d", strtotime("$data_nascimento"));
// Separando yyyy, mm, ddd
list($ano, $mes, $dia) = explode('-', $nascimento);
// Data atual
$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
// Descobre a unix timestamp da data de nascimento do fulano
$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
// Idade 
$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
echo $idade;


?>