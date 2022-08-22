<?php 
    date_default_timezone_set('America/Sao_Paulo');
    # The maximum execution time, in seconds. If set to zero, no time limit is imposed.
    set_time_limit(0);
    # Make sure to keep alive the script when a client disconnect.
    ignore_user_abort(true);
    function curlExec($url, $post = NULL, array $header = array()){
        $ch = curl_init($url);
        
        // Para dizer ao Curl para nunca atingir o tempo limite quando uma transferência ainda está ativa, você deve definir CURLOPT_TIMEOUT para 0
        curl_setopt($ch, CURLOPT_TIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if(count($header) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if($post !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post, '', '&'));
        }
    
        // HTTPAUTH
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        // Ignore SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
?>