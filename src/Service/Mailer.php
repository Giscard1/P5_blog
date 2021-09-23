<?php


namespace App\Service;




class Mailer
{
    protected \Swift_Mailer $mailerSrv;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $config = require_once (__DIR__.'/../../config/mail_config.php');

        $transport = (new \Swift_SmtpTransport('smtp.googlemail.com', 465,'ssl'))
           ->setUsername($config['email'])
            ->setPassword($config['password']);

        $this->mailerSrv = new \Swift_Mailer($transport);

    }

    public function send(string $subject, string $to, string $from, string $body)
    {
        try {
            $message = (new \Swift_Message())
                ->setSubject($subject)
                ->setTo($to)
                ->setFrom($from)
                ->setBody($body)
                ->setContentType('text/html');

           $result = $this->mailerSrv->send($message);
           var_dump($result);
        }catch ( \Exception $e) {
            var_dump($e);
        }

    }
}
