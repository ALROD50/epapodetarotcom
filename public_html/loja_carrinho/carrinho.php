<?php
// Dados do Cliente
$sql_onlinex = $pdo->query("SELECT * FROM clientes WHERE id='$usuario_id' "); 
	while ($mostrarx = $sql_onlinex->fetch(PDO::FETCH_ASSOC)) { 
	$row_onlinex=$mostrarx['online'];
	$endereco=$mostrarx['endereco'];
	$numero=$mostrarx['numero'];
	$complemento=$mostrarx['complemento'];
	$cep=$mostrarx['cep'];
	$bairro=$mostrarx['bairro'];
	$cidade=$mostrarx['cidade'];
	$estado=$mostrarx['estado'];
	$nome=$mostrarx['nome'];
	$data_nascimento=$mostrarx['data_nascimento'];
	$data_nascimento = date("d-m-Y", strtotime("$data_nascimento"));
	$email=$mostrarx['email'];
	$telefone=$mostrarx['telefone'];
	$estado=$mostrarx['estado'];
}
$Mask="SIM";
$borda_vermelha = "bordavermelha";

// Verifica se esta na página de pagamento
if(@$categoriaURL=='FinalizarPagamento'){
	$pagamento=true;
} else {
	$pagamento=false;
}
	
// Excluir Produto
if (isset($_POST['ExcluirProduto'])) {
	$id_produto=$_POST['id_produto'];
	$pdo->query("DELETE FROM loja_carrinho WHERE id_produto='$id_produto' AND id_cliente='$id_cliente_carrinho_session'");
	$msgs = "Produto Removido Com Sucesso do Carrinho!";
	MsgSucesso ($msgs);
}
// Alterar Quantidade do Produto
if (isset($_POST['novoquantidadeselecionada'])) {

	// Variaveis do Novo Produtos, vido do botão comprar
	$IdAlterarQuantidade          = $_POST['IdAlterarQuantidade'];
	$id_produto                   = $IdAlterarQuantidade;
	$novoquantidadeselecionada    = $_POST['novoquantidadeselecionada'][$IdAlterarQuantidade];
	// $preco                        = $_POST['preco'];

	// preço do produto
	$executa66 = $pdo->query("SELECT * FROM loja_produtos WHERE id='$id_produto'");
	while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
		$preco=$dadoss66['preco'];
	}

	$preco = $preco * $novoquantidadeselecionada;

	// Salva no Carrinho
	$query = $pdo->query("UPDATE loja_carrinho SET 
        quantidade='$novoquantidadeselecionada',
        preco='$preco'
    WHERE id_produto='$id_produto' AND id_cliente='$id_cliente_carrinho_session' ");
	$msgs = "Quantidade do produto atualizada no carrinho com sucesso!";
	MsgSucesso ($msgs);
}
// Atualiza Dados de Cadastro
if (isset($_POST['BotUpdateDados'])) {

	$nome = $_POST['nome'];
	$data_nascimento = $_POST['data_nascimento'];
	@$data_nascimento   = date("Y-m-d", strtotime("$data_nascimento"));
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$endereco = $_POST['endereco'];
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$cep = $_POST['cep'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];

	// Salva no Carrinho
	$query = $pdo->query("UPDATE clientes SET 
        nome='$nome',
        data_nascimento='$data_nascimento',
        telefone='$telefone',
        email='$email',
        endereco='$endereco',
        numero='$numero',
        complemento='$complemento',
        cep='$cep',
        bairro='$bairro',
        cidade='$cidade',
        estado='$estado'
    WHERE id='$usuario_id' ");
	$msgs = "Endereço de Entrega Atualizado Com Sucesso!";
	MsgSucesso ($msgs);
}
// Erro - Confirmar Compra
if(isset($_GET['ErroFinalizarCompra'])){
	$msge=$_GET['ErroFinalizarCompra'];
	MsgErro ($msge);
}

// Mostra todos os produtos do carrinho, conforme disponível na sessão.
$sql_produto = $pdo->query("SELECT * FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session' "); 
$row = $sql_produto->rowCount();

// SUBTOTAL
$sqlSUBTOTAL    = $pdo->query("SELECT SUM(preco) as soma FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session'"); 
$contSUBTOTAL   = $sqlSUBTOTAL->fetch(PDO::FETCH_ASSOC);
$valorSUBTOTAL1 = $contSUBTOTAL["soma"];
$valorSUBTOTAL  = number_format($valorSUBTOTAL1, 2, ',', '.');//Formatando para mostrar ao usuario.

if ($row > 0) {

	?>
	<div class="row" style="margin-top:10px;">
		<div class="col-md-6" style="padding:0px;">
			<!-- DADOS PESSOAIS -->
			<div style="border: 1px solid #aaa8a8; margin: 10px 0 10px 5px; padding: 10px;">
				<h3 class="text-white"><span class="badge badge-pill badge-dark"> 1 </span> <span class="preto">DADOS PESSOAIS</span></h3>
				<hr>

				<?php
				// Verifica se o usuário esta logado.
				if(@$row_onlinex=="offline" OR @$row_onlinex==""){

				    //Não esta logado
					?><h4 class="azul">FAÇA LOGIN AQUI!</h4>
					<div class="row">
						<div class="card bg-light mb-3 mt-3 shadow col-md-12">
					        <div class="card-header"><h2 class="mb-0"><i class="fas fa-door-open"></i> Entrar</h2></div>
					        <div class="card-body">
					          <center>
								<h5 class="card-title"><i class="fas fa-handshake"></i> Bem-Vindo De Volta!</h5>
								<p>Que bom te ver novamente!</p>
							  </center>
					          <a button href="<?php echo $loginUrl; ?>" id="xface" class="btn btn-lg btn-primary btn-block bot_cadastro_facebook" type="submit" title="Cadastrar Via Facebook" alt="Cadastrar Via Facebook" name="cadastro_facebook"><i class="fab fa-facebook"></i> Entrar Com Facebook</button></a>
					          <hr>
					          <center><p> Ou </p></center>
					          <form name="FormLogin" id="FormLogin" method="post" action="" class="form-horizontal">
					            <input type="hidden" id="token2" name="token2">
					            <div class="form-group">
					              <label for="usuario">Usuário/Email:</label>
					              <input type="text" class="form-control" placeholder="Usuário ou Email" name="usuario" value="<?php echo $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" required  />
					            </div>
					            <div class="form-group">
					              <label for="senha">Senha:</label>
					              <input type="password" class="form-control" placeholder="******" name="senha" value="<?php echo $senha = isset($_POST['senha']) ? $_POST['senha'] : ''; ?>" required />
					            </div>
					            <div class="form-group">
					              <button class="btn btn-lg btn-success btn-block text-white" type="submit" name="loginsite" id="loginsite"><i class="fas fa-sign-in-alt"></i> ENTRAR</button>
					              <center><p><small><i class="fas fa-search"></i> <a href="lembrar-senha">Lembrar Minha Senha.</a></small></p></center>
					            </div>

					          </form>
					        </div>
					    </div>

					    <div class="card bg-light mb-3 mt-3 shadow col-md-12">
					        <div class="card-header"><h2 class="mb-0 titlecriarnovaconta">Criar Nova Conta</h2></div>
					        <div class="card-body">
					          <center>
					            <h5 class="card-title">Faça seu registro abaixo:</h5>
					          </center>
					          <form name="CadastroForm" id="CadastroForm" method="post" action="" class="form-horizontal" autocomplete="off">
					            <input type="hidden" id="token" name="token">
					            <div class="form-group">
					              <input type="text" class="form-control"  name="nome" value="<?php echo $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" placeholder="Seu Nome Completo" required />
					            </div>
					            <div class="form-group">
					              <input type="tel" class="form-control"  name="data_nascimento" data-mask="00-00-0000" placeholder="Data de nascimento" value="<?php echo $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : ''; ?>" required />
					            </div>
					            <div class="form-group">
					              <input type="tel" class="form-control cel_with_ddd"  name="whatsapp" value="<?php echo $whatsapp = isset($_POST['whatsapp']) ? $_POST['whatsapp'] : ''; ?>" placeholder="Celular" required />
					            </div>
					            <div class="form-group">
					              <input type="text" class="form-control"  name="email" value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Use Seu Melhor Email" required autocomplete="off"/>
					            </div>
					            <div class="form-group">
					              <input type="password" class="form-control"  name="senha" value="<?php echo $senha = isset($_POST['senha']) ? $_POST['senha'] : ''; ?>" placeholder="Crie uma senha fácil de lembrar" required autocomplete="off"/>
					            </div>
					            <div class="form-group">
					              <button class="btn btn-lg btn-success btn-block text-white" type="submit" name="enviacadastrar" id="enviacadastrar"><i class="fas fa-house-user"></i> CADASTRAR</button>
					              <center><p><small><i class="fas fa-hands-helping"></i> Eu li e aceito os <a href="https://www.epapodetarot.com.br/politica-de-privacidade-e-termos-de-uso" target="_blank">Termos de Uso.</a></small></p></center>
					            </div>
					          </form>
					        </div>
					    </div>
					</div>
					<script src="https://www.google.com/recaptcha/api.js?render=6LfIKpwhAAAAALRzObk_GNN_kB60S8px5S9XZgkw"></script>
					<script>
					  grecaptcha.ready(function() {
					    grecaptcha.execute('6LfIKpwhAAAAALRzObk_GNN_kB60S8px5S9XZgkw', {action: 'homepage'}).then(function(token) {
					      // console.log(token);
					      document.getElementById("token").value = token;
					   });
					  });
					</script>
					<script>
					  grecaptcha.ready(function() {
					    grecaptcha.execute('6LfIKpwhAAAAALRzObk_GNN_kB60S8px5S9XZgkw', {action: 'homepage'}).then(function(token) {
					      // console.log(token);
					      document.getElementById("token2").value = token;
					   });
					  });
					</script>
					<?php
				} else {

					?><h4 class="azul">ENDEREÇO DE ENTREGA</h4><?php

				    //Esta logado.
				    ?>
				    <div class="row" id="FormAtualizaDadosDiv" style="display: none;">
				    	<p><b><?php echo $nome; ?></b>, atualize o endereço de entrega no formulário abaixo:</p>

				    	<div class="col-md-12">
						    
						    <form name="FormUpdateDados" method="post" action="" class="form-horizontal">

						        <div class="form-group">
						            <label for="">Nome Completo:</label>
						            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $nome = isset($_POST['$nome']) ? $_POST['$nome'] : $nome; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Data Nascimento:</label>
						            <input type="text" name="data_nascimento" id="data_nascimento" class="form-control dataNascimento"  value="<?php echo $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : $data_nascimento; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">E-mail:</label>
						            <input type="text" name="email" id="email" class="form-control"  value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : $email; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Telefone Celular:</label>
						            <input type="text" name="telefone" id="telefone" class="form-control cel_with_ddd"  value="<?php echo $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : $telefone; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Endereco:</label>
						            <input type="text" name="endereco" id="endereco" class="form-control"  value="<?php echo $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : $endereco; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Numero:</label>
						            <input type="text" name="numero" id="numero" class="form-control"  value="<?php echo $numero = isset($_POST['numero']) ? $_POST['numero'] : $numero; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Complemento:</label>
						            <input type="text" name="complemento" id="complemento" class="form-control"  value="<?php echo $complemento = isset($_POST['complemento']) ? $_POST['complemento'] : $complemento; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">CEP:</label>
						            <input type="text" name="cep" id="cep" class="form-control cep <?php if(empty($cep)){echo $borda_vermelha;} ?>"  value="<?php echo $cep = isset($_POST['cep']) ? $_POST['cep'] : $cep; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Bairro:</label>
						            <input type="text" name="bairro" id="bairro" class="form-control"  value="<?php echo $bairro = isset($_POST['bairro']) ? $_POST['bairro'] : $bairro; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Cidade:</label>
						            <input type="text" name="cidade" id="cidade" class="form-control"  value="<?php echo $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : $cidade; ?>" required >
						        </div>

						        <div class="form-group">
						            <label for="">Estado:</label>
						            <select name="estado" id="estado" class="form-control">
	                                    <option value="<?php echo $estado = isset($_POST['estado']) ? $_POST['estado'] : $estado; ?>"><?php echo $estado = isset($_POST['estado']) ? $_POST['estado'] : $estado; ?></option> 
	                                    <option value="AC">Acre</option> 
	                                    <option value="AL">Alagoas</option> 
	                                    <option value="AM">Amazonas</option> 
	                                    <option value="AP">Amapá</option> 
	                                    <option value="BA">Bahia</option> 
	                                    <option value="CE">Ceará</option> 
	                                    <option value="DF">Distrito Federal</option> 
	                                    <option value="ES">Espírito Santo</option> 
	                                    <option value="GO">Goiás</option> 
	                                    <option value="MA">Maranhão</option> 
	                                    <option value="MT">Mato Grosso</option> 
	                                    <option value="MS">Mato Grosso do Sul</option> 
	                                    <option value="MG">Minas Gerais</option> 
	                                    <option value="PA">Pará</option> 
	                                    <option value="PB">Paraíba</option> 
	                                    <option value="PR">Paraná</option> 
	                                    <option value="PE">Pernambuco</option> 
	                                    <option value="PI">Piauí</option> 
	                                    <option value="RJ">Rio de Janeiro</option> 
	                                    <option value="RN">Rio Grande do Norte</option> 
	                                    <option value="RO">Rondônia</option> 
	                                    <option value="RS">Rio Grande do Sul</option> 
	                                    <option value="RR">Roraima</option> 
	                                    <option value="SC">Santa Catarina</option> 
	                                    <option value="SE">Sergipe</option> 
	                                    <option value="SP">São Paulo</option> 
	                                    <option value="TO">Tocantins</option>
	                                </select>
						        </div>

						    	<div class="form-group">
						    		<input class="btn btn-primary" type="submit" name="BotUpdateDados" value="Atualizar Meu Endereço"/>
								</div>
							</form>
								
							<button onclick="MostraDadosEntrega();" class="btn btn-info">Cancelar</button>
						</div>
						
				    </div>

				    <div class="row" id="FormMostraDadosDiv">
			    		<p><b><?php echo $nome; ?></b>, confira se os dados abaixo para a entrega do seu pedido estão corretos.</p>

			    		<div class="card card-body" style="background: rgba(255, 255, 255, 0.5);">

			    			<div class="text-center">
							  <i class="fas fa-shipping-fast"></i>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Nome Destinatário:</b> <?php echo $nome; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Data Nascimento:</b> <?php echo $data_nascimento; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Telefone:</b> <?php echo $telefone; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>E-mail:</b> <?php echo $email; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Endereço de Entrega:</b> <?php echo $endereco; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Número:</b> <?php echo $numero; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Complemento:</b> <?php echo $complemento; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>CEP:</b> <?php echo $cep; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Bairro:</b> <?php echo $bairro; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Cidade:</b> <?php echo $cidade; ?>
							</div>

							<div style="margin:0px; display:inline-block;">
							    <b>Estado:</b> <?php echo $estado; ?>
							</div>

							<button onclick="MostraAtualizarDados();" class="btn btn-dark"><i class="fas fa-edit"></i> Mudar Endereço de Entrega</button>

					    </div>
				    </div>
				    <?php
				} 
				?>
			</div>
		</div>

		<div class="col-md-6" style="padding:0px;">
			<!-- CONCLUIR PEDIDO -->
			<div style="border: 1px solid #aaa8a8; margin: 10px 0 10px 5px; padding: 10px;">
				<h3 class="text-white"><span class="badge badge-pill badge-dark"> 2 </span> <span class="preto">CONCLUIR PEDIDO</span></h3>
				<hr>

				<!-- Lista de Itens No Carrinho -->
				<h4 class="azul">PEDIDO</h4>

				<?php
				$ctg = 0; // limita para ler 1 vez o código para a descrição curta.
				while ($dados = $sql_produto->fetch(PDO::FETCH_ASSOC)) { 
					$id_produto=$dados['id_produto'];
					$quantidadeselecionada=$dados['quantidade'];
					$precobd=$dados['preco'];
					$preco = MostraValorDinheiroCorretamente($precobd);

					$executa66 = $pdo->query("SELECT * FROM loja_produtos WHERE id='$id_produto'");
				    while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
				        $titulo=$dadoss66['titulo'];
				        $alias=$dadoss66['alias'];
				        $descricao=$dadoss66['descricao'];
				        $descricao = strip_tags($descricao);
        				$descricaodois=limita_caracteres($descricao, '80', $quebra = true);
						$foto_abertura=$dadoss66['foto_abertura'];
						$altura=$dadoss66['altura'];
						$largura=$dadoss66['largura'];
						$comprimento=$dadoss66['comprimento'];
						$peso=$dadoss66['peso'];
						$categoria=$dadoss66['categoria'];
						$estoque=$dadoss66['estoque'];
						$executa66 = $pdo->query("SELECT * FROM loja_categorias WHERE id='$categoria'");
				        while ($dadoss66 = $executa66->fetch(PDO::FETCH_ASSOC)) { 
				            $categoria_nome=$dadoss66['titulo'];
				            $categoria_alias=$dadoss66['alias'];
				        }
				        // Listando os produtos
						?>
						<div class="row">
				            <div class="col-2 p-0">
				              <!-- Foto de Principal -->
				              <a href='<?php echo "https://www.epapodetarot.com.br/loja-item/$categoria_alias/$alias"; ?>' title="<?php echo $titulo; ?>">
				                <div id="efeitofoto" class='img-thumbnail' style="background-position: center; background-size: cover; height:60px; width:60px; background-image: url('<?php echo 'https://www.epapodetarot.com.br/loja_admin/foto_abertura/'.$foto_abertura; ?>');">
				                </div>
				              </a>
				            </div>
				            <div class="col-10 p-0 pl-2">
								<!-- Título -->
								<a href='<?php echo "https://www.epapodetarot.com.br/loja-item/$categoria_alias/$alias"; ?>' title="<?php echo $titulo; ?>"><b><?php echo $titulo; ?></b></a><br>
								<div class="row">
								    <!-- Preço -->
								    <div class="float-left mr-3">
								    	<b><?php echo $preco; ?></b> 
								    </div>

							      	<!-- Alterar Quantidade de Produtos -->
							        <div class="float-right">
							          	<form id="FormAlterarProduto[<?php echo $id_produto; ?>]" name="FormAlterarProduto[<?php echo $id_produto; ?>]" method="post" action="carrinho-compras" class="form-horizontal" style="padding: 0; margin: 0;">
							                <input type="hidden" name="IdAlterarQuantidade" id="IdAlterarQuantidade" value="" />
							                <input type="hidden" name="preco" id="preco" value="<?php echo $precobd; ?>" />
							                <select name="novoquantidadeselecionada[<?php echo $id_produto; ?>]" id="novoquantidadeselecionada[<?php echo $id_produto; ?>]" class="form-control input-sm" onchange="AlterarQuantidade('<?php echo $id_produto; ?>');"> 
								                <option value="<?php echo $quantidadeselecionada; ?>" selected><?php echo $quantidadeselecionada; ?> Unidade(s)</option>
								                <?php 
								                for ($i=1; $i < $estoque; $i++) {
								                	?>
								                	<option value="<?php echo $i; ?>"><?php echo $i; ?> Unidade(s)</option>
								                	<?php
								                }
								                ?>
								            </select>
							            </form>
							        </div>
								</div>
								<!-- Descrição -->
								<?php echo strip_tags($descricaodois); ?><br>
								<!-- Excluir Produto do Carrinho -->
								<div class="float-right">
									<form id="FormExluirCarrinho" name="FormExluirCarrinho" method="post" action="carrinho-compras" class="form-horizontal" style="padding: 0; margin: 0;">
									    <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>" />
									  	<button name="ExcluirProduto" id="ExcluirProduto" type="submit" class="btn btn-xs btn-default"><i class="fas fa-trash-alt text-danger"></i> Remover</button>
									</form>
								</div>
				            </div>
				        </div>

				        <hr style="border-top: 1px solid #ccc;">
					<?php
				    }

				    // cria descrição curta do pedido para demonstrativo
			        if ($ctg < 1  ) {
				        $demonstrativolojacurto = $titulo.', '.$quantidadeselecionada.' Unidade(s) '.$preco.' / ';
				        $ctg ++; // não lê mais o if, agora só adiciona na variavel o restante dos produtos.
			        } else {
				        $demonstrativolojacurto .= $titulo.', '.$quantidadeselecionada.' Unidade(s) '.$preco.' / ';
			        }
				}
				?>
				<!-- Total de Itens -->
				<h4 class="azul">TOTAL DE ITENS:<span class="float-right" style="color:#575656;"><?php echo $row; ?></span></h4>
				<hr>

				<!-- SubTotal -->
				<h4 class="azul">SUBTOTAL:<span class="float-right" style="color:#575656;">R$ <?php echo $valorSUBTOTAL; ?></span></h4>
				<hr>

				<!-- Frete -->
				<?php
				// FRETE
				$sqlaltura = $pdo->query("SELECT COALESCE(SUM(altura), 0) as soma FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session'");
				$contaltura  = $sqlaltura->fetch(PDO::FETCH_ASSOC);
				$valoraltura = $contaltura["soma"];

				$sqllargura = $pdo->query("SELECT COALESCE(SUM(largura), 0) as soma FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session'");
				$contlargura  = $sqllargura->fetch(PDO::FETCH_ASSOC);
				$valorlargura = $contlargura["soma"];

				$sqlcomprimento = $pdo->query("SELECT COALESCE(SUM(comprimento), 0) as soma FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session'");
				$concomprimento  = $sqlcomprimento->fetch(PDO::FETCH_ASSOC);
				$valorcomprimento = $concomprimento["soma"];

				$sqlpeso = $pdo->query("SELECT COALESCE(SUM(peso), 0) as soma FROM loja_carrinho WHERE id_cliente='$id_cliente_carrinho_session'");
				$conpeso  = $sqlpeso->fetch(PDO::FETCH_ASSOC);
				$valorpeso = $conpeso["soma"];

				// FRETE
				if(@$row_onlinex=="offline" OR @$row_onlinex=="") {

					$valorFrete=0;
					$PrazoEntregaFrete=0;
					// echo $valoraltura.'<br>';
					// echo $valorlargura.'<br>';
					// echo $valorcomprimento.'<br>';
					// echo $valorpeso.'<br>';
					?>
					<h4 class="azul">FRETE:</h4> <p>Faça login ou cadastre-se antes de continuar...</p><?php

				} else {
				
					// Verifica Frete Grátis
					if ($valoraltura < 100 OR $valorlargura < 100 OR $valorcomprimento < 100 OR $valorpeso < 30.000) {
						
						// Frete grátis
						?><h4 class="text-success">Frete Grátis!</h4><?php
						$valorFrete=0;
						$PrazoEntregaFrete=0;
					} else {
						
						// Frete normal
						include 'calcularfrete.php';
						?><h4 class="azul">FRETE:<span class="float-right" style="color:#575656;">R$ <?php echo $valorFrete.' / Prazo: '.$PrazoEntregaFrete.' dias'; ?></span></h4><?php
					}
				}
				?>
				<hr>

				<!-- Total -->
				<?php $valorTotal =  $valorSUBTOTAL1 + $valorFrete; $valorTotal1 = number_format($valorTotal, 2, ',', '.'); ?>
				<h4 class="azul">TOTAL:<span class="float-right" style="color:#575656;">R$ <?php echo $valorTotal1; ?></span></h4>
				<hr>

				<!-- Botão Finalizar -->
				<h4 class="azul">FINALIZAR COMPRA</h4>

				<p><a button class="btn btn-lg btn-block btn-success text-white" id="SubMeterLoja" name="SubMeterLoja" data-loading-text="Aguarde..."><i class="fas fa-check-double"></i> Confirmar Pedido</a></p>
			</div>
		</div>
	</div>
	<?php

} else {

	?>
	<div class="row" style="margin-top:20px;">
		<div class="card card-body" style="background:#fff; color:#383C3F;">
			</br>
			<center><p><i class="fas fa-cat"></i> Ops...</p></center>
			<center><b>Nenhum produto foi adicionado no carrinho ainda...</b></center>
			<br>
			<a button href='loja' name="ContinuarComprando" class="btn btn-lg btn-block btn-success d-none"><i class="fas fa-store"></i> CONTINUAR COMPRANDO</button></a>
		</div>
	</div>
	<?php 
}
?>

<div id="retorno"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- ContinuarComprando -->
<script type="text/javascript">
    function AlterarQuantidade($this) {
    	var id = $this;
    	$("input[name='IdAlterarQuantidade']").val(id);
        document.getElementById("FormAlterarProduto["+id+"]").submit();
    }
    function MostraAtualizarDados() {
    	$("#FormAtualizaDadosDiv").show();
        $("#FormMostraDadosDiv").hide();
        $('html,body').animate({scrollTop: 0},'fast');
    }
    function MostraDadosEntrega() {
    	$("#FormAtualizaDadosDiv").hide();
        $("#FormMostraDadosDiv").show();
        $('html,body').animate({scrollTop: 0},'fast');
    }
    $("#SubMeterLoja").click(function() {

		// verifica se usuário esta logado
		var usuarioOnline = '<?php echo $row_onlinex; ?>';
		if ((usuarioOnline=="offline") || (usuarioOnline=="")) {
    		document.location.href='carrinho-compras/?ErroFinalizarCompra=Faça Login ou Cadastre-se logo abaixo nessa página antes de continuar.';
			return false;
		}

		// Valida dados de Cadastro
		var nome = document.getElementById("nome").value;
    	var telefone = document.getElementById("telefone").value;
    	var email = document.getElementById("email").value;
    	var endereco = document.getElementById("endereco").value;
    	var numero = document.getElementById("numero").value;
    	var cep = document.getElementById("cep").value;
    	var bairro = document.getElementById("bairro").value;
    	var cidade = document.getElementById("cidade").value;
    	var estado = document.getElementById("estado").value;
    	var complemento = document.getElementById("complemento").value;

    	// Grava Pedido e Mostra Conclusão
    	if ((nome != "") || (telefone != "") || (email != "") || (endereco != "") || (numero != "") || (cep != "") || (bairro != "") || (cidade != "") || (estado != "")) {
			// Grava Pedido
		    $.post('https://www.epapodetarot.com.br/loja_carrinho/gravapedido.php',
	        {
				id_cliente_carrinho: '<?php echo $id_cliente_carrinho_session; ?>',
				totaldeitens: '<?php echo $row; ?>',
				valorSUBTOTAL: '<?php echo $valorSUBTOTAL; ?>',
				valorFrete: '<?php echo $valorFrete; ?>',
				PrazoEntregaFrete: '<?php echo $PrazoEntregaFrete; ?>',
				valorTotal: '<?php echo $valorTotal; ?>',
				usuario_id: '<?php echo $usuario_id; ?>',
				demonstrativo: '<?php echo $demonstrativolojacurto; ?>',
				nome: nome,
				telefone: telefone,
				email: email,
				endereco: endereco,
				numero: numero,
				cep: cep,
				bairro: bairro,
				cidade: cidade,
				estado: estado,
				complemento: complemento
	        }, 
	        function(retorno) {
	        	// envia carrega bloco de pagamento
	        	$("#retorno").html(retorno);
	        });
		} else {
			// Mostrando erro
			document.location.href='carrinho-compras/?ErroFinalizarCompra=Verifique se <b>todos</b> os dados pessoais e endereço de entrega estão informados corretamente antes de continuar.';
			return false;
		}
	});
</script>