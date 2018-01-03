<?php
namespace Hcode;
use Rain\Tpl;
class Mailer {
    const USERNAME = "unievsantos@gamil.com";
    const PASSWORD = "vmello85";
    const NAME_FROM = "Hcode Store";
    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName, $data = array()) {
        $config = array(
            "tpl_dir"   => $_SERVER["DOCUMENT_ROOT"]."/views/email/",	//DOCUMENT_ROOT busca a pasta raiz do projeto
            "cache_dir" => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"     => false // set to false to improve the speed
        );
        Tpl::configure( $config );
        $tpl = new Tpl;
        foreach ($data as $key => $value){
            $tpl->assign($key, $value);
        }
        $html = $tpl->draw($tplName, true);
        
        $this->mail = new \PHPMailer;
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Debugoutput = 'html';
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Mailer::USERNAME;
        $this->mail->Password = Mailer::PASSWORD;
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
        $this->mail->addAddress($toAddress, $toName);
        $this->mail->subject = $subject;
        $this->mail->msgHTML($html);
        $this->mail->AltBody = 'This is a plain-text message body';
    }
    public function send(){
        /*if(!$this->mail->send){
            echo 'Mailer Error: '. $this->mail->ErrorInfo;
        } else{
            echo 'Message sent!';
        }*/
        return $this->mail->send();
    }
}
