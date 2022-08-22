<form action="" method="post" style="margin: 10px 0px 10px 0px;" class="form-inline">
  Pesquisar Artigo:
  <input type="text" name="buscar" value="" class="form-control"/>
  <input type="submit" type="button" name="filtros" value="ok" class="btn btn-sm btn-primary"/>
</form>
<?php

//Variavel do filtro Buscar
$filtro_buscar = @$_POST['buscar'];
$filtro_buscar_escolhido = null;

// Transforma as variaveis do filtro em sessões para consulta no banco de dados
//------------------------------------------------------------------------------------------
if(!empty($filtro_buscar) )
{ 
  $filtro_buscar_escolhido = "AND titulo LIKE '%{$filtro_buscar}%' ";
  $_SESSION['buscar_session'] = $filtro_buscar_escolhido;
}  else { unset($_SESSION['buscar_session']); }
//------------------------------------------------------------------------------------------
// Console de teste do filtro
//  echo "ler-filtro_buscar_escolhido".$filtro_buscar_escolhido.'<br>';
//  echo "ler-ordemv".$ordemv_escolhida.'<br>';
//  echo "ler-nome".$filtro_nome_cliente_escolhido.'<br>';
//  echo "ler-id".$filtro_id_escolhido.'<br>';
?>