<?php


namespace App\Controllers;


use App\Repository\UserRepository;
use GuzzleHttp\Psr7\Response;

class InscriptionController extends AbstractController
{

    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function inscription()
    {
        $response =  new Response(
            200,
            [],
            $this->renderHtml('inscription/inscription.html.twig')
        );

        return $response->getBody();
    }

}
