<?php


namespace App\Controllers;


use GuzzleHttp\Psr7\Response;

class ErrorController extends AbstractController
{

    public function errorOccured($codeError)
    {
        $response =  new Response(
            200,
            [],
            $this->renderHtml('errors/_'.$codeError.'.html.twig')
        );

        return $response->getBody();
    }

}
