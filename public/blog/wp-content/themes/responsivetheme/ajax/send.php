<?php
	$name = $_POST['name'];
	$email = $_POST['email'];
	$text = $_POST['text'];

	$message = "<p><b>Имя:</b> ".$name."</p><p><b>Email:</b> ".$email."</p><p><b>Сообщение:</b> ".$text."</p>";

			// $to      = 'info@globalprom.com.ua'; 
			$to      = 'xolodok.373@gmail.com'; 
			$subject = 'GlobalProm Блог - Обратная связь';
			$header="Date: ".date("D, j M Y G:i:s")." +0300\r\n";
			$header.="From: GlobalProm.com.ua <GlobalProm.com.ua>\r\n";
			$header.="Reply-To: =?utf-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('webmaster@example.com')))."?= <webmaster@example.com>\r\n";
			$header.="X-Priority: 3 (Normal)\r\n";
			$header.="Message-ID: <172562218.".date("YmjHis")."@gmail.com>\r\n";
			$header.="MIME-Version: 1.0\r\n";
			$header.="Content-Type: text/html; charset=utf-8\r\n";
			$header.="Content-Transfer-Encoding: 8bit\r\n";

			if(mail($to, $subject, $message, $header)){
				return json_encode(['error' => false, 'message' => 'Сообщение успешно отправлено']);
			}
			else{
				return json_encode(['error' => true, 'message' => 'не удалось отправить сообщение']);				
			}
?>