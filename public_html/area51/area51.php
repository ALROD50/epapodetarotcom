<?php 
$regex = '/^(?![ ])(?!.*(?:\d|[ ]{2}|[!$%^&*()_+|~=`\{\}\[\]:";<>?,\/]))(?:(?:e|da|do|das|dos|de|d\'|D\'|la|las|el|los|l\')\s*?|(?:[A-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\'][^\s]*\s*?)(?!.*[ ]$))+$/mu';
$nome = "Alexandre";
$resultado = preg_match($regex, $nome);

if ($resultado) { 
  echo "true"; 
} else { 
  echo "false";
}

echo "<pre>";
var_dump($resultado);
echo "</pre>";


?>