<?php
///////////////////////////////////////////
// PAGSEGURO TRANSPARENTE - NOVA SYSTEMS //
///////////////////////////////////////////
// URL de Notificação: https://www.respostanascartas/admin/controle/retorno_pagseguro.php
    //Config SANDBOX or PRODUCTION environment
	$SANDBOX_ENVIRONMENT = false;
	// $SANDBOX_ENVIRONMENT = true;

	$PAGSEGURO_API_URL = 'https://ws.pagseguro.uol.com.br/v2';
	$PAGSEGURO_JS_URL = 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';

	$PAGSEGURO_EMAIL = 'epapodetarot@gmail.com';
	$PAGSEGURO_TOKEN = 'a6cd16a0-d451-41e7-8833-135eba83283393f726d44f12bb84fa9d253499f058b8d9a1-8336-4660-afe4-3b8faa3c4f44';
	$directpayment = '<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>';

	if($SANDBOX_ENVIRONMENT){
	    $PAGSEGURO_API_URL = 'https://ws.sandbox.pagseguro.uol.com.br/v2';
	    $PAGSEGURO_JS_URL = 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';
	    $PAGSEGURO_EMAIL = 'epapodetarot@gmail.com';
	    $PAGSEGURO_TOKEN = 'F5D7DB75D6DD4D6C99D46B365D7E8C84';
	    $directpayment = '<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>';
	}
?>