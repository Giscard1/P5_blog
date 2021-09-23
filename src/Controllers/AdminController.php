<?php


namespace App\Controllers;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Test;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;


class AdminController extends AbstractController
{
    protected CommentRepository $commentRepository;
    /**
     * @var UserRepository
     */
    public $userRepository;


    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
        $this->postRepository = new PostRepository();
    }

    public function index(ServerRequestInterface $request, array $parameters)
    {
        $userId = null;

        if (!$this->isAdmin()) {
            $response =  new Response(
                200,
                [],
                $this->renderHtml('errors/_403.html.twig')
            );
            return $response->getBody();
        }

        if (isset($_POST['btc-addToAdmin'])){
            $this->userRepository->turnToAdmin($this->getCurrentUser()['id']);
        } elseif (isset($_POST['btc-addToValid'])){
            //TODO dev requete valider
            $this->userRepository->turnToValid();
        } elseif (isset($_POST['btn-deleteUser'])){
            //
            if (isset($_GET['id']) AND !empty($_GET['id'])){
                //
                $userId = $_GET['id'];
                $this->userRepository->deleteUser($userId);
            }
        }
        elseif (isset($_POST['validateComment'])){
            //TODO DEV req pour valider com
            $this->commentRepository->validateComment();
        }elseif (isset($_POST['deleteComment'])){
            //Todo dev req delete com
            $this->commentRepository->deleteCom();
        }


        $response =  new Response(
            200,
            [],
            $this->renderHtml(
                'Admin/index.html.twig',
                [
                    'comments' => $this->commentRepository->findAll(),
                    'users' => $this->userRepository->findAll(),
                    'articles' => $this->postRepository->findAll()
                ])
        );

        return $response->getBody();

    }

    public function deleteComment(ServerRequestInterface $request, array $params){

        $this->commentRepository->delete((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

    public function valid(ServerRequestInterface $request, array $params){

        $this->commentRepository->valid((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

}
