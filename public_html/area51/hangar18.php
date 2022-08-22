<script type="text/javascript">
    // Conecta o tarólogo no servidor com WebSocket para escutar as chamadas
    var conn = new WebSocket('wss://tarotdehorus.com.br/wss2/wss2/NNN');
    var cod_sala = "1";
    // Abre Conexão
    conn.onopen = function(e) {
        console.log("Connection established!");
    };
    // Fica Escutando
    conn.onmessage = function(e) {
        console.log(e.data);
        MostraDepoimentos(e.data);
    };
    // Fecha Conexão
    conn.onclose = function(e) {
        console.log("Connection close!");
        conn.onopen();
    };
    function MostraDepoimentos(data) {
        // Recebe o retorno da escuta
        data = JSON.parse(data);
        var id_sala = data.id_sala;
        var tipo = data.tipo;
        // Se a videochamada tiver sido finalizada mostra a div de depoimentos e oculta a div do chat
        if ((id_sala == cod_sala) && (tipo == 'finalizavideochat')) {
            document.location.href='https://www.tarotdehorus.com.br/chat/depoimentos.php';
        }
    }
</script>