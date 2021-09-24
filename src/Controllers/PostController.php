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

    public function new_post(ServerRequestInterface $request,$id_User)
    {
        $errors = [];
        $dataSubmitted = [];
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
            //var_dump($dataSubmitted);
            //$this->postRepository->createNewPost($dataSubmitted,$id_user);
            var_dump($dataSubmitted);
            $this->postRepository->createNewPost($dataSubmitted,(int) $this->getCurrentUser()['id']);
        };


        $response =  new Response(
            200,
            [],
            $this->renderHtml('Post/New/post.html.twig',
                ['errors' => $errors])
        );

        return $response->getBody();
    }

    public function index(ServerRequestInterface $request){

        //$this->postRepository->findAll();
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

            $this->commentRepository->submitComment($dataSubmitted,(int)$parameters['id'], (int) $this->getCurrentUser()['id']);

            //var_dump($dataSubmitted);
        };

        $response =  new Response(
            200,
            [],
            $this->renderHtml('Post/TheOne/post.html.twig',
                [
                    'article' => $this->postRepository->findOneById((int)$parameters['id']),
                    'comments' => $this->commentRepository->findByArticleIdValid((int)$parameters['id'])
                ])
        );

        /*
         *   var_dump($this->postRepository->findOneById((int)$parameters['id']));
        exit;
         */
        //var_dump($this->commentRepository->findAll());

        return $response->getBody();
    }

    public function goToPost(ServerRequestInterface $request, array $params){
        $this->postRepository->findById((int) $params['id']);
        $this->redirect($request->getServerParams()['HTTP_REFERER']);
    }

}
