<?php

/**
 * Created by PhpStorm.
 * User: hudumazeau
 * Date: 11/04/16
 * Time: 11:15
 */
namespace ObsessionMainBundle\Service;


use Symfony\Component\Templating\EngineInterface;
use Uda\NotesBundle\Entity\Note;


class Mailer
{
    protected $mailer;


    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }



    public function sendMessage($mailFrom,$mailTo,$body,$objet)
    {
        $mail=\Swift_Message::newInstance();

        $mail->setFrom($mailFrom)->setTo($mailTo)->setSubject($objet)->setBody($body);

        $this->mailer->send($mail);
    }

}