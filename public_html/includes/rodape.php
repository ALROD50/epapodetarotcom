	    <style><?php echo file_get_contents("assets/dist/css/bootstrap.min.css"); ?></style>
		<style><?php echo file_get_contents("assets/style.css"); ?></style>
		<style>
		    @font-face {
			    font-family: 'dumbledor_1regular';
			    src: url('fonts/dum1-webfont/dum1-webfont.woff2') format('woff2'),
			         url('fonts/dum1-webfont/dum1-webfont.woff') format('woff');
			    font-weight: normal;
			    font-style: normal;
			}
		</style>
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    	<script>
    		window.jQuery || document.write('<script src="assets/dist/js/jquery-3.5.1.min.js"><\/script>');
    	</script>
    	<!-- <script async src="https://www.epapodetarot.com.br/assets/dist/js/jquery-3.5.1.min.js"></script> -->
    	<script async src="assets/dist/js/bootstrap.bundle.min.js"></script>
    	<script async src="https://kit.fontawesome.com/4587a64295.js" crossorigin="anonymous"></script>

    	<!-- Notificações -->
	    <script>
	        if (window.webkitNotifications) {
	            // console.log('Seu browser possui suporte ao Notifications');
	        } else {
	            // console.log('Seu browser não possui suporte ao Notifications');
	        }
	        // Após o carregamento da página
	        document.addEventListener('DOMContentLoaded', function () {
	            // Se não tiver suporte a Notification manda um alert para o usuário
	            if (!Notification) {
	                alert('Este Navegador não permite notificações. Use o Google Chrome.'); 
	                return;
	            }
	            // Se não tem permissão, solicita a autorização do usuário
	            if (Notification.permission !== "granted")
	                Notification.requestPermission();
	        });
	    </script>
	    <!-- Notificações -->

	    <!-- whatsapp -->
		<div id="whatsapp" class="d-none">
		    <a href="https://api.whatsapp.com/send?phone=5511941190306&text=Olá É Papo de Tarot, pode me ajudar com uma duvida?"><img src="images/whatsapp.png" alt=""></a>
		</div>

		<!-- Subir -->
		<div id="subir">
			<i class="fas fa-arrow-circle-up"></i>
		</div>

	    <!-- Código do Data Picker -->
	    <?php 
	    if($DataPicker=="SIM") {
	    	?>
			<link href="scripts/datepicker/css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
			<script src="scripts/datepicker/js/jquery-ui-1.10.3.custom.js"></script>
			<script type="text/javascript">
				$(function() {
					$( "#datepicker" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "dd-mm-yy",
					});
					$( "#datepicker2" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "dd-mm-yy",
					});
					$( "#datepicker3" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "dd-mm-yy",
					});
					$( "#datepicker4" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "dd-mm-yy",
					});
					$( "#datepicker5" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "dd-mm-yy 00:00:00",
					});
					$( "#datepicker6" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "dd-mm-yy 00:00:00",
					});
					$( "#datepicker7" ).datepicker({
						// dateFormat: "dd/mm/yy",
						dateFormat: "yy-mm-dd",
					});
				});
			</script>
	    	<?php
	    }
	    ?>
		<!-- Código do Data Picker -->

		<!-- Editor Tiny Mce -->
		<?php 
	    if($TinyMce=="SIM") {
			if ($habilitareditor == 'simples') {  ?>

				<script type="text/javascript" src="scripts/tinymce_4.7.13/tinymce/js/tinymce/tinymce.min.js"></script>
				<script type="text/javascript">
					tinymce.init({
						selector: 'textarea',
						height: 300,
						theme: 'modern',
						plugins: ["print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools  colorpicker textpattern help paste"],
						toolbar1: 'formatselect fontsizeselect | bold italic underline strikethrough forecolor | link unlink | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | fullscreen hr table ',
					    browser_spellcheck: true,
						image_advtab: true,
					    menubar: false,
					    convert_urls: false,
					    paste_data_images: true,
						templates: [
							{ title: 'Test template 1', content: 'Test 1' },
							{ title: 'Test template 2', content: 'Test 2' }
						],
						content_css: [
							'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
							'//www.tinymce.com/css/codepen.min.css'
						]
						// mobile: {
						//     theme: 'mobile',
						//     plugins: [ 'autosave', 'lists', 'autolink' ],
						//     toolbar: [ 'undo', 'bold', 'italic', 'numlist', 'bullist', 'removeformat', 'styleselect' ]
						// }
					});
				</script>
				<?php
			} elseif ($habilitareditor == 'completo') {  ?>

				<script src="https://cdn.tiny.cloud/1/rbavzhky4qhsevjecaywqycghd6d7dvhy3iltsxdh077ptwu/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
				<script>
					tinymce.init({
						selector: 'textarea',
						plugins: 'print preview importcss tinydrive searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons code',
						mobile: {
						plugins: 'print preview importcss tinydrive searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount textpattern noneditable help charmap  quickbars emoticons code'
						},
						menu: {
						tc: {
						  title: 'TinyComments',
						  items: 'addcomment showcomments deleteallconversations'
						}
						},
						menubar: 'file edit view insert format tools table tc help',
						toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist code | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
						autosave_ask_before_unload: true,
						autosave_interval: "30s",
						autosave_prefix: "{path}{query}-{id}-",
						autosave_restore_when_empty: false,
						autosave_retention: "2m",
						image_advtab: true,
						content_css: '//www.tiny.cloud/css/codepen.min.css',
						link_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
						],
						image_list: [
						{ title: 'My page 1', value: 'http://www.tinymce.com' },
						{ title: 'My page 2', value: 'http://www.moxiecode.com' }
						],
						image_class_list: [
						{ title: 'None', value: '' },
						{ title: 'Some class', value: 'class-name' }
						],
						importcss_append: true,
						templates: [
						    { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
						{ title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
						{ title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
						],
						template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
						template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
						height: 480,
						image_caption: true,
						quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
						noneditable_noneditable_class: "mceNonEditable",
						toolbar_mode: 'sliding',
						spellchecker_whitelist: ['Ephox', 'Moxiecode'],
						tinycomments_mode: 'embedded',
						content_style: ".mymention{ color: gray; }",
						contextmenu: "link image imagetools table configurepermanentpen",
						a11y_advanced_options: true,
  						images_upload_url: 'https://www.epapodetarot.com.br/scripts/postAcceptor.php',
  						images_upload_handler: function (blobInfo, success, failure, progress) {
						    var xhr, formData;
						    xhr = new XMLHttpRequest();
						    xhr.withCredentials = false;
						    xhr.open('POST', 'https://www.epapodetarot.com.br/scripts/postAcceptor.php');
						    xhr.upload.onprogress = function (e) {
						      progress(e.loaded / e.total * 100);
						    };
						    xhr.onload = function() {
						      var json;
						      if (xhr.status < 200 || xhr.status >= 300) {
						        failure('HTTP Error: ' + xhr.status);
						        return;
						      }
						      json = JSON.parse(xhr.responseText);
						      if (!json || typeof json.location != 'string') {
						        failure('Invalid JSON: ' + xhr.responseText);
						        return;
						      }
						      success(json.location);
						    };
						    xhr.onerror = function () {
						      failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
						    };
						    formData = new FormData();
						    formData.append('file', blobInfo.blob(), blobInfo.filename());
						    xhr.send(formData);
						},
				    });
				</script>
				<!-- <script type="text/javascript">
					tinymce.init({
						selector: 'textarea',
						height: 480,
						theme: 'modern',
						plugins: ["print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools  colorpicker textpattern help paste"],
						toolbar1: 'formatselect fontsizeselect | bold italic underline strikethrough forecolor | link unlink | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | fullscreen hr table ',
					    browser_spellcheck: true,
						image_advtab: true,
					    menubar: true,
					    convert_urls: false,
					    paste_data_images: true,
						templates: [
							{ title: 'Test template 1', content: 'Test 1' },
							{ title: 'Test template 2', content: 'Test 2' }
						],
						content_css: [
							'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
							'//www.tinymce.com/css/codepen.min.css'
						]
					});
				</script> -->
				<?php
			}
	    }
	    ?>
		<!-- Editor Tiny Mce -->

		<!-- Mascaras -->
		<?php 
	    if($Mask=="SIM") {
	    	?>
			<script type="text/javascript" src="scripts/mask/jquery.mask.js"></script>
			<script>
				$(document).ready(function(){
				  $('.peso').mask('00.000');
				  $('.OnlyNumber').mask('000000000000');
				  $('.cardNumber').mask('0000 0000 0000 0000');
				  $('.cardExpiryM').mask('00');
				  $('.cardExpiryY').mask('00');
				  $('.cardCVC').mask('000');
				  $('.data-mask').mask('00/00/0000');
				  $('.dataNascimento').mask('00-00-0000');
				  $('.time').mask('00:00:00');
				  $('.date_time').mask('00/00/0000 00:00:00');
				  $('.cep').mask('00000-000');
				  $('.peso').mask('00.000');
				  $('.area').mask('00');
				  $('.cell').mask('0.0000-0000');
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
			</script>
			<?php 
	    }
	    ?>
		<!-- Mascaras -->

		<!-- Loja -->
		<?php 
	    if($ScriptsLoja=="SIM") { ?>
			<!-- Submete adicionar no carrinho addCarrinho -->
			<script type="text/javascript">
			    $("#enviarAddCarrinho").click(function(){
			      document.getElementById("addCarrinho").submit();
			    });
			</script>

			<!-- Filtro -->
			<script>
				$("#enviaCategoria").click(function(){

				var categoria = document.forms['FormCategoria'].elements['categoria'].value;
				var errosform = 0;
				categoria = categoria.trim();

				if (categoria.length <= 0){
				    errosform++;
				} else {
				}

				if (errosform == 0){
					document.location.href='https://www.epapodetarot.com.br/loja/'+categoria;
				}
				      
				});
			</script>
			<?php
		}
	    ?>
		<!-- Loja -->
		
		<!-- Checkout -->
		<?php 
	    if($Checkout=="SIM") {
	    	echo $directpayment; 
	    	?>
	    	<script src="https://www.paypalobjects.com/api/checkout.js"></script>
		    <script>
		        $(function(){
		            $(".btn-toggle").click(function(e){
		                e.preventDefault();
		                el = $(this).data('element');
		                $(el).toggle();
		            });
		        });
		        // Atualiza o endereço da fatura do cartão automaticamente quando digita
		        $(document).change(function(){
		            $("#Street").change(function(){
		                var billingAddressStreet = document.forms["FormCheckout"]["Street"].value;
		                $("input[id='billingAddressStreet']").val(billingAddressStreet);
		            });
		            $("#numBer").change(function(){
		                var billingAddressNumber = document.forms["FormCheckout"]["numBer"].value;
		                $("input[id='billingAddressNumber']").val(billingAddressNumber);
		            });
		            $("#complemento").change(function(){
		                var billingAddressComplement = document.forms["FormCheckout"]["complemento"].value;
		                $("input[id='billingAddressComplement']").val(billingAddressComplement);
		            });
		            $("#District").change(function(){
		                var billingAddressDistrict = document.forms["FormCheckout"]["District"].value;
		                $("input[id='billingAddressDistrict']").val(billingAddressDistrict);
		            });
		            $("#PostalCode").change(function(){
		                var billingAddressPostalCode = document.forms["FormCheckout"]["PostalCode"].value;
		                $("input[id='billingAddressPostalCode']").val(billingAddressPostalCode);
		            });
		            $("#City").change(function(){
		                var billingAddressCity = document.forms["FormCheckout"]["City"].value;
		                $("input[id='billingAddressCity']").val(billingAddressCity);
		            });
		            $("#State").change(function(){
		                var billingAddressState = document.forms["FormCheckout"]["State"].value;
		                $("input[id='billingAddressState']").val(billingAddressState);
		            });
		        });
		        $(document).ready(function() {
		            // Cliente sem cadastro
		            var emaildecadastro = '<?php echo $email ?>';
		            if (emaildecadastro.length > 4){
		                $("#senderEmail").attr("disabled", true);
		                // $("#PostalCode").focus();
		            }
		            // Cliente já tem cadastro
		            var enderecodecadastro = '<?php echo $endereco ?>';
		            if (enderecodecadastro.length > 4){
		                $("#senderEmail").attr("disabled", true);
		                $("#OpPagCard").show();
		                $("#informeocep").hide();
		                // $("#cardNumber").focus();
		                $("#checkadress").hide();
		                $("#OpPagCardGE").show();
		                // $("#cardNumberGE").focus();
		            }
		        });
		        var installments = [];
		        $("input[name='cardNumber']").keyup(function(){
		            getInstallments();
		        });
		        $("#select-installments").change(function(){
		            console.log(installments[$(this).val()-1]);
		            $("input[name='installmentValue']").val(installments[$(this).val()-1].installmentAmount);
		        });
		        function getInstallments(){
		            
		            var cardNumber = $("input[name='cardNumber']").val();
		            
		            //if creditcard number is finished, get installments
		            if(cardNumber.length != 19){
		                return;
		            } 
		            PagSeguroDirectPayment.getBrand({
		                cardBin: cardNumber.replace(/ /g,''),
		                success: function(json){
		                    // console.log(json);
		                    var brand = json.brand.name;
		                    $("input[name='brand']").val(brand);
		                    
		                    var amount = parseFloat($("input[name='amount']").val());
		                    var shippingCoast = parseFloat($("input[name='shippingCoast']").val());

		                    //O valor máximo da prestação sem taxas extras (você deve configurá-lo no seu painel do PagSeguro com o mesmo valor)
		                    var max_installment_no_extra_fees = 2;
		                    
		                    PagSeguroDirectPayment.getInstallments({
		                        amount: amount + shippingCoast,
		                        brand: brand,
		                        maxInstallmentNoInterest: max_installment_no_extra_fees,
		                        success: function(response) {
		                            /*
		                                Available installments options.
		                                Here you have quantity and value options
		                            */
		                            // console.log(response);
		                            installments = response.installments[brand];
		                            $("#select-installments").html("");
		                            $("#select-installments").append("<option value=''> Selecione... </option>");
		                            for(var i in installments){

		                                $("#select-installments").append("<option value='" + installments[i].quantity + "'>" + installments[i].quantity + " x R$ " + installments[i].installmentAmount + " " + (installments[i].quantity <= max_installment_no_extra_fees ? " - Sem Juros" : "")  + " </option>");
		                            }
		                            $('#select-installments').removeAttr('disabled');
		                            // Seleciona automaticamente a primeira opçao do parcelamento
		                            document.getElementById('select-installments').value=1;

		                        }, error: function(response) {
		                            // console.log(response);
		                            $("input[name='cardNumber']").focus();
		                            $('#cardNumber').addClass('bordavermelha');
		                            $("#ErrocardNumber").show();
		                            $('#cardNumberL').addClass('labelvermelho');
		                            $("#select-installments").html("");
		                            $("#select-installments").attr("disabled", "");
		                        }, complete: function(response) {
		                            //Called after sucess or error
		                        } 
		                    });
		                }, error: function(json){
		                    // console.log(json);
		                    $("input[name='cardNumber']").focus();
		                    $('#cardNumber').addClass('bordavermelha');
		                    $("#ErrocardNumber").show();
		                    $('#cardNumberL').addClass('labelvermelho');
		                    $("#select-installments").html("");
		                    $("#select-installments").attr("disabled", "");
		                }, complete: function(json){
		                    // console.log(json);
		                }
		            });
		        }
		        jQuery(function($) {
		            var shippingCoast = parseFloat($("input[name='shippingCoast']").val());
		            var amount = parseFloat($("input[name='amount']").val());
		            $("input[name='installmentValue']").val(amount + shippingCoast);
		            PagSeguroDirectPayment.setSessionId('<?php echo $sessionCode;?>');
		            PagSeguroDirectPayment.getPaymentMethods({
		                success: function(json){
		                    getInstallments();
		                    // console.log(json);
		                }, error: function(json){
		                    // console.log(json);
		                    // var erro = "";
		                    // for(i in json.errors){
		                    //     erro = erro + json.errors[i];
		                    // }
		                    // alert(erro);
		                }, complete: function(json){
		                }
		            });
		        });
		        $("#enviarCartao").click(function(){

		            $("#carregandoPagSeguro").show();
		            var errosform = 0;

		            // Cliente vai usar outros dados pessoais diferente do cartão
		            var DadosPessoaisDoisChek = document.forms['FormCheckout'].elements['DadosPessoaisDoisChek'].value;
		            if (DadosPessoaisDoisChek == 'nao'){

		                var cx = document.forms['FormCheckout'].elements['senderNamexx'].value;
		                var separadox = cx.split(" ");

		                if (FormCheckout.senderPhonexx.value.length <= 8){
		                    $("input[name='senderPhonexx']").focus();
		                    $('#senderPhonexx').addClass('bordavermelha');
		                    $("#EsenderPhonexx").show();
		                    errosform++;
		                } else {
		                    $('#senderPhonexx').removeClass('bordavermelha');
		                    $("#EsenderPhonexx").hide();
		                }

		                if (FormCheckout.senderAreaCodexx.value.length <= 1){
		                    $("input[name='senderAreaCodexx']").focus();
		                    $('#senderAreaCodexx').addClass('bordavermelha');
		                    $("#EsenderAreaCodexx").show();
		                    errosform++;
		                } else {
		                    $('#senderAreaCodexx').removeClass('bordavermelha');
		                    $("#EsenderAreaCodexx").hide();
		                }

		                if (FormCheckout.senderCPFxx.value.length <= 13){
		                    $("input[name='senderCPFxx']").focus();
		                    $('#senderCPFxx').addClass('bordavermelha');
		                    $("#EsenderCPFxx").show();
		                    errosform++;
		                } else {
		                    $('#senderCPFxx').removeClass('bordavermelha');
		                    $("#EsenderCPFxx").hide();
		                }

		                if ((document.forms["FormCheckout"]["senderNamexx"].value < 1) ||
		                    (separadox.length <= 1)){
		                    $("input[name='senderNamexx']").focus();
		                    $('#senderNamexx').addClass('bordavermelha');
		                    $("#EsenderNamexx").show();
		                    errosform++;
		                } else {
		                    $('#senderNamexx').removeClass('bordavermelha');
		                    $("#EsenderNamexx").hide();
		                }
		            }

		            // Cliente vai usar outros dados de endereço para a fatura do cartão
		            var UsarMesmoEndCard = document.forms['FormCheckout'].elements['UsarMesmoEndCard'].value;
		            if (UsarMesmoEndCard == 'nao'){

		                if (FormCheckout.billingAddressStatex.value.length <= 1){    
		                    $("input[name='billingAddressState']").focus();
		                    $('#billingAddressStatex').addClass('bordavermelha');
		                    $("#EbillingAddressStatex").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressStatex').removeClass('bordavermelha');
		                    $("#EbillingAddressStatex").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressCityx"].value == ""){
		                    $("input[name='billingAddressCity']").focus();
		                    $('#billingAddressCityx').addClass('bordavermelha');
		                    $("#EbillingAddressCityx").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressCityx').removeClass('bordavermelha');
		                    $("#EbillingAddressCityx").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressDistrictx"].value == ""){
		                    $("input[name='billingAddressDistrict']").focus();
		                    $('#billingAddressDistrictx').addClass('bordavermelha');
		                    $("#EbillingAddressDistrictx").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressDistrictx').removeClass('bordavermelha');
		                    $("#EbillingAddressDistrictx").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressNumberx"].value == ""){
		                    $("input[name='billingAddressNumber']").focus();
		                    $('#billingAddressNumberx').addClass('bordavermelha');
		                    $("#EbillingAddressNumberx").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressNumberx').removeClass('bordavermelha');
		                    $("#EbillingAddressNumberx").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressStreetx"].value == ""){
		                    $("input[name='billingAddressStreet']").focus();
		                    $('#billingAddressStreetx').addClass('bordavermelha');
		                    $("#EbillingAddressStreetx").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressStreetx').removeClass('bordavermelha');
		                    $("#EbillingAddressStreetx").hide();
		                }

		                var cepx = FormCheckout.billingAddressPostalCodex.value;
		                if ((document.forms["FormCheckout"]["billingAddressPostalCodex"].value == "") ||
		                    (cepx.length <=8)) {
		                    $("input[name='billingAddressPostalCode']").focus();
		                    $('#billingAddressPostalCodex').addClass('bordavermelha');
		                    $("#EbillingAddressPostalCodex").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressPostalCodex').removeClass('bordavermelha');
		                    $("#EbillingAddressPostalCodex").hide();
		                }
		            }

		            // Parcelas do cartão de crédito
		            if (document.forms["FormCheckout"]["select-installments"].value.length == ""){    
		                $("input[name='installments']").focus();
		                $('#select-installments').addClass('bordavermelha');
		                $("#Erroselect-installments").show();
		                $('#select-installmentsL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#select-installments').removeClass('bordavermelha');
		                $("#Erroselect-installments").hide();
		                $('#select-installmentsL').removeClass('labelvermelho');
		            }

		            // Data de nascimento cartão de crédito
		            var stringData = FormCheckout.creditCardHolderBirthDate.value;
		            if (validaData(stringData)) {
		                $('#creditCardHolderBirthDate').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderBirthDate").hide();
		                $('#creditCardHolderBirthDateL').removeClass('labelvermelho');

		            } else {
		                $("input[name='creditCardHolderBirthDate']").focus();
		                $('#creditCardHolderBirthDate').addClass('bordavermelha');
		                $("#ErrocreditCardHolderBirthDate").show();
		                $('#creditCardHolderBirthDateL').addClass('labelvermelho');
		                errosform++;
		            }

		            // Celular cartão de crédito
		            var tel = document.forms['FormCheckout'].elements['creditCardHolderPhone'].value.replace('-','');
		            tel = tel.substring(0,1); //intervalo de caracteres prentendido, no caso pega o 1º valor
		            // Verificar se o numero é menor que 9, ou se falta o 9 no inicio do telefone.
		            if ((FormCheckout.creditCardHolderPhone.value.length <= 9) || (/[0-8]/.test(tel)) ) {
		                $("input[name='creditCardHolderPhone']").focus();
		                $('#creditCardHolderPhone').addClass('bordavermelha');
		                $("#ErrocreditCardHolderPhone").show();
		                $('#creditCardHolderPhoneL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#creditCardHolderPhone').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderPhone").hide();
		                $('#creditCardHolderPhoneL').removeClass('labelvermelho');
		            }

		            // Código de área telefone cartão de crédito
		            if (FormCheckout.creditCardHolderAreaCode.value.length <= 1){
		                $("input[name='creditCardHolderAreaCode']").focus();
		                $('#creditCardHolderAreaCode').addClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCode").show();
		                $('#creditCardHolderPhoneL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#creditCardHolderAreaCode').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCode").hide();
		                $('#creditCardHolderPhoneL').removeClass('labelvermelho');
		            }
		            var AreaCode = document.forms['FormCheckout'].elements['creditCardHolderAreaCode'].value;
		            //Expressão regular para validar o AreaCode.
		            var validaAreaCode = /[1-9][1-9]/;
		            //Valida o formato da AreaCode.
		            if(validaAreaCode.test(AreaCode)) {
		                $('#creditCardHolderAreaCode').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCode").hide();
		                $('#creditCardHolderPhoneL').removeClass('labelvermelho');
		            } else {
		                $("input[name='creditCardHolderAreaCode']").focus();
		                $('#creditCardHolderAreaCode').addClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCode").show();
		                $('#creditCardHolderPhoneL').addClass('labelvermelho');
		                errosform++;
		            }

		            // CPF cartão de crédito
		            var strCPF = FormCheckout.creditCardHolderCPF.value;
		            strCPF = strCPF.replace(/[ÀÁÂÃÄÅ]/g,"A");
		            strCPF = strCPF.replace(/[àáâãäå]/g,"a");
		            strCPF = strCPF.replace(/[ÈÉÊË]/g,"E");
		            strCPF = strCPF.replace(/[^a-z0-9]/gi,'');
		            if (TestaCPF(strCPF)) {
		                $('#creditCardHolderCPF').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderCPF").hide();
		                $('#creditCardHolderCPFL').removeClass('labelvermelho');

		            } else {
		                $("input[name='creditCardHolderCPF']").focus();
		                $('#creditCardHolderCPF').addClass('bordavermelha');
		                $("#ErrocreditCardHolderCPF").show();
		                $('#creditCardHolderCPFL').addClass('labelvermelho');
		                errosform++;
		            }

		            // Código segurança cartão de crédito
		            if (FormCheckout.cardCVC.value.length <= 2){
		                $("input[name='cardCVC']").focus();
		                $('#cardCVC').addClass('bordavermelha');
		                $("#ErrocardCVC").show();
		                $('#cardCVCL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardCVC').removeClass('bordavermelha');
		                $("#ErrocardCVC").hide();
		                $('#cardCVCL').removeClass('labelvermelho');
		            }

		            // Nome cartão de crédito
		            var c = document.forms['FormCheckout'].elements['creditCardHolderName'].value;
		            var separado = c.split(" ");
		            if ((document.forms["FormCheckout"]["creditCardHolderName"].value < 1) ||
		                (separado.length <= 1)){
		                $("input[name='creditCardHolderName']").focus();
		                $('#creditCardHolderName').addClass('bordavermelha');
		                $("#ErrocreditCardHolderName").show();
		                $('#creditCardHolderNameL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#creditCardHolderName').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderName").hide();
		                $('#creditCardHolderNameL').removeClass('labelvermelho');
		            }

		            // Ano de válidade
		            var mydate = new Date();
		            var year   = mydate.getFullYear();
		            var year = year.toString();
		            year = year.substring(2,4);
		            if ((FormCheckout.cardExpiryY.value.length <= 1) || (FormCheckout.cardExpiryY.value < year) ){
		                $("input[name='cardExpiryY']").focus();
		                $('#cardExpiryY').addClass('bordavermelha');
		                $("#ErrocardExpiryY").show();
		                $('#cardExpiryML').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardExpiryY').removeClass('bordavermelha');
		                $("#ErrocardExpiryY").hide();
		                $('#cardExpiryML').removeClass('labelvermelho');
		            }

		            // Mês de válidade
		            var mesLimite = "12";
		            if ((FormCheckout.cardExpiryM.value.length <= 1) || (FormCheckout.cardExpiryM.value > mesLimite) || (FormCheckout.cardExpiryM.value == "00") ){
		                $("input[name='cardExpiryM']").focus();
		                $('#cardExpiryM').addClass('bordavermelha');
		                $("#ErrocardExpiryM").show();
		                $('#cardExpiryML').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardExpiryM').removeClass('bordavermelha');
		                $("#ErrocardExpiryM").hide();
		                $('#cardExpiryML').removeClass('labelvermelho');
		            }

		            // Número Cartão
		            if (FormCheckout.cardNumber.value.length <= 18){
		                $("input[name='cardNumber']").focus();
		                $('#cardNumber').addClass('bordavermelha');
		                $("#ErrocardNumber").show();
		                $('#cardNumberL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardNumber').removeClass('bordavermelha');
		                $("#ErrocardNumber").hide();
		                $('#cardNumberL').removeClass('labelvermelho');
		            }

		            // Estados
		            if (FormCheckout.State.value.length <= 1){    
		                $("input[name='State']").focus();
		                $('#State').addClass('bordavermelha');
		                $("#ErroState").show();
		                $('#StateL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#State').removeClass('bordavermelha');
		                $("#ErroState").hide();
		                $('#StateL').removeClass('labelvermelho');
		            }

		            // Cidade
		            if (document.forms["FormCheckout"]["City"].value == ""){
		                $("input[name='City']").focus();
		                $('#City').addClass('bordavermelha');
		                $("#ErroCity").show();
		                $('#CityL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#City').removeClass('bordavermelha');
		                $("#ErroCity").hide();
		                $('#CityL').removeClass('labelvermelho');
		            }

		            // Bairro
		            if (document.forms["FormCheckout"]["District"].value == ""){
		                $("input[name='District']").focus();
		                $('#District').addClass('bordavermelha');
		                $("#ErroDistrict").show();
		                $('#DistrictL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#District').removeClass('bordavermelha');
		                $("#ErroDistrict").hide();
		                $('#DistrictL').removeClass('labelvermelho');
		            }

		            // Número
		            if (document.forms["FormCheckout"]["numBer"].value == ""){
		                $("input[name='numBer']").focus();
		                $('#numBer').addClass('bordavermelha');
		                $("#ErronumBer").show();
		                $('#NumberL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#numBer').removeClass('bordavermelha');
		                $("#ErronumBer").hide();
		                $('#NumberL').removeClass('labelvermelho');
		            }

		            // Rua
		            if (document.forms["FormCheckout"]["Street"].value == ""){
		                $("input[name='Street']").focus();
		                $('#Street').addClass('bordavermelha');
		                $("#ErroStreet").show();
		                $('#StreetL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#Street').removeClass('bordavermelha');
		                $("#ErroStreet").hide();
		                $('#StreetL').removeClass('labelvermelho');
		            }

		            // CEP
		            var cep = FormCheckout.PostalCode.value;
		            if ((document.forms["FormCheckout"]["PostalCode"].value == "") ||
		                (cep.length <=8)) {
		                $("input[name='PostalCode']").focus();
		                $('#PostalCode').addClass('bordavermelha');
		                $("#ErroPostalCode").show();
		                errosform++;
		            } else {
		                $('#PostalCode').removeClass('bordavermelha');
		                $("#ErroPostalCode").hide();
		            }

		            // Email
		            usuario = FormCheckout.senderEmail.value.substring(0, FormCheckout.senderEmail.value.indexOf("@"));
		            dominio = FormCheckout.senderEmail.value.substring(FormCheckout.senderEmail.value.indexOf("@") + 1, FormCheckout.senderEmail.value.length);
		            if ((usuario.length >=1) &&
		                (dominio.length >=3) && 
		                (usuario.search("@")==-1) && 
		                (dominio.search("@")==-1) &&
		                (usuario.search(" ")==-1) && 
		                (dominio.search(" ")==-1) &&
		                (dominio.search(".")!=-1) &&      
		                (dominio.indexOf(".") >=1)&& 
		                (dominio.lastIndexOf(".") < dominio.length - 1)) {
		                // document.getElementById("msgemail").innerHTML="E-mail válido";
		                // alert("email valido");
		                $('#senderEmail').removeClass('bordavermelha');
		                $('#mail').removeClass('labelvermelho');
		                $("#ErrosenderEmail").hide();
		            } else {
		                $("input[name='senderEmail']").focus();
		                $('#senderEmail').addClass('bordavermelha');
		                $('#mail').addClass('labelvermelho');
		                $("#ErrosenderEmail").show();
		                errosform++;
		            }

		            if (errosform == 0) {
		       
		                var param = {
		                    cardNumber: $("input[name='cardNumber']").val().replace(/ /g,''),
		                    brand: $("input[name='brand']").val(),
		                    cvv: $("input[name='cardCVC']").val(),
		                    expirationMonth: $("input[name='cardExpiryM']").val(),
		                    expirationYear: '20' + $("input[name='cardExpiryY']").val(),
		                    success: function(json){
		                        preloader();
		                        var token = json.card.token;
		                        $("input[name='token']").val(token);
		                        console.log("Token: " + token);
		                        var senderHash = PagSeguroDirectPayment.getSenderHash();
		                        $("input[name='senderHash']").val(senderHash);
		                        var enviarCartao = 'enviarCartao';
		                        var emaildocliente = "<?php echo $email; ?>";
		                        $("input[name='emaildocliente']").val(emaildocliente);
		                        $("input[name='Cartao']").val(enviarCartao);
		                        document.getElementById("FormCheckout").submit();
		                    }, error: function(json){
		                        console.log(json);
		                        // alert ('Por favor, confira se os dados informados para o cartão de crédito estão corretos para prosseguir com o pagamento.');
		                        $("input[name='cardNumber']").focus();
		                        $('#cardNumber').addClass('bordavermelha');
		                        $("#ErrocardNumber").show();
		                        $('#cardNumberL').addClass('labelvermelho');
		                        errosform++;
		                    }, complete:function(json){
		                    }
		                }

		                PagSeguroDirectPayment.createCardToken(param);
		            } else {
		            	$("#carregandoPagSeguro").hide();
		            	alert ('Por favor, confira se os dados informados para o cartão de crédito estão corretos e as parcelas.');
		            }
		        });
	    		$("#enviarDebito").click(function(){

			        $("#carregandoDebito").show();
			        var errosform = 0;

			        var tel = document.forms['FormCheckout'].elements['telefoneD'].value.replace('-','');
			        tel = tel.substring(0,1); //intervalo de caracteres prentendido, no caso pega o 1º valor
			        // Verificar se o numero é menor que 9, ou se falta o 9 no inicio do telefone.
			        if ((FormCheckout.telefoneD.value.length <= 9) || (/[0-8]/.test(tel)) ) {
			            $("input[name='telefoneD']").focus();
			            $('#telefoneD').addClass('bordavermelha');
			            $("#EtelefoneD").show();
			            errosform++;
			        } else {
			            $('#telefoneD').removeClass('bordavermelha');
			            $("#EtelefoneD").hide();
			        }

			        if (FormCheckout.senderAreaCodeD.value.length <= 1){
			            $("input[name='senderAreaCodeD']").focus();
			            $('#senderAreaCodeD').addClass('bordavermelha');
			            $("#EsenderAreaCodeD").show();
			            errosform++;
			        } else {
			            $('#senderAreaCodeD').removeClass('bordavermelha');
			            $("#EsenderAreaCodeD").hide();
			        }
			        var AreaCode = document.forms['FormCheckout'].elements['senderAreaCodeD'].value;
			        var validaAreaCode = /[1-9][1-9]/;
			        if(validaAreaCode.test(AreaCode)) {
			            $('#senderAreaCodeD').removeClass('bordavermelha');
			            $("#EsenderAreaCodeD").hide();
			        } else {
			            $("input[name='senderAreaCodeD']").focus();
			            $('#senderAreaCodeD').addClass('bordavermelha');
			            $("#EsenderAreaCodeD").show();
			            errosform++;
			        }

			        var strCPF = FormCheckout.senderCPFD.value;
			        strCPF = strCPF.replace(/[ÀÁÂÃÄÅ]/g,"A");
			        strCPF = strCPF.replace(/[àáâãäå]/g,"a");
			        strCPF = strCPF.replace(/[ÈÉÊË]/g,"E");
			        strCPF = strCPF.replace(/[^a-z0-9]/gi,'');
			        if (TestaCPF(strCPF)) {
			            $('#senderCPFD').removeClass('bordavermelha');
			            $("#EsenderCPFD").hide();
			        } else {
			            $("input[name='senderCPFD']").focus();
			            $('#senderCPFD').addClass('bordavermelha');
			            $("#EsenderCPFD").show();
			            errosform++;
			        }

			        var cd = document.forms['FormCheckout'].elements['senderNameD'].value;
			        var separadod = cd.split(" ");
			        if ((document.forms["FormCheckout"]["senderNameD"].value < 1) ||
			            (separadod.length <= 1)){
			            $("input[name='senderNameD']").focus();
			            $('#senderNameD').addClass('bordavermelha');
			            $("#EsenderNameD").show();
			            errosform++;
			        } else {
			            $('#senderNameD').removeClass('bordavermelha');
			            $("#EsenderNameD").hide();
			        }

			        // Estados
			        if (FormCheckout.State.value.length <= 1){    
			            $("input[name='State']").focus();
			            $('#State').addClass('bordavermelha');
			            $("#ErroState").show();
			            $('#StateL').addClass('labelvermelho');
			            errosform++;
			        } else {
			            $('#State').removeClass('bordavermelha');
			            $("#ErroState").hide();
			            $('#StateL').removeClass('labelvermelho');
			        }

			        // Cidade
			        if (document.forms["FormCheckout"]["City"].value == ""){
			            $("input[name='City']").focus();
			            $('#City').addClass('bordavermelha');
			            $("#ErroCity").show();
			            $('#CityL').addClass('labelvermelho');
			            errosform++;
			        } else {
			            $('#City').removeClass('bordavermelha');
			            $("#ErroCity").hide();
			            $('#CityL').removeClass('labelvermelho');
			        }

			        // Bairro
			        if (document.forms["FormCheckout"]["District"].value == ""){
			            $("input[name='District']").focus();
			            $('#District').addClass('bordavermelha');
			            $("#ErroDistrict").show();
			            $('#DistrictL').addClass('labelvermelho');
			            errosform++;
			        } else {
			            $('#District').removeClass('bordavermelha');
			            $("#ErroDistrict").hide();
			            $('#DistrictL').removeClass('labelvermelho');
			        }

			        // Número
			        if (document.forms["FormCheckout"]["numBer"].value == ""){
			            $("input[name='numBer']").focus();
			            $('#numBer').addClass('bordavermelha');
			            $("#ErronumBer").show();
			            $('#NumberL').addClass('labelvermelho');
			            errosform++;
			        } else {
			            $('#numBer').removeClass('bordavermelha');
			            $("#ErronumBer").hide();
			            $('#NumberL').removeClass('labelvermelho');
			        }

			        // Rua
			        if (document.forms["FormCheckout"]["Street"].value == ""){
			            $("input[name='Street']").focus();
			            $('#Street').addClass('bordavermelha');
			            $("#ErroStreet").show();
			            $('#StreetL').addClass('labelvermelho');
			            errosform++;
			        } else {
			            $('#Street').removeClass('bordavermelha');
			            $("#ErroStreet").hide();
			            $('#StreetL').removeClass('labelvermelho');
			        }

			        // CEP
			        var cep = FormCheckout.PostalCode.value;
			        if ((document.forms["FormCheckout"]["PostalCode"].value == "") ||
			            (cep.length <=8)) {
			            $("input[name='PostalCode']").focus();
			            $('#PostalCode').addClass('bordavermelha');
			            $("#ErroPostalCode").show();
			            $('#PostalCodeL').addClass('labelvermelho');
			            errosform++;
			        } else {
			            $('#PostalCode').removeClass('bordavermelha');
			            $("#ErroPostalCode").hide();
			            $('#PostalCodeL').removeClass('labelvermelho');
			        }

			        // Email
			        usuario = FormCheckout.senderEmail.value.substring(0, FormCheckout.senderEmail.value.indexOf("@"));
			        dominio = FormCheckout.senderEmail.value.substring(FormCheckout.senderEmail.value.indexOf("@") + 1, FormCheckout.senderEmail.value.length);
			        if ((usuario.length >=1) &&
			            (dominio.length >=3) && 
			            (usuario.search("@")==-1) && 
			            (dominio.search("@")==-1) &&
			            (usuario.search(" ")==-1) && 
			            (dominio.search(" ")==-1) &&
			            (dominio.search(".")!=-1) &&      
			            (dominio.indexOf(".") >=1)&& 
			            (dominio.lastIndexOf(".") < dominio.length - 1)) {
			            $('#senderEmail').removeClass('bordavermelha');
			            $('#mail').removeClass('labelvermelho');
			            $("#ErrosenderEmail").hide();
			        } else {
			            $("input[name='senderEmail']").focus();
			            $('#senderEmail').addClass('bordavermelha');
			            $('#mail').addClass('labelvermelho');
			            $("#ErrosenderEmail").show();
			            errosform++;
			        }

			        if (errosform == 0) {
			            PagSeguroDirectPayment.onSenderHashReady(function(response){
			                if(response.status == 'error') {
			                    console.log(response.message);
			                    return false;
			                }
			                var hash = response.senderHash; //Hash estará disponível nesta variável.
			                // var senderHash = PagSeguroDirectPayment.getSenderHash();
			                $("input[name='senderHash']").val(hash);
			                var enviarDebito = 'enviarDebito';
			                $("input[name='Debito']").val(enviarDebito);
			                document.getElementById("FormCheckout").submit();
			            });
			        } else {
		            	$("#carregandoDebito").hide();
		            }
			    });
				$("#enviarBoleto").click(function(){

			        $("#carregandoBoleto").show();
			        var errosform = 0;

			        var tel = document.forms['FormCheckout'].elements['telefone'].value.replace('-','');
			        tel = tel.substring(0,1); //intervalo de caracteres prentendido, no caso pega o 1º valor
			        // Verificar se o numero é menor que 9, ou se falta o 9 no inicio do telefone.
			        if ((FormCheckout.telefone.value.length <= 9) || (/[0-8]/.test(tel)) ) {
			            $("input[name='telefone']").focus();
			            $('#telefone').addClass('bordavermelha');
			            $("#Etelefone").show();
			            errosform++;
			        } else {
			            $('#telefone').removeClass('bordavermelha');
			            $("#Etelefone").hide();
			        }

			        if (FormCheckout.senderAreaCode.value.length <= 1){
			            $("input[name='senderAreaCode']").focus();
			            $('#senderAreaCode').addClass('bordavermelha');
			            $("#EsenderAreaCode").show();
			            errosform++;
			        } else {
			            $('#senderAreaCode').removeClass('bordavermelha');
			            $("#EsenderAreaCode").hide();
			        }
			        var AreaCode = document.forms['FormCheckout'].elements['senderAreaCode'].value;
			        var validaAreaCode = /[1-9][1-9]/;
			        if(validaAreaCode.test(AreaCode)) {
			            $('#senderAreaCode').removeClass('bordavermelha');
			            $("#EsenderAreaCode").hide();
			        } else {
			            $("input[name='senderAreaCode']").focus();
			            $('#senderAreaCode').addClass('bordavermelha');
			            $("#EsenderAreaCode").show();
			            errosform++;
			        }

			        var strCPF = FormCheckout.senderCPF.value;
			        strCPF = strCPF.replace(/[ÀÁÂÃÄÅ]/g,"A");
			        strCPF = strCPF.replace(/[àáâãäå]/g,"a");
			        strCPF = strCPF.replace(/[ÈÉÊË]/g,"E");
			        strCPF = strCPF.replace(/[^a-z0-9]/gi,'');
			        if (TestaCPF(strCPF)) {
			            $('#senderCPF').removeClass('bordavermelha');
			            $("#EsenderCPF").hide();
			        } else {
			            $("input[name='senderCPF']").focus();
			            $('#senderCPF').addClass('bordavermelha');
			            $("#EsenderCPF").show();
			            errosform++;
			        }

			        var cd = document.forms['FormCheckout'].elements['senderName'].value;
			        var separadod = cd.split(" ");
			        if ((document.forms["FormCheckout"]["senderName"].value < 1) ||
			            (separadod.length <= 1)){
			            $("input[name='senderName']").focus();
			            $('#senderName').addClass('bordavermelha');
			            $("#EsenderName").show();
			            errosform++;
			        } else {
			            $('#senderName').removeClass('bordavermelha');
			            $("#EsenderName").hide();
			        }

			        // Email
			        usuario = FormCheckout.senderEmail.value.substring(0, FormCheckout.senderEmail.value.indexOf("@"));
			        dominio = FormCheckout.senderEmail.value.substring(FormCheckout.senderEmail.value.indexOf("@") + 1, FormCheckout.senderEmail.value.length);
			        if ((usuario.length >=1) &&
			            (dominio.length >=3) && 
			            (usuario.search("@")==-1) && 
			            (dominio.search("@")==-1) &&
			            (usuario.search(" ")==-1) && 
			            (dominio.search(" ")==-1) &&
			            (dominio.search(".")!=-1) &&      
			            (dominio.indexOf(".") >=1)&& 
			            (dominio.lastIndexOf(".") < dominio.length - 1)) {
			            // document.getElementById("msgemail").innerHTML="E-mail válido";
			            // alert("email valido");
			            $('#senderEmail').removeClass('bordavermelha');
			            $('#mail').removeClass('labelvermelho');
			            $("#ErrosenderEmail").hide();
			        } else {
			            $("input[name='senderEmail']").focus();
			            $('#senderEmail').addClass('bordavermelha');
			            $('#mail').addClass('labelvermelho');
			            $("#ErrosenderEmail").show();
			            errosform++;
			        }

					// Estados
		            if (FormCheckout.State.value.length <= 1){    
		                $("input[name='State']").focus();
		                $('#State').addClass('bordavermelha');
		                $("#ErroState").show();
		                $('#StateL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#State').removeClass('bordavermelha');
		                $("#ErroState").hide();
		                $('#StateL').removeClass('labelvermelho');
		            }

		            // Cidade
		            if (document.forms["FormCheckout"]["City"].value == ""){
		                $("input[name='City']").focus();
		                $('#City').addClass('bordavermelha');
		                $("#ErroCity").show();
		                $('#CityL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#City').removeClass('bordavermelha');
		                $("#ErroCity").hide();
		                $('#CityL').removeClass('labelvermelho');
		            }

		            // Bairro
		            if (document.forms["FormCheckout"]["District"].value == ""){
		                $("input[name='District']").focus();
		                $('#District').addClass('bordavermelha');
		                $("#ErroDistrict").show();
		                $('#DistrictL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#District').removeClass('bordavermelha');
		                $("#ErroDistrict").hide();
		                $('#DistrictL').removeClass('labelvermelho');
		            }

		            // Número
		            if (document.forms["FormCheckout"]["numBer"].value == ""){
		                $("input[name='numBer']").focus();
		                $('#numBer').addClass('bordavermelha');
		                $("#ErronumBer").show();
		                $('#NumberL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#numBer').removeClass('bordavermelha');
		                $("#ErronumBer").hide();
		                $('#NumberL').removeClass('labelvermelho');
		            }

		            // Rua
		            if (document.forms["FormCheckout"]["Street"].value == ""){
		                $("input[name='Street']").focus();
		                $('#Street').addClass('bordavermelha');
		                $("#ErroStreet").show();
		                $('#StreetL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#Street').removeClass('bordavermelha');
		                $("#ErroStreet").hide();
		                $('#StreetL').removeClass('labelvermelho');
		            }

		            // CEP
		            var cep = FormCheckout.PostalCode.value;
		            if ((document.forms["FormCheckout"]["PostalCode"].value == "") ||
		                (cep.length <=8)) {
		                $("input[name='PostalCode']").focus();
		                $('#PostalCode').addClass('bordavermelha');
		                $("#ErroPostalCode").show();
		                errosform++;
		            } else {
		                $('#PostalCode').removeClass('bordavermelha');
		                $("#ErroPostalCode").hide();
		            }

			        if (errosform == 0){
			            preloaderTres();
						var senderHash = PagSeguroDirectPayment.getSenderHash();
            			$("input[name='senderHash']").val(senderHash);
			            var enviarBoleto = 'enviarBoleto';
			            $("input[name='Boleto']").val(enviarBoleto);
			            document.getElementById("FormCheckout").submit();
			        } else {
		            	$("#carregandoBoleto").hide();
		            }
			    });
			    $("#enviarDeposito").click(function(){

			        $("#carregandoDeposito").show();
			        var errosform = 0;

			        // Banco
			        if (document.forms["FormCheckout"]["banco"].value == ""){
			            $("input[name='banco']").focus();
						$('#bancozeroL').addClass('labelvermelho');
			            $('#bancoumL').addClass('labelvermelho');
			            $('#bancodoisL').addClass('labelvermelho');
			            $('#bancotresL').addClass('labelvermelho');
			            $('#bancoquatroL').addClass('labelvermelho');
						$('#bancocincoL').addClass('labelvermelho');
						$('#bancoseisL').addClass('labelvermelho');
			            $("#Errobanco").show();
			            errosform++;
			        } else {
						$('#bancozeroL').removeClass('labelvermelho');
			            $('#bancoumL').removeClass('labelvermelho');
			            $('#bancodoisL').removeClass('labelvermelho');
			            $('#bancotresL').removeClass('labelvermelho');
			            $('#bancoquatroL').removeClass('labelvermelho');
						$('#bancocincoL').removeClass('labelvermelho');
						$('#bancoseisL').removeClass('labelvermelho');
			            $("#Errobanco").hide();
			        }

			        // Email
			        usuario = FormCheckout.senderEmail.value.substring(0, FormCheckout.senderEmail.value.indexOf("@"));
			        dominio = FormCheckout.senderEmail.value.substring(FormCheckout.senderEmail.value.indexOf("@") + 1, FormCheckout.senderEmail.value.length);
			        if ((usuario.length >=1) &&
			            (dominio.length >=3) && 
			            (usuario.search("@")==-1) && 
			            (dominio.search("@")==-1) &&
			            (usuario.search(" ")==-1) && 
			            (dominio.search(" ")==-1) &&
			            (dominio.search(".")!=-1) &&      
			            (dominio.indexOf(".") >=1)&& 
			            (dominio.lastIndexOf(".") < dominio.length - 1)) {
			            // document.getElementById("msgemail").innerHTML="E-mail válido";
			            // alert("email valido");
			            $('#senderEmail').removeClass('bordavermelha');
			            $('#mail').removeClass('labelvermelho');
			            $("#ErrosenderEmail").hide();
			        } else {
			            $("input[name='senderEmail']").focus();
			            $('#senderEmail').addClass('bordavermelha');
			            $('#mail').addClass('labelvermelho');
			            $("#ErrosenderEmail").show();
			            errosform++;
			        }

			        if (errosform == 0){
			            var enviarDeposito = 'enviarDeposito';
			            $("input[name='Deposito']").val(enviarDeposito);
			            document.getElementById("FormCheckout").submit();
			        } else {
		            	$("#carregandoDeposito").hide();
		            }
			    });
	    		$("#enviarCartaoGE").click(function(){

		            $("#carregandoGE").show();
		            var errosform = 0;

		            // Cliente vai usar outros dados pessoais diferente do cartão
		            var DadosPessoaisDoisChek = document.forms['FormCheckout'].elements['DadosPessoaisDoisChekGE'].value;
		            if (DadosPessoaisDoisChek == 'nao'){

		                var cx = document.forms['FormCheckout'].elements['senderNamexxGE'].value;
		                var separadox = cx.split(" ");

		                if (FormCheckout.senderPhonexxGE.value.length <= 8){
		                    $("input[name='senderPhonexxGE']").focus();
		                    $('#senderPhonexxGE').addClass('bordavermelha');
		                    $("#EsenderPhonexxGE").show();
		                    errosform++;
		                } else {
		                    $('#senderPhonexxGE').removeClass('bordavermelha');
		                    $("#EsenderPhonexxGE").hide();
		                }

		                if (FormCheckout.senderAreaCodexxGE.value.length <= 1){
		                    $("input[name='senderAreaCodexx']").focus();
		                    $('#senderAreaCodexxGE').addClass('bordavermelha');
		                    $("#EsenderAreaCodexxGE").show();
		                    errosform++;
		                } else {
		                    $('#senderAreaCodexxGE').removeClass('bordavermelha');
		                    $("#EsenderAreaCodexxGE").hide();
		                }

		                if (FormCheckout.senderCPFxxGE.value.length <= 13){
		                    $("input[name='senderCPFxxGE']").focus();
		                    $('#senderCPFxxGE').addClass('bordavermelha');
		                    $("#EsenderCPFxxGE").show();
		                    errosform++;
		                } else {
		                    $('#senderCPFxxGE').removeClass('bordavermelha');
		                    $("#EsenderCPFxxGE").hide();
		                }

		                if ((document.forms["FormCheckout"]["senderNamexxGE"].value < 1) ||
		                    (separadox.length <= 1)){
		                    $("input[name='senderNamexxGE']").focus();
		                    $('#senderNamexxGE').addClass('bordavermelha');
		                    $("#EsenderNamexxGE").show();
		                    errosform++;
		                } else {
		                    $('#senderNamexxGE').removeClass('bordavermelha');
		                    $("#EsenderNamexxGE").hide();
		                }
		            }

		            // Cliente vai usar outros dados de endereço para a fatura do cartão
		            var UsarMesmoEndCard = document.forms['FormCheckout'].elements['UsarMesmoEndCardGE'].value;
		            if (UsarMesmoEndCard == 'nao'){

		                if (FormCheckout.billingAddressStatexGE.value.length <= 1){    
		                    $("input[name='billingAddressStateGE']").focus();
		                    $('#billingAddressStatexGE').addClass('bordavermelha');
		                    $("#EbillingAddressStatexGE").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressStatexGE').removeClass('bordavermelha');
		                    $("#EbillingAddressStatexGE").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressCityxGE"].value == ""){
		                    $("input[name='billingAddressCityGE']").focus();
		                    $('#billingAddressCityxGE').addClass('bordavermelha');
		                    $("#EbillingAddressCityxGE").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressCityxGE').removeClass('bordavermelha');
		                    $("#EbillingAddressCityxGE").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressDistrictxGE"].value == ""){
		                    $("input[name='billingAddressDistrictGE']").focus();
		                    $('#billingAddressDistrictxGE').addClass('bordavermelha');
		                    $("#EbillingAddressDistrictxGE").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressDistrictxGE').removeClass('bordavermelha');
		                    $("#EbillingAddressDistrictxGE").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressNumberxGE"].value == ""){
		                    $("input[name='billingAddressNumberGE']").focus();
		                    $('#billingAddressNumberxGE').addClass('bordavermelha');
		                    $("#EbillingAddressNumberxGE").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressNumberxGE').removeClass('bordavermelha');
		                    $("#EbillingAddressNumberxGE").hide();
		                }

		                if (document.forms["FormCheckout"]["billingAddressStreetxGE"].value == ""){
		                    $("input[name='billingAddressStreetGE']").focus();
		                    $('#billingAddressStreetxGE').addClass('bordavermelha');
		                    $("#EbillingAddressStreetxGE").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressStreetxGE').removeClass('bordavermelha');
		                    $("#EbillingAddressStreetxGE").hide();
		                }

		                var cepx = FormCheckout.billingAddressPostalCodexGE.value;
		                if ((document.forms["FormCheckout"]["billingAddressPostalCodexGE"].value == "") ||
		                    (cepx.length <=8)) {
		                    $("input[name='billingAddressPostalCodeGE']").focus();
		                    $('#billingAddressPostalCodexGE').addClass('bordavermelha');
		                    $("#EbillingAddressPostalCodexGE").show();
		                    errosform++;
		                } else {
		                    $('#billingAddressPostalCodexGE').removeClass('bordavermelha');
		                    $("#EbillingAddressPostalCodexGE").hide();
		                }
		            }

		            // Data de nascimento cartão de crédito
		            var stringData = FormCheckout.creditCardHolderBirthDateGE.value;
		            if (validaData(stringData)) {
		                $('#creditCardHolderBirthDateGE').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderBirthDateGE").hide();
		                $('#creditCardHolderBirthDateLGE').removeClass('labelvermelho');

		            } else {
		                $("input[name='creditCardHolderBirthDateGE']").focus();
		                $('#creditCardHolderBirthDateGE').addClass('bordavermelha');
		                $("#ErrocreditCardHolderBirthDateGE").show();
		                $('#creditCardHolderBirthDateLGE').addClass('labelvermelho');
		                errosform++;
		            }

		            // Celular cartão de crédito
		            var tel = document.forms['FormCheckout'].elements['creditCardHolderPhoneGE'].value.replace('-','');
		            tel = tel.substring(0,1); //intervalo de caracteres prentendido, no caso pega o 1º valor
		            // Verificar se o numero é menor que 9, ou se falta o 9 no inicio do telefone.
		            if ((FormCheckout.creditCardHolderPhoneGE.value.length <= 9) || (/[0-8]/.test(tel)) ) {
		                $("input[name='creditCardHolderPhoneGE']").focus();
		                $('#creditCardHolderPhoneGE').addClass('bordavermelha');
		                $("#ErrocreditCardHolderPhoneGE").show();
		                $('#creditCardHolderPhoneLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#creditCardHolderPhoneGE').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderPhoneGE").hide();
		                $('#creditCardHolderPhoneLGE').removeClass('labelvermelho');
		            }

		            // Código de área telefone cartão de crédito
		            if (FormCheckout.creditCardHolderAreaCodeGE.value.length <= 1){
		                $("input[name='creditCardHolderAreaCodeGE']").focus();
		                $('#creditCardHolderAreaCodeGE').addClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCodeGE").show();
		                $('#creditCardHolderPhoneLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#creditCardHolderAreaCodeGE').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCodeGE").hide();
		                $('#creditCardHolderPhoneLGE').removeClass('labelvermelho');
		            }
		            var AreaCode = document.forms['FormCheckout'].elements['creditCardHolderAreaCodeGE'].value;
		            //Expressão regular para validar o AreaCode.
		            var validaAreaCode = /[1-9][1-9]/;
		            //Valida o formato da AreaCode.
		            if(validaAreaCode.test(AreaCode)) {
		                $('#creditCardHolderAreaCodeGE').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCodeGE").hide();
		                $('#creditCardHolderPhoneLGE').removeClass('labelvermelho');
		            } else {
		                $("input[name='creditCardHolderAreaCodeGE']").focus();
		                $('#creditCardHolderAreaCodeGE').addClass('bordavermelha');
		                $("#ErrocreditCardHolderAreaCodeGE").show();
		                $('#creditCardHolderPhoneLGE').addClass('labelvermelho');
		                errosform++;
		            }

		            // CPF cartão de crédito
		            var strCPF = FormCheckout.creditCardHolderCPFGE.value;
		            strCPF = strCPF.replace(/[ÀÁÂÃÄÅ]/g,"A");
		            strCPF = strCPF.replace(/[àáâãäå]/g,"a");
		            strCPF = strCPF.replace(/[ÈÉÊË]/g,"E");
		            strCPF = strCPF.replace(/[^a-z0-9]/gi,'');
		            if (TestaCPF(strCPF)) {
		                $('#creditCardHolderCPFGE').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderCPFGE").hide();
		                $('#creditCardHolderCPFLGE').removeClass('labelvermelho');

		            } else {
		                $("input[name='creditCardHolderCPFGE']").focus();
		                $('#creditCardHolderCPFGE').addClass('bordavermelha');
		                $("#ErrocreditCardHolderCPFGE").show();
		                $('#creditCardHolderCPFLGE').addClass('labelvermelho');
		                errosform++;
		            }

		            // Código segurança cartão de crédito
		            if (FormCheckout.cardCVCGE.value.length <= 2){
		                $("input[name='cardCVCGE']").focus();
		                $('#cardCVCGE').addClass('bordavermelha');
		                $("#ErrocardCVCGE").show();
		                $('#cardCVCLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardCVCGE').removeClass('bordavermelha');
		                $("#ErrocardCVCGE").hide();
		                $('#cardCVCLGE').removeClass('labelvermelho');
		            }

		            // Nome cartão de crédito
		            var c = document.forms['FormCheckout'].elements['creditCardHolderNameGE'].value;
		            var separado = c.split(" ");
		            if ((document.forms["FormCheckout"]["creditCardHolderNameGE"].value < 1) ||
		                (separado.length <= 1)){
		                $("input[name='creditCardHolderNameGE']").focus();
		                $('#creditCardHolderNameGE').addClass('bordavermelha');
		                $("#ErrocreditCardHolderNameGE").show();
		                $('#creditCardHolderNameLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#creditCardHolderNameGE').removeClass('bordavermelha');
		                $("#ErrocreditCardHolderNameGE").hide();
		                $('#creditCardHolderNameLGE').removeClass('labelvermelho');
		            }

		            // Ano de válidade
		            var mydate = new Date();
		            var year   = mydate.getFullYear();
		            var year = year.toString();
		            year = year.substring(2,4);
		            if ((FormCheckout.cardExpiryYGE.value.length <= 1) || (FormCheckout.cardExpiryYGE.value < year) ){
		                $("input[name='cardExpiryYGE']").focus();
		                $('#cardExpiryYGE').addClass('bordavermelha');
		                $("#ErrocardExpiryYGE").show();
		                $('#cardExpiryMLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardExpiryYGE').removeClass('bordavermelha');
		                $("#ErrocardExpiryYGE").hide();
		                $('#cardExpiryMLGE').removeClass('labelvermelho');
		            }

		            // Mês de válidade
		            var mesLimite = "12";
		            if ((FormCheckout.cardExpiryMGE.value.length <= 1) || (FormCheckout.cardExpiryMGE.value > mesLimite) || (FormCheckout.cardExpiryMGE.value == "00") ){
		                $("input[name='cardExpiryMGE']").focus();
		                $('#cardExpiryMGE').addClass('bordavermelha');
		                $("#ErrocardExpiryMGE").show();
		                $('#cardExpiryMLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardExpiryMGE').removeClass('bordavermelha');
		                $("#ErrocardExpiryMGE").hide();
		                $('#cardExpiryMLGE').removeClass('labelvermelho');
		            }

		            // Bandeira do Cartão
		            var creditCardBrandGe = document.forms['FormCheckout'].elements['creditCardBrandtabGE'].value;
		            if (creditCardBrandGe == "") {
		                $('#creditCardBrandtabGEL').addClass('labelvermelho');
		            	$('#creditCardBrandtabGEL').focus();
		                $("#ErrocreditCardBrandtabGE").show();
		            	errosform++;
		            } else {
		                $('#creditCardBrandtabGEL').removeClass('labelvermelho');
		                $("#ErrocreditCardBrandtabGE").hide();
		            }
 
		            // Número Cartão
		            if (FormCheckout.cardNumberGE.value.length <= 18){
		                $("input[name='cardNumberGE']").focus();
		                $('#cardNumberGE').addClass('bordavermelha');
		                $("#ErrocardNumberGE").show();
		                $('#cardNumberLGE').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#cardNumberGE').removeClass('bordavermelha');
		                $("#ErrocardNumberGE").hide();
		                $('#cardNumberLGE').removeClass('labelvermelho');
		            }

		            // Bandeira Cartão
					var creditCardBrand = $("input[name='creditCardBrand']:checked").val();
		            if (creditCardBrand){
		                $("#ErrocreditCardBrand").hide();
		                $('#creditCardBrandML').removeClass('labelvermelho');
		            } else {
		                $("input[name='creditCardBrand']").focus();
		                $("#ErrocreditCardBrand").show();
		                $('#creditCardBrandML').addClass('labelvermelho');
		                errosform++;
		            }

		            // Estados
		            if (FormCheckout.State.value.length <= 1){    
		                $("input[name='State']").focus();
		                $('#State').addClass('bordavermelha');
		                $("#ErroState").show();
		                $('#StateL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#State').removeClass('bordavermelha');
		                $("#ErroState").hide();
		                $('#StateL').removeClass('labelvermelho');
		            }

		            // Cidade
		            if (document.forms["FormCheckout"]["City"].value == ""){
		                $("input[name='City']").focus();
		                $('#City').addClass('bordavermelha');
		                $("#ErroCity").show();
		                $('#CityL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#City').removeClass('bordavermelha');
		                $("#ErroCity").hide();
		                $('#CityL').removeClass('labelvermelho');
		            }

		            // Bairro
		            if (document.forms["FormCheckout"]["District"].value == ""){
		                $("input[name='District']").focus();
		                $('#District').addClass('bordavermelha');
		                $("#ErroDistrict").show();
		                $('#DistrictL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#District').removeClass('bordavermelha');
		                $("#ErroDistrict").hide();
		                $('#DistrictL').removeClass('labelvermelho');
		            }

		            // Número
		            if (document.forms["FormCheckout"]["numBer"].value == ""){
		                $("input[name='numBer']").focus();
		                $('#numBer').addClass('bordavermelha');
		                $("#ErronumBer").show();
		                $('#NumberL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#numBer').removeClass('bordavermelha');
		                $("#ErronumBer").hide();
		                $('#NumberL').removeClass('labelvermelho');
		            }

		            // Rua
		            if (document.forms["FormCheckout"]["Street"].value == ""){
		                $("input[name='Street']").focus();
		                $('#Street').addClass('bordavermelha');
		                $("#ErroStreet").show();
		                $('#StreetL').addClass('labelvermelho');
		                errosform++;
		            } else {
		                $('#Street').removeClass('bordavermelha');
		                $("#ErroStreet").hide();
		                $('#StreetL').removeClass('labelvermelho');
		            }

		            // CEP
		            var cep = FormCheckout.PostalCode.value;
		            if ((document.forms["FormCheckout"]["PostalCode"].value == "") ||
		                (cep.length <=8)) {
		                $("input[name='PostalCode']").focus();
		                $('#PostalCode').addClass('bordavermelha');
		                $("#ErroPostalCode").show();
		                errosform++;
		            } else {
		                $('#PostalCode').removeClass('bordavermelha');
		                $("#ErroPostalCode").hide();
		            }

		            // Email
		            usuario = FormCheckout.senderEmail.value.substring(0, FormCheckout.senderEmail.value.indexOf("@"));
		            dominio = FormCheckout.senderEmail.value.substring(FormCheckout.senderEmail.value.indexOf("@") + 1, FormCheckout.senderEmail.value.length);
		            if ((usuario.length >=1) &&
		                (dominio.length >=3) && 
		                (usuario.search("@")==-1) && 
		                (dominio.search("@")==-1) &&
		                (usuario.search(" ")==-1) && 
		                (dominio.search(" ")==-1) &&
		                (dominio.search(".")!=-1) &&      
		                (dominio.indexOf(".") >=1)&& 
		                (dominio.lastIndexOf(".") < dominio.length - 1)) {
		                $('#senderEmail').removeClass('bordavermelha');
		                $('#mail').removeClass('labelvermelho');
		                $("#ErrosenderEmail").hide();
		            } else {
		                $("input[name='senderEmail']").focus();
		                $('#senderEmail').addClass('bordavermelha');
		                $('#mail').addClass('labelvermelho');
		                $("#ErrosenderEmail").show();
		                errosform++;
		            }

		            if (errosform == 0){

		            	// Gerencianet cartão de crédito
			        	// Obtendo um "payment_token" ( getPaymentToken )
			        	// Produção
        				var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://api.gerencianet.com.br/v1/cdn/78224a5aaf400e5440e15bc38ed49988/'+v;s.async=false;s.id='78224a5aaf400e5440e15bc38ed49988';if(!document.getElementById('78224a5aaf400e5440e15bc38ed49988')){document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn){$gn.done=fn;}};

        				// Sandbox
        				//var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://sandbox.gerencianet.com.br/v1/cdn/78224a5aaf400e5440e15bc38ed49988/'+v;s.async=false;s.id='78224a5aaf400e5440e15bc38ed49988';if(!document.getElementById('78224a5aaf400e5440e15bc38ed49988')){document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn){$gn.done=fn;}};

		                var cardNumberGe = document.forms["FormCheckout"]["cardNumberGE"].value;
		                var creditCardBrandGe = document.forms['FormCheckout'].elements['creditCardBrandtabGE'].value;
		                var cardCVCGe = document.forms["FormCheckout"]["cardCVCGE"].value;
		                var cardExpiryMGe = document.forms["FormCheckout"]["cardExpiryMGE"].value;
		                var cardExpiryYGe = document.forms["FormCheckout"]["cardExpiryYGE"].value;

			            $gn.ready(function(checkout) {
			              var callback = function(error, response) {
			                if(error) {
			                  	// Trata o erro ocorrido
			                  	console.log("aqui1");
			                  	console.error(error);
			                } else {
			                  	// Trata a resposta
			                  	console.log(response);
			                  	var tokenGE = response.data.payment_token;
							  	$("input[name='tokenGE']").val(tokenGE);

							  	// ok submete
							  	var enviarCartaoGE = 'enviarCartaoGE';
			                    var emaildocliente = "<?php echo $email; ?>";
			                    $("input[name='emaildocliente']").val(emaildocliente);
			                    $("input[name='CartaoGE']").val(enviarCartaoGE);
			                    document.getElementById("FormCheckout").submit();
			                }
			              };
			              checkout.getPaymentToken({
			                brand: creditCardBrandGe, // bandeira do cartão
			                number: cardNumberGe, // número do cartão
			                cvv: cardCVCGe, // código de segurança
			                expiration_month: cardExpiryMGe, // mês de vencimento
			                expiration_year: '20' + cardExpiryYGe // ano de vencimento
			              }, callback);
			            });

		            } else {
		            	$("#carregandoGE").hide();
		            }
		        });
	    		$("#enviarPix").click(function(){

			        $("#carregandoPix").show();
			        var errosform = 0;

			        // Email
			        usuario = FormCheckout.senderEmail.value.substring(0, FormCheckout.senderEmail.value.indexOf("@"));
			        dominio = FormCheckout.senderEmail.value.substring(FormCheckout.senderEmail.value.indexOf("@") + 1, FormCheckout.senderEmail.value.length);
			        if ((usuario.length >=1) &&
			            (dominio.length >=3) && 
			            (usuario.search("@")==-1) && 
			            (dominio.search("@")==-1) &&
			            (usuario.search(" ")==-1) && 
			            (dominio.search(" ")==-1) &&
			            (dominio.search(".")!=-1) &&      
			            (dominio.indexOf(".") >=1)&& 
			            (dominio.lastIndexOf(".") < dominio.length - 1)) {
			            // document.getElementById("msgemail").innerHTML="E-mail válido";
			            // alert("email valido");
			            $('#senderEmail').removeClass('bordavermelha');
			            $('#mail').removeClass('labelvermelho');
			            $("#ErrosenderEmail").hide();
			        } else {
			            $("input[name='senderEmail']").focus();
			            $('#senderEmail').addClass('bordavermelha');
			            $('#mail').addClass('labelvermelho');
			            $("#ErrosenderEmail").show();
			            errosform++;
			        }

			        if (errosform == 0){
			            var enviarPix = 'enviarPix';
			            $("input[name='Pix']").val(enviarPix);
			            document.getElementById("FormCheckout").submit();
			        } else {
		            	$("#carregandoPix").hide();
		            }
			    });
		        function validacaoEmail(field) {
		          usuario = field.value.substring(0, field.value.indexOf("@"));
		          dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
		          if ((usuario.length >=1) && //Tamanho de usuário maior ou igual a 1 caracter.
		              (dominio.length >=3) && //Tamanho do domínio maior ou igual a 3 caracteres.
		              (usuario.search("@")==-1) && //Usuário não pode conter o @.
		              (dominio.search("@")==-1) && //Domínio não pode conter o @.
		              (usuario.search(" ")==-1) && //Usuário não pode conter o “ ” espaço em branco.
		              (dominio.search(" ")==-1) && //Domínio não pode conter o “ ” espaço em branco.
		              (dominio.search(".")!=-1) && //Domínio tem que possuir “.” Ponto.   
		              (dominio.indexOf(".")>=1)&& //
		              (dominio.lastIndexOf(".") < dominio.length - 1)) { //A posição do primeiro ponto tem que ser maior ou igual a 1, lembrando a posição 0 deve ser ocupado por algum caracter após o @. A posição do ultimo ponto tem que ser menor que o ultimo caracter, deve ser finalizado o domínio por um caracter.
		              // alert("E-mail valido");
		              $("#senderEmail").removeClass('labelvermelho');
		              // $("#senderEmail").addClass('bordaverde');
		              $("#ErrosenderEmail").hide();
		          } else {
		              // alert("E-mail inválido");
		              $("#ErrosenderEmail").show();
		              $("#senderEmail").addClass('labelvermelho');
		              $("#senderEmail").focus();
		          }
		        }
		        function validacaoNumber(numBer) {

		            numBer = numBer.trim();
		            
		            if (numBer.length <= 0){
		                $("#ErronumBer").show();
		                // $("#numBer").removeClass('bordaverde');
		                $("#numBer").addClass('labelvermelho');
		                $("#ErronumBer").hide();
		                $("#numBer").focus();
		            } else {
		                $("#numBer").removeClass('labelvermelho');
		                $("#informeocep").hide();
		                $("#ErronumBer").hide();
		                // document.title = "Cartão de Crédito";
		                $("#checkadress").hide();
		            }
		        }
		        function preloader(){
		            $("#preloader").show();
		        }
		        function preloaderDois(){
		            $("#preloaderDois").show();
		        }
		        function preloaderTres(){
		            $("#preloaderTres").show();
		        }
		        function OpPagCard(){
		            $("#OpPagCard").show();
		            $("#cardNumber").focus();
		        }
		        function OpPagDebito(){
		            $("#OpPagDebito").show();
		        }
		        function OpPagBoleto(){
		            $("#OpPagBoleto").show();
		        }
		        function OpenEndCard(){
		            $("#EndCardUm").show();
		            $("#EndCardDois").hide();
		        }
		        function CloseEndCard(){
		            $("#EndCardUm").hide();
		            $("#EndCardDois").show();
		        }
		        function OpenDadosPessoaisDois(){
		            $("#DadosPessoaisDois").show();
		        }
		        function CloseDadosPessoaisDois(){
		            $("#DadosPessoaisDois").hide();
		        }
		        function LimpaBordaVermelha($this){
		            var id = $this;
		            $(document.getElementById(id)).removeClass('bordavermelha');
		            $(document.getElementById(id+"L")).removeClass('labelvermelho');
		            $(document.getElementById("Erro"+id)).hide();
		            $(document.getElementById("E"+id)).hide();
		            $(document.getElementById("NaoEncontrado")).hide();
		        }
		        function TestaCPF(strCPF) {
		            var Soma;
		            var Resto;
		            Soma = 0;
		            if (strCPF == "00000000000") return false;
		            
		            for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
		            Resto = (Soma * 10) % 11;
		            
		            if ((Resto == 10) || (Resto == 11))  Resto = 0;
		            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
		            
		            Soma = 0;
		            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
		            Resto = (Soma * 10) % 11;
		            
		            if ((Resto == 10) || (Resto == 11))  Resto = 0;
		            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
		            return true;
		        }
		        function validaData(stringData) {
		            /******** VALIDA DATA NO FORMATO DD/MM/AAAA *******/

		            var regExpCaracter = /[^\d]/;     //Expressão regular para procurar caracter não-numérico.
		            var regExpEspaco = /^\s+|\s+$/g;  //Expressão regular para retirar espaços em branco.

		            if(stringData.length != 10)
		            {
		               // alert('Data fora do padrão DD/MM/AAAA');
		               return false;
		            }

		            splitData = stringData.split('/');

		            if(splitData.length != 3)
		            {
		               // alert('Data fora do padrão DD/MM/AAAA');
		               return false;
		            }

		            /* Retira os espaços em branco do início e fim de cada string. */
		            splitData[0] = splitData[0].replace(regExpEspaco, '');
		            splitData[1] = splitData[1].replace(regExpEspaco, '');
		            splitData[2] = splitData[2].replace(regExpEspaco, '');

		            if ((splitData[0].length != 2) || (splitData[1].length != 2) || (splitData[2].length != 4))
		            {
		               // alert('Data fora do padrão DD/MM/AAAA');
		               return false;
		            }

		            /* Procura por caracter não-numérico. EX.: o "x" em "28/09/2x11" */
		            if (regExpCaracter.test(splitData[0]) || regExpCaracter.test(splitData[1]) || regExpCaracter.test(splitData[2]))
		            {
		               alert('Caracter inválido encontrado na Data de Nascimento!');
		               return false;
		            }

		            dia = parseInt(splitData[0],10);
		            mes = parseInt(splitData[1],10)-1; //O JavaScript representa o mês de 0 a 11 (0->janeiro, 1->fevereiro... 11->dezembro)
		            ano = parseInt(splitData[2],10);

		            var novaData = new Date(ano, mes, dia);

		            /* O JavaScript aceita criar datas com, por exemplo, mês=14, porém a cada 12 meses mais um ano é acrescentado à data
		                final e o restante representa o mês. O mesmo ocorre para os dias, sendo maior que o número de dias do mês em
		                questão o JavaScript o converterá para meses/anos.
		                Por exemplo, a data 28/14/2011 (que seria o comando "new Date(2011,13,28)", pois o mês é representado de 0 a 11)
		                o JavaScript converterá para 28/02/2012.
		                Dessa forma, se o dia, mês ou ano da data resultante do comando "new Date()" for diferente do dia, mês e ano da
		                data que está sendo testada esta data é inválida. */
		            if ((novaData.getDate() != dia) || (novaData.getMonth() != mes) || (novaData.getFullYear() != ano))
		            {
		               // alert('Data Inválida!');
		               return false;
		            }
		            else
		            {
		               // alert('Data OK!');
		               return true;
		            }
		        }
		        // Preenchimento automático do CEP
		        function pesquisacep(valor) {

		            $("#PostalCode").removeClass('labelvermelho');
		            $("#ErronumBer").show();
		            $("#informeocep").hide();
		            $("#checkadress").show();

		            if (FormCheckout.PostalCode.value.length < 9){
		        
		            } else {
		                //Nova variável "cep" somente com dígitos.
		                var cep = valor.replace(/\D/g, '');

		                //Expressão regular para validar o CEP.
		                var validacep = /^[0-9]{8}$/;

		                //Valida o formato do CEP.
		                if(validacep.test(cep)) {

		                    //Cria um elemento javascript.
		                    var script = document.createElement('script');

		                    //Sincroniza com o callback.
		                    // script.src = 'http://www.viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
		                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

		                    //Insere script no documento e carrega o conteúdo.
		                    document.body.appendChild(script);
		                    // $("#PostalCode").addClass('bordaverde');
		                    $("#numBer").addClass('labelvermelho');
		                    $("#ErronumBer").show();
		                    $('#numBer').focus();

		                //end if.
		                } else {
		                    //cep é inválido.
		                    limpa_formulario_cep();
		                    alert("Formato de CEP inválido.");
		                }
		            }
		        }
		        function limpa_formulario_cep() {
		                // CEP encontrado, colocando dados
		                document.getElementById('Street').value=("");
		                document.getElementById('District').value=("");
		                document.getElementById('City').value=("");
		                document.getElementById('State').value=("");
		                $("#informeocep").hide();
		                $('#Street').focus();
		        }
		        function meu_callback(conteudo) {
		            if (!("erro" in conteudo)) {
		                //Atualiza os campos com os valores.
		                document.getElementById('Street').value=(conteudo.logradouro);
		                $('#Street').removeClass('bordavermelha');
		                $("#ErroStreet").hide();
		                $('#StreetL').removeClass('labelvermelho');

		                document.getElementById('District').value=(conteudo.bairro);
		                $('#District').removeClass('bordavermelha');
		                $("#ErroDistrict").hide();
		                $('#DistrictL').removeClass('labelvermelho');

		                document.getElementById('City').value=(conteudo.localidade);
		                $('#City').removeClass('bordavermelha');
		                $("#ErroCity").hide();
		                $('#CityL').removeClass('labelvermelho');

		                document.getElementById('State').value=(conteudo.uf);
		                $('#State').removeClass('bordavermelha');
		                $("#ErroState").hide();
		                $('#StateL').removeClass('labelvermelho');

		                $('#numBer').focus();
		                $('#numBer').removeClass('bordavermelha');
		                $("#ErronumBer").show();
		                $('#NumberL').removeClass('labelvermelho');
		                // Atualiza no endereço da fatura do cartão
		                $("input[id='billingAddressStreet']").val(conteudo.logradouro);
		                $("input[id='billingAddressDistrict']").val(conteudo.bairro);
		                $("input[id='billingAddressPostalCode']").val(conteudo.cep);
		                $("input[id='billingAddressCity']").val(conteudo.localidade);
		                $("input[id='billingAddressState']").val(conteudo.uf);
		            } //end if.
		            else {
		                //CEP não Encontrado.
		                limpa_formulario_cep();
		                // alert("CEP não encontrado.");
		                $("input[name='PostalCode']").focus();
		                // $("#PostalCode").removeClass('bordaverde');
		                $('#PostalCode').addClass('bordavermelha');
		                $("#NaoEncontrado").show();
		            }
		        }
		        // Preenchimento automático do CEP DOIS #####################
		        function pesquisacepDois(valor) {

		            if (FormCheckout.billingAddressPostalCodex.value.length < 9){
		        
		            } else {
		                //Nova variável "cep" somente com dígitos.
		                var cep = valor.replace(/\D/g, '');

		                //Expressão regular para validar o CEP.
		                var validacep = /^[0-9]{8}$/;

		                //Valida o formato do CEP.
		                if(validacep.test(cep)) {

		                    //Cria um elemento javascript.
		                    var script = document.createElement('script');

		                    //Sincroniza com o callback.
		                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callbackDois';

		                    //Insere script no documento e carrega o conteúdo.
		                    document.body.appendChild(script);
		                    $("#EndDois").show();
		                    $('#billingAddressStreetx').focus();

		                } //end if.
		                else {
		                    //cep é inválido.
		                    limpa_formulario_cepDois();
		                    alert("Formato de CEP inválido.");
		                    $('#billingAddressPostalCodex').focus();
		                }
		            }
		        }
		        function limpa_formulario_cepDois() {
		                //Limpa valores do formulário de cep.
		                document.getElementById('billingAddressStreetx').value=("");
		                document.getElementById('billingAddressDistrictx').value=("");
		                document.getElementById('billingAddressCityx').value=("");
		                document.getElementById('billingAddressStatex').value=("");
		                $("#EndDois").show();
		                $('#billingAddressStreetx').focus();
		        }
		        function meu_callbackDois(conteudo) {
		            if (!("erro" in conteudo)) {
		                //Atualiza os campos com os valores.
		                document.getElementById('billingAddressStreetx').value=(conteudo.logradouro);
		                document.getElementById('billingAddressDistrictx').value=(conteudo.bairro);
		                document.getElementById('billingAddressCityx').value=(conteudo.localidade);
		                document.getElementById('billingAddressStatex').value=(conteudo.uf);
		                $("#EndDois").show();
		                $('#billingAddressNumberx').focus();
		            } //end if.
		            else {
		                //CEP não Encontrado.
		                limpa_formulario_cepDois();
		                // alert("CEP não encontrado.");
		                $('#billingAddressStreetx').focus();
		                $('#billingAddressPostalCodex').addClass('bordavermelha');
		                $("#NaoEncontrado").show();
		                $("#EndDois").show();
		            }
		        }
		        // Preenchimento automático do CEP DOIS #####################
		        
		        // Cartão Gerencianet
		        // Preenchimento automático do CEP GE #####################
		        function pesquisacepDoisGE(valor) {

		            if (FormCheckout.billingAddressPostalCodexGE.value.length < 9){
		        
		            } else {
		                //Nova variável "cep" somente com dígitos.
		                var cepGE = valor.replace(/\D/g, '');

		                //Expressão regular para validar o CEP.
		                var validacepGE = /^[0-9]{8}$/;

		                //Valida o formato do CEP.
		                if(validacepGE.test(cepGE)) {

		                    //Cria um elemento javascript.
		                    var script = document.createElement('script');

		                    //Sincroniza com o callback.
		                    script.src = 'https://viacep.com.br/ws/'+ cepGE + '/json/?callback=meu_callbackDoisGE';

		                    //Insere script no documento e carrega o conteúdo.
		                    document.body.appendChild(script);
		                    $("#EndDoisGE").show();
		                    $('#billingAddressStreetxGE').focus();

		                } //end if.
		                else {
		                    //cep é inválido.
		                    limpa_formulario_cepDoisGE();
		                    alert("Formato de CEP inválido.");
		                    $('#billingAddressPostalCodexGE').focus();
		                }
		            }
		        }
		        function limpa_formulario_cepDoisGE() {
		                //Limpa valores do formulário de cep.
		                document.getElementById('billingAddressStreetxGE').value=("");
		                document.getElementById('billingAddressDistrictxGE').value=("");
		                document.getElementById('billingAddressCityxGE').value=("");
		                document.getElementById('billingAddressStatexGE').value=("");
		                $("#EndDoisGE").show();
		                $('#billingAddressStreetxGE').focus();
		        }
		        function meu_callbackDoisGE(conteudo) {
		            if (!("erro" in conteudo)) {
		                //Atualiza os campos com os valores.
		                document.getElementById('billingAddressStreetxGE').value=(conteudo.logradouro);
		                document.getElementById('billingAddressDistrictxGE').value=(conteudo.bairro);
		                document.getElementById('billingAddressCityxGE').value=(conteudo.localidade);
		                document.getElementById('billingAddressStatexGE').value=(conteudo.uf);
		                $("#EndDoisGE").show();
		                $('#billingAddressNumberxGE').focus();
		            } //end if.
		            else {
		                //CEP não Encontrado.
		                limpa_formulario_cepDoisGE();
		                // alert("CEP não encontrado.");
		                $('#billingAddressStreetxGE').focus();
		                $('#billingAddressPostalCodexGE').addClass('bordavermelha');
		                $("#NaoEncontradoGE").show();
		                $("#EndDoisGE").show();
		            }
		        }
		        // Preenchimento automático do CEP GE #####################
		        function OpenDadosPessoaisDoisGE(){
		            $("#DadosPessoaisDoisGE").show();
		        }
		        function CloseDadosPessoaisDoisGE(){
		            $("#DadosPessoaisDoisGE").hide();
		        }
		        function OpenEndCardGE(){
		            $("#EndCardUmGE").show();
		            $("#EndCardDoisGE").hide();
		        }
		        function CloseEndCardGE(){
		            $("#EndCardUmGE").hide();
		            $("#EndCardDoisGE").show();
		        }
		        function OpPagCardGE(){
		            $("#OpPagCardGE").show();
		            $("#cardNumberGE").focus();
		        }
		        // Paypal *****************************************************
			    paypal.Button.render({
			        env: 'production', // sandbox | production | sandbox (alexandre.rodrigues.sp-buyer@hotmail.com - grupoacggrupoacg)
			        // PayPal Client IDs - replace with your own
			        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
			        client: {
			            sandbox:    'AXNrc5cQ0d6YifxqoVehfDrY6TdEsoAB6Lr5we3NVv50i3OBVsxLE1cRxZ8UmL2I5PtwUpNtoY2s4frp',
			            production: 'Ac_wgBlOF054zfMJ0k_epF9zKVYX1I8mQ743kbvSaK41RTVjadX-h3JIEXsq7vyiLbB3B3kGFa8ZwoX4'
			        },
			        locale: 'pt_BR',
			        style: {
			          size: 'responsive',
			          color: 'gold',
			          shape: 'rect',
			          label: 'checkout',
			          tagline: 'true'
			        },
			        // Show the buyer a 'Pay Now' button in the checkout flow
			        commit: true,
			        // payment() is called when the button is clicked
			        payment: function(data, actions) {
			            // Make a call to the REST api to create the payment
			            return actions.payment.create({
			                payment: {
			                    transactions: [
			                        {
			                            amount: {
			                                total: '<?php echo $valor; ?>', 
			                                currency: 'BRL' 
			                            },
			                            description: "<?php echo $demonstrativo; ?>",
			                            invoice_number: '<?php echo $ref; ?>' //Insert a unique invoice number
			                        }
			                    ]
			                }
			            });
			        },
			        // SUCESSO
			        onAuthorize: function (data, actions) {

						// Set up the data you need to pass to your server
						var paymentID = data.paymentID;
						// console.log(paymentID);
						$.post('https://www.epapodetarot.com.br/checkout/add_credit_paypal.php',
						{
							ref: '<?php echo $ref; ?>',
							paymentIDRegister: '1',
							paymentID: paymentID
						}, 
						function(retorno){
							$("#retorno_sucesso_paypal").html(retorno);
						});

			            // Get the payment details
			            return actions.payment.get().then(function (paymentDetails) {
			                // Execute the payment
			                return actions.payment.execute().then(function () {
			                    // Show a success page to the buyer
			                    $.post('https://www.epapodetarot.com.br/checkout/add_credit_paypal.php',
			                    {
			                      usuario_id : '<?php echo $idclientesite; ?>',
			                      ref:         '<?php echo $ref; ?>',
			                      tipo:        '<?php echo $tipo; ?>',
			                      minutos:     '<?php echo $minutos; ?>',
			                      valor_plano: '<?php echo $valor; ?>'
			                    }, 
			                    function(retorno){
			                        $("#botao_do_paypal").hide();
			                        $("#retorno_sucesso_paypal").html(retorno);
			                    });
			                });
			            });
			        },
			        // ERRO
			        onError: function (err) {
			            // Show an error page here, when an error occurs
			            // Call your server to execute the payment
			            //console.log(err);
			            $.post('https://www.epapodetarot.com.br/checkout/add_credit_paypal.php',
			            {
			              ERRO    : 'ERRONOPAGAMENTO',
			              ErroCod : err
			            }, 
			            function(retorno){
			              $("#retorno_sucesso_paypal").html(retorno);
			            });
			            // Enviar cliente para página de erro.
			            document.location.href='<?php echo $urldacopra; ?>&msgpaypalerro=erro';
			        }
			    }, '#paypal-button-containerx');

			    // Copia QRCODEPIX
			    function CopiaQRCODE($this){
				    // Seleciona o conteúdo do input
			        $('input').select();
			        // Copia o conteudo selecionado
			        var copiar = document.execCommand('copy');
				    $("#QRCODEPIXCOPIADA").show();
		        }
		    </script>
		    <?php
		}
    	?>
		<!-- Checkout -->

		<!-- Sobre página ao topo -->
		<script>
		    $(document).ready(function(){
				$('#subir').click(function(){
					$('html,body').animate({scrollTop: 0},'slow');
				});
			});
		</script>

	    <!-- Chamada Chat -->
	    <script type="text/javascript">
			// Muda o Título da Página
			(function () {
			var original = document.title;
			var timeout;
			window.flashTitle = function (newMsg, howManyTimes) {
			    function step() {
			        document.title = (document.title == original) ? newMsg : original;
			        if (--howManyTimes > 0) {
			            timeout = setTimeout(step, 1000);
			        };
			    };
			    howManyTimes = parseInt(howManyTimes);
			    if (isNaN(howManyTimes)) {
			        howManyTimes = 5;
			    };
			    cancelFlashTitle(timeout);
			    step();
			};
			window.cancelFlashTitle = function () {
			    clearTimeout(timeout);
			    document.title = original;
			};
			}());
			// Sobre página ao topo
			function SobeaoTopo () {
			    $(document).ready(function() {
			       $('#subir').click(function(){ });
			          $('html, body').animate({scrollTop:0}, 'slow');
			      return false;
			     });
			};
		</script>

		<?php 
        // ###################################    WebSocket     ####################################################
		if ($usuario_nivel == 'ADMIN') {
		 	?>
		 	<script type="text/javascript">
            var conn = new WebSocket('wss://epapodetarot.com.br/wss87/NS');
            function StatusTarologoOnline() {
              $('#onlineVerificaion').removeClass('offline');
              $('#onlineVerificaion').addClass('online');
            }
            function StatusTarologoOffline() {
              $('#onlineVerificaion').removeClass('online');
              $('#onlineVerificaion').addClass('offline');
            }
            conn.onopen = function(e) {
              StatusTarologoOnline();
              console.log("Conexão estabelecida!");
            };
            conn.onclose = function(e) {
              StatusTarologoOffline();
              console.log("Conexão perdida!");
              conn.onopen();
            };
          	</script>
		 	<?php
		}  elseif ($usuario_nivel == 'TAROLOGO') {
			?>
			<!-- Conecta o tarólogo no servidor com WebSocket para escutar as chamadas e mostra o status da conexão -->
			<script type="text/javascript">
				// Id do usuário
				var meuid = "<?php echo $usuario_id; ?>";
				// Mostra icone online
				function StatusTarologoOnline() {
					$('#onlineVerificaion').removeClass('offline');
					$('#onlineVerificaion').addClass('online');
				}
				// Mostra icone offline
				function StatusTarologoOffline() {
					$('#onlineVerificaion').removeClass('online');
					$('#onlineVerificaion').addClass('offline');
				}
				// Conecta + Status + Mostra Chamada
				function CreateSocketWrapper(){
					// Conexão
					var conn = new WebSocket('wss://epapodetarot.com.br/wss87/NS');
					// Abre Conexão
					conn.onopen = function(e) {
						console.log("Connection established!!");
						StatusTarologoOnline();
					};
					// Fica Escutando
					conn.onmessage = function(e) {
						console.log("Connection Escutando!!");
						MostraAviso(e.data);
					};
					conn.onclose = function(e) {
						console.log("Connection close!!");
						StatusTarologoOffline();
            			setTimeout(function(){CreateSocketWrapper()}, 1000); // Executa depois 1 segundos
					};
				}
				function MostraAviso(data) {
					// Recebe o retorno da escuta
					console.log('MostraAviso');
					data = JSON.parse(data);
					var id_tarologo_chamada = data.id_tarologo;
					var tipo = data.tipo;
					// Se tiver chamada para o meu ID, mostra o aviso ao tarólogo
					if ((id_tarologo_chamada == meuid) && (tipo == 'iniciachat')) {
						// Verificar no banco "chamada_consulta", se existir, mostra mensagem de cliente chamando
						var intervalo = setInterval(function() {
							$.post('https://www.epapodetarot.com.br/area_tarologos/inicia_chat.php',
							{
								id_tarologo : meuid
							}, function(retorno){
								$("#verifica_chamada_cliente_tarologo").html(retorno);
							});
						}, 2000);
						// Sobe para o Topo
						SobeaoTopo ();
						// Muda Título no Navegador
						flashTitle("Cliente Chamando para Atendimento...", 100);
						// Notificações via windows - titulo, icone e texto para a notificação.
						var notificationChat = new Notification('Cliente Chamando!', {
							icon: 'https://www.epapodetarot.com.br/images/Logo-SiteP.png',
							body: "Iniciar Atendimento!",
							silent: true,
						});
						notificationChat.onclick = (e) => {
							e.preventDefault();
							window.focus();
							notification.close();
						};
						// Toca Música
						myAudio =  new  Audio ( 'https://www.epapodetarot.com.br/chat/newmsg.mp3' );  
						myAudio.addEventListener ( 'ended' ,  function ()  { 
							this.currentTime =  0 ; 
							this.play(); 
						},  false ); 
						var resp = myAudio.play();
						// Remove a mensagem de erro ao tocar o som por n interatividade do usuário
						if (resp!== undefined) {
							resp.then(_ => {
								// autoplay starts!
							}).catch(error => {
								// show error
							});
						}
					}
				}
				// Faz a conexão ao WebSocket
				var socket = CreateSocketWrapper();
		    </script>
			<?php
		}
		// ###################################    WebSocket     ####################################################
		?>

		<!-- Preloader -->
		<script type="text/javascript">
		    //<![CDATA[
		    // $(window).on('load', function () { // makes sure the whole site is loaded 
		    //     $('#preloader .inner').fadeOut(); // will first fade out the loading animation 
		    //     $('#preloader').delay(200).fadeOut('slow'); // will fade out the white DIV that covers the website. 
		    //     $('body').delay(200).css({'overflow': 'visible'});
		    // })
		    //]]>
	    </script>

		<!-- COOKIES -->
		<!-- https://cookieinfoscript.com/ -->
		<script async type="text/javascript" id="cookieinfo"
			src="//cookieinfoscript.com/js/cookieinfo.min.js"
			data-bg="#000"
			data-fg="#FFFFFF"
			data-link="#F1D600"
			data-cookie="CookieInfoScript"
			data-text-align="left"
			data-message="Usamos cookies para melhorar sua experiência. Continuando a visitar este site, você concorda com o nosso uso de cookies."
			data-moreinfo="https://www.epapodetarot.com.br/politica-de-privacidade-e-termos-de-uso"
			data-linkmsg="Mais Informações"
			data-close-text="Aceitar!">
		</script>

	</body>
</html>