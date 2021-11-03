<?php

namespace App\Controllers;

use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class PostController extends AbstractController
{

    protected PostRepository $postRepository;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
        $this->commentRepository = new CommentRepository();
    }

    public function new_post(ServerRequestInterface $request, array $params)
    {
        if (!$this->isAdmin()) {
            $response =  new Response(
                200,
                [],
                $this->renderHtml('errors/_403.html.twig')
            );
            return $response->getBody();
        }
        $errors = [];
        $dataSubmitted = [];
        if ($request->getMethod() === 'POST'){
            $dataSubmitted = $request->getParsedBody();

            // Vérification title
            if (strlen($dataSubmitted['title']) === 0) {
                $errors['title']['required'] = true;
            }
            if (strlen($dataSubmitted['title']) > 32) {
                $errors['title']['sup'] = true;
            }
            if (strlen($dataSubmitted['title']) < 2){
                $errors['title']['inf'] = true;
            }
            // Vérification chapo
            if (strlen($dataSubmitted['chapo']) === 0) {
                $errors['chapo']['required'] = true;
            }
            if (strlen($dataSubmitted['chapo']) > 32) {
                $errors['chapo']['sup'] = true;
            }
            if (strlen($dataSubmitted['chapo']) < 2){
                $errors['chapo']['inf'] = true;
            }
            // Vérification content
            if (strlen($dataSubmitted['content']) === 0) {
                $errors['content']['required'] = true;
            }
            if (strlen($dataSubmitted['content']) < 2){
                $errors['content']['inf'] = true;
            }
            if (count($errors) === 0){
                $this->postRepository->createNewPost($dataSubmitted,(int) $this->getCurrentUser()['id']);
                $this->redirect('/homepage');
            }
        };
            $response = new Response(
                200,
                [],
                $this->renderHtml('Post/New/post.html.twig',
                    ['errors' => $errors])
            );
            return $response->getBody();
    }

    public function index(ServerRequestInterface $request){

        $response =  new Response(
            200,
            [],
            $this->renderHtml('Post/Index/posts.html.twig',
                [
                        'articles' => $this->postRepository->findAll()
                ])
        );
        return $response->getBody();
    }

    public function thePost(ServerRequestInterface $request, array $parameters){

        $errors = [];
        $dataSubmitted = [];

        if ($request->getMethod() === 'POST'){
            //Todo Traitement des soumission formulaire
            $dataSubmitted = $request->getParsedBody();

            if (strlen($dataSubmitted['comment']) === 0){
                $errors['comment']['required'] = true;
            }
            if (count($errors) === 0){
                $this->commentRepository->submitComment($dataSubmitted,(int)$parameters['id'], (int) $this->getCurrentUser()['id']);
            }
        };
        $response =  new Response(
            200,
            [],
            $this->renderHtml('Post/TheOne/post.html.twig',
                [
                    'article' => $this->postRepository->findOneById((int)$parameters['id']),
                    'comments' => $this->commentRepository->findByArticleIdValid((int)$parameters['id']),
                    'errors' => $errors
                ])
        );
        return $response->getBody();
    }
}
