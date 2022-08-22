<div id="geral" class="col-md-12" style="margin-bottom: 15px;">	
	<center>
		<h1 style="margin-top:0px;padding-top:15px;color: #0e0c0c;text-shadow: 0px 2px 4px #da8345;"><i class="fab fa-gratipay"></i> Escolha um Cartomante:</h1>
		<p>Escolha um TARÓLOGO e faça todas as perguntas com total sigilo e privacidade, nossa plataforma é de total segurança, fique tranquilo para perguntar sobre Amor, Trabalho, Saúde e tudo o mais que aflige o seu coração.</p>
	</center>

	<hr style="border-top: 1px solid #000;">

	<style type="text/css">
		#tarologoshomeresultado .avisemehover {
		  color:#fff;
		  padding: 10px 0px;
		}
		#tarologoshomeresultado .avisemehover:hover {
		  color:#000;
		  padding: 10px 0px;
		}
		#tarologoshomeresultado .perfilhover {
		  color: #0e0c0c;
		  text-shadow: 0px 2px 4px #da8345;
		  padding: 10px 0px;
		}
		#tarologoshomeresultado .perfilhover:hover {
		  color: #8a2b29;
		  text-shadow: 0px 2px 4px #da8345;
		  padding: 10px 0px;
		}
		#tarologoshomeresultado .consultar {
		  color:#000;
		  padding: 10px 0px;
		}
		#tarologoshomeresultado .consultar:hover {
		  color:#fff;
		  padding: 10px 0px;
		}
	</style>
	<?php
	$result = $pdo->query("SELECT * FROM clientes WHERE nivel = 'TAROLOGO' AND status='ATIVO' ORDER BY nome ASC");
	while ($mostrar2 = $result->fetch(PDO::FETCH_ASSOC)) {
		$id_tarologo2=$mostrar2['id'];
		$nome2=$mostrar2['nome'];
		$alias=$mostrar2['alias'];
		$especialidades2=$mostrar2['especialidade_taro'];
		$infos2=$mostrar2['infos'];
		$infos22=$mostrar2['infos2'];
		$logo2=$mostrar2['logo'];
		?>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right: 5px;">
				<img src="../tarologos_admin/fotos/<?php echo $logo2;?>" alt="<?php echo $nome2; ?>" style="max-width:100%;border:none;background-size:cover;background-position:50% 50%;" class="img-rounded efeito">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding: 0;">
				<div style="background: transparent;border: none;font-size:30px;color: #0e0c0c;font-weight: 800;text-shadow: 0px 2px 4px #da8345;"><i class="fas fa-ankh"></i> <?php echo $nome2; ?></div>
				<div style="margin-top:10px;margin-bottom:10px;font-size:20px;color:#000000;">
			        <p><b>Oráculos: </b><?php echo $especialidades2;?></p>
			    </div>
			</div>
		</div>

	    <div style="margin-top:10px;margin-bottom:10px;font-size:20px;color:#000000;">
	        <?php echo $infos22;?>
	    </div>
	          
		<div style="margin-bottom:15px;">
			<center>
				<a class="btn btn-lg btn-success btn-block" href="index.php?pg=page3.php&tarologo=<?php echo $alias; ?>" style="background: #aef124;color:#000;border: none;font-weight: bold;font-size:25px;width: 100%;"><i class="fas fa-arrow-circle-right"></i> Escolher <?php echo $nome2; ?></a>
			</center>
		</div>

		<hr style="border-top: 1px solid #000; clear: both;">

		<!-- </div> -->
	<?php
	}
	?>

</div>

<div id="depoimentos">
	<button class="pointer btn-group-sm btn-default" data-toggle="modal" data-target="#VerDepoimentos" title='Depoimentos'><i class="fas fa-eye"></i> Ver Depoimentos</button>
</div>


<!-- VerDepoimentos -->
<div class="modal fade" id="VerDepoimentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h1 class="modal-title" id="myModalLabel">Depoimentos</h1>
			</div>
			<div class="modal-body">
				<?php
				//Estanciando dados dos depoimentos
				$executa = $pdo->query("SELECT * FROM depoimentos WHERE habilitado='SIM' ORDER BY id DESC");
				$encontrados = $executa->rowCount();
				while ($dadoss= $executa->fetch(PDO::FETCH_ASSOC))
				{
					$id_tarologo=$dadoss['id_tarologo'];
					$id_cliente=$dadoss['id_cliente'];
					$mensagem=$dadoss['mensagem'];
					$mensagem = strip_tags($mensagem);
					$mensagem = ucfirst(strtolower($mensagem));
					$pontuacao=$dadoss['pontuacao'];
					$data  = $dadoss['data'];
					$data  = date("d-m-Y", strtotime("$data"));

					//Estancia dados do Tarólogo
					$executa3 = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo'");
					while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC))
					{
					  $tarologo_nome=$dadoss3['nome'];
					}
					$row = $executa3->rowCount();
					if ($row == 0) { $tarologo_nome=""; }

					//Estancia dados do cliente
					$executa33 = $pdo->query("SELECT * FROM clientes WHERE id='$id_cliente'");
					while ($dadoss33= $executa33->fetch(PDO::FETCH_ASSOC))
					{
					  $cliente_id=$dadoss33['id'];
					  $cliente_nome=$dadoss33['nome'];
					  $cliente_nome = strip_tags($cliente_nome);
					  $cliente_nome = ucfirst(strtolower($cliente_nome));
					}
					$row = $executa33->rowCount();
					if ($row == 0) { $cliente_nome=""; } 

					?>
					<div class="row well" style="background: rgb(252,255,244, 0.5);">
						<p><em><?php echo $data; ?></em></p>
						<p><i class="fas fa-star"></i> <span style="color:#2196F3;"><?php echo $pontuacao; ?></span></p>
						<span style="font-size: 20px; word-break: break-word;">
							<p><em><?php echo $mensagem; ?></em></p>
						</span>
						<p><span style="color:#656262;">Consulta realizada por:</span> <span style="color:#ff7600;"><b><?php echo $tarologo_nome; ?></b></span></p>
					</div>
					<?php 
				} 
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-md" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- VerDepoimentos -->

<style>
	#depoimentos {
	    position: fixed;
	    bottom: 0px;
	    padding: 5px;
	    z-index: 99999;
	    margin:10px;
	}
</style>