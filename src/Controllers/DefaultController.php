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
            //var_dump($dataSubmitted);
            try {
                $this->mailer->send(
                    'Blog P5',
                    'giscard.dsj@gmail.com',
                    'giscard.dsj@gmail.com',
                    $this->renderHtml('mails/hello.html.twig', $dataSubmitted)
                );
            } catch (\Exception $e){
                echo $e;}
        };
        $response =  new Response(
            200,
            [],
            $this->renderHtml('core/homepage.html.twig')
        );

        return $response->getBody();
    }

}
