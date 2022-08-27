<?php

/**
 * DropboxService.php
 * @author Lídmo <suporte@lidmo.com.br>
 */


class DropboxService extends \Prefab
{
    protected $logger;

    public function logger($message){
        if(!$this->logger){
            $this->logger = new Log('dropbox.log');
        }
        $this->logger->write($message);
    }

    public function auth(string $appId, string $appSecret)
    {
        try {
            return new \Stevenmaguire\OAuth2\Client\Provider\Dropbox([
                'clientId' => $appId,
                'clientSecret' => $appSecret
            ]);
        }catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            $this->logger(print_r($e, true));
            throw $e;
        }
    }
}
