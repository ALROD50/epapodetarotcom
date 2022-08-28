<?php
/**
 * index.php
 * @author Lídmo <suporte@lidmo.com.br>
 */

require __DIR__ . '/vendor/autoload.php';

$f3 = \Base::instance();

###     START CONFIG    ###
$f3->set('ENV.APP_URL', '/home/epapodetarotcom/public_html/chat/dropbox/dropbox-login/');
$f3->set('UI', 'app/views/');
$f3->set('LOGS', 'logs/');
$f3->set('DEBUG', 3);

// AUTOLOAD
$f3->set('AUTOLOAD', 'app/controllers/; app/services/');

// ROUTES
$f3->route('GET @index: /','AuthController->index');
$f3->route('POST @auth: /auth', 'AuthController->processAuth');
$f3->route('POST @generate: /generate', 'AuthController->processGenerate');


###     END CONFIG    ###

$f3->run();