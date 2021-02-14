<?php

    require "./bibliotecas/PHPMailer/Exception.php";
    require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";


        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;



    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = array('codigo_status' => null, 'descricao_status' => ' ');

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;
        }
    }

    $mensagem = new Mensagem();
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //print_r($mensagem);


    if(!$mensagem->mensagemValida()){
        echo 'Mensagem Válida';
        header('Location: index.php');
    }

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = false;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'devparatestes@gmail.com';                     // SMTP username
            $mail->Password   = '#Sumaeta8246#';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('devparatestes@gmail.com', 'Sumaeta'); //remetente
            $mail->addAddress($mensagem->__get('para'));     // destinatário
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $mensagem->__get('assunto');
            $mail->Body    = $mensagem->__get('mensagem');
            $mail->AltBody = 'É necessário ter um client que suporte HTML para ter acesso total a essa mensagem!';
            $mail->send();
            $mensagem->status['codigo_status'] = 1;
           echo $mensagem->status['descricao_status'] = 'E-mail enviado com Sucesso!'; //Mensagem após o envio do e-mail
       
        } catch (Exception $e) {
            $mensagem->status['codigo_status'] = 2;
            echo $mensagem->status['descricao_status'] = 'Não foi possivel enviar o e-mail, favor, tentar novamente!' . $mail->ErrorInfo; //caso ocorra um erro
            }