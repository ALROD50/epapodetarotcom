<?php
header('Access-Control-Allow-Origin: *');

// $Mysqli = new mysqli('localhost', 'tarotdeh_sistema', 'AZ4xGDcBI,Q+', 'tarotdeh_sistema');

$request = $_SERVER['REQUEST_METHOD'] == 'GET' ? $_GET : $_POST;

switch ($request['acao']) {
	
	case "LoginWeb":
		$usuario = addslashes($_POST['usuario']);
		$senha = addslashes($_POST['senha']);
		$senha = md5($senha);

		$erro = "";
		$erro .= empty($usuario) ? "Informe o seu usuario \n" : "";
		$erro .= empty($senha) ? "Informe a sua senha \n" : "";

		$arr = array();

		if(empty($erro)){
			// $query = "select * from clientes where usuario = '{$usuario}' and senha = '{$senha}'";
			// $result = $Mysqli->query($query);

			$host   = "localhost";
			$user   = "tarotdeh_sistema";
			$pass   = "AZ4xGDcBI,Q+";
			$banco  = "tarotdeh_sistema";
			$conect = mysqli_connect($host, $user, $pass, $banco);
			$sql = mysqli_query ($conect, "select * from clientes where usuario = '{$usuario}' and senha = '{$senha}'"); 
			$row = mysqli_num_rows($sql);
			$mostrar = mysqli_fetch_array ($sql);

			if($row > 0){
				//usuario logado
				//$obj = $result->mysqli_fetch_array ($query);

				$arr['result'] = true;
				$arr['dados']['nome'] = $mostrar['nome'];
			}else{
				$arr['result'] = false;
				$arr['msg'] = "Usuário ou senha incorreto";
			}
		}else{
			$arr['result'] = false;
			$arr['msg'] = $erro;
		}

		echo json_encode($arr);
	break;
}