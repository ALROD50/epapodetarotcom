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
    $credito           = $_SESSION['credito'];
    $id_tarologo       = $_SESSION['id_tarologo'];
    $id_cliente        = $_SESSION['id_cliente'];
    $nome_tarologo     = $_SESSION['nome_tarologo'];
    $nome_cliente      = $_SESSION['nome_cliente'];
    $data              = date('Y-m-d h:i:s');

    // Se a room na URL for diferente da room aqui, volta para a room daqui.
    $cod_sala_url_chat = $_GET['room'];
    if ($cod_sala_url_chat != $cod_sala) {
        header("location:chat-index.php?room=$cod_sala");
    }

    // Estanciando dados do tarólogo.
    $sqlxa = $pdo->query("SELECT * FROM clientes WHERE id='$id_usuario_logado' LIMIT 1 ");
    while ($mostrarxa = $sqlxa->fetch(PDO::FETCH_ASSOC)){ 
        $NomeUserLogadoChat=$mostrarxa['nome'];
    }
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
    // Digitango
    if ($NomeUserLogadoChat!=$nome_tarologo) {
        $nome_digitando=$nome_tarologo;
    } elseif($NomeUserLogadoChat!=$nome_cliente){
        $nome_digitando=$nome_cliente;
        // Primeiro nome
        $nome_digitando = $nome_digitando;
        $nome_digitando = explode(' ', $nome_digitando);
        $nome_digitando = $nome_digitando[0];
    }
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Em Consulta no Chat - <?php echo $NomeUserLogadoChat; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="../scripts/bootstrap3/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../scripts/bootstrap3/css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/mobile.css" media="(max-width: 999px)">
        <link rel="shortcut icon" href="../images/favicon.ico" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body onLoad="document.forms['form1'].message.focus();">

        <?php
        if (!isset($_SESSION['inicia_chat3']) ) {
            
            $_SESSION['tempo_inicial3'] = date('Y-m-d H:i:s'); // armazena o tempo exato que o chat é iniciado em sessão
            $_SESSION['inicia_chat3'] = 'sim'; // Sessão criada para não execultar essa condição novamente novamente.
        }

        $horaInicio = $_SESSION['tempo_inicial3']; // tempo em que o chat começou
        $horaFim = date('Y-m-d H:i:s'); // tempo atual

        // Tempo que passou em minutos
        $resultado = datediff('n', $horaInicio, $horaFim, false);

        // Crédito em minutos
        $credito_minutos1 = $credito / 60;
        $credito_minutos = $credito_minutos1 + 2;

        // Novo crédito atualizado, de acorodo com o tempo que passou
        $credito2 = $credito_minutos - $resultado;

        // Crédito em segundos
        $credito2 = $credito2 * 60;
        ?>
        
        <!-- Contagem Regressiva -->
        <script type="text/javascript">
            var tempo = new Number();
            // Tempo em segundos
            tempo = <?php echo $credito2; ?>;
            function startCountdown() {
                // Se o tempo não for zerado
                if((tempo - 1) >= 58) {
                    // Pega a parte inteira dos minutos
                    var min = parseInt(tempo/60);
                    // horas, pega a parte inteira dos minutos
                    var hor = parseInt(min/60);
                    //atualiza a variável minutos obtendo o tempo restante dos minutos
                    min = min % 60;
                    // Calcula os segundos restantes
                    var seg = tempo%60;
                    // Formata o número menor que dez, ex: 08, 07, ...
                    if(min < 10) {
                        min = "0"+min;
                        min = min.substr(0, 2);
                    }
                    if(seg <=9) {
                        seg = "0"+seg;
                    }
                    if(hor <=9) {
                        hor = "0"+hor;
                    }
                    // Cria a variável para formatar no estilo hora/cronômetro
                    // horaImprimivel = hor+':'+min+':'+seg;
                    horaImprimivel = hor+'H : '+min+" Minuto(s) ";
                    // JQuery pra setar o valor
                    $("#tempoconsulta").html(horaImprimivel);
                    $("#tempoconsulta2").html(horaImprimivel);
                    // Define que a função será executada novamente em 1000ms = 1 segundo
                    setTimeout('startCountdown()',1000);
                    // diminui o tempo
                    tempo--;
                    // Quando o contador chegar a zero faz esta ação
                } else {
                    // Avisar que a sessão foi finalizada com sucesso.
                    alert(' Atenção - A consulta foi finalizada!  ');
                    location.href="https://www.epapodetarot.com.br/chat/finalizar.php?tempo=total";
                }
            }
            // Chama a função ao carregar a tela
            startCountdown();
            //Contagem Progressiva
            // <!-- begin
            var sHors = "0"+0; 
            var sMins = "<?php echo $resultado; ?>";
            var sSecs = -1;
            function getSecs() {
                sSecs++;
                if(sSecs==60) {
                    sSecs=0;
                    sMins++;
                    if(sMins<=9) {
                        sMins="0"+sMins;
                    }
                }
                // if(sMins==60){sMins="0"+0;sHors++;
                // if(sHors<=9)sHors="0"+sHors;
                // }
                if(sSecs<=9)sSecs="0"+sSecs;
                    clock1.innerHTML=sMins+" Minuto(s) ";
                    // clock2.innerHTML=sMins+" Minuto(s) ";
                    //clock1.innerHTML=sMins+"<font color=#000000>:</font>"+sSecs;
                    setTimeout('getSecs()',1000);
            }
        //-->
        </script>
        <!-- Contagem Progressiva -->

        <!-- Botão Encerrar Chat -->
        <div id="hedchat" class="" style="">
            <div style="float:right;">
                <?php echo '<a button class="btn btn-danger" href="https://www.epapodetarot.com.br/chat/chat-index.php?room='.$cod_sala.'&encerrar='.$cod_sala.'"><i class="glyphicon glyphicon-off icon-white"></i> Encerrar</button></a>'; ?>
            </div>
            <img id="logo" src="https://www.epapodetarot.com.br/images/Logo-Site.fw.png" alt="É Papo de Tarot" style="max-height: 53px;">
        </div>
        
        <!-- Corpo do Chat -->
        <div id="fullpage" class="row" style="">

            <!-- Corpo onde aparecem as mensagens -->
            <div role="main" class="col-md-9">
                <section id="content" style="display:block; position:fixed;"></section>
            </div>

            <!-- Lateral Direita com Informações do Tarólogo e Tempo -->
            <aside id="lateral_direita" role="complementary" class="col-md-3" style="margin-top:80px; overflow-y: scroll !important; z-index: 1;">
               
               <center>
                    <img id="imagem_tarologo" src="../tarologos_admin/fotos/<?php echo $logo;?>" class="img-rounded" alt="<?php echo $nome_tarologo;?>" title="<?php echo $nome_tarologo;?>" style="max-height:173px; margin-top:10px;">

                    <h1 style="font-size: 27px; color:#f0cd4e;"><?php echo $nome_tarologo;?></h1>

                    <p style="font-size: 13px; color:#3ac5e4; padding:3px;"><?php echo $especialidade_taro;?></p>

                    <p style="color:#fff; margin: 0 0 0px;"><b>Tempo de Consulta:</b></p>
                    <div id="clock1" style="color:#fff;"></div>
                    <script>setTimeout('getSecs()',1000);</script>

                    <p style="color:#fff; margin: 0 0 0px;"><b>Tempo Restante:</b> 
                    <div style="color:#fff;" id="tempoconsulta"></div></p>

                    <?php if ($nivel == 'TAROLOGO') { ?>
                        <div id="clientes">
                            <center style="color:#820000;">Dados do Cliente</center>
                            Nome: <b><?php  echo $nome_cliente; ?></b><br>
                            Data de Nascimento: <b><?php  echo $data_nascimento; ?></b>
                        </div>
                    <?php } ?>
                </center>
                
            </aside>

        </div>

        <!-- Rodapé com campo de envio de mensagens -->
        <footer class="" style="">

            <!-- Digitando -->
            <div id="key" class="d-none" style="position:absolute; z-index:2; color:#fff;">
                <p style="margin:0 0 1px;"><img src="https://www.epapodetarot.com.br/images/crayons-01.gif" style="max-height: 21px;"> <?php echo $nome_digitando; ?> está digitando...</p>
            </div>

            <!-- Tempo para mobile -->
            <div id="tempo_mobile" style="color:#fff;">
                <p style="margin: 0 0 5px;"> 
                    Tempo Restante:  <span id="tempoconsulta2"></span>
                    <video height="1" width="1" autoplay="" loop="" muted="" controls="">
                      <source src="https://www.epapodetarot.com.br/blackvideo.mp4">
                    </video>
                </p>
            </div>
            
            <!-- Digita a Mensagem -->
            <form id="form1" class="form-horizontal" style="margin-top:25px;">

                <input type="hidden" name="name" id="name" value="<?php echo $NomeUserLogadoChat; ?>">
                <input type="hidden" name="cod_sala" id="cod_sala" value="<?php echo $cod_sala; ?>">
                <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $id_cliente; ?>">
                <input type="hidden" name="id_tarologo" id="id_tarologo" value="<?php echo $id_tarologo; ?>">
                <input type="hidden" name="escreveu" id="escreveu" value="<?php echo $id_usuario_logado; ?>">

                <div id="mensagem_texto" style="float:left; width:127px; padding-left: 15px; padding-top:6px;">
                    <span style="margin-left:10px; color:#fff;">Mensagem</span>
                </div>

                <div  id="mensagem_textarea" style="width:50%; float:left; margin-right:20px;">
                    <input class="form-control" type="text" id="message" name="message" autocomplete="off" style="height:30px;" />
                </div>

            </form>
            
            <!-- Botão Enviar -->
            <div style="margin-left:20px;">
                <button class="btn btn-success" id="btn1" style="height:30px; padding-top: 5px;">Enviar</button>
            </div>

        </footer>

        <script src='assets/js/script.js'></script>

        <!-- Carrega histórico -->
        <script type="text/javascript">
            $(document).ready(function(){
                $.post('https://www.epapodetarot.com.br/chat/historico.php',
                {
                    cod_sala : '<?php echo $cod_sala; ?>',
                    id_usuario_logado : '<?php echo $id_usuario_logado; ?>'
                }, 
                function(retorno){
                    $("#content").html(retorno);
                });
                // Volta ponteiro na caixa de mensagem
                document.forms['form1'].message.focus();
            });
            // Auto-scroll ulimas mensagens
            var objDiv = document.getElementById("#content");
            objDiv.scrollTop = objDiv.scrollHeight;
        </script>

    </body>
    </html>
    <?php 
} else {
    // Essa sala não existe
    echo '<script>document.location.href="https://www.epapodetarot.com.br/"</script>';
}
// Botão Encerra Chat
if ($_GET['encerrar']) {
    ?>
    <script type="text/javascript">
        var resultado = "<?php echo $resultado; ?>";
        EncerrarChat(resultado);
    </script>
    <?php
}
?>