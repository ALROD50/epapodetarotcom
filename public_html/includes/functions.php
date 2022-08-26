<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
?>
<?php 
// Data completa, exemplo:  Quarta-Feira, 12 de Fevereiro de 2014
function DataCompleta() {
  // Data --
    $dia_ingles = date("l"); //vê o dia da semana em inglês

  switch($dia_ingles)
  //acha o dia da semana em português
  {
    case "Monday":
     $dia_port = "Segunda-Feira";
     break;
    case "Tuesday":
     $dia_port = "Terça-Feira";
     break;
    case "Wednesday":
     $dia_port = "Quarta-Feira";
     break;
    case "Thursday":
     $dia_port = "Quinta-Feira";
     break;
    case "Friday":
     $dia_port = "Sexta-Feira";
     break;
    case "Saturday":
     $dia_port = "Sábado";
     break;
    case "Sunday":
     $dia_port = "Domingo";
     break;
  }

  $mes_ingles = date("n"); // vê o mês em Inglês

  switch($mes_ingles)
  // acha o mês em português
  {
    case "1":
      $mes_port = "Janeiro";
      break;
    case "2":
      $mes_port = "Fevereiro";
      break;
    case "3":
      $mes_port = "Março";
      break;
    case "4":
      $mes_port = "Abril";
      break;
    case "5":
      $mes_port = "Maio";
      break;
    case "6":
      $mes_port = "Junho";
      break;
    case "7":
      $mes_port = "Julho";
      break;
    case "8":
      $mes_port = "Agosto";
      break;
    case "9":
      $mes_port = "Setembro";
      break;
    case "10":
      $mes_port = "Outubro";
      break;
    case "11":
      $mes_port = "Novembro";
      break;
    case "12":
     $mes_port = "Dezembro";
     break;
  }
  //Resultado
  echo ($dia_port);
  echo (", ");
  echo (date("d"));
  echo (" de ");
  echo ($mes_port);
  echo (" de ");
  echo (date("Y"));
}
// total de clientes
function TotalClientes ($conect=null) {
  require_once 'includes/conexaoPdo.php';
  $pdo = conexao();
$sql = $pdo->query("SELECT * FROM clientes WHERE nivel ='CLIENTE' "); 
$clientes_total = $sql->rowCount();
echo $clientes_total;
}

// total de clientes ativos
function TotalClientesAtivos ($conect) {
$sql = $conect->query("SELECT * FROM clientes WHERE status = 'ATIVO' ");
$clientes_total = $sql->rowCount();
echo $clientes_total;
}

// total de clientes inativos
function TotalClientesInativos ($conect) {
$sql = $conect->query("SELECT * FROM clientes WHERE status = 'INATIVO' "); 
$clientes_total = $sql->rowCount();
echo $clientes_total;
}

// total de clientes cancelados
function TotalClientesCancelados ($conect) {
$sql = $conect->query("SELECT * FROM clientes WHERE status = 'CANCELADO' "); 
$clientes_total = $sql->rowCount();
echo $clientes_total;
}

// total de clientes novos neste mês
function TotalClientesNovosNesteMes($conect) {
$datahoje = date("Y-m-d");
$data_dia = date("d");
$data_mes = date("m");
$data_ano = date("Y");
$sql = $conect->query("SELECT * FROM clientes WHERE nivel ='CLIENTE' AND data_registro BETWEEN '$data_ano-$data_mes-01' AND '$data_ano-$data_mes-31' "); 
$clientes_total = $sql->rowCount();
echo $clientes_total;
}

// limita caracteres
function limita_caracteres($texto, $limite, $quebra = true){
   $tamanho = strlen($texto);
   if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
      $novo_texto = $texto;
   }else{ // Se o tamanho do texto for maior que o limite
      if($quebra == true){ // Verifica a opção de quebrar o texto
         $novo_texto = trim(substr($texto, 0, $limite))."...";
      }else{ // Se não, corta $texto na última palavra antes do limite
         $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
         $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
      }
   }
   return $novo_texto; // Retorna o valor formatado
}

//Mostra o nome do mês
function MostraNomeDoMes ($mes){
  switch ($mes) {
    case '1':
      $mesatual_nome='Janeiro';
      break;
    case '2':
      $mesatual_nome='Fevereiro';
      break;
    case '3':
      $mesatual_nome='Março';
      break;
    case '4':
      $mesatual_nome='Abril';
      break;
    case '5':
      $mesatual_nome='Maio';
      break;
    case '6':
      $mesatual_nome='Junho';
      break;
    case '7':
      $mesatual_nome='Julho';
      break;
    case '8':
      $mesatual_nome='Agosto';
      break;
    case '9':
      $mesatual_nome='Setembro';
      break;
    case '10':
      $mesatual_nome='Outubro';
      break;
    case '11':
      $mesatual_nome='Novembro';
      break;
    case '12':
      $mesatual_nome='Dezembro';
      break;
    default:
      # code...
      break;
  }
   return $mesatual_nome; // Retorna o valor formatado
}

// Função Mostra Data Corretamente
function MostraDataCorretamenteHora ($data_correta_mostrar) {
  $new_data = date("d-m-Y H:i:s", strtotime("$data_correta_mostrar")); //Formatando para mostrar ao usuario.

  if ($new_data == "31-12-1969") {
    $new_data = "00-00-0000";
  } elseif ($new_data == "31-12-2069") {
    $new_data = "00-00-0000";
  } elseif ($new_data == "30-11--0001") {
    $new_data = "00-00-0000";
  }
  return $new_data;
}

// Função Mostra Data Corretamente
function MostraDataCorretamente ($data_correta_mostrar) {
  $new_data = date("d-m-Y", strtotime("$data_correta_mostrar")); //Formatando para mostrar ao usuario.

  if ($new_data == "31-12-1969") {
    $new_data = "00-00-0000";
  } elseif ($new_data == "31-12-2069") {
    $new_data = "00-00-0000";
  } elseif ($new_data == "30-11--0001") {
    $new_data = "00-00-0000";
  }
  return $new_data;
}

// Função Muda Data Para Gravar No Banco
function MudaDataGravarBanco ($data_correta_gravar) {
  $new_data = date("Y-m-d", strtotime("$data_correta_gravar"));
  
  if ($new_data == "1969-12-31") {
    $new_data = "0000-00-00";
  } elseif ($new_data == "2069-12-31") {
    $new_data = "0000-00-00";
  } elseif ($new_data == "0001-11-30") {
    $new_data = "0000-00-00";
  } elseif ($new_data == "") {
    $new_data = "0000-00-00";
  } 
  return $new_data;
}

// Função Mostra Valores Dinheiro Corretamente
function MostraValorDinheiroCorretamente ($valor_correto_mostrar) {
  $new_valor = 'R$ '. number_format($valor_correto_mostrar, 2, ',', '.'); //Formatando para mostrar ao usuario.
  return $new_valor;
}

// Função Mostra Valores Dinheiro Corretamente sem Cifrão
function MostraValorDinheiroCorretamenteNoCifrao ($valor_correto_mostrar) {
  $new_valor = number_format($valor_correto_mostrar, 2, ',', '.'); //Formatando para mostrar ao usuario.
  return $new_valor;
}

// Função Muda Valores Dinheiro Para Gravar No Banco
function MudaValorDinheiroGravar ($valor_correto_gravar) {
  $new_valor = str_replace(",",".",str_replace(".","",$valor_correto_gravar)); // Formatando para gravar no banco.
  return $new_valor; 
}

function Data_Mostra_Dia ($data){          // Só funciona com datas no formato d-m-Y
       if (strstr($data, "-")){            // Verifica se tem a traço -
           $d = explode ("-", $data);      // Tira o traço
           $rstData = "$d[2]-$d[1]-$d[0]"; // Separa as datas $d[0] = Dia, $d[1] = Mês e $d[2] = Ano 
           return $d[0];
      }
}

function Data_Mostra_Mes ($data){          // Só funciona com datas no formato d-m-Y
       if (strstr($data, "-")){            // Verifica se tem a traço -
           $d = explode ("-", $data);      // Tira o traço
           $rstData = "$d[2]-$d[1]-$d[0]"; // Separa as datas $d[0] = Dia, $d[1] = Mês e $d[2] = Ano 
           return $d[1];
      }
}

function Data_Mostra_Ano ($data){          // Só funciona com datas no formato d-m-Y
       if (strstr($data, "-")){            // Verifica se tem a traço -
           $d = explode ("-", $data);      // Tira o traço
           $rstData = "$d[2]-$d[1]-$d[0]"; // Separa as datas $d[0] = Dia, $d[1] = Mês e $d[2] = Ano 
           return $d[2];
      }
}

function proximoDiaUtil($data, $saida = 'Y-m-d') { // Alterado para padrão WHMCS
    //function proximoDiaUtil($data, $saida = 'd/m/Y') {
    // Converte $data em um UNIX TIMESTAMP
    $timestamp = strtotime($data);

    // Calcula qual o dia da semana de $data
    // O resultado será um valor numérico:
    // 1 -> Segunda ... 7 -> Domingo
    $dia = date('N', $timestamp);
    // Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
    if ($dia >= 6) {
    $timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
    } else {
    // Não é sábado nem domingo, mantém a data de entrada
    $timestamp_final = $timestamp;
    }
    return date($saida, $timestamp_final);
}
//Adicionar
//10 dias a partir de hoje
$adicionar_10_dias =  date('d/m/Y', strtotime("+10 days"));

//10 dias a partir de uma data
$adicionar_10_dias = date('d/m/Y', strtotime("+10 days",strtotime('20-07-2011')));

//Subtrair
//10 dias a partir de hoje
$subtrair_10_dias = date('d/m/Y', strtotime("-10 days"));

//10 dias a partir de uma data
$subtrair_10_dias = date('d/m/Y', strtotime("-10 days",strtotime('20-07-2011')));

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
  /*
  $interval can be:
  yyyy - Number of full years
  q - Number of full quarters
  m - Number of full months
  y - Difference between day numbers
      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
  d - Number of full days
  w - Number of full weekdays
  ww - Number of full weeks
  h - Number of full hours
  n - Number of full minutes
  s - Number of full seconds (default)
  */
  
  if (!$using_timestamps) {
      $datefrom = strtotime($datefrom, 0);
      $dateto = strtotime($dateto, 0);
  }
  $difference = $dateto - $datefrom; // Difference in seconds
   
  switch($interval) {
   
  case 'yyyy': // Number of full years
      $years_difference = floor($difference / 31536000);
      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
          $years_difference--;
      }
      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
          $years_difference++;
      }
      $datediff = $years_difference;
      break;
  case "q": // Number of full quarters
      $quarters_difference = floor($difference / 8035200);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
          $months_difference++;
      }
      $quarters_difference--;
      $datediff = $quarters_difference;
      break;
  case "m": // Number of full months
      $months_difference = floor($difference / 2678400);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
          $months_difference++;
      }
      $months_difference--;
      $datediff = $months_difference;
      break;
  case 'y': // Difference between day numbers
      $datediff = date("z", $dateto) - date("z", $datefrom);
      break;
  case "d": // Number of full days
      $datediff = floor($difference / 86400);
      break;
  case "w": // Number of full weekdays
      $days_difference = floor($difference / 86400);
      $weeks_difference = floor($days_difference / 7); // Complete weeks
      $first_day = date("w", $datefrom);
      $days_remainder = floor($days_difference % 7);
      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
      if ($odd_days > 7) { // Sunday
          $days_remainder--;
      }
      if ($odd_days > 6) { // Saturday
          $days_remainder--;
      }
      $datediff = ($weeks_difference * 5) + $days_remainder;
      break;
  case "ww": // Number of full weeks
      $datediff = floor($difference / 604800);
      break;
  case "h": // Number of full hours
      $datediff = floor($difference / 3600);
      break;
  case "n": // Number of full minutes
      $datediff = floor($difference / 60);
      break;
  default: // Number of full seconds (default)
      $datediff = $difference;
      break;
  }    
  return $datediff;
}
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {

  $lmin       = 'abcdefghijklmnopqrstuvwxyz';
  $lmai       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $num        = '1234567890';
  $simb       = '!@#$%*-';
  $retorno    = '';
  $caracteres = '';

  $caracteres .= $lmin;
  if ($maiusculas) $caracteres .= $lmai;
  if ($numeros) $caracteres .= $num;
  if ($simbolos) $caracteres .= $simb;

  $len = strlen($caracteres);
  for ($n = 1; $n <= $tamanho; $n++) {
  $rand = mt_rand(1, $len);
  $retorno .= $caracteres[$rand-1];
  }
  return $retorno;
}

function remover_caracter($string) {
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
    $string = preg_replace("/ /", "_", $string);
    $string = preg_replace("/[-]/", "", $string);
    return $string;
}

function CalculaComissao($duracao, $config_valor_minutos, $config_porcentagem_tarologo) {

  if ($duracao == "") {
      $duracao='0';
  }

  $valor = $duracao * $config_valor_minutos;
  $percentual = $config_porcentagem_tarologo / 100.0; // 35%
  $percentual = $percentual * $valor;
  $comissao_real = MostraValorDinheiroCorretamenteNoCifrao ($percentual);
  return $comissao_real;
}

function CupomDesconto($valor, $desconto) {

  $percentual = $desconto / 100.0; // 35%
  $percentual = $percentual * $valor;
  $desconto = $valor - $percentual;
  return $desconto;
}

function EnviarEmail($memaildestinatario, $mnomedestinatario, $massunto, $mmensagem) {
  $PHPMaileremail = new PHPMailer();
  $PHPMaileremail->setLanguage('pt');
  $PHPMaileremail->CharSet     = "UTF-8";
  // $PHPMaileremail->Debugoutput = 'html';
  // $PHPMaileremail->SMTPDebug   = 2; // debugging: 1 = errors and messages, 2 = messages only
  $PHPMaileremail->SMTPSecure  = 'ssl'; // secure transfer enabled REQUIRED for Gmail
  $PHPMaileremail->isSMTP(); // Define que o e-mail será enviado como HTML
  $PHPMaileremail->addCustomHeader("List-Unsubscribe: <mailto:epapodetarot@gmail.com?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
  $PHPMaileremail->Host     ="mail.epapodetarot.com.br";  
  $PHPMaileremail->SMTPAuth =true;
  $PHPMaileremail->Port     =465; //  Usar 587 porta SMTP
  $PHPMaileremail->Username ="epapodetarot@gmail.com"; 
  $PHPMaileremail->Password ="AG!eo{wOQRHA";
  $PHPMaileremail->setFrom('epapodetarot@gmail.com', 'É Papo de Tarot');
  $PHPMaileremail->addReplyTo('epapodetarot@gmail.com', 'É Papo de Tarot'); // Remetente
  // $PHPMaileremail->DKIM_domain = 'epapodetarot.com.br';
  // $PHPMaileremail->DKIM_private = '/home/novasyst/public_html/admin/area51/.htkeyprivate';
  // $PHPMaileremail->DKIM_selector = '1484161502.tarotdehorus'; //Prefix for the DKIM selector
  // $PHPMaileremail->DKIM_passphrase = ''; //leave blank if no Passphrase
  // $PHPMaileremail->DKIM_identity = "epapodetarot@gmail.com";
  // $PHPMailer->addCC('tarotdehorus.atendimento@hotmail.com', 'É Papo de Tarot'); // Copia
  $PHPMaileremail->addBCC('logs@novasystems.com.br', 'Nova Systems'); // Cópia Oculta
  // $PHPMailer->addAttachment('images/phpmailer.gif');      // Adicionar um anexo
  $PHPMaileremail->addAddress($memaildestinatario, $mnomedestinatario); // Destinatário
  $PHPMaileremail->Subject = $massunto;
  $PHPMaileremail->MsgHTML($mmensagem);
  // Enviando o PHPMailer
  $PHPMaileremail->send();
  //send the message, check for errors
  // if (!$PHPMaileremail->send()) {
  //   echo "Mailer Error: " . $PHPMaileremail->ErrorInfo;
  // } else {
  //   //echo "Message sent!";
  // }
}

function TransformaAlias($string) {
  $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
  $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
  $string = preg_replace("/ /", "-", $string);
  $string = strtolower($string);
  $string = preg_replace("/--/", "", $string);
  $string = str_replace("/", "", $string);
  $string = str_replace("ç", "c", $string);
  $string = str_replace("Ç", "c", $string);
  $string = stripslashes($string);
  return $string;
}

class Codificador {
  static $chave = "tarot555ds1sdsdfhorus8sd8dfs5s2";
  static function cript($a, $b) {
      if ($a=='') return '';
      $retorno = "";
      $i = strlen($a) - 1;
      $j = strlen($b);
      do {
          $retorno .= ($a{$i} ^ $b{$i % $j});
      } while ($i--);
      return strrev($retorno);
  }
  static function Codifica($param) {
      $string = (string) $param;
      return base64_encode(Codificador::cript($string, Codificador::$chave));
  }
  static function Decodifica($string) {
      return Codificador::cript(base64_decode($string), Codificador::$chave);
  }
}
?>