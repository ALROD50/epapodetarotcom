<style>
  .nav-pills>li>a {
    border-radius: 4px;
    color: #fff;
  }
  .menuservico {
    border-color: #ddd;
    background: #333333;
  }
  .nav-pills>li>a:hover {
    color: #000;
    background-color: #fff;
  }
</style>
<h3 class="text-success"><i class="glyphicon glyphicon-blackboard"></i> Loja - É Papo de Tarot</h3>
<hr>
<?php $tab = isset($_GET['tab']) ? $_GET['tab'] : 'estatisticas'; ?>

<div class="tabbable">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked panel panel-default menuservico" id="myTab">
          <center><div style="margin: 8px; color: #ffffff;">MENU</div></center>
          <li <?php if ($tab == 'estatisticas') { echo 'class="active"';} ?> ><a data-target="#estatisticas" data-toggle="tab"><i class="glyphicon glyphicon-stats"></i> Estatísticas</a></li>
          <li <?php if ($tab == 'pedidos') { echo 'class="active"';} ?> ><a data-target="#pedidos" data-toggle="tab" class="pointer"><i class="glyphicon glyphicon-shopping-cart"></i> Pedidos</a></li>
          <li <?php if ($tab == 'produtos') { echo 'class="active"';} ?> ><a data-target="#produtos" data-toggle="tab" class="pointer"><i class="glyphicon glyphicon-tags"></i>&nbsp;&nbsp;Produtos</a></li>
        </ul>
      </div>
      <div class="col-md-10">
        <div class="tab-content">
          <div <?php if ($tab == 'estatisticas') { echo 'class="tab-pane active"';} else { echo 'class="tab-pane"'; } ?> id="estatisticas">
            <?php include "estatisticas.php"; ?>
          </div>
          <div <?php if ($tab == 'pedidos') { echo 'class="tab-pane active"';} else { echo 'class="tab-pane"'; } ?> id="pedidos">
            <?php include "pedidos.php"; ?>
          </div>
          <div <?php if ($tab == 'produtos') { echo 'class="tab-pane active"';} else { echo 'class="tab-pane"'; } ?> id="produtos">
            <?php include "produtos.php"; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>