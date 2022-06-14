<?php

declare(strict_types=1);

namespace App\Service\Email;

use User\Entity\User;
use Laminas\Mail\{Message,Transport\TransportInterface};

class UserNotificationService
{
    private Message $mail;

    public function __construct(
        private readonly TransportInterface $transport,
        private readonly array $config
    ){
        $this->mail = new Message();
        $this->mail->setFrom($this->config['fromAddress'], $this->config['fromName']);
    }

    public function sendAccountCreatedEmail(string $toAddress, string $toName, string $baseUrl)
    {
        $body =<<<EOF
Your account has been created with the username: %s.
You can login here: %s.
Your awesome support team.
EOF;
        $this->mail
            ->setBody(sprintf($body, $baseUrl))
            ->addTo($toAddress, $toName)
            ->setSubject("Your password has been created");

        $this->transport->send($this->mail);
    }

    public function sendResetPasswordEmail(User $user, string $resetPasswordUrl)
    {
        $body =<<<EOF
We got a request to change the password for the account with the email address: %s.
If you don't want to reset your password, you can ignore this email.
Open %s to reset your password.
EOF;

        $this->mail
            ->setBody(sprintf($body, $user->emailAddress, $resetPasswordUrl))
            ->addTo($user->emailAddress, $user->fullName)
            ->setSubject("Reset your password");

        $this->transport->send($this->mail);
    }

    public function sendResetPasswordConfirmationEmail(string $toAddress, string $toName, string $baseUrl)
    {
        $body =<<<EOF
Your password has now been reset.
You can login here: %s
Your awesome support team.
EOF;

        $this->mail
            ->setBody(sprintf($body, $baseUrl))
            ->addTo($toAddress, $toName)
            ->setSubject("Your password has been reset");

        $this->transport->send($this->mail);
    }

}