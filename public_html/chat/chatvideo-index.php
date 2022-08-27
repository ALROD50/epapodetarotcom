<?php
session_start();
ini_set('display_errors',1); // Força o PHP a mostrar os erros.
ini_set('display_startup_erros',1); // Força o PHP a mostrar os erros.
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
header('Content-Type: text/html; charset=utf-8');
if (!empty($_SESSION["cod_sala"])){
    require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
    $pdo = conexao();
    include "functions.php";
    $cod_sala          = $_SESSION['cod_sala'];
    $nome              = $_SESSION['nome'];
    $id_usuario_logado = $_SESSION['id_usuario_logado'];
    $nivel             = $_SESSION['user_nivel'];
    $creditoSegundos   = $_SESSION['credito'];
    $id_tarologo       = $_SESSION['id_tarologo'];
    $id_cliente        = $_SESSION['id_cliente'];
    $nome_tarologo     = $_SESSION['nome_tarologo'];
    $nome_cliente      = $_SESSION['nome_cliente'];
    $data              = date('Y-m-d h:i:s');
	$credito           = $creditoSegundos / 60;
    // Se a room na URL for diferente da room aqui, volta para a room daqui.
    $cod_sala_url_chat = $_GET['room'];
    if ($cod_sala_url_chat != $cod_sala) {
        header("location:chatvideo-index.php?room=$cod_sala");
		exit();
    }
	// Se não existir mais a chamada então o chat acabou
	$asdsadsa = $pdo->query("SELECT * FROM chamada_consulta WHERE id='$cod_sala'");
    $nLinhas = $asdsadsa->rowCount();
    if ($nLinhas === 0) {
		echo '<script>document.location.href="https://www.epapodetarot.com.br/home/?msge=Essa consulta foi finalizada!"</script>';
		exit();
	}
	// Estanciando dados do tarólogo.
    $sqlxa = $pdo->query("SELECT * FROM clientes WHERE id='$id_tarologo' LIMIT 1 ");
    while ($mostrarxa = $sqlxa->fetch(PDO::FETCH_ASSOC)){ 
        $logo=$mostrarxa['logo'];
        $especialidade_taro=$mostrarxa['especialidade_taro'];
    }
    // Estanciando dados do cliente
    $sqlxc = $pdo->query("SELECT * FROM clientes WHERE id='$id_cliente' LIMIT 1 ");
    while ($dadoss = $sqlxc->fetch(PDO::FETCH_ASSOC)){
        $data_nascimento = $dadoss['data_nascimento'];
        if ($data_nascimento == "30-11--0001") {
            $data_nascimento = "00-00-0000";
        }
        $data_nascimento = date("d/m/Y", strtotime("$data_nascimento"));
        if ($data_nascimento == "30/11/-0001") {
            $data_nascimento = "00/00/0000";
        }
    }
	// Nome tarólogo na videochamada
	if ($nivel=="TAROLOGO") {
		$nome_chat = $nome_cliente;
	} else {
		$nome_chat = $nome_tarologo;
	}
	// Token gen DropBox
	require __DIR__ . '/dropbox/helper.php';
    ?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Vídeo Chamada É Papo de Tarot</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" type="text/css" href="../scripts/bootstrap3/css/bootstrap.css"/>
		<link rel="stylesheet" type="text/css" href="../scripts/bootstrap3/css/bootstrap-theme.min.css"/>
		<link rel="shortcut icon" href="../images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<!-- <script src='assets/js/jitsi_api.js'></script> -->
		<script src='https://meet.jit.si/external_api.js'></script>
		<style>
			/* Pc */
			body {
				color: #fff;
				font-size: 15px;
				background: #1b2933 url('https://www.epapodetarot.com.br/images/crop.png') 50% 0 fixed no-repeat !important;
				background-size: 1920px 1169px;
				background-size: cover !important;
			}
			#hedchat {
				padding: 15px;
				background: #1b2933 url('https://www.epapodetarot.com.br/images/crop.png') 50% 0 fixed no-repeat !important;
				background-size: 1920px 1169px;
				background-size: cover !important;
			}
			#meet { 
				height: 800px; 
			}
			.title {
				color: #fff;
				text-shadow: 0 0 6px rgba(255,144,0,0.5);
			}
			.text-success {
				color: #f8b334;
			}
			/* Celular */
			@media (max-width: 999px) {
				body {
					color: #fff;
					font-size: 15px;
					background: #1b2933 url('https://www.epapodetarot.com.br/images/crop.png') 50% 0 fixed no-repeat !important;
					background-size: 1920px 1169px;
					background-size: cover !important;
				}
				#hedchat {
					padding: 5px;
					background: #ffffff; /* Old browsers */
					background: -moz-linear-gradient(top, #ffffff 0%, #e8e8e8 57%); /* FF3.6-15 */
					background: -webkit-linear-gradient(top, #ffffff 0%,#e8e8e8 57%); /* Chrome10-25,Safari5.1-6 */
					background: linear-gradient(to bottom, #ffffff 0%,#e8e8e8 57%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e8e8e8',GradientType=0 ); /* IE6-9 */
				}
			}
			@media (max-width: 1025px) { 
				#logovideo {
					top: 85px !important;
				}
			}
			@media (max-width: 769px) { 
				#logovideo {
					top: 66px !important;
				}
			}
			@media (max-width: 426px) { 
				#logovideo {
					top: 124px !important;
				}
			}
			@media (max-width: 376px) { 
				#logovideo {
					top: 124px !important;
				}
			}
			@media (max-width: 321px) { 
				#logovideo {
					top: 124px !important;
				}
			}
		</style>
	</head>
	<body>
		<!-- Cabeçalho -->
		<div id="hedchat" class="">
			<!-- Form -->
			<form id="encerra" name="encerra" action="finalizarchatvideo.php" method="post" style="margin: 0px 0px 0px 0px;" class="form-inline" onkeydown="return event.key != 'Enter';">
				<div class="form-group">
					<!-- Usuários -->
					<label for="exampleInputName2"> <?php echo $nome_tarologo.' & '.$nome_cliente.' '.$data_nascimento.' <i class="glyphicon glyphicon-time icon-white"></i> '.$credito.' Minutos'; ?></label>
					<!-- Botão Encerrar -->
					<?php if ($nivel=="TAROLOGO") { ?>
						<div class="input-group">
							<input type="text" name="duracao" id="duracao" value="" placeholder="Duração em minutos..." autocomplete="off" required class="form-control" data-mask="0000"/>
							<span class="input-group-btn">
								<button type="button" id="finalizavideochat" name="finalizavideochat" class="btn btn-danger"><i class="glyphicon glyphicon-off icon-white"></i> Encerrar</button>
							</span>
						</div>
					<?php } ?>
				</div>
				<input type="hidden" name="videochamadafinalizada">
				<input type="hidden" name="id_usuario_logado" value="<?php echo $id_usuario_logado; ?>"/>
				<input type="hidden" name="id_tarologo" value="<?php echo $id_tarologo; ?>"/>
				<input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>"/>
				<input type="hidden" name="cod_sala" value="<?php echo $cod_sala; ?>"/>
				<input type="hidden" name="nome" value="<?php echo $nome; ?>"/>
				<input type="hidden" name="user_nivel" value="<?php echo $user_nivel; ?>"/>
				<input type="hidden" name="credito" value="<?php echo $credito; ?>"/>
			</form>
        </div>
		<!-- Chat -->
		<script type="text/javascript">
			window.onload = () => {
				const domain = 'meet.jit.si';
				const options = {
					roomName: '<?= $cod_sala; ?>',
					lang: 'pt-BR',
					configOverwrite: { 
						startWithAudioMuted: false,
						startWithVideoMuted: false,
						disableDeepLinking: true,
						rejoinPageEnabled: false,
						prejoinPageEnabled: false,
						requireDisplayName: false,
						displayName: false,
						disableProfile: false,
						// meetingPasswordEnabled: false,
					},
					interfaceConfigOverwrite: { 
						SHOW_WATERMARK_FOR_GUESTS: false,
						SHOW_JITSI_WATERMARK: false,
						SHOW_BRAND_WATERMARK: false,
						HIDE_DEEP_LINKING_LOGO: true,
						SHOW_DEEP_LINKING_IMAGE: false,
						// SHOW_POWERED_BY: false,
						SHOW_PROMOTIONAL_CLOSE_PAGE: false,
						DEFAULT_REMOTE_DISPLAY_NAME: '<?=$nome_chat; ?>',
						FILM_STRIP_MAX_HEIGHT: 2,
						TOOLBAR_BUTTONS: [ 
							'microphone', 'camera', 'videoquality', 'tileview',
							//'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen', 'fodeviceselection', 'hangup', 'profile', 'recording', 'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand', 'videoquality', 'filmstrip', 'feedback', 'stats', 'shortcuts', 'tileview'
						],
					},
					parentNode: document.querySelector('#meet')
				};
				const api = new JitsiMeetExternalAPI(domain, options);
				// Inicia a gração automática do videochamada
				api.addListener('videoConferenceJoined', (e) => {
					api.startRecording({
						mode: 'file',
						dropboxToken: '<?= get_dropbox_token() ?>',
					});
				});
			}
		</script>
		<!-- Logomarca -->
		<a href="https://www.epapodetarot.com.br/chat/chatvideo-index.php?room=<?=$cod_sala?>"><div id="logovideo" style="background:#fff;width:205px;height:53px;position:absolute;top:88px; border-radius:6px 6px 6px 6px;padding:2px;"><img src="https://www.epapodetarot.com.br/images/Logo-Site.fw.png" style="width:200px;height:50px;"/></div></a>
		<!-- Renderiza o Chat -->
		<div id="meet"></div>
		<!-- Rodapé -->
		<div style="margin: 15px 0px 5px 0px;">
			<center><p>Copyright © É Papo de Tarot - Todos os Direitos Reservados - Desenvolvimento: Agência Nova Systems - Marketing Digital.</p></center>
		</div>
		<!-- Mask -->
		<script type="text/javascript" src="../scripts/mask/jquery.mask.js"></script>
		<!-- Finaliza Chamada Tarólogo -->
		<script>
			$("#finalizavideochat").click(function(){
				var duracao = document.forms['encerra'].elements['duracao'].value;
				var errosform = 0;
				duracao = duracao.trim();
				if (duracao.length < 1){
					errosform++;
					alert('Digite o tempo total da consulta em minutos.');
				}
				if (duracao > <?=$credito?>){
					errosform++;
					alert('A duração da chamada não pode ser maior que <?=$credito?> minutos.');
				}
				if (errosform == 0){
					// Oculta a videochamada e mostra a mensagem de finalização.
					$("#logovideo").hide();
					$("#meet").hide();
                	$("#meetfinish").hide();
					$("input[name='videochamadafinalizada']").val('videochamadafinalizada');
		            document.getElementById("encerra").submit();
				}
			});
		</script>
		<!-- Finaliza Chamada Cliente -->
		<!-- ###################################    WebSocket   #################################################### -->
			<?php
			if ($nivel == 'CLIENTE') {
				?>
				<script type="text/javascript">
					var cod_sala = "<?php echo $cod_sala; ?>";
					function CreateSocketWrapper(){
						console.log("cod_sala 1 = " + cod_sala);
						var conn = new WebSocket('wss://epapodetarot.com.br/wss87/NS');
						// Abre Conexão
						conn.onopen = function(e) {
							console.log("Connection established!!");
						};
						// Fica Escutando
						conn.onmessage = function(e) {
							MostraDepoimentos(e.data);
						};
						// Fecha Conexão
						conn.onclose = function(e) {
							console.log("Connection close!!");
							setTimeout(function(){CreateSocketWrapper()}, 1000); // Executa depois 1 segundos
						};
					}
					function MostraDepoimentos(data) {
						// Recebe o retorno da escuta
						data = JSON.parse(data);
						var id_sala = data.id_sala;
						var tipo = data.tipo;
						console.log("MD tipo = " + tipo);
						console.log("MD id_sala = " + id_sala);
						console.log("MD cod_sala = " + cod_sala);
						// Se a videochamada tiver sido finalizada mostra a div de depoimentos e oculta a div do chat
						if ((id_sala == cod_sala) && (tipo == 'finalizavideochat')) {
							console.log("Redirecionando para depoimentos...");
							document.location.href='https://www.epapodetarot.com.br/chat/depoimentos.php/?id_tarologo=<?php echo $id_tarologo; ?>&id_cliente=<?php echo $id_cliente; ?>&id_usuario_logado=<?php echo $id_usuario_logado; ?>';
						}
					}
					var socket = CreateSocketWrapper();
				</script>
				<?php
			}
			?>
		<!-- ###################################    WebSocket   #################################################### -->
	</body>
	</html>
	<?php 
} else {
    // Essa sala não existe
    echo '<script>document.location.href="https://www.epapodetarot.com.br/"</script>';
	exit();
}