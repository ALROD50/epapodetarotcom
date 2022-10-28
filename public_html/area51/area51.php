<?php 
$nascimento = date("Y-m-d", strtotime("07-08-1986"));
$hoje = date("Y-m-d");
$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
echo $nascimento;


?>