<?php
//
// PARA TARÓLOGOS
//
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo = conexao();
echo '<div class="card card-body" style="position:absolute; font-size:42px; z-index:99999;">';
echo 'Pesquisando se existe chamada de atendimento: tempo '.time().'</br>'; 
echo '</div>';
$id_tarologo = $_POST['id_tarologo'];

//Verificar no banco "chamada_consulta" a última chamada do cliente.
$sql = $pdo->query("SELECT * FROM chamada_consulta WHERE id_tarologo='$id_tarologo' ORDER by id DESC LIMIT 1"); 

  while ($row = $sql->fetch(PDO::FETCH_ASSOC)){
  	$id               = $row["id"];
	$cliente_chamando = $row["cliente_chamando"];
	$acesso           = $row["acesso"];
  }

if ($cliente_chamando == "cliente_chamando" AND $acesso == "") {
	?>
    <!-- Mensagem de Aviso para Tarólogo Iniciar o Atendimento -->
    <div id="MensagemAviso" class="card card-body my-3 shadow col-md-12 text-center" style="z-index: 1000000">
        <h1 class="preto" style="font-size:40px;">Atenção <i class="fas fa-exclamation-circle"></i></h1>
        <h1 class="azul">Cliente solicitando atendimento!</h1>
        <h1 class="azul">Clique no botão abaixo para começar...</h1>
        <?php echo '<a href="index.php?cod_sala='.$id.'&inicia_chat=true"><button type="button" id="btn1" class="btn btn-primary btn-lg btn-block shadow" style="font-size:35px;"><i class="fas fa-comments"></i> Iniciar Atendimento!</button></a>'; ?>
	</div>

	<div style="width:0px; height:0px; position: absolute; top:-100px;" id="temporizador"></div>

	<!-- Da Refresh na Página Após 32 segundos, para reiniciar o sistema -->
	<script type="text/javascript">
		var tempo2 = new Number();
		// Tempo em segundos
		tempo2 = 32;
		function startCountdown2(){
			// Se o tempo não for zerado
			if((tempo2 - 1) >= 0){
				// Pega a parte inteira dos minutos
				var min = parseInt(tempo2/60);
				// horas, pega a parte inteira dos minutos
				var hor = parseInt(min/60);
				// atualiza a variável minutos obtendo o tempo restante dos minutos
				min = min % 60;
				// Calcula os segundos restantes
				var seg = tempo2%60;
				// Formata o número menor que dez, ex: 08, 07, ...
				if(min < 10){
					min = "0"+min;
					min = min.substr(0, 2);
				}
				if(seg <=9){
					seg = "0"+seg;
				}
				if(hor <=9){
					hor = "0"+hor;
				}
				// Cria a variável para formatar no estilo hora/cronômetro
				horaImprimivel = hor+':' + min + ':' + seg;
				//JQuery pra setar o valor
				$("#temporizador").html(horaImprimivel);
				// Define que a função será executada novamente em 1000ms = 1 segundo
				setTimeout('startCountdown2()',1000);
				// diminui o tempo
				tempo2--;
			} else {
				// Quando o contador chegar a zero faz esta ação
			    location.href="https://www.epapodetarot.com.br/minha-conta";
			}
		}
		// Chama a função ao carregar a tela
		startCountdown2();

		// Remove o aviso para não criar 2 salas
		var btn1 = document.getElementById('btn1');
		btn1.addEventListener('click', function(){
		   $("#MensagemAviso").hide();
		});
	</script>

	<?php

} else {

	//Clientes não esta chamando
	//echo "Cliente NÃO esta chamando!";
}
?>