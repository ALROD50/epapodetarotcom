<?php
if ($row_onlinex=="" OR $row_onlinex=="offline") {

	require_once "/home/tarotdehoruscom/public_html/scripts/facebook/autoload.php";
	$fb = new \Facebook\Facebook([
		// https://developers.facebook.com/apps/
	    'app_id' => '286946728553917',
	    'app_secret' => 'fb212621a21349a382a970105e23547c',
	    // 'default_graph_version' => 'v5.6.3',
	    //'default_access_token' => '{access-token}', // optional
	]);

	$helper = $fb->getRedirectLoginHelper();
	//var_dump($helper);
	$permissions = ['email']; // Optional permissions

	try {
		if(isset($_SESSION['face_access_token'])){
			$accessToken = $_SESSION['face_access_token'];
		} else {
			$accessToken = $helper->getAccessToken();
		}
		
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	// Se não existir o token
	if (! isset($accessToken)) {
		$url_login = 'https://www.tarotdehorus.com.br/'.$URLSESSAO.'/';
		$loginUrl = $helper->getLoginUrl($url_login, $permissions);
	} else {
		// existe o token
		// ################### CLIENTE JA DEU PERMISSÃO NO FACEBOOK ANTERIORMENTE - SÓ LOGAR
		$url_login = 'https://www.tarotdehorus.com.br/'.$URLSESSAO.'/';
		$loginUrl = $helper->getLoginUrl($url_login, $permissions);
		if(isset($_SESSION['face_access_token'])){
			// Usuário ja autenticado - ele ja deu permissão ao facebook anteriormente - Faça Login Aqui
			$fb->setDefaultAccessToken($_SESSION['face_access_token']);
			// Dados no Facebook
			$response = $fb->get('/me?fields=name, email');
			$user = $response->getGraphUser();
			$email=$user['email'];
			// Verificando se e-mail já existe no sistema.
	        $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email='$email'");
	        if ($sqlmail->rowCount() >= 1) {

	        	// echo $row_onlinex;
	        	// exit();

	            // E-mail Existe, então Loga cliente
	            $resultado = $sqlmail->fetch(PDO::FETCH_ASSOC);   
				date_default_timezone_set("Brazil/East");
				#### Sistema de login com Cookies -----------------------------------
	            setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
	            @$usuario_id     = $_COOKIE["UsuarioID"];
	            @$usuario_nome   = $_COOKIE["UsuarioNome"];
	            @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
	            @$usuario_status = $_COOKIE["UsuarioStatus"];
	            #### Sistema de login com Cookies -----------------------------------
				//Registrar usuário como online
				$usuario_id = $resultado['id'];
				$datacompleta2 = date("Y-m-d H:i:s");
				$query = $pdo->query("UPDATE clientes SET 
					online='online',
					time='$datacompleta2'
				WHERE id='$usuario_id'");
				// Redireciona o visitante

				if ($URLSESSAO=='carrinho-compras') {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/carrinho-compras/?msgs=Você foi logado com sucesso!'</script>";
	            } elseif ($URLSESSAO=='comprar-consulta') {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/comprar-consulta/chat/?msgs=Você foi logado com sucesso!'</script>";
	            } else {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/tarologos/?msgs=Você foi logado com sucesso!'</script>";
	            }
	        }

		} else {
			//Usuário não está autenticado
			$_SESSION['face_access_token'] = (string) $accessToken;
			$oAuth2Client = $fb->getOAuth2Client();
			$_SESSION['face_access_token'] = (string) $oAuth2Client->getLongLivedAccessToken($_SESSION['face_access_token']);
			$fb->setDefaultAccessToken($_SESSION['face_access_token']);	
		}
		
		try {
	        // ################### NOVA SESSÃO, PODE SER CLIENTE NOVO OU CLIENTE ANTIGO
			// Retorna dados do Facebook `Facebook\FacebookResponse` object
			$response = $fb->get('/me?fields=name, email');
			$user = $response->getGraphUser();
			$name=$user['name'];
			$email=$user['email'];
	        // Verificando se e-mail já existe no sistema.
	        $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email='$email'");
	        if ($sqlmail->rowCount() >= 1) {

	        	// echo "aqui 2";
	        	// exit();
	            
	            // O E-mail existe, faz login:
				$resultado = $sqlmail->fetch(PDO::FETCH_ASSOC);
				date_default_timezone_set("Brazil/East");
				#### Sistema de login com Cookies -----------------------------------
	            setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
	            @$usuario_id     = $_COOKIE["UsuarioID"];
	            @$usuario_nome   = $_COOKIE["UsuarioNome"];
	            @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
	            @$usuario_status = $_COOKIE["UsuarioStatus"];
	            #### Sistema de login com Cookies -----------------------------------
				//Registrar usuário como online
				$usuario_id = $resultado['id'];
				$datacompleta2 = date("Y-m-d H:i:s");
				$query = $pdo->query("UPDATE clientes SET 
					online='online',
					time='$datacompleta2'
				WHERE id='$usuario_id'");
				// Redireciona o visitante

				if ($URLSESSAO=='carrinho-compras') {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/carrinho-compras/?msgs=Você foi logado com sucesso!'</script>";
	            } elseif ($URLSESSAO=='comprar-consulta') {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/comprar-consulta/chat/?msgs=Você foi logado com sucesso!'</script>";
	            } else {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/tarologos/?msgs=Você foi logado com sucesso!'</script>";
	            }
	        
	        } else { 

		        // O E-mail não existe, Então registra o novo cliente
		        $data_registro = date("Y-m-d H:i:s");
				$senha         = uniqid();
				$senha2        = md5($senha);
		        $queryInsert   = $pdo->query("INSERT INTO clientes (
		            nome,
		            email,
		            usuario,
		            senha,
		            aceita_termos_uso,
		            receber_email,
		            data_registro,
		            nivel
		        ) VALUES (
		            '$name',
		            '$email',
		            '$email',
		            '$senha2',
		            'SIM',
		            'SIM',
		            '$data_registro',
		            'CLIENTE'
		        )");

		        // Faz login
		        $id_gerado = $pdo->lastInsertId();
		        
		        /* -----------------Mandando E-mail---------------------- */
		            $seuemail = $email;/*email de destino*/
		            $assunto  = "Bem Vindo";/*assunto*/

		            /*Configuramos os cabe?alhos do e-mail*/
		            $headers  = "MIME-Version: 1.0 \r\n";
		            $headers .= "Content-type: text/html; charset=utf-8 \r\n";
		            $headers .= "From: contato@tarotdehorus.com.br \r\n";
		            $headers .= "Bcc: contato@tarotdehorus.com.br \r\n";

		            /*Configuramos o conte?do do e-mail*/
		            $conteudo  = "Obrigado por se registrar em nosso site, abaixo segue os seus dados de cadastro e login.<br/>";
		            $conteudo .= "<br/>";
		            $conteudo .= "Cadastro via FACEBOOK: <br/>";
		            $conteudo .= "<strong>NOME:</strong> $name<br/>";
		            $conteudo .= "<strong>USUÁRIO:</strong> $email<br/>";
		            $conteudo .= "<strong>E-MAIL:</strong> $email<br/>";
		            $conteudo .= "<br/>";
		            $conteudo .= "<br/>";
		            $conteudo .= "www.tarotdehorus.com.br<br/>";

		            /*Enviando o e-mail...*/
		            $enviando = mail($seuemail, $assunto, $conteudo, $headers);
	            /* -----------------Mandando E-mail---------------------- */

	            // Adiciona cliente no autoresponder ID 15
		        // ADICIONA OS E-MAILS NA LISTA DA CAMPANHA
		        $data_hoje = date('Y-m-d H:i:s');
		        $pdo->query("INSERT INTO mail_lista (
		            id_camp,
		            nome,
		            email,
		            data
		        ) VALUES (
		            '15',
		            '$nome',
		            '$email',
		            '$data_hoje'
		        )");

		        // Logando novo cliente
	            $query = $pdo->query("SELECT * FROM clientes WHERE id = '$id_gerado' AND status != 'CANCELADO' LIMIT 1");
				$resultado = $query->fetch(PDO::FETCH_ASSOC);
				date_default_timezone_set("Brazil/East");
				#### Sistema de login com Cookies -----------------------------------
	            setcookie("UsuarioID", $resultado['id'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioNome", $resultado['nome'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioNivel", $resultado['nivel'], time()+3600*24*30*12*5, "/", NULL);
	            setcookie("UsuarioStatus", $resultado['status'], time()+3600*24*30*12*5, "/", NULL);
	            @$usuario_id     = $_COOKIE["UsuarioID"];
	            @$usuario_nome   = $_COOKIE["UsuarioNome"];
	            @$usuario_nivel  = $_COOKIE["UsuarioNivel"];
	            @$usuario_status = $_COOKIE["UsuarioStatus"];
	            #### Sistema de login com Cookies -----------------------------------
				
				//Registrar usuário como online
				$usuario_id = $resultado['id'];
				$datacompleta2 = date("Y-m-d H:i:s");
				$query = $pdo->query("UPDATE clientes SET 
					online='online',
					time='$datacompleta2'
				WHERE id='$usuario_id'");

				// adiciona no getresponse
	            ?>
	            <div id="retorno"></div>
	            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	            <script type="text/javascript">
	                $.post('https://app.getresponse.com/add_subscriber.html',{
	                  campaign_token: 'rnqFX',
	                  start_day: '0',
	                  name: '<?php echo $nome; ?>',
	                  email: '<?php echo $email; ?>'
	                }, 
	                function(retorno){
	                  $("#retorno").html(retorno);
	                });
	            </script>
	            <?php
				
				// Redireciona o visitante
				if ($URLSESSAO=='carrinho-compras') {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/carrinho-compras/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
	            } elseif ($URLSESSAO=='comprar-consulta') {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/comprar-consulta/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
	            } else {
	                echo "<script>document.location.href='https://www.tarotdehorus.com.br/comprar-consulta/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
	            }
	        }

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
	}
}
?>