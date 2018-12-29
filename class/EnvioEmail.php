<?php
Class EnvioEmail extends Connection{
		
	private $html;
	private $titulo;
	private $smtp_url;
	private $smtp_email;
	private $smtp_senha;
	private $smtp_porta;
	private $id_usuarios;
	
	//SMTPSecure TLS = 587 ou SSL = 465
	public function enviar_email($host, $username, $password, $port, $from, $fromName, $address, $subject, $body, $secure='tls', $debug=FALSE){
		
		$mail = new PHPMailer();        
	    $mail->Timeout 		= 10;
		// Define os dados do servidor e tipo de conexão
	    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	    $mail->CharSet      = 'UTF-8';
	    //$mail->IsSMTP();    // Define que a mensagem será SMTP
	    
	    $mail->SMTPAuth     = TRUE; // Usa autenticação SMTP? (opcional)
	    //$mail->SMTPSecure 	= 'SSL';	// SSL REQUERIDO pelo GMail
	    $mail->SMTPSecure 	= 'tls';
		/*
	    if($secure){
		    $mail->SMTPSecure 	= 'tls';
	    }
		* /
		$mail->SMTPOptions = array(
								    'ssl' => array('verify_peer' => false,
								        		   'verify_peer_name' => false,
								        		   'allow_self_signed' => true
								    			   )
								  );		
		*/
		//$mail->SMTPAuth 	= false;
		//$mail->SMTPSecure 	= false;
	    
	    $mail->Host         = $host; // Endereço do servidor SMTP
	    $mail->Username     = $username; // Usuário do servidor SMTP
	    $mail->Password     = $password; // Senha do servidor SMTP
	    $mail->Port         = $port; // Senha do servidor SMTP
	    
	    $mail->SMTPDebug    = $debug;
		//$mail->SMTPSecure 	= 'SSL';	// SSL REQUERIDO pelo GMail
	    // Define o remetente
	    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	    
	    $mail->From = $from; // Seu e-mail
	    $mail->FromName = $fromName; // Seu nome
	    // Define os destinatário(s)
	    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	    
	    if (is_array($address)) {
			foreach ($address as $key => $value) {
				$mail->AddAddress($value);
			}
		} else {
			$mail->AddAddress($address);
		}
	    
	    //$mail->AddAddress('ciclano@site.net');
	    //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	    //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
	    // Define os dados técnicos da Mensagem
	    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	    //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
	    // Define a mensagem (Texto e Assunto)
	    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	    $mail->Subject  = mb_convert_encoding($subject, "UTF-8", "auto"); // Assunto da mensagem
	    $mail->Body = $body;
	    //$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";
	    // Define os anexos (opcional)
	    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	    
	    //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
	    // Envia o e-mail
	    
	    $enviado = $mail->Send();
	    // Limpa os destinatários e os anexos
	    //$mail->ClearAllRecipients();
	    //$mail->ClearAttachments();
	    // Exibe uma mensagem de resultado
	    if ($enviado) {
	    	return array('success'=>TRUE, 'error'=>FALSE, 'msg'=>'E-mail enviado com sucesso.');
	        //return json_encode(array('sucesso'=>TRUE, 'msg'=>'E-mail enviado com sucesso!'));
	    } else {
	        //return json_encode(array('erro'=>TRUE, 'msg'=>'ERRO: '.$mail->ErrorInfo));
			return array('success'=>FALSE, 'error'=>TRUE, 'msg'=>$mail->ErrorInfo);
	    }
		
	}	
	
}
?>