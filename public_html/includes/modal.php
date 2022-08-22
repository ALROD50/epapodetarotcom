<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>		
<!-- myModal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Painel É Papo de Tarot</h4>
      </div>
      <div class="modal-body">
        <div style="">
	        <p>Olá, <?php echo $usuario_nome; ?>! <a href='login/logout.php'><button class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-off icon-white"></i> Sair</button></a>&nbsp;&nbsp;</p>
    			<p><?php DataCompleta(); ?></p>
		    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- myModal -->