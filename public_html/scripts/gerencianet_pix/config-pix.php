<?php
/**
 * Configurações do projeto Pix
 */

//DADOS GERAIS DO PIX (DINÂMICO E ESTÁTICO)
@define('PIX_KEY','epapodetarot@gmail.com');
@define('PIX_MERCHANT_NAME','EpapoDeTarot');
@define('PIX_MERCHANT_CITY','SAOPAULO');

//DADOS DA API PIX (DINÂMICO)
@define('API_PIX_URL','https://api-pix.gerencianet.com.br');
@define('API_PIX_CLIENT_ID','Client_Id_fbcb82e7fcec126e6bc7b1dc931932da525dfec2');
@define('API_PIX_CLIENT_SECRET','Client_Secret_d8a28ced55b957e006d6f9f1a164f8268a5ac2e1');
@define('API_PIX_CERTIFICATE',__DIR__.'/files/certificates/certificado.pem');