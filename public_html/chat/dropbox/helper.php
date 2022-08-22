<?php

require_once __DIR__ . '/vendor/autoload.php';

if(!defined('DROPBOXBASEPATH')){
    define('DROPBOXBASEPATH', __DIR__);
}

if(!function_exists('get_dropbox_token')){
	function get_dropbox_token(){
	    return (new \Lidmo\Dropbox\Services\DropboxService())->getToken();
	}
}
