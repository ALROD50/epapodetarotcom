<?php

/**
 * DropboxService.php
 * @author Lídmo <suporte@lidmo.com.br>
 */
namespace Lidmo\Dropbox\Services;

use League\OAuth2\Client\Token\AccessToken;


class DropboxService
{
    const APP_ID = 'mt3k5g56doxytwn';
    const APP_SECRET = '3mbf682luybopke';
    const APP_FILE = DROPBOXBASEPATH . '/files/dropbox-oauth.json';
    protected $accessToken;

    public function __construct()
    {
        $data = $this->getJsonData();
        if(is_array($data)){
            $this->accessToken = new AccessToken($data);
        }
    }

    public function getToken(){
        if($this->accessToken->hasExpired()) {
            $this->regenerateToken();
        }
        return $this->accessToken->getToken();
    }

    protected function regenerateToken(): void
    {
        try{
            $provider = new \Stevenmaguire\OAuth2\Client\Provider\Dropbox([
                'clientId'          => self::APP_ID,
                'clientSecret'      => self::APP_SECRET,
            ]);
            $this->accessToken = $provider->getAccessToken('refresh_token', ['refresh_token' => $this->accessToken->getRefreshToken()]);
            $this->putJsonData($this->accessToken->jsonSerialize());
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            //
        }
    }

    private function getJsonData(){
        if(file_exists(self::APP_FILE)){
            return json_decode(file_get_contents(self::APP_FILE), true);
        }
        return null;
    }

    private function putJsonData(array $data): void
    {
        $jsonData = $this->getJsonData();
        if(is_array($jsonData)){
            $data = array_merge($jsonData, $data);
            unlink(self::APP_FILE);
        }
        $jsonData = json_encode($data);
        file_put_contents(self::APP_FILE, $jsonData);
    }
}
