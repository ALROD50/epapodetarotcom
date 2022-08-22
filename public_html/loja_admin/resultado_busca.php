<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
  <thead>
    <tr style="background:#265A88; color:#fff;">
      <th> ID</th>
      <th> Foto Principal</th>
      <th> Título</th>
      <th> Preço</th>
      <th> Visualizações</th>
      <th> Categoria</th>
      <th> Status</th>
      <th> Estoque</th>
      <th> Visualizar</th>
      <th> Editar</th>
      <th> Excluir</th>
    </tr>
  </thead>
  <tbody>
  <?php  
    while ($aux = $result->fetch(PDO::FETCH_ASSOC)) {
      $foto_abertura=$aux['foto_abertura'];
      $id=$aux['id'];
      $titulo=$aux['titulo'];
      $preco=$aux['preco'];
      $preco = MostraValorDinheiroCorretamente($preco);
      $visualizacoes=$aux['visualizacoes'];
      $categoria=$aux['categoria'];
      $status=$aux['status'];
      $estoque=$aux['estoque'];
      $alias=$aux['alias'];

      $titulo_alias = TransformaAlias($titulo);

      $executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
      while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
        $categoria_nome=$dadoss66['titulo'];
      }

      $categoria_alias = TransformaAlias($categoria_nome);

      ?>
      <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo "<img src='loja_admin/foto_abertura/$foto_abertura' height='50'/>"; ?></td>
        <td><?php echo $titulo; ?></td>
        <td><?php echo $preco; ?></td>
        <td><?php echo $visualizacoes; ?></td>
        <td><?php echo $categoria_nome; ?></td>
        <td>
        <?php 
          if ($status == 'Ativo') {
              $estiloStatusPagExtra = 'label label-success';
            } elseif ($status == 'Desativado') {
              $estiloStatusPagExtra = 'label label-danger';
            } else {
              $estiloStatusPagExtra = 'label label-default';
          }
          echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status.'</span></strong>';
        ?>
        </td>
        <td><?php echo $estoque; ?></td>
        <td><a button class="btn btn-success btn-sm" <?php echo "href='../loja-item/$categoria_alias/$alias'"; ?> target='_blank'><i class="glyphicon glyphicon-eye-open icon-white"></i> Visualizar</button></a></td>
        <td>
          <?php echo "<a href='minha-conta/?pg=loja_admin/editar.php&id=$id' title='Editar' class=\"btn btn-sm\"><i class='glyphicon glyphicon-edit'></i> Editar</a>"; ?>
        </td>
        <td>
          <?php echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir' class=\"btn btn-sm\"><i class='far fa-trash-alt'></i> Excluir</a>"; ?>
        </td>
      </tr>
      <?php 
    } 
  ?>
  </tbody>
</table>
</div>