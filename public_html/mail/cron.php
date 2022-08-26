<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Brazil/East");
ini_set ('default_charset', 'UTF-8');
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
require_once "/home/epapodetarotcom/public_html/scripts/PHPMailer-master5.2.22/class.phpmailer.php";
require_once "/home/epapodetarotcom/public_html/scripts/PHPMailer-master5.2.22/class.smtp.php";
$pdo=conexao();
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

// Progressivo - Não repete a mensagem enviada. Segue enviando progressivamente quando a data do ciclo da mensagem e a data de cadastro do e-mail, tem uma diferença igual a data do ciclo da mensagem.
// Fixo - Envia várias vezes a mesma mensagem, baseado na data da Útima Mensagem Enviada. Exemplo: envia mensagens de 60 em 60 dias.... 15 em 15 dias... etc.

// Seleciona as campanhas ativas 
$sql = $pdo->query("SELECT * FROM mail_camp WHERE status='ATIVO' ");
//$sql = $pdo->query("SELECT * FROM mail_camp WHERE id='15' ");
while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) 
{
	$camp_id=$mostrar['id'];
	$camp_nome=$mostrar['nome'];
	$camp_status=$mostrar['status'];
	$camp_tipo=$mostrar['fixo'];
	$camp_data_utima_exec=$mostrar['data_utima_exec'];

	if ($camp_tipo == "PROGRESSIVO") {
		// Se o PERÍODO for PROGRESSIVO faça este:

		// Seleciona os e-mails desta campanha 
		$executa1=$pdo->query("SELECT * FROM mail_lista WHERE id_camp='$camp_id'");
	    while ($dadoss1= $executa1->fetch(PDO::FETCH_ASSOC)) {

			// E-mails da Campanha
			$email_id=$dadoss1['id'];
			$email_nome=$dadoss1['nome'];
			$email_email=$dadoss1['email'];
			$email_data=$dadoss1['data'];

			// Diferença entre data de hoje e data de cadastro do e-mail
	    	$data1 = $email_data; /*Data de Cadastro do E-mail*/
	        $data2 = date('Y-m-d H:i:s'); /*Data de Hoje*/
	        $diferenca_periodo = datediff('d', $data1, $data2, false); /*Diferença*/

	        // echo nl2br("$email_id - $diferenca_periodo\n");
	        // exit();

			// Seleciona a MENSAGEM desta campanha com ciclo igual a diferença do período
			$executa2=$pdo->query("SELECT * FROM mail_msg WHERE id_camp='$camp_id' AND enviar_dias='$diferenca_periodo' ");
			$quantida_de_mensagens_para_enviar_hoje = $executa2->rowCount();

			// Se existir alguma mensagem com o ciclo igual ao do e-mail, continua.
			if ($quantida_de_mensagens_para_enviar_hoje > 0) {
				
			    while ($dadoss2 = $executa2->fetch(PDO::FETCH_ASSOC))
			    {
					// Mensagens da Campanha
					$msg_id=$dadoss2['id'];
					$msg_id_camp=$dadoss2['id_camp'];
					$msg_enviar_dias=$dadoss2['enviar_dias'];
					$msg_assunto=$dadoss2['assunto'];
					$msg_msg=$dadoss2['msg'];

					if ($msg_enviar_dias == $diferenca_periodo) {
						// Envia o e-mail
						/* -----------------Mandando E-mail---------------------- */
		                // Usando o PHPMailer, Preparando o email
		                $PHPMailer = new PHPMailer();
		                $PHPMailer->setLanguage('pt');
		                $PHPMailer->CharSet  = "UTF-8";
		                $PHPMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
		                $PHPMailer->AddCustomHeader("List-Unsubscribe: <mailto:epapodetarot@gmail.com?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
		                $PHPMailer->Host     = "mail.epapodetarot.com.br";  
		                $PHPMailer->SMTPAuth = true;
		                $PHPMailer->Port     = 587; // Usar 587 porta SMTP
		                $PHPMailer->Username = "epapodetarot@gmail.com"; 
		                $PHPMailer->Password = "AG!eo{wOQRHA";
		                $PHPMailer->From     = "epapodetarot@gmail.com"; // Remetente
		                $PHPMailer->FromName = "É Papo de Tarot"; // Seu nome
		                $PHPMailer->AddReplyTo('epapodetarot@gmail.com', 'É Papo de Tarot'); // Remetente
		                $PHPMailer->AddAddress($email_email, $email_nome); // Destinatário
		                // $PHPMailer->DKIM_domain = 'epapodetarot.com.br';
						// $PHPMailer->DKIM_private = '/home/epapodetarotcom/public_html/area51/.htkeyprivate';
						// $PHPMailer->DKIM_selector = '1484161502.novasystems'; //Prefix for the DKIM selector
						// $PHPMailer->DKIM_passphrase = ''; //leave blank if no Passphrase
						// $PHPMailer->DKIM_identity = "epapodetarot@gmail.com";
						$PHPMailer->AddBCC('epapodetarot@gmail.com', 'É Papo de Tarot'); // Cópia Oculta
		                $PHPMailer->Subject = $msg_assunto; // Assunto
		                $corpoMSG = $msg_msg;
		                $PHPMailer->MsgHTML($corpoMSG);
		                // Enviando o email
		                $PHPMailer->Send();
		                /* -----------------Mandando E-mail---------------------- */

				        echo nl2br("Campanha:$camp_nome - Perído:$camp_tipo - Nome:$email_nome, $email_email - Ciclo Sis:$diferenca_periodo - Ciclo Msg:$msg_enviar_dias - Mensagem:$msg_assunto\n");

						// Registra neste e-mail o ID e data desta mensagem que foi enviada
						$data_times = date('Y-m-d H:i:s');
						$query = $pdo->query("UPDATE mail_lista SET 
			              id_ultima_msg='$msg_id',
			              data_ultima_msg='$data_times'
			            WHERE id='$email_id'");

			            // No final de tudo, registra o dia que esta campanha foi execultada
					    $query = $pdo->query("UPDATE mail_camp SET 
				          data_utima_exec='$data_times'
				        WHERE id='$camp_id'");

				        // Registra quando foi a última vez que essa mensagem foi enviada.
					    $queryx = $pdo->query("UPDATE mail_msg SET 
				          data_utima_exec='$data_times'
				        WHERE id='$msg_id'");
					}
		    	}
			} 
	    }

	} elseif ($camp_tipo == "FIXO") {
		// Se o PERÍODO for FIXO faça este:

		// Seleciona as MENSAGENS desta campanha 
		$executa2=$pdo->query("SELECT * FROM mail_msg WHERE id_camp='$camp_id' ");
	    while ($dadoss2= $result->fetch(PDO::FETCH_ASSOC))
	    {
			// Mensagens da Campanha
			$msg_id=$dadoss2['id'];
			$msg_id_camp=$dadoss2['id_camp'];
			$msg_enviar_dias=$dadoss2['enviar_dias'];
			$msg_assunto=$dadoss2['assunto'];
			$msg_msg=$dadoss2['msg'];
			$data_utima_exec=$dadoss2['data_utima_exec'];

			// Verifica qual a data de hoje
	        $data1 = date('Y-m-d H:i:s');
	        // $data1 = '2017-11-10';

			// Verica qual a data da ultima mensagem enviada
	    	$data2 = $data_utima_exec;
	    	// $data2 = "2017-10-26";

			// Diferença entre data da ultima mensagem enviada e a data de hoje
	        $diferenca_periodo = datediff('d', $data2, $data1, false);

	  		//echo nl2br("$diferenca_periodo\n");
			//exit();

	  		// Se a diferença da data de hoje e a data da ultima mensagem enviada for igual ao ciclo da mensagem, envia os emails.
	  		//if ($diferenca_periodo == $msg_enviar_dias OR $data_utima_exec == '0000-00-00 00:00:00') {
			if ($diferenca_periodo == $msg_enviar_dias) {
				
	        	// Seleciona os e-mails desta campanha 
				$executa1=$pdo->query("SELECT * FROM mail_lista WHERE id_camp='$camp_id'");
			    while ($dadoss1= $executa1->fetch(PDO::FETCH_ASSOC))
			    {
					// E-mails da Campanha
					$email_id=$dadoss1['id'];
					$email_nome=$dadoss1['nome'];
					$email_email=$dadoss1['email'];
					$email_data=$dadoss1['data'];

					// Envia o e-mail
					/* -----------------Mandando E-mail---------------------- */
		            // Usando o PHPMailer, Preparando o email
		            $PHPMailer = new PHPMailer();
		            $PHPMailer->setLanguage('pt');
		            $PHPMailer->CharSet  = "UTF-8";
		            $PHPMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
		            $PHPMailer->AddCustomHeader("List-Unsubscribe: <mailto:epapodetarot@gmail.com?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
		            $PHPMailer->Host     ="mail.epapodetarot.com.br";  
		            $PHPMailer->SMTPAuth =true;
		            $PHPMailer->Port     =587; //  Usar 587 porta SMTP
		            $PHPMailer->Username ="epapodetarot@gmail.com"; 
		            $PHPMailer->Password ="AG!eo{wOQRHA";
		            $PHPMailer->From     ="epapodetarot@gmail.com"; // Remetente
		            $PHPMailer->FromName ="É Papo de Tarot"; // Seu nome
		            $PHPMailer->AddReplyTo('epapodetarot@gmail.com', 'É Papo de Tarot'); // Remetente
		            $PHPMailer->AddAddress($email_email, $email_nome); // Destinatário
		            $PHPMailer->DKIM_domain = 'epapodetarot.com.br';
					$PHPMailer->DKIM_private = '/home/epapodetarotcom/public_html/area51/.htkeyprivate';
					$PHPMailer->DKIM_selector = '1484161502.novasystems'; //Prefix for the DKIM selector
					$PHPMailer->DKIM_passphrase = ''; //leave blank if no Passphrase
					$PHPMailer->DKIM_identity = "epapodetarot@gmail.com";
		            $PHPMailer->Subject  = $msg_assunto; // Assunto
		            $corpoMSG = $msg_msg;
		            $PHPMailer->MsgHTML($corpoMSG);
		            // Enviando o email
		            $PHPMailer->Send();
		            /* -----------------Mandando E-mail---------------------- */

		            echo nl2br("Campanha:$camp_nome - Perído:$camp_tipo - Nome:$email_nome, $email_email - Ciclo Sis:$diferenca_periodo - Ciclo Msg:$msg_enviar_dias - Mensagem:$msg_assunto\n");

					// Registra neste e-mail o ID e data desta mensagem que foi enviada
					$data_times = date('Y-m-d H:i:s');
					$query = $pdo->query("UPDATE mail_lista SET 
		              id_ultima_msg='$msg_id',
		              data_ultima_msg='$data_times'
		            WHERE id='$email_id'");

		            // Registra o dia que esta mensagem foi execultada
					$data_da_execulcao = date('Y-m-d H:i:s');
				    $query = $pdo->query("UPDATE mail_msg SET 
			          data_utima_exec='$data_da_execulcao'
			        WHERE id='$msg_id'");

		            // No final de tudo, registra o dia que esta campanha foi execultada
		            // IMPORTANTE - Pois para execultar de novo, ele pegara a ultima data que foi execultado
					$data_da_execulcao = date('Y-m-d');
				    $query = $pdo->query("UPDATE mail_camp SET 
			          data_utima_exec='$data_da_execulcao'
			        WHERE id='$camp_id'");	
			    }
			}
	    }
	
	} elseif ($camp_tipo == "AGENDADAS") {
		// Se o PERÍODO for FIXO faça este:

		// Seleciona as MENSAGENS desta campanha 
		$executa2=$pdo->query("SELECT * FROM mail_msg WHERE id_camp='$camp_id' ");
	    while ($dadoss2= $result->fetch(PDO::FETCH_ASSOC))
	    {
			// Mensagens da Campanha
			$msg_id=$dadoss2['id'];
			$msg_id_camp=$dadoss2['id_camp'];
			$msg_enviar_dias=$dadoss2['enviar_dias'];
			$msg_assunto=$dadoss2['assunto'];
			$msg_msg=$dadoss2['msg'];
			$data_utima_exec=$dadoss2['data_utima_exec'];

			// Verifica qual a data de hoje
	        $data1 = date('d-m-Y');

			// faz o loop pelas datas agendadas que estão separadas por ';'
			$recupera_datas_agendadas = explode (";", $msg_enviar_dias);
			
			foreach ($recupera_datas_agendadas as $datas_agendadasUm) {
				
				$datas_agendadas = str_replace("/","-",$datas_agendadasUm);
				
		  		// Se a data agendada for igual a data de hoje, então envia o e-mail.
				if ($datas_agendadas == $data1) {
					
		        	// Seleciona os e-mails desta campanha 
					$executa1=$pdo->query("SELECT * FROM mail_lista WHERE id_camp='$camp_id'");
				    while ($dadoss1= $executa1->fetch(PDO::FETCH_ASSOC))
				    {
						// E-mails da Campanha
						$email_id=$dadoss1['id'];
						$email_nome=$dadoss1['nome'];
						$email_email=$dadoss1['email'];
						$email_data=$dadoss1['data'];

						// Envia o e-mail
						/* -----------------Mandando E-mail---------------------- */
			            // Usando o PHPMailer, Preparando o email
			            $PHPMailer = new PHPMailer();
			            $PHPMailer->setLanguage('pt');
			            $PHPMailer->CharSet  = "UTF-8";
			            $PHPMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
			            $PHPMailer->AddCustomHeader("List-Unsubscribe: <mailto:epapodetarot@gmail.com?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
			            $PHPMailer->Host     ="mail.epapodetarot.com.br";  
			            $PHPMailer->SMTPAuth =true;
			            $PHPMailer->Port     =587; //  Usar 587 porta SMTP
			            $PHPMailer->Username ="epapodetarot@gmail.com"; 
			            $PHPMailer->Password ="AG!eo{wOQRHA";
			            $PHPMailer->From     ="epapodetarot@gmail.com"; // Remetente
			            $PHPMailer->FromName ="É Papo de Tarot"; // Seu nome
			            $PHPMailer->AddReplyTo('epapodetarot@gmail.com', 'É Papo de Tarot'); // Remetente
			            $PHPMailer->AddAddress($email_email, $email_nome); // Destinatário
			            // $PHPMailer->DKIM_domain = 'epapodetarot.com.br';
						// $PHPMailer->DKIM_private = '/home/epapodetarotcom/public_html/area51/.htkeyprivate';
						// $PHPMailer->DKIM_selector = '1484161502.novasystems'; //Prefix for the DKIM selector
						// $PHPMailer->DKIM_passphrase = ''; //leave blank if no Passphrase
						// $PHPMailer->DKIM_identity = "epapodetarot@gmail.com";
			            $PHPMailer->Subject  = $msg_assunto; // Assunto
			            $corpoMSG = $msg_msg;
			            $PHPMailer->MsgHTML($corpoMSG);
			            // Enviando o email
			            $PHPMailer->Send();
			            /* -----------------Mandando E-mail---------------------- */

			            echo nl2br("Campanha:$camp_nome - Perído:$camp_tipo - Nome:$email_nome, $email_email - Ciclo Sis:$diferenca_periodo - Ciclo Msg:$msg_enviar_dias - Mensagem:$msg_assunto\n");

						// Registra neste e-mail o ID e data desta mensagem que foi enviada
						$data_times = date('Y-m-d H:i:s');
						$query = $pdo->query("UPDATE mail_lista SET 
			              id_ultima_msg='$msg_id',
			              data_ultima_msg='$data_times'
			            WHERE id='$email_id'");

			            // Registra o dia que esta mensagem foi execultada
						$data_da_execulcao = date('Y-m-d H:i:s');
					    $query = $pdo->query("UPDATE mail_msg SET 
				          data_utima_exec='$data_da_execulcao'
				        WHERE id='$msg_id'");

			            // No final de tudo, registra o dia que esta campanha foi execultada
			            // IMPORTANTE - Pois para execultar de novo, ele pegara a ultima data que foi execultado
						$data_da_execulcao = date('Y-m-d');
					    $query = $pdo->query("UPDATE mail_camp SET 
				          data_utima_exec='$data_da_execulcao'
				        WHERE id='$camp_id'");	
				    }
				}
			}

	    }

	}	 
}
echo nl2br("Autoresponder Terminou...\n");