<?php 
$regex = "/^(?:[\p{Lu}&&[\p{IsLatin}]])(?:(?:')?(?:[\p{Ll}&&[\p{IsLatin}]]))+(?:\-(?:[\p{Lu}&&[\p{IsLatin}]])(?:(?:')?(?:[\p{Ll}&&[\p{IsLatin}]]))+)*(?: (?:(?:e|y|de(?:(?: la| las| lo| los))?|do|dos|da|das|del|van|von|bin|le) )?(?:(?:(?:d'|D'|O'|Mc|Mac|al\-))?(?:[\p{Lu}&&[\p{IsLatin}]])(?:(?:')?(?:[\p{Ll}&&[\p{IsLatin}]]))+|(?:[\p{Lu}&&[\p{IsLatin}]])(?:(?:')?(?:[\p{Ll}&&[\p{IsLatin}]]))+(?:\-(?:[\p{Lu}&&[\p{IsLatin}]])(?:(?:')?(?:[\p{Ll}&&[\p{IsLatin}]]))+)*))+(?: (?:Jr\.|II|III|IV))?/";
$nome = "William Henry Gates III";
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