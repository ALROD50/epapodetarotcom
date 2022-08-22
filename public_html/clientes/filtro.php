<form action="" method="post" style="margin: 10px 0px 10px 0px;" class="form-inline">

	Pesquisa:
	<input type="text" name="buscar" value="" class="form-control" placeholder="E-mail" style="margin-right: 10px;"/>

  <input type="text" name="nome" value="" class="form-control" placeholder="Nome" style="margin-right: 10px;"/>

	<select name="ordemv" id="ordemv" class="input-medium form-control" style="margin-right: 10px;">
	<option value="" selected="selected">  Ordem  </option>
	<option value="ASC">Id Ascendente</option>
	<option value="DESC">Id Decrescente</option>
	<option value="Cadastro">Data de Cadastro</option>
	<option value="NOME">Por Nome</option>
	</select>

	<input type="submit" type="button" name="filtros" value="ok" class="btn btn-sm btn-primary"/>

</form>

<?php
//Variavel do filtro Buscar
$filtro_buscar = @$_POST['buscar'];
$filtro_buscar_escolhido = null;

//Variavel do filtro nome
$filtro_nome = @$_POST['nome'];
$filtro_nome_escolhido = null;

//Variaveis do filtro Ordem
$ordemv = @$_POST['ordemv']; 
$ordemv_escolhida = null;

// Transforma as variaveis do filtro em sessões para consulta no banco de dados
if(!empty($filtro_buscar) )
{ 
  $filtro_buscar_escolhido = "AND email LIKE '%{$filtro_buscar}%' ";
  $_SESSION['buscar_session'] = $filtro_buscar_escolhido;
}  else { unset($_SESSION['buscar_session']); }
//------------------------------------------------------------------------------------------
if(!empty($filtro_nome) )
{ 
  $filtro_nome_escolhido = "AND nome LIKE '%{$filtro_nome}%' ";
  $_SESSION['nome_session'] = $filtro_nome_escolhido;
}  else { unset($_SESSION['nome_session']); }
//------------------------------------------------------------------------------------------
if (!empty($ordemv) )
{   
  // Se a variavel do filtro ORDEM não estiver Vazio, ela vai receber o dado escolhido no filtro que é ela mesmo.
  $ordemv_escolhida = "ORDER BY id $ordemv";
  // Criando a sessão ORDEM de acordo com o que foi escolhido no filtro.
  $_SESSION['ordem_session'] = $ordemv_escolhida;
  // Caso o usuário não tenha escolhido nenhum ORDEM no filtro a sessão ORDEM fica vazia.
} elseif (empty($ordemv)) { 
  $ordemv_escolhida = "ORDER BY id DESC";
  $_SESSION['ordem_session'] = $ordemv_escolhida;

} else { unset($_SESSION['ordem_session']); }

if ($ordemv == "Cadastro") {
  $ordemv_escolhida = "ORDER BY data_registro ASC";
  $_SESSION['ordem_session'] = $ordemv_escolhida;
}

if ($ordemv == "NOME") {
  $ordemv_escolhida = "ORDER BY nome ASC";
  $_SESSION['ordem_session'] = $ordemv_escolhida;
}
// Console de teste do filtro
//  echo "ler-status".$status_escolhido.'<br>';
//  echo "ler-ordemv".$ordemv_escolhida.'<br>';
//  echo "ler-nome".$filtro_nome_cliente_escolhido.'<br>';
//  echo "ler-id".$filtro_id_escolhido.'<br>';
?>