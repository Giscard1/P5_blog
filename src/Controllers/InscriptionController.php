<?php


namespace App\Controllers;


use App\Repository\UserRepository;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class InscriptionController extends AbstractController
{

    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


        public function inscription(ServerRequestInterface $request, array $params)
        {

            $errors = [];
            $dataSubmitted = [];



            if ($request->getMethod() === 'POST'){
                //Todo Traitement des soumission formulaire
                $dataSubmitted = $request->getParsedBody();

                // Vérification prenom
                if (strlen($dataSubmitted['firstname']) === 0){
                    $errors['firstname']['required'] = true;
                }
                if (strlen($dataSubmitted['firstname']) > 32){
                    $errors['firstname']['sup'] = true;
                }
                if (strlen($dataSubmitted['firstname']) < 2){
                    $errors['firstname']['inf'] = true;
                }
                // Vérification nom

                if (strlen($dataSubmitted['lastname']) === 0){
                    $errors['lastname']['required'] = true;
                }
                // Vérification email

                if (strlen($dataSubmitted['email']) === 0){
                    $errors['email']['required'] = true;
                }
                // Vérification mot de passe

                if (strlen($dataSubmitted['password']) === 0){
                    $errors['password']['required'] = true;
                }

                $this->userRepository->registerNewUser($dataSubmitted);

                $message = 'Félicitation vous etes inscrit';
            };


            $response =  new Response(
                200,
                [],
                $this->renderHtml('inscription/inscription.html.twig',
                    ['errors' => $errors,
                        $message = 'message']
                )
            );

            return $response->getBody();
        }







}
