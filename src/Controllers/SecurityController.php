<?php


namespace App\Controllers;


use App\Repository\UserRepository;
use App\Service\loginService\validators;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class SecurityController extends AbstractController
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login(ServerRequestInterface $request)
    {
        $errors = [];

        if ($request->getMethod() === 'POST') {
            $dataSubmitted = $request->getParsedBody();
            //TODO 1. Vérification des champs obligatoires
            /*if (strlen(trim($dataSubmitted['email'])) === 0 || strlen(trim($dataSubmitted['password'])) === 0) {
                $errors[] = 'Tous les champs sont requis';
            }
            */
            if (!validators::isNotBlank($dataSubmitted['email']) || !validators::isNotBlank($dataSubmitted['password'])) {

                $errors[] = 'Tous les champs sont requis';
            } else {
                //Todo 2. Récupération de l'email de l'utilisateur en bdd
                $user = $this->userRepository->findByEmail($dataSubmitted['email']);
                //var_dump($user);
                if ($user) {
                    //Todo 3. Coparaison des mot de passe soumises et en BDD
                    if ($dataSubmitted['password'] = $user['password']){
                        $_SESSION['user'] = $user;

                        $this->redirect('/homepage');
                    } else {
                        $errors[] = 'Identifiant';
                    }
                } else {
                    $errors[] = 'Identifant invalides';
                }
            }

        }
        $response =  new Response(
            200,
            [],
            $this->renderHtml('security/login.html.twig',
                [
                    'errors' => $errors
                ])
        );

        return $response->getBody();


    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/homepage');
    }

}
