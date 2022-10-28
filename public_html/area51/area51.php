<?php 
$regex = "/^[a-z]{2,}\ [a-z]{2,}/";
$nome = "andreia silva";
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