<?php


namespace App\Controllers;


use GuzzleHttp\Psr7\Response;

class DefaultController extends AbstractController
{

    public function homepage()
    {
        $response =  new Response(
            200,
            [],
            $this->renderHtml('core/homepage.html.twig')
        );

        return $response->getBody();
    }

}
