//WebSocket
var conn = new WebSocket('wss://epapodetarot.com.br/wss87/NS'); 

///////////////////////////////////////////////
var form1 = document.getElementById('form1');
var inp_message = document.getElementById('message');
var inp_name = document.getElementById('name');
var btn_env = document.getElementById('btn1');
var area_content = document.getElementById('content');
var cod_sala = document.getElementById('cod_sala');
var id_cliente = document.getElementById('id_cliente');
var id_tarologo = document.getElementById('id_tarologo');
var escreveu = document.getElementById('escreveu');
///////////////////////////////////////////////

conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    // console.log(e.data);
    showMessages('other', e.data);
};

// Impede do ENTER submeter o formulário, e em vez disso aciona função EnviarMensagem
$(function(){
    var keyStop = {
        8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
        13: "input:text, input:password", // stop enter = submit 
        end: null
    };
    $(document).bind("keydown", function(event){
    var selector = keyStop[event.which];
    if(selector !== undefined && $(event.target).is(selector)) {
        EnviarMensagem(); // antes de impedir de submeter o form, aciona a função EnviarMensagem
        event.preventDefault(); //stop event
    }
    return true;
    });
});

// Ao clicar em Enviar assiona função EnviarMensagem
btn_env.addEventListener('click', function(){
   EnviarMensagem(); 
});
 
function EnviarMensagem(){
    if (inp_message.value != '') {

        // Mensagem
        var msg = {
            'tipo': 'chat',
            'name': inp_name.value, 
            'msg': inp_message.value,
            'cod_sala': cod_sala.value,
            'id_cliente': id_cliente.value,
            'id_tarologo': id_tarologo.value,
            'escreveu': escreveu.value
        };
        msg = JSON.stringify(msg);

        // Envia
        conn.send(msg);

        // Volta ponteiro na caixa de mensagem
        document.forms['form1'].message.focus();

        // Mostra as mensagens enviadas
        showMessages('me', msg);
        inp_message.value = '';
    }
};

// Essa função mostra as mensagens na tela, ela é execultada por todos os chats ao mesmo tempo conectados neste websocket
function showMessages(how, data) {

    // Auto-scroll before
    var oldscrollHeight = $("#content").attr("scrollHeight") - 20; //Scroll height before the request

    // Data
    data = JSON.parse(data);
    // console.log(data);

    // Código da sala, podem vir códigos de outros chats abertos
    var dataSala = data.cod_sala;

    // Tipo
    var tipo = data.tipo;

    // ID da Sala na URL
    // Array de parametros 'chave=valor'
    var params = window.location.search.substring(1).split('&');
    // Criar objeto que vai conter os parametros
    var paramArray = {};
    // Passar por todos os parametros
    for(var i=0; i<params.length; i++) {
        // Dividir os parametros chave e valor
        var param = params[i].split('=');
        // Adicionar ao objeto criado antes
        paramArray[param[0]] = param[1];
    }
    var salaIDurl = paramArray[param[0]] = param[1];

    if (tipo =='chat') {

        if (salaIDurl == dataSala) {

            // Cria a div da mensagem com a classe "me" ou "other"
            var div = document.createElement('div');
            div.setAttribute('class', how);

            // Cria uma div com a classe text
            var div_txt = document.createElement('div');
            div_txt.setAttribute('class', 'text');

            // Coloca o Nome dentro da tag h5
            var h5 = document.createElement('h5');
            h5.textContent = data.name;

            // Coloca a Mensagem dentro da tag p
            var p = document.createElement('p');
            p.textContent = h5.textContent + ': ' + data.msg;

            // Coloca as tag P e H5 dentro da div com a class text
            div_txt.appendChild(p);

            // Coloca a div com a classe TEXT dentro da div com as classes ME ou OTHER 
            div.appendChild(div_txt);

            // Imprimi
            area_content.appendChild(div);
        }

    } else if (tipo =='digitando') {

        if (salaIDurl == dataSala) {
            // Mostra o icone digitando
            $("#key").show();
            // Apaga após 5 segundos
            setTimeout(function() {
                $("#key").hide();
            }, 3000);
        }
    }

    //Auto-scroll after            
    var newscrollHeight = $("#content").attr("scrollHeight") - 20; //Scroll height after the request  
    if(newscrollHeight > oldscrollHeight){  
        $("#content").animate({ scrollTop: newscrollHeight }, 'slow'); //Autoscroll to bottom of div  
    }
}

// Digitando
document.querySelector('body').addEventListener('keydown', function(event) {
    var msg = {
        'tipo': 'digitando',
        'cod_sala': cod_sala.value
    };
    msg = JSON.stringify(msg);
    // Envia
    conn.send(msg);
});

function EncerrarChat(resultado){

    var resultado = resultado;
    var message = 'Atenção - A consulta foi finalizada, ' + inp_name.value + ' saiu da sala, clique no botão vermelho para Encerrar...';
    
    // Mensagem
    var msg = {
        'tipo': 'chat',
        'name': inp_name.value, 
        'msg': message,
        'cod_sala': cod_sala.value,
        'id_cliente': id_cliente.value,
        'id_tarologo': id_tarologo.value,
        'escreveu': escreveu.value
    };
    msg = JSON.stringify(msg);

    // Envia, o método abaixo espera até que a conexão com o websocket se estabeleça antes de enviar a mensagem
    conn.onopen = () => conn.send(msg);
    alert("Encerrando...");
    document.body.style.cursor = 'wait';

    // Espera 3 segundos antes de direcionar para dar tempo da mensagem ser enviada.
    setTimeout(function(){
        document.location.href="https://www.epapodetarot.com.br/chat/finalizar.php?tempo=" + resultado;
    }, 3000);
};