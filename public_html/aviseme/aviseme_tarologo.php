<script language='Javascript' type='text/javascript'>
function ConfirmaExclusao($id) {
  if( confirm( "Você tem certeza de que deseja excluir este registro?" ) ) {
  	location="minha-conta/?pg=aviseme/excluir.php&id="+$id;
  } else {
    alert("O Registro não foi excluido!");
  }
}
</script>

<?php
// Avise-me por E-mail
if(isset($_POST['enviaEmail'])){
	$tarologo_nome = $_POST['tarologo_nome'];
	$cliente_nome = $_POST['cliente_nome'];
	$cliente_email = $_POST['cliente_email'];
    /* -----------------Mandando E-mail---------------------- */
    $assunto  = "Avise-me Quando Disponível - É Papo de Tarot";
    /*Configuramos os cabeçalho do e-mail*/
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: epapodetarot@gmail.com \r\n";
    $headers .= "Reply-To: epapodetarot@gmail.com \r\n";
    // $headers .= "BCC: logs@novasystems.com.br";
    /*Configuramos o conte?do do e-mail*/
    $conteudo = '
    Olá <b>'.$cliente_nome.'</b>, <br/>
    O tarólogo(a) <b>'.$tarologo_nome.'</b> esta online e disponível para atender você! <br/>
    Acesse o site <a href=\'https://www.epapodetarot.com.br/tarologos/\'>www.epapodetarot.com.br/tarologos</a> e encontre <b>'.$tarologo_nome.'</b>, depois clique no botão <b>Consultar</b> para iniciar seu atendimento.<br/>
    Caso não consiga clicar no link do site acima, tente copiar todo o endereço e colar no seu navegador de internet.
    <br/>
    <br/>
    É Papo de Tarot<br/>
    <a href=\'https://www.epapodetarot.com.br/\'>www.epapodetarot.com.br</a>
    ';
    /*Enviando o e-mail...*/
    $enviando = mail($cliente_email, $assunto, $conteudo, $headers);
    /* -----------------Mandando E-mail---------------------- */

    $msgs="Parabéns!<br/>";
    $msgs.='O sistema enviou um e-mail de aviso para o(a) cliente <b>'.$cliente_nome.'</b>, de que você esta online e disponível para atendimento.';
  	MsgSucesso ($msgs);

}
?>

<h3 class="text-success">Avise-me Quando Disponível</h3>

<p>Estes são os últimos registrados de solicitações avise-me, feito por clientes para você!</p>
<p>Sempre que houver registros de avise-me nesta página, clique no botão <b>Avisar por E-mail</b> para que o respectivo cliente, assim ele receberá o aviso de que você esta online e pode atendê-lo.</p>
<p>Depois de atender o cliente, você pode excluir o aviso do cliente que você ja atendeu, para assim manter essa página atualizada.</p>

<?php 

	$sql = $pdo->query("SELECT * FROM aviseme WHERE tarologo_id='$usuario_id' ORDER BY id DESC "); 
	$row = $sql->rowCount();

	if ($row > 0){
?>
<div class="table-responsive">
<table class="table table-responsive table-bordered table-condensed table-hover table-striped" style="margin-top:15px; font-size:12px;">
    <thead>
      <tr style="background:#265A88; color:#fff;">
        <th>ID</th>
        <th> Cliente</th>
        <th> Tarólogo</th>
        <!-- <th> E-mail Cliente</th> -->
        <!-- <th> Celular Cliente</th> -->
        <th> Data</th>
        <th style="background:#000";> Avisar</th>
        <th> Excluir</th>
      </tr>
    </thead>
    <tbody>
    <?php  
        while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)){  
	        $id=$mostrar['id'];
	        $tarologo_id=$mostrar['tarologo_id'];
	        $tarologo_nome=$mostrar['tarologo_nome'];
	        $cliente_id=$mostrar['cliente_id'];
	        $cliente_nome=$mostrar['cliente_nome'];
	        $cliente_email=$mostrar['cliente_email'];
	        $cliente_celular=$mostrar['cliente_celular'];
	        $data=$mostrar['data'];
	        $data=MostraDataCorretamenteHora ($data);
	        ?>
	      <tr>
	        <td><?php echo $id; ?></td>
	        <td><?php echo $cliente_nome; ?></td>
	        <td><?php echo $tarologo_nome; ?></td>
	        <!-- <td><?php //echo $cliente_email; ?></td> -->
	        <!-- <td><?php //echo $cliente_celular; ?></td> -->
	        <td><?php echo $data; ?></td>
	        <td>
	        	<form name="enviaEmail" method="post" action="">
				    <input type="hidden" name="tarologo_nome" value="<?php echo @$tarologo_nome; ?>" />
				    <input type="hidden" name="cliente_nome" value="<?php echo @$cliente_nome; ?>" />
				    <input type="hidden" name="cliente_email" value="<?php echo @$cliente_email; ?>" />
				    <input class="btn btn-success" type="submit" name="enviaEmail" value="Avisar por E-mail"/>
				    </form>
	        </td>
	        <td>
		        <?php echo "<a href='javascript:;' onclick='ConfirmaExclusao($id);' data-toggle='tooltip' title='Excluir Registro' class=\"btn btn-sm\"><i class=\"fas fa-trash-alt\"></i></a>"; ?>
		    </td>
        </tr>
 <?php } ?>
    </tbody>
  </table>
  </div>     
<?php
  
}else{
  $msge="Nenhum resultado encontrado...";
  MsgErro ($msge);
  }
?>