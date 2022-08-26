<?php
$gg = $URLCATEGORIA;
if ($row_onlinex=="" OR $row_onlinex=="offline") {

	if ($gg=='gg') {

		// Recebe os dados do cliente
		$name  = $URLSUBCATEGORIA;
		$email = $URLSUBSUBCATEGORIA;
		$name  = str_replace("%20", " ", $name);

		// Verificando se e-mail já existe no sistema.
	    $sqlmail = $pdo->query("SELECT * FROM clientes WHERE email='$email'");
	    
	    // E-mail Existe, então Loga cliente
	    if ($sqlmail->rowCount() >= 1) {
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
	            echo "<script>document.location.href='https://www.epapodetarot.com.br/carrinho-compras/?msgs=Você foi logado com sucesso!'</script>";
	        } elseif ($URLSESSAO=='comprar-consulta') {
	            echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/chat/?msgs=Você foi logado com sucesso!'</script>";
	        } else {
	            echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msgs=Você foi logado com sucesso!'</script>";
	        }

	    // O E-mail não existe, Então registra o novo cliente
	    } else { 

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
	            $headers .= "From: epapodetarot@gmail.com \r\n";
	            $headers .= "Bcc: epapodetarot@gmail.com \r\n";

	            /*Configuramos o conte?do do e-mail*/
	            $conteudo  = "Obrigado por se registrar em nosso site, abaixo segue os seus dados de cadastro e login.<br/>";
	            $conteudo .= "<br/>";
	            $conteudo .= "Cadastro via GOOGLE: <br/>";
	            $conteudo .= "<strong>NOME:</strong> $name<br/>";
	            $conteudo .= "<strong>USUÁRIO:</strong> $email<br/>";
	            $conteudo .= "<strong>E-MAIL:</strong> $email<br/>";
	            $conteudo .= "<br/>";
	            $conteudo .= "<br/>";
	            $conteudo .= "www.epapodetarot.com.br<br/>";

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
	            '$name',
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
			
			// Registrar usuário como online
			$usuario_id = $resultado['id'];
			$datacompleta2 = date("Y-m-d H:i:s");
			$query = $pdo->query("UPDATE clientes SET 
				online='online',
				time='$datacompleta2'
			WHERE id='$usuario_id'");
			
			// Redireciona o visitante
			if ($URLSESSAO=='carrinho-compras') {
	            echo "<script>document.location.href='https://www.epapodetarot.com.br/carrinho-compras/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
	        } elseif ($URLSESSAO=='comprar-consulta') {
	            echo "<script>document.location.href='https://www.epapodetarot.com.br/comprar-consulta/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
	        } else {
	            echo "<script>document.location.href='https://www.epapodetarot.com.br/tarologos/?msgs=Parabéns, sua conta foi criada com sucesso!'</script>";
	        }
	    }
	}
}
?>