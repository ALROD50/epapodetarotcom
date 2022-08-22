<div class="card card-body p-1" style="background:#f5f5f5;">
  <form name="FormCategoria" action="" method="post" style="margin: 10px 0px 10px 0px; padding:10px;" class="form-horizontal">
    <input type="hidden" name="filtroativo" value="sim" />

    <div class="form-group">
      
      <p>Refine sua pesquisa:</p>
      
      <label for="" style="color:#265A88"><i class="far fa-folder-open"></i> Categoria:</label>
      
      <select name="categoria" id='categoria' class="form-control" size="5">
        <?php
        // se existir a variável 'filtrar', então mostra no filtro a categoria escolhida 
        if ($CategoriaLojaAtiva=='SIM') {

          ?><option value="<?php echo $tituloCategoria; ?>" selected="selected" focus><b><?php echo $tituloCategoria; ?></b></option><?php

          $sql = $pdo->query("SELECT * FROM loja_categorias WHERE id!='$idCategoria' ORDER BY titulo ASC");
        
        } else {

          ?><option value="" selected="selected"> >> Selecione aqui...</option><?php
          
          $sql = $pdo->query("SELECT * FROM loja_categorias ORDER BY titulo ASC");
        
        }

        if ($sql->rowCount() == 0) {
          echo '<option value="">Nenhum dado encontrado...</option>';
        } else { 
          while ($nomes_encontrados = $sql->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$nomes_encontrados['alias'].'">'.$nomes_encontrados['titulo'].'</option>';
          }
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <button id="enviaCategoria" name="enviaCategoria" class="btn btn-info btn-lg btn-block" type="button" data-loading-text="Aguarde..." style="font-size: 20px;" data-loading-text="Aguarde..."><i class="fas fa-filter"></i> Filtrar</button>
    </div>

  </form>
</div>

<?php
//------------------------------------------------------------------------------------------
// Console de teste do filtro
//  echo "ler-status".$status_escolhido.'<br>';
//  echo "ler-ordemv".$ordemv_escolhida.'<br>';
//  echo "ler-nome".$filtro_nome_cliente_escolhido.'<br>';
//  echo "ler-id".$filtro_id_escolhido.'<br>';
?>