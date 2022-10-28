<?php 
$regex = "/^((\b[A-zÀ-ú']{2,40}\b)\s*){2,}$/";
$nome = "Andréia";
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