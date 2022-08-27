<div class="row">
	<div class="col-md-12">
		<div class="well muted">
			<h3 class="text-success">Clientes Que Mais Compraram no Site</h3>
			<hr>
			<p>Abra um chamado no departamento de Atualizações da Nova Systems para saber como adiquerir este recurso.</p>
			<?php
			// Selecione os clientes com mais compras
			$resultxx = $pdo->query("SELECT count(id_nome_cliente)Qtde_Registros, id_nome_cliente from controle group by id_nome_cliente order by Qtde_Registros DESC LIMIT 100");
			while ($mostrar22x = $resultxx->fetch(PDO::FETCH_ASSOC)) {

				$id_cliente=$mostrar22x['id_nome_cliente'];
				$Qtde_Registros=$mostrar22x['Qtde_Registros'];
				// Selecione o cliente
				$resultx = $pdo->query("SELECT * FROM clientes WHERE id='$id_cliente'");
				while ($mostrar22 = $resultx->fetch(PDO::FETCH_ASSOC)) {

					$id_cliente=$mostrar22['id'];
					$nome=$mostrar22['nome'];
					$nome = ucwords(strtolower($nome));
					$telefone =  $mostrar22['telefone'];
					$telefone =  remover_caracter($telefone); 
					$telefone =  preg_replace("/_/", "", $telefone);
					?>
					<p class="d-none">Compras: <b><?php echo $Qtde_Registros; ?></b> | <?php echo "<a href='minha-conta/?pg=clientes/view.php&id=$id_cliente' data-toggle='tooltip' title='$nome'>$nome</a>"; ?> | <a href='<?php echo "https://api.whatsapp.com/send?phone=55$telefone&text=Oi $nome, tudo bem?"; ?>' target="_Blank" class="linkClientesAdmin"><i class="fab fa-whatsapp"></i> Mandar Mensagem</a></p>
					<hr class="d-none">
					<?php
				}
			}
			?>
		</div>
	</div>
</div>