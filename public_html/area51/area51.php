<?php 
$nascimento = "07-08-1986";


// separando yyyy, mm, ddd
list($ano, $mes, $dia) = explode('-', $nascimento);

// data atual
$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
// Descobre a unix timestamp da data de nascimento do fulano
$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);


$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
echo $idade;


?>