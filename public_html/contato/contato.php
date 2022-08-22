<script src='https://www.google.com/recaptcha/api.js'></script>
<style type="text/css">
    /* Recaptcha */
    @media (max-width: 480px) {
        #rc-imageselect, .g-recaptcha {
            transform:scale(0.77);
            -webkit-transform:scale(0.77);
            transform-origin:0 0;
            -webkit-transform-origin:0 0;
        }
    }
</style>

<h1><i class="fas fa-headset"></i> Central de Atendimento</h1>
<hr>

<?php 
//Função que mostra os erros da validação
$erros = null;
function ErroFormContato($nomev, $emailv, $emailv2, $telefonev, $captchav) { ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <h4>Erro no envio da mensagem!</h4>
          <p><?php echo $nomev;     ?></p>
          <p><?php echo $emailv;    ?></p>
          <p><?php echo $emailv2;   ?></p>
          <p><?php echo $telefonev; ?></p>
          <p><?php echo $captchav; ?></p>
    </div> 
<?php }

if(isset($_POST['envia'])){
    // Pega os posts e gera as variaveis
    $nome       = trim(addslashes($_POST['nome']));
    $email      = trim(addslashes($_POST['email']));
    $telefone   = trim(addslashes($_POST['telefone']));
    $assunto2    = trim(addslashes($_POST['assunto']));
    @$mensagem  = $_POST['mensagem'];
    // Captcha ###############################################################
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha_data = $_POST['g-recaptcha-response'];
        }
        // Se nenhum valor foi recebido, o usuário não realizou o captcha
        if (!$captcha_data) {
            $erros++; 
            $captchav="Clique no box <b>Não sou um robô.</b>";
        } else {            
            //biblioteca para o captcha
            require_once '/home/epapodetarotcom/public_html/scripts/recaptcha/autoload.php';
            // sua chave secreta
            $secret = "6LeO7OkUAAAAAL7xRieXU8luIkFBANA7_GjnSbsT";
            // resposta vazia
            $response = null;
            // verifique a chave secreta
            $reCaptcha = new \ReCaptcha\ReCaptcha($secret);
            // se submetido, verifique a resposta
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            }
            if ($response != null && $response->isSuccess()) {
                $captchav = null;
            } else {
                $erros++;
                $captchav="A mensagem não foi enviada.";
            }
        }
    // Captcha ###############################################################
    // validação
    if (empty($_POST['nome'])) { 
        $erros++;
        $nomev="Nome vazio, por favor preencha o nome corretamente."; 
    } else { $nomev = null; }
    if (empty($_POST['email'])) { 
        $erros++;
        $emailv="E-mail vazio, por favor preencha o e-mail corretamente."; 
    } else { $emailv = null; }
    if (empty($_POST['telefone'])) { 
        $erros++;
        $telefonev="Telefone vazio, por favor preencha o telefone corretamente."; 
    } else { $telefonev = null; }
    /*verifica email, se digitado incorretamente*/
    $email = str_replace (" ", "", $email);
    $email = str_replace ("/", "", $email);
    $email = str_replace ("@.", "@", $email);
    $email = str_replace (".@", "@", $email);
    $email = str_replace (",", ".", $email);
    $email = str_replace (";", ".", $email);
    
    if(strlen($email)<8 || substr_count($email, "@")!=1 || substr_count($email, ".")==0)
    {
        $erros++;
        $emailv2 = "Por favor, digite seu <b>E-mail</b> corretamente.<br />";
    } else {
        $emailv2 = null;
    }
    // Se tiver mais de um erro mostra a mensagem de erro
    if($erros >= 1) {
        ErroFormContato($nomev, $emailv, $emailv2, $telefonev, $captchav);
    } else {
        /* -----------------Mandando E-mail---------------------- */
        // Usando o PHPMailer, Preparando o email
        $emailMailer = new PHPMailer();
        $emailMailer->setLanguage('pt');
        $emailMailer->CharSet = "UTF-8";
        $emailMailer->IsHTML(true);
        $emailMailer->AddCustomHeader("List-Unsubscribe: <mailto:contato@epapodetarot.com.br?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
        $emailMailer->Host     = "";  
        $emailMailer->From     = "contato@epapodetarot.com.br";
        $emailMailer->SMTPAuth = false; 
        $emailMailer->Username = "contato@epapodetarot.com.br"; 
        $emailMailer->Password = ""; 
        $emailMailer->From      = 'contato@epapodetarot.com.br'; // Remetente
        $emailMailer->AddAddress( "contato@epapodetarot.com.br", 'É Papo de Tarot'); // Destinatário
        // $emailMailer->AddBCC('logs@novasystems.com.br', 'Nova Systems'); // Cópia oculta
        $emailMailer->FromName  = 'É Papo de Tarot'; // Seu nome
        $emailMailer->Subject   = 'Contato'; // Assunto
        $corpoMSG = '
        Uma nova mensagem foi enviada via formulário contato do site É Papo de Tarot.<br/>
        <br/>
        Dados da mensagem: <br/>
        <strong>NOME:</strong> '.$nome.'<br/>
        <strong>E-MAIL:</strong> '.$email.'<br/>
        <strong>TELEFONE:</strong> '.$telefone.'<br/>
        <strong>ASSUNTO:</strong> '.$assunto2.'<br/>
        <strong>MENSAGEM:</strong><br/>
        '.$mensagem.'<br/>
        <br/>
        É Papo de Tarot<br/>
        <a href=\'https://www.epapodetarot.com.br/\'>www.epapodetarot.com.br</a>
        ';
        $emailMailer->MsgHTML($corpoMSG);
        // Enviando o email
        $emailMailer->Send();
        /* -----------------Mandando E-mail---------------------- */
        $msgs="Sua mensagem foi enviada com sucesso!".'</br>';
        $msgs.="Em breve nossa equipe estará entrando em contato com você.".'</br>';
        MsgSucesso($msgs);
    }
} 
?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <p><img src="images/logo3.webp" alt="É Papo de Tarot" style="max-width: 70%;"></p>
        <p>Use o formulário ao lado para falar com o Tartot de Hórus.</p>
        <p style="color: #000;"><i class="far fa-clock"></i> Seg. a Sex. das 10H às 22H</p>
        <p style="color: #000; "><i class="fab fa-whatsapp"></i> (11) 9.4119-0306</p>
        <p style="color: #000; "><i class="far fa-envelope"></i> contato@epapodetarot.com.br</p>
        <p><i class="far fa-compass"></i> Rua Vergueiro, 1000 - Paraíso, São Paulo - SP, 01504-000</p>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <span class="small">(*) Preenchimento obrigatório.</span>
        <form name="contato" method="post" action="" class="form-horizontal">
            <div class="form-group">
                <label>*Seu Nome:</label>
                <input type="text" class="form-control"  name="nome" value="<?php echo $nome = isset($_POST['nome']) ? $_POST['nome'] : ''; ?>" required autofocus />
            </div>
            <div class="form-group">
                <label>*E-mail:</label>
                <input type="text" class="form-control"  name="email" value="<?php echo $email = isset($_POST['email']) ? $_POST['email'] : ''; ?>" required autofocus />
            </div>
            <div class="form-group">
                <label>*Telefone com DDD:</label>
                <input type="text" class="form-control"  name="telefone" value="<?php echo $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : ''; ?>" required autofocus />
            </div>
            <div class="form-group">
                <label>Assunto:</label>
                <input type="text" class="form-control"  name="assunto" value="<?php echo $assunto = isset($_POST['assunto']) ? $_POST['assunto'] : ''; ?>" autofocus />
            </div>
            <div class="form-group">
                <label>Mensagem</label>
                <textarea name="mensagem" class="form-control"/></textarea>
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6LeO7OkUAAAAAHEfPoGmvH6VaNJa-RhLIGK4uVbA"></div>
                <br>
                <input class="btn btn-success" type="submit" name="envia" value="Enviar Mensagem"/>
            </div>
        </form>
    </div>
</div>