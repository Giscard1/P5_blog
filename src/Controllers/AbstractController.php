<?php

namespace App\Controllers;

abstract class  AbstractController

{
    use TwigTrait;

    public function redirect($url){
        header('location: '.$url);
    }

    protected function isAdmin(){

        return array_key_exists('user', $_SESSION) && $_SESSION['user']['admin'] === '1';
    }

    protected function getCurrentUser(){
        if (array_key_exists('user', $_SESSION)){
            return $_SESSION['user'];
        }
    }
}
