<?php

namespace app\models;

/**
 * Класс, который хранит у себя письма и решает
 * когда их отсылать
 *
 * @author igorb
 */
class Sender extends PostEvents {
    /**
     * проверяет, нужно ли отослать это письмо
     */
    public function check() {
        $currentTime = time();
        
        if($this->expire > $currentTime) {            
            //если это новая запись, значит устанавливаем на какое время
            if($this->isNewRecord) {                
                $this->expire += $currentTime;
            }
            
            //если время истекло            
            if($this->expire <= $currentTime) {                
                $this->status = $this->send();
            }
        }
        else {
            $this->status = $this->send();
        }
    }
    
    /**
     * Посылаем это письмо
     */
    public function send() {        
        //проверяем, годится ли для отправки
        if($this->status == self::STATUS_WAIT) {
            
            //Если DEBUG, то вместо отправки сохраняем письма в runtime/mail
            \Yii::$app->mailer->useFileTransport = defined('NO_MAIL_SEND') && NO_MAIL_SEND;
    	    
            //скоуп e-mail
            $mail = \Yii::$app
                ->mailer
                ->compose()
                ->setSubject($this->subject)                    
                ->setFrom([
                    $this->from_email => $this->from_name,
                ])
                ->setTo($this->email);            
            
            //в зависимости от типа контента
            if($this->content_type == PostEventsTemplates::CONT_TEXT_PLAIN) {
                $mail->setTextBody($this->text);
            }
            else {
                $mail->setHtmlBody($this->text);
            }
            
            if($mail->send()) {
                return self::STATUS_IS_SEND;
            }
            else {
                return self::STATUS_TROUBLE;
            }
        }
        
        return self::STATUS_WAIT;
    }
}