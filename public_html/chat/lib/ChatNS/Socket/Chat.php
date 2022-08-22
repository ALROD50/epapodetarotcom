<?php
    namespace Novasystemschat\Socket;

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;
    
    class Chat implements MessageComponentInterface {
        protected $clients;
    
        public function __construct() {
            $this->clients = new \SplObjectStorage;
        }
    
        public function onOpen(ConnectionInterface $conn) {
            // Store the new connection to send messages to later
            $this->clients->attach($conn);
    
            echo "New connection! ({$conn->resourceId})\n";
        }
    
        public function onMessage(ConnectionInterface $from, $msg) {

            // Geral
            $dataH = date('Y-m-d H:i:s');
            $data = json_decode($msg);
            $tipo = $data->tipo;

            // Do Chat
            $name = @$data->name;
            $mensagem = @$data->msg;
            $cod_sala = @$data->cod_sala;
            $id_cliente = @$data->id_cliente;
            $id_tarologo = @$data->id_tarologo;
            $escreveu = @$data->escreveu;

            if ($tipo=="chat") {
                // Execulta quando for consulta no chat em sala
                // Envia mensagem para todos conectados, se tiver 5 pessoas conectadas vai ser execultado 5 vezes.
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($msg);
                    }
                }
                // Grava no banco a mensagem apenas 1 vez
                $db = new \mysqli('localhost', 'epapodetarotcom_sistema', 'AZ4xGDcBI,Q+', 'epapodetarotcom_67674');
                # Aqui está o segredo do utf8
                $stmt = $db->prepare("INSERT INTO chat (
                    nome,
                    mensagem,
                    datahora,
                    cod_sala,
                    id_cliente,
                    id_tarologo,
                    escreveu
                ) VALUES (
                    '$name',
                    '$mensagem',
                    '$dataH',
                    '$cod_sala',
                    '$id_cliente',
                    '$id_tarologo',
                    '$escreveu'
                )");
                if ($stmt) {
                    $stmt->execute();
                    $stmt->close();
                    $db->close();
                    return true;
                } else {
                    return false;
                }
            } elseif ($tipo=="finalizavideochat") {
                // Execulta no monitoramento para o cliente saber se o chat acabou
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($msg);
                    }
                }
            } elseif ($tipo=="iniciachat") {
                // Execulta no monitoramento da chamada para a consulta
                // Envia o chamado para todos conectados, se tiver 5 pessoas conectadas vai ser execultado 5 vezes.
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($msg);
                    }
                }
            } elseif ($tipo=="digitando") {
                // Execulta no monitoramento do digitando para a consulta
                // Envia o chamado para todos conectados, se tiver 5 pessoas conectadas vai ser execultado 5 vezes.
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($msg);
                    }
                }
            } elseif ($tipo=="online") {
                // Execulta no monitoramento do websocket
                // Envia o chamado para todos conectados, se tiver 5 pessoas conectadas vai ser execultado 5 vezes.
                foreach ($this->clients as $client) {
                    if ($from == $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($msg);
                    }
                }
            }      
        }
    
        public function onClose(ConnectionInterface $conn) {
            // The connection is closed, remove it, as we can no longer send it messages
            $this->clients->detach($conn);
    
            echo "Connection {$conn->resourceId} has disconnected\n";
        }
    
        public function onError(ConnectionInterface $conn, \Exception $e) {
            echo "An error has occurred: {$e->getMessage()}\n";
    
            $conn->close();
        }
    }