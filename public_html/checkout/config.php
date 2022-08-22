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

	$PAGSEGURO_EMAIL = 'senhorxssj58@hotmail.com';
	$PAGSEGURO_TOKEN = 'E01DC7CA3B454E6C9D081B165D8A9412';
	$directpayment = '<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>';

	if($SANDBOX_ENVIRONMENT){
	    $PAGSEGURO_API_URL = 'https://ws.sandbox.pagseguro.uol.com.br/v2';
	    $PAGSEGURO_JS_URL = 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';
	    $PAGSEGURO_EMAIL = 'senhorxssj58@hotmail.com';
	    $PAGSEGURO_TOKEN = 'F5D7DB75D6DD4D6C99D46B365D7E8C84';
	    $directpayment = '<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>';
	}
?>