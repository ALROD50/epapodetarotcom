<?php
/**
 * Configurações do projeto Pix
 */

//DADOS GERAIS DO PIX (DINÂMICO E ESTÁTICO)
@define('PIX_KEY','');
@define('PIX_MERCHANT_NAME','');
@define('PIX_MERCHANT_CITY','SAOPAULO');

//DADOS DA API PIX (DINÂMICO)
@define('API_PIX_URL','https://api-pix.gerencianet.com.br');
@define('API_PIX_CLIENT_ID','');
@define('API_PIX_CLIENT_SECRET','');
@define('API_PIX_CERTIFICATE',__DIR__.'/files/certificates/producao-252339-tarot-de-horus.pem');