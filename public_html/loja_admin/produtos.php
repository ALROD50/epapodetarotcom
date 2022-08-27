<!-- caixa de verificação de exclusão -->
<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Confirma Exclusão?" ) ) {
  location="minha-conta/?pg=loja_admin/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>
<h3 class="text-success">Produtos</h3>
<hr>
<p>Abra um chamado no departamento de Atualizações da Nova Systems para saber como adiquerir este recurso.</p>

<button class="btn btn-primary" disabled="" style="" href="minha-conta/?pg=loja_admin/cadastrar_produtos.php"><i class="glyphicon glyphicon-plus"></i> Cadastrar Novo Produto</button>

<?php include "filtro.php"; ?>

<!-- Código da Paginação -->
<script type="text/javascript">
  function paginar(pagina,paginas,quant_result){
    $("#dados").html("<b><img src='img/carregando.gif' alt='' /></b>");
    $.post("loja_admin/paginacao/op.php", {pagina:pagina, paginas:paginas, quant_result:quant_result}, function(data){$("#dados").html(data);}, "html"); 
  }
</script>
<!-- Código da Paginação -->

<?php
//Paginação-------------------------------------------------------------------------
//primeiro select com um contador para saber quantos resultados serão exibidos
$result_p = $pdo->query("SELECT * FROM loja_produtos $filtro_buscar_escolhido ORDER BY titulo ASC");
$row_p = $result_p->rowCount();
//quantidade de resultados por página
$quant_resul = 10;
//página atual referente a página de index que será a primeira página
$pagina = 1;
//calculando quantidade de páginas
$paginas = ceil($row_p / $quant_resul);
//segundo select com os valores já limitados pelo limite no sql
$result = $pdo->query("SELECT * FROM loja_produtos $filtro_buscar_escolhido ORDER BY titulo ASC limit 0 , " . $quant_resul);
?>
<div id="dados">
  <?php
    //echo "ler-paginas: ".$paginas.'<br>';
    require_once "resultado_busca.php";
    //incluindo a página de índice ela é responsável por imprimir os valores das páginas e seus link's.
    if ($paginas != '0') {
      include "paginacao/indice.php";
    } else {            
      ?>
      <div class="row" style="margin-top:20px;">
        <div class="col-md-12">
          <div class="card card-body" style="background:#fff; color:#383C3F;">
            </br>
            <center><p>Nenhum resultado encontrado para sua pesquisa...</p></center>
            </br>
          </div>
        </div>
      </div>
      <?php
    }
  ?>
</div>
<?php
//Paginação ------------------------------------------------------------------------- 
