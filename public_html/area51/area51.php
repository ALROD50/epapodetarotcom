<?php 
$regex = "/^[A-zÀ-ú]{2,}\ [A-zÀ-ú]{2,}/";
$nome = "andréia ";
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