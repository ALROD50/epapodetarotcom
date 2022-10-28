<?php 
$re = '/^(?![ ])(?!.*(?:\d|[ ]{2}|[!$%^&*()_+|~=`\{\}\[\]:";<>?,\/]))(?:(?:e|da|do|das|dos|de|d\'|D\'|la|las|el|los|l\')\s*?|(?:[A-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\'][^\s]*\s*?)(?!.*[ ]$))+$/mu';
$str = 'Maria  Silva
Maria silva
maria Silva
MariaSilva
 Maria Silva
Maria Silva 
Maria da Silva
Marina Silva
Maria / Silva
Maria . Silva
Maria Silva
Maria G. Silva
Maria McDuffy
Getúlio Dornelles Vargas
Maria das Flores
John Smith
John D\'Largy
John Doe-Smith
John Doe Smith
Hector Sausage-Hausen
Mathias d\'Arras
Martin Luther King Jr.
Ai Wong
Chao Chang
Alzbeta Bara
Marcos Assunção
Maria da Silva e Silva
Juscelino Kubitschek de Oliveira
Natalia maria
Natalia aria
Natalia orea
Maria dornelas
Samuel eto\'
Maria da Costa e Silva
Samuel Eto\'o
María Antonieta de las Nieves
Eugène
Antòny de Homé April
àntony de Home ùpril
Antony de Home Aprìl
Antony1 de Home Ap*ril
Ap*ril Willians
Antony_ de Home Apr+il
Ant_ony de Home Apr#il
Antony@ de Ho@me Apr^il
Pierre de l\'Estache
Pierre de L\'Estoile
Akihito
';

preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

// Print the entire match result
var_dump($matches);

// echo "<pre>";
// var_dump($resultado);
// echo "</pre>";


?>