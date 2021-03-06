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
    /**
     * @var PostRepository
     */
    public $postRepository;


    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
        $this->postRepository = new PostRepository();
    }

    public function index(ServerRequestInterface $request, array $parameters)
    {

        if (!$this->isAdmin()) {
            $response =  new Response(
                200,
                [],
                $this->renderHtml('errors/_403.html.twig')
            );
            return $response->getBody();
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

    public function deleteUser(ServerRequestInterface $request, array $params){

        $this->userRepository->deleteUser((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);

        $this->successMessage = "Utilisateur supprimé avec succés";
    }

    public function deletePostAdmin(ServerRequestInterface $request, array $params){

        $this->postRepository->deletePostAdmin((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

    public function valid(ServerRequestInterface $request, array $params){

        $this->commentRepository->valid((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

    public function validUser(ServerRequestInterface $request, array $params){

        $this->userRepository->validUser((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

    public function adminUser(ServerRequestInterface $request, array $params){

        $this->userRepository->adminUser((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

    public function normalUser(ServerRequestInterface $request, array $params){

        $this->userRepository->normalUser((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

    public function upDatePost(ServerRequestInterface $request, array $params){

        $errors = [];
        $id = (int) $params['id'];
        $article = $this->postRepository->findById($id);
        if ($request->getMethod() === 'POST'){

            $dataSubmitted = $request->getParsedBody();
            if (strlen($dataSubmitted['title']) === 0){
                $errors['title']['required'] = true;
            }
            if (strlen($dataSubmitted['chapo']) === 0) {
                $errors['chapo']['required'] = true;
            }
            if (strlen($dataSubmitted['content']) === 0) {
                $errors['content']['required'] = true;
            }
            if (count($errors) === 0){
                $this->postRepository->update($dataSubmitted,(int)$this->getCurrentUser()['id'], $id);
                $this->redirect('/indexPosts');
            }
        };

        $response =  new Response(
            200,
            [],
            $this->renderHtml('Post/New/post.html.twig',
                ['errors' => $errors, 'article' => $article])
        );

        return $response->getBody();

    }

}
