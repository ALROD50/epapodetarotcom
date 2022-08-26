<div class="card card-body p-1 pb-4" style="background:#f5f5f5; font-size:19px;">

  <div class="text-center mt-2 my-0">
    <h3>Categorias</h3>
    <hr>
  </div>

  <?php
  $executa = $pdo->query("SELECT * FROM blog_categoria ORDER by titulo ASC");
  $encontrados = $executa->rowCount();
  while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC)) { 
    $titulo=$dadoss['titulo'];
    $alias=$dadoss['alias'];
    echo '<p class="ml-2 mb-0 py-0"><a href="blog/'.$alias.'" class="link-padraotres text-decoration-none">- '.$titulo.'</a></p>';
  }
  ?>
</div>