<?php
/**
 * helpers.php
 * @author Lídmo <suporte@lidmo.com.br>
 */

if(!function_exists('env')){
    function env(string $key, string $default = '')
    {
        $key = 'ENV.' . $key;
        return \Base::instance()->get($key) ?? $default;
    }
}

if(!function_exists('set_env')){
    function set_env(string $key, string $value)
    {
        $key = 'ENV.' . $key;
        \Base::instance()->set($key, $value);
    }
}

if(!function_exists('view')){
    function view(string $file, array $data = [], bool $echo = true){
        $view = \View::instance()->render($file, 'text/html', $data);
        if($echo){
            echo $view;
        }
        return $view;
    }
}

if(!function_exists('base_url')){
    function base_url(string $uri = ''){
        $url = rtrim(env('APP_URL', 'http://localhost'));
        $uri = ltrim($uri);
        return $url . '/' . $uri;
    }
}