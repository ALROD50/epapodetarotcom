<?php
/**
 * Configurações do projeto Pix
 */

//DADOS GERAIS DO PIX (DINÂMICO E ESTÁTICO)
@define('PIX_KEY','contato@tarotdehorus.com.br');
@define('PIX_MERCHANT_NAME','TarotdeHorus');
@define('PIX_MERCHANT_CITY','SAOPAULO');

//DADOS DA API PIX (DINÂMICO)
@define('API_PIX_URL','https://api-pix.gerencianet.com.br');
@define('API_PIX_CLIENT_ID','Client_Id_a47c179803948a92acdd1e50b8720365aef784f4');
@define('API_PIX_CLIENT_SECRET','Client_Secret_f651dc0222289653f83970c4bc435895dff671ab');
@define('API_PIX_CERTIFICATE',__DIR__.'/files/certificates/producao-252339-tarot-de-horus.pem');