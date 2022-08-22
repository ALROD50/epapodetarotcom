<h3 class="text-success">Visualizar / Editar Pedidos</h3>
<hr>
<?php
$id = @$_GET['id'];
$executa66 = $pdo->query("SELECT * FROM loja_pedidos WHERE id='$id'");
while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 

    $id_nome_cliente=$dadoss66['id_cliente'];
    $id_nome_produto=$dadoss66['id_produto'];
    $quantidade=$dadoss66['quantidade'];
    $telefone=$dadoss66['telefone'];
    $data=$dadoss66['data'];
    $data=MostraDataCorretamenteHora($data);
    $status_pagamento=$dadoss66['status_pagamento'];
    $status_entrega=$dadoss66['status_entrega'];
    $cod_rastreio=$dadoss66['cod_rastreio'];
    $valor=$dadoss66['valor'];
    $valor = MostraValorDinheiroCorretamente($valor);
    $cidade=$dadoss66['cidade'];
    $frete=$dadoss66['frete'];
    $frete = MostraValorDinheiroCorretamente($frete);
    $nome_destinatario=$dadoss66['nome_destinatario'];
    $end=$dadoss66['endereco'];
    $bairro=$dadoss66['bairro'];
    $numero=$dadoss66['numero'];
    $complemento=$dadoss66['complemento'];
    $estado=$dadoss66['estado'];
    $cep=$dadoss66['cep'];
    $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
    while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)) {
      $nome_cliente=$dados22['nome'];
    }
    if ($nome_cliente == "") {
      $nome_cliente_compra = "";
    }
}

if ( isset($_POST["salva"]) ) {

    $cod_rastreio     = $_POST['cod_rastreio']; 
    $status_pagamento = $_POST['status_pagamento'];
    $status_entrega   = $_POST['status_entrega'];

    $query = $pdo->query("UPDATE loja_pedidos SET 
	    cod_rastreio='$cod_rastreio',
	    status_pagamento='$status_pagamento',
	    status_entrega='$status_entrega'
    WHERE id='$id'");
        
    ?>
    <div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
      <h3>Alteração do Pedido</h3>
      <p>Dados atualizados com sucesso!</p>
    </div>
    <?php 
}
?>

<div class="row">
	    
    <div class="col-md-3">
        
        <p><b style="font-size:18px;">Atualizar Dados</b></p>

    	<hr style="border-top: 1px solid #ccc;">

		<form name="editarpedido" id="editarpedido" method="post" action=""  class="form-inline"  enctype="multipart/form-data">

			<div class="card card-body" style="padding:10px;">

			    Cod de Rastreio:<br>
			    <input type="text" name="cod_rastreio" value="<?php echo @$cod_rastreio; ?>" class="form-control"/>

			    Status de Pagamento:<br>
			    <select name="status_pagamento" class="form-control" required  > 
	                <option value="<?php echo $status_pagamento; ?>" selected><?php echo $status_pagamento; ?></option>
	                <option value="Aguardando">Aguardando</option> 
	                <option value="PAGO">Pago</option>
	                <option value="CANCELADO">Cancelado</option> 
	            </select>

			    Status de Entrega:<br>
			    <select name="status_entrega" class="form-control" required  > 
	                <option value="<?php echo $status_entrega; ?>" selected><?php echo $status_entrega; ?></option>
	                <option value="Preparando">Preparando</option>
	                <option value="Em percuso">Em percuso</option> 
	                <option value="Entregue">Entregue</option>
	                <option value="Cancelado">Cancelado</option> 
	            </select>

				<p style="padding:10px;">
			        <input class="btn btn-success" type="submit" name="salva" value="Atualizar" />
			        <input class="btn btn-info" type="button" name="Cancel" value="Voltar" onclick="window.location = 'minha-conta/?pg=loja_admin/pedidos.php' " /> 
			    </p>

		    </div>

		</form>

    </div>

    <div class="col-md-9">
    	
    	<p><b style="font-size:18px;">Dados Gerais do Pedido</b></p>

	    <hr style="border-top: 1px solid #ccc;">

	    <div class="card card-body" style="padding:20px;">

			<div style="margin:1px; display:inline-block;">
			    <b>Data do Pedido:</b>&nbsp;&nbsp;
			    <?php echo $data; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Valor do Pedido:</b>&nbsp;&nbsp;
			    <?php echo $valor; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Frete:</b>&nbsp;&nbsp;
			    <?php echo $frete; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Cliente:</b>&nbsp;&nbsp;
			    <?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id_nome_cliente' data-toggle='tooltip' title='$nome_cliente'>$nome_cliente</a>"; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Nome Destinatário:</b>&nbsp;&nbsp;
			    <?php echo $nome_destinatario; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Telefone:</b>&nbsp;&nbsp;
			    <?php echo $telefone; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Endereço de Entrega:</b>&nbsp;&nbsp;
			    <?php echo $end; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Número:</b>&nbsp;&nbsp;
			    <?php echo $numero; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Complemento:</b>&nbsp;&nbsp;
			    <?php echo $complemento; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Bairro:</b>&nbsp;&nbsp;
			    <?php echo $bairro; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Estado:</b>&nbsp;&nbsp;
			    <?php echo $estado; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>Cidade:</b>&nbsp;&nbsp;
			    <?php echo $cidade; ?>
			</div>

			<div style="margin:1px; display:inline-block;">
			    <b>CEP:</b>&nbsp;&nbsp;
			    <?php echo $cep; ?>
			</div>
			
			<p style="margin-top:20px; margin-bottom:20px;"><span style="font-size:25px; color:#1f860c;">Produtos no pedido:</span></p>

			<div class="row">
				<div class="col-md-9" style="padding-right:0px;">
				    <?php
				    $id_nome_produto = substr($id_nome_produto, 0, -1); // exclui o último caractere
				    $itemProduto    = explode(",", $id_nome_produto);
					foreach ($itemProduto as $produto) {

						// pega nome do produto
						$sql22 = $pdo->query("SELECT * FROM loja_produtos WHERE id='$produto' LIMIT 1"); 
				        while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)) {
				          $titulo=$dados22['titulo'];
				          $alias=$dados22['alias'];
				          $categoria=$dados22['categoria'];
				        }
				        $executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
						while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)){ 
							$categoria_nome=$dadoss66['titulo'];
						}

						$categoria_alias = TransformaAlias($categoria_nome);

						echo "<b>ID:</b> $produto  <b>Produto: </b><b><a href='../loja-item?/$categoria_alias/$alias' target='_blank' data-toggle='tooltip'>$titulo</a></b><br><hr style='border-top: 1px solid #ccc;'>";
					}
				    ?>
				</div>
				<div class="col-md-3" style="padding-left:0px;">
					<?php
				    $quantidade = substr($quantidade, 0, -1); // exclui o último caractere
				    $itemQuantidade = explode(",", $quantidade);
					foreach ($itemQuantidade as $quantidade) {
						
						echo "<b>Quantidade:</b> $quantidade<br><hr style='border-top: 1px solid #ccc;'>";
					}
				    ?>
				</div>
			</div>

	    </div>
    </div>

</div>