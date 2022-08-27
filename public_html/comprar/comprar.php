<div class="card card-body pb-0 pt-2">
	<h2 class="text-success "><i class="fas fa-shopping-basket"></i> <span class="preto">Comprar Consulta</span></h2>
</div>
<hr>

<!-- Verifica se o cliente clicou em algum tarólogo antes, se sim mostra o resumo dele. -->
<?php
if ($URLCATEGORIA!="") {
	$sql = $pdo->query("SELECT * FROM clientes WHERE nivel='TAROLOGO' AND alias='$URLCATEGORIA' ");
	$row = $sql->rowCount();
	if ($row > 0) {
		while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) { 
			$nome=$mostrar['nome'];
			$especialidades=$mostrar['especialidade_taro'];
			$logo=$mostrar['logo'];
			$descricaocurta = $mostrar['infos2'];
			$descricaocurta = strip_tags($descricaocurta);
		    $descricaocurta = strip_tags(limita_caracteres($descricaocurta, 300, true));
		}
		?>
		<div class="card">
			<div class="card-body">
				<div style="float:left; margin: 15px 15px 0px 0px;" class="col-md-auto col-md-4">
			    	<img src="tarologos_admin/fotos/<?php echo $logo; ?>"  class="rounded img-fluid" alt="<?php echo $nome;?>" title="<?php echo $nome;?>"/>
				</div>	
				<h2 class="card-title preto">Consulta Com o tarólogo: </h2>
		    	<h3 class="card-title azul"><?php echo $nome; ?></h3>
				<p><?php echo $especialidades; ?></br>
				<?php echo $descricaocurta; ?></p>
			</div>
		</div>
		<hr>
		<?php
	}
}

// Registrando o pedido
if (isset($_GET['pack'])) {
	
	$pacote = $_GET['pack'];
	$ref    = uniqid("", true);
	$verificaDuploRegistro = $pdo->query("SELECT * FROM controle WHERE cod_pagamento='$ref' ");
	$row2 = $verificaDuploRegistro->rowCount();
	$consultamensal  = "nao";
	if ($row2 > 0){
    	// Compra ja registrada
		echo "<script>document.location.href='https://www.epapodetarot.com.br/minha-conta'</script>";

    } else {
    	// Compra não registrada
    	switch($pacote) {
			case "1":
				$demonstrativo = "Consulta Via Chat - 10 Minutos = R$ 15,00";
				$minutos = "10";
				$valor = "15.00";
				$tipo  = "padrao";
				break;
			case "2":
				$demonstrativo = "Consulta Via Chat - 20 Minutos = R$ 30,00";
				$minutos = "20";
				$valor = "30.00";
				$tipo  = "padrao";
				break;
			case "3":
				$demonstrativo = "Consulta Via Chat - 30 Minutos = R$ 45,00";
				$minutos = "30";
				$valor = "45.00";
				$tipo  = "padrao";
				break;
			case "4":
				$demonstrativo = "Consulta Via Chat - 40 Minutos = R$ 60,00";
				$minutos = "40";
				$valor = "60.00";
				$tipo  = "padrao";
				break;
			case "5":
				$demonstrativo = "Consulta Via Chat - 80 Minutos = R$ 120,00";
				$minutos = "80";
				$valor = "120.00";
				$tipo  = "padrao";
				break;
			case "6":
				$demonstrativo = "Consulta Via Chat - 150 Minutos = R$ 225,00";
				$minutos = "150";
				$valor = "225.00";
				$tipo  = "padrao";
				break;
			case "7":
				$demonstrativo = "Consulta Via Whatsapp - 42 Minutos = R$ 70,00";
				$minutos = "42";
				$valor = "70.00";
				$tipo  = "whatsapp";
				break;
			case "8":
				$demonstrativo = "Consulta Via Whatsapp - 60 Minutos = R$ 100,00";
				$minutos = "60";
				$valor = "100.00";
				$tipo  = "whatsapp";
				break;
			case "9":
				$demonstrativo = "Consulta Via E-mail - Tirar Dúvida - R$ 19,90 - Faça uma pergunta simples e objetiva com até 350 caracteres - Resposta: Até 1.000 caracteres - Prazo: em um dia útil.";
				$minutos = "0";
				$valor = "19.90";
				$tipo  = "email";
				break;
			case "10":
				$demonstrativo = "Consulta Via E-mail - Consulta Completa - R$ 69,90 - Faça um questionamento completo com até 4.000 caracteres - Resposta: Analise Aprofundada com até 8.000 caracteres - Prazo: em até 3 dias úteis";
				$minutos = "0";
				$valor = "69.90";
				$tipo  = "email";
				break;
			case "11":
				$demonstrativo = "Consulta Via Chat - 100 Minutos = R$ 150,00";
				$minutos = "100";
				$valor = "150.00";
				$tipo  = "padrao";
				$consultamensal  = "sim";
				break;
			case "12":
				$demonstrativo = "Consulta Via Chat - 200 Minutos = R$ 300,00";
				$minutos = "200";
				$valor = "300.00";
				$tipo  = "padrao";
				$consultamensal  = "sim";
				break;
			case "13":
				$demonstrativo = "Consulta Via Chat - 300 Minutos = R$ 450,00";
				$minutos = "300";
				$valor = "450.00";
				$tipo  = "padrao";
				$consultamensal  = "sim";
				break;
			case "14":
				$demonstrativo = "Consulta Via Chat - 400 Minutos = R$ 600,00";
				$minutos = "400";
				$valor = "600.00";
				$tipo  = "padrao";
				$consultamensal  = "sim";
				break;
			case "50":
				$demonstrativo = "Consulta Via Chat - 1 Minuto = R$ 00,01";
				$minutos = "1";
				$valor = "00.01";
				$tipo  = "padrao";
				break;
		}

        if ($consultamensal == "sim") {

			$vencimento     = date('d-m-Y', strtotime("+1 days"));
			$dia_venc_orig  = Data_Mostra_Dia ($vencimento);
        	
        	for ($i = 0; $i < 12; $i++) {

			    $ref            = uniqid("", true);
			    $cod            = Codificador::Codifica("$usuario_id, $ref");
			    $url            = 'https://www.epapodetarot.com.br/pagamentos/pagar.php?cod='.$cod;

			    if($i > 0) {
			      // Adiciona mais 1 mês na data de vencimento conforme a quantidade de parcelas do loop
			      $vencimento = date("d-m-Y", strtotime("+1 month",strtotime($dia_venc_orig.'-'.$mes_vencimento.'-'.$ano_vencimento)));
			      // Transforma vencimento em dia util caso necessário
			      $vencimento = proximoDiaUtil($vencimento, $saida = 'd-m-Y');
			      // Atualiza URL's
			      $cod        = Codificador::Codifica("$usuario_id, $ref");
			      $url        = 'https://www.epapodetarot.com.br/pagamentos/pagar.php?cod='.$cod;
			    }

			    //dia, mes e ano de vencimento novo separados
			    $dia_vencimento = Data_Mostra_Dia ($vencimento);
			    $mes_vencimento = Data_Mostra_Mes ($vencimento);
			    $ano_vencimento = Data_Mostra_Ano ($vencimento);

			    $pdo->query( "INSERT INTO controle (
			      id_nome_cliente,
			      minutos,
			      minutos_dispo,
			      valor,
			      cod_pagamento,
			      status,
			      data,
			      vencimento,
			      metodo,
			      tipo,
			      demonstrativo,
			      url
			    ) VALUES (
			      '$usuario_id',
			      '$minutos',
			      '$minutos',
			      '$valor',
			      '$ref', 
			      'Aguardando', 
			      '$data_hoje',
			      '$ano_vencimento-$mes_vencimento-$dia_vencimento', 
			      '',
			      '$tipo',
			      '$demonstrativo',
			      '$url'
			    )");
			}

			###################### EMAIL ##############################
			$memaildestinatario = $email_usuario;
			$mnomedestinatario  = $nome_usuario;
			$massunto           = "Nova Cobrança Gerada É Papo de Tarot";
			$mmensagem          = "
				<p>Olá <b>$nome_usuario</b>, </p>
				<p>O seu pedido foi realizado com sucesso.</p>
				<strong>Demonstrativo:</strong> $demonstrativo <br/>
				<p>Conclua seu pagamento para realizar sua consulta.</p>
				<p>Para mais detalhes acesse sua conta em:</p>
				<p><b>Minha Conta:</b></p>
				<p><a href='https://www.epapodetarot.com.br/minha-conta/'>https://www.epapodetarot.com.br/minha-conta</a></p>
				<br/>
				<br/>
				<b>É Papo de Tarot</b> <br/>
				Departamento Financeiro <br/>
				epapodetarot@gmail.com <br/>
				Site: www.epapodetarot.com.br <br/>
			";
			EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
			###################### EMAIL ##############################

			// Selecionando a primeira parcela
			$sql = $pdo->query("SELECT * FROM controle WHERE demonstrativo='$demonstrativo' AND id_nome_cliente='$usuario_id' ORDER by id DESC");
			while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
      			$url=$mostrar['url'];
      		}

			echo "<script>document.location.href='$url'</script>";

        } else {

        	$vencimento     = date('d-m-Y', strtotime("+1 days"));
			$cod            = Codificador::Codifica("$usuario_id, $ref");
			$url            = 'https://www.epapodetarot.com.br/pagamentos/pagar.php?cod='.$cod;

			// Transforma vencimento em dia util caso necessário
			$vencimento = proximoDiaUtil($vencimento, $saida = 'Y-m-d');

			$q = $pdo->query("INSERT INTO controle (
	            id_nome_cliente,
	            minutos,
	            minutos_dispo,
	            valor,
	            cod_pagamento,
	            status,
	            data,
	            metodo,
	            tipo,
	            vencimento,
	            url,
	            demonstrativo
	        ) VALUES (
	            '$usuario_id',
	            '$minutos',
	            '$minutos',
	            '$valor',
	            '$ref', 
	            'Aguardando', 
	            '$data_hoje',
	            '',
	            '$tipo',
	            '$vencimento',
	            '$url',
				'$demonstrativo'
	        )");

	        ###################### EMAIL ##############################
			$memaildestinatario = $email_usuario;
			$mnomedestinatario  = $nome_usuario;
			$massunto           = "Nova Cobrança Gerada É Papo de Tarot";
			$mmensagem          = "
				<p>Olá <b>$nome_usuario</b>, </p>
				<p>Estes são os dados para realizar sua consulta.</p>
				<strong>Demonstrativo:</strong> $demonstrativo <br/>
				<strong>Valor:</strong> $valor <br/>
				<strong>Código:</strong> $ref <br/>
				<strong>Data Vencimento:</strong> $vencimento <br/>
				<strong>Link para pagamento:</strong> <a href=".$url.">$url</a> <br/>
				<p>Caso não seja possível clicar no link da cobrança acima, tente copiar todo o endereço e colar na barra de navegação do seu navegador de internet.</p>
				<p>Conclua seu pagamento para realizar sua consulta.</p>
				<p>Para mais detalhes acesse sua conta em:</p>
				<p><b>Minha Conta:</b></p>
				<p><a href='https://www.epapodetarot.com.br/minha-conta/'>https://www.epapodetarot.com.br/minha-conta</a></p>
				<br/>
				<br/>
				<b>É Papo de Tarot</b> <br/>
				Departamento Financeiro <br/>
				epapodetarot@gmail.com <br/>
				Site: www.epapodetarot.com.br <br/>
			";
			EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
			###################### EMAIL ##############################
        }
		
		echo "<script>document.location.href='https://www.epapodetarot.com.br/pagamentos/pagar.php?cod=$cod'</script>";
    }
}
?>

<h3 class="text-white"><span class="badge badge-pill badge-dark"> 1 </span> <span class="preto">Primeiro Passo:</span></h3>
<hr>

<div class="alert alert-primary mt-2" role="alert">
  <b><i class="fas fa-mouse-pointer"></i> Como deseja fazer sua consulta?</b>
</div>

<h3><span id="escolhaumaopcao">Escolha uma opção:</span></h3>

<form action="" id="FormComprarConsulta" nome="FormComprarConsulta" class="needs-validation" novalidate>
	
	<ul class="nav nav-tabs flex-column flex-sm-row shadow" id="myTab" role="tablist">
	  <li class="nav-item" role="presentation">
	    <a class="flex-sm-fill text-sm-center nav-link <?php if ($URLCATEGORIA=='chat'){echo 'active';}elseif($URLCATEGORIA==''){echo 'active';}elseif($URLSUBCATEGORIA!=''){echo 'active';} ?>" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="true">Consultas Via: Chat <i class="fas fa-comments"></i> ou VideoChamada <i class="fas fa-video"></i></a>
	  </li>
	  <li class="nav-item d-none" role="presentation">
	    <a class="flex-sm-fill text-sm-center nav-link <?php if ($URLCATEGORIA=='chatmensal'){echo 'active';}?>" id="chatmensal-tab" data-toggle="tab" href="#chatmensal" role="tab" aria-controls="chatmensal" aria-selected="false">Por <i class="fas fa-comments"></i> Chat Mensal</a>
	  </li>
	  <li class="nav-item d-none" role="presentation">
	    <a class="flex-sm-fill text-sm-center nav-link <?php if ($URLCATEGORIA=='whatsapp'){ echo 'active';}?>" id="whatsapp-tab" data-toggle="tab" href="#whatsapp" role="tab" aria-controls="whatsapp" aria-selected="false">Por <i class="fab fa-whatsapp"></i> WhatsApp</a>
	  </li>
	  <li class="nav-item d-none" role="presentation">
	    <a class="flex-sm-fill text-sm-center nav-link <?php if ($URLCATEGORIA=='email'){ echo 'active';}?>" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">Por <i class="fas fa-envelope"></i> E-mail</a>
	  </li>
	  <li class="nav-item d-none" role="presentation">
	    <a class="flex-sm-fill text-sm-center nav-link <?php if ($URLCATEGORIA=='telefone'){ echo 'active';}?>" id="telefone-tab" data-toggle="tab" href="#telefone" role="tab" aria-controls="telefone" aria-selected="false">Por <i class="fas fa-phone-alt"></i> Telefone</a>
	  </li>
	  <li class="nav-item d-none" role="presentation">
	    <a class="flex-sm-fill text-sm-center nav-link <?php if ($URLCATEGORIA=='video'){ echo 'active';}?>" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">Por <i class="fas fa-video"></i> Vídeo</a>
	  </li>
	</ul>
	<div class="card tab-content p-3 mb-4 shadow" id="myTabContent" style="border:none;">
		<div class="tab-pane fade show <?php if ($URLCATEGORIA=='chat'){echo 'active';}elseif($URLCATEGORIA==''){echo 'active';}elseif($URLSUBCATEGORIA!=''){echo 'active';} ?>" id="chat" role="tabpanel" aria-labelledby="chat-tab">
			<ul>
				<li>Valor da Consulta: apenas R$ 1,50 o Minuto!</li>
				<li>Consulta AO VIVO!</li>
				<li>Faça sua consulta via <i class="fas fa-comments"></i> Chat - Texto ao vivo.</li>
				<li>Faça sua consulta via <i class="fas fa-video"></i> Vídeo Chamada - Com audio e video ao vivo.</li>
				<li>Clique no seu tarólogo para saber qual tipo de consulta esta disponível.</li>
			</ul>
	  		<p><b class="text-success">Escolha o tempo:</b></p>
	  		<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value="1">
			  <label class="custom-control-label" for="customRadio1" id="focuCompra"><i class="fas fa-clock"></i> 10 Minutos = R$ 15,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value="2">
			  <label class="custom-control-label" for="customRadio2" id="focuCompra2"><i class="fas fa-clock"></i> 20 Minutos = R$ 30,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input" value="3">
			  <label class="custom-control-label" for="customRadio3" id="focuCompra3"><i class="fas fa-clock"></i> 30 Minutos = R$ 45,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input" value="4">
			  <label class="custom-control-label" for="customRadio4" id="focuCompra4"><i class="fas fa-clock"></i> 40 Minutos = R$ 60,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio5" name="customRadio" class="custom-control-input" value="5">
			  <label class="custom-control-label" for="customRadio5" id="focuCompra5"><i class="fas fa-clock"></i> 80 Minutos = R$ 120,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio6" name="customRadio" class="custom-control-input" value="6">
			  <label class="custom-control-label" for="customRadio6" id="focuCompra6"><i class="fas fa-clock"></i> 150 Minutos = R$ 225,00</label>
			</div>
			<?php
			if ($usuario_nivel=="ADMIN") {
				?>
				<div class="custom-control custom-radio">
					<input type="radio" id="customRadio50" name="customRadio" class="custom-control-input" value="50">
					<label class="custom-control-label" for="customRadio50" id="focuCompra50"><i class="fas fa-clock"></i> 1 Minuto = R$ 00,01</label>
				</div>
				<?php
			}
			?>
		</div>
		<div class="tab-pane fade show <?php if ($URLCATEGORIA=='chatmensal'){echo 'active';}?>" id="chatmensal" role="tabpanel" aria-labelledby="chatmensal-tab">
	  		<p>Valor da Consulta via Chat: R$ 1,50 o Minuto.</br>
	  		Agora você pode fazer consultas mensalmente no site de forma muito mais fácil, adquira <b>Pacotes Mensais</b> baixo.</p>
	  		<p><b class="text-success">Escolha o pacote mensal de atendimento:</b></p>
	  		<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio1mensal" name="customRadio" class="custom-control-input" value="11">
			  <label class="custom-control-label" for="customRadio1mensal" id="focuCompramensal"><i class="fas fa-clock"></i> 100 Minutos = R$ 150,00 / Mensal</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio2mensal" name="customRadio" class="custom-control-input" value="12">
			  <label class="custom-control-label" for="customRadio2mensal" id="focuCompra2mensal"><i class="fas fa-clock"></i> 200 Minutos = R$ 300,00 / Mensal</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio3mensal" name="customRadio" class="custom-control-input" value="13">
			  <label class="custom-control-label" for="customRadio3mensal" id="focuCompra3mensal"><i class="fas fa-clock"></i> 300 Minutos = R$ 450,00 / Mensal</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio4mensal" name="customRadio" class="custom-control-input" value="14">
			  <label class="custom-control-label" for="customRadio4mensal" id="focuCompra4mensal"><i class="fas fa-clock"></i> 400 Minutos = R$ 600,00 / Mensal</label>
			</div>
		</div>
		<div class="tab-pane fade show " id="whatsapp" role="tabpanel" aria-labelledby="whatsapp-tab">
			<p>Valor da Consulta via WhatsApp: R$ 2,00 o Minuto.</br>
	  		Consulta via WhatsApp, maior comodidade na sua consulta. Retorno e acompanhamento da consulta será realizado pela consultora Deusa Anuket, com horário agendado.</p>
	  		<p><b>Escolha o tempo:</b></p>
	  		<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio5" name="customRadio" class="custom-control-input" value="5">
			  <label class="custom-control-label" for="customRadio5"><i class="fas fa-clock"></i> 13 Minutos = R$ 20,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio6" name="customRadio" class="custom-control-input" value="6">
			  <label class="custom-control-label" for="customRadio6"><i class="fas fa-clock"></i> 25 Minutos = R$ 40,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio7" name="customRadio" class="custom-control-input" value="7">
			  <label class="custom-control-label" for="customRadio7"><i class="fas fa-clock"></i> 42 Minutos = R$ 70,00</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio8" name="customRadio" class="custom-control-input" value="8">
			  <label class="custom-control-label" for="customRadio8"><i class="fas fa-clock"></i> 60 Minutos = R$ 100,00</label>
			</div>
		</div>
		<div class="tab-pane fade show" id="email" role="tabpanel" aria-labelledby="email-tab">
	  		<p>Consulta via E-mail, tenha a tranquilidade para pensar melhor na sua pergunta, sem a pressão do tempo presente nas consultas via Chat e Whatsapp. Retorno e acompanhamento da consulta será realizado pela consultora Deusa Anuket</p>
	  		<p><b>Escolha uma opção:</b></p>
	  		<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio9" name="customRadio" class="custom-control-input" value="9">
			  <label class="custom-control-label" for="customRadio9"><i class="fas fa-sticky-note"></i> Tirar Dúvida - R$ 19,90 - Faça uma pergunta simples e objetiva com até 350 caracteres - Resposta: Até 1.000 caracteres - Prazo: em um dia útil.</label>
			</div>
			<div class="custom-control custom-radio">
			  <input type="radio" id="customRadio10" name="customRadio" class="custom-control-input" value="10">
			  <label class="custom-control-label" for="customRadio10"><i class="fas fa-scroll"></i> Consulta Completa - R$ 69,90 - Faça um questionamento completo com até 4.000 caracteres - Resposta: Analise Aprofundada com até 8.000 caracteres - Prazo: em até 3 dias úteis</label>
			</div>
		</div>
		<div class="tab-pane fade show" id="telefone" role="tabpanel" aria-labelledby="telefone-tab">
			<p>Em breve... <i class="fas fa-sad-cry"></i></p>
		</div>
		<div class="tab-pane fade show" id="video" role="tabpanel" aria-labelledby="video-tab">
			<p>Em breve... <i class="fas fa-sad-cry"></i></p>
		</div>
	</div>

</form>

<hr>
<h3 class="text-white"><span class="badge badge-pill badge-dark"> 2 </span> <span class="preto">Segundo Passo:</span></h3>
<hr>

<?php
if($row_onlinex=="offline" OR $row_onlinex=="") {
	?>
	<div class="alert alert-primary mt-2" role="alert">
	  <b><i class="fas fa-mouse-pointer"></i> Identificação</b> - Faça Login ou Cadastre-se caso seja novo no site.
	</div>
	<?php
	include "login/login_site.php";
	?>
	<div class="row py-4">
	    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 offset-xl-4 offset-lg-4">
	    	<center>
	    		<p><i class="fas fa-arrow-up"></i><i class="fas fa-arrow-up"></i><i class="fas fa-arrow-up"></i></p>
	        	<h2 class="text-danger"><i class="fas fa-exclamation-triangle"></i> <b>Entre</b> ou <b>Cadastre-se</b>, acima antes de continuar...</h2>
		        <button disabled="" type="button" class="btn btn-lg btn-success btn-block text-white shadow"><i class="fas fa-check-circle"></i> CONSULTAR</button>
		        <div class="text-center mt-3">
				  <div class="spinner-border" role="status" aria-hidden="true"></div>
				</div>
	        </center>
	    </div>
	</div>
	<br>
	<?php
} else  {
	?>
	<div class="alert alert-primary mt-2" role="alert">
	  <b><i class="fas fa-money-check"></i> Pagamento</b> - Clique no botão verde abaixo.
	</div>
	<p><b><?php echo $usuario_nome; ?></b>, ao clicar no botão verde CONSULTAR abaixo, você será levada(o) a página de pagamento da consulta. Disponibilizamos várias formas de pagamento como, <b>Pix, Cartão de Crédito, Boleto, PagSeguro, PayPal</b>. Você pode escolher qualquer uma delas.</p>
	<p>Após o pagamento você será levada(o) para a página de inicio da consulta com o tarólogo!</p>
	<div class="row py-4">
	    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 offset-xl-4 offset-lg-4">
	        <center>
	        	<p><?php echo $usuario_nome; ?>, clique no botão abaixo:</p>
	        	<button onclick='confirmacao();' type="button" class="btn btn-lg btn-success btn-block text-white shadow" name="confirmarcompraconsulta" id="confirmarcompraconsulta"><i class="fas fa-check-circle"></i> PAGAR E CONSULTAR</button>
	    		<p><i class="fas fa-angle-up"></i></br>
			    <figure class="figure">
			      	<!-- <a href="tarologo/Deusa-Anuket"><img class="rounded img-fluid" title="Tarologa Patricia" src="../tarologos_admin/fotoreal/patty2.jpg" alt="Tarologa Patricia"></a> -->
			      	<figcaption class="figure-caption mt-2">
			      	</figcaption>
			    </figure>
	        </center>
	    </div>
	</div>
	<?php
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	function confirmacao(){
        var pacote = document.forms['FormComprarConsulta'].elements['customRadio'].value;
		var errosform = 0;
		if (pacote==""){
            errosform++;
            alert("Selecione o Tempo da Consulta.");
            $('#escolhaumaopcao').addClass('text-danger');
            $('#customRadio1').focus();
            $('#focuCompra').addClass('text-danger');
            $('#focuCompra2').addClass('text-danger');
            $('#focuCompra3').addClass('text-danger');
            $('#focuCompra4').addClass('text-danger');
            $('#focuCompra5').addClass('text-danger');
            $('#focuCompra6').addClass('text-danger');
        } else {
        	var errosform = 0;
        }
        if (errosform == 0){
        	document.location.href='comprar-consulta/?pack='+pacote;
        }
    }
</script>