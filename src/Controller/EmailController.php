<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email")
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(\Swift_Mailer $mailer)
    {
        $mail = new \Swift_Message();
        $mail->setSubject('Envoie de mail depuis SymfonyPerf');
        $mail->setFrom('php.symfony77@gmail.com');
        $mail->setTo('futurdev@protonmail.com');
        $mail->setBody(
            $this->renderView('email/model-mail.html.twig'),
            'text/html'
        );

        //envoie du mail
        $mailer->send($mail);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController'
        ]);
    }
}
