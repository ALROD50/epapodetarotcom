<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>
<h3 class="text-success">Pedidos da Loja Virtual</h3>

<?php
$sql = $pdo->query("SELECT * FROM loja_pedidos WHERE id_cliente='$usuario_id' ORDER BY data DESC ");
$row = $sql->rowCount();

if ($row > 0) { 

    while ($mostrar=$sql->fetch(PDO::FETCH_ASSOC)) {  
        $id=$mostrar['id'];
        $id_nome_cliente=$mostrar['id_cliente'];
        $id_produto=$mostrar['id_produto'];
        $quantidade=$mostrar['quantidade'];
        $telefone=$mostrar['telefone'];
        $data=$mostrar['data'];
        $data=MostraDataCorretamenteHora($data);
        $status_pagamento=$mostrar['status_pagamento'];
        $status_entrega=$mostrar['status_entrega'];
        $cod_rastreio=$mostrar['cod_rastreio'];
        $valor=$mostrar['valor'];
        $valor = MostraValorDinheiroCorretamenteNoCifrao($valor);
        $cidade=$mostrar['cidade'];
        $frete=$mostrar['frete'];
	    $frete = MostraValorDinheiroCorretamente($frete);
	    $nome_destinatario=$mostrar['nome_destinatario'];
	    $end=$mostrar['endereco'];
	    $numero=$mostrar['numero'];
	    $complemento=$mostrar['complemento'];
	    $estado=$mostrar['estado'];
	    $cep=$mostrar['cep'];
        $sql22 = $pdo->query("SELECT * FROM clientes WHERE id='$id_nome_cliente' LIMIT 1"); 
        while ($dados22= $sql22->fetch(PDO::FETCH_ASSOC)) {
          $nome_cliente=$dados22['nome'];
        }
        ?>
        <div class="card card-body" style="padding:20px; border-left: 5px solid #ccc;">

        	<div class="row">

        		<div class="col-md-6">        			
		        	<div class="card card-body" style="padding:20px;background:#fff;">

		        		<div style="display:inline-block;">
						    <i class="glyphicon glyphicon-stats"></i> <b>Pedido:</b>&nbsp;&nbsp;
						    <?php echo '#'.$id; ?>
						</div>
						<div style="display:inline-block;">
						    <b>Data do Pedido:</b>&nbsp;&nbsp;
						    <?php echo $data; ?>
						</div>
						<div style="display:inline-block;">
						    <b>Valor do Pedido:</b>&nbsp;&nbsp;
						    <?php echo $valor; ?>
						</div>
						<div style="display:inline-block;">
						    <b>Frete:</b>&nbsp;&nbsp;
						    <?php echo $frete; ?>
						</div>
						<div style="display:inline-block;">
						    <b>Status Pagamento:</b>&nbsp;&nbsp;
						    <?php 
							if ($status_pagamento == 'Aguardando') {
								$estiloStatusPagExtra = 'label label-default';
							} elseif ($status_pagamento == 'PAGO') {
								$estiloStatusPagExtra = 'label label-success';
							} else {
								$estiloStatusPagExtra = 'label label-default';
							}
							echo '<strong><span class="'.$estiloStatusPagExtra.'">'.$status_pagamento.'</span></strong>';
							?>
						</div>
						<div style="display:inline-block;">
						    <b>Status Entrega:</b>&nbsp;&nbsp;
						    <?php 
							if ($status_entrega == 'Preparando') {
								$estiloStatusPagExtraEntrega = 'label label-default';
							} elseif ($status_entrega == 'Em percuso') {
								$estiloStatusPagExtraEntrega = 'label label-primary';
							} elseif ($status_entrega == 'Entregue') {
								$estiloStatusPagExtraEntrega = 'label label-success';
							} else {
								$estiloStatusPagExtraEntrega = 'label label-default';
							}
							echo '<strong><span class="'.$estiloStatusPagExtraEntrega.'">'.$status_entrega.'</span></strong>';
							?>
						</div>

					</div>
        		</div>

        		<div class="col-md-6">        			
					<div class="card card-body" style="padding:20px;background:#fff;">

						<div style="display:inline-block;">
						    <b>Nome Destinatário:</b>&nbsp;&nbsp;
						    <?php echo $nome_destinatario; ?>
						</div>

						<div style="display:inline-block;">
						    <b>Telefone:</b>&nbsp;&nbsp;
						    <?php echo $telefone; ?>
						</div>

						<div style="display:inline-block;">
						    <b>Endereço de Entrega:</b>&nbsp;&nbsp;
						    <?php echo $end; ?>
						</div>

						<div style="display:inline-block;">
						    <b>Número:</b>&nbsp;&nbsp;
						    <?php echo $numero; ?>
						</div>

						<div style="display:inline-block;">
						    <b>Complemento:</b>&nbsp;&nbsp;
						    <?php echo $complemento; ?>
						</div>

						<div style="display:inline-block;">
						    <b>Estado:</b>&nbsp;&nbsp;
						    <?php echo $estado; ?>
						</div>

						<div style="display:inline-block;">
						    <b>Cidade:</b>&nbsp;&nbsp;
						    <?php echo $cidade; ?>
						</div>

						<div style="display:inline-block;">
						    <b>CEP:</b>&nbsp;&nbsp;
						    <?php echo $cep; ?>
						</div>

					</div>
        		</div>
        		
        	</div>

			<p><b style="font-size:15px;">Produtos:</b></p>

		    <div class="row">
			    <div class="col-md-9" style="padding-right:0px;">
				    <?php
				    $id_nome_produto = substr($id_produto, 0, -1); // exclui o último caractere
					$itemProduto    = explode(",", $id_nome_produto);
					$descricaodoproduto = "";
					foreach ($itemProduto as $produto) {
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

						echo "<b>ID:</b> $produto  <b>Produto: </b><b>$titulo</b><br><hr style='border-top: 1px solid #ccc;'>";
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

	    <hr class="my-4">

        <?php
 	}

} else {
  $msge="Nenhum resultado encontrado...";
  MsgErro($msge);
}
?>