<?php


namespace App\Controllers;


use App\Service\Mailer;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class DefaultController extends AbstractController
{
    protected Mailer $mailer;

    public function __construct()
    {
        $this->mailer = new Mailer();
    }

    public function homepage(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'POST')
        {
            $dataSubmitted = $request->getParsedBody();
            var_dump($dataSubmitted);

            try {
                $this->mailer->send(
                    'test',
                    'giscard.dsj@gmail.com',
                    'toto@gmail.fr',
                    $this->renderHtml('mails/hello.html.twig', ['name' => 'titi'])

                );
            } catch (\Exception $e){
                var_dump($e);
            }



                /*
                 * try {

               $result = mail(
                    'giscarddesousajunior@hotmail.fr',
                    'un sujet',
                    $dataSubmitted['firstname'],
                    "MIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n"
                );
               var_dump($result);
            } catch (\Exception $e) {
                var_dump($e);
                exit;
            }
                 */
        };
       // var_dump($_SESSION);
        $response =  new Response(
            200,
            [],
            $this->renderHtml('core/homepage.html.twig')
        );

        return $response->getBody();
    }

}
