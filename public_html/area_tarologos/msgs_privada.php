<?php
$TinyMce    = "SIM";
$id_cliente = $_GET['id'];
//Estancia dados do cliente
$dadoss3="SELECT * FROM clientes WHERE id='$id_cliente'"; 
$executa3=$pdo->query($dadoss3);
    while ($dadoss3= $executa3->fetch(PDO::FETCH_ASSOC)){
    $cliente_id=$dadoss3['id'];
    $cliente_nome=$dadoss3['nome'];
    $cliente_email=$dadoss3['email'];
}
//Estancia dados do tarólogo
$dadoss4 ="SELECT * FROM clientes WHERE id='$usuario_id'"; 
$executa4=$pdo->query($dadoss4);
    while ($dadoss4= $executa4->fetch(PDO::FETCH_ASSOC)){
    $tarologo_id=$dadoss4['id'];
    $tarologo_nome=$dadoss4['nome'];
}
?>

<h3 class="text-success mt-2">Enviar Mensagem Privada</h3>
<br>

<p><b>Atenção</b> - É proibido a troca de dados de contato pessoal, como telefones, emails particular, redes sociais, link, e qualquer outra forma de contato entre cliente e tarólogo fora do site.</p>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2"></div>

            <form name="CriarMensagem" method="post" action="" style="font-size:16px;">

                <div class="form-group">
                    <label for="">Destinatário: <b><?php echo $cliente_nome; ?></b></label>
                </div>
            
                <div class="form-group">
                    <label for="">Mensagem:</label>
                    <textarea name="modelo" style="height:400px;width:100%;" class="form-control">
                        <p>Olá <?php echo $cliente_nome; ?>, como está?</p>
                        <p>Aqui é o Tarólogo <?php echo $tarologo_nome; ?> do site Tarot de Hórus <a href="https://www.tarotdehorus.com.br">www.tarotdehorus.com.br</a></p>
                        <p>... mensagem .... </p>
                        <p>... mensagem .... </p>
                        <p>... mensagem .... </p>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for=""></label>
                    <input class="btn btn-success" type="submit" name="CriarMensagem" value="Enviar Mensagem" />
                </div>

            </form>

            <?php
            if (isset($_POST["CriarMensagem"])) {

                $mensagem     = $_POST['modelo'];
                $mensagem     .= '
                <br>
                <br>
                <p>Tarot de Hórus</p>
                <p>https://www.tarotdehorus.com.br/</p>
                ';

                ###################### EMAIL ##############################
                $memaildestinatario = $cliente_email;
                $mnomedestinatario = $cliente_nome;
                $massunto  = 'Mensagem do tarologo '.$tarologo_nome;
                $mmensagem = $mensagem;
                EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem);
                // ###################### EMAIL ##############################

                $msgs = "E-mail enviado com sucesso para: $cliente_nome <br>";
                echo "<script>document.location.href='minha-conta/?pg=area_tarologos/atendimento_meses.php&msgs=$msgs'</script>";  
            }
            ?>

            <div class="col-md-2"></div>
        </div>  
    </div>
</div>