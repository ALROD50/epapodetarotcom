<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>		
		<?php $ano = date("Y"); ?>
		<div class="row" style="background:rgba(9, 8, 8, 0.72);color:#ffffff;padding:20px;font-family:initial;font-size:15px;margin-right:0px;margin-left:0px;">
			<center>
				<p>&copy; É Papo de Tarot <?php echo $ano; ?> <i class="glyphicon glyphicon-lock"></i> Site Protegido</br>
				<i class="glyphicon glyphicon-earphone"></i> Suporte de Seg à Sex das 10H às 22H</br>
				<a href="https://api.whatsapp.com/send?phone=5511941190306&text=Olá É Papo de Tarot, pode me ajudar com uma duvida?" style="color:#afb733;"><i class="fab fa-whatsapp"></i> (11) 94119-0306 - Suporte</a></br>
				<i class="fas fa-envelope"></i> contato@epapodetarot.com.br</br>
				<i class="fas fa-map-marker-alt"></i> Rua Vergueiro, 1000 - Paraíso, São Paulo - SP, 01504-000</p>
				<i class="fas fa-user-lock"></i> Site 100% Seguro</br>
				<i class="fab fa-facebook-square"></i>&nbsp;&nbsp;<i class="fab fa-instagram-square"></i>&nbsp;&nbsp;<i class="fab fa-youtube-square"></i> @TarotDeHorus
			</center>
		</div>

		<!-- bootstrap js -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<!-- bootstrap js -->

		<script async src="https://kit.fontawesome.com/4587a64295.js" crossorigin="anonymous"></script>

		<!-- Mascaras -->
		<script type="text/javascript" src="https://www.epapodetarot.com.br/scripts/mask/jquery.mask.js"></script>
		<script>
		$(document).ready(function(){
		  $('.peso').mask('00.000');
		  $('.OnlyNumber').mask('000000000000');
		  $('.cardNumber').mask('0000 0000 0000 0000');
		  $('.cardExpiryM').mask('00');
		  $('.cardExpiryY').mask('00');
		  $('.cardCVC').mask('000');
		  $('.data-mask').mask('00/00/0000');
		  $('.time').mask('00:00:00');
		  $('.date_time').mask('00/00/0000 00:00:00');
		  $('.cep').mask('00000-000');
		  $('.peso').mask('00.000');
		  $('.area').mask('00');
		  $('.phone').mask('0000-00000');
		  $('.phone_with_ddd').mask('(00) 0000-0000');
		  $('.cel_with_ddd').mask('(00) 00000-0000');
		  $('.phone_us').mask('(000) 000-0000');
		  $('.mixed').mask('AAA 000-S0S');
		  $('.rg').mask('00.000.000-00', {reverse: true});
		  $('.cpf').mask('000.000.000-00', {reverse: true});
		  $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
		  $('.money').mask('000.000.000.000.000,00', {reverse: true});
		  $('.money2').mask("#.##0,00", {reverse: true});
		  $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
		    translation: {
		      'Z': {
		        pattern: /[0-9]/, optional: true
		      }
		    }
		  });
		  $('.ip_address').mask('099.099.099.099');
		  $('.percent').mask('##0,00%', {reverse: true});
		  $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
		  $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
		  $('.fallback').mask("00r00r0000", {
		      translation: {
		        'r': {
		          pattern: /[\/]/,
		          fallback: '/'
		        },
		        placeholder: "__/__/____"
		      }
		    });
		  $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
		});

		$("#enviaNome").click(function(){

			var $btnCartao = $("#enviaNome").button('loading');
			$("#NomeNaoValido").hide();
			var nome = document.forms['FormNome'].elements['nome'].value;
			var errosform = 0;
			nome = nome.trim();

            if (nome.length <= 0){
            	$btnCartao.button('reset');
                errosform++;
                $("#NomeNaoValido").show();
                $("#nome").removeClass('bordaverde');
                $("#nome").addClass('labelvermelho');
                $("#nome").focus();
            } else {
            	var errosform = 0;
                $("#nome").removeClass('labelvermelho');
                $("#nome").addClass('bordaverde');
                $("#NomeNaoValido").hide();
            }

            if (errosform == 0){
            	document.location.href='index.php?pg=page4.php&nome='+nome;
	            $btnCartao.button('reset');
            }
            
        });

		$("#enviaEmail").click(function(){

			var $btnCartao = $("#enviaEmail").button('loading');
			$("#EmailNaoValido").hide();
			var emailform = document.forms['FormEmail'].elements['emaildoformecadastro'].value;
			stringResultante = emailform.trim();

			// Email
            usuario = FormEmail.emaildoformecadastro.value.trim().substring(0, FormEmail.emaildoformecadastro.value.indexOf("@"));
            dominio = FormEmail.emaildoformecadastro.value.trim().substring(FormEmail.emaildoformecadastro.value.indexOf("@") + 1, FormEmail.emaildoformecadastro.value.length);
            if ((usuario.length >=1) &&
                (dominio.length >=3) && 
                (usuario.search("@")==-1) && 
                (dominio.search("@")==-1) &&
                (usuario.search(" ")==-1) && 
                (dominio.search(" ")==-1) &&
                (dominio.search(".")!=-1) &&      
                (dominio.indexOf(".") >=1)&& 
                (dominio.lastIndexOf(".") < dominio.length - 1)) {
                $('#emaildoformecadastro').removeClass('labelvermelho');
                $("#emaildoformecadastro").addClass('bordaverde');
                $("#EmailNaoValido").hide();
                var errosform = 0;
            } else {
                $("#emaildoformecadastro").focus();
                $("#emaildoformecadastro").removeClass('bordaverde');
                $("#emaildoformecadastro").addClass('labelvermelho');
                $("#EmailNaoValido").show();
                $btnCartao.button('reset');
                errosform++;
            }

            if (errosform == 0){
            	document.location.href='https://www.epapodetarot.com.br/cartomantes/index.php?novocliente=true&email='+emailform;
            }
            
        });

        $("#enviaWhatsApp").click(function(){

			var $btnCartao = $("#enviaWhatsApp").button('loading');
			$("#whatsappNaoValido").hide();
			var whatsapp = document.forms['FormWhatsApp'].elements['whatsapp'].value;
			var errosform = 0;
			whatsapp = whatsapp.trim();
			whatsapp = whatsapp.replace(/[ÀÁÂÃÄÅ]/g,"A");
	        whatsapp = whatsapp.replace(/[àáâãäå]/g,"a");
	        whatsapp = whatsapp.replace(/[ÈÉÊË]/g,"E");
	        whatsapp = whatsapp.replace(/[^a-z0-9]/gi,'');

            if (whatsapp.length == 11){
            	var errosform = 0;
                $("#whatsapp").removeClass('labelvermelho');
                $("#whatsapp").addClass('bordaverde');
                $("#whatsappNaoValido").hide();
            } else {
            	$btnCartao.button('reset');
                errosform++;
                $("#whatsappNaoValido").show();
                $("#whatsapp").removeClass('bordaverde');
                $("#whatsapp").addClass('labelvermelho');
                $("#whatsapp").focus();
            }

            if (errosform == 0){
            	document.location.href='https://www.epapodetarot.com.br/cartomantes/index.php?whatsapp='+whatsapp;
            }
        });

        function testaCelular(valor, $this) {
	        var id = $this;
	        valor = valor.replace(/[ÀÁÂÃÄÅ]/g,"A");
	        valor = valor.replace(/[àáâãäå]/g,"a");
	        valor = valor.replace(/[ÈÉÊË]/g,"E");
	        valor = valor.replace(/[^a-z0-9]/gi,'');
	        if (valor.length == 11) {
	            $("#"+id+"").removeClass('labelvermelho');
	            $("#whatsappNaoValido").hide();
	            $("#msgecel").hide();
	        } else {
	        	$("#msgecel").show();
	            $("#"+id+"").focus();
	            $("#"+id+"").removeClass('bordaverde');
	            $("#"+id+"").addClass('labelvermelho');
	            document.getElementById("msgecel").innerHTML="<font color='red'><i class=\"fas fa-exclamation-circle\"></i> O número de celular deve ter 2 digitos para o DD e 9 para o número. </font>";
	        }
	    }
		</script>

	</body>
</html>