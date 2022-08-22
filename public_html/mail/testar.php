<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
include_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
require_once('../scripts/PHPMailer-master5.2.22/class.phpmailer.php');
require_once('../scripts/PHPMailer-master5.2.22/class.smtp.php');

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

// Seleciona as campanhas ativas 
$sql = $pdo->query("SELECT * FROM mail_camp WHERE id='11' ");
while ($mostrar = $sql->fetch(PDO::FETCH_ASSOC)) 
{
	$camp_id=$mostrar['id'];
	$camp_nome=$mostrar['nome'];
	$camp_status=$mostrar['status'];
	$camp_fixo=$mostrar['fixo'];
	$camp_data_utima_exec=$mostrar['data_utima_exec'];

	if ($camp_fixo == "PROGRESSIVO") {
		// Se o PERÍODO for PROGRESSIVO faça este:

		// Seleciona os e-mails desta campanha 
		$executa1=$pdo->query("SELECT * FROM mail_lista WHERE id_camp='$camp_id'");
	    while ($dadoss1= $executa1->fetch(PDO::FETCH_ASSOC))
	    {
			// E-mails da Campanha
			$email_id=$dadoss1['id'];
			$email_nome=$dadoss1['nome'];
			$email_email=$dadoss1['email'];
			$email_data=$dadoss1['data'];

			// Diferença entre data de hoje e data de cadastro do e-mail
	    	$data1 = $email_data; /*Data de Cadastro do E-mail*/
	        $data2 = date('Y-m-d'); /*Data de Hoje*/
	        $periodo = datediff('d', $data1, $data2, false); /*Diferença*/

			// Seleciona a MENSAGEM desta campanha com ciclo igual a diferença do período
			$executa2=$pdo->query("SELECT * FROM mail_msg WHERE id_camp='$camp_id' AND enviar_dias='$periodo' ");
		    while ($dadoss2= $result->fetch(PDO::FETCH_ASSOC))
		    {
				// Mensagens da Campanha
				$msg_id=$dadoss2['id'];
				$msg_id_camp=$dadoss2['id_camp'];
				$msg_enviar_dias=$dadoss2['enviar_dias'];
				$msg_assunto=$dadoss2['assunto'];
				$msg_msg=$dadoss2['msg'];

				// Envia o e-mail
				/* -----------------Mandando E-mail---------------------- */
                // Usando o PHPMailer, Preparando o email
                $PHPMailer = new PHPMailer();
                $PHPMailer->setLanguage('pt');
                $PHPMailer->CharSet  = "UTF-8";
                $PHPMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
                $PHPMailer->AddCustomHeader("List-Unsubscribe: <mailto:contato@epapodetarot.com.br?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
                $PHPMailer->Host     ="mail.epapodetarot.com.br";  
                $PHPMailer->SMTPAuth =true;
                $PHPMailer->Port     =587; //  Usar 587 porta SMTP
                $PHPMailer->Username ="contato@epapodetarot.com.br"; 
                $PHPMailer->Password ="AG!eo{wOQRHA";
                $PHPMailer->From     ="contato@epapodetarot.com.br"; // Remetente
                $PHPMailer->FromName ="É Papo de Tarot"; // Seu nome
                $PHPMailer->AddReplyTo('contato@epapodetarot.com.br', 'É Papo de Tarot'); // Remetente
                $PHPMailer->AddAddress($email_email, $email_nome); // Destinatário
                //Campos abaixo são opcionais 
                //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                //$PHPMailer->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
                // $PHPMailer->AddBCC('novasystems.atendimento@hotmail.com', 'É Papo de Tarot'); // Cópia oculta
                //$PHPMailer->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
                $PHPMailer->Subject  = $msg_assunto; // Assunto
                $corpoMSG = $msg_msg;
                $PHPMailer->MsgHTML($corpoMSG);
                // Enviando o email
                $PHPMailer->Send();
                /* -----------------Mandando E-mail---------------------- */
                sleep(5);

                echo nl2br("Campanha:$camp_nome - Perído:$camp_fixo - Nome:$email_nome, $email_email - Ciclo:$periodo - Mensagem:$msg_assunto\n");

				// Registra neste e-mail o ID desta mensagem que foi enviada
				$query = $pdo->query("UPDATE mail_lista SET 
	              id_ultima_msg='$msg_id'
	            WHERE id='$email_id'");
				
				// No final de tudo, registra o dia que esta campanha foi execultada
				$data_da_execulcao = date('Y-m-d');
			    $query = $pdo->query("UPDATE mail_camp SET 
		          data_utima_exec='$data_da_execulcao'
		        WHERE id='$camp_id'");
		    }
	    }

	} elseif ($camp_fixo == "FIXO") {
		// Se o PERÍODO for FIXO faça este:

		// Seleciona os e-mails desta campanha 
		$executa1=$pdo->query("SELECT * FROM mail_lista WHERE id='74'");
	    while ($dadoss1= $executa1->fetch(PDO::FETCH_ASSOC))
	    {
			// E-mails da Campanha
			$email_id=$dadoss1['id'];
			$email_nome=$dadoss1['nome'];
			$email_email=$dadoss1['email'];
			$email_data=$dadoss1['data'];

			// Verifica qual a data de hoje
	        $data1 = date('Y-m-d');

			// Verica qual a data da ultima vez que essa campanha foi execultada
	    	$data2 = $camp_data_utima_exec;
	    	//$data2 = "2017-01-21";

			// Diferença entre data da ultima campanha e data de hoje, esse é o período
	        $periodo = datediff('d', $data2, $data1, false);

	  //       echo $periodo;
			// exit();
	        
	        // Se nunca tiver sido enviado nenhuma e-mail, então envia hoje. Caso contrario, envia no resultado do período
	        if ($data2=="0000-00-00") {	

	        	// Se nunca tiver sido enviado nenhuma e-mail, então envia hoje
	        	// Seleciona a MENSAGEM desta campanha com ciclo igual a diferença do período
				$executa2=$pdo->query("SELECT * FROM mail_msg WHERE id_camp='$camp_id' ");
			    while ($dadoss2= $result->fetch(PDO::FETCH_ASSOC))
			    {
					// Mensagens da Campanha
					$msg_id=$dadoss2['id'];
					$msg_id_camp=$dadoss2['id_camp'];
					$msg_enviar_dias=$dadoss2['enviar_dias'];
					$msg_assunto=$dadoss2['assunto'];
					$msg_msg=$dadoss2['msg'];

					// echo "Data de Hoje: ".$data1;
				 //    echo "<br/>Data ult ex Camp: ".$data2;
				 //    echo "<br/>Período: ".$periodo;
				 //    echo "<br/>Enviando pela primeira vez";
				 //    echo "<br/>Assunto da mensagem: ".$msg_assunto;
				 //    exit();

					// Envia o e-mail
					/* -----------------Mandando E-mail---------------------- */
	                // Usando o PHPMailer, Preparando o email
	                $PHPMailer = new PHPMailer();
	                $PHPMailer->setLanguage('pt');
	                $PHPMailer->CharSet  = "UTF-8";
	                $PHPMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
	                $PHPMailer->AddCustomHeader("List-Unsubscribe: <mailto:contato@epapodetarot.com.br?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
	                $PHPMailer->Host     ="mail.epapodetarot.com.br";  
	                $PHPMailer->SMTPAuth =true;
	                $PHPMailer->Port     =587; //  Usar 587 porta SMTP
	                $PHPMailer->Username ="contato@epapodetarot.com.br"; 
	                $PHPMailer->Password ="AG!eo{wOQRHA";
	                $PHPMailer->From     ="contato@epapodetarot.com.br"; // Remetente
	                $PHPMailer->FromName ="É Papo de Tarot"; // Seu nome
	                $PHPMailer->AddReplyTo('contato@epapodetarot.com.br', 'É Papo de Tarot'); // Remetente
	                $PHPMailer->AddAddress($email_email, $email_nome); // Destinatário
	                //Campos abaixo são opcionais 
	                //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	                //$PHPMailer->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
	                //$PHPMailer->AddBCC('novasystems.atendimento@hotmail.com', 'É Papo de Tarot'); // Cópia oculta
	                //$PHPMailer->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
	                $PHPMailer->Subject  = $msg_assunto; // Assunto
	                $corpoMSG = $msg_msg;
	                $PHPMailer->MsgHTML($corpoMSG);
	                // Enviando o email
	                $PHPMailer->Send();
	                /* -----------------Mandando E-mail---------------------- */
	                sleep(5);

	                echo nl2br("Campanha:$camp_nome - Perído:$camp_fixo - Nome:$email_nome, $email_email - Ciclo:$periodo - Mensagem:$msg_assunto\n");

					// Registra neste e-mail o ID desta mensagem que foi enviada
					$query = $pdo->query("UPDATE mail_lista SET 
		              id_ultima_msg='$msg_id'
		            WHERE id='$email_id'");
			    }
	        
	        } else {

	        	// Caso contrario, envia no resultado do período
				// Seleciona a MENSAGEM desta campanha com ciclo igual a diferença do período
				$executa2=$pdo->query("SELECT * FROM mail_msg WHERE id='14' ");
			    while ($dadoss2= $result->fetch(PDO::FETCH_ASSOC))
			    {
					// Mensagens da Campanha
					$msg_id=$dadoss2['id'];
					$msg_id_camp=$dadoss2['id_camp'];
					$msg_enviar_dias=$dadoss2['enviar_dias'];
					$msg_assunto=$dadoss2['assunto'];
					$msg_msg=$dadoss2['msg'];
		        	
		        	// echo "Data de Hoje: ".$data1;
		        	// echo "<br/>Data ult ex Camp: ".$data2;
		        	// echo "<br/>Período: ".$periodo;
		        	// echo "<br/>Enviando com período";
		        	// echo "<br/>Assunto da mensagem: ".$msg_assunto;
		        	// echo "<br/>E-mail 1: ".$email_email;
		        	// exit();

					// Envia o e-mail
					/* -----------------Mandando E-mail---------------------- */
	                // Usando o PHPMailer, Preparando o email
	                $PHPMailer = new PHPMailer();
	                $PHPMailer->setLanguage('pt');
	                $PHPMailer->CharSet  = "UTF-8";
	                $PHPMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
	                $PHPMailer->AddCustomHeader("List-Unsubscribe: <mailto:contato@epapodetarot.com.br?subject=Unsubscribe>, <https://www.epapodetarot.com.br>");
	                $PHPMailer->Host     ="mail.epapodetarot.com.br";  
	                $PHPMailer->SMTPAuth =true;
	                $PHPMailer->Port     =587; //  Usar 587 porta SMTP
	                $PHPMailer->Username ="contato@epapodetarot.com.br"; 
	                $PHPMailer->Password ="AG!eo{wOQRHA";
	                $PHPMailer->From     ="contato@epapodetarot.com.br"; // Remetente
	                $PHPMailer->FromName ="É Papo de Tarot"; // Seu nome
	                $PHPMailer->AddReplyTo('contato@epapodetarot.com.br', 'É Papo de Tarot'); // Remetente
	                $PHPMailer->AddAddress($email_email, $email_nome); // Destinatário
	                //Campos abaixo são opcionais 
	                //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	                //$PHPMailer->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
	                // $PHPMailer->AddBCC('novasystems.atendimento@hotmail.com', 'É Papo de Tarot'); // Cópia oculta
	                //$PHPMailer->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
	                $PHPMailer->Subject  = $msg_assunto; // Assunto
	                $corpoMSG = $msg_msg;
	                $PHPMailer->MsgHTML($corpoMSG);
	                // Enviando o email
	                $PHPMailer->Send();
	                /* -----------------Mandando E-mail---------------------- */
	                sleep(5);

	                echo nl2br("Campanha:$camp_nome - Perído:$camp_fixo - Nome:$email_nome, $email_email - Ciclo:$periodo - Mensagem:$msg_assunto\n");

					// Registra neste e-mail o ID desta mensagem que foi enviada
					$query = $pdo->query("UPDATE mail_lista SET 
		              id_ultima_msg='$msg_id'
		            WHERE id='$email_id'");

		            // No final de tudo, registra o dia que esta campanha foi execultada
					$data_da_execulcao = date('Y-m-d');
				    $query = $pdo->query("UPDATE mail_camp SET 
			          data_utima_exec='$data_da_execulcao'
			        WHERE id='$camp_id'");
			    }
	        }
	    }
	}	 
}